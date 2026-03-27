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
                    @if($product->category)
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
                                    @if($product->thumbnail)
                                        <div class="thumb-item active" data-main-image="{{ Storage::url($product->thumbnail) }}">
                                            <img class="lazyload img-fluid" 
                                                 data-src="{{ Storage::url($product->thumbnail) }}"
                                                 src="{{ Storage::url($product->thumbnail) }}"
                                                 alt="{{ $product->name }}">
                                        </div>
                                    @endif

                                    @foreach($product->variants as $variant)
                                        @foreach($variant->images as $img)
                                            @php
                                                $imgPath = Storage::url($img->image);
                                                if ($product->thumbnail && $imgPath === Storage::url($product->thumbnail)) continue;
                                            @endphp
                                            <div class="thumb-item"
                                                 data-color="{{ $variant->color?->name ?? 'default' }}"
                                                 data-variant-id="{{ $variant->id }}"
                                                 data-main-image="{{ $imgPath }}">
                                                <img class="lazyload img-fluid"
                                                     data-src="{{ $imgPath }}"
                                                     src="{{ $imgPath }}"
                                                     alt="{{ $product->name }}">
                                            </div>
                                        @endforeach
                                    @endforeach
                                </div>
                            </div>

                            <!-- Main Image -->
                            <div class="col-9 main-image-column">
                                <div class="main-image-wrap">
                                    <a href="#" id="main-image-link" class="item">
                                        <img class="tf-image-zoom lazyload img-fluid w-100"
                                             id="main-image"
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

                                <div class="product-rate mb-3">
                                    <i class="icon icon-star"></i><i class="icon icon-star"></i>
                                    <i class="icon icon-star"></i><i class="icon icon-star"></i>
                                    <i class="icon icon-star-half"></i>
                                    <span class="count-review">(12 reviews)</span>
                                </div>

                                <div class="product-price mb-4">
                                    <span class="price-new fs-4 fw-bold" id="display-price">
                                        {{ number_format($minPrice) }} ₫
                                    </span>
                                    @if($maxPrice > $minPrice)
                                        <span class="price-old ms-2">{{ number_format($maxPrice) }} ₫</span>
                                    @endif
                                </div>

                                <!-- Size -->
                                <div class="mb-4">
                                    <label class="form-label fw-medium">Kích thước</label>
                                    <div class="d-flex flex-wrap gap-2" id="size-options">
                                        @foreach($availableSizes as $size)
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
                                        @foreach($availableColors as $color)
                                            <button type="button" class="color-btn rounded-circle border border-2" 
                                                    style="background-color: {{ $color->code ?? '#000000' }}; width: 42px; height: 42px;" 
                                                    data-color-id="{{ $color->id }}" 
                                                    title="{{ $color->name }}"></button>
                                        @endforeach
                                    </div>
                                </div>

                                <!-- Quantity + Add to Cart -->
                                <div class="d-flex align-items-center gap-4 mt-4">
                                    <div class="wg-quantity">
                                        <button type="button" class="btn-quantity minus-btn">-</button>
                                        <input type="text" class="quantity-product" value="1" readonly>
                                        <button type="button" class="btn-quantity plus-btn">+</button>
                                    </div>

                                    <button type="button" id="add-to-cart-btn" 
                                            class="tf-btn style-2 fw-6 animate-btn flex-fill">
                                        <i class="icon icon-cart"></i> Thêm vào giỏ hàng
                                    </button>
                                </div>

                                <div class="mt-3">
                                    <a href="#" class="tf-action-btn"><i class="icon-heart"></i> Thêm vào yêu thích</a>
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
                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#description">
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

@endsection

@push('styles')
<style>
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
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {

    // ==================== KHỞI TẠO BIẾN ====================
    const mainImage     = document.getElementById('main-image');
    const thumbs        = document.querySelectorAll('.thumb-item');
    const addBtn        = document.getElementById('add-to-cart-btn');
    const quantityInput = document.querySelector('.quantity-product');

    let selectedSizeId  = null;
    let selectedColorId = null;

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

    // ==================== CHỌN KÍCH THƯỚC ====================
    document.querySelectorAll('.size-btn').forEach(btn => {
        btn.addEventListener('click', function () {
            document.querySelectorAll('.size-btn').forEach(b => {
                b.classList.remove('active', 'btn-primary');
            });
            this.classList.add('active', 'btn-primary');
            selectedSizeId = this.dataset.sizeId;
            console.log('Đã chọn Size:', selectedSizeId); // debug
        });
    });

    // ==================== CHỌN MÀU SẮC (PHẦN QUAN TRỌNG) ====================
    document.querySelectorAll('.color-btn').forEach(btn => {
        btn.addEventListener('click', function () {
            // Bỏ active tất cả màu
            document.querySelectorAll('.color-btn').forEach(b => {
                b.style.borderColor = '#ddd';
                b.style.boxShadow = 'none';
            });

            // Active màu hiện tại
            this.style.borderColor = '#000';
            this.style.boxShadow = '0 0 0 3px rgba(0,0,0,0.2)';
            
            selectedColorId = this.dataset.colorId;
            console.log('Đã chọn Màu:', selectedColorId); // debug
        });
    });

    // ==================== THÊM VÀO GIỎ HÀNG ====================
    addBtn.addEventListener('click', function () {
        if (!selectedSizeId) {
            showToast('Vui lòng chọn kích thước!', 'warning');
            return;
        }
        if (!selectedColorId) {
            showToast('Vui lòng chọn màu sắc!', 'warning');
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
                size_id: selectedSizeId,
                color_id: selectedColorId,
                quantity: quantity,
                product_id: "{{ $product->id }}"
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

    // ==================== TOAST ====================
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

    // ==================== AUTO CHỌN MẶC ĐỊNH ====================
    setTimeout(() => {
        const firstSize  = document.querySelector('.size-btn');
        const firstColor = document.querySelector('.color-btn');

        if (firstSize)  firstSize.click();
        if (firstColor) firstColor.click();
    }, 100);

    // ==================== QUANTITY ====================
    document.querySelectorAll('.btn-quantity').forEach(btn => {
        btn.addEventListener('click', () => {
            let val = parseInt(quantityInput.value) || 1;
            if (btn.classList.contains('minus-btn') && val > 1) val--;
            else if (btn.classList.contains('plus-btn')) val++;
            quantityInput.value = val;
        });
    });
});
</script>
@endpush