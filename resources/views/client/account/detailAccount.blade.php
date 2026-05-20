@extends('client.layout.layout')

@section('content')

<div class="flat-spacing-13">
    <div class="container-7">
        <!-- sidebar-account -->
        <div class="btn-sidebar-mb d-lg-none">
            <button data-bs-toggle="offcanvas" data-bs-target="#mbAccount">
                <i class="icon icon-sidebar"></i>
            </button>
        </div>

        <div class="main-content-account">
            @include('client.layout.sidebar')

            <div class="my-acount-content account-dashboard">
                <form action="{{ route('client.account.update') }}" method="POST" class="form-edit-account" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <!-- SECTION 1: THÔNG TIN TÀI KHOẢN -->
                    <div class="form-section mb-5">
                        <h6 class="display-xs title-form mb-4">Thông tin tài khoản</h6>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="tf-field style-2 style-3">
                                    <input class="tf-field-input tf-input" id="name" placeholder=" " type="text"
                                        name="name" value="{{ old('name', $user->name ?? '') }}" required>
                                    <label class="tf-field-label" for="name">Họ và tên <span class="text-danger">*</span></label>
                                    @error('name')
                                        <span class="text-danger small">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="tf-field style-2 style-3">
                                    <input class="tf-field-input tf-input" id="email" placeholder=" " type="email"
                                        name="email" value="{{ old('email', $user->email ?? '') }}" required>
                                    <label class="tf-field-label" for="email">Email <span class="text-danger">*</span></label>
                                    @error('email')
                                        <span class="text-danger small">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- DIVIDER -->
                    <hr class="my-4">

                    <!-- SECTION 2: THÔNG TIN CÁ NHÂN -->
                    <div class="form-section mb-5">
                        <h6 class="display-xs title-form mb-4">Thông tin cá nhân</h6>
                        
                        <!-- Avatar -->
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="tf-field style-2 style-3">
                                    <label class="tf-field-label d-block mb-2" for="user_image">Ảnh đại diện</label>
                                    @if($userProfile && $userProfile->user_image)
                                        <div class="mb-3">
                                            <img src="{{ asset('storage/' . $userProfile->user_image) }}" alt="Avatar" 
                                                style="max-width: 120px; max-height: 120px; border-radius: 8px; object-fit: cover;">
                                        </div>
                                    @else
                                        <div class="mb-3 p-3 bg-light rounded text-center" style="width: 120px; height: 120px; display: flex; align-items: center; justify-content: center;">
                                            <span class="text-muted">Chưa có ảnh</span>
                                        </div>
                                    @endif
                                    <input class="form-control" id="user_image" type="file"
                                        name="user_image" accept="image/*">
                                    <small class="form-text text-muted d-block mt-2">Hỗ trợ: JPEG, PNG, JPG, GIF (tối đa 2MB)</small>
                                    @error('user_image')
                                        <span class="text-danger small">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Personal Info Row 1 -->
                        <div class="row">
                            <div class="col-md-4">
                                <div class="tf-field style-2 style-3">
                                    <input class="tf-field-input tf-input" id="phone" placeholder=" " type="tel"
                                        name="phone" value="{{ old('phone', $userProfile->phone ?? '') }}">
                                    <label class="tf-field-label" for="phone">Số điện thoại</label>
                                    @error('phone')
                                        <span class="text-danger small">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="tf-field style-2 style-3">
                                    <input class="tf-field-input tf-input" id="birth_date" placeholder=" " type="date"
                                        name="birth_date" value="{{ old('birth_date', $userProfile->birth_date?->format('Y-m-d') ?? '') }}">
                                    <label class="tf-field-label" for="birth_date">Ngày sinh</label>
                                    @error('birth_date')
                                        <span class="text-danger small">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="tf-field style-2 style-3">
                                    <select class="tf-field-input tf-input" id="gender" name="gender">
                                        <option value="">Chọn giới tính</option>
                                        <option value="nam" {{ old('gender', $userProfile->gender ?? '') === 'nam' ? 'selected' : '' }}>Nam</option>
                                        <option value="nu" {{ old('gender', $userProfile->gender ?? '') === 'nu' ? 'selected' : '' }}>Nữ</option>
                                        <option value="khac" {{ old('gender', $userProfile->gender ?? '') === 'khac' ? 'selected' : '' }}>Khác</option>
                                    </select>
                                    <label class="tf-field-label" for="gender">Giới tính</label>
                                    @error('gender')
                                        <span class="text-danger small">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Address -->
                        <div class="row mt-4">
                            <div class="col-12">
                                <div class="tf-field style-2 style-3">
                                    <textarea class="tf-field-input tf-input" id="address" placeholder=" "
                                        name="address" rows="3">{{ old('address', $userProfile->address ?? '') }}</textarea>
                                    <label class="tf-field-label" for="address">Địa chỉ</label>
                                    @error('address')
                                        <span class="text-danger small">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- DIVIDER -->
                    <hr class="my-4">

                    <!-- SECTION 3: ĐỔI MẬT KHẨU -->
                    <div class="form-section mb-5">
                        <h6 class="display-xs title-form mb-4">Thay đổi mật khẩu</h6>
                        <p class="text-muted mb-4">Để trống nếu không muốn thay đổi mật khẩu</p>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="tf-field style-2 style-3">
                                    <input class="tf-field-input tf-input" id="current_password" placeholder=" " type="password"
                                        name="current_password">
                                    <label class="tf-field-label" for="current_password">Mật khẩu hiện tại</label>
                                    @error('current_password')
                                        <span class="text-danger small">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-md-6">
                                <div class="tf-field style-2 style-3">
                                    <input class="tf-field-input tf-input" id="password" placeholder=" " type="password"
                                        name="password">
                                    <label class="tf-field-label" for="password">Mật khẩu mới</label>
                                    @error('password')
                                        <span class="text-danger small">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="tf-field style-2 style-3">
                                    <input class="tf-field-input tf-input" id="password_confirmation" placeholder=" "
                                        type="password" name="password_confirmation">
                                    <label class="tf-field-label" for="password_confirmation">Xác nhận mật khẩu mới</label>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mt-3">
                            <small class="text-muted d-block">Mật khẩu phải có ít nhất 8 ký tự, chứa chữ hoa, chữ thường và số</small>
                        </div>
                    </div>

                    <!-- BUTTON SUBMIT -->
                    <div class="form-section">
                        <button type="submit" class="tf-btn animate-btn">Lưu thay đổi</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection