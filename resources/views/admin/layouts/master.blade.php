<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
   <!-- BEGIN: Head-->
   <head>
      <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
      <meta http-equiv="X-UA-Compatible" content="IE=edge" />
      <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui" />
      <meta name="author" content="NDTPRO" />
      <title>Trang quản trị - NDT Sneaker</title>
      <base href="{{ asset('') }}">
      <meta name="_token" content="{{ csrf_token() }}">
      <meta name="_route" content="{{ Route::currentRouteName() }}">
      <link rel="apple-touch-icon" href="admin-assets/assets/images/favicon.icog" />
      <link rel="shortcut icon" type="image/x-icon" href="admin-assets/assets/images/favicon.ico" />
      <link href="https://fonts.googleapis.com/css?family=Montserrat:300,400,500,600" rel="stylesheet" />
      <!-- BEGIN: Vendor CSS-->
      <link rel="stylesheet" type="text/css" href="admin-assets/app-assets/vendors/css/vendors.min.css" />
      <link rel="stylesheet" type="text/css" href="admin-assets/app-assets/vendors/css/charts/apexcharts.css" />
      <link rel="stylesheet" type="text/css" href="admin-assets/app-assets/vendors/css/extensions/tether-theme-arrows.css" />
      <link rel="stylesheet" type="text/css" href="admin-assets/app-assets/vendors/css/extensions/tether.min.css" />
      <link rel="stylesheet" type="text/css" href="admin-assets/app-assets/vendors/css/extensions/shepherd-theme-default.css" />
      <link rel="stylesheet" type="text/css" href="admin-assets/DataTables-1.10.20/css/dataTables.bootstrap4.css">
      <link rel="stylesheet" type="text/css" href="admin-assets/app-assets/vendors/css/extensions/toastr.css">
      <!-- END: Vendor CSS-->
      <!-- BEGIN: Theme CSS-->
      <link rel="stylesheet" type="text/css" href="admin-assets/app-assets/css/bootstrap.css" />
      <link rel="stylesheet" type="text/css" href="admin-assets/app-assets/css/bootstrap-extended.css" />
      <link rel="stylesheet" type="text/css" href="admin-assets/app-assets/css/colors.css" />
      <link rel="stylesheet" type="text/css" href="admin-assets/app-assets/css/components.css" />
      <link rel="stylesheet" type="text/css" href="admin-assets/app-assets/css/themes/dark-layout.css" />
      <link rel="stylesheet" type="text/css" href="admin-assets/app-assets/css/themes/semi-dark-layout.css" />
      <!-- BEGIN: Page CSS-->
      <link rel="stylesheet" type="text/css" href="admin-assets/app-assets/css/core/menu/menu-types/vertical-menu.css" />
      <link rel="stylesheet" type="text/css" href="admin-assets/app-assets/css/core/colors/palette-gradient.css" />
      <link rel="stylesheet" type="text/css" href="admin-assets/app-assets/vendors/css/extensions/sweetalert2.min.css">
      <link rel="stylesheet" type="text/css" href="admin-assets/app-assets/css/plugins/extensions/toastr.css">
      <!-- END: Page CSS-->
      <!-- BEGIN: Custom CSS-->
      <link rel="stylesheet" type="text/css" href="admin-assets/assets/css/style.css" />
      <!-- END: Custom CSS-->
      
      @yield('style')
   </head>
   <!-- END: Head-->
   <!-- BEGIN: Body-->
   <body class="vertical-layout vertical-menu-modern 2-columns navbar-floating footer-static menu-collapsed" data-open="click" data-menu="vertical-menu-modern" data-col="2-columns">
   <div class="loading_page">
      <div class="lds-roller"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>
   </div>
      <!-- BEGIN: Header-->
      <nav class="header-navbar navbar-expand-lg navbar navbar-with-menu floating-nav navbar-light navbar-shadow">
         <div class="navbar-wrapper">
            <div class="navbar-container content">
               <div class="navbar-collapse" id="navbar-mobile">
                  <div class="mr-auto float-left bookmark-wrapper d-flex align-items-center">
                     <ul class="nav navbar-nav">
                        <li class="nav-item mobile-menu d-xl-none mr-auto">
                           <a class="nav-link nav-menu-main menu-toggle hidden-xs" href="#"><i
                              class="ficon feather icon-menu"></i></a>
                        </li>
                     </ul>
                  </div>
                  @include('admin.blocks.user_menu')
               </div>
            </div>
         </div>
      </nav>
      <!-- END: Header-->
      <!-- BEGIN: Main Menu-->
      @include('admin.blocks.main_menu')
      <!-- END: Main Menu-->
      <!-- BEGIN: Content-->
      <div class="app-content content">
         <div class="content-overlay"></div>
         <div class="header-navbar-shadow"></div>
         <div class="content-wrapper">
            <div class="content-header row"></div>
            <div class="content-body">
               <!-- Dashboard Start -->
               <section id="dashboard-analytics">
                  @include('admin.blocks.statistic')
                  
                  @yield('content')
               </section>
               <!-- Dashboard end -->
            </div>
         </div>
      </div>
      <!-- END: Content-->
      <div class="sidenav-overlay"></div>
      <div class="drag-target"></div>
      <!-- BEGIN: Footer-->
      <footer class="footer footer-static footer-light">
         <p class="clearfix blue-grey lighten-2 mb-0">
            <span class="float-md-left d-block d-md-inline-block mt-25">COPYRIGHT &copy; 2020
               <a class="text-bold-800 grey darken-2" href="https://facebook.com/ndtpro.99" target="_blank">Toàn Nguyễn</a>
            </span>
            <button class="btn btn-primary btn-icon scroll-top" type="button">
            <i class="feather icon-arrow-up"></i>
            </button>
         </p>
      </footer>
      <!-- END: Footer-->
      <!-- BEGIN: Vendor JS-->
      <script src="admin-assets/app-assets/vendors/js/vendors.min.js"></script>
      <!-- BEGIN Vendor JS-->
      <!-- BEGIN: Page Vendor JS-->
      <script src="admin-assets/app-assets/vendors/js/charts/apexcharts.min.js"></script>
      <script src="admin-assets/app-assets/vendors/js/extensions/tether.min.js"></script>
      <script src="admin-assets/app-assets/vendors/js/extensions/shepherd.min.js"></script>
      <!-- END: Page Vendor JS-->
      <!-- BEGIN: Theme JS-->
      <script src="admin-assets/app-assets/js/core/app-menu.js"></script>
      <script src="admin-assets/app-assets/js/core/app.js"></script>
      <script src="admin-assets/app-assets/js/scripts/components.js"></script>
      <!-- END: Theme JS-->
      
      <!-- BEGIN: DataTables JS -->
      <script src="admin-assets/DataTables-1.10.20/js/jquery.dataTables.min.js"></script>
      <script src="admin-assets/DataTables-1.10.20/js/dataTables.bootstrap4.js"></script>
      <!-- END: DataTables JS-->

      <!-- BEGIN: Toastr JS -->
      <script src="admin-assets/app-assets/vendors/js/extensions/toastr.min.js"></script>
      <!-- END: Toastr JS-->

      <!-- BEGIN: SweetAlert JS -->
      <script src="admin-assets/app-assets/vendors/js/extensions/sweetalert2.all.min.js"></script>
      <script src="admin-assets/app-assets/vendors/js/extensions/polyfill.min.js"></script>
      <!-- END: SweetAlert JS-->

      <!-- BEGIN: NDTpro JS-->
      <script src="admin-assets/assets/js/scripts.js"></script>

      @yield('script')
   </body>
   <!-- END: Body-->
</html>