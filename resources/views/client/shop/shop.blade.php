@extends('client.layout.layout')

@section('content')
    <section class="tf-page-title">
        <div class="container">
            <div class="box-title text-center">
                <h4 class="title">NÂNG NIU BÀN CHÂN BẠN</h4>
                <div class="breadcrumb-list">
                    <a class="breadcrumb-item" href="index.html">Trang chủ</a>
                    <div class="breadcrumb-item dot"><span></span></div>
                    <a class="breadcrumb-item" href="shop-collection-list.html">Sản phẩm</a>
                    <div class="breadcrumb-item dot"><span></span></div>
                    <div class="breadcrumb-item current">Giày</div>
                </div>
                <p class="desc text-md text-main">Định vị thương hiệu nâng niu bàn chân bạn.</p>
            </div>
        </div>
    </section>
    <section class="flat-spacing-24">
        <div class="container">
            <div class="tf-shop-control mb1">
                <div class="tf-group-filter">
                    <div class="tf-dropdown-sort" data-bs-toggle="dropdown">
                        <div class="btn-select">
                            <span class="text-sort-value">Bán chạy nhất</span>
                            <span class="icon icon-arr-down"></span>
                        </div>
                        <div class="dropdown-menu">
                            <div class="select-item active" data-sort-value="best-selling">
                                <span class="text-value-item">Bán chạy nhất</span>
                            </div>
                            <div class="select-item" data-sort-value="a-z">
                                <span class="text-value-item">A đến Z</span>
                            </div>
                            <div class="select-item" data-sort-value="z-a">
                                <span class="text-value-item">Z đến A</span>
                            </div>
                            <div class="select-item" data-sort-value="price-low-high">
                                <span class="text-value-item">Giá: Thấp đến Cao</span>
                            </div>
                            <div class="select-item" data-sort-value="price-high-low">
                                <span class="text-value-item">Giá: Cao đến Thấp</span>
                            </div>
                        </div>
                    </div>
                </div>
                <ul class="tf-control-layout">
                    <li class="tf-view-layout-switch sw-layout-4 active" data-value-layout="tf-col-4">
                        <div class="item icon-grid-4"><span></span><span></span><span></span><span></span></div>
                    </li>
                </ul>
            </div>

            <div class="tf-filter-dropdown">
                <span class="title-filter">Lọc:</span>
                <div class="meta-dropdown-filter">

                    <div class="dropdown dropdown-filter">
                        <div class="dropdown-toggle" id="availability" data-bs-toggle="dropdown" aria-expanded="false"
                            data-bs-auto-close="outside">
                            <span class="text-value">Tình trạng kho</span>
                            <span class="icon icon-arr-down"></span>
                        </div>
                        <div class="dropdown-menu" aria-labelledby="availability">
                            <ul class="filter-group-check">
                                <li class="list-item">
                                    <input type="radio" name="availability" value="in_stock" class="tf-check filter-radio"
                                        id="inStock">
                                    <label for="inStock" class="label"><span>Còn hàng</span>&nbsp;<span
                                            class="count">({{ $inStockCount }})</span></label>
                                </li>
                                <li class="list-item">
                                    <input type="radio" name="availability" value="out_stock"
                                        class="tf-check filter-radio" id="outStock">
                                    <label for="outStock" class="label"><span>Hết hàng</span>&nbsp;<span
                                            class="count">({{ $outOfStockCount }})</span></label>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="row" id="product-grid">
                        @forelse($products as $product)
                            @php
                                $firstVariant = $product->variants->sortBy('price')->first() ?? null;

                                $mainImage = $product->thumbnail
                                    ? Storage::url($product->thumbnail)
                                    : ($firstVariant && $firstVariant->images->first()
                                        ? Storage::url($firstVariant->images->first()->image)
                                        : asset('images/default-product.jpg'));

                                $hoverImage =
                                    $firstVariant && $firstVariant->images->count() > 1
                                        ? Storage::url($firstVariant->images->skip(1)->first()->image)
                                        : $mainImage;

                                $minPrice = $product->variants->min('price') ?? 0;
                                $oldPrice = $minPrice * 1.25;
                                $salePercent =
                                    $oldPrice > $minPrice ? round((($oldPrice - $minPrice) / $oldPrice) * 100) : 0;
                            @endphp

                            <div class="col-lg-3 col-md-4 col-sm-6 col-6 mb-4">
                                <div class="card-product style-center" data-product-id="{{ $product->id }}"
                                    data-variants="{{ json_encode(
                                        $product->variants->map(function ($v) {
                                                return [
                                                    'id' => $v->id,
                                                    'size_id' => $v->size_id,
                                                    'size_name' => $v->size?->name ?? '',
                                                    'color_id' => $v->color_id,
                                                    'color_name' => $v->color?->name ?? '',
                                                    'color_code' => $v->color?->code ?? '#000',
                                                    'price' => $v->price,
                                                    'stock' => $v->stock ?? 0,
                                                    'images' => $v->images->toArray(), // ← Quan trọng để đổi ảnh khi click màu
                                                ];
                                            })->values(),
                                    ) }}">

                                    <div class="card-product-wrapper">
                                        <a href="{{ route('client.product.detail', $product->slug ?? $product->id) }}"
                                            class="product-img">
                                            <img class="img-product lazyload" data-src="{{ $mainImage }}"
                                                src="{{ $mainImage }}" alt="{{ $product->name }}">

                                            <img class="img-hover lazyload" data-src="{{ $hoverImage }}"
                                                src="{{ $hoverImage }}" alt="{{ $product->name }}">
                                        </a>

                                        @if ($salePercent > 0)
                                            <div class="on-sale-wrap">
                                                <span class="on-sale-item">{{ $salePercent }}% Off</span>
                                            </div>
                                        @endif

                                        <ul class="list-product-btn">
                                            <li>
                                                <a href="javascript:void(0);" data-add-to-cart
                                                    class="bg-surface hover-tooltip tooltip-left box-icon">
                                                    <span class="icon icon-cart2"></span>
                                                    <span class="tooltip">Thêm vào giỏ hàng</span>
                                                </a>
                                            </li>
                                            <li class="wishlist">
                                                <a href="javascript:void(0);"
                                                    class="bg-surface hover-tooltip tooltip-left box-icon">
                                                    <span class="icon icon-heart2"></span>
                                                    <span class="tooltip">Yêu thích</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>

                                    <div class="card-product-info text-center">
                                        <a href="{{ route('client.product.detail', $product->slug ?? $product->id) }}"
                                            class="name-product link fw-medium text-md">
                                            {{ Str::limit($product->name, 45) }}
                                        </a>

                                        <p class="price-wrap fw-medium">
                                            <span class="price-new">{{ number_format($minPrice) }} ₫</span>
                                            @if ($oldPrice > $minPrice)
                                                <span class="price-old old-line">{{ number_format($oldPrice) }} ₫</span>
                                            @endif
                                        </p>

                                        <!-- Màu sắc -->
                                        <ul class="list-color-product justify-content-center"
                                            id="color-swatch-list-{{ $product->id }}">
                                            @foreach ($product->variants->unique('color_id')->take(4) as $variant)
                                                <li class="list-color-item color-swatch hover-tooltip tooltip-bot"
                                                    data-color-id="{{ $variant->color_id }}">
                                                    <span class="tooltip">{{ $variant->color?->name ?? 'Color' }}</span>
                                                    <span class="swatch-value"
                                                        style="background-color: {{ $variant->color?->code ?? '#000' }};"></span>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-12 text-center py-5">
                                <p class="text-muted">Không tìm thấy sản phẩm nào.</p>
                            </div>
                        @endforelse
                    </div>

                    <div class="wrapper-control-shop">
                        <div class="meta-filter-shop">
                            <div id="product-count-grid" class="count-text"></div>
                            <div id="product-count-list" class="count-text"></div>
                            <div id="applied-filters"></div>
                            <button id="remove-all" class="remove-all-filters" style="display: none;">
                                <i class="icon icon-close"></i> Xóa tất cả bộ lọc
                            </button>
                        </div>

                        <div class="wrapper-shop tf-grid-layout tf-col-4" id="gridLayout">
                            @include('client.shop.partials.product_grid')
                        </div>

                    </div>
                </div>
    </section>
    <div class="flat-spacing-5 line-top flat-wrap-iconbox">
        <div class="container">
            <div dir="ltr" class="swiper tf-swiper wow fadeInUp"
                data-swiper='{
                    "slidesPerView": 1,
                    "spaceBetween": 12,
                    "speed": 800,
                    "pagination": { "el": ".sw-pagination-iconbox", "clickable": true },
                    "breakpoints": {
                        "575": { "slidesPerView": 2, "spaceBetween": 24}, 
                        "768": { "slidesPerView": 3, "spaceBetween": 24},
                        "1200": { "slidesPerView": 3, "spaceBetween": 100},
                        "1440": { "slidesPerView": 3, "spaceBetween": 205}
                    }
                }'>
                <div class="swiper-wrapper">
                    <div class="swiper-slide">
                        <div class="tf-icon-box style-2">
                            <svg width="48" height="48" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M38.9421 14.922L24.328 6.48452C24.2283 6.42685 24.1151 6.39648 23.9999 6.39648C23.8847 6.39648 23.7715 6.42685 23.6717 6.48452L9.05762 14.922C8.95781 14.9795 8.87492 15.0623 8.81731 15.1621C8.75971 15.2618 8.72941 15.375 8.72949 15.4901V32.3651C8.72946 32.4804 8.75977 32.5936 8.81737 32.6934C8.87497 32.7932 8.95783 32.876 9.05762 32.9336L23.6717 41.3711C23.7715 41.4286 23.8847 41.4589 23.9999 41.4589C24.115 41.4589 24.2282 41.4286 24.328 41.3711L38.9421 32.9336C39.0419 32.876 39.1248 32.7932 39.1824 32.6934C39.24 32.5936 39.2703 32.4804 39.2702 32.3651V15.4901C39.2703 15.375 39.24 15.2618 39.1824 15.1621C39.1248 15.0623 39.0419 14.9795 38.9421 14.922ZM23.9999 7.81052L37.3015 15.4901L23.9999 23.1698L10.6982 15.4901L23.9999 7.81052ZM10.042 16.6268L23.3436 24.3064V39.666L10.042 31.9875V16.6268ZM37.9577 31.9875L24.6561 39.666V24.3064L37.9577 16.6268V31.9875Z" fill="#ABABAB" />
                            </svg>
                            <div class="content">
                                <div class="title">Giao hàng miễn phí</div>
                                <p class="desc text-grey-2">Miễn phí giao hàng cho đơn hàng trên 5 triệu đồng</p>
                            </div>
                        </div>
                    </div>
                    </div>
                <div class="d-flex d-xl-none sw-dot-default sw-pagination-iconbox justify-content-center"></div>
            </div>
        </div>
    </div>
