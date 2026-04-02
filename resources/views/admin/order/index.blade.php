@extends('admin.layouts.layout')

@section('content')
    <div class="wrapper">

        <div>
            <!-- Start Container Fluid -->
            <div class="container-xxl">

                <!-- Thống kê nhanh (stats cards) -->
                <div class="row">
                    <!-- Đơn chờ xác nhận -->
                    <div class="col-md-6 col-xl-3">
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
                    </div>

                    <!-- Đơn đang xử lý -->
                    <div class="col-md-6 col-xl-3">
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
                    </div>

                    <!-- Đơn đang giao -->
                    <div class="col-md-6 col-xl-3">
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
                    </div>

                    <!-- Đơn đã giao -->
                    <div class="col-md-6 col-xl-3">
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
                    </div>

                    <!-- Đơn hủy -->
                    <div class="col-md-6 col-xl-3">
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
                    </div>

                    <!-- Chờ thanh toán -->
                    <div class="col-md-6 col-xl-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div>
                                        <h4 class="card-title mb-2">Chờ thanh toán</h4>
                                        <p class="text-muted fw-medium fs-22 mb-0">{{ $stats['pending_payment'] ?? 0 }}</p>
                                    </div>
                                    <div class="avatar-md bg-secondary bg-opacity-10 rounded">
                                        <iconify-icon icon="solar:clock-circle-broken"
                                            class="fs-32 text-secondary avatar-title"></iconify-icon>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Đã thanh toán -->
                    <div class="col-md-6 col-xl-3">
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
                    </div>

                    <!-- Tổng đơn hàng -->
                    <div class="col-md-6 col-xl-3">
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
                    </div>
                </div>


                <!-- Danh sách đơn hàng -->
                <div class="row">
                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h4 class="card-title mb-0">Danh sách đơn hàng</h4>
                                <div class="dropdown">
                                    <a href="#" class="dropdown-toggle btn btn-sm btn-outline-light rounded"
                                        data-bs-toggle="dropdown">
                                        {{ request('period', 'This Month') }}
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-end">
                                        <a href="{{ route('admin.order.index', ['period' => 'this_month']) }}"
                                            class="dropdown-item">This Month</a>
                                        <a href="{{ route('admin.order.index', ['period' => 'last_month']) }}"
                                            class="dropdown-item">Last Month</a>
                                        <a href="{{ route('admin.order.index') }}" class="dropdown-item">All Time</a>
                                    </div>
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
                                                        <span
                                                            class="badge border border-{{ $order->status === 'delivered'
                                                                ? 'success'
                                                                : ($order->status === 'cancelled'
                                                                    ? 'danger'
                                                                    : ($order->status === 'shipped'
                                                                        ? 'primary'
                                                                        : 'warning')) }} text-{{ $order->status === 'delivered'
                                                                ? 'success'
                                                                : ($order->status === 'cancelled'
                                                                    ? 'danger'
                                                                    : ($order->status === 'shipped'
                                                                        ? 'primary'
                                                                        : 'warning')) }} px-2 py-1 fs-13">
                                                            {{ $order->status === 'delivered'
                                                                ? 'Đã giao'
                                                                : ($order->status === 'cancelled'
                                                                    ? 'Đã huỷ'
                                                                    : ($order->status === 'shipped'
                                                                        ? 'Đang giao'
                                                                        : 'Chờ xử lý')) }}
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <div class="d-flex gap-2">
                                                            <a href="{{ route('admin.order.show', $order) }}"
                                                                class="btn btn-light btn-sm"
                                                                title="Xem chi tiết">
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
                                                                <div class="modal fade" id="editReceiver{{ $order->id }}"
                                                                    tabindex="-1">
                                                                    <div class="modal-dialog">
                                                                        <div class="modal-content">
                                                                            <form action="{{ route('admin.order.update-receiver', $order->id) }}"
                                                                                method="POST">
                                                                                @csrf
                                                                                @method('PUT')

                                                                                <div class="modal-header">
                                                                                    <h6 class="modal-title">Sửa thông tin nhận hàng</h6>
                                                                                    <button type="button" class="btn-close"
                                                                                        data-bs-dismiss="modal"></button>
                                                                                </div>

                                                                                <div class="modal-body">
                                                                                    <div class="mb-3">
                                                                                        <label class="form-label">Tên người nhận</label>
                                                                                        <input type="text" name="receiver_name" 
                                                                                            class="form-control" 
                                                                                            value="{{ $order->receiver_name }}"
                                                                                            required>
                                                                                    </div>

                                                                                    <div class="mb-3">
                                                                                        <label class="form-label">Số điện thoại</label>
                                                                                        <input type="tel" name="receiver_phone"
                                                                                            class="form-control"
                                                                                            value="{{ $order->receiver_phone }}"
                                                                                            required>
                                                                                    </div>

                                                                                    <div class="mb-3">
                                                                                        <label class="form-label">Địa chỉ</label>
                                                                                        <textarea name="receiver_address" 
                                                                                            class="form-control" 
                                                                                            rows="2"
                                                                                            required>{{ $order->receiver_address }}</textarea>
                                                                                    </div>

                                                                                    <div class="row">
                                                                                        <div class="col-md-6 mb-3">
                                                                                            <label class="form-label">Phường/Xã</label>
                                                                                            <input type="text" name="receiver_ward"
                                                                                                class="form-control"
                                                                                                value="{{ $order->receiver_ward }}"
                                                                                                required>
                                                                                        </div>
                                                                                        <div class="col-md-6 mb-3">
                                                                                            <label class="form-label">Quận/Huyện</label>
                                                                                            <input type="text" name="receiver_district"
                                                                                                class="form-control"
                                                                                                value="{{ $order->receiver_district }}"
                                                                                                required>
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="mb-3">
                                                                                        <label class="form-label">Tỉnh/Thành phố</label>
                                                                                        <input type="text" name="receiver_province"
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
                                                                                    $statuses = [
                                                                                        'pending',
                                                                                        'confirmed',
                                                                                        'processing',
                                                                                        'shipped',
                                                                                        'delivered',
                                                                                    ];

                                                                                    // Mảng dịch trạng thái sang tiếng Việt hiển thị cho người dùng
                                                                                    $statusTranslations = [
                                                                                        'pending' => 'Chờ xử lý',
                                                                                        'confirmed' => 'Đã xác nhận',
                                                                                        'processing' => 'Đang xử lý',
                                                                                        'shipped' => 'Đang giao',
                                                                                        'delivered' => 'Đã giao',
                                                                                    ];

                                                                                    $currentIndex = array_search(
                                                                                        $order->status,
                                                                                        $statuses,
                                                                                    );
                                                                                @endphp

                                                                                <select name="status"
                                                                                    class="form-select">
                                                                                    @foreach ($statuses as $index => $status)
                                                                                        <option
                                                                                            value="{{ $status }}"
                                                                                            {{ $order->status == $status ? 'selected' : '' }}
                                                                                            {{ $index < $currentIndex ? 'disabled' : '' }}>
                                                                                            {{ $statusTranslations[$status] ?? ucfirst($status) }}
                                                                                        </option>
                                                                                    @endforeach

                                                                                    <option value="cancelled"
                                                                                        {{ $order->status == 'cancelled' ? 'selected' : '' }}>
                                                                                        Đã huỷ
                                                                                    </option>
                                                                                </select>
                                                                            </div>

                                                                            <div class="modal-footer">
                                                                                <button type="submit"
                                                                                    class="btn btn-primary btn-sm">
                                                                                    Cập nhật
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
