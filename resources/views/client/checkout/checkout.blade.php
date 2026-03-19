@extends('client.layout.layout')

@section('content')
<!-- Breadcrumb -->
<section class="section-breadcrumb">
    <div class="cr-breadcrumb-image">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="cr-breadcrumb-title">
                        <h2>Thanh toán</h2>
                        <span> <a href="{{ route('client.homeClient') }}">Trang chủ</a> / <a href="{{ route('cart.view') }}">Giỏ hàng</a> / Thanh toán</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Checkout -->
<section class="section-checkout padding-t-100">
    <div class="container">
        <div class="row">
            <!-- Order Summary -->
            <div class="col-lg-6">
                <div class="cr-checkout-left">
                    <div class="cr-checkout-content" data-aos="fade-up" data-aos-duration="2000" data-aos-delay="400">
                        <div class="cr-checkout-inner">
                            <div class="cr-checkout-wrap">
                                <div class="cr-checkout-block">
                                    <h3 class="cr-checkout-title">Thông tin đơn hàng</h3>
                                    <div class="cr-checkout-block-content">
                                        @foreach($items as $item)
                                            <div class="cr-checkout-product">
                                                <div class="cr-checkout-pro">
                                                    <div class="cr-product-inner">
                                                        <div class="cr-pro-image-outer">
                                                            <div class="cr-pro-image">
                                                                <a href="#" class="image-outer">
                                                                    <img src="{{ asset('storage/' . $item->productVariant->product->thumbnail) }}" alt="{{ $item->productVariant->product->name }}" class="main-image">
                                                                </a>
                                                            </div>
                                                        </div>
                                                        <div class="cr-pro-content cr-product-details">
                                                            <h5 class="cr-pro-title">
                                                                <a href="#">{{ $item->productVariant->product->name }}</a>
                                                            </h5>
                                                            <p class="cr-price">
                                                                <span class="new-price">{{ number_format($item->productVariant->price, 0, ',', '.') }} ₫</span>
                                                                <span class="old-price">{{ $item->quantity }} x</span>
                                                            </p>
                                                            @if($item->productVariant->attribute_name)
                                                                <p class="cr-variation">Loại: {{ $item->productVariant->attribute_name }}</p>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="cr-product-quantity">
                                                    <span>{{ $item->quantity }}</span>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Checkout Form -->
            <div class="col-lg-6">
                <div class="cr-checkout-right" data-aos="fade-up" data-aos-duration="2000" data-aos-delay="600">
                    <form action="{{ route('client.checkout.process') }}" method="POST">
                        @csrf
                        @if($type === 'selected')
                            <input type="hidden" name="type" value="selected">
                            @foreach($selectedIds as $id)
                                <input type="hidden" name="ids[]" value="{{ $id }}">
                            @endforeach
                        @endif

                        <div class="cr-checkout-content">
                            <div class="cr-checkout-inner">
                                <div class="cr-checkout-wrap">
                                    <!-- Customer Information -->
                                    <div class="cr-checkout-block">
                                        <h3 class="cr-checkout-title">Thông tin khách hàng</h3>
                                        <div class="cr-checkout-block-content">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="name" class="form-label">Họ tên <span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', Auth::user()->name) }}" required>
                                                        @error('name')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="phone" class="form-label">Số điện thoại <span class="text-danger">*</span></label>
                                                        <input type="tel" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" value="{{ old('phone') }}" required>
                                                        @error('phone')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="address" class="form-label">Địa chỉ giao hàng <span class="text-danger">*</span></label>
                                                        <textarea class="form-control @error('address') is-invalid @enderror" id="address" name="address" rows="3" required>{{ old('address') }}</textarea>
                                                        @error('address')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="note" class="form-label">Ghi chú</label>
                                                        <textarea class="form-control @error('note') is-invalid @enderror" id="note" name="note" rows="2" placeholder="Ghi chú về đơn hàng (tùy chọn)">{{ old('note') }}</textarea>
                                                        @error('note')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Payment Method -->
                                    <div class="cr-checkout-block">
                                        <h3 class="cr-checkout-title">Phương thức thanh toán</h3>
                                        <div class="cr-checkout-block-content">
                                            <div class="cr-payment-method">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="payment_method" id="cod" value="cod" checked>
                                                    <label class="form-check-label" for="cod">
                                                        <strong>Thanh toán khi nhận hàng (COD)</strong>
                                                        <p class="mb-0 text-muted">Thanh toán bằng tiền mặt khi nhận hàng tại nhà</p>
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="payment_method" id="bank" value="bank_transfer">
                                                    <label class="form-check-label" for="bank">
                                                        <strong>Chuyển khoản ngân hàng</strong>
                                                        <p class="mb-0 text-muted">Thanh toán qua chuyển khoản ngân hàng</p>
                                                    </label>
                                                </div>
                                                @error('payment_method')
                                                    <div class="text-danger mt-2">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Order Total -->
            <div class="col-12">
                <div class="cr-checkout-right" data-aos="fade-up" data-aos-duration="2000" data-aos-delay="800">
                    <div class="cr-checkout-content">
                        <div class="cr-checkout-inner">
                            <div class="cr-checkout-wrap">
                                <div class="cr-checkout-block">
                                    <h3 class="cr-checkout-title">Tổng đơn hàng</h3>
                                    <div class="cr-checkout-block-content">
                                        <div class="cr-checkout-summary">
                                            <div class="cr-checkout-row">
                                                <span>Tạm tính</span>
                                                <span>{{ number_format($subtotal, 0, ',', '.') }} ₫</span>
                                            </div>
                                            <div class="cr-checkout-row">
                                                <span>Phí vận chuyển</span>
                                                <span>{{ number_format($shipping, 0, ',', '.') }} ₫</span>
                                            </div>
                                            <div class="cr-checkout-row cr-checkout-total">
                                                <span>Tổng cộng</span>
                                                <span>{{ number_format($total, 0, ',', '.') }} ₫</span>
                                            </div>
                                        </div>
                                        <div class="cr-checkout-btn">
                                            <button type="submit" class="cr-button btn btn-success w-100">
                                                <i class="ri-shopping-bag-line"></i> Đặt hàng
                                            </button>
                                            <a href="{{ route('cart.view') }}" class="cr-links mt-3 d-block text-center">
                                                <i class="ri-arrow-left-line"></i> Quay lại giỏ hàng
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto format phone number
    const phoneInput = document.getElementById('phone');
    phoneInput.addEventListener('input', function(e) {
        let value = e.target.value.replace(/\D/g, '');
        if (value.length >= 10) {
            value = value.substring(0, 10);
        }
        e.target.value = value;
    });
});
</script>
@endpush