
    <div class="main-menu menu-fixed menu-light menu-accordion menu-shadow" data-scroll-to-active="true">
        <div class="navbar-header">
            <ul class="nav navbar-nav flex-row">
                <li class="nav-item mr-auto"><a class="navbar-brand" href="{{ route('admin.index') }}">
                        <div class="brand-logo"></div>
                        <h2 class="brand-text mb-0">NDT</h2>
                    </a></li>
                <li class="nav-item nav-toggle"><a class="nav-link modern-nav-toggle pr-0" data-toggle="collapse"><i class="feather icon-x d-block d-xl-none font-medium-4 primary toggle-icon"></i><i class="toggle-icon feather icon-disc font-medium-4 d-none d-xl-block collapse-toggle-icon primary" data-ticon="icon-disc"></i></a></li>
            </ul>
        </div>
        <div class="shadow-bottom"></div>
        <div class="main-menu-content">
            <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
                <li class="nav-item">
                    <a href="{{ route('admin.index') }}" route-name="admin.index"><i class="feather icon-home"></i><span class="menu-title">Bảng điều khiển</span></a>
                </li>
                <li class="navigation-header">
                    <span>ADMIN SHOP</span>
                </li>
                <li class="nav-item">
                    <a href="#"><i class="feather icon-shopping-cart"></i><span class="menu-title">Quản lý đơn hàng</span></a>
                    <ul class="menu-content">
                        <li>
                            <a href="{{ route('bill.new') }}" route-name="bill.new">
                                <i class="feather icon-circle"></i><span class="menu-item">Đơn hàng mới</span>
                                @if ($new_bills)
                                    <span class="badge badge badge-success badge-pill float-right mr-2">{{ $new_bills }}</span>
                                @endif
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('bill.index') }}" route-name="bill.index"><i class="feather icon-circle"></i><span class="menu-item">Tất cả đơn hàng</span></a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="#"><i class="feather icon-folder"></i><span class="menu-title">Danh mục & sản phẩm</span></a>
                    <ul class="menu-content">
                        <li>
                            <a href="{{ route('products-type.index') }}" route-name="products-type.index"><i class="feather icon-circle"></i><span class="menu-item">Quản lý danh mục</span></a>
                        </li>
                        <li>
                            <a href="{{ route('products.index') }}" route-name="products.index"><i class="feather icon-circle"></i><span class="menu-item">Quản lý sản phẩm</span></a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="{{ route('users.index') }}" route-name="users.index"><i class="feather icon-user"></i><span class="menu-title">Quản lý người dùng</span></a>
                </li>
                <li class="navigation-header">
                    <span>CẤU HÌNH</span>
                </li>
                <li class="nav-item">
                    <a href="{{ route('slideshow.index') }}" route-name="slideshow.index"><i class="feather icon-image"></i><span class="menu-title">Cấu hình quảng cáo</span></a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('brand.index') }}" route-name="brand.index"><i class="feather icon-package"></i><span class="menu-title">Cấu hình nhãn hiệu</span></a>
                </li>
            </ul>
        </div>
    </div>