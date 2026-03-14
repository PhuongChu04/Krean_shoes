@extends('admin.layouts.layout')
@section('content')
    <!-- Start Container Fluid -->
    <div class="container-xxl">

        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center gap-1">
                        <h4 class="card-title flex-grow-1">Thùng Rác Voucher</h4>

                        <a href="{{ route('admin.vouchers.index') }}" class="btn btn-sm btn-secondary">
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
                                            <th>Xóa lúc</th>
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
                                                <td>{{ $voucher->quanlity }}</td>
                                                <td>
                                                    {{ $voucher->discount_amount }}
                                                    {{ $voucher->type === 'percentage' ? '%' : 'VNĐ' }}
                                                </td>
                                                <td>{{ $voucher->deleted_at?->format('d/m/Y H:i') ?? '—' }}</td>
                                                <td>
                                                    <div class="d-flex gap-2">
                                                        <form action="{{ route('admin.vouchers.restore', $voucher->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Khôi phục voucher này?');">
                                                            @csrf
                                                            <button type="submit" class="btn btn-soft-success btn-sm">
                                                                <i class="bi bi-arrow-clockwise"></i> Khôi phục
                                                            </button>
                                                        </form>
                                                        <form action="{{ route('admin.vouchers.force-delete', $voucher->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Xóa vĩnh viễn? Hành động này không thể hoàn tác!');">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-soft-danger btn-sm">
                                                                <i class="bi bi-trash"></i> Xóa vĩnh viễn
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
                                    <i class="bi bi-info-circle"></i> Thùng rác trống. <a href="{{ route('admin.vouchers.index') }}">Quay lại danh sách voucher</a>
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
