@extends('admin.layouts.layout')
@section('content')
    <!-- Start Container Fluid -->
    <div class="container-xxl">

        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center gap-1">
                        <h4 class="card-title flex-grow-1">Thùng Rác Size</h4>

                        <a href="{{ route('admin.sizes.index') }}" class="btn btn-sm btn-secondary">
                            <i class="bi bi-arrow-left"></i> Quay Lại
                        </a>
                    </div>
                    <div>
                        @if($message = session('success'))
                            <div class="alert alert-success alert-dismissible fade show m-3" role="alert">
                                {{ $message }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        @if($message = session('error'))
                            <div class="alert alert-danger alert-dismissible fade show m-3" role="alert">
                                {{ $message }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        <div class="table-responsive">
                            @if($sizes->count() > 0)
                                <table class="table align-middle mb-0 table-hover table-centered">
                                    <thead class="bg-light-subtle">
                                        <tr>
                                            <th style="width: 20px;">
                                                <div class="form-check">
                                                    <input type="checkbox" class="form-check-input" id="selectAll">
                                                    <label class="form-check-label" for="selectAll"></label>
                                                </div>
                                            </th>
                                            <th>ID</th>
                                            <th>Tên Size</th>
                                            <th>Xóa lúc</th>
                                            <th>Ngày tạo</th>
                                            <th>Hành động</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($sizes as $size)
                                            <tr>
                                                <td>
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input selectItem">
                                                        <label class="form-check-label"></label>
                                                    </div>
                                                </td>
                                                <td>{{ $size->id }}</td>
                                                <td>
                                                    <span class="badge bg-danger">{{ $size->name }}</span>
                                                </td>
                                                <td>{{ $size->deleted_at->format('d/m/Y H:i') }}</td>
                                                <td>{{ $size->created_at->format('d/m/Y H:i') }}</td>
                                                <td>
                                                    <div class="d-flex gap-2">
                                                        <form action="{{ route('admin.sizes.restore', $size->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Khôi phục size này?');">
                                                            @csrf
                                                            <button type="submit" class="btn btn-soft-success btn-sm">
                                                                <i class="bi bi-arrow-counterclockwise"></i> Khôi phục
                                                            </button>
                                                        </form>
                                                        <form action="{{ route('admin.sizes.force-delete', $size->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Xóa vĩnh viễn? Hành động này không thể hoàn tác!');">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-soft-danger btn-sm">
                                                                <i class="bi bi-trash"></i> Xóa Vĩnh Viễn
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @else
                                <div class="alert alert-info m-3" role="alert">
                                    <i class="bi bi-info-circle"></i> Thùng rác rỗng
                                </div>
                            @endif
                        </div>
                        <!-- end table-responsive -->
                    </div>
                </div>
            </div>
        </div>

    </div>
    <!-- End Container Fluid -->
@endsection
