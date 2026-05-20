<script>
    document.addEventListener('DOMContentLoaded', function() {
        const addAddressForm = document.getElementById('add-address-form');
        const openAddAddressButton = document.getElementById('open-add-address-modal');
        const addressFormMethod = document.getElementById('address-form-method');
        const modalTitle = document.getElementById('addAddressModalLabel');
        const modalElement = document.getElementById('addAddressModal');
        // scope selects inside modal to avoid duplicate ID issues on the page
        const modalProvince = modalElement ? modalElement.querySelector('#modal_province') : document.getElementById('modal_province');
        const modalDistrict = modalElement ? modalElement.querySelector('#modal_district') : document.getElementById('modal_district');
        const modalWard = modalElement ? modalElement.querySelector('#modal_ward') : document.getElementById('modal_ward');
        const addressApiBase = @json(route('client.addresses.locationData'));
        const addressStoreUrl = @json(route('client.addresses.store'));
        const oldProvince = @json(old('province'));
        const oldDistrict = @json(old('district'));
        const oldWard = @json(old('ward'));

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
                select.appendChild(option);
            });
            console.debug('[AddressForm] setOptions', select.id, 'items:', items.length, 'selectedValue:', selectedValue, 'optionsCount:', select.options.length);
            // show first few option values for debugging
            const sample = Array.from(select.options).slice(0,5).map(o => ({value: o.value, text: o.textContent, code: o.dataset.code}));
            console.debug('[AddressForm] options sample:', sample);
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
                console.debug('[AddressForm] loadWards ->', districtCode);
                const response = await fetch(`${addressApiBase}?type=ward&code=${districtCode}`);
                if (!response.ok) {
                    throw new Error('Không thể tải phường/xã');
                }

                const data = await response.json();
                console.debug('[AddressForm] wards response:', data);
                const wards = Array.isArray(data) ? data : data.wards || [];
                const wardItems = wards.map(ward => ({
                    value: ward.name ?? ward.codename ?? '',
                    label: ward.name ?? ward.codename ?? '',
                }));

                setOptions(modalWard, wardItems, 'Chọn phường/xã', 'value', 'label', selectedWard);
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
                console.debug('[AddressForm] loadDistricts ->', provinceCode);
                const response = await fetch(`${addressApiBase}?type=district&code=${provinceCode}`);
                if (!response.ok) {
                    throw new Error('Không thể tải quận/huyện');
                }

                const data = await response.json();
                console.debug('[AddressForm] districts response:', data);
                const districts = Array.isArray(data) ? data : data.districts || [];
                const districtItems = districts.map(district => ({
                    value: district.name ?? district.codename ?? '',
                    label: district.name ?? district.codename ?? '',
                    code: district.code,
                }));

                setOptions(modalDistrict, districtItems, 'Chọn quận/huyện', 'value', 'label', selectedDistrict);

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
            setOptions(modalProvince, [], 'Đang tải tỉnh/thành phố...');
            resetDistricts();

            try {
                const response = await fetch(`${addressApiBase}?type=province`);
                if (!response.ok) {
                    throw new Error('Không thể tải tỉnh/thành phố');
                }

                const provinces = await response.json();
                const provinceItems = provinces.map(province => ({
                    value: province.name ?? province.codename ?? '',
                    label: province.name ?? province.codename ?? '',
                    code: province.code,
                }));

                setOptions(modalProvince, provinceItems, 'Chọn tỉnh/thành phố', 'value', 'label', oldProvince);

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

        const resetAddressForm = () => {
            if (!addAddressForm) {
                return;
            }

            addAddressForm.action = addressStoreUrl;
            addressFormMethod.value = 'POST';
            modalTitle.textContent = 'Thêm địa chỉ mới';
            addAddressForm.reset();
            setOptions(modalProvince, [], 'Chọn tỉnh/thành phố');
            resetDistricts();
            modalProvince.focus();
            loadProvinces();
        };

        const fillAddressForm = async (addressData) => {
            if (!addAddressForm) {
                return;
            }

            addAddressForm.action = addressData.update_url;
            addressFormMethod.value = 'PUT';
            modalTitle.textContent = 'Sửa địa chỉ';

            document.getElementById('modal_name').value = addressData.name;
            document.getElementById('modal_phone').value = addressData.phone;
            document.getElementById('modal_address').value = addressData.address;
            document.getElementById('modal_type').value = addressData.type;
            document.getElementById('modal_is_default').checked = !!addressData.is_default;

            await loadProvinces();
            modalProvince.value = addressData.province;
            const provinceOption = Array.from(modalProvince.options).find(option => option.value === addressData.province);
            const provinceCode = provinceOption?.dataset.code;
            console.debug('[AddressForm] fillAddressForm province:', addressData.province, 'code:', provinceCode, 'selected district:', addressData.district);

            if (provinceCode) {
                await loadDistricts(provinceCode, addressData.district, addressData.ward);
            }
        };

        if (openAddAddressButton) {
            openAddAddressButton.addEventListener('click', resetAddressForm);
        }

        document.querySelectorAll('.edit-address-btn').forEach(button => {
            button.addEventListener('click', async () => {
                const addressData = JSON.parse(button.getAttribute('data-address'));
                await fillAddressForm(addressData);
            });
        });

        if (modalProvince && modalDistrict && modalWard) {
            modalProvince.addEventListener('change', async () => {
                const selectedOption = modalProvince.options[modalProvince.selectedIndex];
                const provinceCode = selectedOption?.dataset.code;
                await loadDistricts(provinceCode);
            });

            modalDistrict.addEventListener('change', async () => {
                const selectedOption = modalDistrict.options[modalDistrict.selectedIndex];
                const districtCode = selectedOption?.dataset.code;
                await loadWards(districtCode);
            });

            modalWard.addEventListener('change', () => {
                // no-op, kept for consistency if future logic is needed
            });

            loadProvinces();
        }

        if (addAddressForm) {
            addAddressForm.addEventListener('submit', function(e) {
                e.preventDefault();

                const formData = new FormData(this);
                const csrfMeta = document.querySelector('meta[name="csrf-token"]');
                const csrfToken = csrfMeta ? csrfMeta.getAttribute('content') : document.querySelector('input[name="_token"]')?.value;

                fetch(this.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json().catch(() => ({ error: 'Invalid JSON response' })))
                .then(data => {
                    if (data.success) {
                        const modalElement = document.getElementById('addAddressModal');
                        const modalInstance = bootstrap.Modal.getInstance(modalElement) || new bootstrap.Modal(modalElement);
                        modalInstance.hide();
                        addAddressForm.reset();
                        location.reload();
                    } else {
                        alert(data.message || 'Có lỗi xảy ra khi thêm địa chỉ!');
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
