<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Order;
use App\Models\Admin\Product;
use App\Models\User;           // nếu bạn dùng model User
use Carbon\Carbon;
use Illuminate\Http\Request;
class AdminController extends Controller
{
    public function pending()
{
    $pendingOrders = Order::with(['user', 'items.variant.product'])
        ->where('status', 'pending')
        ->latest()
        ->paginate(15);   // phân trang 15 đơn mỗi trang

    return view('admin.statistics.pending', compact('pendingOrders'));
}

public function instock()
{
    $inStockProducts = Product::with(['category', 'brand', 'variants'])
        ->whereHas('variants', function ($query) {
            $query->where('stock', '>', 0)
                  ->whereNull('deleted_at');
        })
        ->latest()
        ->paginate(15);   // 15 sản phẩm mỗi trang

    return view('admin.statistics.instock', compact('inStockProducts'));
}

    public function homeAdmin()
    {
        $now = Carbon::now();

        // ==================== THỐNG KÊ CHÍNH ====================

        // 1. Tổng đơn hàng
        $totalOrders = Order::count();

        // 2. Doanh thu hôm nay
        $todayRevenue = Order::whereDate('created_at', $now->toDateString())
                            ->where('payment_status', 'paid')
                            ->sum('total_amount');

        // 3. Doanh thu tháng này
        $monthRevenue = Order::whereYear('created_at', $now->year)
                            ->whereMonth('created_at', $now->month)
                            ->where('payment_status', 'paid')
                            ->sum('total_amount');

        // 4. Sản phẩm còn hàng (có ít nhất 1 variant còn stock)
        $inStockProducts = Product::whereHas('variants', function ($q) {
            $q->where('stock', '>', 0)->whereNull('deleted_at');
        })->count();

        // 5. Sản phẩm hết hàng
        $outOfStockProducts = Product::whereDoesntHave('variants', function ($q) {
            $q->where('stock', '>', 0)->whereNull('deleted_at');
        })->count();

        // 6. Đơn hàng đang chờ xử lý
        $pendingOrders = Order::where('status', 'pending')->count();

        // 7. Đơn hàng đã hoàn thành (delivered)
        $completedOrders = Order::where('status', 'delivered')->count();

        // 8. Tổng số khách hàng
        $totalCustomers = User::where('role', 'customer')->count();   // hoặc bỏ where nếu không có role

        // 9. Đơn hàng gần đây (10 đơn)
        $recentOrders = Order::with(['user'])
                            ->latest()
                            ->take(10)
                            ->get();

        // ==================== TĂNG TRƯỞNG ====================

        // Tăng trưởng đơn hàng so với tháng trước
        $lastMonthOrders = Order::whereBetween('created_at', [
            $now->copy()->subMonth()->startOfMonth(),
            $now->copy()->subMonth()->endOfMonth()
        ])->count();

        $orderGrowth = $lastMonthOrders > 0 
            ? round((($totalOrders - $lastMonthOrders) / $lastMonthOrders) * 100, 1) 
            : 0;

        // Tăng trưởng doanh thu tháng này so với tháng trước
        $lastMonthRevenue = Order::whereYear('created_at', $now->subMonth()->year)
                                ->whereMonth('created_at', $now->month)
                                ->where('payment_status', 'paid')
                                ->sum('total_amount');

        $revenueGrowth = $lastMonthRevenue > 0 
            ? round((($monthRevenue - $lastMonthRevenue) / $lastMonthRevenue) * 100, 1) 
            : 0;

        return view('admin.homeAdmin', compact(
            'totalOrders',
            'todayRevenue',
            'monthRevenue',
            'inStockProducts',
            'outOfStockProducts',
            'pendingOrders',
            'completedOrders',
            'totalCustomers',
            'recentOrders',
            'orderGrowth',
            'revenueGrowth'
        ));
    }
}
