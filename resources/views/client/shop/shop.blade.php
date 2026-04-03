@extends('client.layout.layout')

@section('content')

    <!-- Title Page -->
    <section class="tf-page-title">
        <div class="container">
            <div class="box-title text-center">
                <h4 class="title">TẤT CẢ SẢN PHẨM</h4>
                <div class="breadcrumb-list">
                    <a class="breadcrumb-item" href="{{ route('client.homeClient') }}">Trang chủ</a>
                    <div class="breadcrumb-item dot"><span></span></div>
                    <div class="breadcrumb-item current">Cửa hàng</div>
                </div>
                <p class="desc text-md text-main">Khám phá bộ sưu tập sản phẩm chất lượng cao của chúng tôi</p>
            </div>
        </div>
    </section>

    <!-- Section Product - Dùng style giống Hot Deals -->
    <section class="flat-spacing-24">
        <div class="container">
            <div class="tf-shop-control mb-4">
                <div class="tf-group-filter">
                    <!-- Bộ lọc sẽ giữ nguyên hoặc anh có thể tinh chỉnh sau -->
                    <div class="tf-dropdown-sort" data-bs-toggle="dropdown">
                        <div class="btn-select">
                            <span class="text-sort-value">Mới nhất</span>
                            <span class="icon icon-arr-down"></span>
                        </div>
                        <div class="dropdown-menu">
                            <div class="select-item active" data-sort-value="newest">Mới nhất</div>
                            <div class="select-item" data-sort-value="price-low-high">Giá: Thấp đến Cao</div>
                            <div class="select-item" data-sort-value="price-high-low">Giá: Cao đến Thấp</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Danh sách sản phẩm - Dùng cùng style với Hot Deals -->
            <div class="row">
    @forelse($products as $product)
        @php
            $firstVariant = $product->variants->sortBy('price')->first() ?? null;

            $mainImage = $product->thumbnail 
                ? Storage::url($product->thumbnail) 
                : ($firstVariant && $firstVariant->images->first() 
                    ? Storage::url($firstVariant->images->first()->image) 
                    : asset('images/default-product.jpg'));

            $hoverImage = $firstVariant && $firstVariant->images->count() > 1 
                ? Storage::url($firstVariant->images->skip(1)->first()->image) 
                : $mainImage;

            $minPrice = $product->variants->min('price') ?? 0;
            $oldPrice = $minPrice * 1.25;
            $salePercent = $oldPrice > $minPrice ? round((($oldPrice - $minPrice) / $oldPrice) * 100) : 0;
        @endphp

        <div class="col-lg-3 col-md-4 col-sm-6 col-6 mb-4">
            <div class="card-product style-center" 
                 data-product-id="{{ $product->id }}"
                 data-variants="{{ json_encode($product->variants->map(function ($v) {
                     return [
                         'id'          => $v->id,
                         'size_id'     => $v->size_id,
                         'size_name'   => $v->size?->name ?? '',
                         'color_id'    => $v->color_id,
                         'color_name'  => $v->color?->name ?? '',
                         'color_code'  => $v->color?->code ?? '#000',
                         'price'       => $v->price,
                         'stock'       => $v->stock ?? 0,
                     ];
                 })) }}">

                <div class="card-product-wrapper">
                    <a href="{{ route('client.product.detail', $product->slug ?? $product->id) }}" class="product-img">
                        <img class="img-product lazyload" 
                             data-src="{{ $mainImage }}" 
                             src="{{ $mainImage }}" 
                             alt="{{ $product->name }}">

                        <img class="img-hover lazyload" 
                             data-src="{{ $hoverImage }}" 
                             src="{{ $hoverImage }}" 
                             alt="{{ $product->name }}">
                    </a>

                    @if($salePercent > 0)
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
                            <a href="javascript:void(0);" class="bg-surface hover-tooltip tooltip-left box-icon">
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
                        @if($oldPrice > $minPrice)
                            <span class="price-old old-line">{{ number_format($oldPrice) }} ₫</span>
                        @endif
                    </p>

                    <!-- Màu sắc -->
                    <ul class="list-color-product justify-content-center">
                        @foreach($product->variants->unique('color_id')->take(4) as $variant)
                            <li class="list-color-item color-swatch hover-tooltip tooltip-bot">
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

            <!-- Phân trang -->
            <div class="pagination-wrapper mt-5">
                {{ $products->links() }}
            </div>
        </div>
    </section>



@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {

    // ====================== THÊM VÀO GIỎ HÀNG TỪ SHOP ======================
    const addToCartButtons = document.querySelectorAll('[data-add-to-cart]');

    addToCartButtons.forEach(button => {
        button.addEventListener('click', function (e) {
            e.preventDefault();

            const card = this.closest('.card-product');
            if (!card) return;

            const productId = card.dataset.productId;
            const productName = card.querySelector('.name-product') 
                ? card.querySelector('.name-product').textContent.trim() 
                : 'Sản phẩm';

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
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                            <button type="button" class="btn btn-success" id="confirmAddToCart">Thêm vào giỏ hàng</button>
                        </div>
                    </div>
                </div>
            </div>
        `;

        document.body.insertAdjacentHTML('beforeend', modalHTML);

        const modal = new bootstrap.Modal(document.getElementById('variantModal'));
        modal.show();

        // Populate options
        const uniqueSizes = [...new Set(variants.map(v => JSON.stringify({id: v.size_id, name: v.size_name})))]
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
                document.querySelectorAll('.size-btn').forEach(b => b.classList.remove('active', 'btn-primary'));
                this.classList.add('active', 'btn-primary');
                selectedSizeId = this.dataset.sizeId;
            });
        });

        // Click Color
        document.querySelectorAll('.color-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                document.querySelectorAll('.color-btn').forEach(b => b.style.borderColor = '#ddd');
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
        new bootstrap.Toast(container.lastElementChild, { delay: 2800 }).show();
    }
});
</script>
@endpush


    @endsection