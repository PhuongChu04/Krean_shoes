<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        $statuses = [
            'all'       => 'Tất cả',
            'pending'   => 'Chờ xác nhận',
            'confirmed' => 'Đã xác nhận',
            'processing'=> 'Đang xử lý',
            'shipped'   => 'Đang giao',
            'delivered' => 'Đã giao',
            'cancelled' => 'Đã hủy',
            'returned'  => 'Trả hàng',
        ];

        $activeStatus = $request->get('status', 'all');

        $query = Order::with(['items.variant.product', 'payments', 'voucher'])
            ->where('user_id', $user->id);

        if ($activeStatus !== 'all' && array_key_exists($activeStatus, $statuses)) {
            $query->where('status', $activeStatus);
        }

        $orders = $query->latest()->paginate(10)->withQueryString();

        $statusCounts = Order::where('user_id', $user->id)
            ->selectRaw('status, count(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status')
            ->toArray();

        return view('client.orders.index', compact('orders', 'statuses', 'activeStatus', 'statusCounts'));
    }

    public function show(Order $order)
    {
        $user = Auth::user();

        if ($order->user_id !== $user->id) {
            abort(403);
        }

        $order->load([
            'items.review',
            'payments',
            'voucher'
        ]);

        foreach ($order->items as $item) {
            $variant = $item->variant()->withTrashed()->first();

            if ($variant) {
                $variant->load([
                    'images',
                    'color',
                    'size',
                    'product' => fn($q) => $q->withTrashed()
                ]);
            }

            $item->setRelation('variant', $variant);
        }

        // ... phần xử lý availability_status giữ nguyên

        $canReview = $order->status === 'delivered' && 
                     $order->items->every(fn($item) => !$item->review);

        // Kiểm tra có thể thanh toán lại không
        $canRetryPayment = $order->canRetryPayment();

        return view('client.orders.show', compact('order', 'canReview', 'canRetryPayment'));
    }

    /**
     * Xử lý thanh toán lại cho đơn hàng (chỉ VNPAY)
     * - Kiểm tra điều kiện: payment_status = pending, payment_method = vnpay, order status = pending
     * - Chỉ cho thanh toán lại 1 lần duy nhất (kiểm tra từ payment attempts)
     */
    public function retryPayment(Order $order, Request $request)
    {
        $user = Auth::user();

        // Kiểm tra quyền hạn
        if ($order->user_id !== $user->id) {
            return back()->with('error', 'Bạn không có quyền thực hiện hành động này.');
        }

        // Kiểm tra có thể thanh toán lại
        if (!$order->canRetryPayment()) {
            return back()->with('error', 'Đơn hàng này không thể thanh toán lại. Vui lòng kiểm tra lại trạng thái thanh toán hoặc phương thức thanh toán.');
        }

        // Kiểm tra cấu hình VNPay
        if (!$this->isVnpayConfigured()) {
            return back()->with('error', 'Hệ thống VNPay chưa được cấu hình đúng. Vui lòng liên hệ admin.');
        }

        try {
            DB::beginTransaction();

            // Tạo Payment record mới cho lần thanh toán lại
            Payment::create([
                'order_id' => $order->id,
                'payment_method' => 'vnpay',
                'amount' => $order->total_amount,
                'status' => 'pending',
                'note' => 'Lần thanh toán lại qua VNPay.',
            ]);

            DB::commit();

            Log::info('Payment retry initiated for order: ' . $order->order_code, [
                'user_id' => $user->id,
                'amount' => $order->total_amount,
            ]);

            // Redirect đến VNPay
            return redirect()->away($this->buildVnpayPaymentUrl($order, $request));
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Retry payment error for order: ' . $order->order_code . ' | ' . $e->getMessage());
            
            return back()->with('error', 'Có lỗi xảy ra khi chuẩn bị thanh toán lại. Vui lòng thử lại sau.');
        }
    }

    /**
     * Kiểm tra VNPay đã cấu hình chưa
     */
    private function isVnpayConfigured(): bool
    {
        return filled(config('services.vnpay.tmn_code')) && filled(config('services.vnpay.hash_secret'));
    }

    /**
     * Xây dựng URL thanh toán VNPay (copy logic từ CheckoutController)
     */
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
            'vnp_OrderInfo' => 'Thanh toan lai don hang ' . $order->order_code,
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

        Log::info('VNPay retry payment URL built.', [
            'order_code' => $order->order_code,
            'tmn_code' => $tmnCode,
            'client_ip' => $clientIp,
        ]);

        return $baseUrl
            . '?' . $query
            . '&vnp_SecureHashType=HmacSHA512'
            . '&vnp_SecureHash=' . $secureHash;
    }

    /**
     * Resolve VNPay return URL
     */
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

    /**
     * Resolve client IP
     */
    private function resolveClientIp(Request $request): string
    {
        $ip = (string) $request->ip();

        return $ip && $ip !== '127.0.0.1' && filter_var($ip, FILTER_VALIDATE_IP) ? $ip : '127.0.0.1';
    }
    public function cancel(Order $order)
{
    $user = Auth::user();

    // Kiểm tra đơn thuộc user
    if ($order->user_id !== $user->id) {
        abort(403);
    }

    // Chỉ cho hủy khi chưa đến trạng thái "shipped"
    $cancellableStatuses = ['pending', 'confirmed', 'processing'];

    if (!in_array($order->status, $cancellableStatuses)) {
        return back()->with('error', 'Không thể hủy đơn hàng ở trạng thái này!');
    }

    $order->update(['status' => 'cancelled']);

    return back()->with('success', 'Đã hủy đơn hàng thành công!');
}
}