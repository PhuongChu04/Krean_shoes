@extends('admin.layouts.layout')

@section('content')
@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif
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
                                @if ($product->thumbnail)
                                    <img src="{{ asset('storage/' . $product->thumbnail) }}" alt="{{ $product->name }}"
                                        class="img-fluid rounded">
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
                                                @if ($variant->images->isNotEmpty())
                                                    @foreach ($variant->images as $img)
                                                        <img src="{{ asset('storage/' . $img->image) }}"
                                                            alt="Variant image" width="80" class="me-1 rounded">
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

                                                    <form
                                                        action="{{ route('admin.products.variants.destroy', $variant->id) }}"
                                                        method="POST" class="d-inline"
                                                        onsubmit="return confirm('Xóa biến thể này?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-soft-danger">
                                                            <iconify-icon
                                                                icon="solar:trash-bin-minimalistic-2-broken"></iconify-icon>
                                                            Xóa
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center">Chưa có biến thể</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <!-- ... phần bảng biến thể hiện tại giữ nguyên ... -->

<hr class="my-4">

{{-- ===== BIẾN THỂ ĐÃ XÓA MỀM ===== --}}
@if (isset($trashedVariants) && $trashedVariants->isNotEmpty())
<div class="card border-danger border-opacity-50 mt-4">
    <div class="card-header bg-danger bg-opacity-10 d-flex align-items-center justify-content-between py-2">
        <h6 class="mb-0 text-danger fw-semibold">
            <iconify-icon icon="solar:trash-bin-2-broken" class="me-1"></iconify-icon>
            Biến thể đã xóa mềm
            <span class="badge bg-danger ms-1">{{ $trashedVariants->count() }}</span>
        </h6>
        <small class="text-muted">Có thể khôi phục hoặc xóa vĩnh viễn từng biến thể</small>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-bordered mb-0 align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Ảnh</th>
                        <th>Size</th>
                        <th>Màu</th>
                        <th>Giá</th>
                        <th>Tồn kho</th>
                        <th>Ngày xóa</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($trashedVariants as $variant)
                        <tr style="background: rgba(220,53,69,0.04);">
                            <td>
                                @if ($variant->images->isNotEmpty())
                                    <img src="{{ asset('storage/' . $variant->images->first()->image) }}"
                                         alt="" width="56" height="56"
                                         class="rounded border"
                                         style="object-fit:cover; filter:grayscale(50%) opacity(.75);">
                                @else
                                    <div class="rounded border bg-light d-flex align-items-center justify-content-center text-muted"
                                         style="width:56px;height:56px;font-size:1.2rem;">
                                        <iconify-icon icon="solar:image-broken"></iconify-icon>
                                    </div>
                                @endif
                            </td>
                            <td class="text-muted fst-italic">{{ $variant->size?->name ?? 'N/A' }}</td>
                            <td>
                                <span class="d-inline-flex align-items-center gap-2 text-muted fst-italic">
                                    @if ($variant->color?->code)
                                        <span style="display:inline-block;width:14px;height:14px;border-radius:50%;
                                                     background:{{ $variant->color->code }};
                                                     border:1px solid rgba(0,0,0,.15);
                                                     filter:grayscale(40%);"></span>
                                    @endif
                                    {{ $variant->color?->name ?? 'N/A' }}
                                </span>
                            </td>
                            <td class="text-muted fst-italic">{{ number_format($variant->price, 0, ',', '.') }} đ</td>
                            <td>
                                <span class="badge bg-secondary bg-opacity-50">{{ $variant->stock }} sp</span>
                            </td>
                            <td>
                                <small class="text-muted">
                                    {{ $variant->deleted_at->format('d/m/Y H:i') }}<br>
                                    <span class="text-danger-emphasis">{{ $variant->deleted_at->diffForHumans() }}</span>
                                </small>
                            </td>
                            <td>
                                <div class="d-flex gap-2">
                                    {{-- Khôi phục --}}
                                    <form action="{{ route('admin.products.variants.restore', $variant->id) }}"
                                          method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit"
                                                class="btn btn-sm btn-soft-success"
                                                onclick="return confirm('Khôi phục biến thể {{ $variant->size?->name }} / {{ $variant->color?->name }}?')"
                                                title="Khôi phục biến thể này">
                                            <iconify-icon icon="solar:refresh-broken"></iconify-icon> Khôi phục
                                        </button>
                                    </form>

                                    {{-- Xóa vĩnh viễn --}}
                                    <form action="{{ route('admin.products.variants.force-delete', $variant->id) }}"
                                          method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="btn btn-sm btn-soft-danger"
                                                onclick="return confirm('⚠️ Xóa VĨNH VIỄN biến thể {{ $variant->size?->name }} / {{ $variant->color?->name }}?\nHành động này KHÔNG THỂ hoàn tác!')"
                                                title="Xóa vĩnh viễn, không thể phục hồi">
                                            <iconify-icon icon="solar:trash-bin-minimalistic-2-broken"></iconify-icon> Xóa vĩnh viễn
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endif

