<li><a href="{{ route('index') }}" class="active">Trang chủ</a></li>
<li class="dropdown">
    <a href="#">Sản phẩm <span class="sub-arrow">...</span></a>
    <ul class="dropdown-menu">
        @foreach ($types as $item)
            <li><a href="{{ route('loai.san.pham', ['id'=>$item->id]) }}">{{ $item->name }}</a></li>
        @endforeach
    </ul>
</li>
<li><a href="#">Giới thiệu</a></li>
<li><a href="#">Liên hệ</a></li>
<li><a href="#">Tin tức</a></li>