<div class="nav-menu">
    <div class="nav-menu-title">
        <div class="title-line title-left title-sm">
            Danh mục
            <div class="line line-left"></div>
        </div>
    </div>
    <ul>
        @foreach ($types as $item)
            <li>
                <a href="{{ route('loai.san.pham', ['id'=>$item->id]) }}">{{ $item->name }}</a>
            </li>
        @endforeach
    </ul>
</div>