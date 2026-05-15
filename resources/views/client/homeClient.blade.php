@extends('client.layout.layout')

@section('content')
    <!-- Slider -->
    <div class="tf-slideshow slider-electronic slider-default">
        <div dir="ltr" class="swiper tf-sw-slideshow slider-effect-fade" data-preview="1" data-tablet="1" data-mobile="1"
            data-centered="false" data-space="0" data-space-mb="0" data-loop="true" data-auto-play="true">
            <div class="swiper-wrapper">

                <div class="swiper-slide">
                    <div class="slider-wrap bg-type-4">
                        <div class="image">
                            <img src="images/slider/electronic/giày.jpng" data-src="images/slider/electronic/giày.jpg"
                                alt="slider" class="lazyload">
                        </div>
                        <div class="box-content">
                            <div class="container">
                                <div class="row">
                                    <div class="col-lg-12 col-12 col-sm-6">
                                        <div class="content-slider">
                                            <div class="box-title-slider">
                                                <p class="sub text-md fw-medium fade-item fade-item-1 text-dark-3">
                                                    Giày thể thao
                                                </p>
                                                <h2 class="heading fw-medium fade-item fade-item-2 text-dark-3">
                                                    Giảm tới <br> 15%
                                                </h2>
                                            </div>
                                            <div class="box-btn-slider fade-item fade-item-3">
                                                <a href="{{ route('shop.index') }}" class="tf-btn btn-dark2 animate-btn">
                                                    Mua ngay
                                                    <i class="icon icon-arr-right"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="swiper-slide reverse-slide">
                    <div class="slider-wrap bg-type-5">
                        <div class="image">
                            <img src="images/slider/electronic/giày 1.jpg" data-src="images/slider/electronic/giày 1.jpg"
                                alt="slider" class="lazyload">
                        </div>
                        <div class="box-content">
                            <div class="container">
                                <div class="row">
                                    <div class=" offset-lg-8 col-lg-4 col-sm-6 offset-6 col-12">
                                        <div class="content-slider">
                                            <div class="box-title-slider">
                                                <p class="sub text-md fw-medium fade-item fade-item-1 text-dark-3">
                                                    Giày adidas
                                                </p>
                                                <h2 class="heading fw-medium fade-item fade-item-2 text-dark-3">
                                                    Thương hiệu <br> đẳng cấp
                                                </h2>

                                            </div>
                                            <div class="box-btn-slider fade-item fade-item-3">
                                                <a href="{{ route('shop.index') }}" class="tf-btn btn-dark2 animate-btn">
                                                    Mua ngay
                                                    <i class="icon icon-arr-right"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="swiper-slide">
                    <div class="slider-wrap bg-type-6 type-image-right">
                        <div class="image">
                            <img src="images/slider/electronic/giày 2.jpg" data-src="images/slider/electronic/giày 2.jpg"
                                alt="slider" class="lazyload">
                        </div>
                        <div class="box-content">
                            <div class="container">
                                <div class="row">
                                    <div class="col-lg-12 col-12 col-sm-6">
                                        <div class="content-slider">
                                            <div class="box-title-slider">
                                                <p class="sub text-md fw-medium fade-item fade-item-1 text-dark-3">
                                                    Giày Chất – Cuộc Sống Chất
                                                </p>
                                                <h2 class="heading fw-medium fade-item fade-item-2 text-dark-3">
                                                    Tiếp thêm năng lượng <br> Cho bước chạy của bạn
                                                </h2>

                                            </div>
                                            <div class="box-btn-slider fade-item fade-item-3">
                                                <a href="{{ route('shop.index') }}" class="tf-btn btn-dark2 animate-btn">
                                                    Mua ngay
                                                    <i class="icon icon-arr-right"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="wrap-pagination">
                <div class="container">
                    <div class="sw-dots sw-pagination-slider justify-content-center"></div>
                </div>
            </div>
        </div>
    </div>
    <!-- /Slider -->
    <!-- Marquee -->
    <div class="marquee-sale bg-light-green-2">
        <div class="marquee-wrapper">
            <div class="initial-child-container">
                <div class="marquee-child-item">
                    <p class="display-xs fw-medium">50% Off On Selected Items</p>
                </div>
                <div class="marquee-child-item"><i class="icon-flash-star"></i></div>
                <div class="marquee-child-item">
                    <p class="display-xs fw-medium">New Arrival</p>
                </div>
                <div class="marquee-child-item"><i class="icon-flash-star"></i></div>
                <!-- 2 -->
                <div class="marquee-child-item">
                    <p class="display-xs fw-medium">50% Off On Selected Items</p>
                </div>
                <div class="marquee-child-item"><i class="icon-flash-star"></i></div>
                <div class="marquee-child-item">
                    <p class="display-xs fw-medium">New Arrival</p>
                </div>
                <div class="marquee-child-item"><i class="icon-flash-star"></i></div>
                <!-- 3 -->
                <div class="marquee-child-item">
                    <p class="display-xs fw-medium">50% Off On Selected Items</p>
                </div>
                <div class="marquee-child-item"><i class="icon-flash-star"></i></div>
                <div class="marquee-child-item">
                    <p class="display-xs fw-medium">New Arrival</p>
                </div>
                <div class="marquee-child-item"><i class="icon-flash-star"></i></div>
                <!-- 4 -->
                <div class="marquee-child-item">
                    <p class="display-xs fw-medium">50% Off On Selected Items</p>
                </div>
                <div class="marquee-child-item"><i class="icon-flash-star"></i></div>
                <div class="marquee-child-item">
                    <p class="display-xs fw-medium">New Arrival</p>
                </div>
                <div class="marquee-child-item"><i class="icon-flash-star"></i></div>
                <!-- 5 -->
                <div class="marquee-child-item">
                    <p class="display-xs fw-medium">50% Off On Selected Items</p>
                </div>
                <div class="marquee-child-item"><i class="icon-flash-star"></i></div>
                <div class="marquee-child-item">
                    <p class="display-xs fw-medium">New Arrival</p>
                </div>
                <div class="marquee-child-item"><i class="icon-flash-star"></i></div>
                <!-- 6 -->
                <div class="marquee-child-item">
                    <p class="display-xs fw-medium">50% Off On Selected Items</p>
                </div>
                <div class="marquee-child-item"><i class="icon-flash-star"></i></div>
                <div class="marquee-child-item">
                    <p class="display-xs fw-medium">New Arrival</p>
                </div>
                <div class="marquee-child-item"><i class="icon-flash-star"></i></div>
                <!-- 7 -->
                <div class="marquee-child-item">
                    <p class="display-xs fw-medium">50% Off On Selected Items</p>
                </div>
                <div class="marquee-child-item"><i class="icon-flash-star"></i></div>
                <div class="marquee-child-item">
                    <p class="display-xs fw-medium">New Arrival</p>
                </div>
                <div class="marquee-child-item"><i class="icon-flash-star"></i></div>
            </div>
        </div>
    </div>
    <!-- /Marquee -->
    <!-- Categories -->

    <section class="flat-spacing-3">
        <div class="container">
            <div class="flat-title text-start wow fadeInUp">
                <h4 class="title">Danh mục sản phẩm</h4>
            </div>

            <div class="wow fadeInUp">
                <div class="fl-control-sw pos3">
                    <div dir="ltr" class="swiper tf-swiper"
                        data-swiper='{
                        "slidesPerView": 2,
                        "spaceBetween": 12,
                        "speed": 800,
                        "observer": true,
                        "observeParents": true,
                        "slidesPerGroup": 2,
                        "navigation": {
                            "clickable": true,
                            "nextEl": ".nav-next-categories",
                            "prevEl": ".nav-prev-categories"
                        },
                        "pagination": { "el": ".sw-pagination-categories", "clickable": true },
                        "breakpoints": {
                            "575": { "slidesPerView": 3, "spaceBetween": 12, "slidesPerGroup": 3 },
                            "768": { "slidesPerView": 4, "spaceBetween": 12, "slidesPerGroup": 4 },
                            "992": { "slidesPerView": 5, "spaceBetween": 24, "slidesPerGroup": 5 },
                            "1200": { "slidesPerView": 6, "spaceBetween": 24, "slidesPerGroup": 6 }
                        }
                    }'>
                        <div class="swiper-wrapper">

                            @forelse($categories as $category)
                                <div class="swiper-slide">
                                    <div class="wg-cls style-square hover-img">
                                        <a href="{{ route('shop.index') }}?category={{ $category->id }}"
                                            class="image img-style d-block overflow-hidden position-relative"
                                            style="aspect-ratio: 1 / 1;"> <!-- Buộc tỷ lệ vuông 1:1 -->

                                            @if ($category->image)
                                                <img src="{{ Storage::url($category->image) }}"
                                                    data-src="{{ Storage::url($category->image) }}"
                                                    alt="{{ $category->name }}" class="lazyload w-100 h-100 object-cover">
                                            @else
                                                <img src="https://via.placeholder.com/400x400?text={{ urlencode($category->name) }}"
                                                    alt="{{ $category->name }}" class="lazyload w-100 h-100 object-cover">
                                            @endif
                                        </a>

                                        <div class="cls-content text-center">
                                            <a href="{{ route('shop.index') }}?category={{ $category->id }}"
                                                class="link text-md fw-medium">
                                                {{ $category->name }}
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="swiper-slide text-center py-5">
                                    <p class="text-muted">Chưa có danh mục nào được thêm.</p>
                                </div>
                            @endforelse

                        </div>

                        <div class="d-flex d-xl-none sw-dot-default sw-pagination-categories justify-content-center"></div>
                    </div>

                    <div class="swiper-button-next d-none d-xl-flex nav-swiper nav-next-categories"></div>
                    <div class="swiper-button-prev d-none d-xl-flex nav-swiper nav-prev-categories"></div>
                </div>
            </div>
        </div>
    </section>
    <!-- /Categories -->
    <!-- Top Pick -->

    <!-- /Top Pick -->
    <!-- Banner Collection-->
    <div class="s-banner-colection banner-cls-electric flat-spacing-3">
        <div class="container">
            <div class="banner-content tf-grid-layout tf-col-2 hover-overlay-2">
                <div class="image">
                    <img src="images/banner/phone.png" alt="images/banner/phone.png" class="lazyload">
                </div>
                <div class="box-content">
                    <div class="box-title-banner wow fadeInUp">
                        <p class="title display-md fw-medium">
                            Unmatched Performance
                        </p>
                        <p class="sub text-md text-main">
                            Upgrade your devices with cutting-edge technology.
                        </p>
                    </div>
                    <div class="box-btn-banner wow fadeInUp">
                        <a href="shop-default.html" class="tf-btn btn-dark2 animate-btn">
                            Shop Now
                            <i class="icon icon-arr-right"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /Banner Collection-->
    <!-- Hot Deal -->
    <!-- Hot Deal -->
    <section class="bg-surface flat-spacing-8">
        <div class="container">
            <div class="flat-title mb_1 style-between wow fadeInUp">
                <div class="box-title">
                    <h4 class="title">Hot Deals</h4>
                    <p class="desc text-main text-md">Explore our most popular pieces that customers can't get enough of
                    </p>
                </div>
                <div class="wg-countdown-2">
                    <span class="js-countdown" data-timer="46556" data-labels="Days,Hours,Mins,Secs"></span>
                </div>
            </div>

            <div class="fl-control-sw wow fadeInUp">
                <div dir="ltr" class="swiper tf-swiper sw-height"
                    data-swiper='{
                "slidesPerView": 2,
                "spaceBetween": 12,
                "speed": 800,
                "observer": true,
                "observeParents": true,
                "slidesPerGroup": 2,
                "navigation": {
                    "clickable": true,
                    "nextEl": ".nav-next-deal",
                    "prevEl": ".nav-prev-deal"
                },
                "pagination": { "el": ".sw-pagination-deal", "clickable": true },
                "breakpoints": {
                    "768": { "slidesPerView": 3, "spaceBetween": 12, "slidesPerGroup": 3 },
                    "1200": { "slidesPerView": 4, "spaceBetween": 24, "slidesPerGroup": 4}
                }
            }'>
                    <div class="swiper-wrapper">

                        @forelse ($hotDeals as $product)
                            @php
                                $firstVariant = $product->variants->sortBy('price')->first() ?? null;

                                $mainImage = $product->thumbnail
                                    ? Storage::url($product->thumbnail)
                                    : ($firstVariant && $firstVariant->images->first()
                                        ? Storage::url($firstVariant->images->first()->image)
                                        : asset('images/default-product.jpg'));

                                $hoverImage =
                                    $firstVariant && $firstVariant->images->count() > 1
                                        ? Storage::url($firstVariant->images->skip(1)->first()->image)
                                        : $mainImage;

                                $minPrice = $product->variants->min('price') ?? 0;
                                $oldPrice = $minPrice * 1.25; // giả định giảm 20%
                                $salePercent =
                                    $oldPrice > $minPrice ? round((($oldPrice - $minPrice) / $oldPrice) * 100) : 0;
                                $available = $firstVariant ? $firstVariant->stock : 0;
                            @endphp

                            <div class="swiper-slide">
                                <div class="card-product style-center" data-product-id="{{ $product->id }}"
                                    data-variants="{{ json_encode(
                                        $product->variants->map(function ($v) {
                                                return [
                                                    'id' => $v->id,
                                                    'size_id' => $v->size_id,
                                                    'size_name' => $v->size?->name ?? '',
                                                    'color_id' => $v->color_id,
                                                    'color_name' => $v->color?->name ?? '',
                                                    'color_code' => $v->color?->code ?? '#000',
                                                    'price' => $v->price,
                                                    'stock' => $v->stock ?? 0,
                                                ];
                                            })->values(),
                                    ) }}">

                                    <div class="card-product-wrapper">
                                        <a href="{{ route('client.product.detail', $product->slug ?? $product->id) }}"
                                            class="product-img">
                                            <img class="img-product lazyload" data-src="{{ $mainImage }}"
                                                src="{{ $mainImage }}" alt="{{ $product->name }}">

                                            <img class="img-hover lazyload" data-src="{{ $hoverImage }}"
                                                src="{{ $hoverImage }}" alt="{{ $product->name }}">
                                        </a>

                                        @if ($salePercent > 0)
                                            <div class="on-sale-wrap">
                                                <span class="on-sale-item">{{ $salePercent }}% Off</span>
                                            </div>
                                        @endif

                                        <ul class="list-product-btn">
                                            <!-- NÚT ADD TO CART ĐÃ SỬA -->
                                            <li>
                                                <a href="javascript:void(0);" data-add-to-cart
                                                    class="bg-surface hover-tooltip tooltip-left box-icon">
                                                    <span class="icon icon-cart2"></span>
                                                    <span class="tooltip">Thêm vào giỏ hàng</span>
                                                </a>
                                            </li>

                                            <li class="wishlist">
                                                <a href="javascript:void(0);"
                                                    class="bg-surface hover-tooltip tooltip-left box-icon">
                                                    <span class="icon icon-heart2"></span>
                                                    <span class="tooltip">Yêu thích</span>
                                                </a>
                                            </li>

                                            <li>
                                                <a href="#quickView" data-bs-toggle="modal"
                                                    class="bg-surface hover-tooltip tooltip-left box-icon quickview">
                                                    <span class="icon icon-view"></span>
                                                    <span class="tooltip">Xem nhanh</span>
                                                </a>
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
                                            @if ($oldPrice > $minPrice)
                                                <span class="price-old old-line">{{ number_format($oldPrice) }} ₫</span>
                                            @endif
                                        </p>

                                        <!-- Màu sắc -->
                                        <ul class="list-color-product justify-content-center">
                                            @foreach ($product->variants->unique('color_id')->take(3) as $variant)
                                                <li
                                                    class="list-color-item color-swatch hover-tooltip tooltip-bot {{ $loop->first ? 'active' : '' }}">
                                                    <span class="tooltip">{{ $variant->color?->name ?? 'Color' }}</span>
                                                    <span class="swatch-value"
                                                        style="background-color: {{ $variant->color?->code ?? '#000' }};"></span>
                                                </li>
                                            @endforeach
                                        </ul>

                                        <!-- Available -->
                                        <div class="product-progress-sale mt-2">
                                            <p class="text-avaiable text-sm">
                                                Còn lại:
                                                <span
                                                    class="fw-medium {{ $available > 10 ? 'text-success' : 'text-danger' }}">
                                                    {{ $available }}
                                                </span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="swiper-slide text-center py-5">
                                <p>Hiện tại chưa có sản phẩm hot deal nào.</p>
                            </div>
                        @endforelse

                    </div>

                    <div class="d-flex d-xl-none sw-dot-default sw-pagination-deal justify-content-center"></div>
                </div>

                <div class="swiper-button-next d-none d-xl-flex nav-swiper nav-next-deal"></div>
                <div class="swiper-button-prev d-none d-xl-flex nav-swiper nav-prev-deal"></div>
            </div>
        </div>
    </section>
    <!-- /Hot Deal -->
    <!-- /Hot Deal -->
    <!-- Testimonial -->
    <section class="flat-spacing-2 pb-0">
        <div class="container">
            <div class="flat-title text-start wow fadeInUp">
                <h4 class="title">Happy Customers</h4>
            </div>
            <div dir="ltr" class="swiper tf-swiper"
                data-swiper='{
                "slidesPerView": 1,
                "spaceBetween": 12,
                "speed": 800,
                "observer": true,
                "observeParents": true,
                "slidesPerGroup": 1,
                "pagination": { "el": ".sw-pagination-tes", "clickable": true },
                "breakpoints": {
                "768": { "slidesPerView": 2, "spaceBetween": 24, "slidesPerGroup": 2 },
                "1200": { "slidesPerView": 3, "spaceBetween": 24, "slidesPerGroup": 3}
                }
            }'>
                <div class="swiper-wrapper">
                    <!-- item 1 -->
                    <div class="swiper-slide">
                        <div class="wg-testimonial wow fadeInLeft">
                            <div class="content">
                                <div class="content-top">
                                    <div class="box-author">
                                        <p class="name-author text-sm fw-medium">Emily T.</p>
                                        <div class="box-verified text-main">
                                            <i class="icon-verifi"></i>
                                            <p class="text-xs fst-italic">
                                                Verified Buyer
                                            </p>
                                        </div>
                                    </div>
                                    <div class="list-star-default">
                                        <i class="icon-star"></i>
                                        <i class="icon-star"></i>
                                        <i class="icon-star"></i>
                                        <i class="icon-star"></i>
                                        <i class="icon-star"></i>
                                    </div>
                                    <p class="text-review text-sm text-main">
                                        The quality of the electronics exceeded my expectations. Every device feels
                                        premium, and the performance is outstanding. I'm absolutely impressed.
                                    </p>
                                </div>
                                <span class="br-line d-block"></span>
                                <div class="box-avt">
                                    <div class="avatar">
                                        <img src="images/testimonial/author/author-electric1.jpg" alt="author">
                                    </div>
                                    <div class="box-price">
                                        <p class="name-item text-xs">
                                            <a href="product-detail.html" class="text-line-clamp-2">Item purchased:
                                                <span class="fw-medium text-sm link">Instax Mini 12 Camera</span>
                                            </a>
                                        </p>
                                        <p class="price text-md fw-medium">
                                            $130.00
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- item 2 -->
                    <div class="swiper-slide">
                        <div class="wg-testimonial wow fadeInLeft" data-wow-delay="0.1s">
                            <div class="content">
                                <div class="content-top">
                                    <div class="box-author">
                                        <p class="name-author text-sm fw-medium">Jessica M.</p>
                                        <div class="box-verified text-main">
                                            <i class="icon-verifi"></i>
                                            <p class="text-xs fst-italic">
                                                Verified Buyer
                                            </p>
                                        </div>
                                    </div>
                                    <div class="list-star-default">
                                        <i class="icon-star"></i>
                                        <i class="icon-star"></i>
                                        <i class="icon-star"></i>
                                        <i class="icon-star"></i>
                                        <i class="icon-star"></i>
                                    </div>
                                    <p class="text-review text-sm text-main">
                                        I love the gadget I purchased! The build quality is excellent, and the
                                        performance is top-notch. I’ve gotten so many compliments on it. Will
                                        definitely shop here again!
                                    </p>
                                </div>
                                <span class="br-line d-block"></span>
                                <div class="box-avt">
                                    <div class="avatar">
                                        <img src="images/testimonial/author/author-electric2.jpg" alt="author">
                                    </div>
                                    <div class="box-price">
                                        <p class="name-item text-xs">
                                            <a href="product-detail.html" class="text-line-clamp-2">Item purchased:
                                                <span class="fw-medium text-sm link">Wi-Fi Video Doorbell</span>
                                            </a>
                                        </p>
                                        <p class="price text-md fw-medium">
                                            $150.00
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- item 3 -->
                    <div class="swiper-slide">
                        <div class="wg-testimonial wow fadeInLeft" data-wow-delay="0.2s">
                            <div class="content">
                                <div class="content-top">
                                    <div class="box-author">
                                        <p class="name-author text-sm fw-medium">Lisa P.</p>
                                        <div class="box-verified text-main">
                                            <i class="icon-verifi"></i>
                                            <p class="text-xs fst-italic">
                                                Verified Buyer
                                            </p>
                                        </div>
                                    </div>
                                    <div class="list-star-default">
                                        <i class="icon-star"></i>
                                        <i class="icon-star"></i>
                                        <i class="icon-star"></i>
                                        <i class="icon-star"></i>
                                        <i class="icon-star"></i>
                                    </div>
                                    <p class="text-review text-sm text-main">
                                        I was pleasantly surprised by how fast my order arrived. The customer
                                        service team was helpful and responsive. Great shopping experience!
                                    </p>
                                </div>
                                <span class="br-line d-block"></span>
                                <div class="box-avt">
                                    <div class="avatar">
                                        <img src="images/testimonial/author/author-electric3.jpg" alt="author">
                                    </div>
                                    <div class="box-price">
                                        <p class="name-item text-xs">
                                            <a href="product-detail.html" class="text-line-clamp-2">Item purchased:
                                                <span class="fw-medium text-sm link">Amazfit Bip 5 Smart Watch
                                                    46mm</span> </a>
                                        </p>
                                        <p class="price text-md fw-medium">
                                            $120.00
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- item 4 -->
                    <div class="swiper-slide">
                        <div class="wg-testimonial wow fadeInLeft">
                            <div class="content">
                                <div class="content-top">
                                    <div class="box-author">
                                        <p class="name-author text-sm fw-medium">Vineta P.</p>
                                        <div class="box-verified text-main">
                                            <i class="icon-verifi"></i>
                                            <p class="text-xs fst-italic">
                                                Verified Buyer
                                            </p>
                                        </div>
                                    </div>
                                    <div class="list-star-default">
                                        <i class="icon-star"></i>
                                        <i class="icon-star"></i>
                                        <i class="icon-star"></i>
                                        <i class="icon-star"></i>
                                        <i class="icon-star"></i>
                                    </div>
                                    <p class="text-review text-sm text-main">
                                        The quality of the electronics exceeded my expectations. Every device feels
                                        premium, and the performance is outstanding. I'm absolutely impressed.
                                    </p>
                                </div>
                                <span class="br-line d-block"></span>
                                <div class="box-avt">
                                    <div class="avatar">
                                        <img src="images/testimonial/author/author-electric1.jpg" alt="author">
                                    </div>
                                    <div class="box-price">
                                        <p class="name-item text-xs">
                                            <a href="product-detail.html" class="text-line-clamp-2">Item purchased:
                                                <span class="fw-medium text-sm link">Instax Mini 12 Camera</span>
                                            </a>
                                        </p>
                                        <p class="price text-md fw-medium">
                                            $130.00
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <span class="sw-dot-default sw-pagination-tes justify-content-center"></span>
            </div>
        </div>
    </section>
    <!-- /Testimonial -->
    <!-- Brand -->
    <div class="flat-spacing-2">
        <div class="container">
            <div dir="ltr" class="swiper tf-swiper sw-brand"
                data-swiper='{
                "slidesPerView": 2,
                "spaceBetween": 0,
                "speed": 800,
                "observer": true,
                "observeParents": true,
                "slidesPerGroup": 2,
                "pagination": { "el": ".sw-pagination-brand", "clickable": true },
                "breakpoints": {
                "575": { "slidesPerView": 3},
                "991": { "slidesPerView": 4},
                "1200": { "slidesPerView": 6}
                }
            }'>
                <div class="swiper-wrapper">
                    <!-- item 1 -->
                    <div class="swiper-slide">
                        <div class="brand-item wow fadeInLeft">
                            <img src="images/brand/zara.png" alt="brand">
                        </div>
                    </div>
                    <!-- item 2 -->
                    <div class="swiper-slide">
                        <div class="brand-item wow fadeInLeft" data-wow-delay="0.1s">
                            <img src="images/brand/bear.png" alt="brand">
                        </div>
                    </div>
                    <!-- item 3 -->
                    <div class="swiper-slide">
                        <div class="brand-item wow fadeInLeft" data-wow-delay="0.2s">
                            <img src="images/brand/nike.png" alt="brand">
                        </div>
                    </div>
                    <!-- item 4 -->
                    <div class="swiper-slide">
                        <div class="brand-item wow fadeInLeft" data-wow-delay="0.3s">
                            <img src="images/brand/asos.png" alt="brand">
                        </div>
                    </div>
                    <!-- item 5 -->
                    <div class="swiper-slide">
                        <div class="brand-item wow fadeInLeft" data-wow-delay="0.4s">
                            <img src="images/brand/burberry.png" alt="brand">
                        </div>
                    </div>
                    <!-- item 6 -->
                    <div class="swiper-slide">
                        <div class="brand-item wow fadeInLeft" data-wow-delay="0.5s">
                            <img src="images/brand/forever.png" alt="brand">
                        </div>
                    </div>
                </div>
            </div>
            <div class="d-flex d-xl-none sw-dot-default sw-pagination-brand justify-content-center"></div>
        </div>
    </div>
    <!-- /Brand -->
    <!-- Latest Tip -->
    <section>
        <div class="container">
            <div class="flat-title wow fadeInUp">
                <h4 class="title">Latest Tips & Trends</h4>
                <p class="desc text-main text-md">Discover expert advice, style inspiration, and product updates on
                    our blog.</p>
            </div>
            <div class="fl-control-sw wrap-pos-nav wow fadeInUp">
                <div dir="ltr" class="swiper tf-swiper"
                    data-swiper='{
                    "slidesPerView": 1,
                    "spaceBetween": 12,
                    "speed": 800,
                    "observer": true,
                    "observeParents": true,
                    "slidesPerGroup": 1,
                    "navigation": {
                        "clickable": true,
                        "nextEl": ".nav-next-new",
                        "prevEl": ".nav-prev-new"
                    },
                    "pagination": { "el": ".sw-pagination-new", "clickable": true },
                    "breakpoints": {
                    "577": { "slidesPerView": 2, "spaceBetween": 12, "slidesPerGroup": 2 },
                    "1200": { "slidesPerView": 3, "spaceBetween": 24, "slidesPerGroup": 4}
                    }
                }'>
                    <div class="swiper-wrapper">
                        <!-- item 1 -->
                        <div class="swiper-slide">
                            <div class="blog-item-v2">
                                <div class="entry-image hover-img">
                                    <a href="blog-single.html" class="img-style">
                                        <img src="images/blog/blog-eletric1.jpg" data-src="images/blog/blog-eletric1.jpg"
                                            alt="image">
                                    </a>
                                    <div class="entry-tag">
                                        <span class="tag">Electric</span>
                                        <span class="tag">Gadgets</span>
                                    </div>
                                </div>
                                <div class="entry-content">
                                    <div class="info-box">
                                        <ul class="meta-list">
                                            <li class="item">by Jack</li>
                                            <li class="item">Jan 15, 2025</li>
                                            <li class="item">04 Comments</li>
                                        </ul>
                                        <a href="blog-single.html"
                                            class="title fw-medium link text-xl text-line-clamp-2">Tech Trends 2025:
                                            Must-Have Gadgets & Innovations</a>
                                        <p class="desc text-main text-sm text-line-clamp-2">
                                            Technology is more than convenience. It’s about enhancing everyday life
                                            with smart, seamless solutions.
                                        </p>
                                    </div>
                                    <a href="blog-single.html" class="btn-readmore link">Read more <i
                                            class="icon icon-arr-right"></i></a>
                                </div>
                            </div>
                        </div>
                        <!-- item 2 -->
                        <div class="swiper-slide">
                            <div class="blog-item-v2">
                                <div class="entry-image hover-img">
                                    <a href="blog-single.html" class="img-style">
                                        <img src="images/blog/blog-eletric2.jpg" data-src="images/blog/blog-eletric2.jpg"
                                            alt="image">
                                    </a>
                                    <div class="entry-tag">
                                        <span class="tag">Trends</span>
                                    </div>
                                </div>
                                <div class="entry-content">
                                    <div class="info-box">
                                        <ul class="meta-list">
                                            <li class="item">by Alex</li>
                                            <li class="item">Jan 19, 2025</li>
                                            <li class="item">03 Comments</li>
                                        </ul>
                                        <a href="blog-single.html"
                                            class="title fw-medium link text-xl text-line-clamp-2">Cutting-Edge
                                            Tech: Top Electronics to Watch This Year</a>
                                        <p class="desc text-main text-sm text-line-clamp-2">
                                            Electric design goes beyond function. It’s about powering your world
                                            with style, simplicity, and innovation.
                                        </p>
                                    </div>
                                    <a href="blog-single.html" class="btn-readmore link">Read more <i
                                            class="icon icon-arr-right"></i></a>
                                </div>
                            </div>
                        </div>
                        <!-- item 3 -->
                        <div class="swiper-slide">
                            <div class="blog-item-v2">
                                <div class="entry-image hover-img">
                                    <a href="blog-single.html" class="img-style">
                                        <img src="images/blog/blog-eletric3.jpg" data-src="images/blog/blog-eletric3.jpg"
                                            alt="image">
                                    </a>
                                    <div class="entry-tag">
                                        <span class="tag">Innovation</span>
                                    </div>
                                </div>
                                <div class="entry-content">
                                    <div class="info-box">
                                        <ul class="meta-list">
                                            <li class="item">by Henry</li>
                                            <li class="item">May 7, 2025</li>
                                            <li class="item">02 Comments</li>
                                        </ul>
                                        <a href="blog-single.html"
                                            class="title fw-medium link text-xl text-line-clamp-2">Next-Gen Gadgets:
                                            The Hottest Tech Trends of the Year</a>
                                        <p class="desc text-main text-sm text-line-clamp-2">
                                            Modern living starts with smart energy. From daily comfort to lasting
                                            impact, electric solutions lead the way
                                        </p>
                                    </div>
                                    <a href="blog-single.html" class="btn-readmore link">Read more <i
                                            class="icon icon-arr-right"></i></a>
                                </div>
                            </div>
                        </div>
                        <!-- item 4 -->
                        <div class="swiper-slide">
                            <div class="blog-item-v2">
                                <div class="entry-image hover-img">
                                    <a href="blog-single.html" class="img-style">
                                        <img src="images/blog/blog-eletric1.jpg" data-src="images/blog/blog-eletric1.jpg"
                                            alt="image">
                                    </a>
                                    <div class="entry-tag">
                                        <span class="tag">Electric</span>
                                        <span class="tag">Gadgets</span>
                                    </div>
                                </div>
                                <div class="entry-content">
                                    <div class="info-box">
                                        <ul class="meta-list">
                                            <li class="item">by Jack</li>
                                            <li class="item">Jan 15, 2025</li>
                                            <li class="item">04 Comments</li>
                                        </ul>
                                        <a href="blog-single.html"
                                            class="title fw-medium link text-xl text-line-clamp-2">Tech Trends 2025:
                                            Must-Have Gadgets & Innovations</a>
                                        <p class="desc text-main text-sm text-line-clamp-2">
                                            Technology is more than convenience. It’s about enhancing everyday life
                                            with smart, seamless solutions.
                                        </p>
                                    </div>
                                    <a href="blog-single.html" class="btn-readmore link">Read more <i
                                            class="icon icon-arr-right"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex d-xl-none sw-dot-default sw-pagination-new justify-content-center"></div>
                </div>
                <div class="d-none d-xl-flex swiper-button-next nav-swiper nav-next-new"></div>
                <div class="d-none d-xl-flex swiper-button-prev nav-swiper nav-prev-new"></div>
            </div>
        </div>
    </section>
    <!-- /Latest Tip -->
    <!-- Icon box -->
    <div class="flat-spacing-18">
        <div class="container">
            <div class="mw-1 m-auto flat-spacing-7">
                <div dir="ltr" class="swiper tf-swiper sw-auto tf-sw-iconbox-row"
                    data-swiper='{
                "slidesPerView": 1,
                "spaceBetween": 12,
                "speed": 800,
                "preventInteractionOnTransition": false, 
                "touchStartPreventDefault": false,
                "slidesPerGroup": 1,
                "pagination": { "el": ".sw-pagination-iconbox", "clickable": true },
                "breakpoints": {
                    "575": { "slidesPerView": 2, "spaceBetween": 12}, 
                    "768": { "slidesPerView": 3, "spaceBetween": 24},
                    "1200": { "slidesPerView": "auto", "spaceBetween": 59}
                }
            }'>
                    <div class="swiper-wrapper">
                        <div class="swiper-slide">
                            <div class="tf-icon-box style-3 wow fadeInLeft">
                                <div class="box-icon">
                                    <i class="icon icon-shipping"></i>
                                </div>
                                <div class="content">
                                    <div class="title text-uppercase">Free Shipping</div>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="tf-icon-box style-3 wow fadeInLeft">
                                <div class="box-icon">
                                    <i class="icon icon-gift"></i>
                                </div>
                                <div class="content">
                                    <div class="title text-uppercase">Gift Package</div>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="tf-icon-box style-3 wow fadeInLeft">
                                <div class="box-icon">
                                    <i class="icon icon-return"></i>
                                </div>
                                <div class="content">
                                    <div class="title text-uppercase">EASY RETURNS</div>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="tf-icon-box style-3 wow fadeInLeft">
                                <div class="box-icon">
                                    <i class="icon icon-support"></i>
                                </div>
                                <div class="content">
                                    <div class="title text-uppercase">ONE YEAR WARRANTY</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex d-xl-none sw-dot-default sw-pagination-iconbox justify-content-center"></div>

                </div>
            </div>
        </div>
    </div>



    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {

                // ====================== ADD TO CART FROM HOME PAGE ======================
                const addToCartButtons = document.querySelectorAll('[data-add-to-cart]');

                addToCartButtons.forEach(button => {
                    button.addEventListener('click', function(e) {
                        e.preventDefault();

                        const card = this.closest('.card-product');
                        if (!card) return;

                        const productId = card.dataset.productId;
                        const productName = card.querySelector('.name-product')?.textContent.trim() ||
                            'Sản phẩm';

                        let variants = [];
                        try {
                            variants = card.dataset.variants ? JSON.parse(card.dataset.variants) : [];
                        } catch (e) {
                            console.error('Lỗi parse variants:', e);
                            showToast('Dữ liệu sản phẩm không hợp lệ!', 'danger');
                            return;
                        }

                        if (variants.length === 0) {
                            showToast('Sản phẩm này không có biến thể!', 'warning');
                            return;
                        }

                        showVariantModal(productId, productName, variants);
                    });
                });

                // ====================== SHOW VARIANT MODAL (ĐỒNG BỘ VỚI DETAILPRODUCT) ======================
                function showVariantModal(productId, productName, variants) {
                    if (document.getElementById('variantModal')) {
                        document.getElementById('variantModal').remove();
                    }

                    const modalHTML = `
            <div class="modal fade" id="variantModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Chọn phiên bản sản phẩm</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <!-- Ảnh sản phẩm -->
                                <div class="col-md-5 text-center mb-4 mb-md-0">
                                    <img id="modalMainImage" src="" class="img-fluid rounded shadow-sm" 
                                         alt="${productName}" style="max-height: 340px; object-fit: contain;">
                                </div>

                                <!-- Chọn Size, Color, Quantity -->
                                <div class="col-md-7">
                                    <p class="fw-bold fs-5 mb-4">${productName}</p>

                                    <!-- Size -->
                                    <div class="mb-4">
                                        <label class="form-label fw-medium">Kích thước</label>
                                        <div id="sizeOptions" class="d-flex flex-wrap gap-2"></div>
                                    </div>

                                    <!-- Color -->
                                    <div class="mb-4">
                                        <label class="form-label fw-medium">Màu sắc</label>
                                        <div id="colorOptions" class="d-flex flex-wrap gap-3"></div>
                                    </div>

                                    <!-- Tồn kho -->
                                    <div class="mb-4">
                                        <p class="text-avaiable text-sm">
                                            Còn lại: 
                                            <span id="modalStockDisplay" class="fw-medium text-success">0</span>
                                            <span class="text-muted">sản phẩm</span>
                                        </p>
                                    </div>

                                    <!-- Quantity -->
                                    <div>
                                        <label class="form-label fw-medium">Số lượng</label>
                                        <div class="wg-quantity d-inline-flex">
                                            <button type="button" class="btn-quantity minus-btn" id="qtyMinus">-</button>
                                            <input type="text" id="quantityInput" class="quantity-product text-center" value="1" readonly>
                                            <button type="button" class="btn-quantity plus-btn" id="qtyPlus">+</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                            <button type="button" class="tf-btn style-2 fw-6" id="confirmAddToCart">
                                <i class="icon icon-cart"></i> Thêm vào giỏ hàng
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        `;

                    document.body.insertAdjacentHTML('beforeend', modalHTML);

                    const modal = new bootstrap.Modal(document.getElementById('variantModal'));
                    modal.show();

                    let selectedSizeId = null;
                    let selectedColorId = null;

                    // Render Size & Color
                    renderModalOptions(variants);

                    // ====================== RENDER OPTIONS ======================
                    function renderModalOptions(variants) {
                        const sizeContainer = document.getElementById('sizeOptions');
                        const colorContainer = document.getElementById('colorOptions');

                        sizeContainer.innerHTML = '';
                        colorContainer.innerHTML = '';

                        const uniqueSizes = [...new Set(variants.map(v => JSON.stringify({
                            id: v.size_id,
                            name: v.size_name || ''
                        })))].map(s => JSON.parse(s));

                        const uniqueColors = [...new Set(variants.map(v => JSON.stringify({
                            id: v.color_id,
                            name: v.color_name || '',
                            code: v.color_code || '#ccc'
                        })))].map(c => JSON.parse(c));

                        // Render Sizes
                        uniqueSizes.forEach(size => {
                            const hasColor = selectedColorId ?
                                variants.some(v => String(v.size_id) === String(size.id) && String(v
                                    .color_id) === String(selectedColorId)) : true;

                            const isActive = String(size.id) === String(selectedSizeId);

                            const btn = document.createElement('button');
                            btn.type = 'button';
                            btn.className =
                                `btn btn-outline-secondary size-btn px-4 py-2 ${isActive ? 'active' : ''}`;
                            btn.textContent = size.name;
                            btn.dataset.sizeId = size.id;
                            btn.disabled = !hasColor;

                            btn.addEventListener('click', () => {
                                if (btn.disabled) return;

                                selectedSizeId = size.id;

                                // Render lại để cập nhật active
                                renderModalOptions(variants);
                                updateStockAndImage(variants);
                            });

                            sizeContainer.appendChild(btn);
                        });

                        // Render Colors
                        // Click Color
                        // ==================== RENDER COLORS & HIỂN THỊ ẢNH ====================
uniqueColors.forEach(color => {
    const hasSize = selectedSizeId ?
        variants.some(v => String(v.color_id) === String(color.id) && String(v.size_id) === String(selectedSizeId)) : true;

    const isActive = String(color.id) === String(selectedColorId);

    const btn = document.createElement('button');
    btn.type = 'button';
    btn.className = `color-btn rounded-circle border border-2 ${isActive ? 'active' : ''}`;
    btn.style.backgroundColor = color.code;
    btn.style.width = '46px';
    btn.style.height = '46px';
    btn.title = color.name;
    btn.dataset.colorId = color.id;
    btn.disabled = !hasSize;

    if (isActive) {
        btn.style.border = '3px solid #000';
        btn.style.boxShadow = '0 0 0 5px rgba(0,0,0,0.2)';
    }

    btn.addEventListener('click', () => {
        if (btn.disabled) return;

        selectedColorId = color.id;

        // ==================== SỬA ĐƯỜNG DẪN ẢNH - AN TOÀN NHẤT ====================
        const variant = variants.find(v => String(v.color_id) === String(selectedColorId));

        if (variant && variant.images && variant.images.length > 0) {
            let imagePath = variant.images[0].image;

            // Xử lý đường dẫn ảnh an toàn
            if (imagePath) {
                // Nếu đường dẫn đã có http → dùng luôn
                if (imagePath.startsWith('http')) {
                    document.getElementById('modalMainImage').src = imagePath;
                } 
                // Nếu bắt đầu bằng storage/ hoặc /storage/
                else if (imagePath.startsWith('storage/') || imagePath.startsWith('/storage/')) {
                    document.getElementById('modalMainImage').src = '{{ asset('') }}' + imagePath;
                } 
                // Trường hợp còn lại
                else {
                    document.getElementById('modalMainImage').src = '{{ Storage::url('') }}' + imagePath;
                }
            }
        }

        renderModalOptions(variants);
        updateStockAndImage(variants);
    });

    colorContainer.appendChild(btn);
});
                    }

                    // Cập nhật tồn kho
                    function updateStockAndImage(variants) {
                        const stockDisplay = document.getElementById('modalStockDisplay');
                        let stock = 0;

                        if (selectedSizeId && selectedColorId) {
                            const variant = variants.find(v =>
                                String(v.size_id) === String(selectedSizeId) &&
                                String(v.color_id) === String(selectedColorId)
                            );
                            stock = variant ? parseInt(variant.stock || 0) : 0;
                        } else if (selectedSizeId) {
                            stock = variants.filter(v => String(v.size_id) === String(selectedSizeId))
                                .reduce((sum, v) => sum + (parseInt(v.stock) || 0), 0);
                        } else {
                            stock = variants.reduce((sum, v) => sum + (parseInt(v.stock) || 0), 0);
                        }

                        stockDisplay.textContent = stock;
                        stockDisplay.className = stock > 10 ? 'fw-medium text-success' : 'fw-medium text-danger';
                    }

                    // Quantity
                    document.getElementById('qtyMinus').addEventListener('click', () => {
                        const qty = document.getElementById('quantityInput');
                        if (qty.value > 1) qty.value--;
                    });

                    document.getElementById('qtyPlus').addEventListener('click', () => {
                        document.getElementById('quantityInput').value++;
                    });

                    // Confirm Add to Cart
                    document.getElementById('confirmAddToCart').addEventListener('click', function() {
                        if (!selectedSizeId || !selectedColorId) {
                            showToast('Vui lòng chọn kích thước và màu sắc!', 'warning');
                            return;
                        }

                        const selectedVariant = variants.find(v =>
                            String(v.size_id) === String(selectedSizeId) &&
                            String(v.color_id) === String(selectedColorId)
                        );

                        if (!selectedVariant || parseInt(selectedVariant.stock) < 1) {
                            showToast('Sản phẩm này đã hết hàng!', 'danger');
                            return;
                        }

                        const quantity = parseInt(document.getElementById('quantityInput').value);

                        addToCart(selectedVariant.id, quantity);
                        modal.hide();
                    });

                    // Khởi tạo ảnh mặc định
                    if (variants.length > 0 && variants[0]?.images?.length > 0) {
                        document.getElementById('modalMainImage').src = '{{ Storage::url('') }}' + variants[0].images[
                            0].image;
                    }
                }

                // ====================== ADD TO CART API ======================
                function addToCart(variantId, quantity) {
                    fetch("{{ route('cart.add') }}", {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'X-Requested-With': 'XMLHttpRequest'
                            },
                            body: JSON.stringify({
                                product_variant_id: variantId,
                                quantity: quantity
                            })
                        })
                        .then(res => res.json())
                        .then(data => {
                            if (data.success) {
                                showToast('Đã thêm vào giỏ hàng thành công!', 'success');
                            } else {
                                showToast(data.message || 'Thêm thất bại!', 'danger');
                            }
                        })
                        .catch(() => showToast('Lỗi kết nối!', 'danger'));
                }

                // ====================== TOAST ======================
                function showToast(message, type = 'info') {
                    const bg = type === 'success' ? 'bg-success' : 'bg-danger';
                    const toastHTML = `
            <div class="toast align-items-center text-white ${bg} border-0 position-fixed bottom-0 end-0 m-3" role="alert">
                <div class="d-flex">
                    <div class="toast-body">${message}</div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
                </div>
            </div>
        `;

                    let container = document.getElementById('toastContainer');
                    if (!container) {
                        container = document.createElement('div');
                        container.id = 'toastContainer';
                        container.style.cssText = 'position: fixed; bottom: 20px; right: 20px; z-index: 9999;';
                        document.body.appendChild(container);
                    }

                    container.insertAdjacentHTML('beforeend', toastHTML);
                    new bootstrap.Toast(container.lastElementChild, {
                        delay: 2800
                    }).show();
                }
            });
        </script>
    @endpush

    @push('styles')
        <style>
            .image.img-style {
                border-radius: 12px;
                overflow: hidden;
            }

            .image.img-style img {
                transition: transform 0.4s ease;
            }

            .wg-cls:hover .image.img-style img {
                transform: scale(1.08);
            }

            /* ==================== STYLE CHO MODAL ==================== */
            .color-btn.active {
                border: 3px solid #000 !important;
                box-shadow: 0 0 0 5px rgba(0, 0, 0, 0.2) !important;
                transform: scale(1.1);
            }

            .color-btn:hover:not(:disabled) {
                transform: scale(1.08);
                border-color: #000;
            }

            /* Size - In đậm khi chọn */
            .size-btn {
                transition: all 0.3s ease;
                font-weight: 500;
            }

            .size-btn.active {
                background-color: #000 !important;
                color: white !important;
                border-color: #000 !important;
                font-weight: 700 !important;
                /* ← In đậm mạnh */
                box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
            }

            .size-btn:hover:not(:disabled) {
                border-color: #666;
            }
        </style>
    @endpush

@endsection
