<!DOCTYPE html>
<html lang="en">


<!-- Mirrored from techzaa.in/larkon/admin/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 26 Apr 2025 18:02:31 GMT -->
<head>
     <!-- Title Meta -->
     <meta charset="utf-8" />
     <title>Dashboard | Larkon - Responsive Admin Dashboard Template</title>
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <meta name="description" content="A fully responsive premium admin dashboard template" />
     <meta name="author" content="Techzaa" />
     <meta http-equiv="X-UA-Compatible" content="IE=edge" />

     <!-- App favicon -->
     <link rel="shortcut icon" href="{{ asset('admin/assets/images/favicon.ico') }}">

     <!-- Vendor css (Require in all Page) -->
     <link href="{{ asset('admin/assets/css/vendor.min.css') }}" rel="stylesheet" type="text/css" />

     <!-- Icons css (Require in all Page) -->
     <link href="{{ asset('admin/assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />

     <!-- App css (Require in all Page) -->
     <link href="{{ asset('admin/assets/css/app.min.css') }}" rel="stylesheet" type="text/css" />

     <!-- Theme Config js (Require in all Page) -->
     <script src="{{ asset('admin/assets/js/config.js') }}"></script>
     <link href="{{ asset('admin/assets/css/custom_image_upload.css') }}" rel="stylesheet" type="text/css" />
</head>

<body>

     <!-- START Wrapper -->
     <div class="wrapper">

          <!-- ========== Topbar Start ========== -->
          @include('admin.layouts.header')

        

          <!-- Right Sidebar (Theme Settings) -->
          
          @include('admin.layouts.rightbar')
          <!-- ========== Topbar End ========== -->

          <!-- ========== App Menu Start ========== -->
          @include('admin.layouts.sidebar')
          <!-- ========== App Menu End ========== -->

          <!-- ==================================================== -->
          <!-- Start right Content here -->
          <!-- ==================================================== -->
          <div class="page-content">

               <!-- Start Container Fluid -->
               @yield('content')
               <!-- End Container Fluid -->

               <!-- ========== Footer Start ========== -->
              @include('admin.layouts.footer')
               <!-- ========== Footer End ========== -->

          </div>
          <!-- ==================================================== -->
          <!-- End Page Content -->
          <!-- ==================================================== -->

     </div>
     <!-- END Wrapper -->

     <!-- Vendor Javascript (Require in all Page) -->
     <script src="{{ asset('admin/assets/js/vendor.js') }}"></script>

     <!-- App Javascript (Require in all Page) -->
     <script src="{{ asset('admin/assets/js/app.js') }}"></script>

     <!-- Vector Map Js -->
     <script src="{{ asset('admin/assets/vendor/jsvectormap/js/jsvectormap.min.js') }}"></script>
     <script src="{{ asset('admin/assets/vendor/jsvectormap/maps/world-merc.js') }}"></script>
     <script src="{{ asset('admin/assets/vendor/jsvectormap/maps/world.js') }}"></script>

     <!-- Dashboard Js -->
     <script src="{{ asset('admin/assets/js/pages/dashboard.js') }}"></script>
     <script src="{{ asset('admin/assets/js/custom_image_upload.js') }}"></script>
     @yield('scripts')
     
</body>


<!-- Mirrored from techzaa.in/larkon/admin/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 26 Apr 2025 18:03:22 GMT -->
</html>