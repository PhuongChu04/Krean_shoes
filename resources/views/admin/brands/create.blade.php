@extends('admin.layouts.layout')
@section('content')
    <!-- Start Container Fluid -->
    <div class="container-xxl">
        <div class="row">
            <div class="col-md-10 offset-md-1">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Thêm Thương hiệu mới</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.brands.store') }}" method="POST">
                            @csrf

                            <div id="brandRows">
                                <div class="brand-row row g-3 align-items-end mb-3" data-index="0">
                                    <div class="col-md-5">
                                        <label class="form-label">Tên thương hiệu <span class="text-danger">*</span></label>
                                        <input type="text"
                                               name="brands[0][name]"
                                               class="form-control @error('brands.0.name') is-invalid @enderror"
                                               value="{{ old('brands.0.name') }}"
                                               placeholder="Ví dụ: Nike, Adidas, ..."
                                               required>
                                        @error('brands.0.name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-5">
                                        <label class="form-label">Mô tả <span class="text-danger">*</span></label>
                                        <textarea name="brands[0][description]"
                                                  class="form-control @error('brands.0.description') is-invalid @enderror"
                                                  rows="1"
                                                  placeholder="Mô tả ngắn gọn về thương hiệu" required>{{ old('brands.0.description') }}</textarea>
                                        @error('brands.0.description')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-2">
                                        <button type="button" class="btn btn-danger btn-sm w-100 remove-brand-row" style="display: none;">
                                            <i class="bi bi-trash"></i> Xóa
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <button type="button" id="addBrandRow" class="btn btn-secondary btn-sm">
                                    <i class="bi bi-plus"></i> Thêm dòng
                                </button>
                            </div>

                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-plus"></i> Lưu thương hiệu
                                </button>
                                <a href="{{ route('admin.brands.index') }}" class="btn btn-secondary">
                                    <i class="bi bi-x"></i> Hủy
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Container Fluid -->
@endsection

@section('scripts')
<script>
    (function () {
        const brandRows = document.getElementById('brandRows');
        const addBrandRowBtn = document.getElementById('addBrandRow');

        function updateRowIndices() {
            const rows = brandRows.querySelectorAll('.brand-row');
            rows.forEach((row, index) => {
                row.dataset.index = index;
                row.querySelectorAll('input, textarea').forEach((input) => {
                    const name = input.name.replace(/brands\[\d+\]/, `brands[${index}]`);
                    input.name = name;
                });
            });
        }

        function createNewRow() {
            const template = brandRows.querySelector('.brand-row');
            const clone = template.cloneNode(true);
            clone.dataset.index = brandRows.children.length;

            clone.querySelectorAll('input, textarea').forEach((input) => {
                input.value = '';
                input.classList.remove('is-invalid');
                const newName = input.name.replace(/brands\[\d+\]/, `brands[${brandRows.children.length}]`);
                input.name = newName;
            });

            const removeBtn = clone.querySelector('.remove-brand-row');
            removeBtn.style.display = 'block';
            removeBtn.addEventListener('click', () => {
                clone.remove();
                updateRowIndices();
            });

            brandRows.appendChild(clone);
        }

        addBrandRowBtn.addEventListener('click', createNewRow);

        // Enable remove button on cloned rows (existing row doesn't show delete)
        brandRows.querySelectorAll('.remove-brand-row').forEach((btn) => {
            btn.addEventListener('click', () => {
                btn.closest('.brand-row').remove();
                updateRowIndices();
            });
        });
    })();
</script>
@endsection
