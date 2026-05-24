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
                {{-- <ul class="tf-control-layout">
                    <li class="tf-view-layout-switch sw-layout-4 active" data-value-layout="tf-col-4">
                        <div class="item icon-grid-4"><span></span><span></span><span></span><span></span></div>
                    </li>
                </ul> --}}
            </div>

           {{-- ==================== BỘ LỌC ==================== --}}
<div class="tf-filter-dropdown mb-4">
    <span class="title-filter fw-semibold me-3">Lọc:</span>
    <div class="meta-dropdown-filter d-flex flex-wrap gap-2 align-items-center">

        {{-- Tình trạng kho --}}
        <div class="dropdown dropdown-filter">
            <div class="dropdown-toggle" data-bs-toggle="dropdown" data-bs-auto-close="outside">
                <span class="text-value">Tình trạng kho</span>
                <span class="icon icon-arr-down"></span>
            </div>
            <div class="dropdown-menu p-3" style="min-width:200px">
                <ul class="filter-group-check list-unstyled mb-0">
                    <li class="list-item mb-2">
                        <input type="radio" name="availability" value="in_stock"
                            class="tf-check filter-radio" id="inStock">
                        <label for="inStock" class="label ms-2">
                            Còn hàng <span class="text-muted">({{ $inStockCount }})</span>
                        </label>
                    </li>
                    <li class="list-item">
                        <input type="radio" name="availability" value="out_stock"
                            class="tf-check filter-radio" id="outStock">
                        <label for="outStock" class="label ms-2">
                            Hết hàng <span class="text-muted">({{ $outOfStockCount }})</span>
                        </label>
                    </li>
                </ul>
            </div>
        </div>

        {{-- Thương hiệu --}}
        <div class="dropdown dropdown-filter">
            <div class="dropdown-toggle" data-bs-toggle="dropdown" data-bs-auto-close="outside">
                <span class="text-value">Thương hiệu</span>
                <span class="icon icon-arr-down"></span>
            </div>
            <div class="dropdown-menu p-3" style="min-width:200px; max-height:250px; overflow-y:auto;">
                <ul class="filter-group-check list-unstyled mb-0">
                    @foreach ($brands as $brand)
                        <li class="list-item mb-2">
                            <input type="checkbox" class="tf-check filter-brand"
                                value="{{ $brand->id }}" id="brand_{{ $brand->id }}">
                            <label for="brand_{{ $brand->id }}" class="label ms-2">
                                {{ $brand->name }}
                            </label>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>

        {{-- Màu sắc --}}
        <div class="dropdown dropdown-filter">
            <div class="dropdown-toggle" data-bs-toggle="dropdown" data-bs-auto-close="outside">
                <span class="text-value">Màu sắc</span>
                <span class="icon icon-arr-down"></span>
            </div>
            <div class="dropdown-menu p-3" style="min-width:220px; max-height:250px; overflow-y:auto;">
                <ul class="filter-group-check list-unstyled mb-0">
                    @foreach ($colors as $color)
                        <li class="list-item mb-2 d-flex align-items-center gap-2">
                            <input type="checkbox" class="tf-check filter-color"
                                value="{{ $color->id }}" id="color_{{ $color->id }}">
                            <span class="rounded-circle border"
                                style="width:18px;height:18px;background:{{ $color->code ?? '#ccc' }};display:inline-block;"></span>
                            <label for="color_{{ $color->id }}" class="label mb-0">
                                {{ $color->name }}
                            </label>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>

        {{-- Kích thước --}}
        <div class="dropdown dropdown-filter">
            <div class="dropdown-toggle" data-bs-toggle="dropdown" data-bs-auto-close="outside">
                <span class="text-value">Kích thước</span>
                <span class="icon icon-arr-down"></span>
            </div>
            <div class="dropdown-menu p-3" style="min-width:180px; max-height:250px; overflow-y:auto;">
                <ul class="filter-group-check list-unstyled mb-0">
                    @foreach ($sizes as $size)
                        <li class="list-item mb-2">
                            <input type="checkbox" class="tf-check filter-size"
                                value="{{ $size->id }}" id="size_{{ $size->id }}">
                            <label for="size_{{ $size->id }}" class="label ms-2">
                                {{ $size->name }}
                            </label>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>

        {{-- Giá --}}
        <div class="dropdown dropdown-filter">
            <div class="dropdown-toggle" data-bs-toggle="dropdown" data-bs-auto-close="outside">
                <span class="text-value">Khoảng giá</span>
                <span class="icon icon-arr-down"></span>
            </div>
            <div class="dropdown-menu p-3" style="min-width:240px;">
                <div class="d-flex gap-2 align-items-center mb-2">
                    <input type="number" id="minPrice" class="form-control form-control-sm"
                        placeholder="Từ (₫)" min="0" style="width:105px;">
                    <span>–</span>
                    <input type="number" id="maxPrice" class="form-control form-control-sm"
                        placeholder="Đến (₫)" min="0" style="width:105px;">
                </div>
                <button type="button" class="btn btn-dark btn-sm w-100" id="applyPrice">Áp dụng</button>
            </div>
        </div>

        {{-- Nút xóa lọc --}}
        <button type="button" id="clearAllFilters"
            class="btn btn-outline-secondary btn-sm" style="display:none;">
            <i class="icon icon-close"></i> Xóa bộ lọc
        </button>
    </div>

    {{-- Tags bộ lọc đang áp dụng --}}
    <div id="applied-filters" class="d-flex flex-wrap gap-2 mt-3"></div>
