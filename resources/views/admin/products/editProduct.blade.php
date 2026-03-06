@extends('admin.layouts.layout')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <h4>Sửa Sản Phẩm: {{ $product->name }}</h4>
                    <a href="{{ route('admin.listProduct') }}" class="btn btn-secondary">Quay lại</a>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Hiển thị lỗi validation -->
                        @if ($errors->any())
                            <div class="alert alert-danger mb-4">
                                <strong>Có lỗi xảy ra, vui lòng kiểm tra lại:</strong>
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Tên sản phẩm <span class="text-danger">*</span></label>
                                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" 
                                           value="{{ old('name', $product->name) }}" required>
                                    @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Slug</label>
                                    <input type="text" name="slug" class="form-control @error('slug') is-invalid @enderror" 
                                           value="{{ old('slug', $product->slug) }}">
                                    @error('slug') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Danh mục <span class="text-danger">*</span></label>
                                    <select name="category_id" class="form-select @error('category_id') is-invalid @enderror" required>
                                        @foreach($categories as $cat)
                                            <option value="{{ $cat->id }}" {{ old('category_id', $product->category_id) == $cat->id ? 'selected' : '' }}>
                                                {{ $cat->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('category_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Thương hiệu <span class="text-danger">*</span></label>
                                    <select name="brand_id" class="form-select @error('brand_id') is-invalid @enderror" required>
                                        @foreach($brands as $brand)
                                            <option value="{{ $brand->id }}" {{ old('brand_id', $product->brand_id) == $brand->id ? 'selected' : '' }}>
                                                {{ $brand->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('brand_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Mô tả</label>
                            <textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="4">
                                {{ old('description', $product->description) }}
                            </textarea>
                            @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Ảnh đại diện hiện tại</label><br>
                            @if($product->thumbnail)
                                <img src="{{ asset('storage/' . $product->thumbnail) }}" alt="Thumbnail" class="img-thumbnail" width="200">
                            @else
                                <span class="text-muted">Chưa có ảnh đại diện</span>
                            @endif
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold">Thay ảnh đại diện mới (nếu muốn)</label>
                            <input type="file" name="thumbnail" class="form-control @error('thumbnail') is-invalid @enderror" accept="image/*">
                            @error('thumbnail') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <!-- Phần biến thể (chỉ hiển thị, không sửa ở đây) -->
                        <h5 class="mt-4">Biến thể hiện tại ({{ $product->variants->count() }})</h5>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Size</th>
                                        <th>Màu</th>
                                        <th>Giá</th>
                                        <th>Tồn kho</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($product->variants as $v)
                                        <tr>
                                            <td>{{ $v->size?->name ?? 'N/A' }}</td>
                                            <td>{{ $v->color?->name ?? 'N/A' }}</td>
                                            <td>{{ number_format($v->price, 0, ',', '.') }} đ</td>
                                            <td>{{ $v->stock }}</td>
                                        </tr>
                                    @empty
                                        <tr><td colspan="4" class="text-center">Chưa có biến thể</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <div class="d-flex justify-content-end mt-4">
                            <button type="submit" class="btn btn-primary px-5">Cập nhật sản phẩm</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection