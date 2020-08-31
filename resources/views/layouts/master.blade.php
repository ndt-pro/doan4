<!-- Author NDTPRO -->

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="_token" content="{{ csrf_token() }}">
    <title>Cửa hàng bán giày chính hãng NDT Sneaker</title>
    <base href="{{ asset('') }}">

    <link rel="shortcut icon" href="assets/image/favicon.png" type="image/x-icon">

    <!-- font -->
    <link href="https://fonts.googleapis.com/css2?family=Work+Sans:wght@400;500;700&display=swap" rel="stylesheet">

    <!-- css -->
    <link rel="stylesheet" href="assets/vendor/font-awesome-4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/box.css">

    <!-- olw-carousel plugins -->
    <link rel="stylesheet" href="assets/vendor/owl-carousel/owl.carousel.min.css">
    <link rel="stylesheet" href="assets/vendor/owl-carousel/owl.theme.default.min.css">
    <link rel="stylesheet" href="assets/vendor/owl-carousel/animate.css">

    <!-- toastr css -->
    <link rel="stylesheet" href="assets/vendor/toastr/css/toastr.css">

    @yield('style')
</head>

<body>
    @include('layouts.header')

    <section class="container">
        @yield('content')
    </section>

    @include('layouts.footer')
</body>


<!-- jquery script -->
<script src="assets/vendor/jquery-3.5.0/jquery-3.5.0.min.js"></script>
<script src="assets/vendor/toastr/js/toastr.min.js"></script>

<script src="assets/vendor/owl-carousel/owl.carousel.min.js"></script>

<!-- other script -->
<script src="assets/js/plugin.js"></script>
<script src="assets/js/ndtpro.js"></script>
@if (Route::currentRouteName() != 'cart.list')
    <script src="assets/js/cart.js"></script>
@endif
<script src="assets/js/slideshow.js"></script>

@yield('script')

</html>