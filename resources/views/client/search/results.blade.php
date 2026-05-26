@extends('client.layout.layout')

@section('content')
    <!-- Breadcrumb -->
    <div class="breadcrumb-sec py-3 bg-light">
        <div class="container">
            <div class="breadcrumb-list">
                <a href="{{ route('client.homeClient') }}">Trang chủ</a>
                <span class="dot">›</span>
                <span class="current">Kết quả tìm kiếm</span>
            </div>
        </div>
    </div>

    <section class="flat-spacing">
        <div class="container">
            <div class="flat-title mb-4">
                <h4 class="title">
                    Kết quả tìm kiếm cho: 
                    <span class="text-primary">"{{ $keyword }}"</span>
                </h4>
                <p class="desc">{{ $products->total() }} sản phẩm được tìm thấy</p>
            </div>

            @if($products->isEmpty())
                <div class="text-center py-5">
                    <h5 class="text-muted">Không tìm thấy sản phẩm nào phù hợp với từ khóa "{{ $keyword }}".</h5>
                    <a href="{{ route('shop.index') }}" class="btn btn-primary mt-3">Quay lại cửa hàng</a>
                </div>
            @else
                <!-- Danh sách sản phẩm - Giống hệt Hot Deals trên Home -->
                <div class="row row-cols-2 row-cols-md-3 row-cols-lg-4 g-4">
                    @forelse($products as $product)
                        @php
                            $firstVariant = $product->variants->sortBy('price')->first() ?? null;
                            $mainImage = $product->thumbnail 
                                ? Storage::url($product->thumbnail) 
                                : ($firstVariant && $firstVariant->images->first() 
                                    ? Storage::url($firstVariant->images->first()->image) 
                                    : asset('images/default-product.jpg'));

                            $hoverImage = $firstVariant && $firstVariant->images->count() > 1 
                                ? Storage::url($firstVariant->images->skip(1)->first()->image) 
                                : $mainImage;

                            $minPrice = $product->variants->min('price') ?? 0;
                            $available = $firstVariant ? $firstVariant->stock : 0;
                        @endphp

                        <div class="col">
                            <div class="card-product style-center" 
                                 data-product-id="{{ $product->id }}"
                                 data-variants="{{ json_encode(
                                     $product->variants->map(fn($v) => [
                                         'id' => $v->id,
                                         'size_id' => $v->size_id,
                                         'size_name' => $v->size?->name ?? '',
                                         'color_id' => $v->color_id,
                                         'color_name' => $v->color?->name ?? '',
                                         'color_code' => $v->color?->code ?? '#000',
                                         'price' => $v->price,
                                         'stock' => $v->stock ?? 0,
                                     ])
                                 ) }}">

                                <div class="card-product-wrapper">
                                    <a href="{{ route('client.product.detail', $product->slug ?? $product->id) }}" 
                                       class="product-img">
                                        <img class="img-product lazyload" 
                                             data-src="{{ $mainImage }}" 
                                             src="{{ $mainImage }}" 
                                             alt="{{ $product->name }}">

                                        <img class="img-hover lazyload" 
                                             data-src="{{ $hoverImage }}" 
                                             src="{{ $hoverImage }}" 
                                             alt="{{ $product->name }}">
                                    </a>

                                    <ul class="list-product-btn">
                                        
                                        <li class="wishlist">
                                            <form action="{{ route('client.wishlist.store', $product->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" class="bg-surface hover-tooltip tooltip-left box-icon btn btn-link p-0 border-0 bg-transparent text-danger">
                                                    <span class="icon icon-heart2"></span>
                                                    <span class="tooltip">Yêu thích</span>
                                                </button>
                                            </form>
                                        </li>
                                    </ul>
                                </div>

                                <div class="card-product-info text-center">
                                    <a href="{{ route('client.product.detail', $product->slug ?? $product->id) }}" 
                                       class="name-product link fw-medium text-md">
                                        {{ Str::limit($product->name, 45) }}
                                    </a>

                                    <p class="price-wrap fw-medium">
                                        <span class="price-new">{{ number_format($minPrice) }} ₫</span>
                                    </p>

                                    <!-- Màu sắc -->
                                    <ul class="list-color-product justify-content-center">
                                        @foreach($product->variants->unique('color_id')->take(4) as $variant)
                                            <li class="list-color-item color-swatch">
                                                <span class="swatch-value" 
                                                      style="background-color: {{ $variant->color?->code ?? '#000' }};"></span>
                                            </li>
                                        @endforeach
                                    </ul>

                                    <div class="product-progress-sale mt-2">
                                        <p class="text-avaiable text-sm">
                                            Còn lại: 
                                            <span class="fw-medium {{ $available > 10 ? 'text-success' : 'text-danger' }}">
                                                {{ $available }}
                                            </span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                    @endforelse
                </div>

                <!-- Phân trang -->
                <div class="d-flex justify-content-center mt-5">
                    {{ $products->appends(request()->query())->links() }}
                </div>
            @endif
        </div>
    </section>
@endsection