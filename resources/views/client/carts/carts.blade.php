@extends('client.layout.layout')

@section('content')
    <!-- Title Page -->
    <section class="tf-page-title">
        <div class="container">
            <div class="box-title text-center">
                <h4 class="title">Giỏ hàng</h4>
                <div class="breadcrumb-list">
                    <a class="breadcrumb-item" href="{{ route('client.homeClient') }}">Trang chủ</a>
                    <div class="breadcrumb-item dot"><span></span></div>
                    <div class="breadcrumb-item current">Giỏ hàng</div>
                </div>
            </div>
        </div>
    </section>
    <!-- /Title Page -->
    <div class="flat-spacing-24">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-4 col-sm-8">
                    <div class="tf-cart-head text-center">
                        <p class="text-xl-3 title text-dark-4">Nhanh <span class="fw-medium">100k</span> đơn hàng mỗi ngày</p>
                            <span class="fw-medium">Miễn phí vận chuyển</span>
                        </p>
                        <div class="progress-sold tf-progress-ship">
                            <div class="value" style="width: 0%;" data-progress="60">
                                <i class="icon icon-car"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Cart Section -->
    <div class="flat-spacing-2 pt-0 mt_15">
        <div class="container">
            <div class="row">
                <div class="col-xl-8">
                    <div class="tf-page-cart-main">
                        <form class="form-cart">
                            <table class="table-page-cart">
                                <thead>
                                    <tr>
                                        <th>Product</th>
                                        <th>Price</th>
                                        <th>Quantity</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="tf-cart-item file-delete">
                                        <td class="tf-cart-item_product">
                                            <a href="product-detail.html" class="img-box">
                                                <img src="images/products/fashion/product-1.jpg" alt="img-product">
                                            </a>
                                            <div class="cart-info">
                                                <a href="product-detail.html" class="name text-md link fw-medium">Oversized
                                                    Printed
                                                    T-shirt</a>
                                                <div class="variants">White / L</div>
                                                <span class="remove-cart link remove">Remove</span>
                                            </div>
                                        </td>
                                        <td class="tf-cart-item_price text-center" data-cart-title="Price">
                                            <span class="cart-price price-on-sale text-md fw-medium">$130.00</span>
                                        </td>
                                        <td class="tf-cart-item_quantity" data-cart-title="Quantity">
                                            <div class="wg-quantity">
                                                <span class="btn-quantity btn-decrease">-</span>
                                                <input class="quantity-product" type="text" name="number"
                                                    value="1">
                                                <span class="btn-quantity btn-increase">+</span>
                                            </div>
                                        </td>
                                        <td class="tf-cart-item_total text-center" data-cart-title="Total">
                                            <div class="cart-total total-price text-md fw-medium">$130.00</div>
                                        </td>
                                    </tr>
                                    <tr class="tf-cart-item file-delete">
                                        <td class="tf-cart-item_product">
                                            <a href="product-detail.html" class="img-box">
                                                <img src="images/products/fashion/product-34.jpg" alt="img-product">
                                            </a>
                                            <div class="cart-info">
                                                <a href="product-detail.html" class="name text-md link fw-medium">Loose Fit
                                                    Tee</a>
                                                <div class="variants">White / L</div>
                                                <span class="remove-cart link remove">Remove</span>
                                            </div>
                                        </td>
                                        <td class="tf-cart-item_price text-center" data-cart-title="Price">
                                            <span class="cart-price price-on-sale text-md fw-medium">$130.00</span>
                                        </td>
                                        <td class="tf-cart-item_quantity" data-cart-title="Quantity">
                                            <div class="wg-quantity">
                                                <span class="btn-quantity btn-decrease">-</span>
                                                <input class="quantity-product" type="text" name="number"
                                                    value="1">
                                                <span class="btn-quantity btn-increase">+</span>
                                            </div>
                                        </td>
                                        <td class="tf-cart-item_total text-center" data-cart-title="Total">
                                            <div class="cart-total total-price text-md fw-medium">$130.00</div>
                                        </td>
                                    </tr>
                                    <tr class="tf-cart-item file-delete">
                                        <td class="tf-cart-item_product">
                                            <a href="product-detail.html" class="img-box">
                                                <img src="images/products/fashion/product-35.jpg" alt="img-product">
                                            </a>
                                            <div class="cart-info">
                                                <a href="product-detail.html" class="name text-md link fw-medium">Crop
                                                    T-shirt</a>
                                                <div class="variants">White / L</div>
                                                <span class="remove-cart link remove">Remove</span>
                                            </div>
                                        </td>
                                        <td class="tf-cart-item_price text-center" data-cart-title="Price">
                                            <span class="cart-price price-on-sale text-md fw-medium">$130.00</span>
                                        </td>
                                        <td class="tf-cart-item_quantity" data-cart-title="Quantity">
                                            <div class="wg-quantity">
                                                <span class="btn-quantity btn-decrease">-</span>
                                                <input class="quantity-product" type="text" name="number"
                                                    value="1">
                                                <span class="btn-quantity btn-increase">+</span>
                                            </div>
                                        </td>
                                        <td class="tf-cart-item_total text-center" data-cart-title="Total">
                                            <div class="cart-total total-price text-md fw-medium">$130.00</div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="check-gift">
                                <input type="checkbox" class="tf-check" id="checkGift">
                                <label for="checkGift" class="label text-dark-4">Add gift wrap. Only <span
                                        class="fw-medium">$10.00.</span> (You can choose or not)</label>
                            </div>
                            <div class="box-ip-discount">
                                <div class="discount-ip">
                                    <input class="value-discount" type="text" placeholder="Discount code">
                                    <button type="button" class="tf-btn radius-6 btn-out-line-dark-2">Apply</button>
                                </div>
                            </div>
                            <div class="cart-note">
                                <label for="note" class="text-md fw-medium">Special instructions for seller</label>
                                <textarea id="note"></textarea>
                            </div>
                        </form>
                        <div class="fl-iconbox wow fadeInUp">
                            <div dir="ltr" class="swiper tf-swiper sw-auto"
                                data-swiper='{
                                    "slidesPerView": 1,
                                    "spaceBetween": 12,
                                    "speed": 800,
                                    "preventInteractionOnTransition": false, 
                                    "touchStartPreventDefault": false,
                                    "slidesPerGroup": 1,
                                    "pagination": { "el": ".sw-pagination-iconbox", "clickable": true },
                                    "breakpoints": {
                                        "575": { "slidesPerView": 2, "spaceBetween": 12, "slidesPerGroup": 2}, 
                                        "768": { "slidesPerView": 3, "spaceBetween": 24, "slidesPerGroup": 3},
                                        "1200": { "slidesPerView": "auto", "spaceBetween": 24}
                                    }
                                }'>
                                <div class="swiper-wrapper">
                                    <div class="swiper-slide">
                                        <div class="tf-icon-box justify-content-center justify-content-sm-start style-3">
                                            <div class="box-icon">
                                                <i class="icon icon-shipping"></i>
                                            </div>
                                            <div class="content">
                                                <div class="title text-uppercase">Free Shipping</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="swiper-slide">
                                        <div class="tf-icon-box justify-content-center justify-content-sm-start style-3">
                                            <div class="box-icon">
                                                <i class="icon icon-gift"></i>
                                            </div>
                                            <div class="content">
                                                <div class="title text-uppercase">Gift Package</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="swiper-slide">
                                        <div class="tf-icon-box justify-content-center justify-content-sm-start style-3">
                                            <div class="box-icon">
                                                <i class="icon icon-return"></i>
                                            </div>
                                            <div class="content">
                                                <div class="title text-uppercase">Ease Returns</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="swiper-slide">
                                        <div class="tf-icon-box justify-content-center justify-content-sm-start style-3">
                                            <div class="box-icon">
                                                <i class="icon icon-support"></i>
                                            </div>
                                            <div class="content">
                                                <div class="title text-uppercase text-nowrap">ONE YEAR WARRANTY
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="d-flex d-xl-none sw-dot-default sw-pagination-iconbox justify-content-center">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4">
                    <div class="tf-page-cart-sidebar">
                        <form class="cart-box shipping-cart-box">
                            <div class="text-lg title fw-medium">Shipping estimates</div>
                            <fieldset class="field">
                                <label for="country" class="text-sm">Country</label>
                                <input type="text" id="country" placeholder="United State">
                            </fieldset>
                            <fieldset class="field">
                                <label for="state" class="text-sm">State/Province</label>
                                <input type="text" id="state" placeholder="State/Province">
                            </fieldset>
                            <fieldset class="field">
                                <label for="code" class="text-sm">Zipcode</label>
                                <input type="text" id="code" placeholder="41000">
                            </fieldset>
                            <button type="button" class="tf-btn btn-dark2 animate-btn w-100">Estimate</button>
                        </form>
                        <form action="https://vineta-html.vercel.app/checkout.html" class="cart-box checkout-cart-box">
                            <div class="cart-head">
                                <div class="total-discount text-xl fw-medium">
                                    <span>Total:</span>
                                    <span class="total">$130.00 USD</span>
                                </div>
                                <p class="text-sm text-dark-4">Taxes and shipping calculated at checkout</p>
                            </div>
                            <div class="check-agree">
                                <input type="checkbox" class="tf-check" id="check-agree">
                                <label for="check-agree" class="label text-dark-4">I agree with <a
                                        href="term-and-condition.html"
                                        class="text-dark-4 fw-medium text-underline link">term and
                                        conditions</a></label>
                            </div>
                            <div class="checkout-btn">
                                <button type="submit" class="tf-btn btn-dark2 animate-btn w-100">Checkout</button>
                            </div>
                            <div class="cart-imgtrust">
                                <p class="text-center text-sm text-dark-1">We accept</p>
                                <div class="cart-list-social">
                                    <div class="payment-card">
                                        <img src="images/payment/Visa.png" alt="">
                                    </div>
                                    <div class="payment-card">
                                        <img src="images/payment/DinersClub.png" alt="">
                                    </div>
                                    <div class="payment-card">
                                        <img src="images/payment/Mastercard.png" alt="">
                                    </div>
                                    <div class="payment-card">
                                        <img src="images/payment/Stripe.png" alt="">
                                    </div>

                                </div>
                            </div>
                        </form>
                        <div class="cart-box testimonial-cart-box">
                            <div dir="ltr" class="swiper tf-swiper"
                                data-swiper='{
                                    "slidesPerView": 1,
                                    "spaceBetween": 12,
                                    "speed": 800,
                                    "preventInteractionOnTransition": false, 
                                    "touchStartPreventDefault": false,
                                    "pagination": { "el": ".sw-pagination-tes", "clickable": true },
                                    "navigation": {
                                        "clickable": true,
                                        "nextEl": ".nav-next-tes",
                                        "prevEl": ".nav-prev-tes"
                                    }
                                    }'>
                                <div class="swiper-wrapper">
                                    <div class="swiper-slide">
                                        <div class="box-testimonial-main">
                                            <span class="quote icon-quote5"></span>
                                            <div class="content">
                                                <div class="list-star-default">
                                                    <i class="icon-star"></i>
                                                    <i class="icon-star"></i>
                                                    <i class="icon-star"></i>
                                                    <i class="icon-star"></i>
                                                    <i class="icon-star"></i>
                                                </div>

                                                <p class="text-review text-md text-main">"Stylish, comfortable, and
                                                    perfect for any occasion! My new favorite fashion destination."
                                                </p>
                                                <div class="box-author">
                                                    <div class="img">
                                                        <img src="images/avatar/avt-1.png" alt="author">
                                                    </div>
                                                    <span class="name text-sm fw-medium">Vineta P.</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="swiper-slide">
                                        <div class="box-testimonial-main">
                                            <span class="quote icon-quote5"></span>
                                            <div class="content">
                                                <div class="list-star-default">
                                                    <i class="icon-star"></i>
                                                    <i class="icon-star"></i>
                                                    <i class="icon-star"></i>
                                                    <i class="icon-star"></i>
                                                    <i class="icon-star"></i>
                                                </div>

                                                <p class="text-review text-md text-main">"Trendy, versatile, and
                                                    fits perfectly! My go-to place for stylish outfits."</p>
                                                <div class="box-author">
                                                    <div class="img">
                                                        <img src="images/avatar/blog-author-3.jpg" alt="author">
                                                    </div>
                                                    <span class="name text-sm fw-medium">Themesflat</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="swiper-slide">
                                        <div class="box-testimonial-main">
                                            <span class="quote icon-quote5"></span>
                                            <div class="content">
                                                <div class="list-star-default">
                                                    <i class="icon-star"></i>
                                                    <i class="icon-star"></i>
                                                    <i class="icon-star"></i>
                                                    <i class="icon-star"></i>
                                                    <i class="icon-star"></i>
                                                </div>

                                                <p class="text-review text-md text-main">"Chic, affordable, and
                                                    always on point! I’m obsessed with their collections!"</p>
                                                <div class="box-author">
                                                    <div class="img">
                                                        <img src="images/avatar/blog-author-2.jpg" alt="author">
                                                    </div>
                                                    <span class="name text-sm fw-medium">Henry P.</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="box-nav-swiper">
                                    <div class="swiper-button-prev nav-swiper nav-prev-tes"></div>
                                    <div class="swiper-button-next nav-swiper nav-next-tes"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /Cart Section -->
    <!-- You May Also Like -->
    <section class="flat-spacing pt-0">
        <div class="container">
            <div class="flat-title wow fadeInUp mb_5">
                <h4 class="title">You May Also Like</h4>
            </div>
            <div class="fl-control-sw wrap-pos-nav sw-over-product">
                <div dir="ltr" class="swiper tf-swiper wrap-sw-over"
                    data-swiper='{
                            "slidesPerView": 2,
                            "spaceBetween": 12,
                            "speed": 800,
                            "observer": true,
                            "observeParents": true,
                            "slidesPerGroup": 2,
                            "navigation": {
                                "clickable": true,
                                "nextEl": ".nav-next-also",
                                "prevEl": ".nav-prev-also"
                            },
                            "pagination": { "el": ".sw-pagination-also", "clickable": true },
                            "breakpoints": {
                            "768": { "slidesPerView": 3, "spaceBetween": 12, "slidesPerGroup": 3 },
                            "1200": { "slidesPerView": 4, "spaceBetween": 24, "slidesPerGroup": 4}
                            }
                        }'>
                    <div class="swiper-wrapper">
                        <!-- item 1 -->
                        <div class="swiper-slide">
                            <div class="card-product style-2">
                                <div class="card-product-wrapper">
                                    <a href="product-detail.html" class="product-img">
                                        <img class="img-product lazyload"
                                            data-src="images/products/fashion/product-36.jpg"
                                            src="images/products/fashion/product-36.jpg" alt="image-product">
                                        <img class="img-hover lazyload" data-src="images/products/fashion/product-4.jpg"
                                            src="images/products/fashion/product-4.jpg" alt="image-product">
                                    </a>
                                    <ul class="list-product-btn">
                                        <li>
                                            <a href="view-cart.html" class="hover-tooltip box-icon">
                                                <span class="icon icon-cart2"></span>
                                                <span class="tooltip">Add to Cart</span>
                                            </a>
                                        </li>
                                        <li class="wishlist">
                                            <a href="javascript:void(0);" class="hover-tooltip box-icon">
                                                <span class="icon icon-heart2"></span>
                                                <span class="tooltip">Add to Wishlist</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#quickView" data-bs-toggle="modal"
                                                class="hover-tooltip box-icon quickview">
                                                <span class="icon icon-view"></span>
                                                <span class="tooltip">Quick View</span>
                                            </a>
                                        </li>
                                        <li class="compare">
                                            <a href="#compare" data-bs-toggle="modal" class="hover-tooltip box-icon">
                                                <span class="icon icon-compare"></span>
                                                <span class="tooltip">Add to Compare</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="card-product-info">
                                    <a href="product-detail.html" class="name-product link fw-medium text-md">Loose
                                        Fit Tee</a>
                                    <p class="price-wrap fw-medium">
                                        <span class="price-new">$120.00</span>
                                        <span class="price-old">$150.00</span>
                                    </p>
                                    <ul class="list-color-product">
                                        <li class="list-color-item hover-tooltip tooltip-bot color-swatch active">
                                            <span class="tooltip color-filter">Beige</span>
                                            <span class="swatch-value bg-beige"></span>
                                            <img class=" lazyload" data-src="images/products/fashion/product-36.jpg"
                                                src="images/products/fashion/product-36.jpg" alt="image-product">
                                        </li>
                                        <li class="list-color-item color-swatch hover-tooltip tooltip-bot">
                                            <span class="tooltip color-filter">Black</span>
                                            <span class="swatch-value bg-dark"></span>
                                            <img class=" lazyload" data-src="images/products/fashion/product-9.jpg"
                                                src="images/products/fashion/product-9.jpg" alt="image-product">
                                        </li>
                                        <li class="list-color-item color-swatch hover-tooltip tooltip-bot line">
                                            <span class="tooltip color-filter">White</span>
                                            <span class="swatch-value bg-white"></span>
                                            <img class=" lazyload" data-src="images/products/fashion/product-4.jpg"
                                                src="images/products/fashion/product-4.jpg" alt="image-product">
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <!-- item 2 -->
                        <div class="swiper-slide">
                            <div class="card-product style-2">
                                <div class="card-product-wrapper">
                                    <a href="product-detail.html" class="product-img">
                                        <img class="img-product lazyload"
                                            data-src="images/products/fashion/product-37.jpg"
                                            src="images/products/fashion/product-37.jpg" alt="image-product">
                                        <img class="img-hover lazyload" data-src="images/products/fashion/product-7.jpg"
                                            src="images/products/fashion/product-7.jpg" alt="image-product">
                                    </a>
                                    <ul class="list-product-btn">
                                        <li>
                                            <a href="view-cart.html" class="hover-tooltip box-icon">
                                                <span class="icon icon-cart2"></span>
                                                <span class="tooltip">Add to Cart</span>
                                            </a>
                                        </li>
                                        <li class="wishlist">
                                            <a href="javascript:void(0);" class="hover-tooltip box-icon">
                                                <span class="icon icon-heart2"></span>
                                                <span class="tooltip">Add to Wishlist</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#quickView" data-bs-toggle="modal"
                                                class="hover-tooltip box-icon quickview">
                                                <span class="icon icon-view"></span>
                                                <span class="tooltip">Quick View</span>
                                            </a>
                                        </li>
                                        <li class="compare">
                                            <a href="#compare" data-bs-toggle="modal" class="hover-tooltip box-icon">
                                                <span class="icon icon-compare"></span>
                                                <span class="tooltip">Add to Compare</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="card-product-info">
                                    <a href="product-detail.html" class="name-product link fw-medium text-md">Long
                                        Sleeve T-Shirt</a>
                                    <p class="price-wrap fw-medium">
                                        <span class="price-new">$120.00</span>
                                        <span class="price-old">$150.00</span>
                                    </p>
                                    <ul class="list-color-product">
                                        <li class="list-color-item color-swatch hover-tooltip tooltip-bot active">
                                            <span class="tooltip color-filter">Red</span>
                                            <span class="swatch-value bg-red"></span>
                                            <img class=" lazyload" data-src="images/products/fashion/product-37.jpg"
                                                src="images/products/fashion/product-37.jpg" alt="image-product">
                                        </li>
                                        <li class="list-color-item color-swatch hover-tooltip tooltip-bot">
                                            <span class="tooltip color-filter">Beige</span>
                                            <span class="swatch-value bg-beige"></span>
                                            <img class=" lazyload" data-src="images/products/fashion/product-7.jpg"
                                                src="images/products/fashion/product-7.jpg" alt="image-product">
                                        </li>
                                        <li class="list-color-item color-swatch hover-tooltip tooltip-bot">
                                            <span class="tooltip color-filter">Grey</span>
                                            <span class="swatch-value bg-grey-4"></span>
                                            <img class=" lazyload" data-src="images/products/fashion/product-2.jpg"
                                                src="images/products/fashion/product-2.jpg" alt="image-product">
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <!-- item 3 -->
                        <div class="swiper-slide">
                            <div class="card-product style-2">
                                <div class="card-product-wrapper">
                                    <a href="product-detail.html" class="product-img">
                                        <img class="img-product lazyload"
                                            data-src="images/products/fashion/product-38.jpg"
                                            src="images/products/fashion/product-38.jpg" alt="image-product">
                                        <img class="img-hover lazyload" data-src="images/products/fashion/product-29.jpg"
                                            src="images/products/fashion/product-29.jpg" alt="image-product">
                                    </a>
                                    <ul class="list-product-btn">
                                        <li>
                                            <a href="view-cart.html" class="hover-tooltip box-icon">
                                                <span class="icon icon-cart2"></span>
                                                <span class="tooltip">Add to Cart</span>
                                            </a>
                                        </li>
                                        <li class="wishlist">
                                            <a href="javascript:void(0);" class="hover-tooltip box-icon">
                                                <span class="icon icon-heart2"></span>
                                                <span class="tooltip">Add to Wishlist</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#quickView" data-bs-toggle="modal"
                                                class="hover-tooltip box-icon quickview">
                                                <span class="icon icon-view"></span>
                                                <span class="tooltip">Quick View</span>
                                            </a>
                                        </li>
                                        <li class="compare">
                                            <a href="#compare" data-bs-toggle="modal" class="hover-tooltip box-icon">
                                                <span class="icon icon-compare"></span>
                                                <span class="tooltip">Add to Compare</span>
                                            </a>
                                        </li>
                                    </ul>

                                </div>
                                <div class="card-product-info">
                                    <a href="product-detail.html" class="name-product link fw-medium text-md">Loose
                                        Fit Tee</a>
                                    <p class="price-wrap fw-medium">
                                        <span class="price-new">$120.00</span>
                                        <span class="price-old">$130.00</span>
                                    </p>
                                    <ul class="list-color-product">
                                        <li class="list-color-item color-swatch hover-tooltip tooltip-bot active">
                                            <span class="tooltip color-filter">Black</span>
                                            <span class="swatch-value bg-dark"></span>
                                            <img class=" lazyload" data-src="images/products/fashion/product-38.jpg"
                                                src="images/products/fashion/product-38.jpg" alt="image-product">
                                        </li>
                                        <li class="list-color-item color-swatch hover-tooltip tooltip-bot line">
                                            <span class="tooltip color-filter">White</span>
                                            <span class="swatch-value bg-white"></span>
                                            <img class=" lazyload" data-src="images/products/fashion/product-29.jpg"
                                                src="images/products/fashion/product-29.jpg" alt="image-product">
                                        </li>

                                    </ul>
                                </div>
                            </div>
                        </div>
                        <!-- item 4 -->
                        <div class="swiper-slide">
                            <div class="card-product style-2">
                                <div class="card-product-wrapper">
                                    <a href="product-detail.html" class="product-img">
                                        <img class="img-product lazyload"
                                            data-src="images/products/fashion/product-39.jpg"
                                            src="images/products/fashion/product-39.jpg" alt="image-product">
                                        <img class="img-hover lazyload" data-src="images/products/fashion/product-27.jpg"
                                            src="images/products/fashion/product-27.jpg" alt="image-product">
                                    </a>
                                    <ul class="list-product-btn">
                                        <li>
                                            <a href="view-cart.html" class="box-icon hover-tooltip">
                                                <span class="icon icon-cart2"></span>
                                                <span class="tooltip">Add to Cart</span>
                                            </a>
                                        </li>
                                        <li class="wishlist">
                                            <a href="javascript:void(0);" class="box-icon hover-tooltip">
                                                <span class="icon icon-heart2"></span>
                                                <span class="tooltip">Add to Wishlist</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#quickView" data-bs-toggle="modal"
                                                class="box-icon quickview hover-tooltip">
                                                <span class="icon icon-view"></span>
                                                <span class="tooltip">Quick View</span>
                                            </a>
                                        </li>
                                        <li class="compare">
                                            <a href="#compare" data-bs-toggle="modal" class="box-icon hover-tooltip">
                                                <span class="icon icon-compare"></span>
                                                <span class="tooltip">Add to Compare</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="card-product-info">
                                    <a href="product-detail.html" class="name-product link fw-medium text-md">Long
                                        Sleeve T-Shirt</a>
                                    <p class="price-wrap fw-medium">
                                        <span class="price-new">$120.00</span>
                                        <span class="price-old">$130.00</span>
                                    </p>
                                    <ul class="list-color-product">
                                        <li class="list-color-item color-swatch hover-tooltip tooltip-bot active">
                                            <span class="tooltip color-filter">Blue</span>
                                            <span class="swatch-value bg-light-blue"></span>
                                            <img class=" lazyload" data-src="images/products/fashion/product-39.jpg"
                                                src="images/products/fashion/product-39.jpg" alt="image-product">
                                        </li>
                                        <li class="list-color-item color-swatch hover-tooltip tooltip-bot">
                                            <span class="tooltip color-filter">Light Purple</span>
                                            <span class="swatch-value bg-light-purple-3"></span>
                                            <img class=" lazyload" data-src="images/products/fashion/product-27.jpg"
                                                src="images/products/fashion/product-27.jpg" alt="image-product">
                                        </li>

                                    </ul>
                                </div>
                            </div>
                        </div>
                        <!-- item 5 -->
                        <div class="swiper-slide">
                            <div class="card-product style-2">
                                <div class="card-product-wrapper">
                                    <a href="product-detail.html" class="product-img">
                                        <img class="img-product lazyload"
                                            data-src="images/products/fashion/product-13.jpg"
                                            src="images/products/fashion/product-13.jpg" alt="image-product">
                                        <img class="img-hover lazyload" data-src="images/products/fashion/product-14.jpg"
                                            src="images/products/fashion/product-14.jpg" alt="image-product">
                                    </a>
                                    <ul class="list-product-btn">
                                        <li>
                                            <a href="view-cart.html" class="box-icon hover-tooltip">
                                                <span class="icon icon-cart2"></span>
                                                <span class="tooltip">Add to Cart</span>
                                            </a>
                                        </li>
                                        <li class="wishlist">
                                            <a href="javascript:void(0);" class="box-icon hover-tooltip">
                                                <span class="icon icon-heart2"></span>
                                                <span class="tooltip">Add to Wishlist</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#quickView" data-bs-toggle="modal"
                                                class="box-icon quickview hover-tooltip">
                                                <span class="icon icon-view"></span>
                                                <span class="tooltip">Quick View</span>
                                            </a>
                                        </li>
                                        <li class="compare">
                                            <a href="#compare" data-bs-toggle="modal" class="box-icon hover-tooltip">
                                                <span class="icon icon-compare"></span>
                                                <span class="tooltip">Add to Compare</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="card-product-info">
                                    <a href="product-detail.html" class="name-product link fw-medium text-md">COOLMAX®
                                        Loose
                                        Fit Tee</a>
                                    <p class="price-wrap fw-medium">
                                        <span class="price-new">$60.00</span>
                                        <span class=" price-old">$80.00</span>
                                    </p>
                                    <ul class="list-color-product">
                                        <li class="list-color-item color-swatch hover-tooltip tooltip-bot active">
                                            <span class="tooltip color-filter">Black</span>
                                            <span class="swatch-value bg-dark"></span>
                                            <img class=" lazyload" data-src="images/products/fashion/product-13.jpg"
                                                src="images/products/fashion/product-13.jpg" alt="image-product">
                                        </li>
                                        <li class="list-color-item color-swatch hover-tooltip tooltip-bot">
                                            <span class="tooltip color-filter">Purple</span>
                                            <span class="swatch-value bg-purple-3"></span>
                                            <img class="lazyload" data-src="images/products/fashion/product-14.jpg"
                                                src="images/products/fashion/product-14.jpg" alt="image-product">
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <!-- item 6 -->
                        <div class="swiper-slide">
                            <div class="card-product style-2">
                                <div class="card-product-wrapper">
                                    <a href="product-detail.html" class="product-img">
                                        <img class="img-product lazyload"
                                            data-src="images/products/fashion/product-26.jpg"
                                            src="images/products/fashion/product-26.jpg" alt="image-product">
                                        <img class="img-hover lazyload" data-src="images/products/fashion/product-26.jpg"
                                            src="images/products/fashion/product-26.jpg" alt="image-product">
                                    </a>
                                    <ul class="list-product-btn">
                                        <li>
                                            <a href="view-cart.html" class="box-icon hover-tooltip">
                                                <span class="icon icon-cart2"></span>
                                                <span class="tooltip">Add to Cart</span>
                                            </a>
                                        </li>
                                        <li class="wishlist">
                                            <a href="javascript:void(0);" class="box-icon hover-tooltip">
                                                <span class="icon icon-heart2"></span>
                                                <span class="tooltip">Add to Wishlist</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#quickView" data-bs-toggle="modal"
                                                class="box-icon quickview hover-tooltip">
                                                <span class="icon icon-view"></span>
                                                <span class="tooltip">Quick View</span>
                                            </a>
                                        </li>
                                        <li class="compare">
                                            <a href="#compare" data-bs-toggle="modal" class="box-icon hover-tooltip">
                                                <span class="icon icon-compare"></span>
                                                <span class="tooltip">Add to Compare</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="card-product-info">
                                    <a href="product-detail.html" class="name-product link fw-medium text-md">Printed
                                        T-shirt</a>
                                    <p class="price-wrap fw-medium">
                                        <span class="price-new">$120.00</span>
                                        <span class=" price-old">$140.00</span>
                                    </p>
                                    <ul class="list-color-product">
                                        <li class="list-color-item color-swatch line hover-tooltip tooltip-bot active">
                                            <span class="tooltip color-filter">White</span>
                                            <span class="swatch-value bg-white"></span>
                                            <img class=" lazyload" data-src="images/products/fashion/product-26.jpg"
                                                src="images/products/fashion/product-26.jpg" alt="image-product">
                                        </li>
                                        <li class="list-color-item color-swatch hover-tooltip tooltip-bot">
                                            <span class="tooltip color-filter">Grey</span>
                                            <span class="swatch-value bg-grey-4"></span>
                                            <img class=" lazyload" data-src="images/products/fashion/women-grey-1.jpg"
                                                src="images/products/fashion/women-grey-1.jpg" alt="image-product">
                                        </li>
                                        <li class="list-color-item color-swatch hover-tooltip tooltip-bot">
                                            <span class="tooltip color-filter">Black</span>
                                            <span class="swatch-value bg-dark"></span>
                                            <img class=" lazyload" data-src="images/products/fashion/women-black-6.jpg"
                                                src="images/products/fashion/women-black-6.jpg" alt="image-product">
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="d-flex d-xl-none sw-dot-default sw-pagination-also justify-content-center"></div>
                <div class="d-none d-xl-flex swiper-button-next nav-swiper nav-next-also"></div>
                <div class="d-none d-xl-flex swiper-button-prev nav-swiper nav-prev-also"></div>
            </div>
        </div>
    </section>
    <!-- /You May Also Like -->
    @include('client.layout.footer')
@endsection
