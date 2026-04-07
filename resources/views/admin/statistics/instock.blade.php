@extends('admin.layouts.layout')

@section('content')
    <div class="container-fluid">

        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="fw-bold">Sản phẩm còn hàng</h4>
                        <p class="text-muted">Có {{ $inStockProducts->total() ?? 0 }} sản phẩm đang có hàng</p>
                    </div>
                    <a href="{{ route('admin.listProduct') }}" class="btn btn-secondary">
                        <i class="bx bx-arrow-back"></i> Quay lại tất cả sản phẩm
                    </a>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Hình ảnh</th>
                                <th>Tên sản phẩm</th>
                                <th>Danh mục</th>
                                <th>Biến thể còn hàng</th>
                                <th>Giá thấp nhất</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($inStockProducts as $product)
                                <tr>
                                    <td>
                                        @if($product->thumbnail)
                                            <img src="{{ Storage::url($product->thumbnail) }}" 
                                                 alt="{{ $product->name }}" 
                                                 style="width: 50px; height: 50px; object-fit: cover; border-radius: 6px;">
                                        @else
                                            <img src="https://via.placeholder.com/50x50?text=No+Image" 
                                                 style="width: 50px; height: 50px; object-fit: cover; border-radius: 6px;">
                                        @endif
                                    </td>
                                    <td class="fw-medium">{{ $product->name }}</td>
                                    <td>{{ $product->category?->name ?? '—' }}</td>
                                    <td>
                                        <span class="badge bg-success">
                                            {{ $product->variants->count() }} biến thể
                                        </span>
                                    </td>
                                    <td class="fw-semibold">
                                        {{ number_format($product->variants->min('price') ?? 0) }} ₫
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.products.show', $product->id) }}" 
                                           class="btn btn-sm btn-primary">
                                            Xem chi tiết
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-5 text-muted">
                                        Hiện không có sản phẩm nào còn hàng.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Phân trang -->
            <div class="card-footer">
                <div class="d-flex justify-content-center">
                    {{ $inStockProducts->links() }}
                </div>
            </div>
        </div>

    </div>
@endsection