<div class="modal-body">
    <div class="row mb-2">
        <div class="col-xl-12 list-image">
            @foreach ($product->product_image as $item)
                <img src="{{ $product->getLinkImage().$item->image }}" alt=".">
            @endforeach
        </div>
    </div>
    <div class="row mb-2">
        <div class="col-md-4">
            Tên sản phẩm:
        </div>
        <div class="col-md-8">
            {{ $product->name }}
        </div>
    </div>
    <div class="row mb-2">
        <div class="col-md-4">
            Loại sản phẩm:
        </div>
        <div class="col-md-8">
            {{ $product->product_type->name }}
        </div>
    </div>
    <div class="row mb-2">
        <div class="col-md-4">
            Mô tả:
        </div>
        <div class="col-md-8">
            {!! $product->description !!}
        </div>
    </div>
    <div class="row mb-2">
        <div class="col-md-4">
            Số lượng:
        </div>
        <div class="col-md-8">
            {{ number_format($product->quantity) }}
        </div>
    </div>
    <div class="row mb-2">
        <div class="col-md-4">
            Đơn giá:
        </div>
        <div class="col-md-8">
            {{ number_format($product->price) }}đ
        </div>
    </div>
    <div class="row mb-2">
        <div class="col-md-4">
            Màu sắc:
        </div>
        <div class="col-md-8">
            @foreach (json_decode($product->colors) as $item)
                <span class="dot" style="background-color: {{ $item->value }}"></span>
            @endforeach
        </div>
    </div>
    <div class="row mb-2">
        <div class="col-md-4">
            Size:
        </div>
        <div class="col-md-8">
            @foreach (json_decode($product->sizes) as $item)
                <span class="badge badge-pill badge-primary">{{ $item }}</span>
            @endforeach
        </div>
    </div>
    <div class="row mb-2">
        <div class="col-md-4">
            Ngày thêm:
        </div>
        <div class="col-md-8">
            {{ date("H:i:s d/m/Y", strtotime($product->created_at)) }}
        </div>
    </div>
    <div class="row mb-2">
        <div class="col-md-4">
            Cập nhật lần cuối:
        </div>
        <div class="col-md-8">
            {{ date("H:i:s d/m/Y", strtotime($product->updated_at)) }}
        </div>
    </div>
</div>
<div class="modal-footer">
    <a href="{{ route("chi.tiet.san.pham", [$product->id, $product->getLink()]) }}" class="btn btn-primary" target="_blank">Xem tại trang chủ</a>
</div>