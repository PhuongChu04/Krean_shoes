@extends('client.layout.layout')

@section('content')
    <!-- Breadcrumb -->
    <div class="breadcrumb-sec">
        <div class="container">
            <div class="breadcrumb-wrap">
                <div class="breadcrumb-list">
                    <a class="breadcrumb-item" href="{{ route('client.homeClient') }}">Home</a>
                    <div class="breadcrumb-item dot"><span></span></div>
                    <a class="breadcrumb-item" href="{{ route('shop.index') }}">Shop</a>
                    <div class="breadcrumb-item dot"><span></span></div>

                    @if ($product->category)
                        <a class="breadcrumb-item" href="{{ route('shop.index') }}?category={{ $product->category->id }}">
                            {{ $product->category->name ?? 'Danh mục' }}
                        </a>
                        <div class="breadcrumb-item dot"><span></span></div>
                    @endif

                    <div class="breadcrumb-item current">{{ $product->name }}</div>
                </div>
                <div class="breadcrumb-prev-next">
                    <a href="#" class="breadcrumb-prev"><i class="icon icon-arr-left"></i></a>
                    <a href="{{ route('shop.index') }}" class="breadcrumb-back"><i class="icon icon-shop"></i></a>
                    <a href="#" class="breadcrumb-next"><i class="icon icon-arr-right2"></i></a>
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
                            <!-- Thumbs (cột trái) -->
                            <div class="col-3 thumbs-column">
                                <div class="product-thumbs-list d-flex flex-column gap-2" id="thumbs-container">
                                    @if ($product->thumbnail)
                                        <div class="thumb-item active" 
                                             data-main-image="{{ Storage::url($product->thumbnail) }}">
                                            <img class="lazyload img-fluid"
                                                 data-src="{{ Storage::url($product->thumbnail) }}"
                                                 src="{{ Storage::url($product->thumbnail) }}"
                                                 alt="{{ $product->name }} - Ảnh chính">
                                        </div>
                                    @endif

                                    @foreach ($product->variants as $variant)
                                        @foreach ($variant->images as $img)
                                            @php
                                                $imgPath = Storage::url($img->image);
                                                if ($product->thumbnail && $imgPath === Storage::url($product->thumbnail)) {
                                                    continue;
                                                }
                                            @endphp
                                            <div class="thumb-item"
                                                 data-color="{{ $variant->color?->name ?? 'default' }}"
                                                 data-variant-id="{{ $variant->id }}"
                                                 data-main-image="{{ $imgPath }}">
                                                <img class="lazyload img-fluid"
                                                     data-src="{{ $imgPath }}"
                                                     src="{{ $imgPath }}"
                                                     alt="{{ $product->name }} - {{ $variant->color?->name ?? '' }}">
                                            </div>
                                        @endforeach
                                    @endforeach

                                    @if (!$product->thumbnail && $product->variants->flatMap(fn($v) => $v->images)->isEmpty())
                                        <div class="thumb-item text-center p-3 text-muted">Chưa có ảnh</div>
                                    @endif
                                </div>
                            </div>

                            <!-- Main Image -->
                           <!-- Main Image -->