<!-- Phần THÊM BIẾN THỂ MỚI -->
<!-- Phần THÊM BIẾN THỂ MỚI (đặt ngay dưới bảng variants hiện tại) -->
<div class="card mt-4">
    <div class="card-header">
        <h5 class="mb-0">Thêm biến thể mới cho sản phẩm này</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.products.variants.store', $product->id) }}" method="POST" enctype="multipart/form-data">
            @csrf

            @if ($errors->any())
                <div class="alert alert-danger mb-4">
                    <strong>Có lỗi xảy ra:</strong>
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="variant-row card mb-4 p-3 bg-light border-primary">  <!-- dùng class giống template dynamic -->

                <div class="row g-3 align-items-end">
                    <div class="col-md-3">
                        <label class="form-label fw-bold">Size <span class="text-danger">*</span></label>
                        <select name="size_id" class="form-select @error('size_id') is-invalid @enderror" required>
                            <option value="">-- Chọn size --</option>
                            @foreach($sizes as $size)
                                <option value="{{ $size->id }}" {{ old('size_id') == $size->id ? 'selected' : '' }}>
                                    {{ $size->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('size_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-3">
                        <label class="form-label fw-bold">Màu <span class="text-danger">*</span></label>
                        <select name="color_id" class="form-select @error('color_id') is-invalid @enderror" required>
                            <option value="">-- Chọn màu --</option>
                            @foreach($colors as $color)
                                <option value="{{ $color->id }}" {{ old('color_id') == $color->id ? 'selected' : '' }}>
                                    {{ $color->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('color_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-2">
                        <label class="form-label fw-bold">Giá bán (đ) <span class="text-danger">*</span></label>
                        <input type="number" name="price" class="form-control @error('price') is-invalid @enderror" 
                               min="0"  placeholder="Ví dụ: 850000" 
                               value="{{ old('price') }}" required>
                        @error('price')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-2">
                        <label class="form-label fw-bold">Tồn kho <span class="text-danger">*</span></label>
                        <input type="number" name="stock" class="form-control @error('stock') is-invalid @enderror" 
                               min="0" placeholder="Ví dụ: 50" 
                               value="{{ old('stock') }}" required>
                        @error('stock')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Không cần nút Xóa vì đây là form thêm mới đơn lẻ -->
                </div>

                <div class="mt-3">
                    <label class="form-label fw-bold">Ảnh riêng cho biến thể này </label>
                    <input type="file" name="images[]" class="form-control" multiple accept="image/*">
                </div>
            </div>

            <div class="d-flex justify-content-end mt-3">
                <button type="submit" class="btn btn-success px-4">
                    Thêm biến thể mới
                </button>
            </div>
        </form>
    </div>
</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection