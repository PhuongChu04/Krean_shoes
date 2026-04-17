<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;

class AdminOrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with(['items.variant.product', 'payments', 'user'])
            ->latest();

        // Search filter
        $search = $request->query('search');
        $status = strtolower(trim($request->query('status', '')));
        $paymentStatus = strtolower(trim($request->query('payment_status', '')));
        $date = $request->query('date');
        $month = $request->query('month');
        $year = $request->query('year');
        $period = $request->query('period');

        // Apply combined search filter for order code, customer name, and phone
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('order_code', 'like', '%' . $search . '%')
                  ->orWhere('receiver_name', 'like', '%' . $search . '%')
                  ->orWhere('receiver_phone', 'like', '%' . $search . '%');
            });
        }

        if (in_array($status, ['pending', 'confirmed', 'processing', 'shipped', 'delivered', 'cancelled', 'returned'])) {
            $query->whereRaw('LOWER(TRIM(status)) = ?', [$status]);
        }

        if (in_array($paymentStatus, ['pending', 'paid'])) {
            $query->whereRaw('LOWER(TRIM(payment_status)) = ?', [$paymentStatus]);
        }

        if ($date) {
            $query->whereDate('created_at', $date);
        } elseif ($month) {
            $parts = explode('-', $month);
            if (count($parts) === 2) {
                [$yearValue, $monthValue] = $parts;
                $query->whereYear('created_at', $yearValue)
                    ->whereMonth('created_at', $monthValue);
            }
        } elseif ($year) {
            $query->whereYear('created_at', $year);
        } elseif ($period === 'last_month') {
            $query->whereBetween('created_at', [now()->subMonth()->startOfMonth(), now()->subMonth()->endOfMonth()]);
        } elseif ($period === 'this_month') {
            $query->whereYear('created_at', now()->year)
                ->whereMonth('created_at', now()->month);
        }

        $orders = $query->paginate(15)->withQueryString();
        $stats = Order::selectRaw("
        COUNT(*) AS total,
        SUM(CASE WHEN LOWER(TRIM(status)) = 'pending'    THEN 1 ELSE 0 END) AS pending,
        SUM(CASE WHEN LOWER(TRIM(status)) = 'processing' THEN 1 ELSE 0 END) AS processing,
        SUM(CASE WHEN LOWER(TRIM(status)) = 'shipped'    THEN 1 ELSE 0 END) AS shipped,
        SUM(CASE WHEN LOWER(TRIM(status)) = 'delivered'  THEN 1 ELSE 0 END) AS delivered,
        SUM(CASE WHEN LOWER(TRIM(status)) IN ('cancelled', 'canceled') THEN 1 ELSE 0 END) AS cancelled,
        SUM(CASE WHEN LOWER(TRIM(status)) = 'returned'   THEN 1 ELSE 0 END) AS returned,
        
        SUM(CASE WHEN LOWER(TRIM(payment_status)) = 'pending' THEN 1 ELSE 0 END) AS pending_payment,
        SUM(CASE WHEN LOWER(TRIM(payment_status)) = 'paid'    THEN 1 ELSE 0 END) AS paid
    ")->first()->toArray();
        return view('admin.order.index', compact('orders','stats'));
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
            'user.userProfile',

            // (Tùy chọn) Nếu bạn có bảng lịch sử trạng thái đơn hàng
            // $order->load('statusHistories');
        ]);

        // (Tùy chọn) Tính toán thêm nếu cần (ví dụ: tổng số lượng sản phẩm)
        $order->total_items = $order->items->sum('quantity');
        // Truyền biến $order và các biến phụ (nếu cần) sang view
        return view('admin.order.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
{
    $statuses = [
        'pending',
        'confirmed',
        'processing',
        'shipped',
        'delivered'
    ];

    $request->validate([
        'status' => 'required|in:pending,confirmed,processing,shipped,delivered,cancelled,returned',
    ]);

    $oldStatus = $order->status;
    $newStatus = $request->status;

    // ❗ Không cho cập nhật lùi
    if (in_array($oldStatus, $statuses) && in_array($newStatus, $statuses)) {
        $oldIndex = array_search($oldStatus, $statuses);
        $newIndex = array_search($newStatus, $statuses);

        if ($newIndex < $oldIndex) {
            return back()->with('error', 'Không thể quay lại trạng thái trước!');
        }
    }

    $order->status = $newStatus;

    // Xử lý COD
    if ($newStatus === 'delivered' && $order->payment_method === 'cod') {
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

    return back()->with('success', "Đã cập nhật từ {$oldStatus} → {$newStatus}");
}

public function updateReceiver(Request $request, $id)
{
    $order = Order::findOrFail($id);

    // Chỉ cho phép sửa khi status = 'pending'
    if ($order->status !== 'pending') {
        return back()->with('error', 'Chỉ có thể sửa thông tin khi đơn hàng ở trạng thái "Chờ xác nhận"!');
    }

    $request->validate([
        'receiver_name' => 'required|string|max:255',
        'receiver_phone' => 'required|string|max:20',
        'receiver_address' => 'required|string',
        'receiver_ward' => 'required|string|max:255',
        'receiver_district' => 'required|string|max:255',
        'receiver_province' => 'required|string|max:255',
    ], [
        'receiver_name.required' => 'Tên người nhận bắt buộc',
        'receiver_phone.required' => 'Số điện thoại bắt buộc',
        'receiver_address.required' => 'Địa chỉ bắt buộc',
        'receiver_ward.required' => 'Phường/Xã bắt buộc',
        'receiver_district.required' => 'Quận/Huyện bắt buộc',
        'receiver_province.required' => 'Tỉnh/Thành phố bắt buộc',
    ]);

    $order->update($request->only([
        'receiver_name',
        'receiver_phone',
        'receiver_address',
        'receiver_ward',
        'receiver_district',
        'receiver_province',
    ]));

    return back()->with('success', 'Đã cập nhật thông tin nhận hàng!');
}
/**
     * Dashboard thống kê đơn hàng (dùng cho view có các card)
     */
    // public function dashboard()
    // {
    //     // Cách 1: Dùng query đếm trực tiếp (hiệu suất tốt cho dashboard)
    //     $stats = [
    //         'pending'         => Order::where('status', 'pending')->count(),
    //         'processing'      => Order::where('status', 'processing')->count(),
    //         'shipped'         => Order::where('status', 'shipped')->count(),
    //         'delivered'       => Order::where('status', 'delivered')->count(),
    //         'cancelled'       => Order::where('status', 'cancelled')->count(),

    //         // Theo payment_status
    //         'pending_payment' => Order::where('payment_status', 'pending')->count(),
    //         'paid'            => Order::where('payment_status', 'paid')->count(),

    //         // Tổng đơn
    //         'total'           => Order::count(),
    //     ];

    //     // Cách 2 (nếu muốn tối ưu hơn nữa - chỉ 1 query)
    //     // $statsRaw = Order::selectRaw("
    //     //     SUM(CASE WHEN status = 'pending' THEN 1 ELSE 0 END) as pending,
    //     //     SUM(CASE WHEN status = 'processing' THEN 1 ELSE 0 END) as processing,
    //     //     SUM(CASE WHEN status = 'shipped' THEN 1 ELSE 0 END) as shipped,
    //     //     SUM(CASE WHEN status = 'delivered' THEN 1 ELSE 0 END) as delivered,
    //     //     SUM(CASE WHEN status = 'cancelled' THEN 1 ELSE 0 END) as cancelled,
    //     //     SUM(CASE WHEN payment_status = 'pending' THEN 1 ELSE 0 END) as pending_payment,
    //     //     SUM(CASE WHEN payment_status = 'paid' THEN 1 ELSE 0 END) as paid,
    //     //     COUNT(*) as total
    //     // ")->first();

    //     // $stats = $statsRaw->toArray();

    //     return view('admin.dashboard.orders', compact('stats'));
    //     // hoặc 'admin.order.dashboard', 'admin.orders.stats' tùy cấu trúc view của bạn
    // }
//    public function dashboard()
// {
//     // Cách tối ưu: 1 query duy nhất + case-insensitive
//     $stats = Order::selectRaw("
//         COUNT(*) AS total,
//         SUM(CASE WHEN LOWER(TRIM(status)) = 'pending'    THEN 1 ELSE 0 END) AS pending,
//         SUM(CASE WHEN LOWER(TRIM(status)) = 'processing' THEN 1 ELSE 0 END) AS processing,
//         SUM(CASE WHEN LOWER(TRIM(status)) = 'shipped'    THEN 1 ELSE 0 END) AS shipped,
//         SUM(CASE WHEN LOWER(TRIM(status)) = 'delivered'  THEN 1 ELSE 0 END) AS delivered,
//         SUM(CASE WHEN LOWER(TRIM(status)) IN ('cancelled', 'canceled') THEN 1 ELSE 0 END) AS cancelled,
        
//         SUM(CASE WHEN LOWER(TRIM(payment_status)) = 'pending' THEN 1 ELSE 0 END) AS pending_payment,
//         SUM(CASE WHEN LOWER(TRIM(payment_status)) = 'paid'    THEN 1 ELSE 0 END) AS paid
//     ")->first()->toArray();

//     // Debug nhanh (bật khi test, sau đó comment lại)
//     // dd($stats);

//     // Nếu bạn muốn thêm các status khác mà hệ thống đang dùng thật
//     // $realStatuses = Order::distinct('status')->pluck('status');
//     // $realPayment = Order::distinct('payment_status')->pluck('payment_status');
//     // dd(compact('stats', 'realStatuses', 'realPayment'));

//     return view('admin.order.index', compact('stats'));
// }
}