@extends('admin.layouts.layout')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4>Sửa Biến Thể: {{ $variant->product->name }}</h4>
                    <a href="{{ route('admin.products.show', $variant->product_id) }}" class="btn btn-secondary btn-sm">Quay lại chi tiết sản phẩm</a>
                </div>

                <div class="card-body">
                    <form action="{{ route('admin.products.variants.update', $variant->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Size</label>
                                    <select name="size_id" class="form-select @error('size_id') is-invalid @enderror" required>
                                        @foreach($sizes as $size)
                                            <option value="{{ $size->id }}" {{ old('size_id', $variant->size_id) == $size->id ? 'selected' : '' }}>
                                                {{ $size->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('size_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Màu sắc</label>
                                    <select name="color_id" class="form-select @error('color_id') is-invalid @enderror" required>
                                        @foreach($colors as $color)
                                            <option value="{{ $color->id }}" {{ old('color_id', $variant->color_id) == $color->id ? 'selected' : '' }}>
                                                {{ $color->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('color_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Giá bán (đ)</label>
                                    <input type="number" step="0.01" name="price" class="form-control @error('price') is-invalid @enderror"
                                           value="{{ old('price', $variant->price) }}" required>
                                    @error('price') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Tồn kho</label>
                                    <input type="number" name="stock" class="form-control @error('stock') is-invalid @enderror"
                                           value="{{ old('stock', $variant->stock) }}" required>
                                    @error('stock') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Ảnh hiện tại -->
                        <div class="mb-4">
                            <label class="form-label">Ảnh hiện tại của biến thể</label>
                            <div class="row g-2">
                                @forelse($variant->images as $image)
                                    <div class="col-3 position-relative">
                                        <img src="{{ asset('storage/' . $image->image) }}" alt="Variant image" class="img-thumbnail">
                                        <div class="form-check position-absolute top-0 end-0 m-1">
                                            <input type="checkbox" name="delete_images[]" value="{{ $image->id }}"
                                                   class="form-check-input bg-danger">
                                            <label class="form-check-label text-white bg-danger px-1 rounded small">Xóa</label>
                                        </div>
                                    </div>
                                @empty
                                    <p class="text-muted">Chưa có ảnh cho biến thể này</p>
                                @endforelse
                            </div>
                        </div>

                        <!-- Thêm ảnh mới -->
                        <div class="mb-3">
                            <label class="form-label">Thêm ảnh mới (có thể chọn nhiều)</label>
                            <input type="file" name="images[]" class="form-control" multiple accept="image/*">
                        </div>

                        <button type="submit" class="btn btn-primary">Cập nhật biến thể</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection