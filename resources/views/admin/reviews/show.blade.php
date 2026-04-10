@extends('admin.layouts.layout')

@section('content')
    <div class="container-xxl">
        <div class="row">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Chi tiết đánh giá #{{ $review->id }}</h4>
                    </div>
                    <div class="card-body">
                        <div class="d-flex gap-4 mb-4">
                            <div>
                                <strong>Sản phẩm:</strong> {{ $review->productVariant?->product?->name }}
                            </div>
                            <div>
                                <strong>Khách hàng:</strong> {{ $review->user?->name }}
                            </div>
                        </div>

                        <div class="mb-4">
                            <strong>Đánh giá:</strong>
                            <div class="text-warning fs-3">
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= $review->rating) ★ @else ☆ @endif
                                @endfor
                            </div>
                        </div>

                        <div class="mb-4">
                            <strong>Tiêu đề:</strong>
                            <p class="fw-medium">{{ $review->title }}</p>
                        </div>

                        <div>
                            <strong>Nội dung đánh giá:</strong>
                            <p class="border p-3 bg-light rounded">{{ $review->content }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Phần phản hồi của Admin -->
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Phản hồi từ Admin</h5>
                    </div>
                    <div class="card-body">
                        @if($review->reply)
                            <div class="alert alert-info">
                                <strong>Phản hồi lúc:</strong> {{ $review->replied_at?->format('d/m/Y H:i') }}<br>
                                <p class="mt-2">{{ $review->reply }}</p>
                            </div>
                        @else
                            <form action="{{ route('admin.reply', $review) }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label class="form-label fw-medium">Nội dung phản hồi</label>
                                    <textarea name="reply" class="form-control" rows="6" placeholder="Viết phản hồi cho khách hàng..." required></textarea>
                                </div>
                                <button type="submit" class="btn btn-success w-100">
                                    <i class="ri-reply-line"></i> Gửi phản hồi
                                </button>
                            </form>
                        @endif
                    </div>
                </div>

                <!-- Thay đổi trạng thái -->
                <div class="card mt-4">
                    <div class="card-header">
                        <h5 class="mb-0">Trạng thái đánh giá</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.status', $review) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <select name="status" class="form-select mb-3">
                                <option value="pending" {{ $review->status == 'pending' ? 'selected' : '' }}>Chờ duyệt</option>
                                <option value="approved" {{ $review->status == 'approved' ? 'selected' : '' }}>Đã duyệt (Hiển thị)</option>
                                <option value="hidden" {{ $review->status == 'hidden' ? 'selected' : '' }}>Ẩn</option>
                            </select>
                            <button type="submit" class="btn btn-primary w-100">Cập nhật trạng thái</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection