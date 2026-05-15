@extends('client.layout.layout')

@section('content')
    <!-- Breadcrumb -->
    <div class="breadcrumb-sec">
        <div class="container">
            <div class="breadcrumb-wrap">
                <div class="breadcrumb-list">
                    <a class="breadcrumb-item" href="{{ route('client.homeClient') }}">Trang chủ</a>
                    <div class="breadcrumb-item dot"><span></span></div>
                    <a class="breadcrumb-item" href="{{ route('client.blog.index') ?? '#' }}">Blog</a>
                    <div class="breadcrumb-item dot"><span></span></div>
                    <div class="breadcrumb-item current">{{ $blog->title }}</div>
                </div>
            </div>
        </div>
    </div>

    <section class="flat-spacing">
        <div class="container">
            <div class="row">
                <!-- Nội dung chính -->
                <div class="col-lg-8">
                    <div class="blog-single">
                        <!-- Ảnh thumbnail -->
                        @if($blog->thumbnail)
                            <div class="blog-image mb-4">
                                <img src="{{ Storage::url($blog->thumbnail) }}" 
                                     alt="{{ $blog->title }}" 
                                     class="img-fluid rounded">
                            </div>
                        @endif

                        <!-- Tiêu đề -->
                        <h1 class="blog-title fw-bold mb-3">{{ $blog->title }}</h1>

                        <!-- Thông tin meta -->
                        <div class="blog-meta d-flex align-items-center gap-3 text-muted mb-4">
                            <span>By <strong>{{ $blog->author?->name ?? 'Admin' }}</strong></span>
                            <span>{{ $blog->created_at->format('d/m/Y') }}</span>
                            @if($blog->category)
                                <span class="badge bg-primary">{{ $blog->category->name }}</span>
                            @endif
                        </div>

                        <!-- Nội dung bài viết -->
                        <div class="blog-content">
                            {!! $blog->content !!}
                        </div>

                        <!-- Tag (nếu có) -->
                        @if($blog->tags)
                            <div class="blog-tags mt-5">
                                <h6 class="fw-medium">Tags:</h6>
                                <div class="d-flex flex-wrap gap-2">
                                    @foreach(explode(',', $blog->tags) as $tag)
                                        <span class="badge bg-light text-dark">{{ trim($tag) }}</span>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="col-lg-4">
                    <div class="blog-sidebar">
                        <!-- Bài viết liên quan -->
                        @if($relatedBlogs->isNotEmpty())
                            <div class="sidebar-widget">
                                <h5 class="widget-title">Bài viết liên quan</h5>
                                <ul class="related-posts">
                                    @foreach($relatedBlogs as $related)
                                        <li>
                                            <a href="{{ route('client.blogshow', $related->slug) }}">
                                                @if($related->thumbnail)
                                                    <img src="{{ Storage::url($related->thumbnail) }}" alt="">
                                                @endif
                                                <span>{{ $related->title }}</span>
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('styles')
<style>
    .blog-content {
        font-size: 1.05rem;
        line-height: 1.85;
    }
    .blog-content img {
        max-width: 100%;
        height: auto;
        border-radius: 8px;
        margin: 20px 0;
    }
    .related-posts li {
        margin-bottom: 15px;
    }
    .related-posts img {
        width: 60px;
        height: 60px;
        object-fit: cover;
        border-radius: 6px;
        margin-right: 10px;
    }
</style>
@endpush