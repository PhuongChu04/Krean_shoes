@extends('client.layout.layout')

@section('content')
    <div class="flat-spacing-13">
        <div class="container-7">
            <div class="main-content-account">
                @include('client.layout.sidebar')

                <div class="my-acount-content account-orders">
                    <div class="account-orders-wrap">
                        <h5 class="title">Chi tiết đơn hàng</h5>

                        {{-- ===== THÔNG TIN ĐƠN HÀNG ===== --}}
                        <div class="card mb-4 p-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <h6>Đơn hàng: {{ $order->order_code }}</h6>
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
                                    $badgeColor = $statusColorMap[$order->status] ?? 'secondary';
                                    $statusLabel = $statusLabelMap[$order->status] ?? ucfirst($order->status);
                                @endphp
                                <span class="badge bg-{{ $badgeColor }}">{{ $statusLabel }}</span>
                            </div>
                            <p class="mb-1 mt-2">
                                Ngày đặt: {{ $order->created_at->format('d/m/Y H:i') }} <br>
                                Thanh toán: <b>{{ $order->payment_method_label }}</b> <br>
                                Trạng thái thanh toán: <b>{{ $order->payment_status_label }}</b>
                            </p>
                            <p class="mb-1">Người nhận: {{ $order->receiver_name }} - {{ $order->receiver_phone }}</p>
                            <p class="mb-1">Địa chỉ: {{ $order->full_address }}</p>
                            @if ($order->note)
                                <p class="mb-1">Ghi chú: {{ $order->note }}</p>
                            @endif
                            @if ($order->voucher)
                                <p class="mb-0">Voucher: {{ $order->voucher->code }}
                                    ({{ $order->voucher->description ?? '--' }})</p>
                            @endif

                            {{-- Nút Thanh Toán Lại (chỉ hiển thị khi điều kiện đủ) --}}
                            @if ($canRetryPayment)
                                <div class="mt-3">
                                    <form action="{{ route('client.orders.retry-payment', $order) }}" method="POST" style="display: inline;">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-warning">
                                            <i class="bx bx-refresh"></i> Thanh Toán Lại
                                        </button>
                                    </form>
                                    <small class="text-muted ms-2">
                                        <i class="bx bx-info-circle"></i>
                                        Đơn hàng chưa thanh toán. Bạn có thể thanh toán lại qua VNPay.
                                    </small>
                                </div>
                            @endif
                        </div>

                        {{-- ===== CHI TIẾT SẢN PHẨM ===== --}}
                        {{-- ===== CHI TIẾT SẢN PHẨM ===== --}}
                        <div class="card mb-4 p-3">
                            <h6 class="mb-3">Chi tiết sản phẩm</h6>

                            <div class="order-items-list">
                                @foreach ($order->items as $item)
                                    @php
                                        // Dữ liệu snapshot ưu tiên
                                        $productName =
                                            $item->product_name ??
                                            ($item->variant?->product?->name ?? 'Sản phẩm đã bị xóa');

                                        $sizeName = $item->size_name ?? ($item->variant?->size?->name ?? 'N/A');
                                        $colorName = $item->color_name ?? ($item->variant?->color?->name ?? 'N/A');

                                        $imgSrc = $item->image_url;

                                        // Trạng thái
                                        $variantDeleted = $item->variant && !is_null($item->variant->deleted_at);
                                        $isOutOfStock = $item->variant && $item->variant->stock <= 0;
                                        $productExists = $item->variant?->product !== null;

                                        $hasOtherActiveVariants = false;
                                        if ($productExists) {
                                            $hasOtherActiveVariants = $item->variant->product
                                                ->variants()
                                                ->whereNull('deleted_at')
                                                ->where('stock', '>', 0)
                                                ->where('id', '!=', optional($item->variant)->id)
                                                ->exists();
                                        }

                                        // Xác định badge
                                        if ($variantDeleted) {
                                            if ($hasOtherActiveVariants) {
                                                $badgeText = 'Hết hàng';
                                                $badgeClass = 'bg-warning text-dark';
                                                $rowClass = 'order-item--outofstock';
                                            } else {
                                                $badgeText = 'Ngừng kinh doanh';
                                                $badgeClass = 'bg-secondary';
                                                $rowClass = 'order-item--discontinued';
                                            }
                                        } elseif ($isOutOfStock) {
                                            $badgeText = 'Hết hàng';
                                            $badgeClass = 'bg-warning text-dark';
                                            $rowClass = 'order-item--outofstock';
                                        } else {
                                            $badgeText = $badgeClass = $rowClass = '';
                                        }

                                       if (!$productExists) {
    $badgeText  = 'Ngừng kinh doanh';
    $badgeClass = 'bg-secondary';
    $rowClass   = 'order-item--discontinued';
} elseif ($variantDeleted || $isOutOfStock) {
    // Kiểm tra còn variant nào còn hàng không
    $hasOtherInStock = $item->variant->product
        ->variants()
        ->whereNull('deleted_at')
        ->where('stock', '>', 0)
        ->exists();

    if ($hasOtherInStock) {
        $badgeText  = 'Hết hàng';
        $badgeClass = 'bg-warning text-dark';
        $rowClass   = 'order-item--outofstock';
    } else {
        $badgeText  = 'Ngừng kinh doanh';
        $badgeClass = 'bg-secondary';
        $rowClass   = 'order-item--discontinued';
    }
} else {
    $badgeText = $badgeClass = $rowClass = '';
}

