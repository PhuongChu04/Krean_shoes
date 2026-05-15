@extends('admin.layouts.layout')
@section('content')
    <!-- Start Container Fluid -->
    <div class="container-xxl">

        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center gap-1">
                        <h4 class="card-title flex-grow-1">Danh sách Voucher</h4>

                        <a href="{{ route('admin.vouchers.create') }}" class="btn btn-sm btn-primary">
                            <i class="bi bi-plus"></i> Thêm Voucher Mới
                        </a>

                        <a href="{{ route('admin.vouchers.trash') }}" class="btn btn-sm btn-warning">
                            <i class="bi bi-trash"></i> Thùng Rác
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
                            @if($vouchers->count() > 0)
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
                                            <th>Tên Voucher</th>
                                            <th>Mã Code</th>
                                            <th>Loại</th>
                                            <th>Số lượng</th>
                                            <th>Giảm giá</th>
                                            <th>Ngày bắt đầu</th>
                                            <th>Ngày kết thúc</th>
                                            <th>Trạng thái</th>
                                            <th>Hành động</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($vouchers as $index => $voucher)
                                            <tr>
                                                <td>
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input selectItem">
                                                        <label class="form-check-label"></label>
                                                    </div>
                                                </td>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $voucher->name }}</td>
                                                <td>
                                                    <span class="badge bg-info">{{ $voucher->code }}</span>
                                                </td>
                                                <td>
                                                    <span class="badge bg-{{ $voucher->type === 'percentage' ? 'warning' : 'success' }}">
                                                        {{ $voucher->type === 'percentage' ? 'Phần trăm' : 'Cố định' }}
                                                    </span>
                                                </td>
                                                <td>{{ $voucher->quantity }}</td>
                                                <td>
                                                    {{ $voucher->discount_amount }}
                                                    {{ $voucher->type === 'percentage' ? '%' : 'VNĐ' }}
                                                </td>
                                                <td>{{ $voucher->start_date?->format('d/m/Y H:i') ?? '—' }}</td>
                                                <td>{{ $voucher->end_date?->format('d/m/Y H:i') ?? '—' }}</td>
                                                <td>
                                                    <span class="badge bg-{{ $voucher->status === 'active' ? 'success' : 'danger' }}">
                                                        {{ $voucher->status === 'active' ? 'Hoạt động' : 'Không hoạt động' }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <div class="d-flex gap-2">
                                                        <a href="{{ route('admin.vouchers.edit', $voucher->id) }}" class="btn btn-soft-primary btn-sm">
                                                            <i class="bi bi-pencil"></i> Sửa
                                                        </a>
                                                        <form action="{{ route('admin.vouchers.destroy', $voucher->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Bạn chắc chắn muốn xóa?');">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-soft-danger btn-sm">
                                                                <i class="bi bi-trash"></i> Xóa
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
                                    <i class="bi bi-info-circle"></i> Không có voucher nào. <a href="{{ route('admin.vouchers.create') }}">Tạo voucher mới</a>
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
