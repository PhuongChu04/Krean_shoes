<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
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

    // ==================== THỐNG KÊ BIỂU ĐỒ ====================

    /**
     * Lấy dữ liệu doanh thu theo ngày trong 30 ngày gần nhất
     */
    public function getRevenueByDay(Request $request)
    {
        $days = (int) $request->get('days', 30);
        
        $data = Order::where('payment_status', 'paid')
                    ->where('created_at', '>=', Carbon::now()->subDays($days))
                    ->selectRaw('DATE(created_at) as date, COUNT(*) as orders, SUM(total_amount) as revenue')
                    ->groupByRaw('DATE(created_at)')
                    ->orderBy('date', 'asc')
                    ->get();

        $labels = [];
        $revenues = [];
        $orders = [];

        foreach ($data as $item) {
            $labels[] = Carbon::createFromFormat('Y-m-d', $item->date)->format('d/m');
            $revenues[] = (int) $item->revenue;
            $orders[] = (int) $item->orders;
        }

        return response()->json([
            'labels' => $labels,
            'revenue' => $revenues,
            'orders' => $orders
        ]);
    }

    /**
     * Lấy dữ liệu doanh thu theo tháng trong năm hiện tại
     */
    public function getRevenueByMonth(Request $request)
    {
        $year = (int) $request->get('year', now()->year);
        
        $data = Order::where('payment_status', 'paid')
                    ->whereYear('created_at', $year)
                    ->selectRaw('MONTH(created_at) as month, COUNT(*) as orders, SUM(total_amount) as revenue')
                    ->groupByRaw('MONTH(created_at)')
                    ->orderBy('month', 'asc')
                    ->get();

        $labels = [
            'Tháng 1', 'Tháng 2', 'Tháng 3', 'Tháng 4', 'Tháng 5', 'Tháng 6',
            'Tháng 7', 'Tháng 8', 'Tháng 9', 'Tháng 10', 'Tháng 11', 'Tháng 12'
        ];

        $revenues = array_fill(0, 12, 0);
        $orders = array_fill(0, 12, 0);

        foreach ($data as $item) {
            $month = (int) $item->month - 1;
            $revenues[$month] = (int) $item->revenue;
            $orders[$month] = (int) $item->orders;
        }

        return response()->json([
            'labels' => $labels,
            'revenue' => $revenues,
            'orders' => $orders,
            'year' => $year
        ]);
    }

    /**
     * Lấy dữ liệu doanh thu theo năm (5 năm gần nhất)
     */
    public function getRevenueByYear(Request $request)
    {
        $years = (int) $request->get('years', 5);
        $startYear = now()->year - $years + 1;
        
        $data = Order::where('payment_status', 'paid')
                    ->where('created_at', '>=', Carbon::createFromDate($startYear, 1, 1))
                    ->selectRaw('YEAR(created_at) as year, COUNT(*) as orders, SUM(total_amount) as revenue')
                    ->groupByRaw('YEAR(created_at)')
                    ->orderBy('year', 'asc')
                    ->get();

        $labels = [];
        $revenues = [];
        $orders = [];

        for ($i = 0; $i < $years; $i++) {
            $year = $startYear + $i;
            $labels[] = "Năm " . $year;
            
            $found = $data->where('year', $year)->first();
            $revenues[] = $found ? (int) $found->revenue : 0;
            $orders[] = $found ? (int) $found->orders : 0;
        }

        return response()->json([
            'labels' => $labels,
            'revenue' => $revenues,
            'orders' => $orders
        ]);
    }

    /**
     * Lấy dữ liệu trạng thái đơn hàng
     */
    public function getOrderStatusChart()
    {
        $statuses = Order::selectRaw('status, COUNT(*) as count')
                        ->groupBy('status')
                        ->get();

        $labels = [];
        $data = [];
        $colors = [
            'pending' => '#FFC107',
            'confirmed' => '#17A2B8',
            'processing' => '#007BFF',
            'shipped' => '#6F42C1',
            'delivered' => '#28A745',
            'cancelled' => '#DC3545',
            'returned' => '#FD7E14'
        ];

        foreach ($statuses as $status) {
            $labels[] = ucfirst($status->status);
            $data[] = (int) $status->count;
        }

        return response()->json([
            'labels' => $labels,
            'data' => $data,
            'colors' => array_values($colors)
        ]);
    }

    /**
     * Lấy dữ liệu phương thức thanh toán
     */
    public function getPaymentMethodChart()
    {
        $methods = Order::selectRaw('payment_method, COUNT(*) as count, SUM(total_amount) as revenue')
                       ->groupBy('payment_method')
                       ->get();

        $labels = [];
        $orders = [];
        $revenue = [];

        foreach ($methods as $method) {
            $labels[] = strtoupper($method->payment_method);
            $orders[] = (int) $method->count;
            $revenue[] = (int) $method->revenue;
        }

        return response()->json([
            'labels' => $labels,
            'orders' => $orders,
            'revenue' => $revenue
        ]);
    }

    /**
     * Lấy dữ liệu tổng quan thống kê
     */
    public function getStatisticsSummary(Request $request)
    {
        $period = $request->get('period', 'month'); // day, month, year
        $now = Carbon::now();

        $summary = [
            'total_orders' => 0,
            'total_revenue' => 0,
            'average_order_value' => 0,
            'pending_orders' => 0
        ];

        if ($period === 'day') {
            $summary['total_orders'] = Order::whereDate('created_at', $now->toDateString())->count();
            $summary['total_revenue'] = Order::whereDate('created_at', $now->toDateString())
                                           ->where('payment_status', 'paid')
                                           ->sum('total_amount');
            $summary['pending_orders'] = Order::whereDate('created_at', $now->toDateString())
                                             ->where('status', 'pending')
                                             ->count();
        } elseif ($period === 'month') {
            $summary['total_orders'] = Order::whereYear('created_at', $now->year)
                                          ->whereMonth('created_at', $now->month)
                                          ->count();
            $summary['total_revenue'] = Order::whereYear('created_at', $now->year)
                                           ->whereMonth('created_at', $now->month)
                                           ->where('payment_status', 'paid')
                                           ->sum('total_amount');
            $summary['pending_orders'] = Order::whereYear('created_at', $now->year)
                                             ->whereMonth('created_at', $now->month)
                                             ->where('status', 'pending')
                                             ->count();
        } else { // year
            $summary['total_orders'] = Order::whereYear('created_at', $now->year)->count();
            $summary['total_revenue'] = Order::whereYear('created_at', $now->year)
                                           ->where('payment_status', 'paid')
                                           ->sum('total_amount');
            $summary['pending_orders'] = Order::whereYear('created_at', $now->year)
                                             ->where('status', 'pending')
                                             ->count();
        }

        if ($summary['total_orders'] > 0) {
            $summary['average_order_value'] = round($summary['total_revenue'] / $summary['total_orders'], 0);
        }

        return response()->json($summary);
    }
}
