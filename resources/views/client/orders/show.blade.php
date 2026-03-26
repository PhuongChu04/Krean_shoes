@extends('client.layout.layout')

@section('content')
    <div class="flat-spacing-13">
        <div class="container-7">
            <div class="main-content-account">
                @include('client.layout.sidebar')

                <div class="my-acount-content account-orders">
                    <div class="account-orders-wrap">
                        <h5 class="title">Chi tiết đơn hàng</h5>

                        <div class="card mb-4 p-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <h6>Đơn hàng: {{ $order->order_code }}</h6>
                                <span class="badge bg-secondary">{{ ucfirst($order->status) }}</span>
                            </div>
                            <p>
                                Ngày đặt: {{ $order->created_at->format('d/m/Y H:i') }} ·
                                Thanh toán: {{ ucfirst($order->payment_method) }} ·
                                Trạng thái thanh toán: {{ ucfirst($order->payment_status) }}
                            </p>
                            <p>Người nhận: {{ $order->receiver_name }} - {{ $order->receiver_phone }}</p>
                            <p>Địa chỉ: {{ $order->full_address }}</p>
                            @if($order->note)
                                <p>Ghi chú: {{ $order->note }}</p>
                            @endif
                            @if($order->voucher)
                                <p>Voucher: {{ $order->voucher->code }} ({{ $order->voucher->description ?? '--' }})</p>
                            @endif
                        </div>

                        <div class="card mb-4 p-3">
                            <h6>Chi tiết sản phẩm</h6>
                            <div class="row g-3">
                                @foreach($order->items as $item)
                                    <div class="col-12">
                                        <div class="card border rounded p-3">
                                            <div class="d-flex align-items-center">
                                                <div class="me-3" style="width: 70px; height: 70px; overflow: hidden; border-radius: 6px;">
                                                    <img src="{{ asset('/storage/' . $item->variant->product->thumbnail ?? 'images/no-image.png') }}" alt="{{ $item->variant->product->name ?? 'Sản phẩm đã xóa' }}" class="img-fluid" />
                                                </div>
                                                <div class="flex-fill">
                                                    <div class="fw-bold">{{ $item->variant->product->name ?? 'Sản phẩm đã xóa' }}</div>
                                                    @if($item->variant->attribute_name)
                                                        <small class="text-muted">{{ $item->variant->attribute_name }}</small>
                                                    @endif
                                                    <div class="mt-1">
                                                        <span class="text-primary fw-bold">{{ number_format($item->price, 0, ',', '.') }} ₫</span>
                                                        <span class="text-muted ms-3">x{{ $item->quantity }}</span>
                                                    </div>
                                                </div>
                                                <div class="text-end">
                                                    <small class="text-muted">Subtotal</small>
                                                    <div class="fw-bold">{{ number_format($item->subtotal, 0, ',', '.') }} ₫</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="card p-3">
                            <div class="row">
                                <div class="col-md-6">Tạm tính</div>
                                <div class="col-md-6 text-end">{{ number_format($order->subtotal, 0, ',', '.') }} ₫</div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">Giảm giá</div>
                                <div class="col-md-6 text-end">-{{ number_format($order->discount_amount, 0, ',', '.') }} ₫</div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">Phí vận chuyển</div>
                                <div class="col-md-6 text-end">{{ number_format($order->shipping_fee, 0, ',', '.') }} ₫</div>
                            </div>
                            <hr />
                            <div class="row fw-bold">
                                <div class="col-md-6">Tổng</div>
                                <div class="col-md-6 text-end">{{ number_format($order->total_amount, 0, ',', '.') }} ₫</div>
                            </div>
                        </div>
                        
                    </div> <br>
                    <div class="mb-3">
                            <a href="{{ route('client.orders.index') }}" class="tf-btn animate-btn bg-light-2">← Quay lại đơn hàng</a>
                        </div>
                </div>
            </div>
        </div>
    </div>
@endsection