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
                <form action="{{ route('client.account.update') }}" method="POST" class="form-edit-account">
                    @csrf
                    @method('PUT')  <!-- hoặc PATCH tùy route của bạn -->

                    <h6 class="display-xs title-form">Thông tin tài khoản</h6>

                    <div class="form-name">
                        <div class="tf-field style-2 style-3">
                            <input class="tf-field-input tf-input" id="name" placeholder=" " type="text"
                                name="name" value="{{ old('name', $user->name ?? '') }}" required>
                            <label class="tf-field-label" for="name">Họ và tên</label>
                            @error('name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="tf-field style-2 style-3">
                            <input class="tf-field-input tf-input" id="email" placeholder=" " type="email"
                                name="email" value="{{ old('email', $user->email ?? '') }}" required>
                            <label class="tf-field-label" for="email">Email</label>
                            @error('email')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-pass mt-4">
                        <div class="text-lg title-pass">Thay đổi mật khẩu (để trống nếu không đổi)</div>

                        <div class="tf-field style-2 style-3">
                            <input class="tf-field-input tf-input" id="current_password" placeholder=" " type="password"
                                name="current_password">
                            <label class="tf-field-label" for="current_password">Mật khẩu hiện tại</label>
                            @error('current_password')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="tf-field style-2 style-3">
                            <input class="tf-field-input tf-input" id="password" placeholder=" " type="password"
                                name="password">
                            <label class="tf-field-label" for="password">Mật khẩu mới</label>
                            @error('password')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="tf-field style-2 style-3">
                            <input class="tf-field-input tf-input" id="password_confirmation" placeholder=" "
                                type="password" name="password_confirmation">
                            <label class="tf-field-label" for="password_confirmation">Xác nhận mật khẩu mới</label>
                        </div>
                    </div>

                    <button type="submit" class="tf-btn animate-btn mt-4">Lưu thay đổi</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection