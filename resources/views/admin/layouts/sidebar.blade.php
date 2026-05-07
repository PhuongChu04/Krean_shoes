 <div class="main-nav">
     <!-- Sidebar Logo -->

     <div class="logo-box">
         <a href="index.html" class="logo-dark">
             <img src="{{ asset('admin/assets/images/1.png') }}" class="logo-sm" alt="logo sm">
             {{-- <img src="assets/images/logo-dark.png" class="logo-lg" alt="logo dark"> --}}
         </a>

         <a href="index.html" class="logo-light">
             <img src="{{ asset('admin/assets/images/1.png') }}" class="logo-sm" alt="logo sm">
             {{-- <img src="{{asset('admin/assets/images/1.png')}}" class="logo-lg" alt="logo light"> --}}
         </a>
     </div>
     {{--  --}}
     <div class="logo-box">
         <a href="index.html" class="logo-dark">
             <img src="{{ asset('admin/assets/images/1.png') }}" class="logo-lg" alt="logo">
         </a>

         <a href="index.html" class="logo-light">
             <img src="{{ asset('admin/assets/images/1.png') }}" class="logo-lg" alt="logo">
         </a>
     </div>

     <!-- Menu Toggle Button (sm-hover) -->
     <button type="button" class="button-sm-hover" aria-label="Show Full Sidebar">
         <iconify-icon icon="solar:double-alt-arrow-right-bold-duotone" class="button-sm-hover-icon"></iconify-icon>
     </button>

     <div class="scrollbar" data-simplebar>
         <ul class="navbar-nav" id="navbar-nav">

             <li class="menu-title">General</li>

             <li class="nav-item">
                 <a class="nav-link" href="{{ route('admin.homeAdmin') }}">
                     <span class="nav-icon">
                         <iconify-icon icon="solar:widget-5-bold-duotone"></iconify-icon>
                     </span>
                     <span class="nav-text"> Dashboard </span>
                 </a>
             </li>

             <li class="nav-item">
                 <a class="nav-link menu-arrow" href="#sidebarOrders" data-bs-toggle="collapse" role="button"
                     aria-expanded="false" aria-controls="sidebarOrders">
                     <span class="nav-icon">
                         <iconify-icon icon="solar:users-group-rounded-bold-duotone"></iconify-icon>
                     </span>
                     <span class="nav-text"> Accounts </span>
                 </a>
                 <div class="collapse" id="sidebarOrders">
                     <ul class="nav sub-navbar-nav">
                         <li class="sub-nav-item">
                             <a class="sub-nav-link" href="{{ route('admin.account.listAdmins') }}">Admins</a>
                         </li>
                         <li class="sub-nav-item">
                             <a class="sub-nav-link" href="{{ route('admin.account.listUsers') }}">Users</a>
                         </li>
                     </ul>
                 </div>
             </li>

             <li class="nav-item">
                 <a class="nav-link" href="{{ route('admin.list') }}">
                     <span class="nav-icon">
                         <iconify-icon icon="solar:clipboard-list-bold-duotone"></iconify-icon>
                     </span>
                     <span class="nav-text"> Danh mục </span>
                 </a>
             </li>

             <li class="nav-item">
                 <a class="nav-link" href="{{ route('admin.listProduct') }}">
                     <span class="nav-icon">
                         <iconify-icon icon="solar:t-shirt-bold-duotone"></iconify-icon>
                     </span>
                     <span class="nav-text"> Sản phẩm </span>
                 </a>
             </li>

             <li class="nav-item">
                 <a class="nav-link" href="{{ route('admin.order.index') }}">
                     <span class="nav-icon">
                         <iconify-icon icon="solar:bag-smile-bold-duotone"></iconify-icon>
                     </span>
                     <span class="nav-text"> Đơn hàng </span>
                 </a>
             </li>

             <li class="nav-item">
                 <a class="nav-link" href="{{ route('admin.sizes.index') }}">
                     <span class="nav-icon">
                         <iconify-icon icon="solar:ruler-bold-duotone"></iconify-icon>
                     </span>
                     <span class="nav-text"> Kích thước </span>
                 </a>
             </li>
             <li class="nav-item">
                 <a class="nav-link" href="{{ route('admin.brands.index') }}">
                     <span class="nav-icon">
                         <iconify-icon icon="solar:ruler-bold-duotone"></iconify-icon>
                     </span>
                     <span class="nav-text"> Thương hiệu </span>
                 </a>
             </li>
             <li class="nav-item">
                 <a class="nav-link" href="{{ route('admin.vouchers.index') }}">
                     <span class="nav-icon">
                         <iconify-icon icon="solar:ticket-sale-bold-duotone"></iconify-icon>
                     </span>
                     <span class="nav-text"> Vouchers </span>
                 </a>
             </li>
             <li class="nav-item">
                 <a class="nav-link" href="{{ route('admin.color.listColor') }}">
                     <span class="nav-icon">
                         <iconify-icon icon="solar:palette-round-bold-duotone" style="color: #C0C0C0;"></iconify-icon>
                     </span>
                     <span class="nav-text">Màu sắc</span>
                 </a>
             </li>



             <li class="nav-item">
                 <a class="nav-link" href="{{ route('admin.blog_categories.index') }}">
                     <span class="nav-icon">
                         <iconify-icon icon="solar:folder-with-files-bold-duotone"></iconify-icon>
                     </span>
                     <span class="nav-text"> Danh mục bài viết </span>
                 </a>
             </li>

             <li class="nav-item">
                 <a class="nav-link" href="{{ route('admin.blogs.index') }}">
                     <span class="nav-icon">
                         <iconify-icon icon="solar:document-text-bold-duotone"></iconify-icon>
                     </span>
                     <span class="nav-text"> Bài viết </span>
                 </a>
             </li>

             <li class="nav-item">
                 <a class="nav-link" href="{{ route('admin.banners.index') }}">
                     <span class="nav-icon">
                         <iconify-icon icon="solar:gallery-wide-bold-duotone"></iconify-icon>
                     </span>
                     <span class="nav-text"> Banner </span>
                 </a>
             </li>
             <li class="nav-item">
                 <a class="nav-link" href="{{ route('admin.account.comments.index') }}">
                     <span class="nav-icon">
                         <iconify-icon icon="solar:chat-round-bold-duotone"></iconify-icon>
                     </span>
                     <span class="nav-text"> Bình luận </span>
                 </a>
             </li>
             <li class="nav-item">
                 <a class="nav-link" href="{{ route('admin.review') }}">
                     <span class="nav-icon">
                         <iconify-icon icon="solar:star-bold-duotone"></iconify-icon>
                     </span>
                     <span class="nav-text"> Đánh giá </span>
                 </a>
             </li>
             <li class="nav-item">
                 <a class="nav-link" href="{{ route('admin.account.webinfor') }}">
                     <span class="nav-icon">
                         <iconify-icon icon="solar:info-circle-bold-duotone"></iconify-icon>
                     </span>
                     <span class="nav-text"> Webinfor </span>
                 </a>
             </li>
         </ul>
     </div>
 </div>
