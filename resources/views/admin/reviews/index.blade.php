@extends('admin.layouts.layout')

@section('content')
    <div class="container-xxl">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title mb-0">Quản lý đánh giá sản phẩm</h4>
                        <div>
                            <a href="{{ route('admin.review') }}" class="btn btn-sm btn-outline-secondary me-2">
                                Tất cả
                            </a>
                            <a href="{{ route('admin.review', ['status' => 'pending']) }}" 
                               class="btn btn-sm btn-warning">Chờ duyệt</a>
                            <a href="{{ route('admin.review', ['status' => 'approved']) }}" 
                               class="btn btn-sm btn-success">Đã duyệt</a>
                            <a href="{{ route('admin.review', ['status' => 'hidden']) }}" 
                               class="btn btn-sm btn-secondary">Đã ẩn</a>
                        </div>
                    </div>

                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th width="5%">ID</th>
                                        <th>Sản phẩm</th>
                                        <th>Khách hàng</th>
                                        <th>Đánh giá</th>
                                        <th>Nội dung</th>
                                        <th>Trạng thái</th>
                                        <th>Thời gian</th>
                                        <th>Hành động</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($reviews as $review)
                                        <tr>
                                            <td><strong>#{{ $review->id }}</strong></td>
                                            <td>
                                                <strong>{{ $review->productVariant?->product?->name ?? 'Sản phẩm đã xóa' }}</strong>
                                                <br>
                                                <small class="text-muted">
                                                    Màu: {{ $review->productVariant?->color?->name ?? '-' }} | 
                                                    Size: {{ $review->productVariant?->size?->name ?? '-' }}
                                                </small>
                                            </td>
                                            <td>
                                                {{ $review->user?->name ?? 'Khách vãng lai' }}
                                                <br>
                                                <small class="text-muted">{{ $review->user?->email }}</small>
                                            </td>
                                            <td>
                                                <div class="text-warning">
                                                    @for($i = 1; $i <= 5; $i++)
                                                        @if($i <= $review->rating)
                                                            ★
                                                        @else
                                                            ☆
                                                        @endif
                                                    @endfor
                                                </div>
                                            </td>
                                            <td>
                                                <strong>{{ $review->title }}</strong>
                                                <p class="mb-0 text-muted small">{{ Str::limit($review->content, 80) }}</p>
                                            </td>
                                            <td>
                                                <span class="badge bg-{{ $review->status === 'approved' ? 'success' : ($review->status === 'pending' ? 'warning' : 'secondary') }}">
                                                    {{ ucfirst($review->status) }}
                                                </span>
                                            </td>
                                            <td>{{ $review->created_at->format('d/m/Y H:i') }}</td>
                                            <td>
                                                <a href="{{ route('admin.showReview', $review) }}" 
                                                   class="btn btn-sm btn-primary">
                                                   <iconify-icon icon="solar:pen-2-broken"
                                                                    class="align-middle fs-18"></iconify-icon>
                                                    {{-- <i class="ri-eye-line">chi tiết</i> --}}
                                                </a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="8" class="text-center py-4">Chưa có đánh giá nào.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="card-footer">
                        {{ $reviews->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection