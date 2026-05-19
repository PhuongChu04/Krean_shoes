@extends('client.layout.layout')

@section('content')
    <!-- Breadcrumb -->
    <div class="breadcrumb-sec py-3 bg-light">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('client.homeClient') }}">Trang chủ</a></li>
                    <li class="breadcrumb-item"><a href="#">Blog</a></li>
                    <li class="breadcrumb-item active">{{ $blog->title }}</li>
                </ol>
            </nav>
        </div>
    </div>

    <section class="py-5">
        <div class="container">
            <div class="row g-5">

                <!-- Ảnh bên trái -->
                <div class="col-lg-5">
                    @if($blog->thumbnail)
                        <div class="sticky-top" style="top: 90px;">
                            <img src="{{ Storage::url($blog->thumbnail) }}" 
                                 alt="{{ $blog->title }}" 
                                 class="img-fluid rounded-4 shadow">
                        </div>
                    @endif
                </div>

                <!-- Nội dung bên phải -->
                <div class="col-lg-7">

                    <h1 class="fw-bold display-5 lh-1 mb-4">{{ $blog->title }}</h1>

                    <!-- Meta -->
                    <div class="d-flex flex-wrap gap-4 text-muted mb-5 pb-4 border-bottom">
                        <div>
                            <i class="bi bi-person-fill me-1"></i>
                            <strong>{{ $blog->author?->name ?? 'Admin' }}</strong>
                        </div>
                        <div>
                            <i class="bi bi-calendar3 me-1"></i>
                            {{ $blog->created_at->format('d M, Y') }}
                        </div>
                        @if($blog->category)
                            <span class="badge bg-primary fs-6">{{ $blog->category->name }}</span>
                        @endif
                    </div>

                    <!-- Nội dung chính - Chữ to & thoáng -->
                    <div class="blog-content fs-5 lh-lg">
                        {!! $blog->content !!}
                    </div>

                    <!-- Tags -->
                    @if($blog->tags)
                        <div class="mt-5 pt-5 border-top">
                            <h6 class="fw-semibold mb-3">Tags</h6>
                            <div class="d-flex flex-wrap gap-2">
                                @foreach(explode(',', $blog->tags) as $tag)
                                    <span class="badge bg-light text-dark px-3 py-2">#{{ trim($tag) }}</span>
                                @endforeach
                            </div>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </section>

    <!-- Bài viết liên quan -->
    @if($relatedBlogs->isNotEmpty())
    <section class="py-5 bg-light">
        <div class="container">
            <h4 class="text-center fw-bold mb-5">Bài viết liên quan</h4>
            <div class="row g-4">
                @foreach($relatedBlogs as $related)
                    <div class="col-lg-4 col-md-6">
                        <div class="card h-100 border-0 shadow-sm hover-card overflow-hidden">
                            <a href="{{ route('client.blog.detailshow', $related->slug) }}">
                                @if($related->thumbnail)
                                    <img src="{{ Storage::url($related->thumbnail) }}" 
                                         class="card-img-top" 
                                         style="height: 230px; object-fit: cover;" 
                                         alt="{{ $related->title }}">
                                @endif
                            </a>
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title line-clamp-2">
                                    <a href="{{ route('client.blog.detailshow', $related->slug) }}" 
                                       class="text-decoration-none text-dark">
                                        {{ $related->title }}
                                    </a>
                                </h5>
                                <p class="text-muted small mt-auto">
                                    {{ $related->created_at->format('d M, Y') }}
                                </p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif
@endsection

@push('styles')
<style>
    .blog-content {
        font-size: 1.32rem;     /* Chữ to theo yêu cầu */
        line-height: 2.1;       /* Khoảng cách dòng xa */
        color: #333;
    }
    
    .blog-content h2 { font-size: 2.2rem; margin: 3rem 0 1.4rem; }
    .blog-content h3 { font-size: 1.75rem; margin: 2.5rem 0 1.1rem; }
    
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