@extends('client.layout.layout')

@section('content')
    <!-- Breadcrumb -->
    <section class="section-breadcrumb py-4 bg-light">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('client.homeClient') }}" class="text-decoration-none">Trang chủ</a></li>
                    <li class=" active fw-bold" aria-current="page">->Giỏ hàng</li>
                </ol>
            </nav>
        </div>
    </section>

    <!-- Cart Section -->
    <section class="section-cart py-8">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10 col-xl-9">
                    <div class="card shadow-sm border-0">
                        <div class="card-body p-4 p-md-5">
                            <h2 class="card-title mb-4 fw-bold text-center text-dark">Giỏ hàng của bạn</h2>

                            <!-- Loading -->
                            <div id="cart-loader" class="text-center py-5">
                                <div class="spinner-border text-primary" role="status" style="width: 3rem; height: 3rem;">
                                    <span class="visually-hidden">Đang tải...</span>
                                </div>
                                <p class="mt-3 text-muted">Đang tải giỏ hàng...</p>
                            </div>

                            <!-- Cart Content -->
                            <div id="cart-content" style="display: none;">
                                <div class="table-responsive">
                                    <table class="table table-hover align-middle text-center">
                                        <thead class="table-light">
                                            <tr>
                                                <th scope="col" class="text-start ps-4">
                                                    <input type="checkbox" id="select-all" class="form-check-input">
                                                </th>
                                                <th scope="col" class="text-start">Sản phẩm</th>
                                                <th scope="col">Phân loại</th>
                                                <th scope="col">Đơn giá</th>
                                                <th scope="col">Số lượng</th>
                                                <th scope="col">Thành tiền</th>
                                                <th scope="col"> Xóa</th>
                                            </tr>
                                        </thead>
                                        <tbody id="cart-body"></tbody>
                                    </table>
                                </div>

                                <!-- Tổng tiền & Action -->
                                <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mt-4 pt-4 border-top">
                                    <a href="{{ route('shop.index') }}" class="btn btn-outline-secondary mb-3 mb-md-0">
                                        <i class="ri-arrow-left-line me-2"></i> Tiếp tục mua sắm
                                    </a>

                                    <div class="text-end">
                                        <h5 class="mb-3">Tổng tiền: <span id="cart-total" class="fw-bold text-danger fs-4">0 ₫</span></h5>
                                        <div class="d-flex gap-3 justify-content-end">
                                            <button type="button" id="delete-selected" class="btn btn-outline-danger">
                                                <i class="ri-delete-bin-line me-2"></i> Xóa đã chọn
                                            </button>
                                            <button type="button" id="checkout-selected" class="btn btn-success px-5">
                                                Thanh toán <i class="ri-arrow-right-line ms-2"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Empty Cart -->
                            <div id="cart-empty" class="text-center py-5" style="display: none;">
                                <div class="mb-4">
                                    <i class="ri-shopping-cart-line ri-5x text-muted"></i>
                                </div>
                                <h4 class="text-muted mb-3">Giỏ hàng của bạn đang trống</h4>
                                <p class="text-muted mb-4">Hãy thêm sản phẩm yêu thích vào giỏ ngay bây giờ!</p>
                                <a href="{{ route('client.homeClient') }}" class="btn btn-primary btn-lg px-5">
                                    Bắt đầu mua sắm
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        
    </section>


@push('styles')
<style>
    .table th, .table td {
        vertical-align: middle !important;
    }
    .table-hover tbody tr:hover {
        background-color: rgba(0,123,255,0.05);
    }
    .quantity-input-group {
        max-width: 140px;
        margin: 0 auto;
    }
    .product-img {
        width: 80px;
        height: 80px;
        object-fit: cover;
        border-radius: 8px;
        border: 1px solid #eee;
    }
    .cart-subtotal {
        font-weight: 600;
        color: #e74c3c;
    }
</style>
@endpush

