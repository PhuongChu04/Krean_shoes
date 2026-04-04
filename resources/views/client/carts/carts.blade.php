@extends('client.layout.layout')

@section('content')
<section class="py-3 border-bottom bg-white">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0" style="--bs-breadcrumb-divider: '/'; font-size: 14px;">
                <li class="breadcrumb-item"><a href="{{ route('client.homeClient') }}" class="text-decoration-none text-muted">Trang chủ</a></li>
                <li class="breadcrumb-item active text-dark fw-bold" aria-current="page">Giỏ hàng</li>
            </ol>
        </nav>
    </div>
</section>

<section class="section-cart py-4 bg-light min-vh-100">
    <div class="container">
        <div id="cart-loader" class="text-center py-5">
            <div class="spinner-border text-danger" role="status"></div>
        </div>

        <div id="cart-content" style="display: none;">
            <div class="cart-header-shopee bg-white shadow-sm mb-3 d-none d-md-block border-radius-2">
                <div class="row align-items-center py-3 px-3 mx-0">
                    <div class="col-md-1 text-center"><input type="checkbox" id="select-all" class="form-check-input custom-checkbox"></div>
                    <div class="col-md-4 text-muted">Sản phẩm</div>
                    <div class="col-md-2 text-center text-muted">Đơn giá</div>
                    <div class="col-md-2 text-center text-muted">Số lượng</div>
                    <div class="col-md-2 text-center text-muted">Số tiền</div>
                    <div class="col-md-1 text-center text-muted">Thao tác</div>
                </div>
            </div>

            <div id="cart-body" class="mb-5">
                </div>

            <div class="shopee-footer-sticky bg-white shadow-lg border-top">
                <div class="container">
                    <div class="row align-items-center py-3">
                        <div class="col-md-6 d-none d-md-flex align-items-center">
                            <input type="checkbox" id="select-all-bottom" class="form-check-input custom-checkbox me-2">
                            <label for="select-all-bottom" class="mb-0 me-4 cursor-pointer">Chọn tất cả</label>
                            <button type="button" id="delete-selected" class="btn btn-link text-danger text-decoration-none p-0 shadow-none">Xóa đã chọn</button>
                        </div>
                        <div class="col-md-6 text-end d-flex align-items-center justify-content-end">
                            <div class="me-4">
                                <span class="text-dark">Tổng thanh toán:</span>
                                <span id="cart-total" class="fs-4 fw-bold text-danger ms-2">0 ₫</span>
                            </div>
                            <button type="button" id="checkout-selected" class="btn btn-danger btn-lg px-5 fw-bold btn-shopee-main">
                                Mua hàng
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="cart-empty" class="text-center py-5 bg-white shadow-sm rounded" style="display: none;">
            <img src="https://deo.shopeemobile.com/shopee/shopee-pcmall-live-sg/9bdd8040b334d31946f49e36be23d058.png" style="width: 120px;" class="mb-3">
            <h5 class="text-muted mb-4">Giỏ hàng của bạn còn trống</h5>
            <a href="{{ route('shop.index') }}" class="btn btn-danger px-5">MUA NGAY</a>
        </div>
    </div>
</section>

