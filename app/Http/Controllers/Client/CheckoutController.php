<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CheckoutController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $cart = Cart::with(['items.productVariant.product', 'items.productVariant.color', 'items.productVariant.size'])
            ->where('user_id', $user->id)
            ->first();

        if (!$cart || $cart->items->isEmpty()) {
            return redirect()->route('cart.view')->with('error', 'Giỏ hàng trống!');
        }

        [$type, $selectedIds, $items] = $this->resolveCheckoutItems($request, $cart);

        if ($items->isEmpty()) {
            return redirect()->route('cart.view')->with('error', 'Không có sản phẩm nào để thanh toán!');
        }

        $subtotal = $this->calculateSubtotal($items);
        $shipping = 30000;
        $discount = 0;
        $total = $subtotal + $shipping - $discount;

        return view('client.checkout.checkout', compact('items', 'subtotal', 'shipping', 'discount', 'total', 'type', 'selectedIds'));
    }

    public function process(Request $request)
    {
        Log::info('=== START CHECKOUT ===');
        Log::info('Checkout POST data:', $request->all());

        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'city' => 'required|string|max:100',
            'district' => 'required|string|max:100',
            'ward' => 'required|string|max:100',
            'address' => 'required|string|max:500',
            'payment_method' => 'required|in:cod,bank,vnpay',
            'note' => 'nullable|string|max:1000',
            'voucher_code' => 'nullable|string|max:50',
        ]);

        $paymentMethod = $this->normalizePaymentMethod($request->payment_method);

        if ($paymentMethod === 'vnpay' && !$this->isVnpayConfigured()) {
            Log::warning('VNPay config is missing during checkout.', [
                'tmn_code_configured' => filled(config('services.vnpay.tmn_code')),
                'hash_secret_configured' => filled(config('services.vnpay.hash_secret')),
            ]);

            return back()
                ->withInput()
                ->with('error', 'VNPay chưa được cấu hình. Vui lòng thêm VNPAY_TMN_CODE và VNPAY_HASH_SECRET vào file .env.');
        }

        $user = Auth::user();
        $cart = Cart::with(['items.productVariant.product', 'items.productVariant.color', 'items.productVariant.size'])
            ->where('user_id', $user->id)
            ->first();

        if (!$cart || $cart->items->isEmpty()) {
            Log::warning('Cart is empty for user: ' . $user->id);
            return back()->with('error', 'Giỏ hàng trống!');
        }

        [$type, $selectedIds, $items] = $this->resolveCheckoutItems($request, $cart);

        if ($items->isEmpty()) {
            Log::warning('No items to checkout for user: ' . $user->id);
            return back()->with('error', 'Không có sản phẩm nào để thanh toán!');
        }

        foreach ($items as $item) {
            if (!$item->productVariant || !$item->productVariant->product) {
                return back()->with('error', 'Có sản phẩm không còn tồn tại, vui lòng kiểm tra lại giỏ hàng.');
            }

            if ((int) $item->productVariant->stock < (int) $item->quantity) {
                Log::warning('Out of stock for product: ' . $item->productVariant->product->name);
                return back()->with('error', 'Sản phẩm ' . $item->productVariant->product->name . ' không đủ tồn kho!');
            }
        }

        $cartItemIds = $items->pluck('id')->map(fn ($id) => (int) $id)->values()->all();

        DB::beginTransaction();

        try {
            $subtotal = $this->calculateSubtotal($items);
            $shipping = 30000;
            $discount = 0;
            $voucher = null;
            $total = $subtotal + $shipping - $discount;

            if ($request->filled('voucher_code')) {
                Log::info('Voucher feature is temporarily disabled. Code received: ' . $request->voucher_code);
            }

            $order = Order::create([
                'user_id' => $user->id,
                'user_name' => $request->name,
                'order_code' => $this->generateOrderCode(),
                'subtotal' => $subtotal,
                'discount_amount' => $discount,
                'discount_type' => $discount > 0 ? 'fixed' : null,
                'shipping_fee' => $shipping,
                'total_amount' => $total,
                'status' => 'pending',
                'payment_method' => $paymentMethod,
                'payment_status' => 'pending',
                'receiver_name' => $request->name,
                'receiver_phone' => $request->phone,
                'receiver_address' => $request->address,
                'receiver_ward' => $request->ward,
                'receiver_district' => $request->district,
                'receiver_province' => $request->city,
                'note' => $request->note,
                'voucher_id' => $voucher?->id,
            ]);

            foreach ($items as $item) {
                $variant = $item->productVariant;
                $product = $variant->product;
                $attributeLabel = $variant->attribute_name
                    ?: collect([$variant->color?->name, $variant->size?->name])->filter()->implode(' / ');

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_name' => $product->name,
                    'product_variant_sku' => $variant->sku,
                    'product_image' => $variant->image ?: $product->thumbnail,
                    'product_attribute' => $attributeLabel ?: 'Mặc định',
                    'product_variant_id' => $item->product_variant_id,
                    'quantity' => $item->quantity,
                    'price' => $variant->price,
                    'discount_amount' => 0,
                    'subtotal' => $item->quantity * $variant->price,
                ]);

                $variant->decrement('stock', $item->quantity);
            }

            Payment::create([
                'order_id' => $order->id,
                'payment_method' => $paymentMethod,
                'amount' => $total,
                'status' => $paymentMethod === 'cod' ? 'pending' : 'pending',
                'note' => $paymentMethod === 'vnpay'
                    ? 'Khởi tạo thanh toán online qua VNPay.'
                    : 'Đơn hàng thanh toán khi nhận hàng (COD).',
            ]);

            if ($paymentMethod === 'cod') {
                $this->clearCartItems($cartItemIds);
            }

            DB::commit();

            Log::info('Checkout successful for order: ' . $order->order_code . ' | Payment method: ' . $paymentMethod);

            if ($paymentMethod === 'vnpay') {
                session([
                    "checkout_cleanup.{$order->id}" => [
                        'cart_item_ids' => $cartItemIds,
                        'user_id' => $user->id,
                    ],
                ]);

                return redirect()->away($this->buildVnpayPaymentUrl($order, $request));
            }

            return redirect()
                ->route('client.orders.show', $order)
                ->with('success', 'Đặt hàng thành công! Mã đơn hàng: ' . $order->order_code);
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Checkout error: ' . $e->getMessage() . ' | ' . $e->getFile() . ':' . $e->getLine());
            Log::error('Stack trace: ' . $e->getTraceAsString());

            return back()->withInput()->with('error', 'Có lỗi xảy ra khi đặt hàng: ' . $e->getMessage());
        }
    }

    public function vnpayReturn(Request $request)
    {
        $orderCode = $request->get('vnp_TxnRef');
        $order = Order::with('payments')->where('order_code', $orderCode)->first();

        if (!$order) {
            return redirect()->route('client.orders.index')->with('error', 'Không tìm thấy đơn hàng cần xác nhận thanh toán.');
        }

        if ($order->payment_status === 'paid') {
            return redirect()->route('client.orders.show', $order)->with('success', 'Đơn hàng này đã được thanh toán trước đó.');
        }

        if (!$this->verifyVnpaySignature($request->query())) {
            Log::warning('VNPay invalid signature for order: ' . $orderCode, $request->query());

            DB::transaction(function () use ($order) {
                $this->markOrderPaymentFailed($order, 'Sai chữ ký bảo mật từ VNPay.');
            });

            return redirect()->route('client.orders.show', $order)->with('error', 'Xác thực phản hồi VNPay không hợp lệ.');
        }

        $responseCode = (string) $request->get('vnp_ResponseCode');
        $transactionStatus = (string) $request->get('vnp_TransactionStatus');
        $transactionId = $request->get('vnp_TransactionNo');

        if ($responseCode === '00' && $transactionStatus === '00') {
            DB::transaction(function () use ($order, $transactionId) {
                $payment = $order->payments()->latest()->first();

                if ($payment) {
                    $payment->update([
                        'payment_method' => 'vnpay',
                        'status' => 'paid',
                        'transaction_id' => $transactionId,
                        'paid_at' => now(),
                        'note' => 'Thanh toán VNPay thành công.',
                    ]);
                }

                $order->update([
                    'payment_method' => 'vnpay',
                    'payment_status' => 'paid',
                    'status' => 'pending',
                    'cancel_reason' => null,
                ]);
            });

            $this->cleanupVnpayPendingCart($order);

            return redirect()
                ->route('client.orders.show', $order)
                ->with('success', 'Thanh toán VNPay thành công cho đơn hàng ' . $order->order_code . '.');
        }

        $message = 'Thanh toán VNPay không thành công (mã phản hồi: ' . ($responseCode ?: 'N/A') . ').';

        DB::transaction(function () use ($order, $message, $transactionId) {
            $this->markOrderPaymentFailed($order, $message, $transactionId);
        });

        return redirect()->route('client.orders.show', $order)->with('error', $message);
    }

    private function resolveCheckoutItems(Request $request, Cart $cart): array
    {
        $type = $request->get('type', 'full');
        $selectedIds = collect($request->get('ids', []))
            ->map(fn ($id) => (int) $id)
            ->filter()
            ->values()
            ->all();

        $items = $type === 'selected' && !empty($selectedIds)
            ? $cart->items->whereIn('id', $selectedIds)
            : $cart->items;

        return [$type, $selectedIds, $items->values()];
    }

    private function calculateSubtotal($items): float
    {
        return (float) $items->sum(fn ($item) => $item->quantity * $item->productVariant->price);
    }

    private function normalizePaymentMethod(?string $paymentMethod): string
    {
        return $paymentMethod === 'bank' ? 'vnpay' : (string) $paymentMethod;
    }

    private function isVnpayConfigured(): bool
    {
        return filled(config('services.vnpay.tmn_code')) && filled(config('services.vnpay.hash_secret'));
    }

    private function clearCartItems(array $cartItemIds): void
    {
        if (!empty($cartItemIds)) {
            CartItem::whereIn('id', $cartItemIds)->delete();
        }
    }

    private function cleanupVnpayPendingCart(Order $order): void
    {
        $sessionKey = "checkout_cleanup.{$order->id}";
        $cleanup = session($sessionKey);

        if (is_array($cleanup) && !empty($cleanup['cart_item_ids'])) {
            $this->clearCartItems($cleanup['cart_item_ids']);
        }

        session()->forget($sessionKey);
    }

    private function buildVnpayPaymentUrl(Order $order, Request $request): string
    {
        $tmnCode = (string) config('services.vnpay.tmn_code');
        $hashSecret = (string) config('services.vnpay.hash_secret');
        $baseUrl = (string) config('services.vnpay.url', 'https://sandbox.vnpayment.vn/paymentv2/vpcpay.html');
        $returnUrl = $this->resolveVnpayReturnUrl();

        if ($tmnCode === '' || $hashSecret === '') {
            throw new \RuntimeException('VNPay chưa được cấu hình TMN code / hash secret.');
        }

        $vnpTimezone = (string) config('services.vnpay.timezone', 'Asia/Ho_Chi_Minh');
        $createdAt = now($vnpTimezone);
        $expiresAt = $createdAt->copy()->addMinutes((int) config('services.vnpay.expire_minutes', 15));
        $clientIp = $this->resolveClientIp($request);

        $inputData = [
            'vnp_Version' => (string) config('services.vnpay.version', '2.1.0'),
            'vnp_Command' => (string) config('services.vnpay.command', 'pay'),
            'vnp_TmnCode' => $tmnCode,
            'vnp_Amount' => (int) round((float) $order->total_amount * 100),
            'vnp_CreateDate' => $createdAt->format('YmdHis'),
            'vnp_CurrCode' => (string) config('services.vnpay.curr_code', 'VND'),
            'vnp_IpAddr' => $clientIp,
            'vnp_Locale' => (string) config('services.vnpay.locale', 'vn'),
            'vnp_OrderInfo' => 'Thanh toan don hang ' . $order->order_code,
            'vnp_OrderType' => 'other',
            'vnp_ReturnUrl' => $returnUrl,
            'vnp_TxnRef' => $order->order_code,
            'vnp_ExpireDate' => $expiresAt->format('YmdHis'),
        ];

        ksort($inputData);

        $query = '';
        $hashData = '';
        $index = 0;

        foreach ($inputData as $key => $value) {
            $encodedKey = urlencode((string) $key);
            $encodedValue = urlencode((string) $value);

            if ($index > 0) {
                $query .= '&';
                $hashData .= '&';
            }

            $query .= $encodedKey . '=' . $encodedValue;
            $hashData .= $encodedKey . '=' . $encodedValue;
            $index++;
        }

        $secureHash = hash_hmac('sha512', $hashData, $hashSecret);

        Log::info('VNPay payment URL built.', [
            'order_code' => $order->order_code,
            'tmn_code' => $tmnCode,
            'return_url' => $returnUrl,
            'client_ip' => $clientIp,
            'hash_data' => $hashData,
        ]);

        return $baseUrl
            . '?' . $query
            . '&vnp_SecureHashType=HmacSHA512'
            . '&vnp_SecureHash=' . $secureHash;
    }

    private function resolveVnpayReturnUrl(): string
    {
        $fallbackUrl = route('payment.vnpay.return');
        $configuredUrl = (string) config('services.vnpay.return_url');

        if ($configuredUrl === '' || !filter_var($configuredUrl, FILTER_VALIDATE_URL)) {
            return $fallbackUrl;
        }

        $configuredPath = trim((string) parse_url($configuredUrl, PHP_URL_PATH), '/');
        $expectedPath = trim((string) parse_url($fallbackUrl, PHP_URL_PATH), '/');

        return $configuredPath === $expectedPath ? $configuredUrl : $fallbackUrl;
    }

    private function resolveClientIp(Request $request): string
    {
        $ip = (string) $request->ip();

        if ($ip === '' || $ip === '::1' || $ip === '0:0:0:0:0:0:0:1') {
            return '127.0.0.1';
        }

        return $ip;
    }

    private function verifyVnpaySignature(array $data): bool
    {
        $secureHash = $data['vnp_SecureHash'] ?? '';

        unset($data['vnp_SecureHash'], $data['vnp_SecureHashType']);
        ksort($data);

        $hashData = [];
        foreach ($data as $key => $value) {
            if (str_starts_with($key, 'vnp_')) {
                $hashData[] = urlencode($key) . '=' . urlencode((string) $value);
            }
        }

        $calculatedHash = hash_hmac('sha512', implode('&', $hashData), (string) config('services.vnpay.hash_secret'));

        return $secureHash !== '' && hash_equals($calculatedHash, $secureHash);
    }

    private function markOrderPaymentFailed(Order $order, string $message, ?string $transactionId = null): void
    {
        $payment = $order->payments()->latest()->first();

        if ($payment) {
            $payment->update([
                'payment_method' => 'vnpay',
                'status' => 'failed',
                'transaction_id' => $transactionId,
                'note' => $message,
            ]);
        }

        $order->update([
            'payment_method' => 'vnpay',
            'payment_status' => 'failed',
            'status' => 'cancelled',
            'cancel_reason' => $message,
        ]);

        session()->forget("checkout_cleanup.{$order->id}");
    }

    private function generateOrderCode(): string
    {
        do {
            $code = 'ORD-' . now()->format('YmdHis') . '-' . random_int(100, 999);
        } while (Order::where('order_code', $code)->exists());

        return $code;
    }
}