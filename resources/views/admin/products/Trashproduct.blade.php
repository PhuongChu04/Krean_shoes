@extends('admin.layouts.layout')

@section('content')

{{-- Flash messages --}}
@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="ri-checkbox-circle-line me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif
@if (session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="ri-error-warning-line me-2"></i>{{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="container-fluid">

    {{-- ===== HEADER ===== --}}
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h4 class="mb-1 fw-semibold">
                <i class="ri-delete-bin-2-line me-2 text-danger"></i>Thùng rác sản phẩm
            </h4>
            <p class="text-muted mb-0 fs-13">Các sản phẩm  đã xóa mềm. Có thể khôi phục hoặc xóa vĩnh viễn.</p>
        </div>
        <a href="{{ route('admin.listProduct') }}" class="btn btn-sm btn-outline-secondary">
            <i class="ri-arrow-left-line me-1"></i>Quay lại danh sách
        </a>
    </div>

    {{-- ===== TABS ===== --}}
    <ul class="nav nav-tabs mb-4" id="trashTabs">
        <li class="nav-item">
            <a class="nav-link {{ $tab === 'products' ? 'active' : '' }}"
               href="{{ route('admin.products.trash', ['tab' => 'products']) }}">
                <i class="ri-shopping-bag-line me-1"></i>
                Sản phẩm đã xóa
                <span class="badge bg-danger ms-1">{{ $trashedProducts->total() }}</span>
            </a>
        </li>
       
    </ul>

    {{-- ===================================================
         TAB 1: PRODUCTS ĐÃ XÓA
    ==================================================== --}}
    @if ($tab === 'products')
        <div class="card shadow-sm">
            <div class="card-header bg-white d-flex align-items-center justify-content-between py-3">
                <h6 class="mb-0 fw-semibold text-danger">
                    <i class="ri-shopping-bag-line me-1"></i>
                    Sản phẩm đã xóa mềm ({{ $trashedProducts->total() }})
                </h6>
                <small class="text-muted">Khôi phục sẽ phục hồi cả toàn bộ của sản phẩm.</small>
            </div>

            <div class="card-body p-0">
                @if ($trashedProducts->isEmpty())
                    <div class="text-center py-5">
                        <div class="mb-3" style="font-size: 3rem; opacity: .3;">🗑️</div>
                        <p class="text-muted">Không có sản phẩm nào trong thùng rác.</p>
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light-subtle">
                                <tr>
                                    <th style="width:60px">Ảnh</th>
                                    <th>Tên sản phẩm</th>
                                    <th>Danh mục</th>
                                    
                                    <th>Tồn kho</th>
                                    <th>Ngày xóa</th>
                                    <th style="width:180px">Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($trashedProducts as $product)
                                    <tr class="trash-row">
                                        <td>
                                            @if ($product->thumbnail)
                                                <img src="{{ asset('storage/' . $product->thumbnail) }}"
                                                     alt="{{ $product->name }}"
                                                     class="rounded border"
                                                     style="width:50px;height:50px;object-fit:cover;filter:grayscale(40%);">
                                            @else
                                                <div class="rounded border bg-light d-flex align-items-center justify-content-center"
                                                     style="width:50px;height:50px;color:#aaa;font-size:1.3rem;">
                                                    <i class="ri-image-line"></i>
                                                </div>
                                            @endif
                                        </td>

                                        <td>
                                            <span class="fw-medium text-danger-emphasis">{{ $product->name }}</span>
                                            <div class="text-muted fs-12">{{ $product->slug }}</div>
                                        </td>

                                        <td>
                                            <span class="badge bg-soft-secondary text-secondary">
                                                {{ $product->category?->name ?? '—' }}
                                            </span>
                                        </td>

                                        <td>
                                            @php
                                                $allVariants = $product->variants;
                                                $activeCount  = $allVariants->whereNull('deleted_at')->count();
                                                $deletedCount = $allVariants->whereNotNull('deleted_at')->count();
                                            @endphp
                                            <div class="fs-13">
                                                <span class="text-success">{{ $activeCount }} còn</span>
                                                @if ($deletedCount > 0)
                                                    · <span class="text-muted">{{ $deletedCount }} đã xóa</span>
                                                @endif
                                            </div>
                                            @php
                                                $sizes  = $allVariants->pluck('size.name')->filter()->unique()->implode(', ');
                                                $colors = $allVariants->pluck('color.name')->filter()->unique()->implode(', ');
                                            @endphp
                                            @if ($sizes)
                                                <small class="text-muted d-block">Size: {{ $sizes }}</small>
                                            @endif
                                            @if ($colors)
                                                <small class="text-muted d-block">Màu: {{ $colors }}</small>
                                            @endif
                                        </td>

                                        <td>
                                            @php $totalStock = $allVariants->sum('stock'); @endphp
                                            <span class="badge bg-soft-{{ $totalStock > 0 ? 'warning' : 'danger' }} text-{{ $totalStock > 0 ? 'warning' : 'danger' }}">
                                                {{ $totalStock }} sp
                                            </span>
                                        </td>

                                        <td>
                                            <span class="text-muted fs-12">
                                                <i class="ri-time-line me-1"></i>
                                                {{ $product->deleted_at?->format('d/m/Y H:i') }}
                                            </span>
                                            <div class="text-muted fs-11">
                                                {{ $product->deleted_at?->diffForHumans() }}
                                            </div>
                                        </td>

                                        <td>
                                            <div class="d-flex gap-2 flex-wrap">
                                                {{-- Khôi phục --}}
                                                <form action="{{ route('admin.products.restore', $product->id) }}"
                                                      method="POST" class="d-inline">
                                                    @csrf
                                                    <button type="submit"
                                                            class="btn btn-sm btn-soft-success"
                                                            title="Khôi phục sản phẩm và toàn bộ biến thể"
                                                            onclick="return confirm('Khôi phục sản phẩm này và toàn bộ biến thể của nó?')">
                                                        <i class="ri-refresh-line me-1"></i>Khôi phục
                                                    </button>
                                                </form>

                                                {{-- Xóa vĩnh viễn --}}
                                                <form action="{{ route('admin.products.force-delete', $product->id) }}"
                                                      method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                            class="btn btn-sm btn-soft-danger"
                                                            title="Xóa vĩnh viễn, không thể hoàn tác"
                                                            onclick="return confirm('⚠️ Xóa VĨNH VIỄN sản phẩm này?\nHành động này KHÔNG THỂ hoàn tác!\nTất cả ảnh và biến thể sẽ bị xóa hoàn toàn.')">
                                                        <i class="ri-delete-bin-line me-1"></i>Xóa vĩnh viễn
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>

                                    {{-- Chi tiết variant (collapsible) --}}
                                    @if ($allVariants->isNotEmpty())
                                        <tr class="bg-light-subtle">
                                            <td colspan="7" class="py-2 ps-4">
                                                <button class="btn btn-link btn-sm text-muted p-0 text-decoration-none"
                                                        type="button"
                                                        data-bs-toggle="collapse"
                                                        data-bs-target="#variants-{{ $product->id }}">
                                                    <i class="ri-arrow-down-s-line"></i>
                                                    Xem {{ $allVariants->count() }} biến thể
                                                </button>
                                                <div class="collapse mt-2" id="variants-{{ $product->id }}">
                                                    <div class="row g-2">
                                                        @foreach ($allVariants as $v)
                                                            <div class="col-md-4">
                                                                <div class="border rounded p-2 fs-12 d-flex align-items-center gap-2
                                                                    {{ $v->deleted_at ? 'bg-danger bg-opacity-10 border-danger border-opacity-25' : 'bg-white' }}">
                                                                    @if ($v->images->isNotEmpty())
                                                                        <img src="{{ asset('storage/' . $v->images->first()->image) }}"
                                                                             class="rounded" style="width:36px;height:36px;object-fit:cover;
                                                                                {{ $v->deleted_at ? 'filter:grayscale(60%)' : '' }}">
                                                                    @else
                                                                        <div class="rounded bg-light d-flex align-items-center justify-content-center"
                                                                             style="width:36px;height:36px;color:#bbb">
                                                                            <i class="ri-image-line"></i>
                                                                        </div>
                                                                    @endif
                                                                    <div>
                                                                        <div class="fw-medium">
                                                                            {{ $v->size?->name ?? '?' }} / {{ $v->color?->name ?? '?' }}
                                                                        </div>
                                                                        <div class="text-muted">
                                                                            {{ number_format($v->price, 0, ',', '.') }}đ
                                                                            · Kho: {{ $v->stock }}
                                                                        </div>
                                                                        @if ($v->deleted_at)
                                                                            <span class="badge bg-danger" style="font-size:10px">Đã xóa</span>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{-- Phân trang --}}
                    <div class="p-3">
                        {{ $trashedProducts->appends(['tab' => 'products'])->links('pagination::bootstrap-5') }}
                    </div>
                @endif
            </div>
        </div>
    @endif



</div>

@push('styles')
<style>
    .trash-row:hover {
        background-color: #fff8f8;
    }
    .fs-11 { font-size: 11px; }
    .fs-12 { font-size: 12px; }
    .fs-13 { font-size: 13px; }
    .hover-underline:hover { text-decoration: underline !important; }

    /* Soft badges dùng trong layout admin */
    .bg-soft-secondary { background-color: rgba(108,117,125,.12); }
    .bg-soft-success   { background-color: rgba(25,135,84,.12); }
    .bg-soft-warning   { background-color: rgba(255,193,7,.15); }
    .bg-soft-danger    { background-color: rgba(220,53,69,.12); }
    .bg-soft-primary   { background-color: rgba(13,110,253,.1); }
    .bg-soft-info      { background-color: rgba(13,202,240,.12); }
</style>
@endpush

@endsection