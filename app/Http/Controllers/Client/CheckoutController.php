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

class CheckoutController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $cart = $user->cart;

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
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:500',
            'payment_method' => 'required|in:cod,bank_transfer',
            'note' => 'nullable|string|max:1000',
        ]);

        $user = Auth::user();
        $cart = $user->cart;

        if (!$cart || $cart->items->isEmpty()) {
            return back()->with('error', 'Giỏ hàng trống!');
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
            return back()->with('error', 'Không có sản phẩm nào để thanh toán!');
        }

        DB::beginTransaction();
        try {
            // Tính tổng tiền
            $subtotal = $items->sum(function ($item) {
                return $item->quantity * $item->productVariant->price;
            });
            $shipping = 30000;
            $total = $subtotal + $shipping;

            // Tạo đơn hàng
            $order = Order::create([
                'user_id' => $user->id,
                'order_code' => 'ORD-' . time() . '-' . $user->id,
                'subtotal' => $subtotal,
                'shipping_fee' => $shipping,
                'total_amount' => $total,
                'status' => 'pending',
                'payment_method' => $request->payment_method,
                'payment_status' => 'unpaid',
                'receiver_name' => $request->name,
                'receiver_phone' => $request->phone,
                'receiver_address' => $request->address,
                'note' => $request->note,
            ]);

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

            // Tạo thanh toán
            Payment::create([
                'order_id' => $order->id,
                'payment_method' => $request->payment_method,
                'amount' => $total,
                'status' => 'pending',
            ]);

            // Xóa sản phẩm khỏi giỏ hàng
            if ($type === 'selected') {
                CartItem::whereIn('id', $selectedIds)->delete();
            } else {
                $cart->items()->delete();
            }

            DB::commit();

            return redirect()->route('client.homeClient')->with('success', 'Đặt hàng thành công! Mã đơn hàng: ' . $order->order_code);

        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Có lỗi xảy ra khi đặt hàng: ' . $e->getMessage());
        }
    }
}