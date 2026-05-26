@extends('admin.layouts.layout')

@section('content')
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-12">
                {{-- ===== THANH TÌM KIẾM & BỘ LỌC ===== --}}
                    <form method="GET" action="{{ route('admin.listProduct') }}" id="filterForm">
                        <div class="row g-2 mb-3 align-items-end">

                            {{-- Tìm theo tên --}}
                            <div class="col-12 col-md-4">

                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0">
                                        <iconify-icon icon="solar:magnifer-broken"></iconify-icon>
                                    </span>
                                    <input type="text" name="search" class="form-control border-start-0"
                                        placeholder="Tìm kiếm sản phẩm..." value="{{ request('search') }}"
                                        autocomplete="off">
                                </div>
                            </div>

                            {{-- Lọc theo danh mục --}}
                            <div class="col-6 col-md-2">
                                <select name="category_id" class="form-select">
                                    <option value="">Tất cả danh mục</option>
                                    @foreach ($categories as $cat)
                                        <option value="{{ $cat->id }}"
                                            {{ request('category_id') == $cat->id ? 'selected' : '' }}>
                                            {{ $cat->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Lọc theo trạng thái --}}
                            <div class="col-6 col-md-2">
                                <select name="status" class="form-select">
                                    <option value="all" {{ request('status', 'all') === 'all' ? 'selected' : '' }}>
                                        Tất cả
                                    </option>
                                    <option value="1" {{ request('status') === '1' ? 'selected' : '' }}>
                                        Đang bán
                                    </option>
                                    <option value="0" {{ request('status') === '0' ? 'selected' : '' }}>
                                        Đang ẩn
                                    </option>
                                </select>
                            </div>

                            {{-- Lọc theo tồn kho --}}
                            <div class="col-6 col-md-2">
                                <select name="stock" class="form-select">
                                    <option value="all" {{ request('stock', 'all') === 'all' ? 'selected' : '' }}>
                                        Tất cả
                                    </option>
                                    <option value="in_stock" {{ request('stock') === 'in_stock' ? 'selected' : '' }}>
                                        Còn hàng
                                    </option>
                                    <option value="out_stock" {{ request('stock') === 'out_stock' ? 'selected' : '' }}>
                                        Hết hàng
                                    </option>
                                </select>
                            </div>

                            {{-- Nút tìm & reset --}}
                            <div class="col-6 col-md-2 d-flex gap-2">
                                <button type="submit" class="btn btn-primary flex-grow-1">
                                    <iconify-icon icon="solar:magnifer-broken" class="me-1"></iconify-icon>
                                    Lọc
                                </button>
                                @if (request()->hasAny(['search', 'category_id', 'status', 'stock']))
                                    <a href="{{ route('admin.listProduct') }}" class="btn btn-outline-secondary"
                                        title="Xóa bộ lọc">
                                        <iconify-icon icon="solar:restart-broken"></iconify-icon>
                                    </a>
                                @endif
                            </div>

                        </div>

                        {{-- Hiển thị bộ lọc đang áp dụng --}}
                        @if (request()->hasAny(['search', 'category_id', 'status', 'stock']))
                            <div class="d-flex align-items-center gap-2 mb-3 flex-wrap">
                                <small class="text-muted">Đang lọc:</small>
                                @if (request('search'))
                                    <span class="badge bg-soft-primary text-primary">
                                        Tên: "{{ request('search') }}"
                                    </span>
                                @endif
                                @if (request('category_id'))
                                    <span class="badge bg-soft-info text-info">
                                        Danh mục: {{ $categories->firstWhere('id', request('category_id'))?->name }}
                                    </span>
                                @endif
                                @if (request('status') !== null && request('status') !== 'all' && request('status') !== '')
                                    <span class="badge bg-soft-warning text-warning">
                                        {{ request('status') === '1' ? 'Đang bán' : 'Đang ẩn' }}
                                    </span>
                                @endif
                                @if (request('stock') && request('stock') !== 'all')
                                    <span class="badge bg-soft-success text-success">
                                        {{ request('stock') === 'in_stock' ? 'Còn hàng' : 'Hết hàng' }}
                                    </span>
                                @endif
                                <small class="text-muted">— {{ $products->total() }} kết quả</small>
                            </div>
                        @endif
                    </form>
                    {{-- ===== END TÌM KIẾM ===== --}}
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center gap-1">
                        <h4 class="card-title flex-grow-1">Danh Sách Sản Phẩm</h4>

                        <a href="{{ route('admin.products.create') }}" class="btn btn-sm btn-primary">
                            Thêm Sản Phẩm
                        </a>

                        
                        <div class="dropdown">
                            <a href="{{ route('admin.products.trash') }}" class="btn btn-sm btn-danger"
                                aria-expanded="false">
                                Sản Phẩm đã xóa
                            </a>

                        </div>
                    </div>
                    
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table align-middle mb-0 table-hover table-centered">
                                <thead class="bg-light-subtle">
                                    <tr>

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
                                            {{-- <td>
                                                <div class="form-check ms-1">
                                                    <input type="checkbox" class="form-check-input check-item">
                                                </div>
                                            </td> --}}

                                            <!-- Cột Sản Phẩm (ảnh + tên) -->
                                            <td>
                                                <div class="d-flex align-items-center gap-3">
                                                    <div class="flex-shrink-0">
                                                        <div
                                                            class="avatar-md bg-light rounded d-flex align-items-center justify-content-center">
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


                                                </div>
                                            </td>
                                            <td>
                                                <div class="flex-grow-1 overflow-hidden">
                                                    <a href="#"
                                                        class="text-dark fw-medium fs-15 text-truncate d-block"
                                                        style="max-width: 220px;">
                                                        {{ $product->name }}
                                                    </a>
                                                    <p class="text-muted mb-0 fs-13">
                                                        {{ $product->variants->count() }} Sản Phẩm
                                                    </p>
                                                </div>
                                            </td>

                                            <!-- Cột Biến Thể (gộp size & color) -->
                                            <td class="fs-13">
                                                @php
                                                    $sizes = $product->variants
                                                        ->pluck('size.name')
                                                        ->filter()
                                                        ->unique()
                                                        ->implode(', ');
                                                    $colors = $product->variants
                                                        ->pluck('color.name')
                                                        ->filter()
                                                        ->unique()
                                                        ->implode(', ');
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
                                                        {{ number_format($product->variants->min('price') ?: 0, 0, ',', '.') }}
                                                        đ
                                                        {{-- min('price') . ' - ' . max('price') --}}
                                                    </span>
                                                @else
                                                    <span class="text-muted">—</span>
                                                @endif
                                            </td>

                                            <!-- Tồn kho tổng -->
                                            <td>
                                                @if ($product->variants->isNotEmpty())
                                                    <span
                                                        class="badge bg-soft-{{ $product->variants->sum('stock') > 10 ? 'success' : 'warning' }} text-{{ $product->variants->sum('stock') > 10 ? 'success' : 'warning' }} fs-12">
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
                                            <!-- Hành động -->
                                            <td>
                                                <div class="d-flex gap-1 flex-wrap">
                                                    <a href="{{ route('admin.products.show', $product->id) }}"
                                                        class="btn btn-sm btn-soft-info">
                                                        <iconify-icon icon="solar:eye-broken"></iconify-icon>
                                                    </a>

                                                    <a href="{{ route('admin.products.edit', $product->id) }}"
                                                        class="btn btn-sm btn-soft-primary">
                                                        <iconify-icon icon="solar:pen-2-broken"></iconify-icon>
                                                    </a>

                                                    <form action="{{ route('admin.products.destroy', $product->id) }}"
                                                        method="POST" class="d-inline"
                                                        onsubmit="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này và tất cả biến thể?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-soft-danger">
                                                            <iconify-icon
                                                                icon="solar:trash-bin-minimalistic-2-broken"></iconify-icon>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>

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
