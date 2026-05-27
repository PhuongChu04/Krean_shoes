@extends('admin.layouts.layout')
@section('content')
    <!-- Start Container Fluid -->
    <div class="container-xxl">

        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center gap-1">
                        <h4 class="card-title flex-grow-1">Danh sách Size</h4>

                        <a href="{{ route('admin.sizes.create') }}" class="btn btn-sm btn-primary">
                            <i class="bi bi-plus"></i> Thêm Size Mới
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
                                          
                                            <th>ID</th>
                                            <th>Tên Size</th>
                                            <th>Ngày tạo</th>
                                            <th>Ngày cập nhật</th>
                                            <th>Hành động</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($sizes as $index => $size)
                                            <tr>
                                               
                                                <td>{{ $index + 1 }}</td>
                                                <td>
                                                    <span class="badge bg-primary">{{ $size->name }}</span>
                                                </td>
                                                <td>{{ $size->created_at?->format('d/m/Y H:i') ?? '—' }}</td>
                                                <td>{{ $size->updated_at?->format('d/m/Y H:i') ?? '—' }}</td>
                                                <td>
                                                    <div class="d-flex gap-2">
                                                        <a href="{{ route('admin.sizes.edit', $size->id) }}" class="btn btn-soft-primary btn-sm">
                                                            <i class="bi bi-pencil"></i> Sửa
                                                        </a>
                                                        
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @else
                                <div class="alert alert-info m-3" role="alert">
                                    <i class="bi bi-info-circle"></i> Không có size nào. <a href="{{ route('admin.sizes.create') }}">Tạo size mới</a>
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
