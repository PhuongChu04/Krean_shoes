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

                            <!-- Address Selection -->
                            <fieldset class="tf-field style-2 style-3 mb_16">
                                <div class="tf-select select-square">
                                    @php
                                        $selectedAddressId = old('address_id') ?: optional($addresses->firstWhere('is_default', true))->id;
                                    @endphp
                                    <select id='address_id' name='address_id' required class="@error('address_id') is-invalid @enderror">
                                        <option value="">Chọn địa chỉ giao hàng</option>
                                        @foreach($addresses as $address)
                                            <option value="{{ $address->id }}" {{ $selectedAddressId == $address->id ? 'selected' : '' }}>
                                                {{ $address->name }} - {{ $address->phone }} - {{ $address->full_address }}
                                                @if($address->is_default) (Mặc định) @endif
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('address_id')
                                    <div class='invalid-feedback'>{{ $message }}</div>
                                @enderror
                            </fieldset>

                            <!-- Add New Address Button -->
                            <div class="mb_16">
                                <button type="button" class="tf-btn btn-outline-dark btn-sm" data-bs-toggle="modal" data-bs-target="#addAddressModal">
                                    <i class="icon-plus"></i> Thêm địa chỉ mới
                                </button>
                            </div>

                            <!-- Voucher Selection -->
                            <fieldset class="tf-field style-2 style-3 mb_16">
                                <div class="tf-select select-square">
                                    <select id='voucher_id' name='voucher_id' class="@error('voucher_id') is-invalid @enderror">
                                        <option value="">Chọn voucher (không bắt buộc)</option>
                                        @foreach($availableVouchers as $voucher)
                                            <option value="{{ $voucher->id }}" {{ old('voucher_id') == $voucher->id ? 'selected' : '' }}>
                                                {{ $voucher->code }} - {{ $voucher->type === 'percentage' ? $voucher->discount_amount . '%' : number_format($voucher->discount_amount, 0, ',', '.') . '₫' }}
                                                @if($voucher->max_discount) (Giảm tối đa {{ number_format($voucher->max_discount, 0, ',', '.') }}₫) @endif
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('voucher_id')
                                    <div class='invalid-feedback'>{{ $message }}</div>
                                @enderror
                            </fieldset>

                            <div class='col-md-12 mb-2'>
                                <label for='note'>Ghi chú</label>
                                <input type='text' class='form-control' id='note' name='note'
                                    value='{{ old('note') }}' placeholder='Nhập ghi chú'>
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
                                    <span id="summary-subtotal" class="price-sub fw-medium">{{ number_format($subtotal, 0, ',', '.') }} ₫</span>
                                </li>
                                <li class="total-item text-sm d-flex justify-content-between">
                                    <span>Phí vận chuyển:</span>
                                    <span id="summary-shipping" class="price-discount fw-medium">{{ number_format($shipping, 0, ',', '.') }} ₫</span>
                                </li>
                                <li id="summary-discount-row" class="total-item text-sm d-flex justify-content-between" style="display: none;">
                                    <span>Giảm giá:</span>
                                    <span id="summary-discount" class="price-discount fw-medium">-0 ₫</span>
                                </li>
                            </ul>
                            <div class="subtotal text-lg fw-medium d-flex justify-content-between">
                                <span>Tổng cộng:</span>
                                <span id="summary-total" class="total-price-order">{{ number_format($total, 0, ',', '.') }} ₫</span>
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

    <!-- Add Address Modal -->
    <div class="modal fade" id="addAddressModal" tabindex="-1" aria-labelledby="addAddressModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addAddressModalLabel">Thêm địa chỉ mới</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="add-address-form" action="{{ route('client.addresses.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="modal_name" class="form-label">Họ tên <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="modal_name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="modal_phone" class="form-label">Số điện thoại <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="modal_phone" name="phone" required>
                        </div>
                        <div class="mb-3">
                            <label for="modal_province" class="form-label">Tỉnh/Thành phố <span class="text-danger">*</span></label>
                            <select class="form-control" id="modal_province" name="province" required>
                                <option value="">Chọn tỉnh/thành phố</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="modal_district" class="form-label">Quận/Huyện <span class="text-danger">*</span></label>
                            <select class="form-control" id="modal_district" name="district" required>
                                <option value="">Chọn quận/huyện</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="modal_ward" class="form-label">Phường/Xã <span class="text-danger">*</span></label>
                            <select class="form-control" id="modal_ward" name="ward" required>
                                <option value="">Chọn phường/xã</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="modal_address" class="form-label">Địa chỉ chi tiết <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="modal_address" name="address" required>
                        </div>
                        <div class="mb-3">
                            <label for="modal_type" class="form-label">Loại địa chỉ</label>
                            <select class="form-control" id="modal_type" name="type">
                                <option value="home">Nhà riêng</option>
                                <option value="work">Văn phòng</option>
                                <option value="other">Khác</option>
                            </select>
                        </div>
                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="modal_is_default" name="is_default" value="1">
                            <label class="form-check-label" for="modal_is_default">Đặt làm địa chỉ mặc định</label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                        <button type="submit" class="btn btn-primary">Thêm địa chỉ</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const paymentRadios = document.querySelectorAll('input[name="payment_method"]');
            const placeOrderBtn = document.getElementById('place-order-btn');
            const addAddressForm = document.getElementById('add-address-form');
            const modalProvince = document.getElementById('modal_province');
            const modalDistrict = document.getElementById('modal_district');
            const modalWard = document.getElementById('modal_ward');
            const voucherSelect = document.getElementById('voucher_id');
            const summaryDiscountRow = document.getElementById('summary-discount-row');
            const summaryDiscount = document.getElementById('summary-discount');
            const summaryTotal = document.getElementById('summary-total');
            const addressApiBase = @json(route('client.addresses.locationData'));
            const oldProvince = @json(old('province'));
            const oldDistrict = @json(old('district'));
            const oldWard = @json(old('ward'));
            const subtotalAmount = {{ $subtotal }};
            const shippingAmount = {{ $shipping }};
            @php
                $voucherJsData = $availableVouchers->map(function ($voucher) {
                    return [
                        'id' => $voucher->id,
                        'code' => $voucher->code,
                        'type' => $voucher->type,
                        'discount_amount' => $voucher->discount_amount,
                        'max_discount' => $voucher->max_discount,
                    ];
                })->toArray();
            @endphp
            const voucherData = @json($voucherJsData);

            const updateButtonText = () => {
                const selectedPayment = document.querySelector('input[name="payment_method"]:checked')?.value;

                if (!placeOrderBtn) {
                    return;
                }

                placeOrderBtn.textContent = selectedPayment === 'vnpay'
                    ? 'Thanh toán với VNPay'
                    : 'Đặt hàng';
            };

            const formatCurrency = amount => {
                return new Intl.NumberFormat('vi-VN').format(amount) + ' ₫';
            };

            const updateSummaryForVoucher = () => {
                if (!voucherSelect) {
                    return;
                }

                const selectedVoucherId = parseInt(voucherSelect.value, 10);
                const selectedVoucher = voucherData.find(v => v.id === selectedVoucherId);

                if (!selectedVoucher) {
                    summaryDiscountRow.style.display = 'none';
                    summaryTotal.textContent = formatCurrency(subtotalAmount + shippingAmount);
                    return;
                }

                let discount = 0;
                if (selectedVoucher.type === 'percentage') {
                    discount = subtotalAmount * (selectedVoucher.discount_amount / 100);
                    if (selectedVoucher.max_discount && discount > selectedVoucher.max_discount) {
                        discount = selectedVoucher.max_discount;
                    }
                } else {
                    discount = selectedVoucher.discount_amount;
                }

                discount = Math.min(discount, subtotalAmount);
                summaryDiscount.textContent = '-' + formatCurrency(discount);
                summaryDiscountRow.style.display = 'flex';
                summaryTotal.textContent = formatCurrency(subtotalAmount + shippingAmount - discount);
            };

            const setOptions = (select, items, placeholder, valueKey = 'value', labelKey = 'label', selectedValue = '') => {
                select.innerHTML = '';
                const placeholderOption = document.createElement('option');
                placeholderOption.value = '';
                placeholderOption.textContent = placeholder;
                select.appendChild(placeholderOption);

                items.forEach(item => {
                    const option = document.createElement('option');
                    const value = item[valueKey] ?? item[labelKey] ?? item.code ?? '';
                    const label = item[labelKey] ?? item[valueKey] ?? item.code ?? '';

                    option.value = value;
                    option.textContent = label;
                    if (selectedValue && value === selectedValue) {
                        option.selected = true;
                    }
                    if (item.code != null) {
                        option.dataset.code = item.code;
                    }
                    if (item[labelKey] != null) {
                        option.dataset.label = item[labelKey];
                    }
                    select.appendChild(option);
                });
            };

            const resetDistricts = () => {
                setOptions(modalDistrict, [], 'Chọn quận/huyện');
                resetWards();
            };

            const resetWards = () => {
                setOptions(modalWard, [], 'Chọn phường/xã');
            };

            const loadWards = async (districtCode, selectedWard = '') => {
                resetWards();

                if (!districtCode) {
                    return;
                }

                try {
                    const response = await fetch(`${addressApiBase}?type=ward&code=${districtCode}`);
                    if (!response.ok) {
                        throw new Error('Không thể tải phường/xã');
                    }

                    const data = await response.json();
                    const wards = Array.isArray(data) ? data : data.wards || [];
                    const wardItems = wards.map(ward => ({
                        value: ward.name ?? ward.codename ?? '',
                        label: ward.name ?? ward.codename ?? '',
                    }));

                    setOptions(modalWard, wardItems, 'Chọn phường/xã', selectedWard);
                } catch (error) {
                    console.error(error);
                    resetWards();
                }
            };

            const loadDistricts = async (provinceCode, selectedDistrict = '', selectedWard = '') => {
                resetDistricts();

                if (!provinceCode) {
                    return;
                }

                try {
                    const response = await fetch(`${addressApiBase}?type=district&code=${provinceCode}`);
                    if (!response.ok) {
                        throw new Error('Không thể tải quận/huyện');
                    }

                    const data = await response.json();
                    const districts = Array.isArray(data) ? data : data.districts || [];
                    const districtItems = districts.map(district => ({
                        value: district.name ?? district.codename ?? '',
                        label: district.name ?? district.codename ?? '',
                        code: district.code,
                    }));

                    setOptions(modalDistrict, districtItems, 'Chọn quận/huyện', selectedDistrict);

                    if (selectedDistrict) {
                        const selectedOption = Array.from(modalDistrict.options).find(option => option.value === selectedDistrict);
                        const districtCodeForWard = selectedOption?.dataset.code;
                        if (districtCodeForWard) {
                            await loadWards(districtCodeForWard, selectedWard);
                        }
                    }
                } catch (error) {
                    console.error(error);
                    resetDistricts();
                }
            };

            const loadProvinces = async () => {
                console.log('Loading provinces...');
                setOptions(modalProvince, [], 'Đang tải tỉnh/thành phố...');
                resetDistricts();

                try {
                    const response = await fetch(`${addressApiBase}?type=province`);
                    console.log('Provinces response status:', response.status);
                    if (!response.ok) {
                        throw new Error('Không thể tải tỉnh/thành phố');
                    }

                    const provinces = await response.json();
                    console.log('Provinces data:', provinces);
                    const provinceItems = provinces.map(province => ({
                        value: province.name ?? province.codename ?? '',
                        label: province.name ?? province.codename ?? '',
                        code: province.code,
                    }));

                    setOptions(modalProvince, provinceItems, 'Chọn tỉnh/thành phố', oldProvince);

                    if (oldProvince) {
                        const selectedOption = Array.from(modalProvince.options).find(option => option.value === oldProvince);
                        const provinceCode = selectedOption?.dataset.code;
                        if (provinceCode) {
                            await loadDistricts(provinceCode, oldDistrict, oldWard);
                        }
                    }
                } catch (error) {
                    console.error('Error loading provinces:', error);
                    setOptions(modalProvince, [], 'Chọn tỉnh/thành phố');
                }
            };

            if (modalProvince && modalDistrict && modalWard) {
                modalProvince.addEventListener('change', async () => {
                    const selectedOption = modalProvince.options[modalProvince.selectedIndex];
                    const provinceCode = selectedOption?.dataset.code;
                    console.log('Province selected:', {
                        value: modalProvince.value,
                        text: selectedOption?.text,
                        code: provinceCode,
                        options: Array.from(modalProvince.options).map(option => ({ value: option.value, text: option.text, code: option.dataset.code })),
                    });
                    await loadDistricts(provinceCode);
                });

                modalDistrict.addEventListener('change', async () => {
                    const selectedOption = modalDistrict.options[modalDistrict.selectedIndex];
                    const districtCode = selectedOption?.dataset.code;
                    console.log('District selected:', {
                        value: modalDistrict.value,
                        text: selectedOption?.text,
                        code: districtCode,
                        options: Array.from(modalDistrict.options).map(option => ({ value: option.value, text: option.text, code: option.dataset.code })),
                    });
                    await loadWards(districtCode);
                });

                modalWard.addEventListener('change', () => {
                    const selectedOption = modalWard.options[modalWard.selectedIndex];
                    console.log('Ward selected:', {
                        value: modalWard.value,
                        text: selectedOption?.text,
                        code: selectedOption?.dataset.code,
                        options: Array.from(modalWard.options).map(option => ({ value: option.value, text: option.text, code: option.dataset.code })),
                    });
                });

                loadProvinces();
            }

            if (voucherSelect) {
                voucherSelect.addEventListener('change', updateSummaryForVoucher);
                updateSummaryForVoucher();
            }

            paymentRadios.forEach(radio => {
                radio.addEventListener('change', updateButtonText);
            });

            updateButtonText();

            // Handle add address form submission
            if (addAddressForm) {
                addAddressForm.addEventListener('submit', function(e) {
                    e.preventDefault();

                    const formData = new FormData(this);

                    console.log('Form data being sent:', Object.fromEntries(formData.entries()));
                    console.log('Modal selects current values:', {
                        province: modalProvince?.value,
                        district: modalDistrict?.value,
                        ward: modalWard?.value,
                    });

                    const csrfMeta = document.querySelector('meta[name="csrf-token"]');
                    const csrfToken = csrfMeta
                        ? csrfMeta.getAttribute('content')
                        : document.querySelector('input[name="_token"]')?.value;

                    console.log('CSRF Token:', csrfToken);

                    fetch(this.action, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': csrfToken,
                            'Accept': 'application/json'
                        }
                    })
                    .then(response => {
                        console.log('Response status:', response.status);
                        return response.json().catch(() => ({ error: 'Invalid JSON response' }));
                    })
                    .then(data => {
                        console.log('Response data:', data);
                        if (data.success) {
                            const modalElement = document.getElementById('addAddressModal');
                            const modalInstance = bootstrap.Modal.getInstance(modalElement) || new bootstrap.Modal(modalElement);
                            modalInstance.hide();

                            addAddressForm.reset();
                            location.reload();
                        } else {
                            alert('Có lỗi xảy ra khi thêm địa chỉ!');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Có lỗi xảy ra khi thêm địa chỉ!');
                    });
                });
            }
        });
    </script>
@endpush
