@extends('admin.layouts.layout')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>Thêm Sản Phẩm Mới</h4>
                </div>

                <div class="card-body">
                    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" novalidate id="product-form">
                        @csrf

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

                        <!-- Thông tin sản phẩm chính -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Tên sản phẩm <span class="text-danger">*</span></label>
                                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Danh mục <span class="text-danger">*</span></label>
                                    <select name="category_id" class="form-select @error('category_id') is-invalid @enderror" required>
                                        <option value="">-- Chọn danh mục --</option>
                                        @foreach($categories as $cat)
                                            <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('category_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Thương hiệu <span class="text-danger">*</span></label>
                                    <select name="brand_id" class="form-select @error('brand_id') is-invalid @enderror" required>
                                        <option value="">-- Chọn thương hiệu --</option>
                                        @foreach($brands as $brand)
                                            <option value="{{ $brand->id }}" {{ old('brand_id') == $brand->id ? 'selected' : '' }}>{{ $brand->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('brand_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Mô tả</label>
                                    <textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="3">{{ old('description') }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold">Ảnh đại diện (thumbnail)</label>
                            <input type="file" name="thumbnail" class="form-control @error('thumbnail') is-invalid @enderror" accept="image/*">
                            @error('thumbnail')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <hr class="my-4">

                        <!-- Phần biến thể -->
                        <h5 class="mb-3 fw-bold">Biến thể sản phẩm <span class="text-danger">*</span> (ít nhất 1 biến thể)</h5>

                        <div id="variants-container"></div>

                        <button type="button" id="add-variant" class="btn btn-success mb-4">
                            + Thêm biến thể mới
                        </button>

                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary px-5 py-2">
                                Lưu sản phẩm
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    let variantIndex = 0;

    function addVariantRow(preFill = {}) {
        const container = document.getElementById('variants-container');

        const row = document.createElement('div');
        row.className = 'variant-row card mb-4 p-3 bg-light border-primary';
        row.dataset.index = variantIndex;

        row.innerHTML = `
            <div class="row g-3 align-items-end">
                <div class="col-md-3">
                    <label class="form-label fw-bold">Size <span class="text-danger">*</span></label>
                    <select name="variants[${variantIndex}][size_id]" class="form-select" required>
                        <option value="">-- Chọn size --</option>
                        @foreach($sizes as $size)
                            <option value="{{ $size->id }}">{{ $size->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3">
                    <label class="form-label fw-bold">Màu <span class="text-danger">*</span></label>
                    <select name="variants[${variantIndex}][color_id]" class="form-select" required>
                        <option value="">-- Chọn màu --</option>
                        @foreach($colors as $color)
                            <option value="{{ $color->id }}">{{ $color->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-2">
                    <label class="form-label fw-bold">Giá bán (đ) <span class="text-danger">*</span></label>
                    <input type="number" name="variants[${variantIndex}][price]" class="form-control" min="0" step="1000" placeholder="Ví dụ: 850000" required>
                </div>

                <div class="col-md-2">
                    <label class="form-label fw-bold">Tồn kho <span class="text-danger">*</span></label>
                    <input type="number" name="variants[${variantIndex}][stock]" class="form-control" min="0" placeholder="Ví dụ: 50" required>
                </div>

                <div class="col-md-2 d-flex align-items-end">
                    <button type="button" class="btn btn-danger btn-sm remove-variant w-100">Xóa biến thể</button>
                </div>
            </div>

            <div class="mt-3">
                <label class="form-label fw-bold">Ảnh riêng cho biến thể này (có thể chọn nhiều)</label>
                <input type="file" name="variants[${variantIndex}][images][]" class="form-control" multiple accept="image/*">
            </div>
        `;

        // Điền giá trị cũ nếu validation fail
        if (Object.keys(preFill).length > 0) {
            row.querySelector(`[name="variants[${variantIndex}][size_id]"]`).value  = preFill.size_id || '';
            row.querySelector(`[name="variants[${variantIndex}][color_id]"]`).value = preFill.color_id || '';
            row.querySelector(`[name="variants[${variantIndex}][price]"]`).value    = preFill.price || '';
            row.querySelector(`[name="variants[${variantIndex}][stock]"]`).value    = preFill.stock || '';
        }

        // Sự kiện xóa
        row.querySelector('.remove-variant').addEventListener('click', () => {
            row.remove();
        });

        container.appendChild(row);
        variantIndex++;
    }

    document.addEventListener('DOMContentLoaded', function () {
        // Nút thêm biến thể
        document.getElementById('add-variant').addEventListener('click', () => {
            addVariantRow();
        });

        // Tự động thêm ít nhất 1 biến thể khi load trang lần đầu
        if (document.querySelectorAll('.variant-row').length === 0) {
            addVariantRow();
        }

        // Repopulate từ old input nếu validation fail
        const oldVariants = @json(old('variants', []));
        if (oldVariants && oldVariants.length > 0) {
            oldVariants.forEach(variant => {
                addVariantRow({
                    size_id: variant.size_id || '',
                    color_id: variant.color_id || '',
                    price: variant.price || '',
                    stock: variant.stock || ''
                });
            });
        }

        // Kiểm tra client-side trước khi submit
        const form = document.getElementById('product-form');
        form.addEventListener('submit', function (e) {
            const rows = document.querySelectorAll('.variant-row');

            if (rows.length === 0) {
                alert('Bạn cần thêm ít nhất 1 biến thể sản phẩm!');
                e.preventDefault();
                return;
            }

            let hasError = false;
            rows.forEach(row => {
                const size  = row.querySelector('select[name*="size_id"]').value.trim();
                const color = row.querySelector('select[name*="color_id"]').value.trim();
                const price = row.querySelector('input[name*="price"]').value.trim();
                const stock = row.querySelector('input[name*="stock"]').value.trim();

                if (!size || !color || !price || !stock) {
                    hasError = true;
                    row.scrollIntoView({ behavior: 'smooth' });
                    row.style.border = '2px solid red';
                    setTimeout(() => row.style.border = '', 3000);
                }
            });

            if (hasError) {
                alert('Vui lòng điền đầy đủ thông tin cho tất cả biến thể!');
                e.preventDefault();
            }
        });
    });
</script>
@endsection