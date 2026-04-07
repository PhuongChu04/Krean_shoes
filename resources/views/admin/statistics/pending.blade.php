@extends('admin.layouts.layout')

@section('content')
    <div class="container-fluid">

        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="fw-bold">Đơn hàng chờ xử lý</h4>
                        <p class="text-muted">Có {{ $pendingOrders->total() ?? 0 }} đơn đang chờ</p>
                    </div>
                    <a href="{{ route('admin.order.index') }}" class="btn btn-secondary">
                        <i class="bx bx-arrow-back"></i> Quay lại tất cả đơn hàng
                    </a>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Mã đơn</th>
                                <th>Khách hàng</th>
                                <th>Ngày đặt</th>
                                <th>Tổng tiền</th>
                                <th>Trạng thái thanh toán</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($pendingOrders as $order)
                                <tr>
                                    <td><strong>#{{ $order->order_code }}</strong></td>
                                    <td>{{ $order->user?->name ?? $order->receiver_name ?? 'Khách vãng lai' }}</td>
                                    <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                                    <td class="fw-semibold">{{ number_format($order->total_amount) }} ₫</td>
                                    <td>
                                        <span class="badge bg-{{ $order->payment_status === 'paid' ? 'success' : 'warning' }}">
                                            {{ ucfirst($order->payment_status) }}
                                        </span>
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.order.show', $order) }}" 
                                           class="btn btn-sm btn-primary">
                                            Xem chi tiết
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-5 text-muted">
                                        Hiện không có đơn hàng nào đang chờ xử lý.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Phân trang -->
            <div class="card-footer">
                <div class="d-flex justify-content-center">
                    {{ $pendingOrders->links() }}
                </div>
            </div>
        </div>

    </div>
@endsection