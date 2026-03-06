@extends('admin.layouts.layout')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <h4>Chi Tiết Sản Phẩm: {{ $product->name }}</h4>
                    <a href="{{ route('admin.listProduct') }}" class="btn btn-secondary">Quay lại</a>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            @if($product->thumbnail)
                                <img src="{{ asset('storage/' . $product->thumbnail) }}" alt="{{ $product->name }}" class="img-fluid rounded">
                            @else
                                <div class="bg-light p-5 text-center">Chưa có ảnh đại diện</div>
                            @endif
                        </div>

                        <div class="col-md-8">
                            <h5>Thông tin cơ bản</h5>
                            <p><strong>Danh mục:</strong> {{ $product->category?->name ?? 'N/A' }}</p>
                            <p><strong>Thương hiệu:</strong> {{ $product->brand?->name ?? 'N/A' }}</p>
                            <p><strong>Mô tả:</strong> {{ $product->description ?? 'Không có mô tả' }}</p>
                            <p><strong>Slug:</strong> {{ $product->slug }}</p>
                        </div>
                    </div>

                    <hr>

                    <h5>Biến thể sản phẩm ({{ $product->variants->count() }})</h5>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Size</th>
                                    <th>Màu</th>
                                    <th>Giá</th>
                                    <th>Tồn kho</th>
                                    <th>Ảnh</th>
                                    <th>Hành Động</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($product->variants as $variant)
                                    <tr>
                                        <td>{{ $variant->size?->name ?? 'N/A' }}</td>
                                        <td>{{ $variant->color?->name ?? 'N/A' }}</td>
                                        <td>{{ number_format($variant->price, 0, ',', '.') }} đ</td>
                                        <td>{{ $variant->stock }}</td>
                                        <td>
                                            @if($variant->images->isNotEmpty())
                                                @foreach($variant->images as $img)
                                                    <img src="{{ asset('storage/' . $img->image) }}" alt="Variant image" width="80" class="me-1 rounded">
                                                @endforeach
                                            @else
                                                <span class="text-muted">Không có ảnh</span>
                                            @endif
                                        </td>
                                                                           <td>
                                          <div class="d-flex gap-2">
        <a href="{{ route('admin.products.variants.edit', $variant->id) }}"
           class="btn btn-sm btn-soft-primary">
            <iconify-icon icon="solar:pen-2-broken"></iconify-icon> Sửa
        </a>

        <form action="{{ route('admin.products.variants.destroy', $variant->id) }}" method="POST" class="d-inline"
              onsubmit="return confirm('Xóa biến thể này?')">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-sm btn-soft-danger">
                <iconify-icon icon="solar:trash-bin-minimalistic-2-broken"></iconify-icon> Xóa
            </button>
        </form>
    </div>
</td>
                                    </tr>
                                @empty
                                    <tr><td colspan="5" class="text-center">Chưa có biến thể</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection