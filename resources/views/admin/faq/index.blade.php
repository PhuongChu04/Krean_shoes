@extends('admin.layouts.layout')

@section('title')
    Danh sách câu hỏi thường gặp
@endsection

@section('content')
    <div class="container-xxl">
        <div class="py-3 d-flex align-items-center flex-sm-row flex-column mb-3">
            <div class="flex-grow-1 d-flex align-items-center gap-2">
                <i class="mdi mdi-comment-question-outline fs-3 text-primary"></i>
                <h4 class="fs-20 fw-bold m-0">Quản lý FAQ</h4>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">Danh sách câu hỏi</h5>
                        <div>
                            <a href="{{ route('admin.account.faqs.create') }}" class="btn btn-success shadow-sm">
                                + Thêm câu hỏi
                            </a>
                        </div>
                    </div>

                    <div class="card-body">
                        @if ($faqs->isEmpty())
                            <p class="text-center text-muted">Chưa có câu hỏi nào.</p>
                        @else
                            <table class="table table-bordered mt-3">
                                <thead class="table">
                                    <tr>
                                        <th>#</th>
                                        <th>Câu hỏi</th>
                                        <th>Câu trả lờ</th>
                                        <th>Ngày tạo</th>
                                        <th class="text-center">Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($faqs as $faq)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ Str::limit($faq->question, 60) }}</td>
                                            <td>
                                                {{ Str::limit(strip_tags($faq->answer), 100) }}
                                            </td>
                                            <td>{{ $faq->created_at->format('d/m/Y') }}</td>
                                            <td class="text-center">
                                                <div class="dropdown">
                                                    <a class="dropdown-item"
                                                        href="{{ route('admin.account.faqs.edit', $id = $faq->id) }}">
                                                        Chi tiết
                                                    </a>
                                                    <form action="{{ route('admin.account.faqs.destroy', $faq->id) }}"
                                                        method="POST"
                                                        onsubmit="return confirm('Bạn có chắc muốn xóa câu hỏi này?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button class="dropdown-item text-danger" type="submit">
                                                            Xóa
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="d-flex justify-content-end mt-3">
                                {{ $faqs->links() }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
