@extends('admin.layouts.layout')
@section('content')
    <!-- Start Container Fluid -->
    <div class="container-xxl">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Chỉnh sửa Size</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.sizes.update', $size->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label for="name" class="form-label">Tên Size <span class="text-danger">*</span></label>
                                <input 
                                    type="text" 
                                    class="form-control @error('name') is-invalid @enderror" 
                                    id="name" 
                                    name="name" 
                                    placeholder="Ví dụ: S, M, L, XL, XXL, ..."
                                    value="{{ old('name', $size->name) }}"
                                    required>
                                @error('name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-check"></i> Cập nhật Size
                                </button>
                                <a href="{{ route('admin.sizes.index') }}" class="btn btn-secondary">
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
