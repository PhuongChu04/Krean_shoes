@extends('admin.layouts.layout')

@section('content')
    <div class="container-xxl">

        <div class="row">
            <!-- Nội dung chính -->
            <div class="col-xl-9 col-lg-8">
                <div class="card">
                    <div class="card-body">

                        <!-- Header -->
                        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4">
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
                        </div>

                        <!-- ==================== CHỈNH TRẠNG THÁI ĐƠN HÀNG ==================== -->
                        <div class="border rounded-3 p-4 bg-light-subtle mb-4">
                            <h5 class="fw-medium mb-3">Cập nhật trạng thái đơn hàng</h5>
                            
                            <form action="{{ route('admin.order.status', $order->id) }}" method="POST">
                                @csrf

                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label fw-medium">Trạng thái hiện tại</label>
                                        <p class="form-control-static fw-bold fs-5">
                                            {{ ucfirst($order->status) }}
                                        </p>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label fw-medium">Đổi sang trạng thái mới</label>
                                        <select name="status" class="form-select form-select-lg">
                                            <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>
                                                Pending - Chờ xác nhận
                                            </option>
                                            <option value="confirmed" {{ $order->status == 'confirmed' ? 'selected' : '' }}>
                                                Confirmed - Đã xác nhận
                                            </option>
                                            <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>
                                                Processing - Đang xử lý
                                            </option>
                                            <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>
                                                Shipped - Đang giao hàng
                                            </option>
                                            <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>
                                                Delivered - Đã giao thành công
                                            </option>
                                            <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }} class="text-danger">
                                                Cancelled - Đã hủy
                                            </option>
                                        </select>
                                    </div>
                                </div>

                                <div class="mt-4">
                                    <button type="submit" class="btn btn-primary btn-lg px-5">
                                        <i class="ri-save-line me-2"></i> Cập nhật trạng thái
                                    </button>
                                </div>
                            </form>
                        </div>
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
                                                                class="rounded" style="width: 60px; height: 60px; object-fit: cover;">
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
                                                    <td class="text-end fw-bold">{{ number_format($item->subtotal) }} ₫</td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="5" class="text-center py-4 text-muted">Không có sản phẩm trong đơn hàng.</td>
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

            <!-- Sidebar bên phải -->
            <div class="col-xl-3 col-lg-4">
                <!-- Tóm tắt đơn hàng -->
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title mb-0">Tóm tắt đơn hàng</h4>
                    </div>
                    <div class="card-body">
                        <table class="table table-borderless mb-0">
                            <tr>
                                <td>Tạm tính:</td>
                                <td class="text-end">{{ number_format($order->subtotal ?? 0) }} ₫</td>
                            </tr>
                            <tr>
                                <td>Giảm giá:</td>
                                <td class="text-end text-danger">-{{ number_format($order->discount_amount ?? 0) }} ₫</td>
                            </tr>
                            <tr>
                                <td>Phí vận chuyển:</td>
                                <td class="text-end">{{ number_format($order->shipping_fee ?? 0) }} ₫</td>
                            </tr>
                            <tr class="border-top">
                                <td class="fw-bold">Tổng tiền:</td>
                                <td class="text-end fw-bold text-primary fs-5">
                                    {{ number_format($order->total_amount) }} ₫
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>

                <!-- Thông tin khách hàng -->
                <div class="card mt-4">
                    <div class="card-header">
                        <h4 class="card-title mb-0">Thông tin khách hàng</h4>
                    </div>
                    <div class="card-body">
                        <p><strong>Tên người nhận:</strong> {{ $order->receiver_name }}</p>
                        <p><strong>Số điện thoại:</strong> {{ $order->receiver_phone }}</p>
                        <p><strong>Địa chỉ:</strong> {{ $order->receiver_address }}</p>
                        <p>{{ $order->receiver_ward }}, {{ $order->receiver_district }}, {{ $order->receiver_province }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection