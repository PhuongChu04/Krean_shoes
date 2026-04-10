 <div class="main-nav">
     <!-- Sidebar Logo -->
    
     <div class="logo-box">
         <a href="index.html" class="logo-dark">
             <img src="{{asset('admin/assets/images/1.png')}}" class="logo-sm" alt="logo sm">
             {{-- <img src="assets/images/logo-dark.png" class="logo-lg" alt="logo dark"> --}}
         </a>

         <a href="index.html" class="logo-light">
             <img src="{{asset('admin/assets/images/1.png')}}" class="logo-sm" alt="logo sm" >
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
                 <a class="nav-link" href="{{route('admin.homeAdmin')}}">
                     <span class="nav-icon">
                         <iconify-icon icon="solar:widget-5-bold-duotone"></iconify-icon>
                     </span>
                     <span class="nav-text"> Dashboard </span>
                 </a>
             </li>

             

            
             <li class="nav-item">
                 <a class="nav-link" href="{{ route('admin.listProduct') }}">
                     <span class="nav-icon">
                        <iconify-icon icon="solar:t-shirt-bold-duotone"></iconify-icon>
                     </span>
                     <span class="nav-text"> Product </span>
                 </a>
             </li>
              
             <li class="nav-item">
                 <a class="nav-link" href="{{ route('admin.list') }}">
                     <span class="nav-icon">
                        <iconify-icon icon="solar:clipboard-list-bold-duotone"></iconify-icon>
                     </span>
                     <span class="nav-text"> Category </span>
                 </a>
             </li>

             <li class="nav-item">
                 <a class="nav-link" href="{{ route('admin.sizes.index') }}">
                     <span class="nav-icon">
                         <iconify-icon icon="solar:ruler-bold-duotone"></iconify-icon>
                     </span>
                     <span class="nav-text"> Sizes </span>
                 </a>
             </li>
             <li class="nav-item">
                 <a class="nav-link" href="{{ route('admin.brands.index') }}">
                     <span class="nav-icon">
                         <iconify-icon icon="solar:ruler-bold-duotone"></iconify-icon>
                     </span>
                     <span class="nav-text"> Brands </span>
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
                     <span class="nav-text">Color</span>
                 </a>
             </li>

        

             <li class="nav-item">
                 <a class="nav-link" href="{{ route('admin.order.index') }}">
                     <span class="nav-icon">
                         <iconify-icon icon="solar:bag-smile-bold-duotone"></iconify-icon>
                     </span>
                     <span class="nav-text"> Order </span>
                 </a>
             </li>
             <li class="nav-item">
                 <a class="nav-link" href="{{ route('admin.review') }}">
                     <span class="nav-icon">
                         <iconify-icon icon="solar:chat-square-like-bold-duotone"></iconify-icon>
                     </span>
                     <span class="nav-text"> Evaluate </span>
                 </a>
             </li>
     




         </ul>
     </div>
 </div>
