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

                        <!-- Các trường tương tự create, nhưng điền old() hoặc $product->... -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label>Tên sản phẩm</label>
                                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $product->name) }}">
                                    @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label>Danh mục</label>
                                    <select name="category_id" class="form-select">
                                        @foreach($categories as $cat)
                                            <option value="{{ $cat->id }}" {{ old('category_id', $product->category_id) == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Tương tự cho brand_id, description, thumbnail... -->

                        <div class="mb-3">
                            <label>Ảnh đại diện hiện tại</label><br>
                            @if($product->thumbnail)
                                <img src="{{ asset('storage/' . $product->thumbnail) }}" alt="Thumbnail" width="150">
                            @else
                                <span>Chưa có ảnh</span>
                            @endif
                        </div>

                        <div class="mb-3">
                            <label>Thay ảnh đại diện mới (nếu muốn)</label>
                            <input type="file" name="thumbnail" class="form-control" accept="image/*">
                        </div>

                        <!-- Phần biến thể: hiện tại chỉ hiển thị thông tin, chưa cho sửa chi tiết variant (có thể mở rộng sau) -->
                        <h5>Biến thể hiện tại ({{ $product->variants->count() }})</h5>
                        <ul>
                            @foreach($product->variants as $v)
                                <li>
                                    Size: {{ $v->size?->name ?? 'N/A' }} | 
                                    Màu: {{ $v->color?->name ?? 'N/A' }} | 
                                    Giá: {{ number_format($v->price, 0, ',', '.') }} đ | 
                                    Tồn: {{ $v->stock }}
                                </li>
                            @endforeach
                        </ul>

                        <button type="submit" class="btn btn-primary">Cập nhật</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection