@extends('admin.layouts.layout')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center gap-1">
                        <h4 class="card-title flex-grow-1">Danh Sách Sản Phẩm</h4>

                        <a href="{{ route('admin.products.create') }}" class="btn btn-sm btn-primary">
                            Thêm Sản Phẩm
                        </a>

                        <div class="dropdown">
                            <a href="#" class="dropdown-toggle btn btn-sm btn-outline-light" data-bs-toggle="dropdown"
                               aria-expanded="false">
                                This Month
                            </a>
                            <div class="dropdown-menu dropdown-menu-end">
                                <a href="#!" class="dropdown-item">Download</a>
                                <a href="#!" class="dropdown-item">Export</a>
                                <a href="#!" class="dropdown-item">Import</a>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table align-middle mb-0 table-hover table-centered">
                                <thead class="bg-light-subtle">
                                    <tr>
                                        <th style="width: 20px;">
                                            <div class="form-check ms-1">
                                                <input type="checkbox" class="form-check-input" id="checkAll">
                                                <label class="form-check-label" for="checkAll"></label>
                                            </div>
                                        </th>
                                        <th>Image</th>
                                        <th>Tên Sản Phẩm</th>
                                        <th>Biến Thể</th>
                                        <th>Giá Thấp Nhất</th>
                                        <th>Tồn Kho Tổng</th>
                                        <th>Danh Mục</th>
                                        <th>Hành Động</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($products as $product)
                                        <tr>
                                            <td>
                                                <div class="form-check ms-1">
                                                    <input type="checkbox" class="form-check-input check-item">
                                                </div>
                                            </td>

                                            <!-- Cột Sản Phẩm (ảnh + tên) -->
                                           <td>
    <div class="d-flex align-items-center gap-3">
        <div class="flex-shrink-0">
            <div class="avatar-md bg-light rounded d-flex align-items-center justify-content-center">
                @if ($product->thumbnail)
                    <img src="{{ asset('storage/' . $product->thumbnail) }}"
                         alt="{{ $product->name }}"
                         class="avatar-img img-fluid rounded">
                @elseif ($product->variants->isNotEmpty() && $product->variants->first()->images->isNotEmpty())
                    <img src="{{ asset('storage/' . $product->variants->first()->images->first()->image) }}"
                         alt="{{ $product->name }}"
                         class="avatar-img img-fluid rounded">
                @else
                    <span class="text-muted">No Image</span>
                @endif
            </div>
        </div>

        <div class="flex-grow-1 overflow-hidden">
            <a href="#" class="text-dark fw-medium fs-15 text-truncate d-block"
               style="max-width: 220px;">
                {{ $product->name }}
            </a>
            <p class="text-muted mb-0 fs-13">
                {{ $product->variants->count() }} Biến thể
            </p>
        </div>
    </div>
</td>
                                            <td><div class="flex-grow-1 overflow-hidden">
                                                        <a href="#" class="text-dark fw-medium fs-15 text-truncate d-block"
                                                           style="max-width: 220px;">
                                                            {{ $product->name }}
                                                        </a>
                                                        <p class="text-muted mb-0 fs-13">
                                                            {{ $product->variants->count() }} Sản Phẩm
                                                        </p>
                                                    </div></td>

                                            <!-- Cột Biến Thể (gộp size & color) -->
                                            <td class="fs-13">
                                                @php
                                                    $sizes = $product->variants->pluck('size.name')->filter()->unique()->implode(', ');
                                                    $colors = $product->variants->pluck('color.name')->filter()->unique()->implode(', ');
                                                @endphp

                                                @if ($sizes)
                                                    <div><strong>Size:</strong> {{ $sizes }}</div>
                                                @endif
                                                @if ($colors)
                                                    <div><strong>Màu:</strong> {{ $colors }}</div>
                                                @endif
                                                @if (!$sizes && !$colors)
                                                    <span class="text-muted">Không có biến thể</span>
                                                @endif
                                            </td>

                                            <!-- Giá thấp nhất -->
                                            <td>
                                                @if ($product->variants->isNotEmpty())
                                                    <span class="fw-medium">
                                                        {{ number_format($product->variants->min('price') ?: 0, 0, ',', '.') }} đ
                                                        {{-- min('price') . ' - ' . max('price') --}}
                                                    </span>
                                                @else
                                                    <span class="text-muted">—</span>
                                                @endif
                                            </td>

                                            <!-- Tồn kho tổng -->
                                            <td>
                                                @if ($product->variants->isNotEmpty())
                                                    <span class="badge bg-soft-{{ $product->variants->sum('stock') > 10 ? 'success' : 'warning' }} text-{{ $product->variants->sum('stock') > 10 ? 'success' : 'warning' }} fs-12">
                                                        {{ $product->variants->sum('stock') }} Item
                                                    </span>
                                                @else
                                                    <span class="badge bg-soft-danger text-danger fs-12">Hết hàng</span>
                                                @endif
                                            </td>

                                            <!-- Danh mục -->
                                            <td>
                                                {{ $product->category?->name ?? 'N/A' }}
                                            </td>

                                            <!-- Hành động (ở mức product) -->
                                            <td>
                                                <div class="d-flex gap-2 flex-wrap">
                                                    <a href="{{ route('admin.products.show', $product->id) }}"
                                                       class="btn btn-sm btn-soft-info">
                                                        <iconify-icon icon="solar:eye-broken" class="me-1"></iconify-icon>
                                                        Xem
                                                    </a>

                                                    <a href="{{ route('admin.products.edit', $product->id) }}"
                                                       class="btn btn-sm btn-soft-primary">
                                                        <iconify-icon icon="solar:pen-2-broken" class="me-1"></iconify-icon>
                                                        Sửa
                                                    </a>

                                                    <form action="{{ route('admin.products.destroy', $product->id) }}"
                                                          method="POST"
                                                          class="d-inline"
                                                          onsubmit="return confirm('Xóa sản phẩm này sẽ xóa hết biến thể. Bạn có chắc chắn?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-soft-danger">
                                                            <iconify-icon icon="solar:trash-bin-minimalistic-2-broken" class="me-1"></iconify-icon>
                                                            Xóa
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                            <td>
  
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center py-5 text-muted">
                                                Chưa có sản phẩm nào.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <!-- Phân trang -->
                        <div class="mt-4">
                            {{ $products->links('pagination::bootstrap-5') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection