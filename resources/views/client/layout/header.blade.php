<header id="header" class="header-default">
    <div class="container">
        <div class="row wrapper-header align-items-center">
            <div class="col-md-4 col-3 d-xl-none">
                <a href="#mobileMenu" class="mobile-menu" data-bs-toggle="offcanvas" aria-controls="mobileMenu">
                    <i class="icon icon-categories1"></i>
                </a>
            </div>
            <div class="col-xl-2 col-md-4 col-6">
                <a href="{{ route('client.homeClient') }}" class="logo-header">
                    <img src="{{ asset('admin/assets/images/1.png') }}" alt="logo" class="logo">
                </a>
            </div>
            <div class="col-xl-8 d-none d-xl-block">
                <nav class="box-navigation text-center">
                    <ul class="box-nav-menu">
                        <li class="menu-item"><a href="{{ route('client.homeClient') }}" class="item-link">Trang chủ</a>
                        </li>
                        <li class="menu-item"><a href="{{ route('shop.index') }}" class="item-link">Sản phẩm</a></li>
                        <li class="menu-item"><a href="{{ route('client.blog.index') }}" class="item-link">Blog</a></li>
                        <li class="menu-item"><a href="{{ route('client.faq.index') }}" class="item-link">Câu hỏi thường gặp</a></li>
                    </ul>
                </nav>
            </div>
            <div class="col-xl-2 col-md-4 col-3">
                <ul class="nav-icon d-flex justify-content-end align-items-center">
                    <!-- Ô tìm kiếm luôn hiển thị -->
                    <!-- Ô tìm kiếm đẹp - Luôn hiển thị -->
                    <li class="nav-search position-relative" style="min-width: 300px;">
                        <form action="{{ route('client.search.results') }}" method="GET" id="searchForm">
                            <div class="search-box">

                                <input type="text" name="q" id="headerSearchInput"
                                    class="search-input  icon icon-search search-icon" placeholder="Tìm kiếm sản phẩm"
                                    autocomplete="off">
                            </div>
                        </form>

                        <!-- Dropdown kết quả (nếu muốn live search) -->
                        <div id="liveSearchResults" class="live-search-dropdown"></div>
                    </li>
                    <li class="nav-account">
                        <a href="{{ route('client.account.detail') }}" aria-controls="login" class="nav-icon-item">
                            <i class="icon icon-user"></i>
                        </a>
                    </li>
                    <li class="nav-wishlist">
                        <a href="{{ route('client.wishlist.index') }}" class="nav-icon-item">
                            <i class="icon icon-heart"></i>
                            <span class="count-box">0</span>
                        </a>
                    </li>
                    <li class="nav-cart">
                        <a href="{{ route('cart.view') }}" class="nav-icon-item">
                            <i class="icon icon-cart"></i>
                            <span class="count-box">{{ $cartCount }}</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</header>
