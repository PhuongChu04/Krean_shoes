@extends('admin.layouts.layout')



@section('content')
    <style>
        .custom-pills .nav-link {
            font-weight: 600;
            color: #1e2022;
        }

        .custom-pills .nav-link.active {
            font-weight: 700;
        }
    </style>

    <div class="container-xxl">

        <div class="row">
            <div class="col-xl-12">
                <div class="card">

                    <!-- Tabs trạng thái -->


                    <div>
                        <div class="card-body">
                            <div>
                                <ul class="nav nav-pills mb-3 custom-pills">
                                    <li class="nav-item">
                                        <a class="nav-link {{ request('status') == null ? 'active' : '' }}"
                                            href="{{ route('admin.blog_categories.index') }}">
                                            Tất cả ({{ $all->count() ?? 0 }})
                                        </a>
                                    </li>

                                    <li class="nav-item">
                                        <a class="nav-link {{ request('status') == 'active' ? 'active' : '' }}"
                                            href="{{ route('admin.blog_categories.index', ['status' => 'active']) }}">
                                            Đang hoạt động ({{ $active->count() ?? 0 }})
                                        </a>
                                    </li>

                                    <li class="nav-item">
                                        <a class="nav-link {{ request('status') == 'deleted' ? 'active' : '' }}"
                                            href="{{ route('admin.blog_categories.trash', ['status' => 'deleted']) }}">
                                            Đã xóa ({{ $Trashed->count() ?? 0 }})
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <div class="d-md-flex align-items-center">

                                <div class="py-1 d-flex align-items-center flex-sm-row flex-column mb-3">
                                    <div class="flex-grow-1 d-flex align-items-center gap-2">
                                        <i class="mdi mdi-post-outline fs-2 text-primary"></i>
                                        <h4 class="fs-20 fw-bold m-0">Danh mục bài viết</h4>
                                    </div>
                                </div>
                                <div class="ms-auto mt-3 mt-md-0">
                                    <a href="{{ route('admin.blog_categories.create') }}" class="btn btn-primary">
                                        <i class="fa-solid fa-plus me-1"></i> Thêm danh mục
                                    </a>
                                    <a class="btn btn-outline-secondary dropdown-toggle ms-2" type="button"
                                        id="filterDropdown" data-bs-toggle="dropdown" aria-expanded="false"
                                        data-bs-auto-close="outside">
                                        <i class="fas fa-filter me-1"></i> Bộ lọc
                                    </a>
                                    <div class="dropdown-menu p-4" style="min-width: max;" aria-labelledby="filterDropdown">
                                        <form method="GET" action="{{ route('admin.blog_categories.index') }}"
                                            class="row g-7">
                                            <div class="col-md-6">
                                                <label for="search" class="form-label">Tên danh mục / Slug</label>
                                                <input type="text" name="search" id="search" class="form-control"
                                                    value="{{ request('search') }}">
                                            </div>
                                            <div class="col-md-6">
                                                <label for="status" class="form-label">Trạng thái</label>
                                                <select name="status" id="status" class="form-select">
                                                    <option value="">-- Tất cả --</option>
                                                    <option value="active"
                                                        {{ request('status') == 'active' ? 'selected' : '' }}>Đang
                                                        hoạt động</option>
                                                    <option value="deleted"
                                                        {{ request('status') == 'deleted' ? 'selected' : '' }}>Đã
                                                        xóa</option>
                                                </select>
                                            </div>
                                            <div class="col-md-12">
                                                <label class="form-label">Ngày tạo</label>
                                                <div class="input-group">
                                                    <span class="input-group-text">Từ</span>
                                                    <input type="date" name="min_date" class="form-control"
                                                        value="{{ request('min_date') }}">
                                                    <span class="input-group-text">đến</span>
                                                    <input type="date" name="max_date" class="form-control"
                                                        value="{{ request('max_date') }}">
                                                </div>
                                            </div>
                                            <div class="col-md-12 d-flex justify-content-end gap-2">
                                                <button type="submit" class="btn btn-primary">
                                                    <i class="fas fa-search me-1"></i> Tìm kiếm
                                                </button>
                                                <a href="{{ route('admin.blog_categories.index') }}"
                                                    class="btn btn-warning">
                                                    <i class="fas fa-sync me-1"></i> Làm mới
                                                </a>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <div class="table-responsive mt-4">
                                <table class="table table-striped table-hover align-middle">
                                    <thead class="table-light">
                                        <tr>
                                            <th>ID</th>
                                            <th>Tên danh mục</th>
                                            <th>Slug</th>
                                            <th>Mô tả</th>
                                            <th>Trạng thái</th>
                                            <th>Ngày tạo</th>
                                            <th class="text-center">Hành động</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($categories as $category)
                                            <tr>
                                                <td>{{ $category->id }}</td>
                                                <td>{{ $category->name }}</td>
                                                <td>{{ $category->slug }}</td>
                                                <td>{!! $category->description !!}</td>
                                                <td>
                                                    <span
                                                        class="badge {{ $category->deleted_at ? 'bg-danger' : 'bg-success' }}">
                                                        {{ $category->deleted_at ? 'Đã xóa' : 'Đang hoạt động' }}
                                                    </span>
                                                </td>
                                                <td>{{ $category->created_at->format('d/m/Y') }}</td>
                                                <td class="text-center">
    <div class="d-flex align-items-center justify-content-center gap-1">

                                                        {{-- Xem chi tiết --}}
                                                        <a href="{{ route('admin.blog_categories.show', $category->slug) }}"
                                                            class="btn btn-sm btn-soft-info" title="Xem chi tiết">
                                                            <iconify-icon icon="solar:eye-broken"
                                                                width="18"></iconify-icon>
                                                        </a>

                                                        @if ($category->deleted_at)
                                                            {{-- Khôi phục --}}
                                                            <form
                                                                action="{{ route('admin.blog_categories.restore', $category->slug) }}"
                                                                method="POST"
                                                                onsubmit="return confirm('Khôi phục danh mục này?')"
                                                                class="d-inline">
                                                                @csrf
                                                                <button type="submit" class="btn btn-sm btn-soft-success"
                                                                    title="Khôi phục">
                                                                    <iconify-icon icon="solar:restart-broken"
                                                                        width="18"></iconify-icon>
                                                                </button>
                                                            </form>

                                                            {{-- Xóa vĩnh viễn --}}
                                                            <form
                                                                action="{{ route('admin.blog_categories.forceDelete', $category->slug) }}"
                                                                method="POST"
                                                                onsubmit="return confirm('Xóa vĩnh viễn danh mục này?')"
                                                                class="d-inline">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-sm btn-soft-danger"
                                                                    title="Xóa vĩnh viễn">
                                                                    <iconify-icon
                                                                        icon="solar:trash-bin-minimalistic-2-broken"
                                                                        width="18"></iconify-icon>
                                                                </button>
                                                            </form>
                                                        @else
                                                            {{-- Chỉnh sửa --}}
                                                            <a href="{{ route('admin.blog_categories.edit', $category->slug) }}"
                                                                class="btn btn-sm btn-soft-primary" title="Chỉnh sửa">
                                                                <iconify-icon icon="solar:pen-2-broken"
                                                                    width="18"></iconify-icon>
                                                            </a>

                                                            {{-- Xóa mềm --}}
                                                            <form
                                                                action="{{ route('admin.blog_categories.destroy', $category->slug) }}"
                                                                method="POST"
                                                                onsubmit="return confirm('Bạn có chắc chắn muốn xóa danh mục blog này?')"
                                                                class="d-inline">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-sm btn-soft-danger"
                                                                    title="Xóa danh mục">
                                                                    <iconify-icon
                                                                        icon="solar:trash-bin-minimalistic-2-broken"
                                                                        width="18"></iconify-icon>
                                                                </button>
                                                            </form>
                                                        @endif

                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="7" class="text-center">Không tìm thấy danh mục nào.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                            <!-- Phân trang -->
                            @if ($categories->lastPage() > 1)
                                <nav>
                                    <ul class="pagination justify-content-end mt-3 mb-0">
                                        <li class="page-item {{ $categories->onFirstPage() ? 'disabled' : '' }}">
                                            <a class="page-link" href="{{ $categories->previousPageUrl() }}">Trước</a>
                                        </li>
                                        @for ($i = 1; $i <= $categories->lastPage(); $i++)
                                            <li class="page-item {{ $i == $categories->currentPage() ? 'active' : '' }}">
                                                <a class="page-link"
                                                    href="{{ $categories->url($i) }}">{{ $i }}</a>
                                            </li>
                                        @endfor
                                        <li class="page-item {{ !$categories->hasMorePages() ? 'disabled' : '' }}">
                                            <a class="page-link" href="{{ $categories->nextPageUrl() }}">Sau</a>
                                        </li>
                                    </ul>
                                </nav>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
