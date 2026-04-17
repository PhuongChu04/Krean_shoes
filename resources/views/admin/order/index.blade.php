@extends('admin.layouts.layout')

@section('content')
    <div class="wrapper">

        <div>
            <!-- Start Container Fluid -->
            <div class="container-xxl">

                <!-- Thống kê nhanh (stats cards) -->
                <div class="row">
                    @php
                        $baseQuery = request()->except('page');
                    @endphp
                    <!-- Đơn chờ xác nhận -->
                    <div class="col-md-6 col-xl-3">
                        <a href="{{ route('admin.order.index', array_merge($baseQuery, ['status' => 'pending'])) }}"
                            class="text-reset text-decoration-none">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div>
                                            <h4 class="card-title mb-2">Đơn chờ xác nhận</h4>
                                            <p class="text-muted fw-medium fs-22 mb-0">{{ $stats['pending'] ?? 0 }}</p>
                                        </div>
                                        <div class="avatar-md bg-warning bg-opacity-10 rounded">
                                            <iconify-icon icon="solar:clock-circle-broken"
                                                class="fs-32 text-warning avatar-title"></iconify-icon>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>

                    <!-- Đơn đang xử lý -->
                    <div class="col-md-6 col-xl-3">
                        <a href="{{ route('admin.order.index', array_merge($baseQuery, ['status' => 'processing'])) }}"
                            class="text-reset text-decoration-none">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div>
                                            <h4 class="card-title mb-2">Đơn đang xử lý</h4>
                                            <p class="text-muted fw-medium fs-22 mb-0">{{ $stats['processing'] ?? 0 }}</p>
                                        </div>
                                        <div class="avatar-md bg-info bg-opacity-10 rounded">
                                            <iconify-icon icon="solar:inbox-line-broken"
                                                class="fs-32 text-info avatar-title"></iconify-icon>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>

                    <!-- Đơn đang giao -->
                    <div class="col-md-6 col-xl-3">
                        <a href="{{ route('admin.order.index', array_merge($baseQuery, ['status' => 'shipped'])) }}"
                            class="text-reset text-decoration-none">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div>
                                            <h4 class="card-title mb-2">Đơn đang giao</h4>
                                            <p class="text-muted fw-medium fs-22 mb-0">{{ $stats['shipped'] ?? 0 }}</p>
                                        </div>
                                        <div class="avatar-md bg-primary bg-opacity-10 rounded">
                                            <iconify-icon icon="solar:box-broken"
                                                class="fs-32 text-primary avatar-title"></iconify-icon>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>

                    <!-- Đơn đã giao -->
                    <div class="col-md-6 col-xl-3">
                        <a href="{{ route('admin.order.index', array_merge($baseQuery, ['status' => 'delivered'])) }}"
                            class="text-reset text-decoration-none">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div>
                                            <h4 class="card-title mb-2">Đơn đã giao</h4>
                                            <p class="text-muted fw-medium fs-22 mb-0">{{ $stats['delivered'] ?? 0 }}</p>
                                        </div>
                                        <div class="avatar-md bg-success bg-opacity-10 rounded">
                                            <iconify-icon icon="solar:clipboard-check-broken"
                                                class="fs-32 text-success avatar-title"></iconify-icon>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>

                    <!-- Đơn trả hàng -->
                    <div class="col-md-6 col-xl-3">
                        <a href="{{ route('admin.order.index', array_merge($baseQuery, ['status' => 'returned'])) }}"
                            class="text-reset text-decoration-none">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div>
                                            <h4 class="card-title mb-2">Đơn trả hàng</h4>
                                            <p class="text-muted fw-medium fs-22 mb-0">{{ $stats['returned'] ?? 0 }}</p>
                                        </div>
                                        <div class="avatar-md bg-secondary bg-opacity-10 rounded">
                                            <iconify-icon icon="solar:arrow-back-up"
                                                class="fs-32 text-secondary avatar-title"></iconify-icon>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>

                    <!-- Đơn hủy -->
                    <div class="col-md-6 col-xl-3">
                        <a href="{{ route('admin.order.index', array_merge($baseQuery, ['status' => 'cancelled'])) }}"
                            class="text-reset text-decoration-none">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div>
                                            <h4 class="card-title mb-2">Đơn hủy</h4>
                                            <p class="text-muted fw-medium fs-22 mb-0">{{ $stats['cancelled'] ?? 0 }}</p>
                                        </div>
                                        <div class="avatar-md bg-danger bg-opacity-10 rounded">
                                            <iconify-icon icon="solar:cart-cross-broken"
                                                class="fs-32 text-danger avatar-title"></iconify-icon>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>

                    <!-- Chờ thanh toán -->
                    <div class="col-md-6 col-xl-3">
                        <a href="{{ route('admin.order.index', array_merge($baseQuery, ['payment_status' => 'pending'])) }}"
                            class="text-reset text-decoration-none">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div>
                                            <h4 class="card-title mb-2">Chờ thanh toán</h4>
                                            <p class="text-muted fw-medium fs-22 mb-0">{{ $stats['pending_payment'] ?? 0 }}
                                            </p>
                                        </div>
                                        <div class="avatar-md bg-secondary bg-opacity-10 rounded">
                                            <iconify-icon icon="solar:clock-circle-broken"
                                                class="fs-32 text-secondary avatar-title"></iconify-icon>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>

                    <!-- Đã thanh toán -->
                    <div class="col-md-6 col-xl-3">
                        <a href="{{ route('admin.order.index', array_merge($baseQuery, ['payment_status' => 'paid'])) }}"
                            class="text-reset text-decoration-none">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div>
                                            <h4 class="card-title mb-2">Đã thanh toán</h4>
                                            <p class="text-muted fw-medium fs-22 mb-0">{{ $stats['paid'] ?? 0 }}</p>
                                        </div>
                                        <div class="avatar-md bg-success bg-opacity-10 rounded">
                                            <iconify-icon icon="solar:check-circle-broken"
                                                class="fs-32 text-success avatar-title"></iconify-icon>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>

                    <!-- Tổng đơn hàng -->
                    <div class="col-md-6 col-xl-3">
                        <a href="{{ route('admin.order.index', request()->except(['page', 'status', 'payment_status'])) }}"
                            class="text-reset text-decoration-none">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div>
                                            <h4 class="card-title mb-2">Tổng đơn hàng</h4>
                                            <p class="text-muted fw-medium fs-22 mb-0">{{ $stats['total'] ?? 0 }}</p>
                                        </div>
                                        <div class="avatar-md bg-dark bg-opacity-10 rounded">
                                            <iconify-icon icon="solar:cart-bold-duotone"
                                                class="fs-32 text-dark avatar-title"></iconify-icon>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>


                <!-- Danh sách đơn hàng -->
                <div class="row">
                    <div class="col-xl-12">
                        <div class="card">
                            @php
                                $statusLabelMap = [
                                    'pending' => 'Đơn chờ xác nhận',
                                    'confirmed' => 'Đơn đã xác nhận',
                                    'processing' => 'Đơn đang xử lý',
                                    'shipped' => 'Đơn đang giao',
                                    'delivered' => 'Đơn đã giao',
                                    'cancelled' => 'Đơn hủy',
                                    'returned' => 'Đơn trả hàng',
                                ];
                                $paymentLabelMap = [
                                    'pending' => 'Chờ thanh toán',
                                    'paid' => 'Đã thanh toán',
                                ];
                                $filterLabel = request('period', 'Tất cả thời gian');
                                if (request('date')) {
                                    $filterLabel = 'Ngày ' . \Carbon\Carbon::parse(request('date'))->format('d/m/Y');
                                } elseif (request('month')) {
                                    $filterLabel =
                                        'Tháng ' . \Carbon\Carbon::parse(request('month') . '-01')->format('m/Y');
                                } elseif (request('year')) {
                                    $filterLabel = 'Năm ' . request('year');
                                } elseif (request('period') === 'last_month') {
                                    $filterLabel = 'Tháng trước';
                                } elseif (request('period') === 'this_month') {
                                    $filterLabel = 'Tháng này';
                                }
                                if (request('status') && isset($statusLabelMap[request('status')])) {
                                    $filterLabel = $statusLabelMap[request('status')];
                                } elseif (
                                    request('payment_status') &&
                                    isset($paymentLabelMap[request('payment_status')])
                                ) {
                                    $filterLabel = $paymentLabelMap[request('payment_status')];
                                }
                            @endphp
                            <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-3">
                                <h4 class="card-title mb-0">Danh sách đơn hàng</h4>

                                <div class="d-flex align-items-center gap-2 flex-wrap">
                                    <!-- dropdown -->
                                    <div class="dropdown">
                                        <a href="#" class="dropdown-toggle btn btn-sm btn-outline-light"
                                            data-bs-toggle="dropdown">
                                            {{ $filterLabel }}
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-end">
                                            <a href="{{ route('admin.order.index', ['period' => 'this_month']) }}"
                                                class="dropdown-item">Tháng này</a>
                                            <a href="{{ route('admin.order.index', ['period' => 'last_month']) }}"
                                                class="dropdown-item">Tháng trước</a>
                                            <a href="{{ route('admin.order.index') }}" class="dropdown-item">Tất cả thời
                                                gian</a>
                                        </div>
                                    </div>

                                    <!-- form -->
                                    <form action="{{ route('admin.order.index') }}" method="GET"
                                        class="row g-2 align-items-center mb-0">

                                        @if (request('status'))
                                            <input type="hidden" name="status" value="{{ request('status') }}">
                                        @endif
                                        @if (request('payment_status'))
                                            <input type="hidden" name="payment_status"
                                                value="{{ request('payment_status') }}">
                                        @endif

                                        <div class="col-auto">
                                            <div class="input-group input-group-sm">
                                                <span class="input-group-text bg-white">
                                                    <i class="bi bi-search"></i>
                                                </span>
                                                <input type="text" name="search" class="form-control border-start-0"
                                                    placeholder="Tìm mã đơn, tên, SĐT..."
                                                    value="{{ request('search') }}">
                                            </div>
                                        </div>

                                        <div class="col-auto">
                                            <div class="input-group input-group-sm">
                                                <span class="input-group-text">Ngày</span>
                                                <input type="date" name="date" class="form-control"
                                                    value="{{ request('date') }}">
                                            </div>
                                        </div>

                                        <div class="col-auto">
                                            <div class="input-group input-group-sm">
                                                <span class="input-group-text">Tháng</span>
                                                <input type="month" name="month" class="form-control"
                                                    value="{{ request('month') }}">
                                            </div>
                                        </div>

                                        <div class="col-auto">
                                            <div class="input-group input-group-sm">
                                                <span class="input-group-text">Năm</span>
                                                <input type="number" name="year" class="form-control"
                                                    value="{{ request('year') }}">
                                            </div>
                                        </div>

                                        <div class="col-auto">
                                            <button class="btn btn-primary btn-sm">Lọc</button>
                                        </div>

                                        <div class="col-auto">
                                            <a href="{{ route('admin.order.index') }}"
                                                class="btn btn-outline-secondary btn-sm">Xóa</a>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table align-middle mb-0 table-hover table-centered">
                                        <thead class="bg-light-subtle">
                                            <tr>
                                                <th>Mã đơn</th>
                                                <th>Ngày tạo</th>
                                                <th>Khách hàng</th>
                                                <th>Tổng tiền</th>
                                                <th>Thanh toán</th>
                                                <th>Sản phẩm</th>
                                                <th>Trạng thái</th>
                                                <th>Hành động</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($orders as $order)
                                                <tr>
                                                    <td>{{ $order->order_code }}</td>
                                                    <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                                                    <td>
                                                        <a href="#"
                                                            class="link-primary fw-medium">{{ $order->receiver_name }}</a><br>
                                                        <small>{{ $order->receiver_phone }}</small>
                                                    </td>
                                                    <td>{{ number_format($order->total_amount) }} ₫</td>
                                                    <td>
                                                        <span
                                                            class="badge bg-{{ $order->payment_status === 'paid' ? 'success' : 'warning' }} text-light px-2 py-1 fs-13">
                                                            {{ $order->payment_status === 'paid' ? 'Đã thanh toán' : 'Chưa thanh toán' }}
                                                            ({{ strtoupper($order->payment_method) }})
                                                        </span>
                                                    </td>
                                                    <td>{{ $order->items->count() }}</td>
                                                    <td>
                                                        @php
                                                            $statusMap = [
                                                                'pending' => [
                                                                    'label' => 'Chờ xác nhận',
                                                                    'class' => 'warning',
                                                                ],
                                                                'confirmed' => [
                                                                    'label' => 'Đã xác nhận',
                                                                    'class' => 'info',
                                                                ],
                                                                'processing' => [
                                                                    'label' => 'Đang xử lý',
                                                                    'class' => 'secondary',
                                                                ],
                                                                'shipped' => [
                                                                    'label' => 'Đang giao',
                                                                    'class' => 'primary',
                                                                ],
                                                                'delivered' => [
                                                                    'label' => 'Đã giao',
                                                                    'class' => 'success',
                                                                ],
                                                                'cancelled' => [
                                                                    'label' => 'Đã hủy',
                                                                    'class' => 'danger',
                                                                ],
                                                                'returned' => [
                                                                    'label' => 'Đã trả hàng',
                                                                    'class' => 'dark',
                                                                ],
                                                            ];

                                                            $status = $statusMap[$order->status] ?? [
                                                                'label' => 'Không xác định',
                                                                'class' => 'secondary',
                                                            ];
                                                        @endphp

                                                        <span class="badge bg-{{ $status['class'] }} px-2 py-1 fs-13">
                                                            {{ $status['label'] }}
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <div class="d-flex gap-2">
                                                            <a href="{{ route('admin.order.show', $order) }}"
                                                                class="btn btn-light btn-sm" title="Xem chi tiết">
                                                                <iconify-icon icon="solar:eye-broken"
                                                                    class="align-middle fs-18"></iconify-icon>
                                                            </a>
                                                           

                                                            @if ($order->status === 'pending')
                                                                <button type="button" class="btn btn-soft-warning btn-sm"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#editReceiver{{ $order->id }}"
                                                                    title="Sửa thông tin nhận hàng">
                                                                    <iconify-icon icon="solar:pen-2-broken"
                                                                        class="align-middle fs-18"></iconify-icon>
                                                                </button>

                                                                <!-- Modal sửa thông tin nhận hàng -->
                                                                <div class="modal fade"
                                                                    id="editReceiver{{ $order->id }}" tabindex="-1">
                                                                    <div class="modal-dialog">
                                                                        <div class="modal-content">
                                                                            <form
                                                                                action="{{ route('admin.order.update-receiver', $order->id) }}"
                                                                                method="POST">
                                                                                @csrf
                                                                                @method('PUT')

                                                                                <div class="modal-header">
                                                                                    <h6 class="modal-title">Sửa thông tin
                                                                                        nhận hàng</h6>
                                                                                    <button type="button"
                                                                                        class="btn-close"
                                                                                        data-bs-dismiss="modal"></button>
                                                                                </div>

                                                                                <div class="modal-body">
                                                                                    <div class="mb-3">
                                                                                        <label class="form-label">Tên người
                                                                                            nhận</label>
                                                                                        <input type="text"
                                                                                            name="receiver_name"
                                                                                            class="form-control"
                                                                                            value="{{ $order->receiver_name }}"
                                                                                            required>
                                                                                    </div>

                                                                                    <div class="mb-3">
                                                                                        <label class="form-label">Số điện
                                                                                            thoại</label>
                                                                                        <input type="tel"
                                                                                            name="receiver_phone"
                                                                                            class="form-control"
                                                                                            value="{{ $order->receiver_phone }}"
                                                                                            required>
                                                                                    </div>

                                                                                    <div class="mb-3">
                                                                                        <label class="form-label">Địa
                                                                                            chỉ</label>
                                                                                        <textarea name="receiver_address" class="form-control" rows="2" required>{{ $order->receiver_address }}</textarea>
                                                                                    </div>

                                                                                    <div class="row">
                                                                                        <div class="col-md-6 mb-3">
                                                                                            <label
                                                                                                class="form-label">Phường/Xã</label>
                                                                                            <input type="text"
                                                                                                name="receiver_ward"
                                                                                                class="form-control"
                                                                                                value="{{ $order->receiver_ward }}"
                                                                                                required>
                                                                                        </div>
                                                                                        <div class="col-md-6 mb-3">
                                                                                            <label
                                                                                                class="form-label">Quận/Huyện</label>
                                                                                            <input type="text"
                                                                                                name="receiver_district"
                                                                                                class="form-control"
                                                                                                value="{{ $order->receiver_district }}"
                                                                                                required>
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="mb-3">
                                                                                        <label
                                                                                            class="form-label">Tỉnh/Thành
                                                                                            phố</label>
                                                                                        <input type="text"
                                                                                            name="receiver_province"
                                                                                            class="form-control"
                                                                                            value="{{ $order->receiver_province }}"
                                                                                            required>
                                                                                    </div>
                                                                                </div>

                                                                                <div class="modal-footer">
                                                                                    <button type="submit"
                                                                                        class="btn btn-primary btn-sm">
                                                                                        Lưu thay đổi
                                                                                    </button>
                                                                                    <button type="button"
                                                                                        class="btn btn-secondary btn-sm"
                                                                                        data-bs-dismiss="modal">
                                                                                        Hủy
                                                                                    </button>
                                                                                </div>

                                                                            </form>

                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endif

                                                            <!-- Nút đổi trạng thái có thể thêm modal hoặc form riêng sau -->
                                                            {{-- <form action="{{ route('admin.order.status', $order->id) }}"
                                                                method="POST">
                                                                @csrf
                                                                @method('post')

                                                                <button type="button" class="btn btn-soft-primary btn-sm"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#changeStatus{{ $order->id }}">

                                                                    <iconify-icon icon="solar:pen-2-broken"
                                                                        class="align-middle fs-18"></iconify-icon>
                                                                </button>
                                                                <div class="modal fade"
                                                                    id="changeStatus{{ $order->id }}" tabindex="-1">
                                                                    <div class="modal-dialog modal-sm">
                                                                        <div class="modal-content">

                                                                            <form
                                                                                action="{{ route('admin.order.status', $order->id) }}"
                                                                                method="POST">
                                                                                @csrf

                                                                                <div class="modal-header">
                                                                                    <h6 class="modal-title">Đổi trạng thái
                                                                                    </h6>
                                                                                    <button type="button"
                                                                                        class="btn-close"
                                                                                        data-bs-dismiss="modal"></button>
                                                                                </div>

                                                                                <div class="modal-body">
                                                                                    <select name="status"
                                                                                        class="form-select">
                                                                                        <option value="pending"
                                                                                            {{ $order->status == 'pending' ? 'selected' : '' }}>
                                                                                            Pending</option>
                                                                                        <option value="confirmed"
                                                                                            {{ $order->status == 'confirmed' ? 'selected' : '' }}>
                                                                                            Confirmed</option>
                                                                                        <option value="processing"
                                                                                            {{ $order->status == 'processing' ? 'selected' : '' }}>
                                                                                            Processing</option>
                                                                                        <option value="shipped"
                                                                                            {{ $order->status == 'shipped' ? 'selected' : '' }}>
                                                                                            Shipped</option>
                                                                                        <option value="delivered"
                                                                                            {{ $order->status == 'delivered' ? 'selected' : '' }}>
                                                                                            Delivered</option>
                                                                                        <option value="cancelled"
                                                                                            {{ $order->status == 'cancelled' ? 'selected' : '' }}>
                                                                                            Cancelled</option>
                                                                                    </select>
                                                                                </div>

                                                                                <div class="modal-footer">
                                                                                    <button type="submit"
                                                                                        class="btn btn-primary btn-sm">Cập
                                                                                        nhật</button>
                                                                                    <button type="button"
                                                                                        class="btn btn-secondary btn-sm"
                                                                                        data-bs-dismiss="modal">Hủy</button>
                                                                                </div>

                                                                            </form>

                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </form> --}}
                                                            <!-- 🔘 Nút mở modal -->
                                                            <button type="button" class="btn btn-soft-primary btn-sm"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#changeStatus{{ $order->id }}"
                                                                title="Đổi trạng thái">

                                                                <iconify-icon icon="solar:history-2-broken"
                                                                    class="align-middle fs-18"></iconify-icon>
                                                            </button>

                                                            <!-- 🔥 Modal -->
                                                            <div class="modal fade" id="changeStatus{{ $order->id }}"
                                                                tabindex="-1">
                                                                <div class="modal-dialog modal-sm">
                                                                    <div class="modal-content">

                                                                        <form
                                                                            action="{{ route('admin.order.status', $order->id) }}"
                                                                            method="POST">
                                                                            @csrf

                                                                            <div class="modal-header">
                                                                                <h6 class="modal-title">Đổi trạng thái</h6>
                                                                                <button type="button" class="btn-close"
                                                                                    data-bs-dismiss="modal"></button>
                                                                            </div>

                                                                            <div class="modal-body">
                                                                                @php
                                                                                    $statusTranslations = [
                                                                                        'pending' => 'Chờ xác nhận',
                                                                                        'confirmed' => 'Đã xác nhận',
                                                                                        'processing' => 'Đang xử lý',
                                                                                        'shipped' => 'Đang giao',
                                                                                        'delivered' => 'Đã giao',
                                                                                        'returned' => 'Đã trả hàng',
                                                                                        'cancelled' => 'Đã huỷ',
                                                                                    ];
                                                                                    $statusTransitions = [
                                                                                        'pending' => [
                                                                                            'confirmed' => 'Đã xác nhận',
                                                                                            'cancelled' => 'Đã huỷ',
                                                                                        ],
                                                                                        'confirmed' => [
                                                                                            'processing' => 'Đang xử lý',
                                                                                        ],
                                                                                        'processing' => [
                                                                                            'shipped' => 'Đang giao',
                                                                                        ],
                                                                                        'shipped' => [
                                                                                            'delivered' => 'Đã giao',
                                                                                        ],
                                                                                        'delivered' => [
                                                                                            'returned' => 'Đã trả hàng',
                                                                                        ],
                                                                                    ];
                                                                                    $currentStatus = $order->status;
                                                                                    $nextStatuses = $statusTransitions[$currentStatus] ?? [];
                                                                                @endphp

                                                                                <div class="mb-3">
                                                                                    <p class="mb-2">
                                                                                        Trạng thái hiện tại:
                                                                                        <strong>{{ $statusTranslations[$currentStatus] ?? ucfirst($currentStatus) }}</strong>
                                                                                    </p>
                                                                                    <div class="d-grid gap-2">
                                                                                        @forelse ($nextStatuses as $statusValue => $statusLabel)
                                                                                            <button type="submit"
                                                                                                name="status"
                                                                                                value="{{ $statusValue }}"
                                                                                                class="btn btn-outline-primary btn-sm">
                                                                                                {{ $statusLabel }}
                                                                                            </button>
                                                                                        @empty
                                                                                            <div class="text-muted">Không
                                                                                                có trạng thái nào để chuyển.
                                                                                            </div>
                                                                                        @endforelse
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <div class="modal-footer">
                                                                                <button type="button"
                                                                                    class="btn btn-secondary btn-sm"
                                                                                    data-bs-dismiss="modal">
                                                                                    Hủy
                                                                                </button>
                                                                            </div>

                                                                        </form>

                                                                    </div>
                                                                </div>
                                                            </div>


                                                        </div>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="8" class="text-center py-5">Chưa có đơn hàng nào.
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="card-footer border-top">
                                {{ $orders->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- End Container Fluid -->

        <!-- Footer -->


    </div>
@endsection
