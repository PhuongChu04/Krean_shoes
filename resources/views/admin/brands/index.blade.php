@extends('admin.layouts.layout')
@php use Illuminate\Support\Str; @endphp
@section('content')
    <!-- Start Container Fluid -->
    <div class="container-xxl">

        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center gap-1">
                        <h4 class="card-title flex-grow-1">Danh sách Thương hiệu</h4>

                        <a href="{{ route('admin.brands.create') }}" class="btn btn-sm btn-primary">
                            <i class="bi bi-plus"></i> Thêm thương hiệu
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
                            @if($brands->count() > 0)
                                <table class="table align-middle mb-0 table-hover table-centered">
                                    <thead class="bg-light-subtle">
                                        <tr>
                                            <th style="width: 20px;">
                                                <div class="form-check">
                                                    <input type="checkbox" class="form-check-input" id="selectAll">
                                                    <label class="form-check-label" for="selectAll"></label>
                                                </div>
                                            </th>
                                            <th>Id</th>
                                            <th>Tên</th>
                                            <th>Slug</th>
                                            <th>Mô tả</th>
                                            <th>Ngày tạo</th>
                                            <th>Ngày cập nhật</th>
                                            <th>Hành động</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($brands as $index => $brand)
                                            <tr>
                                                <td>
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input selectItem">
                                                        <label class="form-check-label"></label>
                                                    </div>
                                                </td>
                                                <td>{{ $index + 1 }}</td>
                                                <td>
                                                    <strong>{{ $brand->name }}</strong>
                                                </td>
                                                <td>{{ $brand->slug }}</td>
                                                <td>{{ Str::limit($brand->description, 60, '...') }}</td>
                                                <td>{{ $brand->created_at?->format('d/m/Y H:i') ?? '—' }}</td>
                                                <td>{{ $brand->updated_at?->format('d/m/Y H:i') ?? '—' }}</td>
                                               {{-- {{ dd($brand->slug) }} --}}
                                                <td>
                                                    <div class="d-flex gap-2">
                                                        <a href="{{ route('admin.brands.edit', $brand->slug) }}" class="btn btn-soft-primary btn-sm">
                                                            <i class="bi bi-pencil"></i> Sửa
                                                        </a>
                                                        
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                                <div class="mt-3">
                                    {{ $brands->links() }}
                                </div>
                            @else
                                <div class="alert alert-info m-3" role="alert">
                                    <i class="bi bi-info-circle"></i> Không có thương hiệu nào. <a href="{{ route('admin.brands.create') }}">Tạo thương hiệu mới</a>
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
