@extends('admin.layouts.layout')
@section('content')
    <!-- Start Container Fluid -->
   <div class="container-xxl">

        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Chỉnh sửa thương hiệu</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.brands.update', $brand->slug) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label for="name" class="form-label">Tên thương hiệu <span class="text-danger">*</span></label>
                                <input
                                    type="text"
                                    id="name"
                                    name="name"
                                    class="form-control @error('name') is-invalid @enderror"
                                    value="{{ old('name', $brand->name) }}"
                                    placeholder="Ví dụ: Nike, Adidas, ..."
                                    required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="description" class="form-label">Mô tả <span class="text-danger">*</span></label>
                                <textarea
                                    id="description"
                                    name="description"
                                    class="form-control @error('description') is-invalid @enderror"
                                    rows="3"
                                    placeholder="Mô tả ngắn gọn về thương hiệu" required>{{ old('description', $brand->description) }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                           <div class="d-flex justify-content-end gap-2">
    <button type="submit" class="btn btn-primary">
        <i class="bi bi-check"></i> Cập nhật
    </button>

    <a href="{{ route('admin.brands.index') }}" class="btn btn-secondary">
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
@endsection
