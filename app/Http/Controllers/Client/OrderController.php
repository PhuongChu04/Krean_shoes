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

    return view('client.orders.show', compact('order', 'canReview'));
}
}