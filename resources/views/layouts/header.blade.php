<header id="top">
    <div class="container">
        <div class="row">
            <div class="col-menu">
                <i class="fa fa-bars"></i>
            </div>
            <div class="col-5 col-logo">
                <a href="{{ route('index') }}"><img src="assets/image/logo-ndtpro.png" alt="logo" width="200px"></a>
            </div>
            <div class="col-menu-right">
                @if(Auth::check())
                    <a href="giohang.html"><i class="fa fa-shopping-cart"></i></a>
                    <a href="giohang.html"><i class="fa fa-sign-out"></i></a>
                @else
                    <a href="{{ route('login') }}"><i class="fa fa-user-circle-o"></i></a>
                    <a href="giohang.html"><i class="fa fa-shopping-cart"></i></a>
                @endif
            </div>
            <div class="col-7 col-info">
                @if (Route::currentRouteName() != 'cart.list')
                    <div class="cart-info">
                        <a href="{{ route('cart.list') }}">
                            <div class="cart-icon"><i class="fa fa-shopping-cart"></i></div>
                        </a>
                        <div class="cart-count" data-cart="count">0</div>
                        <div class="cart-products">
                            <div data-cart="products">
                                <!-- ds sản phẩm ở đây -->
                            </div>
                            <div class="footer">
                                <div class="row mb-3">
                                    <div class="col-6">
                                        Tổng tiền:
                                    </div>
                                    <div class="col-6 text-right">
                                        <b data-cart="total">0</b>đ
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <a href="{{ route('cart.list') }}" class="btn btn-outline-primary left">Xem giỏ hàng</a>
                                    </div>
                                    <div class="col-6 text-right btn-checkout">
                                        <a href="{{ route('checkout') }}" class="btn btn-outline-danger">Thanh toán</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                <div class="navholder">
                    <nav class="subnav">
                        <ul>
                            @if(Auth::check())
                                <li>Xin chào, <a href="{{ route('index') }}" class="user">{{ Auth::user()->full_name }}</a></li>
                                <li><a href="{{ route('logout') }}">Đăng xuất</a></li>
                            @else
                                <li><i class="fa fa-phone"></i><a href="#">0386420310</a></li>
                                <li><a href="{{ route('register') }}">Đăng ký</a></li>
                                <li><a href="{{ route('login') }}">Đăng nhập</a></li>
                            @endif
                        </ul>
                    </nav>
                    <div class="header_line">
                        <p>Cam kết chỉ bán hàng chính hãng, nói không với replica, fake...</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="header-menu" id="ontop">
        <div class="container">
            <div class="row">
                <div class="navmenu">
                    <!-- MENU IN DESKTOP DEVICE -->
                    <ul>
                        @include('blocks.navmenu')
                    </ul>
                </div>
                <div class="header-search">
                    <form action="{{ route('search') }}" method="get">
                        <input type="text" class="search" name="find" placeholder="Bạn muốn tìm gì?">
                    </form>
                    <i class="fa fa-search"></i>
                    <button><i class="fa fa-search"></i></button>
                </div>
            </div>
        </div>
    </div>
    <div class="sidenav">
        <!-- MENU IN MOBILE DEVICE -->
        <div class="side-menu">
            <div class="side-header">
                MENU
                <span class="close">&times;</span>
            </div>
            <div class="side-body">
                <ul>
                    @if(Auth::check())
                        <li><a href="{{ route('index') }}" class="user">{{ Auth::user()->full_name }}</a></li>
                    @endif
                    @include('blocks.navmenu')
                </ul>
            </div>
            <div class="side-footer">
                <i class="fa fa-commenting-o"></i> Design by Toàn Nguyễn
            </div>
        </div>
    </div>
</header>

<div class="notifications">
    <div data-alert="notifications">
    </div>
    <span class="close">&times;</span>
</div>