@endsection

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {

                // ====================== THÊM VÀO GIỎ HÀNG TỪ SHOP ======================
                const addToCartButtons = document.querySelectorAll('[data-add-to-cart]');

                addToCartButtons.forEach(button => {
                    button.addEventListener('click', function(e) {
                        e.preventDefault();

                        const card = this.closest('.card-product');
                        if (!card) return;

                        const productId = card.dataset.productId;
                        const productName = card.querySelector('.name-product') ?
                            card.querySelector('.name-product').textContent.trim() :
                            'Sản phẩm';

                        let variants = [];
                        try {
                            variants = card.dataset.variants ? JSON.parse(card.dataset.variants) : [];
                        } catch (e) {
                            console.error('Lỗi parse variants:', e);
                            showToast('Dữ liệu sản phẩm không hợp lệ!', 'danger');
                            return;
                        }

                        if (variants.length === 0) {
                            showToast('Sản phẩm này không có biến thể!', 'warning');
                            return;
                        }

                        showVariantModal(productId, productName, variants);
                    });
                });

                // ====================== HIỂN THỊ MODAL CHỌN VARIANT ======================
                function showVariantModal(productId, productName, variants) {
                    // Xóa modal cũ nếu tồn tại
                    if (document.getElementById('variantModal')) {
                        document.getElementById('variantModal').remove();
                    }

                    const modalHTML = `
            <div class="modal fade" id="variantModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Chọn phiên bản sản phẩm</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <p class="fw-bold fs-5 mb-3">${productName}</p>

                            <!-- Size -->
                            <div class="mb-4">
                                <label class="form-label fw-medium">Kích thước</label>
                                <div id="sizeOptions" class="d-flex flex-wrap gap-2"></div>
                            </div>

                            <!-- Color -->
                            <div class="mb-4">
                                <label class="form-label fw-medium">Màu sắc</label>
                                <div id="colorOptions" class="d-flex flex-wrap gap-2"></div>
                            </div>

                            <!-- Quantity -->
                            <div>
                                <label class="form-label fw-medium">Số lượng</label>
                                <div class="input-group" style="max-width: 160px;">
                                    <button type="button" class="btn btn-outline-secondary" id="qtyMinus">-</button>
                                    <input type="number" id="quantityInput" class="form-control text-center" value="1" min="1" readonly>
                                    <button type="button" class="btn btn-outline-secondary" id="qtyPlus">+</button>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
                
                const oldModal = document.getElementById('variantModal');
                if (oldModal) oldModal.remove();
                
                document.body.insertAdjacentHTML('beforeend', modalHTML);
                
                const uniqueSizes = [...new Set(variants.map(v => JSON.stringify({id: v.size_id, name: v.size_name})))].map(v => JSON.parse(v));
                const uniqueColors = [...new Set(variants.map(v => JSON.stringify({id: v.color_id, name: v.color_name, code: v.color_code})))].map(v => JSON.parse(v));
                
                document.getElementById('sizeOptions').innerHTML = uniqueSizes.map(size => `
                    <button type="button" class="btn btn-outline-secondary btn-sm size-option" data-size-id="${size.id}">${size.name}</button>
                `).join('');
                
                document.getElementById('colorOptions').innerHTML = uniqueColors.map(color => `
                    <button type="button" class="btn btn-sm color-option" data-color-id="${color.id}" 
                            style="background-color: ${color.code}; color: ${isLightColor(color.code) ? '#000' : '#fff'}; border: 2px solid #ddd;"
                            title="${color.name}">
                    </button>
                `).join('');
                
                const modal = new bootstrap.Modal(document.getElementById('variantModal'));
                modal.show();
                
                let selectedSize = null;
                let selectedColor = null;
                
                document.querySelectorAll('.size-option').forEach(btn => {
                    btn.addEventListener('click', function() {
                        document.querySelectorAll('.size-option').forEach(b => b.classList.remove('active', 'btn-primary'));
                        this.classList.add('active', 'btn-primary');
                        selectedSize = this.dataset.sizeId;
                    });
                });
                
                document.querySelectorAll('.color-option').forEach(btn => {
                    btn.addEventListener('click', function() {
                        document.querySelectorAll('.color-option').forEach(b => b.style.borderWidth = '2px');
                        this.style.borderWidth = '4px';
                        this.style.borderColor = '#000';
                        selectedColor = this.dataset.colorId;
                    });
                });
                
                document.getElementById('decreaseQty').addEventListener('click', function() {
                    const qty = document.getElementById('quantity');
                    if (qty.value > 1) qty.value--;
                });
                
                document.getElementById('increaseQty').addEventListener('click', function() {
                    const qty = document.getElementById('quantity');
                    if (selectedSize && selectedColor) {
                        const currentVariant = variants.find(v => v.size_id == selectedSize && v.color_id == selectedColor);
                        if (currentVariant && parseInt(qty.value) >= currentVariant.stock) {
                            alert(`Số lượng tối đa cho loại này là ${currentVariant.stock}`);
                            return;
                        }
                    }
                    qty.value++;
                });
                
                document.getElementById('confirmAddToCart').addEventListener('click', function() {
                    if (!selectedSize || !selectedColor) {
                        alert('Vui lòng chọn kích cỡ và màu sắc');
                        return;
                    }
                    
                    const selectedVariant = variants.find(v => v.size_id == selectedSize && v.color_id == selectedColor);
                    if (!selectedVariant) {
                        alert('Loại sản phẩm này không có sẵn');
                        return;
                    }
                    
                    const quantity = parseInt(document.getElementById('quantity').value);
                    if (quantity > selectedVariant.stock) {
                        alert(`Số lượng không đủ. Chỉ còn ${selectedVariant.stock} sản phẩm trong kho`);
                        return;
                    }
                    
                    addToCart(selectedVariant.id, quantity);
                    modal.hide();
                });
            }
            
            function addToCart(variantId, quantity) {
                fetch("{{ route('cart.add') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'X-Requested-With': 'XMLHttpRequest',
                    },
                    credentials: 'same-origin',
                    body: JSON.stringify({ product_variant_id: variantId, quantity: quantity })
                })
                .then(res => {
                    if (res.status === 401) {
                        window.location.href = "{{ route('auth.login') }}";
                        return;
                    }
                    return res.json();
                })
                .then(data => {
                    if (data && data.success) {
                        showToast('Đã thêm vào giỏ hàng!', 'success');
                    } else {
                        showToast(data?.message || 'Lỗi thêm vào giỏ hàng', 'error');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showToast('Lỗi kết nối. Vui lòng thử lại', 'error');
                });
            }
            
            function showToast(message, type = 'info') {
                const toastHTML = `
                    <div class="toast align-items-center text-white bg-${type === 'success' ? 'success' : 'danger'} border-0" role="alert">
                        <div class="d-flex">
                            <div class="toast-body">${message}</div>
                            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
                        </div>
                    </div>
                </div>
            </div>
        `;

                    document.body.insertAdjacentHTML('beforeend', modalHTML);

                    const modal = new bootstrap.Modal(document.getElementById('variantModal'));
                    modal.show();

                    // Populate options
                    const uniqueSizes = [...new Set(variants.map(v => JSON.stringify({
                            id: v.size_id,
                            name: v.size_name
                        })))]
                        .map(s => JSON.parse(s));

                    const uniqueColors = [...new Set(variants.map(v => JSON.stringify({
                            id: v.color_id,
                            name: v.color_name,
                            code: v.color_code
                        })))]
                        .map(c => JSON.parse(c));

                    document.getElementById('sizeOptions').innerHTML = uniqueSizes.map(size => `
            <button type="button" class="btn btn-outline-secondary size-btn px-3 py-2" data-size-id="${size.id}">
                ${size.name}
            </button>
        `).join('');

                    document.getElementById('colorOptions').innerHTML = uniqueColors.map(color => `
            <button type="button" class="color-btn rounded-circle border border-2" 
                    style="background-color: ${color.code}; width: 42px; height: 42px;" 
                    data-color-id="${color.id}" title="${color.name}"></button>
        `).join('');

                    let selectedSizeId = null;
                    let selectedColorId = null;

                    // Click Size
                    document.querySelectorAll('.size-btn').forEach(btn => {
                        btn.addEventListener('click', function() {
                            document.querySelectorAll('.size-btn').forEach(b => b.classList.remove(
                                'active', 'btn-primary'));
                            this.classList.add('active', 'btn-primary');
                            selectedSizeId = this.dataset.sizeId;
                        });
                    });

                    // Click Color
                    document.querySelectorAll('.color-btn').forEach(btn => {
                        btn.addEventListener('click', function() {
                            document.querySelectorAll('.color-btn').forEach(b => b.style.borderColor =
                                '#ddd');
                            this.style.borderColor = '#000';
                            selectedColorId = this.dataset.colorId;
                        });
                    });

                    // Quantity
                    document.getElementById('qtyMinus').addEventListener('click', () => {
                        const qty = document.getElementById('quantityInput');
                        if (qty.value > 1) qty.value--;
                    });

                    document.getElementById('qtyPlus').addEventListener('click', () => {
                        document.getElementById('quantityInput').value++;
                    });

                    // Confirm
                    document.getElementById('confirmAddToCart').addEventListener('click', function() {
                        if (!selectedSizeId || !selectedColorId) {
                            showToast('Vui lòng chọn kích thước và màu sắc!', 'warning');
                            return;
                        }

                        const selectedVariant = variants.find(v =>
                            String(v.size_id) === String(selectedSizeId) &&
                            String(v.color_id) === String(selectedColorId)
                        );

                        if (!selectedVariant) {
                            showToast('Phiên bản này không tồn tại!', 'danger');
                            return;
                        }

                        const quantity = parseInt(document.getElementById('quantityInput').value);

                        if (quantity > selectedVariant.stock) {
                            showToast(`Chỉ còn ${selectedVariant.stock} sản phẩm!`, 'warning');
                            return;
                        }

                        addToCart(selectedVariant.id, quantity);
                        modal.hide();
                    });
                }

                // ====================== GỌI API THÊM VÀO GIỎ ======================
                function addToCart(variantId, quantity) {
                    fetch("{{ route('cart.add') }}", {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'X-Requested-With': 'XMLHttpRequest'
                            },
                            body: JSON.stringify({
                                product_variant_id: variantId,
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
                }

                // ====================== TOAST ======================
                function showToast(message, type = 'info') {
                    const bg = type === 'success' ? 'bg-success' : (type === 'warning' ? 'bg-warning' : 'bg-danger');

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
                    new bootstrap.Toast(container.lastElementChild, {
                        delay: 2800
                    }).show();
                }
            });
        </script>
    @endpush


@endsection