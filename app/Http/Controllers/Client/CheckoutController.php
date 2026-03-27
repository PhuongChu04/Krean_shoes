<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Admin\Cart;
use App\Models\Admin\CartItem;
use App\Models\Admin\Order;
use App\Models\Admin\OrderItem;
use App\Models\Admin\Payment;
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

        // Xử lý checkout theo loại
        $type = $request->get('type', 'full');
        $selectedIds = $request->get('ids', []);

        if ($type === 'selected' && !empty($selectedIds)) {
            $items = $cart->items->whereIn('id', $selectedIds);
        } else {
            $items = $cart->items;
        }

        if ($items->isEmpty()) {
            return redirect()->route('cart.view')->with('error', 'Không có sản phẩm nào để thanh toán!');
        }

        // Tính tổng tiền
        $subtotal = $items->sum(function ($item) {
            return $item->quantity * $item->productVariant->price;
        });

        $shipping = 30000; // Phí ship cố định
        $total = $subtotal + $shipping;

        return view('client.checkout.checkout', compact('items', 'subtotal', 'shipping', 'total', 'type', 'selectedIds'));
    }

    public function process(Request $request)
    {
        // Debug: luật lưu POST data
        Log::info('=== START CHECKOUT ===');
        Log::info('Checkout POST data:', $request->all());
        
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'city' => 'required|string|max:100',
            'district' => 'required|string|max:100',
            'ward' => 'required|string|max:100',
            'address' => 'required|string|max:500',
            'payment_method' => 'required|in:cod,bank',
            'note' => 'nullable|string|max:1000',
            'voucher_code' => 'nullable|string|max:50',
        ]);
        
        Log::info('✓ Validation passed');

        $user = Auth::user();
        Log::info('User ID: ' . $user->id);
        
        $cart = Cart::with(['items.productVariant.product', 'items.productVariant.color', 'items.productVariant.size'])
            ->where('user_id', $user->id)
            ->first();
        Log::info('Cart loaded. Cart ID: ' . ($cart ? $cart->id : 'NULL'));

        if (!$cart || $cart->items->isEmpty()) {
            Log::warning('Cart is empty for user: ' . $user->id);
            return back()->with('error', 'Giỏ hàng trống!');
        }
        
        Log::info('Cart has ' . $cart->items->count() . ' items');

        // Xử lý checkout theo loại
        $type = $request->get('type', 'full');
        $selectedIds = $request->get('ids', []);

        if ($type === 'selected' && !empty($selectedIds)) {
            $items = $cart->items->whereIn('id', $selectedIds);
        } else {
            $items = $cart->items;
        }

        if ($items->isEmpty()) {
            Log::warning('No items to checkout for user: ' . $user->id);
            return back()->with('error', 'Không có sản phẩm nào để thanh toán!');
        }

        // Kiểm tra tồn kho
        foreach ($items as $item) {
            if ($item->productVariant->stock < $item->quantity) {
                Log::warning('Out of stock for product: ' . $item->productVariant->product->name);
                return back()->with('error', 'Sản phẩm ' . $item->productVariant->product->name . ' không đủ tồn kho!');
            }
        }

        DB::beginTransaction();
        try {
            Log::info('Starting checkout transaction for user: ' . $user->id);
            
            // Tính tổng tiền
            $subtotal = $items->sum(function ($item) {
                return $item->quantity * $item->productVariant->price;
            });
            $shipping = 30000;
            $discount = 0;
            $voucher = null;

            // Kiểm tra voucher
            if ($request->voucher_code) {
                Log::info('Checking voucher code: ' . $request->voucher_code);
                
                // Tạm bỏ voucher feature - bảng vouchers chưa setup đúng
                // TODO: Fix voucher later
                Log::info('Voucher feature disabled temporarily');
                /*
                $voucher = Voucher::where('code', $request->voucher_code)
                    ->where('status', 'active')
                    ->where('start_date', '<=', now())
                    ->where('end_date', '>=', now())
                    ->where('quantity', '>', 0)
                    ->first();

                if (!$voucher) {
                    Log::warning('Invalid voucher code: ' . $request->voucher_code);
                    DB::rollback();
                    return back()->with('error', 'Mã voucher không hợp lệ hoặc đã hết hạn!');
                }

                // Tính discount
                if ($voucher->type === 'fixed') {
                    $discount = min($voucher->discount_amount, $subtotal);
                } elseif ($voucher->type === 'percent') {
                    $discount = $subtotal * ($voucher->discount_amount / 100);
                }
                */
                
                Log::info('Voucher applied. Discount: ' . $discount);
            }

            $total = $subtotal + $shipping - $discount;
            Log::info('Order totals - Subtotal: ' . $subtotal . ', Shipping: ' . $shipping . ', Discount: ' . $discount . ', Total: ' . $total);

            // Tạo đơn hàng
            $order = Order::create([
                'user_id' => $user->id,
                'order_code' => 'ORD-' . time() . '-' . $user->id,
                'subtotal' => $subtotal,
                'discount_amount' => $discount,
                'shipping_fee' => $shipping,
                'total_amount' => $total,
                'status' => 'pending',
                'payment_method' => $request->payment_method,
                'payment_status' => 'pending',
                'receiver_name' => $request->name,
                'receiver_phone' => $request->phone,
                'receiver_address' => $request->address,
                'receiver_ward' => $request->ward,
                'receiver_district' => $request->district,
                'receiver_province' => $request->city,
                'note' => $request->note,
                'voucher_id' => $voucher ? $voucher->id : null,
            ]);
            
            Log::info('Order created with ID: ' . $order->id . ', Code: ' . $order->order_code);

            // Tạo chi tiết đơn hàng
            foreach ($items as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_variant_id' => $item->product_variant_id,
                    'quantity' => $item->quantity,
                    'price' => $item->productVariant->price,
                    'subtotal' => $item->quantity * $item->productVariant->price,
                ]);

                // Giảm tồn kho
                $item->productVariant->decrement('stock', $item->quantity);
            }
            
            Log::info('Order items created and stock updated');

            // Giảm số lượng voucher
            if ($voucher) {
                $voucher->decrement('quantity');
                Log::info('Voucher quantity decremented');
            }

            // Tạo thanh toán
            Payment::create([
                'order_id' => $order->id,
                'payment_method' => $request->payment_method, // cod hoặc bank - match enum
                'amount' => $total,
                'status' => 'pending',
            ]);
            
            Log::info('Payment created with method: ' . $request->payment_method);
            
            Log::info('Payment record created');

            // Xóa sản phẩm khỏi giỏ hàng
            if ($type === 'selected') {
                CartItem::whereIn('id', $selectedIds)->delete();
            } else {
                $cart->items()->delete();
            }
            
            Log::info('Cart items deleted');

            DB::commit();
            
            Log::info('Checkout successful for order: ' . $order->order_code);

            return redirect()->route('client.homeClient')->with('success', 'Đặt hàng thành công! Mã đơn hàng: ' . $order->order_code);

        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Checkout error: ' . $e->getMessage() . ' | ' . $e->getFile() . ':' . $e->getLine());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            
            return back()->with('error', 'Có lỗi xảy ra khi đặt hàng: ' . $e->getMessage());
        }
    }
}