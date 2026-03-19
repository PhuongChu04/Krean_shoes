@extends('admin.layouts.layout')
@php use Illuminate\Support\Str; @endphp
@section('content')
    <!-- Start Container Fluid -->
    <div class="container-xxl">
        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center gap-1">
                        <div>
                            <h4 class="card-title">Thương hiệu: {{ $brand->name }}</h4>
                            <p class="mb-0 text-muted">{{ $brand->description }}</p>
                        </div>
                        <div class="d-flex gap-2">
                            <a href="{{ route('admin.brands.index') }}" class="btn btn-sm btn-secondary">
                                <i class="bi bi-arrow-left"></i> Danh sách
                            </a>
                            <a href="{{ route('admin.brands.edit', $brand->slug) }}" class="btn btn-sm btn-primary">
                                <i class="bi bi-pencil"></i> Chỉnh sửa
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.brands.show', $brand->slug) }}" method="GET" class="row g-3 mb-4">
                            <div class="col-md-3">
                                <input type="text" name="keyword" value="{{ request('keyword') }}" class="form-control" placeholder="Tìm theo tên sản phẩm...">
                            </div>
                            <div class="col-md-2">
                                <select name="category_id" class="form-select">
                                    <option value="">Tất cả danh mục</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <select name="status" class="form-select">
                                    <option value="">Tất cả trạng thái</option>
                                    <option value="1" {{ request('status') === '1' ? 'selected' : '' }}>Hoạt động</option>
                                    <option value="0" {{ request('status') === '0' ? 'selected' : '' }}>Ngừng bán</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <input type="number" name="min_quantity" value="{{ request('min_quantity') }}" class="form-control" placeholder="Tồn tối thiểu">
                            </div>
                            <div class="col-md-3">
                                <button type="submit" class="btn btn-primary w-100">
                                    <i class="bi bi-funnel"></i> Lọc
                                </button>
                            </div>
                        </form>

                        <div class="table-responsive">
                            @if($products->count() > 0)
                                <table class="table table-hover align-middle">
                                    <thead class="bg-light-subtle">
                                        <tr>
                                            <th>#</th>
                                            <th>Tên sản phẩm</th>
                                            <th>Danh mục</th>
                                            <th>Giá</th>
                                            <th>Tồn kho</th>
                                            <th>Trạng thái</th>
                                            <th>Hành động</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($products as $index => $product)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $product->name }}</td>
                                                <td>{{ $product->category?->name ?? '—' }}</td>
                                                <td>{{ number_format($product->price, 0, ',', '.') }} đ</td>
                                                <td>{{ $product->quantity }}</td>
                                                <td>
                                                    @if($product->status)
                                                        <span class="badge bg-success">Hoạt động</span>
                                                    @else
                                                        <span class="badge bg-secondary">Ngừng bán</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <a href="{{ route('admin.products.show', $product->id) }}" class="btn btn-soft-primary btn-sm">
                                                        <i class="bi bi-eye"></i> Xem
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                                <div class="mt-3">
                                    {{ $products->links() }}
                                </div>
                            @else
                                <div class="alert alert-info" role="alert">
                                    <i class="bi bi-info-circle"></i> Không có sản phẩm nào thuộc thương hiệu này.
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Container Fluid -->
@endsection
