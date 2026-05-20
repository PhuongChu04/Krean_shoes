@extends('client.layout.layout')

@section('content')
<div class="flat-spacing-13">
    <div class="container-7">
        <div class="btn-sidebar-mb d-lg-none">
            <button data-bs-toggle="offcanvas" data-bs-target="#mbAccount">
                <i class="icon icon-sidebar"></i>
            </button>
        </div>

        <div class="main-content-account">
            @include('client.layout.sidebar')

            <div class="my-acount-content account-dashboard">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h6 class="display-xs title-form">Địa chỉ của tôi</h6>
                        <p class="text-sm text-muted">Quản lý địa chỉ giao hàng và thêm địa chỉ mới.</p>
                    </div>
                    <button id="open-add-address-modal" type="button" class="tf-btn btn-dark2" data-bs-toggle="modal" data-bs-target="#addAddressModal">
                        Thêm địa chỉ mới
                    </button>
                </div>

                @if(session('success'))
                    <div class="alert alert-success mb-4">{{ session('success') }}</div>
                @endif

                @if($addresses->isEmpty())
                    <div class="alert alert-info">Bạn chưa có địa chỉ nào. Vui lòng thêm địa chỉ mới.</div>
                @else
                    <div class="list-addresses">
                        @foreach($addresses as $address)
                            <div class="address-card mb-3 p-4 border rounded">
                                <div class="d-flex justify-content-between align-items-start mb-3">
                                    <div>
                                        <div class="text-lg fw-semibold">{{ $address->name }}</div>
                                        <div class="text-sm text-muted">{{ $address->phone }}</div>
                                    </div>
                                    <div class="d-flex gap-2 align-items-center">
                                        @if($address->is_default)
                                            <span class="badge bg-dark text-white">Mặc định</span>
                                        @endif
                                        @php
                                            $addrData = array_merge(
                                                $address->only([
                                                    'id','name','phone','province','district','ward','address','type','is_default'
                                                ]),
                                                ['update_url' => route('client.addresses.update', $address)]
                                            );
                                        @endphp
                                        <button type="button" class="tf-btn btn-link text-primary edit-address-btn"
                                            data-address='@json($addrData)'
                                            data-bs-toggle="modal" data-bs-target="#addAddressModal">
                                            Sửa
                                        </button>
                                        <form action="{{ route('client.addresses.destroy', $address) }}" method="POST" class="d-inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="tf-btn btn-link text-danger"
                                                onclick="return confirm('Bạn có chắc muốn xóa địa chỉ này không?')">
                                                Xóa
                                            </button>
                                        </form>
                                    </div>
                                </div>
                                <div class="text-sm">{{ $address->full_address }}</div>
                                <div class="mt-2 text-sm text-muted">Loại: {{ ucfirst($address->type) }}</div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

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
                <input type="hidden" name="_method" id="address-form-method" value="POST">
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
                        <select class="form-control" id="modal_type" name="type" required>
                            <option value="home">Nhà riêng</option>
                            <option value="work">Văn phòng</option>
                            <option value="other">Khác</option>
                        </select>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="modal_is_default" name="is_default" value="1">
                        <label class="form-check-label" for="modal_is_default">Đặt làm địa chỉ mặc định</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                    <button type="submit" class="btn btn-primary">Lưu địa chỉ</button>
                </div>
            </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    @include('client.partials.address-form-scripts')
@endpush
@endsection