@extends('layouts.master')

@section('content')

<!-- slideshow -->
<div class="owl-carousel owl-theme" id="slideshow">
    @foreach ($slideshows as $item)
        <div class="item">
            <a href="{{ $item->url }}" target="_blank"><img src="storage/slideshow/{{ $item->image }}" alt="..."></a>
        </div>
    @endforeach
</div>

<!-- content -->
<div class="title-line">
    <h1>Sản phẩm mới</h1>
    <div class="line"></div>
</div>

<div class="row list-product">
    <!-- ds sản phẩm nổi bật ở đây -->
    <div class="owl-carousel owl-theme" id="hot-products">
        @foreach ($new_products as $product)
        <div class="item">
            <div class="product-card">
                <div class="product-image">
                    <img src="{{ $product->getLinkImage().$product->product_image[0]->image }}" alt="...">
                </div>
                <div class="product-content">
                    <a href="{{ route("chi.tiet.san.pham", [$product->id, $product->getLink()]) }}">{{ $product->name }}</a>
                    <p>{{ number_format($product->price) }}đ</p>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

<div class="row text-center mt-3 mb-3">
    <a href="#" class="btn btn-small btn-shadow btn-outline-primary">Xem thêm</a>
</div>

<div class="row line"></div>

<div class="title-line">
    <h1>Sản phẩm khác</h1>
    <div class="line"></div>
</div>

<div class="row list-products">
    <!-- ds sản phẩm bán chạy ở đây -->
    @foreach ($products as $product)
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

<div class="row text-center mt-3 mb-3">
    <a href="#" class="btn btn-small btn-shadow btn-outline-primary">Xem thêm</a>
</div>

<div class="row line"></div>

<div class="title-line">
    Chúng tôi hợp tác với
    <div class="line"></div>
</div>

<div class="row">
    <div class="col-12">
        <!-- brands -->
        <div class="owl-carousel owl-theme" id="brands">
            @foreach ($brands as $item)
                <div class="item">
                    <img src="storage/brand/{{ $item->image }}" alt="...">
                </div>
            @endforeach
        </div>
    </div>
</div>

{{-- modal --}}
@include('blocks.quickview')
@endsection