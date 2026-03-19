@extends('admin.layouts.layout')

@section('content')
    {{-- <div class="page-content"> --}}
        <!-- Start Container -->
        <div class="container-xxl">

            <div class="row">
                <div class="col-xl-9 col-lg-8">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
                                        <div>
                                            <h4 class="fw-medium text-dark d-flex align-items-center gap-2">
                                                {{ $order->order_code }}
                                                <span class="badge bg-{{ $order->payment_status === 'paid' ? 'success' : 'warning' }} px-2 py-1 fs-13">
                                                    {{ ucfirst($order->payment_status) }}
                                                </span>
                                                <span class="badge border border-{{ 
                                                    $order->status === 'delivered' ? 'success' : 
                                                    ($order->status === 'cancelled' ? 'danger' : 'warning')
                                                }} text-{{ 
                                                    $order->status === 'delivered' ? 'success' : 
                                                    ($order->status === 'cancelled' ? 'danger' : 'warning')
                                                }} px-2 py-1 fs-13">
                                                    {{ ucfirst($order->status) }}
                                                </span>
                                            </h4>
                                            <p class="mb-0 text-muted">
                                                Đơn hàng / Chi tiết đơn hàng / {{ $order->order_code }} - 
                                                {{ $order->created_at->format('d/m/Y \l\ú\c H:i') }}
                                            </p>
                                        </div>
                                        <div class="d-flex gap-2 flex-wrap">
                                            @if ($order->payment_status === 'paid')
                                                <a href="#" class="btn btn-outline-danger btn-sm">Hoàn tiền</a>
                                            @endif
                                            @if ($order->status !== 'delivered' && $order->status !== 'cancelled')
                                                <a href="#" class="btn btn-outline-secondary btn-sm">Trả hàng</a>
                                            @endif
                                            {{-- <a href="{{ route('admin.orders.edit', $order) }}" class="btn btn-primary btn-sm">Chỉnh sửa đơn</a> --}}
                                        </div>
                                    </div>

                                    <!-- Tiến độ đơn hàng -->
                                    <div class="mt-4">
                                        <h5 class="fw-medium text-dark">Tiến độ đơn hàng</h5>
                                        <div class="row row-cols-xxl-5 row-cols-md-2 row-cols-1 mt-3 g-3">
                                            <div class="col">
                                                <div class="progress" style="height: 10px;">
                                                    <div class="progress-bar bg-success progress-bar-striped progress-bar-animated" role="progressbar" 
                                                         style="width: {{ $order->status === 'pending' ? '100' : '100' }}%" aria-valuenow="100"></div>
                                                </div>
                                                <p class="mb-0 mt-2 text-center">Xác nhận</p>
                                            </div>
                                            <div class="col">
                                                <div class="progress" style="height: 10px;">
                                                    <div class="progress-bar bg-success progress-bar-striped progress-bar-animated" role="progressbar" 
                                                         style="width: {{ in_array($order->status, ['confirmed', 'processing', 'shipped', 'delivered']) ? '100' : '0' }}%"></div>
                                                </div>
                                                <p class="mb-0 mt-2 text-center">Đã thanh toán</p>
                                            </div>
                                            <div class="col">
                                                <div class="progress" style="height: 10px;">
                                                    <div class="progress-bar bg-{{ $order->status === 'processing' ? 'warning' : 'primary' }} progress-bar-striped progress-bar-animated" role="progressbar" 
                                                         style="width: {{ $order->status === 'processing' ? '60' : ($order->status === 'shipped' || $order->status === 'delivered' ? '100' : '0') }}%"></div>
                                                </div>
                                                <p class="mb-0 mt-2 text-center {{ $order->status === 'processing' ? 'text-warning' : '' }}">Xử lý</p>
                                            </div>
                                            <div class="col">
                                                <div class="progress" style="height: 10px;">
                                                    <div class="progress-bar bg-primary progress-bar-striped progress-bar-animated" role="progressbar" 
                                                         style="width: {{ $order->status === 'shipped' || $order->status === 'delivered' ? '100' : '0' }}%"></div>
                                                </div>
                                                <p class="mb-0 mt-2 text-center">Giao hàng</p>
                                            </div>
                                            <div class="col">
                                                <div class="progress" style="height: 10px;">
                                                    <div class="progress-bar bg-success progress-bar-striped progress-bar-animated" role="progressbar" 
                                                         style="width: {{ $order->status === 'delivered' ? '100' : '0' }}%"></div>
                                                </div>
                                                <p class="mb-0 mt-2 text-center">Đã giao</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Footer card với ngày giao dự kiến -->
                                <div class="card-footer d-flex flex-wrap align-items-center justify-content-between bg-light-subtle gap-3">
                                    <p class="border rounded mb-0 px-3 py-2 bg-body">
                                        <i class='bx bx-calendar-check align-middle fs-16'></i> 
                                        Ngày giao dự kiến: <span class="text-dark fw-medium">{{ $order->estimated_delivery ?? 'Chưa xác định' }}</span>
                                    </p>
                                    @if ($order->status === 'processing')
                                        <a href="#" class="btn btn-primary">Đánh dấu sẵn sàng giao</a>
                                    @endif
                                </div>
                            </div>

                            <!-- Danh sách sản phẩm -->
                            <div class="card mt-4">
                                <div class="card-header">
                                    <h4 class="card-title">Sản phẩm trong đơn</h4>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table align-middle mb-0 table-hover table-centered">
                                            <thead class="bg-light-subtle border-bottom">
                                                <tr>
                                                    <th>Sản phẩm & Phân loại</th>
                                                    {{-- <th>Trạng thái</th> --}}
                                                    <th>Số lượng</th>
                                                    <th>Giá</th>
                                                    <th>Thành tiền</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse ($order->items as $item)
                                                    <tr>
                                                        <td>
    <div class="d-flex align-items-center gap-3">
        
        <!-- KHUNG ẢNH -->
        <div class="rounded bg-light avatar-md d-flex align-items-center justify-content-center overflow-hidden">
           <img 
    src="{{ 
        $item->variant?->images->first()?->image 
            ? asset('storage/' . $item->variant->images->first()->image) 
            : asset('assets/images/product/placeholder.png') 
    }}" 
    class="w-100 h-100 object-fit-cover">
        </div>

        <div>
            <a href="#" class="text-dark fw-medium fs-15">
                {{ $item->variant->product->name ?? 'Sản phẩm không còn' }}
            </a>
            <p class="text-muted mb-0 mt-1 fs-13">
                Màu: {{ $item->variant->color->name ?? '-' }} | 
                Size: {{ $item->variant->size->name ?? '-' }}
            </p>
        </div>
    </div>
