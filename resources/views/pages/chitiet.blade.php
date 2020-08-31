
@extends('layouts.master')

@section('content')

<div class="row">
    <div class="col-3 p-3">
        @include('blocks.category')
    </div>
    <div class="col-4 p-3">
        <div class="gallery">
            <div class="image-view">
            <img src="{{ $product->getLinkImage().$product->product_image[0]->image }}" alt="">
            </div>
            <div class="image-list" data-role="select-image">
                @foreach ($product->product_image as $item)
                    <img src="{{ $product->getLinkImage().$item->image }}" alt="" class="{{ $item ==  $product->product_image[0] ? 'active' : ''}}">
                @endforeach
            </div>
        </div>
    </div>
    <form onsubmit="return quickView(this)" method="post">
        <input type="hidden" name="id" value="{{ $product->id }}">
        <div class="col-5 p-3">
            @if ($product->quantity == 0)
            <div class="alert alert-danger"><strong>Xin lỗi!</strong> Hiện tại sản phẩm này của cửa hàng đã hết. Mời bạn quay lại sau</div>
            @endif

            <div class="product-title">
                {{ $product->name }}
                <p>Mã sản phẩm: #{{ $product->id }} </p>
            </div>
            <div class="product-price">
                {{ number_format($product->price) }}đ
            </div>
            <div class="product-description">
                {!! $product->description !!}
            </div>

            @if ($product->colors != "[]")
            <div class="product-option">
                Chọn màu:
                <div class="list-color">   
                    @foreach (json_decode($product->colors) as $item)
                        <label class="custom-radio"> 
                            <input type="radio" name="color" value="{{ $item->value }}" {{ $item == json_decode($product->colors)[0] ? 'checked' : '' }}>
                            <span class="checkmark" style="background-color: {{ $item->value }};"></span>
                        </label>
                    @endforeach
                </div>
            </div>
            @endif
            
            @if ($product->sizes != "[]")
            <div class="product-option">
                <p>Chọn kích cỡ:</p>
                <select name="size" class="form-control form-md">
                    @foreach (json_decode($product->sizes) as $item)
                        <option value="{{ $item }}">{{ $item }}</option>
                    @endforeach
                </select>
            </div>
            @endif

            @if ($product->quantity > 0)
            <div class="product-option">
                <p>Số lượng:</p>
                <input type="number" name="quantity" value="1" class="form-control form-sm" min="1" max="{{ $product->quantity }}">
            </div>
            <div class="row mt-3">
                <div class="col-6">
                    <button type="submit" name="submit" class="btn btn-warning btn-block btn-icon" data-modal="openModal">
                        <i class="fa fa-cart-plus"></i>
                        <span>Thêm vào giỏ</span>
                    </button>
                </div>
                <div class="col-6">
                    <button type="button" class="btn btn-success btn-block btn-icon ml-3" data-modal="openQRCodeView">
                        <i class="fa fa-qrcode"></i>
                        <span>Xem QR Code</span>
                    </button>
                </div>
            </div>
            @endif
        </div>
    </form>
</div>

<div class="title-line title-left">
    <h3>Sản phẩm liên quan</h3>
    <div class="line line-left"></div>
</div>

<div class="row list-products">
    @foreach ($products_similar as $product)
    <div class="col-3">
        <div class="product-card">
            <div class="product-image">
                <img src="{{ $product->getLinkImage().$product->product_image[0]->image }}" alt="..." class="first-image">
                @if (isset($product->product_image[1]))
                    <img src="{{ $product->getLinkImage().$product->product_image[1]->image }}" alt="..." class="second-image">
                @else
                    <img src="{{ $product->getLinkImage().$product->product_image[0]->image }}" alt="..." class="second-image">
                @endif
                <div class="action">
                    <a href="#" data-cart="add" data-id="{{ $product->id }}"><i class="fa fa-cart-plus"></i></a>
                    <a href="#" data-view="quick-view" data-id="{{ $product->id }}"><i class="fa fa-eye"></i></a>
                </div>
            </div>
            <div class="product-content">
                <a href="{{ route("chi.tiet.san.pham", [$product->id, $product->getLink()]) }}">{{ $product->name }}</a>
                <p>{{ number_format($product->price) }}đ</p>
            </div>
        </div>
    </div>
    @endforeach
</div>

{{-- modal --}}
@include('blocks.quickview')

<div id="QRCodeViewModal" class="modal">
    <div class="modal-content modal-sm">
        <div class="modal-header">
            <span class="close">&times;</span>
            <h3>Xem QR Code</h3>
        </div>
        <div class="modal-body">
            <div class="row text-center">
                <p>Quét mã QR Code để chia sẻ cho các thiết bị khác</p>
                
                {!! $qrCode !!}
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    $("[data-role=select-image] img").click(function() {
        $(".image-view>img").attr("src", $(this).attr("src"));
        $("[data-role=select-image] img").removeClass("active");
        $(this).addClass("active");
    });

    $("[data-modal='openQRCodeView']").click(function() {
        $('#QRCodeViewModal').show();
    });
</script>
@endsection