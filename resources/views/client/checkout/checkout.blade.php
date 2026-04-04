@extends('client.layout.layout')

@section('content')
    <!-- Title Page -->
    <section class="tf-page-title">
        <div class="container">
            <div class="box-title text-center">
                <h4 class="title">Thanh toán</h4>
                <div class="breadcrumb-list">
                    <a class="breadcrumb-item" href="{{ route('client.homeClient') }}">Trang chủ</a>
                    <div class="breadcrumb-item dot"><span></span></div>
                    <div class="breadcrumb-item current">Thanh toán</div>
                </div>
            </div>
        </div>
    </section>
    <!-- /Title Page -->
    <!-- Cart Section -->
    <div class="flat-spacing-13">
        <div class="container">
            @if (session('error'))
                <div class="alert alert-danger mb-4">{{ session('error') }}</div>
            @endif

            @if (session('success'))
                <div class="alert alert-success mb-4">{{ session('success') }}</div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger mb-4">
                    <ul class="mb-0 ps-3">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="row">
                <div class="col-xl-8">
                    <form id="checkout-form" class="tf-checkout-cart-main" action="{{ route('client.checkout.process') }}" method="POST">
                        @csrf
                        <input type="hidden" name="type" value="{{ $type }}">
                        @if ($type === 'selected')
                            @foreach ($selectedIds as $id)
                                <input type="hidden" name="ids[]" value="{{ $id }}">
                            @endforeach
                        @endif
                        <div class="box-ip-checkout">
                            <div class="title text-lg fw-medium">Thông tin thanh toán</div>
                            <fieldset class="tf-field style-2 style-3 mb_16">
                                <input class="tf-field-input tf-input @error('name') is-invalid @enderror" id="name"
                                    placeholder=" " type="text" name="name"
                                    value='{{ old('name', Auth::user()->name ?? '') }}' required>
                                <label class="tf-field-label" for="name">Họ tên <span
                                        class='text-danger'>*</span></label>
                            </fieldset>
                            <fieldset class="tf-field style-2 style-3 mb_16">
                                <div class="tf-select select-square">
                                    <select id='city' name='city' required>
                                        <option value="">Tỉnh/Thành phố</option>
                                        <option value='Hồ Chí Minh' {{ old('city') == 'Hồ Chí Minh' ? 'selected' : '' }}>Hồ
                                            Chí
                                            Minh</option>
                                        <option value='Hà Nội' {{ old('city') == 'Hà Nội' ? 'selected' : '' }}>Hà Nội
                                        </option>
                                        <option value='Đà Nẵng' {{ old('city') == 'Đà Nẵng' ? 'selected' : '' }}>Đà Nẵng
                                        </option>
                                    </select>
                                </div>
                            </fieldset>
                            <fieldset class="tf-field style-2 style-3 mb_16">
                                <div class="tf-select select-square">
                                    <select id='district' name='district' required>
                                        <option value=''>Chọn quận / huyện</option>
                                        <option value='Quận 1' {{ old('district') == 'Quận 1' ? 'selected' : '' }}>Quận 1
                                        </option>
                                        <option value='Quận 3' {{ old('district') == 'Quận 3' ? 'selected' : '' }}>Quận 3
                                        </option>
                                        <option value='Quận 10' {{ old('district') == 'Quận 10' ? 'selected' : '' }}>Quận
                                            10</option>
                                    </select>
                                </div>
                            </fieldset>
                            <fieldset class="tf-field style-2 style-3 mb_16">
                                <div class="tf-select select-square">
                                    <select class='form-control' id='ward' name='ward' required>
                                        <option value=''>Chọn xã / phường</option>
                                        <option value='Phường 1' {{ old('ward') == 'Phường 1' ? 'selected' : '' }}>Phường 1
                                        </option>
                                        <option value='Phường 2' {{ old('ward') == 'Phường 2' ? 'selected' : '' }}>Phường 2
                                        </option>
                                    </select>
                                </div>
                            </fieldset>
                            <fieldset class="tf-field style-2 style-3 mb_16">
                                <input class="tf-field-input tf-input @error('address') is-invalid @enderror" id="address"
                                    type="text" name="address" placeholder="" value='{{ old('address') }}' required>
                                <label class="tf-field-label" for="address">Địa chỉ chi tiết <span
                                        class='text-danger'>*</span></label>
                                @error('address')
                                    <div class='invalid-feedback'>{{ $message }}</div>
                                @enderror
                            </fieldset>
                            <fieldset class="tf-field style-2 style-3 mb_16">
                                <input class="tf-field-input tf-input @error('phone') is-invalid @enderror" id="phone"
                                    type="text" name="phone" placeholder=""
                                    value='{{ old('phone', Auth::user()->phone ?? '') }}' required>
                                <label class="tf-field-label" for="phone">Số điện thoại <span
                                        class='text-danger'>*</span></label>
                                @error('phone')
                                    <div class='invalid-feedback'>{{ $message }}</div>
                                @enderror
                            </fieldset>
                            <div class='col-md-12 mb-2'>
                                <label for='note'>Ghi chú</label>
                                <input type='text' class='form-control' id='note' name='note'
                                    value='{{ old('note') }}' placeholder='Nhập ghi chú'>
                            </div>
                            <div class='col-md-12 mb-2'>
                                <label for='voucher_code'>Mã voucher (nếu có)</label>
                                <input type='text' class='form-control' id='voucher_code' name='voucher_code'
                                    value='{{ old('voucher_code') }}' placeholder='Nhập mã voucher'>
                            </div>
                        </div>
                        <div class="box-ip-shipping">
                            <div class="title text-lg fw-medium">Phương thức thanh toán</div>
                            <fieldset>
                                <label class="check-ship">
                                    <input type='radio' name='payment_method' value='cod'
                                        {{ old('payment_method', 'cod') === 'cod' ? 'checked' : '' }}>
                                    <span class="text text-sm">
                                        <span>Thanh toán khi nhận hàng (COD)</span>
                                        <small class="d-block text-muted mt-1">Thanh toán sau khi nhận và kiểm tra hàng.</small>
                                    </span>
                                </label>
                            </fieldset>
                            <fieldset class="mb_16">
                                <label class="check-ship">
                                    <input type='radio' name='payment_method' value='vnpay'
                                        {{ old('payment_method') === 'vnpay' ? 'checked' : '' }}>
                                    <span class="text text-sm">
                                        <span>Thanh toán online qua VNPay</span>
                                        <small class="d-block text-muted mt-1">Hỗ trợ ATM nội địa, QR Code và Internet Banking.</small>
                                    </span>
                                </label>
                            </fieldset>
                        </div>
                    </form>
                </div>
                <div class="col-xl-4">
                    <div class="tf-page-cart-sidebar">
                        <div class="cart-box order-box">
                            <div class="title text-lg fw-medium">Tóm tắt đơn hàng</div>
                            <ul class="list-order-product">
                                @if ($items->isEmpty())
                                    <p>Không có sản phẩm nào để thanh toán.</p>
                                @else
                                    @foreach ($items as $item)
                                        <li class="order-item">
                                            <figure class="img-product">
                                                <img src="{{ $item->productVariant->product->thumbnail
                                                    ? asset('storage/' . $item->productVariant->product->thumbnail)
                                                    : asset('client/images/products/product-not-found.jpg') }}"
                                                    alt="product">
                                                <span class="quantity">{{ $item->quantity }}</span>
                                            </figure>
                                            <div class="content">
                                                <div class="info">
                                                    <p class="name text-sm fw-medium">
                                                        {{ $item->productVariant->product->name }}
                                                    </p>
                                                    <span class="variant">
                                                        {{ $item->productVariant->attribute_name ?? 'Không có biến thể' }}
                                                    </span>
                                                </div>
                                                <span
                                                    class="price text-sm fw-medium">{{ number_format($item->total_price, 0, ',', '.') }}
                                                    ₫</span>
                                            </div>
                                        </li>
                                    @endforeach
                                @endif
                            </ul>
                            <ul class="list-total">
                                <li class="total-item text-sm d-flex justify-content-between">
                                    <span>Tạm tính:</span>
                                    <span class="price-sub fw-medium">{{ number_format($subtotal, 0, ',', '.') }} ₫</span>
                                </li>
                                <li class="total-item text-sm d-flex justify-content-between">
                                    <span>Phí vận chuyển:</span>
                                    <span class="price-discount fw-medium">{{ number_format($shipping, 0, ',', '.') }}
                                        ₫</span>
                                </li>
                                @if (isset($discount) && $discount > 0)
                                    <li class="total-item text-sm d-flex justify-content-between">
                                        <span>Giảm
                                            giá:</span>
                                        <span class="price-discount fw-medium">-{{ number_format($discount, 0, ',', '.') }}
                                            ₫</span>
                                    </li>
                                @endif
                            </ul>
                            <div class="subtotal text-lg fw-medium d-flex justify-content-between">
                                <span>Tổng cộng:</span>
                                <span class="total-price-order">{{ number_format($total, 0, ',', '.') }} ₫</span>
                            </div>
                            <div class="btn-order">
                                <button type="submit" id="place-order-btn" form="checkout-form"
                                    class="tf-btn btn-dark2 animate-btn w-100 text-transform-none">Đặt hàng</button>
                            </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /Cart Section -->
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const phoneInput = document.getElementById('phone');
            const paymentRadios = document.querySelectorAll('input[name="payment_method"]');
            const placeOrderBtn = document.getElementById('place-order-btn');

            if (phoneInput) {
                phoneInput.addEventListener('input', function(e) {
                    let value = e.target.value.replace(/\D/g, '');
                    if (value.length > 10) value = value.substring(0, 10);
                    e.target.value = value;
                });
            }

            const updateButtonText = () => {
                const selectedPayment = document.querySelector('input[name="payment_method"]:checked')?.value;

                if (!placeOrderBtn) {
                    return;
                }

                placeOrderBtn.textContent = selectedPayment === 'vnpay'
                    ? 'Thanh toán với VNPay'
                    : 'Đặt hàng';
            };

            paymentRadios.forEach(radio => {
                radio.addEventListener('change', updateButtonText);
            });

            updateButtonText();
        });
    </script>
@endpush
