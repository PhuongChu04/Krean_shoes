@extends('client.layout.layout')

@section('content')
    <section class='section-breadcrumb'>
        <div class='cr-breadcrumb-image'>
            <div class='container'>
                <div class='row'>
                    <div class='col-lg-12'>
                        <div class='cr-breadcrumb-title'>
                            <h2>Thanh toán</h2>
                            <span> <a href='{{ route('client.homeClient') }}'>Trang chủ</a> / <a href='{{ route('cart.view') }}'>Giỏ hàng</a> / Thanh toán</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class='cr-checkout-section padding-tb-100'>
        <div class='container'>
            <div class='row'>
                <div class='cr-checkout-rightside col-lg-4 col-md-12'>
                    <div class='cr-sidebar-wrap'>
                        <div class='cr-sidebar-block'>
                            <div class='cr-sb-title'><h3 class='cr-sidebar-title'>Thông tin đơn hàng</h3></div>
                            <hr>
                            <div class='cr-sb-block-content'>
                                @if($items->isEmpty())
                                    <p>Không có sản phẩm nào để thanh toán.</p>
                                @else
                                    @foreach($items as $item)
                                        <div class='cr-checkout-pro mb-2'>
                                            <div class='cr-product-inner d-flex align-items-center'>
                                                <div class='cr-pro-image-outer me-2'>
                                                    <div class='cr-pro-image'>
                                                        <a href='/san-pham/{{ $item->productVariant->product->slug }}' class='image'>
                                                            <img height='80px' class='main-image' src='{{ asset('storage/' . $item->productVariant->product->thumbnail) }}' alt='{{ $item->productVariant->product->name }}'>
                                                        </a>
                                                    </div>
                                                </div>
                                                <div class='cr-pro-content cr-product-details'>
                                                    <h5 class='cr-pro-title'><a href='/san-pham/{{ $item->productVariant->product->slug }}'>{{ $item->productVariant->product->name }}{{ $item->productVariant->attribute_name ? ' (' . $item->productVariant->attribute_name . ')' : '' }}</a></h5>
                                                    <p class='cr-price mb-0'>
                                                        <span class='new-price'>{{ number_format($item->productVariant->price, 0, ',', '.') }} ₫</span>
                                                        <span class='text-muted'> x{{ $item->quantity }}</span>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class='cr-sidebar-wrap cr-checkout-pay-wrap mt-3'>
                        <div class='cr-sidebar-block'>
                            <div class='cr-sb-title'><h3 class='cr-sidebar-title'>Phương thức thanh toán</h3></div>
                            <div class='cr-sb-block-content'>
                                <div class='cr-checkout-pay'>
                                    <div class='cr-pay-desc'>Vui lòng chọn phương thức thanh toán</div>
                                    <div class='cr-pay-option'>
                                        <label class='d-block'><input type='radio' name='payment_method' value='cod' checked> Thanh toán khi nhận hàng (COD)</label>
                                        <label class='d-block'><input type='radio' name='payment_method' value='bank_transfer'> Chuyển khoản ngân hàng</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class='cr-checkout-leftside col-lg-8 col-md-12 m-t-991'>
                    <div class='cr-checkout-content'>
                        <div class='cr-checkout-inner'>
                            <div class='cr-checkout-wrap'>
                                <div class='cr-checkout-block cr-check-bill'>
                                    <h3 class='cr-checkout-title'>Thông tin khách hàng</h3>
                                    <div class='cr-bl-block-content'>
                                        <div class='cr-check-bill-form mb-minus-24'>
                                            <form id='checkout-form' action='{{ route('client.checkout.process') }}' method='POST'>
                                                @csrf
                                                @if($type === 'selected')
                                                    <input type='hidden' name='type' value='selected'>
                                                    @foreach($selectedIds as $id)
                                                        <input type='hidden' name='ids[]' value='{{ $id }}'>
                                                    @endforeach
                                                @endif

                                                <div class='row'>
                                                    <div class='col-md-6'>
                                                        <div class='form-group'>
                                                            <label for='name' class='form-label'>Họ và tên <span class='text-danger'>*</span></label>
                                                            <input type='text' class="form-control @error('name') is-invalid @enderror" id='name' name='name' value='{{ old('name', Auth::user()->name ?? '') }}' required>
                                                            @error('name')
                                                                <div class='invalid-feedback'>{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class='col-md-6'>
                                                        <div class='form-group'>
                                                            <label for='phone' class='form-label'>Số điện thoại <span class='text-danger'>*</span></label>
                                                            <input type='tel' class="form-control @error('phone') is-invalid @enderror" id='phone' name='phone' value='{{ old('phone', Auth::user()->phone ?? '') }}' required>
                                                            @error('phone')
                                                                <div class='invalid-feedback'>{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class='col-md-12 mb-2'>
                                                        <label for='city'>Thành phố</label>
                                                        <select class='form-control' id='city' name='city' required>
                                                            <option value=''>Chọn tỉnh / thành</option>
                                                            <option value='Hồ Chí Minh' {{ old('city') == 'Hồ Chí Minh' ? 'selected' : '' }}>Hồ Chí Minh</option>
                                                            <option value='Hà Nội' {{ old('city') == 'Hà Nội' ? 'selected' : '' }}>Hà Nội</option>
                                                            <option value='Đà Nẵng' {{ old('city') == 'Đà Nẵng' ? 'selected' : '' }}>Đà Nẵng</option>
                                                        </select>
                                                    </div>
                                                    <div class='col-md-6 mb-2'>
                                                        <label for='district'>Quận / Huyện</label>
                                                        <select class='form-control' id='district' name='district' required>
                                                            <option value=''>Chọn quận / huyện</option>
                                                            <option value='Quận 1' {{ old('district') == 'Quận 1' ? 'selected' : '' }}>Quận 1</option>
                                                            <option value='Quận 3' {{ old('district') == 'Quận 3' ? 'selected' : '' }}>Quận 3</option>
                                                            <option value='Quận 10' {{ old('district') == 'Quận 10' ? 'selected' : '' }}>Quận 10</option>
                                                        </select>
                                                    </div>
                                                    <div class='col-md-6 mb-2'>
                                                        <label for='ward'>Xã / Phường</label>
                                                        <select class='form-control' id='ward' name='ward' required>
                                                            <option value=''>Chọn xã / phường</option>
                                                            <option value='Phường 1' {{ old('ward') == 'Phường 1' ? 'selected' : '' }}>Phường 1</option>
                                                            <option value='Phường 2' {{ old('ward') == 'Phường 2' ? 'selected' : '' }}>Phường 2</option>
                                                        </select>
                                                    </div>
                                                    <div class='col-md-12 mb-2'>
                                                        <label for='address'>Địa chỉ chi tiết</label>
                                                        <input type='text' class='form-control' id='address' name='address' value='{{ old('address') }}' placeholder='Ví dụ: 123 đường A, khu B' required>
                                                    </div>
                                                    <div class='col-md-12 mb-2'>
                                                        <label for='note'>Ghi chú</label>
                                                        <input type='text' class='form-control' id='note' name='note' value='{{ old('note') }}' placeholder='Nhập ghi chú'>
                                                    </div>
                                                </div>

                                                <div class='cr-checkout-btn mt-3'>
                                                    <button type='submit' class='cr-button btn btn-success w-100'><i class='ri-shopping-bag-line'></i> Đặt hàng</button>
                                                    <a href='{{ route('cart.view') }}' class='cr-links mt-3 d-block text-center'><i class='ri-arrow-left-line'></i> Quay lại giỏ hàng</a>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class='cr-checkout-block mt-3'>
                                    <h3 class='cr-checkout-title'>Tổng đơn hàng</h3>
                                    <div class='cr-checkout-block-content'>
                                        <div class='cr-checkout-summary'>
                                            <div class='cr-checkout-row'><span>Tạm tính</span><span>{{ number_format($subtotal, 0, ',', '.') }} ₫</span></div>
                                            <div class='cr-checkout-row'><span>Phí vận chuyển</span><span>{{ number_format($shipping, 0, ',', '.') }} ₫</span></div>
                                            <div class='cr-checkout-row cr-checkout-total'><span>Tổng cộng</span><span>{{ number_format($total, 0, ',', '.') }} ₫</span></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const phoneInput = document.getElementById('phone');
        if (phoneInput) {
            phoneInput.addEventListener('input', function (e) {
                let value = e.target.value.replace(/\D/g, '');
                if (value.length > 10) value = value.substring(0, 10);
                e.target.value = value;
            });
        }
    });
</script>
@endpush
