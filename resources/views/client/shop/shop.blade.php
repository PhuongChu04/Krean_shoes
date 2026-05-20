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

                    <div class="dropdown dropdown-filter">
                        <div class="dropdown-toggle" id="price" data-bs-toggle="dropdown" aria-expanded="false"
                            data-bs-auto-close="outside">
                            <span class="text-value">Giá</span>
                            <span class="icon icon-arr-down"></span>
                        </div>
                        <div class="dropdown-menu" aria-labelledby="price">
                            <div class="widget-price filter-price">
                                <div class="price-val-range" id="price-value-range" data-min="0" data-max="500"></div>
                                <div class="box-value-price">
                                    <span class="text-sm">Giá:</span>
                                    <div class="price-box">
                                        <div class="price-val" id="price-min-value" data-currency="₫"></div>
                                        <span>-</span>
                                        <div class="price-val" id="price-max-value" data-currency="₫"></div>
                                    </div>
                                </div>
                                <span class="reset-price">Đặt lại</span>
                            </div>
                        </div>
                    </div>

                    <div class="dropdown dropdown-filter">
                        <div class="dropdown-toggle" id="color" data-bs-toggle="dropdown" aria-expanded="false"
                            data-bs-auto-close="outside">
                            <span class="text-value">Màu sắc</span>
                            <span class="icon icon-arr-down"></span>
                        </div>
                        <div class="dropdown-menu" aria-labelledby="color">
                            <div class="filter-color-box flat-check-list">
                                @foreach ($colors as $color)
                                    <div class="check-item color-item color-check" data-color-id="{{ $color->id }}"
                                        data-color-name="{{ $color->name }}">
                                        <span class="color" style="background-color: {{ $color->code }}"></span>
                                        <span class="color-text">{{ $color->name }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div class="dropdown dropdown-filter">
                        <div class="dropdown-toggle" id="size" data-bs-toggle="dropdown" aria-expanded="false"
                            data-bs-auto-close="outside">
                            <span class="text-value">Kích cỡ</span>
                            <span class="icon icon-arr-down"></span>
                        </div>
                        <div class="dropdown-menu" aria-labelledby="size">
                            <div class="filter-size-box flat-check-list">
                                @foreach ($sizes as $size)
                                    <div class="check-item size-item size-check" data-size-id="{{ $size->id }}">
                                        <span class="size">{{ $size->name }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div class="dropdown dropdown-filter">
                        <div class="dropdown-toggle" id="brand" data-bs-toggle="dropdown" aria-expanded="false"
                            data-bs-auto-close="outside">
                            <span class="text-value">Thương hiệu</span>
                            <span class="icon icon-arr-down"></span>
                        </div>
                        <div class="dropdown-menu" aria-labelledby="brand">
                            <ul class="filter-group-check">
                                @foreach ($brands as $brand)
                                    <li class="list-item">
                                        <input type="checkbox" name="brand" value="{{ $brand->id }}"
                                            class="tf-check filter-checkbox" id="brand-{{ $brand->id }}">
                                        <label for="brand-{{ $brand->id }}" class="label">
                                            <span>{{ $brand->name }}</span>&nbsp;
                                            <span class="count">({{ $brand->products->count() }})</span>
                                        </label>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>

                </div>
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
                            <svg width="48" height="48" viewBox="0 0 48 48" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M38.9421 14.922L24.328 6.48452C24.2283 6.42685 24.1151 6.39648 23.9999 6.39648C23.8847 6.39648 23.7715 6.42685 23.6717 6.48452L9.05762 14.922C8.95781 14.9795 8.87492 15.0623 8.81731 15.1621C8.75971 15.2618 8.72941 15.375 8.72949 15.4901V32.3651C8.72946 32.4804 8.75977 32.5936 8.81737 32.6934C8.87497 32.7932 8.95783 32.876 9.05762 32.9336L23.6717 41.3711C23.7715 41.4286 23.8847 41.4589 23.9999 41.4589C24.115 41.4589 24.2282 41.4286 24.328 41.3711L38.9421 32.9336C39.0419 32.876 39.1248 32.7932 39.1824 32.6934C39.24 32.5936 39.2703 32.4804 39.2702 32.3651V15.4901C39.2703 15.375 39.24 15.2618 39.1824 15.1621C39.1248 15.0623 39.0419 14.9795 38.9421 14.922ZM23.9999 7.81052L37.3015 15.4901L23.9999 23.1698L10.6982 15.4901L23.9999 7.81052ZM10.042 16.6268L23.3436 24.3064V39.666L10.042 31.9875V16.6268ZM37.9577 31.9875L24.6561 39.666V24.3064L37.9577 16.6268V31.9875Z"
                                    fill="#ABABAB" />
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
    <link rel="stylesheet" href="{{ asset('client/css/filter.css') }}">

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            // ==========================================
            // 1. LOGIC LỌC VÀ SẮP XẾP SẢN PHẨM (AJAX)
            // ==========================================
            let currentSort = 'best-selling';

            // Xử lý Sắp xếp
            document.querySelectorAll('.dropdown-menu .select-item').forEach(item => {
                item.addEventListener('click', function() {
                    document.querySelector('.text-sort-value').innerText = this.querySelector(
                        '.text-value-item').innerText;
                    currentSort = this.dataset.sortValue;

                    document.querySelectorAll('.dropdown-menu .select-item').forEach(el => el
                        .classList.remove('active'));
                    this.classList.add('active');

                    fetchFilteredProducts();
                });
            });

            // Xử lý chọn Checkbox (Thương hiệu), Radio (Trạng thái)
            document.querySelectorAll('.filter-checkbox, .filter-radio').forEach(input => {
                input.addEventListener('change', fetchFilteredProducts);
            });

            // Xử lý chọn Màu sắc
            document.querySelectorAll('.color-check').forEach(item => {
                item.addEventListener('click', function() {
                    this.classList.toggle('active');
                    fetchFilteredProducts();
                });
            });

            // Xử lý chọn Kích cỡ
            document.querySelectorAll('.size-check').forEach(item => {
                item.addEventListener('click', function() {
                    this.classList.toggle('active');
                    fetchFilteredProducts();
                });
            });

            // Hàm fetch dữ liệu AJAX
            function fetchFilteredProducts() {
                let brands = Array.from(document.querySelectorAll('input[name="brand"]:checked')).map(el => el
                    .value);
                let availability = document.querySelector('input[name="availability"]:checked')?.value || '';
                let colors = Array.from(document.querySelectorAll('.color-check.active')).map(el => el.dataset
                    .colorId);
                let sizes = Array.from(document.querySelectorAll('.size-check.active')).map(el => el.dataset
                .sizeId);

                let params = new URLSearchParams();
                params.append('sort', currentSort);
                if (brands.length) params.append('brands', brands.join(','));
                if (colors.length) params.append('colors', colors.join(','));
                if (sizes.length) params.append('sizes', sizes.join(','));
                if (availability) params.append('availability', availability);

                const gridLayout = document.getElementById('gridLayout');
                gridLayout.style.opacity = '0.5'; // Tạo hiệu ứng mờ khi đang load

                fetch(`{{ route('shop.index') }}?${params.toString()}`, {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(response => response.text())
                    .then(html => {
                        gridLayout.innerHTML = html;
                        gridLayout.style.opacity = '1';

                        // Gắn lại sự kiện "Thêm vào giỏ hàng" cho các element mới được sinh ra
                        initAddToCartEvents();
                    })
                    .catch(error => {
                        console.error('Lỗi lọc sản phẩm:', error);
                        gridLayout.style.opacity = '1';
                    });
            }

            // ==========================================
            // 2. LOGIC THÊM VÀO GIỎ HÀNG 
            // ==========================================
            function initAddToCartEvents() {
                const addToCartButtons = document.querySelectorAll('[data-add-to-cart]');

                addToCartButtons.forEach(button => {
                    // Tránh việc gắn 2 lần event
                    button.removeEventListener('click', handleAddToCartClick);
                    button.addEventListener('click', handleAddToCartClick);
                });
            }

            function handleAddToCartClick(e) {
                e.preventDefault();
                const card = this.closest('.card-product');
                const productId = card.dataset.productId;
                const productName = card.querySelector('.name-product').textContent;

                const variants = JSON.parse(card.dataset.variants);
                showVariantModal(productId, productName, variants);
            }

            function showVariantModal(productId, productName, variants) {
                const modalHTML = `
                    <div class="modal fade" id="variantModal" tabindex="-1" aria-labelledby="variantModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="variantModalLabel">Chọn loại sản phẩm</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <p class="fw-bold text-lg">${productName}</p>
                                    
                                    <div class="mb-3">
                                        <label class="form-label">Chọn kích cỡ:</label>
                                        <div id="sizeOptions" class="d-flex gap-2 flex-wrap"></div>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label class="form-label">Chọn màu sắc:</label>
                                        <div id="colorOptions" class="d-flex gap-2 flex-wrap"></div>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label class="form-label">Số lượng:</label>
                                        <div class="input-group" style="max-width: 150px;">
                                            <button type="button" class="btn btn-outline-secondary btn-sm" id="decreaseQty">-</button>
                                            <input type="number" id="quantity" class="form-control form-control-sm text-center" value="1" min="1" readonly>
                                            <button type="button" class="btn btn-outline-secondary btn-sm" id="increaseQty">+</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                                    <button type="button" class="btn btn-success" id="confirmAddToCart">Thêm vào giỏ</button>
                                </div>
                            </div>
                        </div>
                    </div>
                `;

                const oldModal = document.getElementById('variantModal');
                if (oldModal) oldModal.remove();

                document.body.insertAdjacentHTML('beforeend', modalHTML);

                const uniqueSizes = [...new Set(variants.map(v => JSON.stringify({
                    id: v.size_id,
                    name: v.size_name
                })))].map(v => JSON.parse(v));
                const uniqueColors = [...new Set(variants.map(v => JSON.stringify({
                    id: v.color_id,
                    name: v.color_name,
                    code: v.color_code
                })))].map(v => JSON.parse(v));

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
                        document.querySelectorAll('.size-option').forEach(b => b.classList.remove(
                            'active', 'btn-primary'));
                        this.classList.add('active', 'btn-primary');
                        selectedSize = this.dataset.sizeId;
                    });
                });

                document.querySelectorAll('.color-option').forEach(btn => {
                    btn.addEventListener('click', function() {
                        document.querySelectorAll('.color-option').forEach(b => b.style
                            .borderWidth = '2px');
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
                        const currentVariant = variants.find(v => v.size_id == selectedSize && v.color_id ==
                            selectedColor);
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

                    const selectedVariant = variants.find(v => v.size_id == selectedSize && v.color_id ==
                        selectedColor);
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
                        body: JSON.stringify({
                            product_variant_id: variantId,
                            quantity: quantity
                        })
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
                `;

                let toastContainer = document.getElementById('toastContainer');
                if (!toastContainer) {
                    toastContainer = document.createElement('div');
                    toastContainer.id = 'toastContainer';
                    toastContainer.style.cssText = 'position: fixed; top: 20px; right: 20px; z-index: 9999;';
                    document.body.appendChild(toastContainer);
                }

                toastContainer.insertAdjacentHTML('beforeend', toastHTML);
                const toastEl = toastContainer.lastElementChild;
                const toast = new bootstrap.Toast(toastEl);
                toast.show();
                setTimeout(() => toastEl.remove(), 3000);
            }

            function isLightColor(hex) {
                const r = parseInt(hex.substr(1, 2), 16);
                const g = parseInt(hex.substr(3, 2), 16);
                const b = parseInt(hex.substr(5, 2), 16);
                const brightness = ((r * 299) + (g * 587) + (b * 114)) / 1000;
                return brightness > 155;
            }

            // Gọi khởi tạo sự kiện lần đầu khi load trang
            initAddToCartEvents();
        });
    </script>
@endpush