<div class="col-9 main-image-column">
    <div class="main-image-wrap">
        <a href="#" class="item" id="main-image-link">
            <img class="tf-image-zoom lazyload img-fluid w-100"
                 id="main-image"
                 data-zoom=""
                 {{-- fallback ngay từ HTML --}}
                 src="{{ $product->thumbnail ? Storage::url($product->thumbnail) : 'https://via.placeholder.com/600x600?text=No+Image' }}"
                 data-src="{{ $product->thumbnail ? Storage::url($product->thumbnail) : '' }}"
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
                                <div class="tf-product-heading">
                                    <h3 class="fw-medium">{{ $product->name }}</h3>

                                    <!-- Rating (tạm thời tĩnh) -->
                                    <div class="product-rate">
                                        <i class="icon icon-star"></i><i class="icon icon-star"></i>
                                        <i class="icon icon-star"></i><i class="icon icon-star"></i>
                                        <i class="icon icon-star-half"></i>
                                        <span class="count-review">(0 reviews)</span>
                                    </div>

                                    <!-- Giá -->
                                    <div class="product-price mt-2">
                                        <span class="price-new fs-20 fw-6" id="display-price">
                                            {{ number_format($minPrice) }}₫
                                        </span>
                                        @if ($maxPrice > $minPrice)
                                            <span class="price-old">
                                                {{ number_format($maxPrice) }}₫
                                            </span>
                                        @endif
                                    </div>

                                    <!-- Stock -->
                                    <div class="mt-2" id="stock-info">
                                        @if ($totalStock > 0)
                                            <span class="text-success">Còn hàng: {{ $totalStock }} sản phẩm</span>
                                        @else
                                            <span class="text-danger">Hết hàng</span>
                                        @endif
                                    </div>
                                </div>

                                <!-- Variant Selection -->
                                <div class="tf-product-variants mt-4">
                                    <!-- Size -->
                                    <div class="variant-size mb-3">
                                        <label class="form-label fw-medium">Kích thước</label>
                                        <div class="d-flex flex-wrap gap-2">
                                            @foreach ($availableSizes as $size)
                                                <label class="btn btn-outline-secondary size-btn">
                                                    <input type="radio" name="size" value="{{ $size->id }}"
                                                           data-size-name="{{ $size->name }}" hidden>
                                                    {{ $size->name }}
                                                </label>
                                            @endforeach
                                        </div>
                                    </div>

                                    <!-- Color -->
                                    <div class="variant-color mb-3">
                                        <label class="form-label fw-medium">Màu sắc</label>
                                        <div class="d-flex flex-wrap gap-2">
                                            @foreach ($availableColors as $color)
                                                <label class="btn btn-outline-secondary color-btn position-relative">
                                                    <input type="radio" name="color" value="{{ $color->id }}"
                                                           data-color-name="{{ $color->name }}" hidden>
                                                    <span class="color-swatch" style="background-color: {{ $color->hex ?? '#000' }}"></span>
                                                    <span class="tooltip">{{ $color->name }}</span>
                                                </label>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>

                                <!-- Quantity & Add to Cart -->
                                <div class="tf-product-info-quantity mt-5">
                                    <div class="d-flex align-items-center gap-4">
                                        <div class="wg-quantity">
                                            <span class="btn-quantity minus-btn">-</span>
                                            <input type="text" class="quantity-product" value="1" name="quantity">
                                            <span class="btn-quantity plus-btn">+</span>
                                        </div>

                                        <button type="button" class="tf-btn style-2 fw-6 animate-btn add-to-cart-btn"
                                                data-product-id="{{ $product->id }}"
                                                {{ $totalStock == 0 ? 'disabled' : '' }}>
                                            Thêm vào giỏ hàng
                                        </button>
                                    </div>
                                </div>

                                <!-- Wishlist -->
                                <div class="tf-product-action mt-3">
                                    <a href="#" class="tf-action-btn"><i class="icon-heart"></i> Thêm vào yêu thích</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Description -->
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
                            {!! $product->description ?? '<p>Chưa có mô tả chi tiết.</p>' !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Modal Zoom Image -->
<div id="image-zoom-modal" class="image-zoom-modal">
    <span class="close-zoom">&times;</span>
    <img class="modal-content" id="zoomed-image">
    <div id="caption"></div>
</div>
@endsection
@section('styles')
<style>
    /* Modal Zoom */
    .image-zoom-modal {
        display: none;
        position: fixed;
        z-index: 9999;
        padding-top: 60px;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgba(0,0,0,0.9);
    }

    .modal-content {
        margin: auto;
        display: block;
        width: 80%;
        max-width: 900px;
        max-height: 85vh;
        object-fit: contain;
        transition: transform 0.3s ease;
    }

    .modal-content:hover {
        transform: scale(1.05); /* zoom nhẹ khi hover */
    }

    #caption {
        margin: 15px auto;
        display: block;
        width: 80%;
        max-width: 700px;
        text-align: center;
        color: #ccc;
        padding: 10px 0;
        height: 150px;
    }

    .close-zoom {
        position: absolute;
        top: 20px;
        right: 35px;
        color: #f1f1f1;
        font-size: 40px;
        font-weight: bold;
        transition: 0.3s;
        cursor: pointer;
    }

    .close-zoom:hover,
    .close-zoom:focus {
        color: #bbb;
        text-decoration: none;
        cursor: pointer;
    }

    @media (max-width: 768px) {
        .modal-content { width: 95%; }
        .close-zoom { right: 20px; top: 15px; font-size: 30px; }
    }