@push('scripts')
<script>
    // ====================== FORMAT TIỀN VIỆT NAM ======================
    function formatVND(number) {
        return Number(number).toLocaleString('vi-VN') + ' ₫';
    }

    document.addEventListener('DOMContentLoaded', function () {

        // Elements
        const loader        = document.getElementById('cart-loader');
        const content       = document.getElementById('cart-content');
        const empty         = document.getElementById('cart-empty');
        const tbody         = document.getElementById('cart-body');
        const totalEl       = document.getElementById('cart-total');
        const selectAll     = document.getElementById('select-all');
        const deleteBtn     = document.getElementById('delete-selected');
        const checkoutBtn   = document.getElementById('checkout-selected');

        // URLs
        const cartDataUrl       = "{{ route('cart.data') }}";
        const deleteMultipleUrl = "{{ route('cart.deleteMultiple') }}";
        const updateQuantityUrl = "{{ route('cart.updateQuantity', ':id') }}";
        const checkoutUrl       = "{{ route('client.checkout.index') }}";

        // Load giỏ hàng
        fetch(cartDataUrl, {
            credentials: 'same-origin',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        })
        .then(response => {
            if (!response.ok) {
                if (response.status === 401) {
                    window.location.href = "{{ route('auth.login') }}";
                }
                throw new Error('Lỗi tải dữ liệu');
            }
            return response.json();
        })
        .then(data => {
            loader.style.display = 'none';

            if (!data.success || !data.cart?.items?.length) {
                empty.style.display = 'block';
                return;
            }

            renderCart(data.cart.items);
            updateTotal();
            bindEvents();
            content.style.display = 'block';
        })
        .catch(error => {
            console.error(error);
            loader.innerHTML = `<div class="alert alert-danger">Không thể tải giỏ hàng. Vui lòng thử lại sau.</div>`;
        });

        // ====================== RENDER GIỎ HÀNG ======================
        function renderCart(items) {
            tbody.innerHTML = items.map(item => {
                const variant = item.product_variant || {};
                const product = variant.product || {};
                const color   = variant.color || {};
                const size    = variant.size || {};

                if (!product.id) return '';

                const price     = parseFloat(variant.price) || 0;
                const quantity  = parseInt(item.quantity) || 1;
                const subtotal  = price * quantity;
                const image     = product.thumbnail 
                    ? `/storage/${product.thumbnail}` 
                    : 'https://via.placeholder.com/80x80?text=No+Image';

                // Phân loại = Màu + Size
                let variantInfo = [];
                if (color.name)   variantInfo.push(`Màu: ${color.name}`);
                if (size.name)    variantInfo.push(`Size: ${size.name}`);

                return `
                <tr data-id="${item.id}" data-price="${price}" data-max="${variant.stock || 999}">
                    <td class="ps-4 align-middle">
                        <input type="checkbox" class="form-check-input cart-checkbox" value="${item.id}">
                    </td>
                    <td class="align-middle">
                        <div class="d-flex align-items-center gap-3">
                            <a href="/san-pham/${product.slug || '#'}">
                                <img src="${image}" alt="${product.name}" class="rounded" 
                                     style="width: 70px; height: 70px; object-fit: cover;">
                            </a>
                            <div>
                                <a href="/san-pham/${product.slug || '#'}" 
                                   class="fw-bold text-dark text-decoration-none">
                                    ${product.name}
                                </a>
                            </div>
                        </div>
                    </td>
                   <td class="align-middle text-start">
                <div class="d-flex flex-column align-items-start gap-1">
                    <span class="badge bg-light text-dark px-3 py-1">
                        <strong>Màu:</strong> ${color.name || '—'}
                    </span>
                    <span class="badge bg-light text-dark px-3 py-1">
                        <strong>Size:</strong> ${size.name || '—'}
                    </span>
                </div>
            </td>
                    <td class="align-middle text-center fw-semibold">${formatVND(price)}</td>
                    <td class="align-middle text-center">
                        <div class="input-group input-group-sm justify-content-center" style="max-width: 140px; margin: 0 auto;">
                            <button type="button" class="btn btn-outline-secondary btn-sm minus">-</button>
                            <input type="text" value="${quantity}" class="form-control text-center quantity" readonly style="max-width: 60px;">
                            <button type="button" class="btn btn-outline-secondary btn-sm plus">+</button>
                        </div>
                    </td>
                    <td class="align-middle text-end cart-subtotal fw-semibold">${formatVND(subtotal)}</td>
                    <td class="align-middle text-end">
                        <button type="button" class="btn btn-outline-danger btn-sm cart-remove">
                            <i class="ri-delete-bin-line fs-5"></i>
                        </button>
                    </td>
                </tr>`;
            }).join('');
        }

        // Cập nhật tổng tiền
        function updateTotal() {
            let total = 0;
            document.querySelectorAll('tr[data-price]').forEach(row => {
                const qty   = parseInt(row.querySelector('.quantity').value) || 0;
                const price = parseFloat(row.dataset.price) || 0;
                total += qty * price;
            });
            if (totalEl) totalEl.textContent = formatVND(total);
        }

        // Bind tất cả sự kiện
        function bindEvents() {
            // Chọn tất cả
            if (selectAll) {
                selectAll.addEventListener('change', () => {
                    document.querySelectorAll('.cart-checkbox').forEach(cb => cb.checked = selectAll.checked);
                });
            }

            // Xóa nhiều sản phẩm
            if (deleteBtn) {
                deleteBtn.addEventListener('click', () => {
                    const ids = getSelectedIds();
                    if (!ids.length) return alert('Vui lòng chọn ít nhất một sản phẩm để xóa!');

                    if (!confirm('Bạn có chắc muốn xóa các sản phẩm đã chọn?')) return;

                    fetch(deleteMultipleUrl, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({ ids: ids })
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            alert('Đã xóa thành công!');
                            location.reload();
                        } else {
                            alert(data.message || 'Có lỗi xảy ra!');
                        }
                    })
                    .catch(() => alert('Lỗi kết nối server!'));
                });
            }

            // Checkout
            if (checkoutBtn) {
                checkoutBtn.addEventListener('click', () => {
                    const ids = getSelectedIds();
                    let url = checkoutUrl;

                    if (ids.length > 0) {
                        url += '?type=selected&' + ids.map(id => `ids[]=${id}`).join('&');
                    } else {
                        url += '?type=full';
                    }

                    window.location.href = url;
                });
            }

            // Tăng / Giảm số lượng
            tbody.addEventListener('click', function(e) {
                const btn = e.target.closest('.plus, .minus');
                if (!btn) return;

                const row       = btn.closest('tr');
                const input     = row.querySelector('.quantity');
                let quantity    = parseInt(input.value) || 1;
                const maxStock  = parseInt(row.dataset.max) || 999;

                if (btn.classList.contains('plus')) {
                    if (quantity >= maxStock) {
                        alert('Đã đạt số lượng tối đa có sẵn!');
                        return;
                    }
                    quantity++;
                } else {
                    quantity = Math.max(1, quantity - 1);
                }

                updateQuantity(row, quantity);
            });

            // Xóa 1 sản phẩm
            tbody.addEventListener('click', function(e) {
                if (!e.target.closest('.cart-remove')) return;

                const row = e.target.closest('tr');
                const id  = row.dataset.id;

                if (!confirm('Xóa sản phẩm này khỏi giỏ hàng?')) return;

                fetch(deleteMultipleUrl, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ ids: [id] })
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        row.remove();
                        updateTotal();
                    } else {
                        alert(data.message || 'Xóa thất bại!');
                    }
                })
                .catch(() => alert('Lỗi kết nối!'));
            });
        }

        // Lấy danh sách ID đã chọn
        function getSelectedIds() {
            return Array.from(document.querySelectorAll('.cart-checkbox:checked'))
                        .map(cb => cb.value);
        }

        // Cập nhật số lượng (AJAX)
        function updateQuantity(row, newQuantity) {
            const id          = row.dataset.id;
            const price       = parseFloat(row.dataset.price);
            const subtotalEl  = row.querySelector('.cart-subtotal');
            const oldQuantity = parseInt(row.querySelector('.quantity').value);

            fetch(updateQuantityUrl.replace(':id', id), {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ quantity: newQuantity })
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    row.querySelector('.quantity').value = newQuantity;
                    subtotalEl.textContent = formatVND(price * newQuantity);
                    updateTotal();
                } else {
                    alert(data.message || 'Không thể cập nhật số lượng!');
                    row.querySelector('.quantity').value = oldQuantity;
                }
            })
            .catch(() => {
                alert('Lỗi kết nối!');
                row.querySelector('.quantity').value = oldQuantity;
            });
        }
    });
</script>
@endpush
@endsection