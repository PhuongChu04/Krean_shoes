<div class="sidebar-account-wrap sidebar-content-wrap sticky-top d-lg-block d-none">
    <ul class="my-account-nav">
        <li>
            <a href="{{ route('client.account.detail') }}" class="text-sm link fw-medium my-account-nav-item {{ request()->routeIs('client.account.detail') ? 'active' : '' }}">Thông tin tài khoản</a>
        </li>
        <li>
            <a href="{{ route('client.orders.index') }}" class="text-sm link fw-medium my-account-nav-item {{ request()->routeIs('client.orders.*') ? 'active' : '' }}">Đơn hàng của tôi</a>
        </li>
        <li>
            <a href="wish-list.html" class="text-sm link fw-medium my-account-nav-item">My
                Wishlist</a>
        </li>
        <li>
            <a href="account-addresses.html" class="text-sm link fw-medium my-account-nav-item">Addresses</a>
        </li>
        <li>
            <a href="404-3.html" class="text-sm link fw-medium my-account-nav-item">Account Details</a>
        </li>
        <li>
            <a href="{{route('auth.logout')}}" class="text-sm link fw-medium my-account-nav-item">Đăng xuất</a>
        </li>
    </ul>
</div>