</style>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const productId     = "{{ $product->id }}";
    const priceEl       = document.getElementById('display-price');
    const stockEl       = document.getElementById('stock-info');
    const addBtn        = document.querySelector('.add-to-cart-btn');
    const mainImage     = document.getElementById('main-image');
    const thumbs        = document.querySelectorAll('#thumbs-container .thumb-item');
    const quantityInput = document.querySelector('.quantity-product');

    // Fallback thumbnail từ server (đã có trong HTML)
    const defaultMainSrc = "{{ $product->thumbnail ? Storage::url($product->thumbnail) : '' }}";

    // ── Hàm set ảnh chính ───────────────────────────────────────────────
    function setMainImage(src) {
        if (src && src !== mainImage.src) {
            mainImage.src = src;
            mainImage.dataset.src = src;
        }
    }

    // ── Load ảnh mặc định (ưu tiên thumbnail sản phẩm) ──────────────────
    function loadDefaultImage() {
        if (defaultMainSrc) {
            setMainImage(defaultMainSrc);
            // Tìm thumb tương ứng (nếu có) và active nó
            const thumbMain = Array.from(thumbs).find(t => 
                t.dataset.mainImage === defaultMainSrc
            );
            if (thumbMain) {
                thumbs.forEach(t => t.classList.remove('active'));
                thumbMain.classList.add('active');
            }
        }
    }

    // ── Cập nhật variant khi chọn size/color ────────────────────────────
    function updateVariantInfo() {
        const sizeId  = document.querySelector('input[name="size"]:checked')?.value;
        const colorId = document.querySelector('input[name="color"]:checked')?.value;

        // Nếu chưa chọn đủ → giữ nguyên thumbnail mặc định
        if (!sizeId || !colorId) {
            loadDefaultImage();
            priceEl.textContent = new Intl.NumberFormat('vi-VN').format({{ $minPrice ?? 0 }}) + '₫';
            stockEl.innerHTML   = '<span class="text-muted">Vui lòng chọn kích thước & màu</span>';
            addBtn.disabled     = true;
            thumbs.forEach(t => t.style.display = ''); // hiện hết thumbs
            return;
        }

        fetch(`/client/product/variant?product_id=${productId}&size_id=${sizeId}&color_id=${colorId}`, {
            headers: { 'Accept': 'application/json' }
        })
        .then(res => {
            if (!res.ok) throw new Error('Không tìm thấy variant');
            return res.json();
        })
        .then(data => {
            if (data.success && data.variant) {
                priceEl.textContent = new Intl.NumberFormat('vi-VN').format(data.variant.price) + '₫';
                
                stockEl.innerHTML = data.variant.stock > 0
                    ? `<span class="text-success">Còn hàng: ${data.variant.stock} cái</span>`
                    : `<span class="text-danger">Hết hàng</span>`;

                addBtn.disabled = data.variant.stock <= 0;
                addBtn.textContent = data.variant.stock <= 0 ? 'Hết hàng' : 'Thêm vào giỏ hàng';

                // Lọc thumbs theo màu
                thumbs.forEach(thumb => {
                    const isMatch = thumb.dataset.color?.toLowerCase() === (data.variant.color_name || '').toLowerCase()
                                 || thumb.dataset.variantId == data.variant.id;
                    thumb.style.display = isMatch ? '' : 'none';
                });

                // Ưu tiên ảnh từ variant nếu có, fallback về thumbnail
                const variantImage = data.variant.main_image;
                setMainImage(variantImage || defaultMainSrc);

                // Active thumb đầu tiên còn hiển thị
                const firstVisible = Array.from(thumbs).find(t => t.style.display !== 'none');
                if (firstVisible) {
                    thumbs.forEach(t => t.classList.remove('active'));
                    firstVisible.classList.add('active');
                }
            } else {
                stockEl.innerHTML = '<span class="text-danger">Biến thể không tồn tại</span>';
                addBtn.disabled = true;
                loadDefaultImage();
            }
        })
        .catch(err => {
            console.error('Lỗi fetch variant:', err);
            stockEl.innerHTML = '<span class="text-danger">Không tải được thông tin biến thể</span>';
            loadDefaultImage();
        });
    }

    // ── Sự kiện ─────────────────────────────────────────────────────────
    document.querySelectorAll('input[name="size"], input[name="color"]')
        .forEach(radio => radio.addEventListener('change', updateVariantInfo));

    thumbs.forEach(thumb => {
        thumb.addEventListener('click', () => {
            thumbs.forEach(t => t.classList.remove('active'));
            thumb.classList.add('active');
            setMainImage(thumb.dataset.mainImage);
        });
    });

    // ── Tăng/giảm số lượng ─────────────────────────────────────────────
    document.querySelectorAll('.btn-quantity').forEach(btn => {
        btn.addEventListener('click', () => {
            let val = parseInt(quantityInput.value) || 1;
            if (btn.classList.contains('minus-btn') && val > 1) {
                quantityInput.value = val - 1;
            } else if (btn.classList.contains('plus-btn')) {
                quantityInput.value = val + 1;
            }
        });
    });

    // ── Load ban đầu ────────────────────────────────────────────────────
    // Chọn size & color đầu tiên nếu có
    const firstSize  = document.querySelector('input[name="size"]');
    const firstColor = document.querySelector('input[name="color"]');
    if (firstSize)  firstSize.checked  = true;
    if (firstColor) firstColor.checked = true;

    // Luôn hiện ảnh chính ngay từ đầu
    loadDefaultImage();

    // Sau đó mới gọi update (nếu đã có size+color mặc định thì sẽ fetch variant)
    updateVariantInfo();
});
</script>
@endsection