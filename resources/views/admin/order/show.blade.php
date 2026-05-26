@extends('admin.layouts.layout')

@section('content')
    <div class="container-xxl">

        <div class="row">
            <!-- Nội dung chính -->
            <div class="col-xl-9 col-lg-8">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
                                    <div>
                                        <h4 class="fw-medium text-dark d-flex align-items-center gap-2">
                                            {{ $order->order_code }}
                                            <span
                                                class="badge bg-{{ $order->payment_status === 'paid' ? 'success' : 'warning' }} px-2 py-1 fs-13">
                                                {{ $order->payment_status === 'paid' ? 'Đã thanh toán' : 'Chưa thanh toán' }}
                                            </span>
                                            <span
                                                class="badge border border-{{ $order->status === 'delivered' ? 'success' : ($order->status === 'cancelled' ? 'danger' : 'warning') }} text-{{ $order->status === 'delivered' ? 'success' : ($order->status === 'cancelled' ? 'danger' : 'warning') }} px-2 py-1 fs-13">
                                                {{ $order->status === 'delivered'
                                                    ? 'Đã giao'
                                                    : ($order->status === 'cancelled'
                                                        ? 'Đã huỷ'
                                                        : ($order->status === 'shipped'
                                                            ? 'Đang giao'
                                                            : 'Chờ xử lý')) }}
                                            </span>
                                        </h4>
                                        <p class="mb-0 text-muted">
                                            Đơn hàng / Chi tiết đơn hàng / {{ $order->order_code }} -
                                            {{ $order->created_at->format('d/m/Y \l\ú\c H:i') }}
                                        </p>
                                    </div>

                                </div>

                                <!-- Header -->
                                {{-- <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4">
                            <div>
                                <h4 class="fw-medium text-dark d-flex align-items-center gap-2">
                                    {{ $order->order_code }}
                                    <span class="badge bg-{{ $order->payment_status === 'paid' ? 'success' : 'warning' }} px-3 py-1">
                                        {{ ucfirst($order->payment_status) }}
                                    </span>
                                </h4>
                                <p class="text-muted mb-0">
                                    Đơn hàng #{{ $order->order_code }} — 
                                    {{ $order->created_at->format('d/m/Y \l\ú\c H:i') }}
                                </p>
                            </div>
                        </div> --}}


                                <!-- ==================== KẾT THÚC CHỈNH TRẠNG THÁI ==================== -->

                                <!-- Danh sách sản phẩm -->
                                <div class="card mt-4">
                                    <div class="card-header">
                                        <h4 class="card-title mb-0">Sản phẩm trong đơn hàng</h4>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table align-middle table-hover">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th>Sản phẩm</th>
                                                        <th>Phân loại</th>
                                                        <th class="text-center">Số lượng</th>
                                                        <th class="text-end">Giá</th>
                                                        <th class="text-end">Thành tiền</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @forelse($order->items as $item)
                                                        <tr>
                                                            <td>
                                                                <div class="d-flex align-items-center gap-3">
                                                                    <img src="{{ $item->variant?->images?->first()?->image
                                                                        ? Storage::url($item->variant->images->first()->image)
                                                                        : asset('images/no-image.jpg') }}"
                                                                        class="rounded"
                                                                        style="width: 60px; height: 60px; object-fit: cover;">

                                                                    <!-- KHUNG ẢNH -->
                                                                    <div
                                                                        class="rounded bg-light avatar-md d-flex align-items-center justify-content-center overflow-hidden">
                                                                        <img src="{{ $item->variant?->product?->thumbnail
                                                                            ? asset('storage/' . $item->variant->product->thumbnail)
                                                                            : asset('client/images/products/product-not-found.jpg') }}"
                                                                            class="w-100 h-100 object-fit-cover">
                                                                    </div>

                                                                    <div>
                                                                        <a href="#" class="fw-medium text-dark">
                                                                            {{ $item->variant->product->name ?? 'Sản phẩm không tồn tại' }}
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <span class="badge bg-light text-dark">
                                                                    Màu: {{ $item->variant->color->name ?? '-' }}
                                                                </span>
                                                                <span class="badge bg-light text-dark ms-1">
                                                                    Size: {{ $item->variant->size->name ?? '-' }}
                                                                </span>
                                                            </td>
                                                            <td class="text-center fw-medium">{{ $item->quantity }}</td>
                                                            <td class="text-end">{{ number_format($item->price) }} ₫</td>
                                                            <td class="text-end fw-bold">
                                                                {{ number_format($item->subtotal) }} ₫</td>
                                                        </tr>
                                                    @empty
                                                        <tr>
                                                            <td colspan="5" class="text-center py-4 text-muted">Không có
                                                                sản phẩm trong đơn hàng.</td>
                                                        </tr>
                                                    @endforelse
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    <!-- Sidebar bên phải: User + Status + Receiver lên trên đầu -->

                </div>
            </div>
            <div class="col-xl-3 col-lg-4">
                <!-- Order Owner Info -->
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Thông tin tài khoản đặt hàng</h4>
                    </div>
                    <div class="card-body">
                        <p class="mb-1">Tên người đặt: <span
                                class="fw-medium">{{ $order->user->name ?? ($order->user_name ?? 'Khách vãng lai') }}</span>
                        </p>
                        <p class="mb-1">Email: <span class="fw-medium">{{ $order->user->email ?? '-' }}</span></p>
                        <p class="mb-1">Số điện thoại: <span
                                class="fw-medium">{{ $order->user->phone ?? ($order->receiver_phone ?? '-') }}</span></p>
                        <p class="mb-0">ID người dùng: <span
                                class="fw-medium">{{ $order->user->id ? '#' . $order->user->id : 'không' }}</span></p>
                    </div>
                </div>

                <!-- Status action buttons -->
                @php
                    $statusTransitions = [
                        'pending' => [
                            'confirmed' => 'Xác nhận',
                            'cancelled' => 'Huỷ đơn',
                        ],
                        'confirmed' => [
                            'processing' => 'Chuyển sang xử lý',
                        ],
                        'processing' => [
                            'shipped' => 'Chuyển sang giao hàng',
                        ],
                        'shipped' => [
                            'delivered' => 'Đánh dấu đã giao',
                        ],
                        'delivered' => [
                            'returned' => 'Đánh dấu trả hàng',
                        ],
                    ];
                    $nextActions = $statusTransitions[$order->status] ?? [];
                @endphp
                <div class="card mt-4">
                    <div class="card-header">
                        <h4 class="card-title">Cập nhật trạng thái</h4>
                    </div>
                    <div class="card-body">
                        @if ($nextActions)
                            <div class="d-flex flex-wrap gap-2">
                                @foreach ($nextActions as $status => $label)
                                    <form method="POST" action="{{ route('admin.order.status', $order) }}" class="m-0">
                                        @csrf
                                        <input type="hidden" name="status" value="{{ $status }}">
                                        <button type="submit"
                                            class="btn btn-sm {{ $status === 'cancelled' ? 'btn-outline-danger' : 'btn-outline-primary' }}">
                                            {{ $label }}
                                        </button>
                                    </form>
                                @endforeach
                            </div>
                        @else
                            <p class="mb-0 text-muted">Không có hành động trạng thái khả dụng với trạng thái hiện tại
                                "{{ $order->status }}".</p>
                        @endif
                    </div>
                </div>

                <!-- Customer Details -->
                <div class="card mt-4">
                    <div class="card-header">
                        <h4 class="card-title">Thông tin khách hàng nhận</h4>
                    </div>
                    <div class="card-body">
                        <div class="d-flex align-items-center gap-3 mb-3">
                            <div class="avatar rounded-circle border border-light d-flex align-items-center justify-content-center"
                                style="width: 40px; height: 40px; min-width: 40px;">
                                <img src="{{ $order->user?->userProfile?->user_image ? asset('storage/' . $order->user->userProfile->user_image) : asset('client/images/products/product-not-found.jpg') }}"
                                    alt="" class="avatar-img w-100 h-100 object-fit-cover rounded-circle">
                            </div>
                            <div>
                                <p class="mb-1 fw-medium">{{ $order->receiver_name }}</p>
                                <a href="mailto:{{ $order->user?->email ?? '' }}" class="link-primary">
                                    {{ $order->user?->email ?? 'Khách vãng lai' }}
                                </a>
                            </div>
                        </div>

                        <h6 class="mt-4 mb-2">Số điện thoại</h6>
                        <p class="mb-2">{{ $order->receiver_phone }}</p>

                        <h6 class="mt-3 mb-2">Địa chỉ giao hàng</h6>
                        <p class="mb-0">{{ $order->receiver_address }}</p>
                        <p class="mb-0">{{ $order->receiver_ward }}, {{ $order->receiver_district }},
                            {{ $order->receiver_province }}</p>
                    </div>
                </div>

                <!-- Order Summary -->
                <div class="card mt-4">
                    <div class="card-header">
                        <h4 class="card-title">Tóm tắt đơn hàng</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table mb-0">
                                <tbody>
                                    <tr>
                                        <td class="px-0">Tạm tính:</td>
                                        <td class="text-end fw-medium">{{ number_format($order->subtotal) }} ₫</td>
                                    </tr>
                                    <tr>
                                        <td class="px-0">Giảm giá (voucher):</td>
                                        <td class="text-end text-danger fw-medium">
                                            -{{ number_format($order->discount_amount) }} ₫</td>
                                    </tr>
                                    <tr>
                                        <td class="px-0">Phí vận chuyển:</td>
                                        <td class="text-end fw-medium">{{ number_format($order->shipping_fee) }} ₫</td>
                                    </tr>
                                    <tr>
                                        <td class="px-0">Thuế (nếu có):</td>
                                        <td class="text-end fw-medium">0 ₫</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer d-flex justify-content-between bg-light-subtle">
                        <h5 class="fw-medium mb-0">Tổng tiền:</h5>
                        <h5 class="fw-medium mb-0 text-primary">{{ number_format($order->total_amount) }} ₫</h5>
                    </div>
                </div>

                <!-- Thông tin khách hàng -->
                <div class="card mt-4">
                    <div class="card-header">
                        <h4 class="card-title mb-0">Thông tin khách hàng</h4>
                    </div>
                    <div class="card-body">
                        @if ($order->payment_method === 'cod')
                            <div class="d-flex align-items-center gap-3 mb-3">
                                <div class="avatar bg-light rounded d-flex align-items-center justify-content-center">
                                    <iconify-icon icon="solar:hand-money-bold-duotone"
                                        class="fs-35 text-primary"></iconify-icon>
                                </div>
                                <div>
                                    <p class="mb-1 fw-medium">{{ $order->payment_method_label }}</p>
                                    <p class="mb-0 text-success fw-medium">{{ $order->payment_status_label }}</p>
                                </div>
                            </div>
                        @else
                            <div class="d-flex align-items-center gap-3 mb-3">
                                <div class="avatar bg-light rounded d-flex align-items-center justify-content-center">
                                    <iconify-icon icon="solar:card-send-bold-duotone"
                                        class="fs-35 text-primary"></iconify-icon>
                                </div>
                                <div>
                                    <p class="mb-1 fw-medium">{{ $order->payment_method_label }}</p>
                                    <p class="mb-0 text-success fw-medium">{{ $order->payment_status_label }}</p>
                                </div>
                            </div>
                        @endif

                        <p class="mb-1">Mã giao dịch: <span
                                class="fw-medium">{{ $order->payments->first()?->transaction_id ?? 'N/A' }}</span></p>
                        <p class="mb-0">Thời gian thanh toán: <span
                                class="fw-medium">{{ $order->payments->first()?->paid_at?->format('d/m/Y H:i') ?? 'Chưa thanh toán' }}</span>
                        </p>
                    </div>
                </div>
            </div>
        @endsection
