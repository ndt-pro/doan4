<ul class="nav navbar-nav float-right">
    <li class="dropdown dropdown-user nav-item">
        <a class="dropdown-toggle nav-link dropdown-user-link" href="#" data-toggle="dropdown">
            <div class="user-nav d-sm-flex d-none">
                <span class="user-name text-bold-600">{{ Auth::guard('admin')->user()->username }}</span><span class="user-status">{{ Auth::guard('admin')->user()->full_name }}</span>
            </div>
            <span><img class="round" src="admin-assets/app-assets/images/portrait/small/avatar-s-11.jpg" alt="avatar" height="40" width="40" /></span>
        </a>
        <div class="dropdown-menu dropdown-menu-right">
            <a class="dropdown-item" href=""><i class="feather icon-edit"></i> Sửa thông tin</a>
            <a class="dropdown-item" href=""><i class="fa fa-key"></i> Đổi mật khẩu</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="{{ route('admin.logout') }}"><i class="feather icon-power"></i> Đăng xuất</a>
        </div>
    </li>
</ul>