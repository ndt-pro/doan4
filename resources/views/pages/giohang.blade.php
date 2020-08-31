
@extends('layouts.master')

@section('content')

<div class="row">
    <div class="title-line title-left title-sm">
        Giỏ hàng
        <div class="line line-left"></div>
    </div>

    <table class="table">
        <tr>
            <th id="image">Hình ảnh</th>
            <th id="name">Tên sản phẩm</th>
            <th id="quantity">Số lượng</th>
            <th id="price">Giá tiền</th>
            <th id="action">#</th>
        </tr>
        <tbody data-cart="products">
            
        </tbody>
    </table>

    <div class="col-12 text-right">
        <a href="{{ route('index') }}" class="btn btn-warning">Tiếp tục mua hàng</a>
        <a href="{{ route('checkout') }}" class="btn btn-success btn-checkout">Đặt hàng</a>
    </div>
</div>

@endsection

@section('script')
<script>
    $.get('/gio-hang/get', function(data, status) {
        if (status == 'success') load(data);
    });

    function load(cart) {
        let list = $("[data-cart='products']");
        list.html("");

        let products = cart['cart'];

        $.each(products, function(id, prod) {
            list.append('<tr>\
                <td id="image">\
                    <img src="' + prod.image + '" alt="">\
                </td>\
                <td id="name">\
                    <a href="' + prod.link + '">' + prod.name + '</a>\
                    <p><i>Size: ' + prod.size + ' / ' + prod.color.name + '</i></p>\
                </td>\
                <td id="quantity">\
                    <input type="number" class="form-control" value="' + prod.quantity + '" min="1" max="99" onchange="changeQty(this, ' + id + ')">\
                </td>\
                <td id="price">' + formatNumber(prod.price) + 'đ</td>\
                <td id="action">\
                    <button class="btn btn-danger" onclick="removeCart(this, ' + id + ')">Xóa</button>\
                </td>\
            </tr>');
        });

        if(cart['count'] == 0) {
            list.append('<tr><td colspan="5" class="text-center">Không có sản phẩm nào trong giỏ hàng</td></tr>');
            $('.btn-checkout').hide();
        } else {
            $('.btn-checkout').show();
        }

        list.append('<tr>\
            <td colspan="2"></td>\
            <td id="quantity"><b>Tổng cộng:</b></td>\
            <td id="price"><b>' + formatNumber(cart['total']) + 'đ</b></td>\
        </tr>');
    }

    function removeCart(e, id) {
        let t = $(e);

        let cur_html = t.html();

        t.html(loading);

        $.get('/gio-hang/remove', { id: id }, function(data, status) {
            if (status == 'success' && data.status != 'error') {
                load(data);
                toastr.success('Đã xóa sản phẩm khỏi giỏ hàng!', 'Thành công', { "closeButton": true });
            } else {
                toastr.warning('Có lỗi xảy ra!', 'Thất bại', { "closeButton": true });
            }
            t.html(cur_html);
        });
    }

    function changeQty(e, id) {
        $.get('/gio-hang/change', { id: id, quantity: e.value }, function(data, status) {
            if (status == 'success' && data.status != 'error') {
                load(data);
            }
        });
    }
</script>
@endsection