$productLink = ($productExists && $rowClass !== 'order-item--discontinued')
    ? route('client.product.detail', $item->variant->product->slug)
    : null;
                                    @endphp


                                    <div
                                        class="order-item-row d-flex align-items-start gap-3 py-3 border-bottom {{ $rowClass }}">

                                        <!-- Ảnh -->
                                        <div class="position-relative flex-shrink-0">
                                            <img src="{{ $imgSrc }}" alt="{{ $productName }}" width="90"
                                                height="90"
                                                class="rounded border object-fit-cover {{ $rowClass ? 'opacity-75' : '' }}">

                                            @if ($badgeText)
                                                <span
                                                    class="position-absolute bottom-0 start-0 end-0 text-center text-white {{ $badgeClass }}"
                                                    style="font-size:10px; padding:3px 0; border-radius:0 0 4px 4px;">
                                                    {{ $badgeText }}
                                                </span>
                                            @endif
                                        </div>

                                        <!-- Thông tin chi tiết -->
                                        <div class="flex-grow-1">
                                            <div class="d-flex justify-content-between align-items-start flex-wrap gap-3">
                                                <div class="flex-grow-1">
                                                    <!-- Tên sản phẩm -->
                                                    <h6 class="mb-2">
                                                        @if ($productLink)
                                                            <a href="{{ $productLink }}"
                                                                class="text-dark text-decoration-none">
                                                                {{ $productName }}
                                                            </a>
                                                        @else
                                                            <span class="{{ $variantDeleted ? 'text-muted' : '' }}">
                                                                {{ $productName }}
                                                            </span>
                                                        @endif
                                                    </h6>
                                                    <!-- Size & Color -->
                                                    <div class="mb-2">
                                                        <small class="text-muted">
                                                            <strong>Màu:</strong> {{ $colorName }} &nbsp;&nbsp;
                                                            <strong>Size:</strong> {{ $sizeName }}
                                                        </small>
                                                    </div class="mb-2">
                                                    {{-- <small class="text-muted">
                                    <strong>Giá:</strong>{{ number_format($item->price, 0, ',', '.') }} &nbsp;&nbsp; 
                                    <strong>Số lượng:</strong>{{ $item->quantity }} <br>
                                </small> --}}
                                                    {{-- <tr>
                                    <td>Giá:<div class="fw-semibold"> {{ number_format($item->price, 0, ',', '.') }} ₫</div></td>
                                    <td><small class="text-muted">Số lượng: {{ $item->quantity }}</small></td>
                                </tr><br> --}}

                                                    <!-- Badge -->
                                                    {{-- @if ($badgeText)
                                <span class="badge {{ $badgeClass }} fs-6">{{ $badgeText }}</span>
                            @endif --}}
                                                </div>

                                                <!-- Giá + Số lượng -->
                                                <div class="text-end text-nowrap">
                                                    <div class=""> Giá:<em
                                                            class="fw-semibold fs-6">{{ number_format($item->price, 0, ',', '.') }}
                                                            ₫</em> </div>
                                                    <small class="">Số lượng: <em
                                                            class="fw-semibold fs-6">{{ $item->quantity }}</em></small>
                                                    <div class="fw-bold text-primary mt-1">
                                                        Tổng: <em
                                                            class="fw-semibold fs-6">{{ number_format($item->price * $item->quantity, 0, ',', '.') }}
                                                            ₫</em>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        {{-- ===== TỔNG TIỀN ===== --}}
                        <div class="card p-3 mb-4">
                            <div class="row py-1">
                                <div class="col-6 text-muted">Tạm tính</div>
                                <div class="col-6 text-end">{{ number_format($order->subtotal, 0, ',', '.') }} ₫</div>
                            </div>
                            <div class="row py-1">
                                <div class="col-6 text-muted">Giảm giá</div>
                                <div class="col-6 text-end text-danger">
                                    -{{ number_format($order->discount_amount, 0, ',', '.') }} ₫
                                </div>
                            </div>
                            <div class="row py-1">
                                <div class="col-6 text-muted">Phí vận chuyển</div>
                                <div class="col-6 text-end">{{ number_format($order->shipping_fee, 0, ',', '.') }} ₫</div>
                            </div>
                            <hr class="my-2" />
                            <div class="row fw-bold">
                                <div class="col-6">Tổng cộng</div>
                                <div class="col-6 text-end text-primary fs-6">
                                    {{ number_format($order->total_amount, 0, ',', '.') }} ₫
                                </div>
                            </div>
                        </div>

                        {{-- ===== NÚT QUAY LẠI ===== --}}
                        <div class="mb-3">
                            <a href="{{ route('client.orders.index') }}" class="tf-btn animate-btn bg-light-2">← Quay lại
                                đơn hàng</a>
                        </div>

                        {{-- ===== FORM ĐÁNH GIÁ (chỉ hiện khi đã giao & chưa đánh giá) ===== --}}
                        @if (isset($canReview) && $canReview)
                            <div class="card mt-4">
                                <div class="card-header bg-light">
                                    <h5 class="mb-0">Đánh giá sản phẩm đã nhận</h5>
                                </div>
                                <div class="card-body">
                                    @foreach ($order->items as $item)
                                        @php
                                            $reviewStatus = $item->availability_status ?? 'available';
                                            // Chỉ cho đánh giá nếu variant vẫn còn (chưa xóa cứng)
                                            $canReviewItem = $item->variant !== null && !$item->review;
                                        @endphp

                                        @if ($canReviewItem)
                                            <form action="{{ route('client.reviews.store') }}" method="POST"
                                                class="border rounded p-4 mb-4">
                                                @csrf
                                                <input type="hidden" name="order_item_id" value="{{ $item->id }}">
                                                <input type="hidden" name="product_variant_id"
                                                    value="{{ $item->product_variant_id ?? $item->variant->id }}">

                                                <div class="d-flex gap-3 mb-3">
                                                    @php
                                                        // Ảnh review: snapshot product_image → thumbnail variant → ảnh mặc định
                                                        $reviewImg = null;
                                                        if ($item->product_image) {
                                                            $rp = $item->product_image;
                                                            $reviewImg =
                                                                str_starts_with($rp, 'http') ||
                                                                str_starts_with($rp, '/storage/')
                                                                    ? $rp
                                                                    : Storage::url($rp);
                                                        } elseif ($item->variant?->product?->thumbnail) {
                                                            $reviewImg = Storage::url(
                                                                $item->variant->product->thumbnail,
                                                            );
                                                        } else {
                                                            $reviewImg = asset('images/no-image.png');
                                                        }
                                                    @endphp
                                                    <img src="{{ $reviewImg }}"
                                                        style="width:70px;height:70px;object-fit:cover;border-radius:8px;"
                                                        alt="">
                                                    <div>
                                                        <strong>{{ $item->variant->product->name ?? $item->product_name }}</strong><br>
                                                        <small class="text-muted">
                                                            Màu: {{ $item->variant->color?->name ?? '—' }} |
                                                            Size: {{ $item->variant->size?->name ?? '—' }}
                                                        </small>
                                                        @if ($reviewStatus === 'out_of_stock')
                                                            <span class="badge bg-warning text-dark ms-2">Hết hàng</span>
                                                        @elseif ($reviewStatus === 'discontinued')
                                                            <span class="badge bg-secondary ms-2">Ngừng kinh doanh</span>
                                                        @endif
                                                    </div>
                                                </div>

                                                <div class="mb-3">
                                                    <label class="form-label">Đánh giá sao</label>
                                                    <select name="rating" class="form-select w-50" required>
                                                        <option value="5">5 sao - Tuyệt vời</option>
                                                        <option value="4">4 sao - Tốt</option>
                                                        <option value="3">3 sao - Bình thường</option>
                                                        <option value="2">2 sao - Không hài lòng</option>
                                                        <option value="1">1 sao - Rất tệ</option>
                                                    </select>
                                                </div>

                                                <div class="mb-3">
                                                    <label class="form-label">Tiêu đề đánh giá</label>
                                                    <input type="text" name="title" class="form-control"
                                                        placeholder="Tiêu đề ngắn gọn" required>
                                                </div>

                                                <div class="mb-4">
                                                    <label class="form-label">Nhận xét chi tiết</label>
                                                    <textarea name="content" class="form-control" rows="4" placeholder="Viết nhận xét của bạn..." required></textarea>
                                                </div>

                                                <button type="submit" class="btn btn-primary">Gửi đánh giá</button>
                                            </form>
                                        @else
                                            {{-- Sản phẩm bị xóa cứng → không thể đánh giá --}}
                                            <div
                                                class="border rounded p-3 mb-3 bg-light text-muted d-flex align-items-center gap-3">
                                                <i class="ri-error-warning-line fs-5"></i>
                                                <span>
                                                    <strong>{{ $item->product_name }}</strong> —
                                                    Sản phẩm này không còn tồn tại, không thể gửi đánh giá.
                                                </span>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- CSS cho item không khả dụng --}}
    <style>
        <style>.order-item--discontinued,
        .order-item--outofstock {
            background-color: #f8f9fa;
            opacity: 0.95;
        }

        .order-item--discontinued h6,
        .order-item--outofstock h6 {
            color: #6c757d !important;
        }

        .order-item--unavailable {
            background-color: #f9f9f9;
            border-radius: 6px;
        }

        .order-item--unavailable h6,
        .order-item--unavailable small {
            color: #999 !important;
        }
    </style>
@endsection
