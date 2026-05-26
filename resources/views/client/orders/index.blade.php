@extends('client.layout.layout')

@section('content')
    <div class="flat-spacing-13">
        <div class="container-7">
            <div class="btn-sidebar-mb d-lg-none">
                <button data-bs-toggle="offcanvas" data-bs-target="#mbAccount">
                    <i class="icon icon-sidebar"></i>
                </button>
            </div>

            <div class="main-content-account">
                @include('client.layout.sidebar')

                <div class="my-acount-content account-orders">
                    <div class="account-orders-wrap">
                        <h5 class="title">Lịch sử đặt hàng</h5>

                        <div class="order-status-tabs mb-3">
                            @foreach ($statuses as $statusKey => $statusLabel)
                                @php
                                    $badgeCount =
                                        $statusKey === 'all' ? $orders->total() : $statusCounts[$statusKey] ?? 0;
                                @endphp
                                <a href="{{ route('client.orders.index', ['status' => $statusKey]) }}"
                                    class="btn btn-sm me-2 {{ $activeStatus === $statusKey ? 'btn-primary' : 'btn-outline-secondary' }}">
                                    {{ $statusLabel }} ({{ $badgeCount }})
                                </a>
                            @endforeach
                        </div>

                        <div class="wrap-account-order">
                            @if ($orders->isEmpty())
                                <div class="account-no-orders-wrap" style="display: block;">
                                    <img class="lazyload" data-src="images/section/account-no-order.png"
                                        src="images/section/account-no-order.png" alt="">
                                    <div class="display-sm fw-medium title">
                                        <p>Hiện tại chưa có đơn hàng ở trạng thái</p>
                                        "{{ $statuses[$activeStatus] ?? 'Không xác định' }}"
                                    </div>
                                    <div class="text text-sm">Bạn có thể chọn tab khác để xem đơn hàng.</div>
                                </div>
                            @else
                                @foreach ($orders as $order)
                                    <div class="order-card mb-3 p-3 border rounded bg-white">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <div>
                                                <strong>{{ $order->order_code }}</strong>
                                                <span class="text-muted">•
                                                    {{ $order->created_at->format('d/m/Y H:i') }}</span>
                                            </div>
                                            @php
                                                $statusColorMap = [
                                                    'pending' => 'warning',
                                                    'confirmed' => 'info',
                                                    'processing' => 'primary',
                                                    'shipped' => 'secondary',
                                                    'delivered' => 'success',
                                                    'cancelled' => 'danger',
                                                    'returned' => 'dark',
                                                ];
                                                $statusLabelMap = [
                                                    'pending' => 'Chờ xác nhận',
                                                    'confirmed' => 'Đã xác nhận',
                                                    'processing' => 'Đang xử lý',
                                                    'shipped' => 'Đã gửi',
                                                    'delivered' => 'Đã giao',
                                                    'cancelled' => 'Đã hủy',
                                                    'returned' => 'Trả hàng',
                                                ];
                                                $statusColor = $statusColorMap[$order->status] ?? 'dark';
                                                $statusLabel =
                                                    $statusLabelMap[$order->status] ?? ucfirst($order->status);
                                            @endphp
                                            <span
                                                class="badge bg-{{ $statusColor }} text-uppercase">{{ $statusLabel }}</span>
                                        </div>

                                        <div class="row mb-2">
                                            <div class="col-md-5">
                                                <div class="d-flex align-items-center">
                                                    <i class="ri-truck-line me-2"></i>
                                                    <span class="text-muted">Thanh toán:
                                                        <b>{{ $order->payment_method_label }}</b>
                                                    </span>
                                                </div>
                                                <span class="mx-2"><b>{{ $order->payment_status_label }}</b></span>
                                            </div>
                                            <div class="col-md-5">
                                                <div class="d-flex align-items-center">
                                                    <i class="ri-store-2-line me-2"></i>
                                                    <span class="text-muted">Sản phẩm: {{ $order->items->sum('quantity') }}
                                                        sp</span>
                                                </div>
                                            </div>
                                            <div class="col-md-2 text-end">
                                                <small class="text-muted">Tổng:</small>
                                                <div><strong>{{ number_format($order->total_amount, 0, ',', '.') }}
                                                        ₫</strong></div>
                                            </div>
                                        </div>

                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <a href="{{ route('client.orders.show', $order) }}"
                                                    class="btn btn-sm btn-outline-primary">Xem chi tiết</a>
                                                @if ($order->status === 'pending')
                                                    <span class="badge bg-info">Chờ xác nhận</span>
                                                @endif
                                            </div>
                                            <a href="{{ route('client.orders.show', $order) }}" class="text-primary">Xem
                                                đơn >></a>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>

                        <div class="mt-3">{{ $orders->links() }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
