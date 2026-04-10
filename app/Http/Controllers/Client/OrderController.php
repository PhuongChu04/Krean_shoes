<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        $statuses = [
            'all' => 'Tất cả',
            'pending' => 'Chờ xác nhận',
            'confirmed' => 'Đã xác nhận',
            'processing' => 'Đang xử lý',
            'shipped' => 'Đang giao',
            'delivered' => 'Đã giao',
            'cancelled' => 'Đã hủy',
            'returned' => 'Trả hàng',
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

    // Kiểm tra quyền sở hữu đơn hàng
    if ($order->user_id !== $user->id) {
        abort(403, 'Bạn không có quyền xem đơn hàng này');
    }

    // Load tất cả dữ liệu cần thiết một lần
    $order->load([
        'items.variant.product',
        'items.variant.color',
        'items.variant.size',
        'items.review',           // Load đánh giá nếu có
        'payments',
        'voucher',
        'user'
    ]);

    // Kiểm tra xem khách hàng có thể đánh giá đơn hàng này không
    $canReview = $order->status === 'delivered' && 
                 $order->items->every(function ($item) {
                     return !$item->review;   // Chưa có đánh giá cho item này
                 });

    return view('client.orders.show', compact('order', 'canReview'));
}
}
