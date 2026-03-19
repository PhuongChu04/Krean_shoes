<!DOCTYPE html>

<!--[if IE 8 ]><html class="ie" xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-US" lang="en-US"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!-->
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-US" lang="en-US">
<!--<![endif]-->


<!-- Mirrored from vineta-html.vercel.app/home-electronic.html by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 26 Apr 2025 19:31:38 GMT -->
<!-- Added by HTTrack --><meta http-equiv="content-type" content="text/html;charset=utf-8" /><!-- /Added by HTTrack -->
<head>
    <meta charset="utf-8">
    <title>Vineta - Multipurpose eCommerce</title>

    <meta name="author" content="themesflat.com">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="description"
        content="Themesflat Vineta - A modern and versatile eCommerce template designed for various online stores, including fashion, furniture, electronics, and more. SEO-friendly, fast-loading, and highly customizable.">

    <!-- font -->
    <link rel="stylesheet" href="{{ asset('client/fonts/fonts.css') }}">
    <link rel="stylesheet" href="{{ asset('client/fonts/font-icons.css') }}">
    <!-- css -->
    <link rel="stylesheet" href="{{ asset('client/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('client/css/swiper-bundle.min.css') }}">
    <link rel="stylesheet" href="{{ asset('client/css/animate.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('client/css/styles.css') }}">

    <!-- Favicon and Touch Icons  -->
    <link rel="shortcut icon" href="{{ asset('client/images/logo/favicon.png') }}">
    <link rel="apple-touch-icon-precomposed" href="{{ asset('client/images/logo/favicon.png') }}">

</head>

<body>

    <!-- RTL -->
    <a href="javascript:void(0);" id="toggle-rtl" class="tf-btn animate-btn"><span>RTL</span></a>
    <!-- /RTL  -->

    <!-- Scroll Top -->
   @include('client.layout.srcoll')

    <!-- preload  tải trước-->
    <div class="preload preload-container">
        <div class="preload-logo">
            <div class="spinner"></div>
        </div>
    </div>
    <!-- /preload -->

    <div id="wrapper">
        <!-- Top Bar-->
        <div class="tf-topbar bg-dark-5 topbar-bg">
            <div class="container">
                <div class="row align-items-center justify-content-center">
                    <div class="col-xl-6 overflow-hidden">
                        <div class="topbar-center marquee-wrapper">
                            <div class="initial-child-container">
                                <div class="marquee-child-item">
                                    <p>Return extended to 60 days</p>
                                </div>
                                <div class="marquee-child-item"><span class="dot"></span></div>
                                <div class="marquee-child-item">
                                    <p>Life-time Guarantes</p>
                                </div>
                                <div class="marquee-child-item"><span class="dot"></span></div>
                                <div class="marquee-child-item">
                                    <p>Limited-Time Offer</p>
                                </div>
                                <div class="marquee-child-item"><span class="dot"></span></div>
                                <!-- 2 -->
                                <div class="marquee-child-item">
                                    <p>Return extended to 60 days</p>
                                </div>
                                <div class="marquee-child-item"><span class="dot"></span></div>
                                <div class="marquee-child-item">
                                    <p>Life-time Guarantes</p>
                                </div>
                                <div class="marquee-child-item"><span class="dot"></span></div>
                                <div class="marquee-child-item">
                                    <p>Limited-Time Offer</p>
                                </div>
                                <div class="marquee-child-item"><span class="dot"></span></div>
                                <!-- 3 -->
                                <div class="marquee-child-item">
                                    <p>Return extended to 60 days</p>
                                </div>
                                <div class="marquee-child-item"><span class="dot"></span></div>
                                <div class="marquee-child-item">
                                    <p>Life-time Guarantes</p>
                                </div>
                                <div class="marquee-child-item"><span class="dot"></span></div>
                                <div class="marquee-child-item">
                                    <p>Limited-Time Offer</p>
                                </div>
                                <div class="marquee-child-item"><span class="dot"></span></div>
                                <!-- 4 -->
                                <div class="marquee-child-item">
                                    <p>Return extended to 60 days</p>
                                </div>
                                <div class="marquee-child-item"><span class="dot"></span></div>
                                <div class="marquee-child-item">
                                    <p>Life-time Guarantes</p>
                                </div>
                                <div class="marquee-child-item"><span class="dot"></span></div>
                                <div class="marquee-child-item">
                                    <p>Limited-Time Offer</p>
                                </div>
                                <div class="marquee-child-item"><span class="dot"></span></div>
                                <!-- 5 -->
                                <div class="marquee-child-item">
                                    <p>Return extended to 60 days</p>
                                </div>
                                <div class="marquee-child-item"><span class="dot"></span></div>
                                <div class="marquee-child-item">
                                    <p>Life-time Guarantes</p>
                                </div>
                                <div class="marquee-child-item"><span class="dot"></span></div>
                                <div class="marquee-child-item">
                                    <p>Limited-Time Offer</p>
                                </div>
                                <div class="marquee-child-item"><span class="dot"></span></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Top Bar -->
        <!-- Header -->
       @include('client.layout.header')
        <!-- /Header -->

<div>
    @yield('content')
</div>
        
       
        <!-- Footer -->
       @include('client.layout.footer')
        <!-- /Footer -->


    </div>

   

    <!-- Javascript -->
    <script src="{{ asset('client/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('client/js/jquery.min.js') }}"></script>
    <script src="{{ asset('client/js/swiper-bundle.min.js') }}"></script>
    <script src="{{ asset('client/js/carousel.js') }}"></script>
    <script src="{{ asset('client/js/bootstrap-select.min.js') }}"></script>
    <script src="{{ asset('client/js/lazysize.min.js') }}"></script>
    <script src="{{ asset('client/js/count-down.js') }}"></script>
    <script src="{{ asset('client/js/wow.min.js') }}"></script>
    <script src="{{ asset('client/js/multiple-modal.js') }}"></script>

    <script src="{{ asset('client/js/main.js') }}"></script>

    @stack('scripts')
</body>


<!-- Mirrored from vineta-html.vercel.app/home-electronic.html by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 26 Apr 2025 19:33:06 GMT -->
</html>