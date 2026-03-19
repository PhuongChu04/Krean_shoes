<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Order;
use App\Models\Admin\Payment;
use Illuminate\Http\Request;

class AdminOrderController extends Controller
{
    public function index()
    {
        $orders = Order::with(['items.variant.product', 'payments', 'user'])
            ->latest()
            ->paginate(15);

        return view('admin.order.index', compact('orders'));
    }

    public function show(Order $order)
    {
        // Load tất cả quan hệ cần thiết để tránh N+1 query
        $order->load([
            // Chi tiết sản phẩm trong đơn (items)
            'items.variant.product',           // variant → product
            'items.variant.color',             // màu sắc
            'items.variant.size',              // kích thước

            // Thông tin thanh toán
            'payments',

            // Voucher nếu có
            'voucher',

            // Người dùng (nếu đơn thuộc user đăng ký)
            'user',
        ]);

        // (Tùy chọn) Nếu bạn có bảng lịch sử trạng thái đơn hàng
        // $order->load('statusHistories');

        // (Tùy chọn) Tính toán thêm nếu cần (ví dụ: tổng số lượng sản phẩm)
        $order->total_items = $order->items->sum('quantity');

        // Truyền biến $order và các biến phụ (nếu cần) sang view
        return view('admin.order.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,confirmed,processing,shipped,delivered,cancelled,returned',
        ]);

        $oldStatus = $order->status;
        $order->status = $request->status;

        // Xử lý COD khi giao thành công
        if ($request->status === 'delivered' && $order->payment_method === 'cod') {
            if (!$order->payments()->where('status', 'paid')->exists()) {
                Payment::create([
                    'order_id'       => $order->id,
                    'amount'         => $order->total_amount,
                    'payment_method' => 'cod',
                    'status'         => 'paid',
                    'paid_at'        => now(),
                    'note'           => 'Thanh toán COD khi giao hàng thành công',
                ]);
                $order->payment_status = 'paid';
            }
        }

        $order->save();

        // Có thể thêm log lịch sử trạng thái ở đây sau (nếu có bảng order_status_histories)

        return redirect()->back()->with('success', "Đã cập nhật trạng thái từ {$oldStatus} → {$order->status}");
    }
}