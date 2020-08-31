
@extends('layouts.master')

@section('content')

<div class="row">
    <div class="col-3 p-3">
        <div class="row">
            <div class="col-12">
                @include('blocks.category')
            </div>
            <div class="col-12">
                <div class="info-column">
                    <img src="storage/products-type/{{ $products_type->logo }}" alt="{{ $products_type->name }}">
                    <div class="content">{{ $products_type->description }}</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-9 p-3">
        <div class="title-line title-left title-sm">
            <b style="font-size: 18px;">{{ $products_type->name }}</b> ({{ $count }} sản phẩm)
            <div class="line line-left"></div>
        </div>

        <div class="row list-products">
            @forelse ($products as $product)
                <div class="col-4">
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
            @empty
                <div class="alert alert-danger">
                    <strong>Hết hàng!</strong> Hiện tại loại sản phẩm này đã hết hàng.
                </div>
            @endforelse
            
            @if ($count > 0)
                <div class="col-12">
                    {{ $products->links() }}
                </div>
            @endif
        </div>
    </div>
</div>

{{-- modal --}}
@include('blocks.quickview')
@endsection