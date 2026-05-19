@extends('client.layout.layout')

@section('content')
    <!-- Breadcrumb -->
    <div class="breadcrumb-sec py-3 bg-light">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('client.homeClient') }}">Trang chủ</a></li>
                    <li class="breadcrumb-item active">Blog</li>
                </ol>
            </nav>
        </div>
    </div>

    <section class="py-5">
        <div class="container">
            <div class="row">

                <!-- Sidebar -->
                <div class="col-lg-3">
                    <div class="sticky-top" style="top: 90px;">
                        {{-- <h5 class="fw-bold mb-3">Danh mục</h5>
                        <div class="list-group">
                            <a href="{{ route('client.blog.index') }}" class="list-group-item list-group-item-action {{ !request('category') ? 'active' : '' }}">
                                Tất cả bài viết
                            </a>
                            @foreach($categories as $cat)
                                <a href="{{ route('client.blog.index') }}?category={{ $cat->id }}" 
                                   class="list-group-item list-group-item-action {{ request('category') == $cat->id ? 'active' : '' }}">
                                    {{ $cat->name }}
                                </a>
                            @endforeach
                        </div> --}}

                        <!-- Tìm kiếm -->
                        <div class="mt-5">
                            <h5 class="fw-bold mb-3">Tìm kiếm</h5>
                            <form action="{{ route('client.blog.index') }}" method="GET">
                                <div class="input-group">
                                    <input type="text" name="search" class="form-control" 
                                           placeholder="Nhập từ khóa..." value="{{ request('search') }}">
                                    <button class="btn btn-primary" type="submit">
                                        <i class="bi bi-search"></i>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Danh sách bài viết -->
                <div class="col-lg-9">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h3 class="fw-bold mb-0">Bài viết mới nhất</h3>
                        <span class="text-muted">{{ $blogs->total() }} bài viết</span>
                    </div>

                    <div class="row g-4">
                        @forelse($blogs as $blog)
                            <div class="col-md-6 col-lg-4">
                                <div class="card h-100 border-0 shadow-sm hover-card overflow-hidden">
                                    @if($blog->thumbnail)
                                        <a href="{{ route('client.blog.detailshow', $blog->slug) }}">
                                            <img src="{{ Storage::url($blog->thumbnail) }}" 
                                                 class="card-img-top" 
                                                 style="height: 210px; object-fit: cover;" 
                                                 alt="{{ $blog->title }}">
                                        </a>
                                    @endif
                                    <div class="card-body d-flex flex-column">
                                        @if($blog->category)
                                            <span class="badge bg-primary mb-2 d-inline-block" style="width: fit-content;">
                                                {{ $blog->category->name }}
                                            </span>
                                        @endif
                                        
                                        <h5 class="card-title line-clamp-2">
                                            <a href="{{ route('client.blog.detailshow', $blog->slug) }}" 
                                               class="text-decoration-none text-dark">
                                                {{ $blog->title }}
                                            </a>
                                        </h5>
                                        
                                        <p class="text-muted small mt-auto">
                                            {{ $blog->created_at->format('d M, Y') }} • 
                                            By {{ $blog->author?->name ?? 'Admin' }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-12 text-center py-5">
                                <p class="text-muted fs-5">Chưa có bài viết nào.</p>
                            </div>
                        @endforelse
                    </div>

                    <!-- Phân trang -->
                    <div class="d-flex justify-content-center mt-5">
                        {{ $blogs->appends(request()->query())->links() }}
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('styles')
<style>
    .hover-card {
        transition: all 0.3s ease;
    }
    .hover-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 15px 35px rgba(0,0,0,0.1) !important;
    }
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>
@endpush