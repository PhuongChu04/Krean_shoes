@extends('admin.layouts.layout')
@section('content')
    <!-- Start Container Fluid -->
    <div class="container-xxl">
        <div class="row">
            <div class="col-md-10 offset-md-1">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Thêm Voucher Mới</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.vouchers.store') }}" method="POST">
                            
                            @csrf

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Tên Voucher <span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                                            id="name" name="name" placeholder="Ví dụ: Giảm giá 10%"
                                            value="{{ old('name') }}" required>
                                        @error('name')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="code" class="form-label">Mã Code</label>
                                        <input type="text" class="form-control" id="code" name="code"
                                            placeholder="Mã code sẽ tự sinh" value="{{ old('code') }}" readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="description" class="form-label">Mô tả</label>
                                <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description"
                                    rows="3" placeholder="Mô tả chi tiết về voucher">{{ old('description') }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="type" class="form-label">Loại Voucher <span
                                                class="text-danger">*</span></label>
                                        <select class="form-select @error('type') is-invalid @enderror" id="type"
                                            name="type" required>
                                            <option value="">Chọn loại</option>
                                            <option value="percentage" {{ old('type') === 'percentage' ? 'selected' : '' }}>
                                                Phần trăm (%)</option>
                                            <option value="fixed" {{ old('type') === 'fixed' ? 'selected' : '' }}>Cố định
                                                (VNĐ)</option>
                                        </select>
                                        @error('type')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
    <div class="mb-3">
        <label for="quantity" class="form-label">Số lượng <span class="text-danger">*</span></label>
        <input type="number" class="form-control @error('quantity') is-invalid @enderror"
       id="quantity" name="quantity" placeholder="Ví dụ: 100"
       value="{{ old('quantity') }}" min="1" required>
        @error('quantity')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>
</div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="discount_amount" class="form-label">Số tiền giảm giá <span
                                                class="text-danger">*</span></label>
                                        <input type="number"
                                            class="form-control @error('discount_amount') is-invalid @enderror"
                                            id="discount_amount" name="discount_amount"
                                            placeholder="Ví dụ: 10 (cho %) hoặc 10000 (cho VNĐ)"
                                            value="{{ old('discount_amount') }}" min="0" step="0.01" required>
                                        @error('discount_amount')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="status" class="form-label">Trạng thái <span
                                                class="text-danger">*</span></label>
                                        <select class="form-select @error('status') is-invalid @enderror" id="status"
                                            name="status" required>
                                            <option value="active"
                                                {{ old('status', 'active') === 'active' ? 'selected' : '' }}>Hoạt động
                                            </option>
                                            <option value="inactive" {{ old('status') === 'inactive' ? 'selected' : '' }}>
                                                Không hoạt động</option>
                                        </select>
                                        @error('status')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="start_date" class="form-label">Ngày bắt đầu <span
                                                class="text-danger">*</span></label>
                                        <input type="datetime-local"
                                            class="form-control @error('start_date') is-invalid @enderror" id="start_date"
                                            name="start_date" value="{{ old('start_date') }}" required>
                                        @error('start_date')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="end_date" class="form-label">Ngày kết thúc <span
                                                class="text-danger">*</span></label>
                                        <input type="datetime-local"
                                            class="form-control @error('end_date') is-invalid @enderror" id="end_date"
                                            name="end_date" value="{{ old('end_date') }}" required>
                                        @error('end_date')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-plus"></i> Thêm Voucher
                                </button>
                                <a href="{{ route('admin.vouchers.index') }}" class="btn btn-secondary">
                                    <i class="bi bi-x"></i> Hủy
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Container Fluid -->

    <script>
        document.getElementById('name').addEventListener('input', function() {
            const name = this.value;
            const code = name.toUpperCase()
                .replace(/[^A-Z0-9\s]/g, '') // Loại bỏ ký tự đặc biệt
                .replace(/\s+/g, '-') // Thay khoảng trắng bằng dấu gạch ngang
                .replace(/-+/g, '-') // Loại bỏ dấu gạch ngang liên tiếp
                .replace(/^-|-$/g, ''); // Loại bỏ dấu gạch ngang ở đầu và cuối
            document.getElementById('code').value = code;
        });
    </script>
@endsection