</div>

{{-- ==================== LƯỚI SẢN PHẨM ==================== --}}
<div class="wrapper-shop tf-grid-layout tf-col-4" id="gridLayout">
    @include('client.shop.partials.product_grid')
</div>

{{-- Pagination --}}
<div id="pagination-wrap" class="mt-4 d-flex justify-content-center">
    {{ $products->links() }}
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
               
            </div>
        </div>
    </div>


    @push('scripts')
    
        <script>
            // ====================== BỘ LỌC ======================
(function () {
    let currentFilters = {
        availability: null,
        brands: [],
        colors: [],
        sizes: [],
        min_price: null,
        max_price: null,
        sort: '{{ request("sort", "best-selling") }}'
    };

    // ---- Hàm gọi AJAX ----
    function applyFilters() {
        const params = new URLSearchParams();

        if (currentFilters.availability)   params.set('availability', currentFilters.availability);
        if (currentFilters.brands.length)  params.set('brands',  currentFilters.brands.join(','));
        if (currentFilters.colors.length)  params.set('colors',  currentFilters.colors.join(','));
        if (currentFilters.sizes.length)   params.set('sizes',   currentFilters.sizes.join(','));
        if (currentFilters.min_price)      params.set('min_price', currentFilters.min_price);
        if (currentFilters.max_price)      params.set('max_price', currentFilters.max_price);
        if (currentFilters.sort)           params.set('sort', currentFilters.sort);

        // Cập nhật URL không reload
        history.pushState(null, '', '?' + params.toString());

        const grid = document.getElementById('gridLayout');
        grid.style.opacity = '0.4';

        fetch('/shop?' + params.toString(), {
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(r => r.text())
        .then(html => {
            grid.innerHTML = html;
            grid.style.opacity = '1';
            // Gắn lại event giỏ hàng cho card mới
            rebindAddToCart();
            renderAppliedTags();
            toggleClearBtn();
        });
    }

    // ---- Tình trạng kho ----
    document.querySelectorAll('.filter-radio').forEach(radio => {
        radio.addEventListener('change', function () {
            currentFilters.availability = this.value;
            applyFilters();
        });
    });

    // ---- Thương hiệu ----
    document.querySelectorAll('.filter-brand').forEach(cb => {
        cb.addEventListener('change', function () {
            if (this.checked) currentFilters.brands.push(this.value);
            else currentFilters.brands = currentFilters.brands.filter(v => v !== this.value);
            applyFilters();
        });
    });

    // ---- Màu sắc ----
    document.querySelectorAll('.filter-color').forEach(cb => {
        cb.addEventListener('change', function () {
            if (this.checked) currentFilters.colors.push(this.value);
            else currentFilters.colors = currentFilters.colors.filter(v => v !== this.value);
            applyFilters();
        });
    });

    // ---- Kích thước ----
    document.querySelectorAll('.filter-size').forEach(cb => {
        cb.addEventListener('change', function () {
            if (this.checked) currentFilters.sizes.push(this.value);
            else currentFilters.sizes = currentFilters.sizes.filter(v => v !== this.value);
            applyFilters();
        });
    });

    // ---- Giá ----
    document.getElementById('applyPrice').addEventListener('click', function () {
        currentFilters.min_price = document.getElementById('minPrice').value || null;
        currentFilters.max_price = document.getElementById('maxPrice').value || null;
        applyFilters();
    });

    // ---- Sort (dropdown hiện có) ----
    document.querySelectorAll('.select-item').forEach(item => {
        item.addEventListener('click', function () {
            currentFilters.sort = this.dataset.sortValue;
            document.querySelectorAll('.select-item').forEach(i => i.classList.remove('active'));
            this.classList.add('active');
            document.querySelector('.text-sort-value').textContent = this.querySelector('.text-value-item').textContent;
            applyFilters();
        });
    });

    // ---- Xóa tất cả bộ lọc ----
    document.getElementById('clearAllFilters').addEventListener('click', function () {
        currentFilters = { availability: null, brands: [], colors: [], sizes: [], min_price: null, max_price: null, sort: 'best-selling' };
        document.querySelectorAll('.filter-radio, .filter-brand, .filter-color, .filter-size').forEach(el => el.checked = false);
        document.getElementById('minPrice').value = '';
        document.getElementById('maxPrice').value = '';
        applyFilters();
    });

    // ---- Tags hiển thị bộ lọc đang áp dụng ----
    function renderAppliedTags() {
        const wrap = document.getElementById('applied-filters');
        wrap.innerHTML = '';
        if (currentFilters.availability) addTag(wrap, currentFilters.availability === 'in_stock' ? 'Còn hàng' : 'Hết hàng', () => { currentFilters.availability = null; document.querySelectorAll('.filter-radio').forEach(r => r.checked = false); applyFilters(); });
        if (currentFilters.min_price || currentFilters.max_price) addTag(wrap, `${currentFilters.min_price || 0}₫ – ${currentFilters.max_price || '∞'}₫`, () => { currentFilters.min_price = null; currentFilters.max_price = null; document.getElementById('minPrice').value = ''; document.getElementById('maxPrice').value = ''; applyFilters(); });
    }

    function addTag(wrap, label, onRemove) {
        const tag = document.createElement('span');
        tag.className = 'badge bg-dark d-inline-flex align-items-center gap-1 px-3 py-2';
        tag.innerHTML = `${label} <i class="icon icon-close" style="cursor:pointer;font-size:10px;"></i>`;
        tag.querySelector('i').addEventListener('click', onRemove);
        wrap.appendChild(tag);
    }

    function toggleClearBtn() {
        const hasFilter = currentFilters.availability || currentFilters.brands.length ||
            currentFilters.colors.length || currentFilters.sizes.length ||
            currentFilters.min_price || currentFilters.max_price;
        document.getElementById('clearAllFilters').style.display = hasFilter ? 'inline-flex' : 'none';
    }

    function rebindAddToCart() {
        // Gắn lại sự kiện "Thêm vào giỏ" cho card mới load từ AJAX
        document.querySelectorAll('[data-add-to-cart]').forEach(button => {
            button.addEventListener('click', function (e) {
                e.preventDefault();
                const card = this.closest('.card-product');
                if (!card) return;
                let variants = [];
                try { variants = JSON.parse(card.dataset.variants || '[]'); } catch (e) { return; }
                if (!variants.length) { showToast('Sản phẩm không có biến thể!', 'warning'); return; }
                const name = card.querySelector('.name-product')?.textContent.trim() || 'Sản phẩm';
                showVariantModal(card.dataset.productId, name, variants);
            });
        });
    }
})();
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
