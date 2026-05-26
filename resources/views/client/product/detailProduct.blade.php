@extends('client.layout.layout')

@section('content')

    <!-- Breadcrumb -->
    <div class="breadcrumb-sec">
        <div class="container">
            <div class="breadcrumb-wrap">
                <div class="breadcrumb-list">
                    <a class="breadcrumb-item" href="{{ route('client.homeClient') }}">Trang chủ</a>
                    <div class="breadcrumb-item dot"><span></span></div>
                    <a class="breadcrumb-item" href="{{ route('shop.index') }}">Cửa hàng</a>
                    <div class="breadcrumb-item dot"><span></span></div>
                    @if ($product->category)
                        <a class="breadcrumb-item" href="{{ route('shop.index') }}?category={{ $product->category->id }}">
                            {{ $product->category->name }}
                        </a>
                        <div class="breadcrumb-item dot"><span></span></div>
                    @endif
                    <div class="breadcrumb-item current">{{ $product->name }}</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Product Main -->
    <section class="flat-single-product">
        <div class="tf-main-product section-image-zoom">
            <div class="container">
                <div class="row">

                    <!-- Images -->
                    <div class="col-md-6">
                        <div class="tf-product-media-wrap sticky-top row gx-3">

                            <!-- Thumbs -->
                            <div class="col-3 thumbs-column">
                                <div class="product-thumbs-list d-flex flex-column gap-2" id="thumbs-container">
                                    @if ($product->thumbnail)
                                        <div class="thumb-item active"
                                            data-main-image="{{ Storage::url($product->thumbnail) }}">
                                            <img class="lazyload img-fluid"
                                                data-src="{{ Storage::url($product->thumbnail) }}"
                                                src="{{ Storage::url($product->thumbnail) }}" alt="{{ $product->name }}">
                                        </div>
                                    @endif

                                    @foreach ($product->variants as $variant)
                                        @foreach ($variant->images as $img)
                                            @php
                                                $imgPath = Storage::url($img->image);
                                                if (
                                                    $product->thumbnail &&
                                                    $imgPath === Storage::url($product->thumbnail)
                                                ) {
                                                    continue;
                                                }
                                            @endphp
                                            <div class="thumb-item" data-color="{{ $variant->color?->name ?? 'default' }}"
                                                data-variant-id="{{ $variant->id }}"
                                                data-main-image="{{ $imgPath }}">
                                                <img class="lazyload img-fluid" data-src="{{ $imgPath }}"
                                                    src="{{ $imgPath }}" alt="{{ $product->name }}">
                                            </div>
                                        @endforeach
                                    @endforeach
                                </div>
                            </div>

                            <!-- Main Image -->
                            <div class="col-9 main-image-column">
                                <div class="main-image-wrap">
                                    <a href="#" id="main-image-link" class="item">
                                        <img class="tf-image-zoom lazyload img-fluid w-100" id="main-image"
                                            src="{{ $product->thumbnail ? Storage::url($product->thumbnail) : asset('images/no-image.jpg') }}"
                                            alt="{{ $product->name }}">
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Product Info -->
                    <div class="col-md-6">
                        <div class="tf-product-info-wrap">
                            <div class="tf-product-info-list">

                                <h3 class="fw-medium mb-2">{{ $product->name }}</h3>

                                <!-- Đánh giá trung bình -->
                                <div class="product-rate mb-3 d-flex align-items-center gap-2">
                                    <!-- Hiển thị sao -->
                                    <div class="d-flex gap-1 text-warning" style="font-size: 1.35rem;">
                                        @for ($i = 1; $i <= 5; $i++)
                                            @if ($i <= floor($avgRating))
                                                <i class="icon icon-star"></i>
                                            @elseif($i == ceil($avgRating) && $avgRating != floor($avgRating))
                                                <i class="icon icon-star-half"></i>
                                            @else
                                                <i class="icon icon-star"></i>
                                            @endif
                                        @endfor
                                    </div>

                                    <!-- Điểm số + Tổng đánh giá -->
                                    <div class="d-flex align-items-center gap-2">
                                        <span class="fw-bold fs-5 text-dark">{{ number_format($avgRating, 1) }}</span>
                                        <span class="text-muted small">
                                            ({{ $reviews->total() ?? 0 }} đánh giá)
                                        </span>
                                    </div>
                                </div>
                                <div class="product-progress-sale mt-2">
                                    <p class="text-avaiable text-sm">
                                        Còn lại:
                                        <span id="stock-display"
                                            class="fw-medium {{ $totalStock > 10 ? 'text-success' : 'text-danger' }}">
                                            {{ $totalStock }}
                                        </span>
                                        <span id="stock-unit" class="text-muted">sản phẩm</span>
                                    </p>
                                </div>

                                <div class="product-price mb-4">
                                    <span class="price-new fs-4 fw-bold" id="display-price">
                                        {{ number_format($minPrice) }} ₫
                                    </span>
                                    {{-- @if ($maxPrice > $minPrice)
                                        <span class="price-old ms-2">{{ number_format($maxPrice) }} ₫</span>
                                    @endif --}}
                                </div>

                                <!-- Size -->
                                <div class="mb-4">
                                    <label class="form-label fw-medium">Kích thước</label>
                                    <div class="d-flex flex-wrap gap-2" id="size-options">
                                        @foreach ($availableSizes as $size)
                                            <button type="button" class="btn btn-outline-secondary size-btn px-4 py-2"
                                                data-size-id="{{ $size->id }}">
                                                {{ $size->name }}
                                            </button>
                                        @endforeach
                                    </div>
                                </div>

                                <!-- Color -->
                                <div class="mb-4">
                                    <label class="form-label fw-medium">Màu sắc</label>
                                    <div class="d-flex flex-wrap gap-3" id="color-options">
                                        @foreach ($availableColors as $color)
                                            <button type="button" class="color-btn rounded-circle border border-2"
                                                style="background-color: {{ $color->code ?? '#000000' }}; width: 42px; height: 42px;"
                                                data-color-id="{{ $color->id }}" title="{{ $color->name }}"></button>
                                        @endforeach
                                    </div>
                                </div>

                                <!-- Quantity + Add to Cart -->
                                <div class="d-flex align-items-center gap-4 mt-4">
                                    <div class="wg-quantity">
                                        <button type="button" class="btn-quantity minus-btn">−</button>

    <input type="text" class="quantity-product" value="1" readonly>

    <button type="button" class="btn-quantity plus-btn">+</button>
                                        
                                    </div>

                                    <button type="button" id="add-to-cart-btn"
                                        class="tf-btn style-2 fw-6 animate-btn flex-fill">
                                        <i class="icon icon-cart"></i> Thêm vào giỏ hàng
                                    </button>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Mô tả -->
    <section class="flat-spacing pt-0">
        <div class="container">
            <div class="widget-accordion wd-product-descriptions">
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse"
                            data-bs-target="#description">
                            Mô tả sản phẩm
                        </button>
                    </h2>
                    <div id="description" class="accordion-collapse collapse show">
                        <div class="accordion-body">
                            {!! $product->description ?? '<p>Chưa có mô tả chi tiết cho sản phẩm này.</p>' !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ==================== PHẦN ĐÁNH GIÁ SẢN PHẨM ==================== -->
    <!-- ==================== PHẦN ĐÁNH GIÁ SẢN PHẨM ==================== -->
    <section class="flat-spacing pt-0">
        <div class="container">
            <div class="widget-accordion wd-product-reviews">
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse"
                            data-bs-target="#reviews">
                            Đánh giá từ khách hàng
                            <span class="ms-2 badge bg-primary">{{ $reviews->total() ?? 0 }}</span>
                        </button>
                    </h2>
                    <div id="reviews" class="accordion-collapse collapse show">
                        <div class="accordion-body">

                            @if ($reviews->isEmpty())
                                <div class="text-center py-5 text-muted">
                                    <p>Sản phẩm này chưa có đánh giá nào.</p>
                                    <small>Hãy là người đánh giá đầu tiên!</small>
                                </div>
                            @else
                                <!-- Danh sách đánh giá -->
                                <div class="reviews-list">
                                    @foreach ($reviews as $review)
                                        <div class="review-item border-bottom pb-3 mb-3">
                                            <div class="d-flex justify-content-between align-items-start mb-3">
                                                <!-- Tên người đánh giá -->
                                                <div>
                                                    <strong
                                                        class="fs-6 text-info">{{ $review->user?->name ?? 'Khách hàng ẩn danh' }}</strong>
                                                    <span class="text-muted ms-3 small">
                                                        {{ $review->created_at->format('d/m/Y') }}
                                                    </span>
                                                </div>

                                                <!-- Số sao -->
                                                <div class="text-end">
                                                    <div class="d-flex gap-1 justify-content-end mb-1"
                                                        style="font-size: 1.65rem;">
                                                        @for ($i = 1; $i <= 5; $i++)
                                                            <span
                                                                class="{{ $i <= $review->rating ? 'text-warning' : 'text-secondary' }}">
                                                                ★
                                                            </span>
                                                        @endfor
                                                    </div>
                                                    <small class="text-dark fw-medium">{{ $review->rating }}/5</small>
                                                </div>
                                            </div>

                                            <!-- Tiêu đề -->
                                            @if ($review->title)
                                                <h6 class="fw-semibold text-dark mb-2">{{ $review->title }}</h6>
                                            @endif

                                            <!-- Nội dung đánh giá - GIỐNG HỆT PHẦN MÔ TẢ -->
                                            <div class="review-content" style="font-size: 1rem; line-height: 1.85;">
                                                "{{ $review->content }}"
                                            </div>

                                            <!-- Phản hồi từ cửa hàng -->
                                            @if ($review->reply)
                                                <div
                                                    class="mt-4 p-3 bg-light border-start border-4 border-success rounded">
                                                    <strong class="text-success">Phản hồi từ cửa hàng:</strong>
                                                    <p class="mb-1 mt-2">{{ $review->reply }}</p>
                                                    <small class="text-muted">
                                                        {{ $review->replied_at?->format('d/m/Y H:i') }}
                                                    </small>
                                                </div>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>

                                <!-- Phân trang -->
                                @if ($reviews->hasPages())
                                    <div class="d-flex justify-content-center mt-5">
                                        {{ $reviews->appends(request()->query())->links() }}
                                    </div>
                                @endif
                            @endif

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ==================== PHẦN BÌNH LUẬN SẢN PHẨM ==================== -->
    <section class="flat-spacing pt-0">
        <div class="container">
            <div class="widget-accordion wd-product-comments">
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse"
                            data-bs-target="#comments">
                            Bình luận của khách hàng
                            <span class="ms-2 badge bg-primary">{{ $comments->total() ?? 0 }}</span>
                        </button>
                    </h2>
                    <div id="comments" class="accordion-collapse collapse show">
                        <div class="accordion-body">

                            @if(session('success'))
                                <div class="alert alert-success">{{ session('success') }}</div>
                            @endif
                            @if(session('error'))
                                <div class="alert alert-danger">{{ session('error') }}</div>
                            @endif

                            @guest
                                <div class="alert alert-info">
                                    Vui lòng <a href="{{ route('auth.login') }}">đăng nhập</a> để gửi bình luận.
                                </div>
                            @else
                                <form action="{{ route('client.comments.store') }}" method="POST" class="mb-4">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <div class="mb-3">
                                        <label for="comment_content" class="form-label">Viết bình luận</label>
                                        <textarea id="comment_content" name="content" rows="4"
                                            class="form-control @error('content') is-invalid @enderror"
                                            placeholder="Chia sẻ cảm nhận của bạn về sản phẩm này...">{{ old('content') }}</textarea>
                                        @error('content')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <button type="submit" class="btn btn-primary">Gửi bình luận</button>
                                </form>
                            @endguest

                            @if ($comments->isEmpty())
                                <div class="text-center py-4 text-muted">
                                    <p>Chưa có bình luận nào cho sản phẩm này.</p>
                                </div>
                            @else
                                <div class="comments-list">
                                    @foreach ($comments as $comment)
                                        <div class="comment-item border-bottom pb-3 mb-3">
                                            <div class="d-flex justify-content-between align-items-start mb-2">
                                                <div>
                                                    <strong class="fs-6 text-info">{{ $comment->user?->name ?? 'Khách' }}</strong>
                                                    <span class="text-muted ms-3 small">{{ $comment->created_at->format('d/m/Y') }}</span>
                                                </div>
                                            </div>
                                            <div class="comment-content" style="font-size: 1rem; line-height: 1.85;">
                                                {{ $comment->content }}
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                                @if ($comments->hasPages())
                                    <div class="d-flex justify-content-center mt-4">
                                        {{ $comments->appends(request()->query())->links() }}
                                    </div>
                                @endif
                            @endif

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {

        const mainImage     = document.getElementById('main-image');
        const thumbs        = document.querySelectorAll('.thumb-item');
        const addBtn        = document.getElementById('add-to-cart-btn');
        const quantityInput = document.querySelector('.quantity-product');
        const stockDisplay  = document.getElementById('stock-display');   // ← Phải có id này trong HTML

        let allVariants     = @json($product->variants);
        let variantStockMap = @json($variantStockMap ?? []);   // stock theo variant_id
        let sizeStockMap    = @json($sizeStockMap ?? []);      // stock theo size_id
        let totalStock      = {{ $totalStock ?? 0 }};

        let selectedSizeId  = null;
        let selectedColorId = null;

        // ==================== UPDATE STOCK DISPLAY ====================
        function updateStockDisplay() {
            let stock = 0;

            if (selectedSizeId && selectedColorId) {
                // Chọn đủ size + color → stock của variant
                const variant = allVariants.find(v =>
                    String(v.size_id) === String(selectedSizeId) &&
                    String(v.color_id) === String(selectedColorId)
                );
                stock = variant ? parseInt(variant.stock) || 0 : 0;
            }
            else if (selectedSizeId) {
                // Chỉ chọn size → tổng stock của size đó
                stock = parseInt(sizeStockMap[selectedSizeId]) || 0;
            }
            else {
                // Chưa chọn gì → tổng stock sản phẩm
                stock = totalStock;
            }

            stockDisplay.textContent = stock;

            // Đổi màu chữ
            if (stock > 10) {
                stockDisplay.classList.add('text-success');
                stockDisplay.classList.remove('text-danger');
            } else if (stock > 0) {
                stockDisplay.classList.add('text-danger');
                stockDisplay.classList.remove('text-success');
            } else {
                stockDisplay.classList.add('text-danger');
            }
        }

        // ==================== THUMB IMAGE ====================
        function setMainImage(src) {
            if (src) mainImage.src = src;
        }

        thumbs.forEach(thumb => {
            thumb.addEventListener('click', () => {
                thumbs.forEach(t => t.classList.remove('active'));
                thumb.classList.add('active');
                setMainImage(thumb.dataset.mainImage);
            });
        });

        // ==================== RENDER SIZES & COLORS ====================
        function renderSizesAndColors() {
            const sizeContainer  = document.getElementById('size-options');
            const colorContainer = document.getElementById('color-options');

            sizeContainer.innerHTML = '';
            colorContainer.innerHTML = '';

            let filteredVariants = allVariants;

            if (selectedColorId) filteredVariants = filteredVariants.filter(v => String(v.color_id) === String(selectedColorId));
            if (selectedSizeId) filteredVariants = filteredVariants.filter(v => String(v.size_id) === String(selectedSizeId));

            // Render Sizes
            const availableSizes = [...new Set(allVariants.map(v => JSON.stringify({
                id: v.size_id,
                name: v.size?.name || v.size_name || ''
            })))].map(s => JSON.parse(s));

            availableSizes.forEach(size => {
                const hasColor = selectedColorId ?
                    allVariants.some(v => String(v.size_id) === String(size.id) && String(v.color_id) === String(selectedColorId)) : true;

                const isActive = String(size.id) === String(selectedSizeId);
                const disabled = selectedColorId && !hasColor;

                const btn = document.createElement('button');
                btn.type = 'button';
                btn.className = `btn btn-outline-secondary size-btn px-4 py-2 ${isActive ? 'active btn-primary' : ''} ${disabled ? 'disabled opacity-50' : ''}`;
                btn.dataset.sizeId = size.id;
                btn.textContent = size.name;
                btn.disabled = disabled;

                btn.addEventListener('click', () => {
                    if (disabled) return;
                    selectedSizeId = size.id;
                    renderSizesAndColors();
                    updateStockDisplay();           // ← Cập nhật tồn kho
                });

                sizeContainer.appendChild(btn);
            });

            // Render Colors
            const availableColors = [...new Set(allVariants.map(v => JSON.stringify({
                id: v.color_id,
                name: v.color?.name || v.color_name || '',
                code: v.color?.code || '#ccc'
            })))].map(c => JSON.parse(c));

            availableColors.forEach(color => {
                const hasSize = selectedSizeId ?
                    allVariants.some(v => String(v.color_id) === String(color.id) && String(v.size_id) === String(selectedSizeId)) : true;

                const isActive = String(color.id) === String(selectedColorId);
                const disabled = selectedSizeId && !hasSize;

                const btn = document.createElement('button');
                btn.type = 'button';
                btn.className = `color-btn rounded-circle border border-2 ${isActive ? 'active' : ''} ${disabled ? 'disabled opacity-40' : ''}`;
                btn.style.backgroundColor = color.code;
                btn.style.width = '46px';
                btn.style.height = '46px';
                btn.title = color.name;
                btn.dataset.colorId = color.id;
                btn.disabled = disabled;

                if (isActive) {
                    btn.style.border = '3px solid #000';
                    btn.style.boxShadow = '0 0 0 5px rgba(0,0,0,0.2)';
                }

                btn.addEventListener('click', () => {
                    if (disabled) return;
                    selectedColorId = color.id;

                    const variantWithColor = allVariants.find(v => String(v.color_id) === String(selectedColorId));
                    if (variantWithColor && variantWithColor.images && variantWithColor.images[0]) {
                        setMainImage('{{ Storage::url('') }}' + variantWithColor.images[0].image);
                    }

                    renderSizesAndColors();
                    updateStockDisplay();           // ← Cập nhật tồn kho
                });

                colorContainer.appendChild(btn);
            });
        }

        // ==================== ADD TO CART  ====================
        addBtn.addEventListener('click', function() {
            if (!selectedSizeId || !selectedColorId) {
                showToast('Vui lòng chọn kích thước và màu sắc!', 'warning');
                return;
            }

            const selectedVariant = allVariants.find(v =>
                String(v.size_id) === String(selectedSizeId) &&
                String(v.color_id) === String(selectedColorId)
            );

            if (!selectedVariant) {
                showToast('Không tìm thấy biến thể này!', 'danger');
                return;
            }

            const quantity = parseInt(quantityInput.value) || 1;

            fetch("{{ route('cart.add') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({
                    product_variant_id: selectedVariant.id,
                    quantity: quantity
                })
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    showToast('Đã thêm vào giỏ hàng thành công!', 'success');
                } else {
                    showToast(data.message || 'Thêm thất bại!', 'danger');
                }
            })
            .catch(() => showToast('Lỗi kết nối!', 'danger'));
        });

  document.addEventListener('click', function(e) {
    const btn = e.target.closest('.detail-minus-btn, .detail-plus-btn');
    if (!btn) return;

    let val = parseInt(quantityInput.value) || 1;

    if (btn.classList.contains('detail-minus-btn') && val > 1) {
        val--;
    } else if (btn.classList.contains('detail-plus-btn')) {
        val++;
    }

    quantityInput.value = val;
});

        // ==================== TOAST (giữ nguyên) ====================
        function showToast(message, type = 'info') {
            const bg = type === 'success' ? 'bg-success' : 'bg-danger';
            const toastHTML = `
                <div class="toast align-items-center text-white ${bg} border-0 position-fixed bottom-0 end-0 m-3" role="alert">
                    <div class="d-flex">
                        <div class="toast-body">${message}</div>
                        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
                    </div>
                </div>
            `;

            let container = document.getElementById('toastContainer');
            if (!container) {
                container = document.createElement('div');
                container.id = 'toastContainer';
                container.style.cssText = 'position: fixed; bottom: 20px; right: 20px; z-index: 9999;';
                document.body.appendChild(container);
            }

            container.insertAdjacentHTML('beforeend', toastHTML);
            new bootstrap.Toast(container.lastElementChild, { delay: 2800 }).show();
        }

        // ==================== KHỞI TẠO ====================
        renderSizesAndColors();
        updateStockDisplay();        // Hiển thị tổng tồn kho ban đầu
    });
</script>
@endpush

@endsection

@push('styles')
    <style>
        .quantity-wrapper{
    background: #111;
    border: 1px solid #222;
}

.detail-minus-btn,
.detail-plus-btn{
    background: #111;
    color: #fff;
}

.quantity-product{
    background: #111;
    color: #fff;
}
        .color-btn {
            transition: all 0.2s;
        }

        .color-btn:hover {
            transform: scale(1.1);
        }

        .size-btn.active {
            background-color: #000 !important;
            color: white !important;
            border-color: #000 !important;
        }

        .thumb-item {
            cursor: pointer;
            border: 2px solid transparent;
            transition: all 0.2s;
        }

        .thumb-item.active {
            border-color: #000;
        }

        .thumb-item img {
            width: 100%;
            height: 80px;
            object-fit: cover;
            border-radius: 6px;
        }

        .color-btn {
            transition: all 0.3s ease;
        }

        .color-btn.active {
            border: 3px solid #000 !important;
            box-shadow: 0 0 0 5px rgba(0, 0, 0, 0.2) !important;
            transform: scale(1.1);
        }
    </style>
@endpush
