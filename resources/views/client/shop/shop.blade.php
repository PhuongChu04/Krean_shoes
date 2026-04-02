@extends('client.layout.layout')

@section('content')
    <!-- Title Page -->
    <section class="tf-page-title">
        <div class="container">
            <div class="box-title text-center">
                <h4 class="title">NÂNG NIU BÀN CHÂN BẠN</h4>
                <div class="breadcrumb-list">
                    <a class="breadcrumb-item" href="index.html">Trang chủ</a>
                    <div class="breadcrumb-item dot"><span></span></div>
                    <a class="breadcrumb-item" href="shop-collection-list.html">Sản phẩm</a>
                    <div class="breadcrumb-item dot"><span></span></div>
                    <div class="breadcrumb-item current">Giày</div>
                </div>
                <p class="desc text-md text-main">Định vị thương hiệu nâng niu bàn chân bạn.</p>
            </div>
        </div>
    </section>
    <!-- /Title Page -->

    <!-- Section Product -->
    <section class="flat-spacing-24">
        <div class="container">
            <div class="tf-shop-control mb1">
                <div class="tf-group-filter">
                    <div class="tf-dropdown-sort" data-bs-toggle="dropdown">
                        <div class="btn-select">
                            <span class="text-sort-value">Bán chạy nhất</span>
                            <span class="icon icon-arr-down"></span>
                        </div>
                        <div class="dropdown-menu">
                            <div class="select-item active" data-sort-value="best-selling">
                                <span class="text-value-item">Bán chạy nhất</span>
                            </div>
                            <div class="select-item" data-sort-value="a-z">
                                <span class="text-value-item">A đến Z</span>
                            </div>
                            <div class="select-item" data-sort-value="z-a">
                                <span class="text-value-item">Z đến A</span>
                            </div>
                            <div class="select-item" data-sort-value="price-low-high">
                                <span class="text-value-item">Giá: Thấp đến Cao</span>
                            </div>
                            <div class="select-item" data-sort-value="price-high-low">
                                <span class="text-value-item">Giá: Cao đến Thấp</span>
                            </div>
                        </div>
                    </div>
                </div>
                <ul class="tf-control-layout">
                    <li class="tf-view-layout-switch sw-layout-list list-layout" data-value-layout="list">
                        <div class="item icon-list">
                            <span></span>
                            <span></span>
                        </div>
                    </li>
                    <li class="tf-view-layout-switch sw-layout-2" data-value-layout="tf-col-2">
                        <div class="item icon-grid-2">
                            <span></span>
                            <span></span>
                        </div>
                    </li>
                    <li class="tf-view-layout-switch sw-layout-3" data-value-layout="tf-col-3">
                        <div class="item icon-grid-3">
                            <span></span>
                            <span></span>
                            <span></span>
                        </div>
                    </li>
                    <li class="tf-view-layout-switch sw-layout-4 active" data-value-layout="tf-col-4">
                        <div class="item icon-grid-4">
                            <span></span>
                            <span></span>
                            <span></span>
                            <span></span>
                        </div>
                    </li>

                </ul>
            </div>
            <div class="tf-filter-dropdown">
                <span class="title-filter">Lọc:</span>
                <div class="meta-dropdown-filter">
                    <div class="dropdown dropdown-filter">
                        <div class="dropdown-toggle" id="availability" data-bs-toggle="dropdown" aria-expanded="false"
                            data-bs-auto-close="outside">
                            <span class="text-value">Tình trạng kho</span>
                            <span class="icon icon-arr-down"></span>
                        </div>
                        <div class="dropdown-menu" aria-labelledby="availability">
                            <ul class="filter-group-check">
                                <li class="list-item">
                                    <input type="radio" name="availability" class="tf-check" id="inStock">
                                    <label for="inStock" class="label"><span>Còn hàng</span>&nbsp;<span
                                            class="count">({{ $inStockCount }})</span></label>
                                </li>
                                <li class="list-item">
                                    <input type="radio" name="availability" class="tf-check" id="outStock">
                                    <label for="outStock" class="label"><span>Hết hàng</span>&nbsp;<span
                                            class="count">({{ $outOfStockCount }})</span></label>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="dropdown dropdown-filter">
                        <div class="dropdown-toggle" id="price" data-bs-toggle="dropdown" aria-expanded="false"
                            data-bs-auto-close="outside">
                            <span class="text-value">Giá</span>
                            <span class="icon icon-arr-down"></span>
                        </div>
                        <div class="dropdown-menu" aria-labelledby="price">
                            <div class="widget-price filter-price">
                                <div class="price-val-range" id="price-value-range" data-min="0" data-max="500">
                                </div>
                                <div class="box-value-price">
                                    <span class="text-sm">Giá:</span>
                                    <div class="price-box">
                                        <div class="price-val" id="price-min-value" data-currency="₫"></div>
                                        <span>-</span>
                                        <div class="price-val" id="price-max-value" data-currency="₫"></div>
                                    </div>
                                </div>
                                <span class="reset-price">Đặt lại</span>
                            </div>
                        </div>
                    </div>
                    <div class="dropdown dropdown-filter">
                        <div class="dropdown-toggle" id="color" data-bs-toggle="dropdown" aria-expanded="false"
                            data-bs-auto-close="outside">
                            <span class="text-value">Màu sắc</span>
                            <span class="icon icon-arr-down"></span>
                        </div>
                        <div class="dropdown-menu" aria-labelledby="color">
                            <div class="filter-color-box flat-check-list">
                                @foreach ($colors as $color)
                                    <div class="check-item color-item color-check" data-color-id="{{ $color->id }}"
                                        data-color-name="{{ $color->name }}">
                                        <span class="color" style="background-color: {{ $color->code }}"></span>
                                        <span class="color-text">{{ $color->name }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="dropdown dropdown-filter">
                        <div class="dropdown-toggle" id="size" data-bs-toggle="dropdown" aria-expanded="false"
                            data-bs-auto-close="outside">
                            <span class="text-value">Kích cỡ</span>
                            <span class="icon icon-arr-down"></span>
                        </div>
                        <div class="dropdown-menu" aria-labelledby="size">
                            <div class="filter-size-box flat-check-list">
                                @foreach ($sizes as $size)
                                    <div class="check-item size-item size-check" data-size-id="{{ $size->id }}">
                                        <span class="size">{{ $size->name }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="dropdown dropdown-filter">
                        <div class="dropdown-toggle" id="brand" data-bs-toggle="dropdown" aria-expanded="false"
                            data-bs-auto-close="outside">
                            <span class="text-value">Thương hiệu</span>
                            <span class="icon icon-arr-down"></span>
                        </div>
                        <div class="dropdown-menu" aria-labelledby="brand">
                            <ul class="filter-group-check">
                                @foreach ($brands as $brand)
                                    <li class="list-item">
                                        <input type="radio" name="brand" class="tf-check"
                                            id="brand-{{ $brand->id }}">
                                        <label for="brand-{{ $brand->id }}" class="label">
                                            <span>{{ $brand->name }}</span>&nbsp;
                                            <span class="count">({{ $brand->products->count() }})</span>
                                        </label>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>

                </div>

            </div>
            <div class="wrapper-control-shop">
                <div class="meta-filter-shop">
                    <div id="product-count-grid" class="count-text"></div>
                    <div id="product-count-list" class="count-text"></div>
                    <div id="applied-filters"></div>
                    <button id="remove-all" class="remove-all-filters" style="display: none;"><i
                            class="icon icon-close"></i> Xóa tất cả bộ lọc</button>
                </div>
                <div class="tf-list-layout wrapper-shop" id="listLayout" style="display: none;">
                    <!-- Card Product 1 -->
                    <div class="card-product style-list" data-availability="In stock" data-brand="Vineta">
                        <div class="card-product-wrapper">
                            <a href="product-detail.html" class="product-img">
                                <img class="img-product lazyload" data-src="client/images/products/fashion/product-16.jpg"
                                    src="client/images/products/fashion/product-16.jpg" alt="image-product">
                                <img class="img-hover lazyload" data-src="client/images/products/fashion/product-9.jpg"
                                    src="client/images/products/fashion/product-9.jpg" alt="image-product">
                            </a>
                            <div class="on-sale-wrap"><span class="on-sale-item">20% Off</span></div>
                        </div>
                        <div class="card-product-info">
                            <div class="info-list">
                                <a href="product-detail.html" class="name-product link fw-medium text-md">Graphic
                                    Printed Pure Cotton T-shirt</a>
                                <p class="price-wrap fw-medium text-md">
                                    <span class="price-new">$50.00</span>
                                    <span class="price-old">$70.00</span>
                                </p>
                                <p class="desc text-sm text-main text-line-clamp-2">
                                    Product Specifications Care for fiber: 30% more recycled polyester. We label
                                    garments
                                    manufactured using environmentally friendly technologies and raw materials with
                                    the
                                    Join
                                    Life label.
                                </p>
                                <ul class="list-color-product">
                                    <li class="list-color-item color-swatch hover-tooltip active">
                                        <span class="tooltip color-filter">Yellow</span>
                                        <span class="swatch-value bg-light-orange-2"></span>
                                        <img class="lazyload" data-src="client/images/products/fashion/product-16.jpg"
                                            src="client/images/products/fashion/product-16.jpg" alt="image-product">
                                    </li>
                                    <li class="list-color-item color-swatch hover-tooltip">
                                        <span class="tooltip color-filter">Black</span>
                                        <span class="swatch-value bg-dark"></span>
                                        <img class=" lazyload" data-src="client/images/products/fashion/product-9.jpg"
                                            src="client/images/products/fashion/product-9.jpg" alt="image-product">
                                    </li>
                                    <li class="list-color-item color-swatch hover-tooltip">
                                        <span class="tooltip color-filter">Grey</span>
                                        <span class="swatch-value bg-grey-4"></span>
                                        <img class=" lazyload" data-src="client/images/products/fashion/product-4.jpg"
                                            src="client/images/products/fashion/product-7.jpg" alt="image-product">
                                    </li>
                                </ul>
                                <ul class="size-box">
                                    <li class="size-item text-xs">S</li>
                                    <li class="size-item text-xs">M</li>
                                    <li class="size-item text-xs">L</li>
                                    <li class="size-item text-xs">XL</li>
                                </ul>
                            </div>
                            <div class="list-product-btn">
                                <a href="#shoppingCart" data-bs-toggle="offcanvas"
                                    class="tf-btn btn-main-product add-to-cart animate-btn">Add
                                    To
                                    cart</a>
                                <a href="javascript:void(0);" class="box-icon wishlist hover-tooltip">
                                    <span class="icon icon-heart2"></span>
                                    <span class="tooltip">Add to Wishlist</span>
                                </a>
                                <a href="#quickView" data-bs-toggle="modal" class="box-icon hover-tooltip quickview">
                                    <span class="icon icon-view"></span>
                                    <span class="tooltip">Quick View</span>
                                </a>
                                <a href="#compare" data-bs-toggle="modal" aria-controls="compare"
                                    class="box-icon compare hover-tooltip">
                                    <span class="icon icon-compare"></span>
                                    <span class="tooltip">Add to Compare</span>
                                </a>
                            </div>

                        </div>
                    </div>
                    <!-- Card Product 2 -->
                    <div class="card-product style-list" data-availability="In stock" data-brand="Vineta">
                        <div class="card-product-wrapper">
                            <a href="product-detail.html" class="product-img">
                                <img class="img-product lazyload" data-src="client/images/products/fashion/product-17.jpg"
                                    src="client/images/products/fashion/product-17.jpg" alt="image-product">
                                <img class="img-hover lazyload" data-src="client/images/products/fashion/product-19.jpg"
                                    src="client/images/products/fashion/product-19.jpg" alt="image-product">
                            </a>
                        </div>
                        <div class="card-product-info">
                            <div class="info-list">
                                <a href="product-detail.html" class="name-product link fw-medium text-md">Graphic
                                    Printed Drop Shoulder Sleeves</a>
                                <p class="price-wrap fw-medium text-md">
                                    <span class="price-new">$80.00</span>
                                </p>
                                <p class="desc text-sm text-main text-line-clamp-2">
                                    Product Specifications Care for fiber: 30% more recycled polyester. We label
                                    garments
                                    manufactured using environmentally friendly technologies and raw materials with
                                    the
                                    Join
                                    Life label.
                                </p>
                                <ul class="list-color-product">
                                    <li class="list-color-item color-swatch hover-tooltip line active">
                                        <span class="tooltip color-filter">White</span>
                                        <span class="swatch-value bg-white"></span>
                                        <img class="lazyload" data-src="client/images/products/fashion/product-17.jpg"
                                            src="client/images/products/fashion/product-17.jpg" alt="image-product">
                                    </li>
                                    <li class="list-color-item color-swatch hover-tooltip">
                                        <span class="tooltip color-filter">Dark Green</span>
                                        <span class="swatch-value bg-dark-green"></span>
                                        <img class=" lazyload" data-src="client/images/products/fashion/product-21.jpg"
                                            src="client/images/products/fashion/product-21.jpg" alt="image-product">
                                    </li>
                                    <li class="list-color-item color-swatch hover-tooltip">
                                        <span class="tooltip color-filter">Grey</span>
                                        <span class="swatch-value bg-grey-4"></span>
                                        <img class="lazyload" data-src="client/images/products/fashion/product-19.jpg"
                                            src="client/images/products/fashion/product-19.jpg" alt="image-product">
                                    </li>
                                </ul>
                                <ul class="size-box">
                                    <li class="size-item text-xs">S</li>
                                    <li class="size-item text-xs">M</li>
                                    <li class="size-item text-xs">L</li>
                                    <li class="size-item text-xs">XL</li>
                                </ul>
                            </div>
                            <div class="list-product-btn">
                                <a href="#shoppingCart" data-bs-toggle="offcanvas"
                                    class="tf-btn btn-main-product add-to-cart animate-btn">Add
                                    To
                                    cart</a>
                                <a href="javascript:void(0);" class="box-icon wishlist hover-tooltip">
                                    <span class="icon icon-heart2"></span>
                                    <span class="tooltip">Add to Wishlist</span>
                                </a>
                                <a href="#quickView" data-bs-toggle="modal" class="box-icon hover-tooltip quickview">
                                    <span class="icon icon-view"></span>
                                    <span class="tooltip">Quick View</span>
                                </a>
                                <a href="#compare" data-bs-toggle="modal" aria-controls="compare"
                                    class="box-icon compare hover-tooltip">
                                    <span class="icon icon-compare"></span>
                                    <span class="tooltip">Add to Compare</span>
                                </a>
                            </div>

                        </div>
                    </div>
                    <!-- Card Product 3 -->
                    <div class="card-product style-list" data-availability="In stock" data-brand="Vineta">
                        <div class="card-product-wrapper">
                            <a href="product-detail.html" class="product-img">
                                <img class="img-product lazyload"
                                    data-src="client/images/products/fashion/women-grey-2.jpg"
                                    src="client/images/products/fashion/women-grey-2.jpg" alt="image-product">
                                <img class="img-hover lazyload" data-src="client/images/products/fashion/women-grey-1.jpg"
                                    src="client/images/products/fashion/women-grey-1.jpg" alt="image-product">
                            </a>
                            <div class="on-sale-wrap"><span class="on-sale-item">10% Off</span></div>
                        </div>
                        <div class="card-product-info">
                            <div class="info-list">
                                <a href="product-detail.html" class="name-product link fw-medium text-md">Women
                                    Solid Scoop Neck Slim Fit T-shirt</a>
                                <p class="price-wrap fw-medium text-md">
                                    <span class="price-new">$80.00</span>
                                    <span class="price-old">$90.00</span>
                                </p>
                                <p class="desc text-sm text-main text-line-clamp-2">
                                    Product Specifications Care for fiber: 30% more recycled polyester. We label
                                    garments
                                    manufactured using environmentally friendly technologies and raw materials with
                                    the
                                    Join
                                    Life label.
                                </p>
                                <ul class="list-color-product">
                                    <li class="list-color-item color-swatch hover-tooltip active">
                                        <span class="tooltip color-filter">Grey</span>
                                        <span class="swatch-value bg-grey-4"></span>
                                        <img class="lazyload" data-src="client/images/products/fashion/women-grey-2.jpg"
                                            src="client/images/products/fashion/women-grey-2.jpg" alt="image-product">
                                    </li>
                                    <li class="list-color-item color-swatch hover-tooltip">
                                        <span class="tooltip color-filter">Yellow</span>
                                        <span class="swatch-value bg-yellow"></span>
                                        <img class="lazyload" data-src="client/images/products/fashion/women-yellow-2.jpg"
                                            src="client/images/products/fashion/women-yellow-2.jpg" alt="image-product">
                                    </li>
                                    <li class="list-color-item color-swatch hover-tooltip">
                                        <span class="tooltip color-filter">Light Grey</span>
                                        <span class="swatch-value bg-light-blue-2"></span>
                                        <img class="lazyload"
                                            data-src="client/images/products/fashion/women-light-blue-1.jpg"
                                            src="client/images/products/fashion/women-light-blue-1.jpg"
                                            alt="image-product">
                                    </li>
                                </ul>
                            </div>
                            <div class="list-product-btn">
                                <a href="#shoppingCart" data-bs-toggle="offcanvas"
                                    class="tf-btn btn-main-product add-to-cart animate-btn">Add
                                    To
                                    cart</a>
                                <a href="javascript:void(0);" class="box-icon wishlist hover-tooltip">
                                    <span class="icon icon-heart2"></span>
                                    <span class="tooltip">Add to Wishlist</span>
                                </a>
                                <a href="#quickView" data-bs-toggle="modal" class="box-icon hover-tooltip quickview">
                                    <span class="icon icon-view"></span>
                                    <span class="tooltip">Quick View</span>
                                </a>
                                <a href="#compare" data-bs-toggle="modal" aria-controls="compare"
                                    class="box-icon compare hover-tooltip">
                                    <span class="icon icon-compare"></span>
                                    <span class="tooltip">Add to Compare</span>
                                </a>
                            </div>

                        </div>
                    </div>
                    <!-- Card Product 4 -->
                    <div class="card-product style-list" data-availability="Out of stock" data-brand="Zotac">
                        <div class="card-product-wrapper">
                            <a href="product-detail.html" class="product-img">
                                <img class="img-product lazyload" data-src="client/images/products/fashion/product-18.jpg"
                                    src="client/images/products/fashion/product-18.jpg" alt="image-product">
                                <img class="img-hover lazyload" data-src="client/images/products/fashion/product-12.jpg"
                                    src="client/images/products/fashion/product-12.jpg" alt="image-product">
                            </a>
                        </div>
                        <div class="card-product-info">
                            <div class="info-list">
                                <a href="product-detail.html" class="name-product link fw-medium text-md">Asymmetric
                                    Neck Tank Top</a>
                                <p class="price-wrap fw-medium text-md">
                                    <span class="price-new">$85.00</span>
                                </p>
                                <p class="desc text-sm text-main text-line-clamp-2">
                                    Product Specifications Care for fiber: 30% more recycled polyester. We label
                                    garments
                                    manufactured using environmentally friendly technologies and raw materials with
                                    the
                                    Join
                                    Life label.
                                </p>
                                <ul class="list-color-product">
                                    <li class="list-color-item color-swatch hover-tooltip active">
                                        <span class="tooltip color-filter">Light Orange</span>
                                        <span class="swatch-value bg-light-orange"></span>
                                        <img class="lazyload" data-src="client/images/products/fashion/product-18.jpg"
                                            src="client/images/products/fashion/product-18.jpg" alt="image-product">
                                    </li>
                                    <li class="list-color-item color-swatch hover-tooltip">
                                        <span class="tooltip color-filter">Black</span>
                                        <span class="swatch-value bg-dark"></span>
                                        <img class="lazyload" data-src="client/images/products/fashion/women-black-6.jpg"
                                            src="client/images/products/fashion/women-black-6.jpg" alt="image-product">
                                    </li>

                                </ul>
                                <ul class="size-box">
                                    <li class="size-item text-xs">S</li>
                                    <li class="size-item text-xs">M</li>
                                    <li class="size-item text-xs">L</li>
                                    <li class="size-item text-xs">XL</li>
                                </ul>
                            </div>
                            <div class="list-product-btn">
                                <a href="#shoppingCart" data-bs-toggle="offcanvas"
                                    class="tf-btn btn-main-product animate-btn add-to-cart">Add
                                    To
                                    cart</a>
                                <a href="javascript:void(0);" class="box-icon wishlist hover-tooltip">
                                    <span class="icon icon-heart2"></span>
                                    <span class="tooltip">Add to Wishlist</span>
                                </a>
                                <a href="#quickView" data-bs-toggle="modal" class="box-icon hover-tooltip quickview">
                                    <span class="icon icon-view"></span>
                                    <span class="tooltip">Quick View</span>
                                </a>
                                <a href="#compare" data-bs-toggle="modal" aria-controls="compare"
                                    class="box-icon compare hover-tooltip">
                                    <span class="icon icon-compare"></span>
                                    <span class="tooltip">Add to Compare</span>
                                </a>
                            </div>

                        </div>
                    </div>
                    <!-- Card Product 5 -->
                    <div class="card-product style-list" data-availability="Out of stock" data-brand="Zotac">
                        <div class="card-product-wrapper">
                            <a href="product-detail.html" class="product-img">
                                <img class="img-product lazyload" data-src="client/images/products/fashion/product-15.jpg"
                                    src="client/images/products/fashion/product-15.jpg" alt="image-product">
                                <img class="img-hover lazyload" data-src="client/images/products/fashion/product-1.jpg"
                                    src="client/images/products/fashion/product-1.jpg" alt="image-product">
                            </a>
                        </div>
                        <div class="card-product-info">
                            <div class="info-list">
                                <a href="product-detail.html" class="name-product link fw-medium text-md">Short
                                    Sleeve Sweat</a>
                                <p class="price-wrap fw-medium text-md">
                                    <span class="price-new">$55.00</span>
                                </p>
                                <p class="desc text-sm text-main text-line-clamp-2">
                                    Product Specifications Care for fiber: 30% more recycled polyester. We label
                                    garments
                                    manufactured using environmentally friendly technologies and raw materials with
                                    the
                                    Join
                                    Life label.
                                </p>
                                <ul class="list-color-product">
                                    <li class="list-color-item color-swatch hover-tooltip active">
                                        <span class="tooltip color-filter">Light Pink</span>
                                        <span class="swatch-value bg-light-pink-4"></span>
                                        <img class="lazyload" data-src="client/images/products/fashion/product-15.jpg"
                                            src="client/images/products/fashion/product-15.jpg" alt="image-product">
                                    </li>
                                    <li class="list-color-item color-swatch hover-tooltip line">
                                        <span class="tooltip color-filter">White</span>
                                        <span class="swatch-value bg-white"></span>
                                        <img class="lazyload" data-src="client/images/products/fashion/product-1.jpg"
                                            src="client/images/products/fashion/product-1.jpg" alt="image-product">
                                    </li>
                                    <li class="list-color-item color-swatch hover-tooltip">
                                        <span class="tooltip color-filter">Light Grey</span>
                                        <span class="swatch-value bg-grey-4"></span>
                                        <img class="lazyload" data-src="client/images/products/fashion/product-19.jpg"
                                            src="client/images/products/fashion/product-19.jpg" alt="image-product">
                                    </li>
                                </ul>
                            </div>
                            <div class="list-product-btn">
                                <a href="#shoppingCart" data-bs-toggle="offcanvas"
                                    class="tf-btn btn-main-product add-to-cart animate-btn">Add
                                    To
                                    cart</a>
                                <a href="javascript:void(0);" class="box-icon wishlist hover-tooltip">
                                    <span class="icon icon-heart2"></span>
                                    <span class="tooltip">Add to Wishlist</span>
                                </a>
                                <a href="#quickView" data-bs-toggle="modal" class="box-icon hover-tooltip quickview">
                                    <span class="icon icon-view"></span>
                                    <span class="tooltip">Quick View</span>
                                </a>
                                <a href="#compare" data-bs-toggle="modal" aria-controls="compare"
                                    class="box-icon compare hover-tooltip">
                                    <span class="icon icon-compare"></span>
                                    <span class="tooltip">Add to Compare</span>
                                </a>
                            </div>

                        </div>
                    </div>
                    <!-- Pagination -->
                    <ul class="wg-pagination">
                        <li class="active">
                            <div class="pagination-item">1</div>
                        </li>
                        <li>
                            <a href="#" class="pagination-item">2</a>
                        </li>
                        <li>
                            <a href="#" class="pagination-item">3</a>
                        </li>
                        <li>
                            <a href="#" class="pagination-item"><i class="icon-arr-right2"></i></a>
                        </li>
                    </ul>
                </div>
                <div class="wrapper-shop tf-grid-layout tf-col-4" id="gridLayout">
                    <!-- Card Product 1 -->
                    @foreach ($products as $product)
                        <div class="card-product grid card-product-size"
                            data-availability="{{ $product->status == 1 ? 'In stock' : 'Out of stock' }}"
                            data-brand="Vineta"
                            data-product-id="{{ $product->id }}"
                            data-variants="{{ json_encode($product->variants->map(function($v) { return ['id' => $v->id, 'size_id' => $v->size_id, 'size_name' => $v->size?->name, 'color_id' => $v->color_id, 'color_name' => $v->color?->name, 'color_code' => $v->color?->code, 'price' => $v->price, 'stock' => $v->stock]; })->values()) }}">
                            <div class="card-product-wrapper">
                                <a href="product-detail.html" class="product-img">
                                    <img class="img-product lazyload"
                                        data-src="{{ asset('storage/' . $product->thumbnail) }}"
                                        src="{{ asset('storage/' . $product->thumbnail) }}" alt="image-product">
                                    <img class="img-hover lazyload"
                                        data-src="{{ asset('storage/' . $product->thumbnail) }}"
                                        src="{{ asset('storage/' . $product->thumbnail) }}" alt="image-product">
                                </a>
                                <div class="on-sale-wrap"><span class="on-sale-item">20% Off</span></div>
                                <ul class="list-product-btn">
                                    <li>
                                        <a href="javascript:void(0);" data-add-to-cart
                                            class="hover-tooltip tooltip-left box-icon">
                                            <span class="icon icon-cart2"></span>
                                            <span class="tooltip">Thêm vào giỏ hàng</span>
                                        </a>
                                    </li>
                                    <li class="wishlist">
                                        <a href="javascript:void(0);" class="hover-tooltip tooltip-left box-icon">
                                            <span class="icon icon-heart2"></span>
                                            <span class="tooltip">Thêm vào danh sách yêu thích</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#quickView" data-bs-toggle="modal"
                                            class="hover-tooltip tooltip-left box-icon quickview">
                                            <span class="icon icon-view"></span>
                                            <span class="tooltip">Xem nhanh</span>
                                        </a>
                                    </li>
                                    <li class="compare">
                                        <a href="#compare" data-bs-toggle="modal" aria-controls="compare"
                                            class="hover-tooltip tooltip-left box-icon">
                                            <span class="icon icon-compare"></span>
                                            <span class="tooltip">Add to Compare</span>
                                        </a>
                                    </li>
                                </ul>
                                <ul class="size-box">
                                    @foreach ($product->variants->unique('size_id') as $variant)
                                        <li class="size-item text-xs text-white">
    {{ $variant->size?->name }}
</li>
                                    @endforeach
                                </ul>

                            </div>
                            <div class="card-product-info">
                                <a href="{{ route('client.product.detail', $product->slug ?? $product->id) }}"
                                    class="name-product link fw-medium text-md">{{ $product->name }}</a>
                                <p class="price-wrap fw-medium">
                                    <span class="price-new">{{ number_format($product->variants->min('price')) }}
                                        VND</span>
                                    {{-- <span class="price-old">$150.00</span> --}}
                                </p>
                                <ul class="list-color-product">
                                    @foreach ($product->variants->unique('color_id') as $variant)
                                        <li class="list-color-item hover-tooltip tooltip-bot color-swatch active">
                                            <span class="tooltip color-filter">{{ $variant->color->name }}</span>
                                            <span class="swatch-value"
                                                style="background-color: {{ $variant->color->code }}"></span>
                                            <img class=" lazyload"
                                                data-src="{{ asset('storage/' . $product->thumbnail) }}"
                                                src="{{ asset('storage/' . $product->thumbnail) }}" alt="image-product">
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endforeach
                    <!-- Pagination -->
                    <ul class="wg-pagination">
                        <li class="active">
                            <div class="pagination-item">1</div>
                        </li>
                        <li>
                            <a href="#" class="pagination-item">2</a>
                        </li>
                        <li>
                            <a href="#" class="pagination-item">3</a>
                        </li>
                        <li>
                            <a href="#" class="pagination-item"><i class="icon-arr-right2"></i></a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
    <!-- /Section Product -->
    <div class="flat-spacing-5 line-top flat-wrap-iconbox">
        <div class="container">
            <div dir="ltr" class="swiper tf-swiper wow fadeInUp"
                data-swiper='{
                    "slidesPerView": 1,
                    "spaceBetween": 12,
                    "speed": 800,
                    "preventInteractionOnTransition": false, 
                    "touchStartPreventDefault": false,
                    "pagination": { "el": ".sw-pagination-iconbox", "clickable": true },
                    "breakpoints": {
                        "575": { "slidesPerView": 2, "spaceBetween": 24}, 
                        "768": { "slidesPerView": 3, "spaceBetween": 24},
                        "1200": { "slidesPerView": 3, "spaceBetween": 100},
                        "1440": { "slidesPerView": 3, "spaceBetween": 205}
                    }
                }'>
                <div class="swiper-wrapper">
                    <div class="swiper-slide">
                        <div class="tf-icon-box style-2">
                            <svg width="48" height="48" viewBox="0 0 48 48" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M38.9421 14.922L24.328 6.48452C24.2283 6.42685 24.1151 6.39648 23.9999 6.39648C23.8847 6.39648 23.7715 6.42685 23.6717 6.48452L9.05762 14.922C8.95781 14.9795 8.87492 15.0623 8.81731 15.1621C8.75971 15.2618 8.72941 15.375 8.72949 15.4901V32.3651C8.72946 32.4804 8.75977 32.5936 8.81737 32.6934C8.87497 32.7932 8.95783 32.876 9.05762 32.9336L23.6717 41.3711C23.7715 41.4286 23.8847 41.4589 23.9999 41.4589C24.115 41.4589 24.2282 41.4286 24.328 41.3711L38.9421 32.9336C39.0419 32.876 39.1248 32.7932 39.1824 32.6934C39.24 32.5936 39.2703 32.4804 39.2702 32.3651V15.4901C39.2703 15.375 39.24 15.2618 39.1824 15.1621C39.1248 15.0623 39.0419 14.9795 38.9421 14.922ZM23.9999 7.81052L37.3015 15.4901L23.9999 23.1698L10.6982 15.4901L23.9999 7.81052ZM10.042 16.6268L23.3436 24.3064V39.666L10.042 31.9875V16.6268ZM37.9577 31.9875L24.6561 39.666V24.3064L37.9577 16.6268V31.9875Z"
                                    fill="#ABABAB" />
                            </svg>
                            <div class="content">
                                <div class="title">Giao hàng miễn phí</div>
                                <p class="desc text-grey-2">Miễn phí giao hàng cho đơn hàng trên 5 triệu đồng</p>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="tf-icon-box style-2">
                            <svg width="48" height="48" viewBox="0 0 48 48" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M24.3943 15.1144C24.3216 15.0724 24.239 15.0503 24.155 15.0503C24.071 15.0503 23.9885 15.0724 23.9158 15.1144L16.6187 19.3274C16.5459 19.3694 16.4855 19.4298 16.4435 19.5025C16.4015 19.5753 16.3794 19.6578 16.3794 19.7418V28.1677C16.3794 28.2517 16.4015 28.3342 16.4435 28.407C16.4855 28.4797 16.5459 28.5401 16.6187 28.5821L23.9158 32.7952C23.9885 32.8372 24.071 32.8593 24.155 32.8593C24.239 32.8593 24.3216 32.8372 24.3943 32.7952L31.6915 28.5821C31.7642 28.5401 31.8246 28.4797 31.8666 28.407C31.9086 28.3342 31.9307 28.2517 31.9307 28.1677V19.7418C31.9307 19.6578 31.9086 19.5753 31.8666 19.5025C31.8246 19.4298 31.7642 19.3694 31.6915 19.3274L24.3943 15.1144ZM24.155 16.0813L30.4951 19.7418L24.155 23.4022L17.815 19.7418L24.155 16.0813ZM17.3365 20.5706L23.6765 24.231V31.5523L17.3365 27.8918V20.5706ZM24.6336 31.5519V24.2306L30.9737 20.5702V27.8915L24.6336 31.5519ZM8.18376 25.8952C8.19119 25.9576 8.18624 26.0209 8.1692 26.0815C8.15215 26.142 8.12334 26.1986 8.08442 26.2479C8.04549 26.2973 7.99722 26.3386 7.94235 26.3693C7.88748 26.4 7.8271 26.4196 7.76465 26.427C7.74577 26.4292 7.72678 26.4304 7.70777 26.4304C7.59071 26.4302 7.47776 26.3872 7.39031 26.3093C7.30286 26.2315 7.24697 26.1243 7.23322 26.0081C7.15459 25.3417 7.11519 24.6712 7.11523 24.0002C7.11592 21.0265 7.90177 18.1056 9.39334 15.533C10.8849 12.9604 13.0293 10.8272 15.6097 9.34915C18.1901 7.87109 21.115 7.10055 24.0887 7.11545C27.0624 7.13034 29.9795 7.93015 32.5449 9.43399C34.624 10.6583 36.4184 12.3116 37.8086 14.2836L37.7701 8.77077C37.7697 8.70793 37.7816 8.64561 37.8052 8.58738C37.8289 8.52916 37.8637 8.47615 37.9078 8.4314C37.9969 8.34102 38.1183 8.28974 38.2452 8.28883C38.3721 8.28793 38.4942 8.33747 38.5846 8.42657C38.6749 8.51567 38.7262 8.63702 38.7271 8.76393L38.7772 15.9456C38.7777 16.0087 38.7656 16.0713 38.7418 16.1297C38.7179 16.1882 38.6828 16.2413 38.6383 16.2861C38.5938 16.3309 38.5409 16.3664 38.4826 16.3907C38.4244 16.4149 38.3619 16.4274 38.2987 16.4274C38.2942 16.4274 38.2895 16.4274 38.2851 16.4274L31.6136 16.235C31.5505 16.2336 31.4883 16.2197 31.4306 16.1942C31.3729 16.1687 31.3208 16.132 31.2774 16.0863C31.2339 16.0405 31.1999 15.9866 31.1773 15.9277C31.1548 15.8688 31.1441 15.806 31.1459 15.7429C31.1477 15.6799 31.162 15.6178 31.1879 15.5602C31.2137 15.5027 31.2508 15.4508 31.2968 15.4077C31.3428 15.3645 31.3969 15.3308 31.4559 15.3086C31.515 15.2865 31.5779 15.2762 31.6409 15.2784L37.4378 15.4456C35.9942 13.19 34.0074 11.3329 31.6595 10.0447C29.3117 8.75649 26.678 8.07835 24 8.07247C15.2174 8.07247 8.07227 15.2176 8.07227 24.0002C8.0723 24.6335 8.10953 25.2663 8.18376 25.8952ZM40.8848 24.0002C40.8838 26.9002 40.1361 29.751 38.7138 32.2783C37.2915 34.8055 35.2425 36.924 32.7641 38.4297C30.2857 39.9355 27.4613 40.7777 24.563 40.8754C21.6647 40.973 18.79 40.3228 16.2158 38.9874C14.2573 37.9639 12.5166 36.569 11.0908 34.8806L10.8796 39.7981C10.8744 39.9212 10.8217 40.0376 10.7327 40.123C10.6437 40.2083 10.5252 40.256 10.402 40.2561C10.3951 40.2561 10.3883 40.2561 10.381 40.2556C10.2542 40.2501 10.1348 40.1945 10.049 40.101C9.9632 40.0075 9.91806 39.8838 9.92351 39.757L10.1901 33.5439C10.1951 33.4201 10.248 33.3031 10.3376 33.2177C10.4273 33.1322 10.5466 33.0849 10.6705 33.0859L17.54 33.1193C17.6029 33.1195 17.6651 33.132 17.7231 33.1562C17.7811 33.1804 17.8337 33.2158 17.8781 33.2603C17.9224 33.3048 17.9575 33.3577 17.9814 33.4158C18.0053 33.4739 18.0176 33.5362 18.0174 33.599C18.0173 33.6618 18.0048 33.724 17.9806 33.782C17.9564 33.84 17.921 33.8927 17.8765 33.937C17.8319 33.9814 17.7791 34.0165 17.721 34.0404C17.6629 34.0643 17.6006 34.0765 17.5378 34.0764H17.5355L11.6419 34.0479C13.1384 35.8813 15.0231 37.3598 17.1602 38.3766C19.2973 39.3934 21.6334 39.9233 24 39.9279C32.7826 39.9279 39.9277 32.7828 39.9277 24.0002C39.9277 23.8733 39.9781 23.7516 40.0679 23.6618C40.1576 23.5721 40.2793 23.5217 40.4062 23.5217C40.5332 23.5217 40.6549 23.5721 40.7446 23.6618C40.8344 23.7516 40.8848 23.8733 40.8848 24.0002Z"
                                    fill="#ABABAB" />
                            </svg>
                            <div class="content">
                                <div class="title">Đổi trả dễ dàng</div>
                                <p class="desc text-grey-2">Đổi trả không phiền phức để mua sắm yên tâm.</p>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="tf-icon-box style-2">
                            <svg width="48" height="48" viewBox="0 0 48 48" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M18.2486 37.718C18.2484 38.0955 18.5544 38.4017 18.932 38.4017C19.0615 38.4018 19.1884 38.365 19.2978 38.2957L29.2659 31.9856H38.0487C39.9538 31.9836 41.4977 30.4398 41.4999 28.5346V13.0492C41.4977 11.1441 39.9538 9.60027 38.0487 9.59814H9.95096C8.04595 9.60034 6.50213 11.1442 6.5 13.0492V28.5345C6.5022 30.4395 8.04595 31.9833 9.95096 31.9855H18.2498L18.2486 37.718ZM9.95096 30.6184C8.80064 30.6171 7.86847 29.6849 7.86719 28.5346V13.0492C7.86854 11.8989 8.80064 10.9667 9.95096 10.9654H38.0487C39.1991 10.9667 40.1313 11.8988 40.1327 13.0492V28.5345C40.1314 29.6848 39.1993 30.617 38.049 30.6183H29.0678C28.9384 30.6183 28.8115 30.6551 28.7021 30.7243L19.6162 36.476L19.6176 31.3021C19.6176 30.9247 19.3115 30.6186 18.934 30.6186L9.95096 30.6184Z"
                                    fill="#ABABAB" />
                            </svg>
                            <div class="content">
                                <div class="title">Hỗ trợ 24/7</div>
                                <p class="desc text-grey-2">Chúng tôi luôn sẵn sàng hỗ trợ bạn 24/7.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="d-flex d-xl-none sw-dot-default sw-pagination-iconbox justify-content-center"></div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <link rel="stylesheet" href="{{ asset('css/filter.css') }}">
    <script src="{{ asset('js/filter.js') }}"></script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Handle add to cart button clicks
            const addToCartButtons = document.querySelectorAll('[data-add-to-cart]');
            
            addToCartButtons.forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    const card = this.closest('.card-product');
                    const productId = card.dataset.productId;
                    const productName = card.querySelector('.name-product').textContent;
                    
                    // Get all variants for this product
                    const variants = JSON.parse(card.dataset.variants);
                    
                    // Show variant selection modal
                    showVariantModal(productId, productName, variants);
                });
            });
            
            function showVariantModal(productId, productName, variants) {
                // Create modal HTML
                const modalHTML = `
                    <div class="modal fade" id="variantModal" tabindex="-1" aria-labelledby="variantModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="variantModalLabel">Chọn loại sản phẩm</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <p class="fw-bold text-lg">${productName}</p>
                                    
                                    <div class="mb-3">
                                        <label class="form-label">Chọn kích cỡ:</label>
                                        <div id="sizeOptions" class="d-flex gap-2 flex-wrap">
                                        </div>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label class="form-label">Chọn màu sắc:</label>
                                        <div id="colorOptions" class="d-flex gap-2 flex-wrap">
                                        </div>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label class="form-label">Số lượng:</label>
                                        <div class="input-group" style="max-width: 150px;">
                                            <button type="button" class="btn btn-outline-secondary btn-sm" id="decreaseQty">-</button>
                                            <input type="number" id="quantity" class="form-control form-control-sm text-center" value="1" min="1" readonly>
                                            <button type="button" class="btn btn-outline-secondary btn-sm" id="increaseQty">+</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                                    <button type="button" class="btn btn-success" id="confirmAddToCart">Thêm vào giỏ</button>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
                
                // Remove old modal if exists
                const oldModal = document.getElementById('variantModal');
                if (oldModal) oldModal.remove();
                
                // Add modal to body
                document.body.insertAdjacentHTML('beforeend', modalHTML);
                
                // Populate variant options
                const uniqueSizes = [...new Set(variants.map(v => JSON.stringify({id: v.size_id, name: v.size_name})))].map(v => JSON.parse(v));
                const uniqueColors = [...new Set(variants.map(v => JSON.stringify({id: v.color_id, name: v.color_name, code: v.color_code})))].map(v => JSON.parse(v));
                
                const sizeOptions = document.getElementById('sizeOptions');
                const colorOptions = document.getElementById('colorOptions');
                
                sizeOptions.innerHTML = uniqueSizes.map(size => `
                    <button type="button" class="btn btn-outline-secondary btn-sm size-option" data-size-id="${size.id}">
                        ${size.name}
                    </button>
                `).join('');
                
                colorOptions.innerHTML = uniqueColors.map(color => `
                    <button type="button" class="btn btn-sm color-option" data-color-id="${color.id}" 
                            style="background-color: ${color.code}; color: ${isLightColor(color.code) ? '#000' : '#fff'}; border: 2px solid #ddd;"
                            title="${color.name}">
                    </button>
                `).join('');
                
                // Show modal
                const modal = new bootstrap.Modal(document.getElementById('variantModal'));
                modal.show();
                
                // Handle variant selection
                let selectedSize = null;
                let selectedColor = null;
                
                document.querySelectorAll('.size-option').forEach(btn => {
                    btn.addEventListener('click', function() {
                        document.querySelectorAll('.size-option').forEach(b => b.classList.remove('active', 'btn-primary'));
                        this.classList.add('active', 'btn-primary');
                        selectedSize = this.dataset.sizeId;
                    });
                });
                
                document.querySelectorAll('.color-option').forEach(btn => {
                    btn.addEventListener('click', function() {
                        document.querySelectorAll('.color-option').forEach(b => b.style.borderWidth = '2px');
                        this.style.borderWidth = '4px';
                        this.style.borderColor = '#000';
                        selectedColor = this.dataset.colorId;
                    });
                });
                
                // Handle quantity
                document.getElementById('decreaseQty').addEventListener('click', function() {
                    const qty = document.getElementById('quantity');
                    if (qty.value > 1) qty.value--;
                });
                
                document.getElementById('increaseQty').addEventListener('click', function() {
                    const qty = document.getElementById('quantity');
                    
                    // Find current variant to check max stock
                    if (selectedSize && selectedColor) {
                        const currentVariant = variants.find(v => 
                            v.size_id == selectedSize && v.color_id == selectedColor
                        );
                        
                        if (currentVariant && parseInt(qty.value) >= currentVariant.stock) {
                            alert(`Số lượng tối đa cho loại này là ${currentVariant.stock}`);
                            return;
                        }
                    }
                    
                    qty.value++;
                });
                
                // Handle confirm button
                document.getElementById('confirmAddToCart').addEventListener('click', function() {
                    if (!selectedSize || !selectedColor) {
                        alert('Vui lòng chọn kích cỡ và màu sắc');
                        return;
                    }
                    
                    // Find the variant with selected size and color
                    const selectedVariant = variants.find(v => 
                        v.size_id == selectedSize && v.color_id == selectedColor
                    );
                    
                    if (!selectedVariant) {
                        alert('Loại sản phẩm này không có sẵn');
                        return;
                    }
                    
                    const quantity = parseInt(document.getElementById('quantity').value);
                    
                    // Check stock availability
                    if (quantity > selectedVariant.stock) {
                        alert(`Số lượng không đủ. Chỉ còn ${selectedVariant.stock} sản phẩm trong kho`);
                        return;
                    }
                    
                    addToCart(selectedVariant.id, quantity);
                    
                    modal.hide();
                });
            }
            
            function addToCart(variantId, quantity) {
                fetch("{{ route('cart.add') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'X-Requested-With': 'XMLHttpRequest',
                    },
                    credentials: 'same-origin',
                    body: JSON.stringify({
                        product_variant_id: variantId,
                        quantity: quantity
                    })
                })
                .then(res => {
                    if (res.status === 401) {
                        window.location.href = "{{ route('auth.login') }}";
                        return;
                    }
                    return res.json();
                })
                .then(data => {
                    if (data && data.success) {
                        showToast('Đã thêm vào giỏ hàng!', 'success');
                    } else {
                        showToast(data?.message || 'Lỗi thêm vào giỏ hàng', 'error');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showToast('Lỗi kết nối. Vui lòng thử lại', 'error');
                });
            }
            
            function showToast(message, type = 'info') {
                const toastHTML = `
                    <div class="toast align-items-center text-white bg-${type === 'success' ? 'success' : 'danger'} border-0" role="alert">
                        <div class="d-flex">
                            <div class="toast-body">
                                ${message}
                            </div>
                            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
                        </div>
                    </div>
                `;
                
                const toastContainer = document.getElementById('toastContainer');
                if (!toastContainer) {
                    const container = document.createElement('div');
                    container.id = 'toastContainer';
                    container.style.cssText = 'position: fixed; top: 20px; right: 20px; z-index: 9999;';
                    document.body.appendChild(container);
                }
                
                document.getElementById('toastContainer').insertAdjacentHTML('beforeend', toastHTML);
                
                const toastEl = document.getElementById('toastContainer').lastElementChild;
                const toast = new bootstrap.Toast(toastEl);
                toast.show();
                
                setTimeout(() => toastEl.remove(), 3000);
            }
            
            function isLightColor(hex) {
                const r = parseInt(hex.substr(1, 2), 16);
                const g = parseInt(hex.substr(3, 2), 16);
                const b = parseInt(hex.substr(5, 2), 16);
                const brightness = ((r * 299) + (g * 587) + (b * 114)) / 1000;
                return brightness > 155;
            }
        });
    </script>
@endpush