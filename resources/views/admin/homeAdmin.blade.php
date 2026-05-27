@extends('admin.layouts.layout')

@section('content')
    <div class="container-fluid">

        <div class="row mb-4">
            <div class="col-12">
                <h4 class="fw-bold">Dashboard</h4>
                <p class="text-muted">Tổng quan cửa hàng - Nhấn vào thẻ để xem chi tiết</p>
            </div>
        </div>

        <!-- Tab chuyển đổi giữa các loại thống kê -->
        <div class="row mb-3">
            <div class="col-12">
                <ul class="nav nav-tabs nav-fill" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="day-tab" data-bs-toggle="tab" data-bs-target="#day-content" type="button" role="tab" aria-controls="day-content" aria-selected="true">
                            <i class="bx bxs-calendar"></i> Theo Ngày
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="month-tab" data-bs-toggle="tab" data-bs-target="#month-content" type="button" role="tab" aria-controls="month-content" aria-selected="false">
                            <i class="bx bxs-calendar-alt"></i> Theo Tháng
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="year-tab" data-bs-toggle="tab" data-bs-target="#year-content" type="button" role="tab" aria-controls="year-content" aria-selected="false">
                            <i class="bx bxs-calendar-check"></i> Theo Năm
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="overview-tab" data-bs-toggle="tab" data-bs-target="#overview-content" type="button" role="tab" aria-controls="overview-content" aria-selected="false">
                            <i class="bx bxs-bar-chart-alt-2"></i> Tổng Quan
                        </button>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Nội dung Tab -->
        <div class="tab-content" id="tabContent">
            <!-- TAB: THEO NGÀY -->
            <div class="tab-pane fade show active" id="day-content" role="tabpanel" aria-labelledby="day-tab">
                <div class="row g-3">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h5 class="mb-0">Doanh Thu Theo Ngày (30 ngày gần nhất)</h5>
                                <select id="daySelect" class="form-select w-auto">
                                    <option value="7">7 ngày</option>
                                    <option value="15">15 ngày</option>
                                    <option value="30" selected>30 ngày</option>
                                    <option value="60">60 ngày</option>
                                    <option value="90">90 ngày</option>
                                </select>
                            </div>
                            <div class="card-body">
                                <canvas id="revenueByDayChart" style="max-height: 400px;"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- TAB: THEO THÁNG -->
            <div class="tab-pane fade" id="month-content" role="tabpanel" aria-labelledby="month-tab">
                <div class="row g-3">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h5 class="mb-0">Doanh Thu Theo Tháng</h5>
                                <select id="yearSelect" class="form-select w-auto">
                                    @php
                                        $currentYear = now()->year;
                                        for ($i = $currentYear; $i >= $currentYear - 5; $i--) {
                                            echo "<option value=\"$i\" " . ($i == $currentYear ? 'selected' : '') . ">$i</option>";
                                        }
                                    @endphp
                                </select>
                            </div>
                            <div class="card-body">
                                <canvas id="revenueByMonthChart" style="max-height: 400px;"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- TAB: THEO NĂM -->
            <div class="tab-pane fade" id="year-content" role="tabpanel" aria-labelledby="year-tab">
                <div class="row g-3">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0">Doanh Thu Theo Năm (5 năm gần nhất)</h5>
                            </div>
                            <div class="card-body">
                                <canvas id="revenueByYearChart" style="max-height: 400px;"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- TAB: TỔNG QUAN -->
            <div class="tab-pane fade" id="overview-content" role="tabpanel" aria-labelledby="overview-tab">
                <div class="row g-3">
                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0">Trạng Thái Đơn Hàng</h5>
                            </div>
                            <div class="card-body">
                                <canvas id="orderStatusChart" style="max-height: 400px;"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0">Phương Thức Thanh Toán</h5>
                            </div>
                            <div class="card-body">
                                <canvas id="paymentMethodChart" style="max-height: 400px;"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- KPI Cards -->
        <div class="row g-4 mt-6">

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
                <a href="#" class="text-decoration-none">
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

    <!-- Chart.js Library -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.js"></script>
    
    <script>
        // Màu sắc
        const colors = {
            primary: '#007BFF',
            success: '#28A745',
            danger: '#DC3545',
            warning: '#FFC107',
            info: '#17A2B8',
            secondary: '#6C757D'
        };

        let chartsMap = {};

        // ==================== BIỂU ĐỒ THEO NGÀY ====================
        function loadRevenueByDay(days = 30) {
            fetch(`{{ route('admin.statistics.revenue-by-day') }}?days=${days}`)
                .then(res => res.json())
                .then(data => {
                    if (chartsMap.revenueByDay) chartsMap.revenueByDay.destroy();
                    
                    const ctx = document.getElementById('revenueByDayChart').getContext('2d');
                    chartsMap.revenueByDay = new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels: data.labels,
                            datasets: [
                                {
                                    label: 'Doanh Thu (₫)',
                                    data: data.revenue,
                                    borderColor: colors.success,
                                    backgroundColor: 'rgba(40, 167, 69, 0.1)',
                                    borderWidth: 2,
                                    fill: true,
                                    tension: 0.4,
                                    yAxisID: 'y'
                                },
                                {
                                    label: 'Số Đơn',
                                    data: data.orders,
                                    borderColor: colors.primary,
                                    backgroundColor: 'rgba(0, 123, 255, 0.1)',
                                    borderWidth: 2,
                                    fill: true,
                                    tension: 0.4,
                                    yAxisID: 'y1'
                                }
                            ]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: true,
                            interaction: {
                                mode: 'index',
                                intersect: false,
                            },
                            plugins: {
                                legend: {
                                    position: 'top',
                                }
                            },
                            scales: {
                                y: {
                                    type: 'linear',
                                    display: true,
                                    position: 'left',
                                    title: {
                                        display: true,
                                        text: 'Doanh Thu (₫)'
                                    }
                                },
                                y1: {
                                    type: 'linear',
                                    display: true,
                                    position: 'right',
                                    title: {
                                        display: true,
                                        text: 'Số Đơn'
                                    },
                                    grid: {
                                        drawOnChartArea: false,
                                    }
                                }
                            }
                        }
                    });
                });
        }

        // ==================== BIỂU ĐỒ THEO THÁNG ====================
        function loadRevenueByMonth(year = new Date().getFullYear()) {
            fetch(`{{ route('admin.statistics.revenue-by-month') }}?year=${year}`)
                .then(res => res.json())
                .then(data => {
                    if (chartsMap.revenueByMonth) chartsMap.revenueByMonth.destroy();
                    
                    const ctx = document.getElementById('revenueByMonthChart').getContext('2d');
                    chartsMap.revenueByMonth = new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: data.labels,
                            datasets: [
                                {
                                    label: 'Doanh Thu (₫)',
                                    data: data.revenue,
                                    backgroundColor: 'rgba(40, 167, 69, 0.8)',
                                    borderColor: colors.success,
                                    borderWidth: 1,
                                    yAxisID: 'y'
                                },
                                {
                                    label: 'Số Đơn',
                                    data: data.orders,
                                    backgroundColor: 'rgba(0, 123, 255, 0.8)',
                                    borderColor: colors.primary,
                                    borderWidth: 1,
                                    yAxisID: 'y1'
                                }
                            ]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: true,
                            interaction: {
                                mode: 'index',
                                intersect: false,
                            },
                            plugins: {
                                legend: {
                                    position: 'top',
                                }
                            },
                            scales: {
                                y: {
                                    type: 'linear',
                                    display: true,
                                    position: 'left',
                                    title: {
                                        display: true,
                                        text: 'Doanh Thu (₫)'
                                    }
                                },
                                y1: {
                                    type: 'linear',
                                    display: true,
                                    position: 'right',
                                    title: {
                                        display: true,
                                        text: 'Số Đơn'
                                    },
                                    grid: {
                                        drawOnChartArea: false,
                                    }
                                }
                            }
                        }
                    });
                });
        }

        // ==================== BIỂU ĐỒ THEO NĂM ====================
        function loadRevenueByYear() {
            fetch('{{ route('admin.statistics.revenue-by-year') }}')
                .then(res => res.json())
                .then(data => {
                    if (chartsMap.revenueByYear) chartsMap.revenueByYear.destroy();
                    
                    const ctx = document.getElementById('revenueByYearChart').getContext('2d');
                    chartsMap.revenueByYear = new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: data.labels,
                            datasets: [
                                {
                                    label: 'Doanh Thu (₫)',
                                    data: data.revenue,
                                    backgroundColor: 'rgba(40, 167, 69, 0.8)',
                                    borderColor: colors.success,
                                    borderWidth: 1,
                                    yAxisID: 'y'
                                },
                                {
                                    label: 'Số Đơn',
                                    data: data.orders,
                                    backgroundColor: 'rgba(0, 123, 255, 0.8)',
                                    borderColor: colors.primary,
                                    borderWidth: 1,
                                    yAxisID: 'y1'
                                }
                            ]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: true,
                            interaction: {
                                mode: 'index',
                                intersect: false,
                            },
                            plugins: {
                                legend: {
                                    position: 'top',
                                }
                            },
                            scales: {
                                y: {
                                    type: 'linear',
                                    display: true,
                                    position: 'left',
                                    title: {
                                        display: true,
                                        text: 'Doanh Thu (₫)'
                                    }
                                },
                                y1: {
                                    type: 'linear',
                                    display: true,
                                    position: 'right',
                                    title: {
                                        display: true,
                                        text: 'Số Đơn'
                                    },
                                    grid: {
                                        drawOnChartArea: false,
                                    }
                                }
                            }
                        }
                    });
                });
        }

        // ==================== BIỂU ĐỒ TRẠNG THÁI ====================
        function loadOrderStatusChart() {
            fetch('{{ route('admin.statistics.order-status') }}')
                .then(res => res.json())
                .then(data => {
                    if (chartsMap.orderStatus) chartsMap.orderStatus.destroy();
                    
                    const ctx = document.getElementById('orderStatusChart').getContext('2d');
                    chartsMap.orderStatus = new Chart(ctx, {
                        type: 'doughnut',
                        data: {
                            labels: data.labels,
                            datasets: [{
                                data: data.data,
                                backgroundColor: [
                                    '#FFC107', '#17A2B8', '#007BFF', 
                                    '#6F42C1', '#28A745', '#DC3545', '#FD7E14'
                                ],
                                borderWidth: 2,
                                borderColor: '#fff'
                            }]
                        },
                        options: {
                            responsive: true,
                            plugins: {
                                legend: {
                                    position: 'bottom',
                                }
                            }
                        }
                    });
                });
        }

        // ==================== BIỂU ĐỒ PHƯƠNG THỨC THANH TOÁN ====================
        function loadPaymentMethodChart() {
            fetch('{{ route('admin.statistics.payment-method') }}')
                .then(res => res.json())
                .then(data => {
                    if (chartsMap.paymentMethod) chartsMap.paymentMethod.destroy();
                    
                    const ctx = document.getElementById('paymentMethodChart').getContext('2d');
                    chartsMap.paymentMethod = new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: data.labels,
                            datasets: [
                                {
                                    label: 'Số Đơn',
                                    data: data.orders,
                                    backgroundColor: 'rgba(0, 123, 255, 0.8)',
                                    borderColor: colors.primary,
                                    borderWidth: 1,
                                    yAxisID: 'y'
                                },
                                {
                                    label: 'Doanh Thu (₫)',
                                    data: data.revenue,
                                    backgroundColor: 'rgba(40, 167, 69, 0.8)',
                                    borderColor: colors.success,
                                    borderWidth: 1,
                                    yAxisID: 'y1'
                                }
                            ]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: true,
                            interaction: {
                                mode: 'index',
                                intersect: false,
                            },
                            plugins: {
                                legend: {
                                    position: 'top',
                                }
                            },
                            scales: {
                                y: {
                                    type: 'linear',
                                    display: true,
                                    position: 'left',
                                    title: {
                                        display: true,
                                        text: 'Số Đơn'
                                    }
                                },
                                y1: {
                                    type: 'linear',
                                    display: true,
                                    position: 'right',
                                    title: {
                                        display: true,
                                        text: 'Doanh Thu (₫)'
                                    },
                                    grid: {
                                        drawOnChartArea: false,
                                    }
                                }
                            }
                        }
                    });
                });
        }

        // ==================== INIT ====================
        document.addEventListener('DOMContentLoaded', function() {
            // Load biểu đồ ban đầu
            loadRevenueByDay(30);
            loadRevenueByMonth(new Date().getFullYear());
            loadRevenueByYear();
            loadOrderStatusChart();
            loadPaymentMethodChart();

            // Event listeners
            document.getElementById('daySelect').addEventListener('change', (e) => {
                loadRevenueByDay(e.target.value);
            });

            document.getElementById('yearSelect').addEventListener('change', (e) => {
                loadRevenueByMonth(e.target.value);
            });

            // Reload biểu đồ khi chuyển tab
            document.getElementById('day-tab').addEventListener('shown.bs.tab', () => {
                if (chartsMap.revenueByDay) chartsMap.revenueByDay.resize();
            });

            document.getElementById('month-tab').addEventListener('shown.bs.tab', () => {
                if (chartsMap.revenueByMonth) chartsMap.revenueByMonth.resize();
            });

            document.getElementById('year-tab').addEventListener('shown.bs.tab', () => {
                if (chartsMap.revenueByYear) chartsMap.revenueByYear.resize();
            });

            document.getElementById('overview-tab').addEventListener('shown.bs.tab', () => {
                if (chartsMap.orderStatus) chartsMap.orderStatus.resize();
                if (chartsMap.paymentMethod) chartsMap.paymentMethod.resize();
            });
        });
    </script>
@endsection