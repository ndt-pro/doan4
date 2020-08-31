$.get('/gio-hang/get', function(data, status) {
    if (status == 'success') load(data);
});

function load(cart) {
    let list = $("[data-cart='products']");
    list.html("");

    let products = cart['cart'];

    $.each(products, function(id, prod) {
        list.append('<div class="content">\
            <div class="product">\
                <img src="' + prod.image + '" alt="...">\
                <span class="content">\
                    <a href="' + prod.link + '">' + prod.name + '</a>\
                    <p><span class="quantity">' + prod.quantity + '</span> ' + formatNumber(prod.price) + 'đ</p>\
                </span>\
                <span class="remove" onclick="removeCart(this, ' + id + ')">&times;</span>\
            </div>\
        </div>');
    });

    if(cart['count'] == 0) {
        $('.btn-checkout').hide();
    } else {
        $('.btn-checkout').show();
    }

    $("[data-cart='total']").html(formatNumber(cart['total']));
    $("[data-cart='count']").html(cart['count']);
}

$("[data-cart='add']").on("click", function(e) {
    e.preventDefault();

    let t = $(this);

    let id = t.attr("data-id");

    let cur_html = t.html();

    t.html(loading);

    $.post('/gio-hang/add', {
        _token: csrf_token,
        id: id
    }, function(data, status) {
        if (status == 'success' && data.status != 'error') {
            load(data);
            toastr.success('Đã thêm sản phẩm vào giỏ hàng!', 'Thành công', { "closeButton": true });
        } else {
            toastr.warning('Có lỗi xảy ra!', 'Thất bại', { "closeButton": true });
        }
        t.html(cur_html);
    });
});

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

$("[data-view='quick-view']").on("click", function(e) {
    e.preventDefault();

    let t = $(this);
    let cur_html = t.html();
    t.html(loading);

    let view = $("#quickViewModal");
    let id = $(this).attr("data-id");
    let list_image = $("[data-role='select-image']");
    list_image.html("");

    $.get('/san-pham/get', { id: id }, function(data, status) {
        if (status == 'success' && data.status != 'error') {

            view.find('#title').html(data.name);
            view.find('#image').attr('src', data.image);
            view.find(".product-price").html(formatNumber(data.price) + "đ");
            view.find(".product-description").html(data.description);

            view.find('#id').val(data.id);

            if (data.colors.length > 0) {
                $(".list-color").html("");
                $.each(data.colors, function(i, e) {
                    $(".list-color").append('<label class="custom-radio mr-3">\
                        <input type="radio" name="color" ' + (i == 0 ? 'checked' : '') + ' value="' + e.value + '">\
                        <span class="checkmark" style="background-color: ' + e.value + ';"></span>\
                    </label>');
                });
                $("#select-color").show();
            }

            if (data.sizes.length > 0) {
                $("#list-size").html("");
                $.each(data.sizes, function(i, e) {
                    $("#list-size").append('<option value="' + e + '">' + e + '</option>');
                });
                $("#select-size").show();
            }

            $("#select-quantity").attr("max", data.quantity);
            view.find('.modal-footer>a').attr("href", data.link);

            view.show();
        } else {
            toastr.warning('Có lỗi xảy ra!', 'Thất bại', { "closeButton": true });
        }
        t.html(cur_html);
    });

});

function quickView(form) {
    let t = $(form['submit']);
    let cur_html = t.html();
    t.html(loading);

    let id = form['id'].value;

    let color = 0;
    if (form['color'] !== undefined) {
        color = form['color'].value;
    }

    let size = 0;
    if (form['size'] !== undefined) {
        size = form['size'].value;
    }

    let quantity = form['quantity'].value;

    try {
        $.post('/gio-hang/add', {
            _token: csrf_token,
            id: id,
            color: color,
            size: size,
            quantity: quantity
        }, function(data, status) {
            if (status == 'success' && data.status != 'error') {
                load(data);
                toastr.success('Đã thêm sản phẩm vào giỏ hàng!', 'Thành công', { "closeButton": true });
            } else {
                toastr.warning('Có lỗi xảy ra!', 'Thất bại', { "closeButton": true });
            }
            t.html(cur_html);
        });
    } catch (error) {
        console.log(error);
    }
    return false;
}