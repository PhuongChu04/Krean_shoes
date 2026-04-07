@extends('admin.layouts.layout')

@section('content')
    <div class="container-fluid">

        <div class="row mb-4">
            <div class="col-12">
                <h4 class="fw-bold">Dashboard</h4>
                <p class="text-muted">Tổng quan cửa hàng - Nhấn vào thẻ để xem chi tiết</p>
            </div>
        </div>

        <div class="row g-3">

            <!-- 1. Tổng đơn hàng -->
            <div class="col-xl-2 col-lg-4 col-md-6">
                <a href="{{ route('admin.order.index') }}" class="text-decoration-none">
                    <div class="card h-100 border-0 shadow-sm hover-card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <p class="text-muted mb-1 small">Tổng đơn hàng</p>
                                    <h3 class="fw-bold mb-0">{{ number_format($totalOrders ?? 0) }}</h3>
                                </div>
                                <div class="avatar-md bg-soft-primary rounded-circle d-flex align-items-center justify-content-center">
                                    <iconify-icon icon="solar:cart-5-bold-duotone" class="fs-3 text-primary"></iconify-icon>
                                </div>
                            </div>
                            <div class="mt-3">
                                <span class="badge bg-{{ $orderGrowth >= 0 ? 'success' : 'danger' }}">
                                    <i class="bx {{ $orderGrowth >= 0 ? 'bx-up-arrow-alt' : 'bx-down-arrow-alt' }}"></i> 
                                    {{ $orderGrowth ?? 0 }}%
                                </span>
                                <small class="text-muted ms-1">tháng trước</small>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <!-- 2. Doanh thu hôm nay -->
            <div class="col-xl-2 col-lg-4 col-md-6">
                <a href="#" class="text-decoration-none">   {{-- Tạm thời, sau bạn sẽ tạo route revenue.today --}}
                    <div class="card h-100 border-0 shadow-sm hover-card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <p class="text-muted mb-1 small">Doanh thu hôm nay</p>
                                    <h3 class="fw-bold text-success mb-0">{{ number_format($todayRevenue ?? 0) }} ₫</h3>
                                </div>
                                <div class="avatar-md bg-soft-success rounded-circle d-flex align-items-center justify-content-center">
                                    <iconify-icon icon="solar:dollar-bold-duotone" class="fs-3 text-success"></iconify-icon>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <!-- 3. Doanh thu tháng này -->
            <div class="col-xl-2 col-lg-4 col-md-6">
                <a href="#" class="text-decoration-none">
                    <div class="card h-100 border-0 shadow-sm hover-card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <p class="text-muted mb-1 small">Doanh thu tháng này</p>
                                    <h3 class="fw-bold mb-0">{{ number_format($monthRevenue ?? 0) }} ₫</h3>
                                </div>
                                <div class="avatar-md bg-soft-info rounded-circle d-flex align-items-center justify-content-center">
                                    <iconify-icon icon="solar:chart-bold-duotone" class="fs-3 text-info"></iconify-icon>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <!-- 4. Đơn chờ xử lý -->
            <div class="col-xl-2 col-lg-4 col-md-6">
                <a href="{{ route('admin.orders.pending') }}?status=pending" class="text-decoration-none">
                    <div class="card h-100 border-0 shadow-sm hover-card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <p class="text-muted mb-1 small">Đơn chờ xử lý</p>
                                    <h3 class="fw-bold text-warning mb-0">{{ number_format($pendingOrders ?? 0) }}</h3>
                                </div>
                                <div class="avatar-md bg-soft-warning rounded-circle d-flex align-items-center justify-content-center">
                                    <iconify-icon icon="solar:clock-circle-bold-duotone" class="fs-3 text-warning"></iconify-icon>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <!-- 5. Sản phẩm còn hàng -->
            <div class="col-xl-2 col-lg-4 col-md-6">
                <a href="{{ route('admin.instock') }}" class="text-decoration-none">
                    <div class="card h-100 border-0 shadow-sm hover-card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <p class="text-muted mb-1 small">Sản phẩm còn hàng</p>
                                    <h3 class="fw-bold mb-0">{{ number_format($inStockProducts ?? 0) }}</h3>
                                </div>
                                <div class="avatar-md bg-soft-success rounded-circle d-flex align-items-center justify-content-center">
                                    <iconify-icon icon="solar:box-bold-duotone" class="fs-3 text-success"></iconify-icon>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <!-- 6. Tổng khách hàng -->
            <div class="col-xl-2 col-lg-4 col-md-6">
                <a href="#" class="text-decoration-none">   {{-- Sau này bạn tạo route admin.customers.index --}}
                    <div class="card h-100 border-0 shadow-sm hover-card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <p class="text-muted mb-1 small">Tổng khách hàng</p>
                                    <h3 class="fw-bold mb-0">{{ number_format($totalCustomers ?? 0) }}</h3>
                                </div>
                                <div class="avatar-md bg-soft-secondary rounded-circle d-flex align-items-center justify-content-center">
                                    <iconify-icon icon="solar:users-group-rounded-bold-duotone" class="fs-3 text-secondary"></iconify-icon>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

        </div>

        <!-- Đơn hàng gần đây -->
        <div class="row mt-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Đơn hàng gần đây</h5>
                        <a href="{{ route('admin.order.index') }}" class="btn btn-sm btn-primary">Xem tất cả</a>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Mã đơn</th>
                                    <th>Khách hàng</th>
                                    <th>Ngày đặt</th>
                                    <th>Tổng tiền</th>
                                    <th>Trạng thái</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentOrders ?? [] as $order)
                                    <tr>
                                        <td><strong>#{{ $order->order_code }}</strong></td>
                                        <td>{{ $order->user?->name ?? $order->receiver_name ?? 'Khách vãng lai' }}</td>
                                        <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                                        <td class="fw-semibold">{{ number_format($order->total_amount) }} ₫</td>
                                        <td>
                                            <span class="badge bg-{{ $order->status == 'delivered' ? 'success' : ($order->status == 'pending' ? 'warning' : 'primary') }}">
                                                {{ ucfirst($order->status) }}
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="5" class="text-center py-4">Chưa có đơn hàng nào gần đây</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <style>
        .hover-card {
            transition: all 0.3s ease;
        }
        .hover-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.1) !important;
        }
    </style>
@endsection