@endsection
@push('styles')
<style>
    /* DÙNG STYLE RIÊNG, TRÁNH BỊ CSS THEME ĐÈ LÊN NÚT + / - */
    .cart-item .wg-quantity {
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
        flex-wrap: nowrap !important;
        margin: 0 auto !important;
        padding: 4px 6px !important;
        background: #f5f5f5 !important;
        border: 1px solid #e5e7eb !important;
        border-radius: 999px !important;
        overflow: hidden !important;
        gap: 0 !important;
        min-width: 118px;
    }

    .cart-item .wg-quantity .btn-quantity {
        width: 32px !important;
        height: 32px !important;
        min-width: 32px !important;
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
        position: static !important;
        float: none !important;
        margin: 0 !important;
        padding: 0 !important;
        border: none !important;
        border-radius: 50% !important;
        background: transparent !important;
        color: #111827 !important;
        font-size: 18px !important;
        font-weight: 600 !important;
        line-height: 1 !important;
        cursor: pointer !important;
        box-shadow: none !important;
    }

    .cart-item .wg-quantity .btn-quantity:hover {
        background: #e9ecef !important;
        color: #ee4d2d !important;
    }

    .cart-item .wg-quantity .quantity-product {
        width: 42px !important;
        height: 32px !important;
        min-width: 42px !important;
        padding: 0 !important;
        margin: 0 2px !important;
        border: 0 !important;
        outline: none !important;
        background: transparent !important;
        text-align: center !important;
        font-size: 14px !important;
        font-weight: 600 !important;
        line-height: 32px !important;
        box-shadow: none !important;
        pointer-events: none !important;
    }

    /* Các thành phần khác */
    .custom-checkbox { width: 18px; height: 18px; border: 1px solid #c1c1c1; cursor: pointer; }
    .custom-checkbox:checked { background-color: #ee4d2d; border-color: #ee4d2d; }
    .cart-item { background: #fff; border-radius: 2px; margin-bottom: 12px; border-bottom: 1px solid rgba(0,0,0,.05); }
    .product-name { font-size: 14px; color: #222; font-weight: 500; }
    .price-subtotal { color: #ee4d2d; font-weight: 500; }
    .shopee-footer-sticky { position: sticky; bottom: 0; z-index: 999; margin: 0 -15px; }
    .btn-shopee-main { background-color: #ee4d2d; border: none; border-radius: 2px; }
</style>
@endpush

@push('scripts')
<script>
    function formatVND(number) {
        return new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(number);
    }

    document.addEventListener('DOMContentLoaded', function () {
        const loader = document.getElementById('cart-loader');
        const content = document.getElementById('cart-content');
        const empty = document.getElementById('cart-empty');
        const tbody = document.getElementById('cart-body');
        const totalEl = document.getElementById('cart-total');

        const cartDataUrl = "{{ route('cart.data') }}";
        const deleteMultipleUrl = "{{ route('cart.deleteMultiple') }}";
        const updateQuantityUrl = "{{ route('cart.updateQuantity', ':id') }}";
        const checkoutUrl = "{{ route('client.checkout.index') }}";

        fetch(cartDataUrl, { headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' } })
        .then(res => res.json())
        .then(data => {
            loader.style.display = 'none';
            if (data.success && data.cart?.items?.length > 0) {
                renderCart(data.cart.items);
                content.style.display = 'block';
                bindEvents();
            } else {
                empty.style.display = 'block';
            }
        });

        function renderCart(items) {
            tbody.innerHTML = items.map(item => {
                const variant = item.product_variant || {};
                const product = variant.product || {};
                const color = variant.color?.name || 'Mặc định';
                const size = variant.size?.name || 'Mặc định';
                const price = parseFloat(variant.price) || 0;
                const image = product.thumbnail ? `/storage/${product.thumbnail}` : 'https://via.placeholder.com/80';

                return `
                <div class="cart-item shadow-sm" data-id="${item.id}" data-price="${price}" data-max="${variant.stock || 999}">
                    <div class="row align-items-center py-4 px-3 mx-0">
                        <div class="col-md-1 text-center col-2">
                            <input type="checkbox" class="form-check-input custom-checkbox cart-checkbox" value="${item.id}">
                        </div>
                        <div class="col-md-4 col-10">
                            <div class="d-flex align-items-center">
                                <img src="${image}" class="rounded border" style="width: 80px; height: 80px; object-fit: cover;">
                                <div class="ms-3 text-start">
                                    <a href="/san-pham/${product.slug}" class="text-decoration-none product-name d-block">${product.name}</a>
                                    <div class="text-muted small">Phân loại: ${color}, ${size}</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2 text-center d-none d-md-block text-muted">
                            ${formatVND(price)}
                        </div>
                        <div class="col-md-2 text-center col-6">
                            <div class="wg-quantity">
                                <span class="btn-quantity minus">−</span>
                                <input type="text" value="${item.quantity}" class="quantity-product quantity" readonly>
                                <span class="btn-quantity plus">+</span>
                            </div>
                        </div>
                        <div class="col-md-2 text-center col-4">
                            <span class="price-subtotal">${formatVND(price * item.quantity)}</span>
                        </div>
                        <div class="col-md-1 text-center col-2">
                            <button type="button" class="btn btn-link text-muted p-0 cart-remove text-decoration-none small shadow-none">Xóa</button>
                        </div>
                    </div>
                </div>`;
            }).join('');
        }

        function bindEvents() {
            const selectAllTop = document.getElementById('select-all');
            const selectAllBottom = document.getElementById('select-all-bottom');
            
            [selectAllTop, selectAllBottom].forEach(mainCb => {
                if(!mainCb) return;
                mainCb.addEventListener('change', (e) => {
                    const status = e.target.checked;
                    if(selectAllTop) selectAllTop.checked = status;
                    if(selectAllBottom) selectAllBottom.checked = status;
                    document.querySelectorAll('.cart-checkbox').forEach(cb => cb.checked = status);
                    updateTotal();
                });
            });

            tbody.addEventListener('click', (e) => {
                const btn = e.target.closest('.plus, .minus');
                if (btn) {
                    const row = btn.closest('.cart-item');
                    let qty = parseInt(row.querySelector('.quantity').value);
                    const max = parseInt(row.dataset.max);
                    if (btn.classList.contains('plus')) {
                        if (qty >= max) return alert('Hết hàng!');
                        qty++;
                    } else {
                        if (qty <= 1) return;
                        qty--;
                    }
                    updateQuantity(row, qty);
                }
                if (e.target.closest('.cart-remove')) {
                    const row = e.target.closest('.cart-item');
                    if (confirm('Xóa sản phẩm này?')) {
                        deleteItems([row.dataset.id], () => {
                            row.remove();
                            updateTotal();
                        });
                    }
                }
            });

            tbody.addEventListener('change', (e) => {
                if (e.target.classList.contains('cart-checkbox')) updateTotal();
            });

            document.getElementById('delete-selected').addEventListener('click', () => {
                const ids = Array.from(document.querySelectorAll('.cart-checkbox:checked')).map(cb => cb.value);
                if (ids.length && confirm('Xóa các sản phẩm đã chọn?')) {
                    deleteItems(ids, () => location.reload());
                }
            });

            document.getElementById('checkout-selected').addEventListener('click', () => {
                const ids = Array.from(document.querySelectorAll('.cart-checkbox:checked')).map(cb => cb.value);
                if (!ids.length) return alert('Hãy chọn sản phẩm để thanh toán!');
                window.location.href = `${checkoutUrl}?type=selected&${ids.map(id => `ids[]=${id}`).join('&')}`;
            });
        }

        function updateTotal() {
            let total = 0;
            document.querySelectorAll('.cart-item').forEach(row => {
                if (row.querySelector('.cart-checkbox').checked) {
                    total += parseInt(row.querySelector('.quantity').value) * parseFloat(row.dataset.price);
                }
            });
            totalEl.textContent = formatVND(total);
        }

        function updateQuantity(row, newQty) {
            const id = row.dataset.id;
            fetch(updateQuantityUrl.replace(':id', id), {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                body: JSON.stringify({ quantity: newQty })
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    row.querySelector('.quantity').value = newQty;
                    row.querySelector('.price-subtotal').textContent = formatVND(newQty * row.dataset.price);
                    updateTotal();
                }
            });
        }

        function deleteItems(ids, callback) {
            fetch(deleteMultipleUrl, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                body: JSON.stringify({ ids })
            })
            .then(res => res.json())
            .then(data => data.success ? callback() : alert(data.message));
        }
    });
</script>
@endpush