</td>
                                                        {{-- <td>
                                                            <span class="badge bg-{{ rand(0,1) ? 'success-subtle text-success' : 'warning text-dark' }} px-2 py-1 fs-13">
                                                                {{ rand(0,1) ? 'Sẵn sàng' : 'Đang đóng gói' }}
                                                            </span>
                                                        </td> --}}
                                                        <td>{{ $item->quantity }}</td>
                                                        <td>{{ number_format($item->price) }} ₫</td>
                                                        <td class="fw-medium">{{ number_format($item->subtotal) }} ₫</td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="5" class="text-center py-4">Không có sản phẩm trong đơn hàng.</td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <!-- Timeline (lịch sử trạng thái) -->
                            <div class="card mt-4">
                                <div class="card-header">
                                    <h4 class="card-title">Lịch sử đơn hàng</h4>
                                </div>
                                <div class="card-body">
                                    <div class="position-relative ms-2">
                                        <span class="position-absolute start-0 top-0 border border-dashed h-100" style="width: 2px;"></span>
                                        @forelse ($order->status_histories ?? [] as $history)
                                            <div class="position-relative ps-4 mb-4">
                                                <span class="position-absolute start-0 avatar-sm translate-middle-x bg-light d-inline-flex align-items-center justify-content-center rounded-circle">
                                                    <iconify-icon icon="solar:check-circle-bold-duotone" class="fs-20 text-success"></iconify-icon>
                                                </span>
                                                <div class="ms-2">
                                                    <h5 class="mb-1 text-dark fw-medium fs-15">{{ $history->to_status ?? 'Trạng thái cập nhật' }}</h5>
                                                    <p class="mb-0 text-muted">Cập nhật bởi: {{ $history->changed_by ?? 'Admin' }}</p>
                                                    <p class="mb-0 text-muted small">{{ $history->created_at->format('d/m/Y H:i') }}</p>
                                                </div>
                                            </div>
                                        @empty
                                            <p class="text-center text-muted">Chưa có lịch sử cập nhật trạng thái.</p>
                                        @endforelse
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sidebar bên phải: Summary, Payment, Customer -->
                <div class="col-xl-3 col-lg-4">
                    <!-- Order Summary -->
                    <div class="card">
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
                                            <td class="text-end text-danger fw-medium">-{{ number_format($order->discount_amount) }} ₫</td>
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

                    <!-- Payment Information -->
                    <div class="card mt-4">
                        <div class="card-header">
                            <h4 class="card-title">Thông tin thanh toán</h4>
                        </div>
                        <div class="card-body">
                            @if ($order->payment_method === 'cod')
                                <div class="d-flex align-items-center gap-3 mb-3">
                                    <div class="avatar bg-light rounded d-flex align-items-center justify-content-center">
                                        <iconify-icon icon="solar:hand-money-bold-duotone" class="fs-35 text-primary"></iconify-icon>
                                    </div>
                                    <div>
                                        <p class="mb-1 fw-medium">Thanh toán khi nhận hàng (COD)</p>
                                        <p class="mb-0 text-success fw-medium">{{ ucfirst($order->payment_status) }}</p>
                                    </div>
                                </div>
                            @else
                                <!-- Nếu có thanh toán online, hiển thị thẻ -->
                            @endif

                            <p class="mb-1">Mã giao dịch: <span class="fw-medium">{{ $order->payments->first()?->transaction_id ?? 'N/A' }}</span></p>
                            <p class="mb-0">Thời gian thanh toán: <span class="fw-medium">{{ $order->payments->first()?->paid_at?->format('d/m/Y H:i') ?? 'Chưa thanh toán' }}</span></p>
                        </div>
                    </div>

                    <!-- Customer Details -->
                    <div class="card mt-4">
                        <div class="card-header">
                            <h4 class="card-title">Thông tin khách hàng</h4>
                        </div>
                        <div class="card-body">
                            <div class="d-flex align-items-center gap-3 mb-3">
                                <div class="avatar rounded-circle border border-light">
                                    <img src="{{ asset('assets/images/users/avatar-1.jpg') }}" alt="" class="avatar-img">
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
                            <p class="mb-0">{{ $order->receiver_ward }}, {{ $order->receiver_district }}, {{ $order->receiver_province }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <footer class="footer">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 text-center">
                        <script>document.write(new Date().getFullYear())</script> © Krean Admin. All rights reserved.
                    </div>
                </div>
            </div>
        </footer>
    </div>
@endsection