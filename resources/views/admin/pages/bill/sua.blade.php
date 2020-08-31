@extends('admin.layouts.master')

@section('style')
<link href="admin-assets/bootstrap4-editable/css/bootstrap-editable.css" rel="stylesheet">
@endsection

@section('content')
<div class="row print">
    <div class="col-md-12 mb-5 mt-2 text-center">
        <img src="admin-assets/assets/images/icon.png" class="mb-3" alt="logo" width="64px">
        <h2>HÓA ĐƠN BÁN HÀNG</h2>
    </div>
</div>
<div class="row not-print">
    <div class="col-xl-12 mb-2 mt-2 clearfix">
        <h1 class="float-left"><i class="fa fa-list-alt"></i> Chi tiết đơn hàng #{{ $bill->id }}</h1>

        <div class="float-right">
            <button data-role="print_bill" class="btn btn-outline-success">
                <span class="d-none d-md-block"><i class="fa fa-print"></i> In hóa đơn</span>
                <span class="d-md-none"><i class="fa fa-print"></i></span>
            </button>
        </div>
    </div>
    <div class="col-xl-12">
        @if ($bill->status > 0)
        <div class="alert alert-warning text-center">
            Đơn hàng này đã được phê duyệt. Sẽ không thể chỉnh sửa.
        </div>
        @endif
    </div>
</div>
<div class="row">
    <div class="col-xl-6 mb-5 mb-xl-0">
        <div class="card">
            <div class="card-header">
                <div class="col-md-6">
                    <h3>Thông tin khách hàng</h3>
                </div>
            </div>
            <div class="card-body">
                <div class="row mb-1">
                    <div class="col-md-6"><b>Họ tên:</b></div>
                    <div class="col-md-6">
                        <a href="#" class="editable" data-type="text" data-pk="{ id: {{ $bill->customer->id }}, db: 'customer' }" data-name="full_name" data-title="Họ tên">{{ $bill->customer->full_name }}</a>
                    </div>
                </div>
                <div class="row mb-1">
                    <div class="col-md-6"><b>Giới tính:</b></div>
                    <div class="col-md-6">
                        <a href="#" class="editable" data-type="select" data-pk="{ id: {{ $bill->customer->id }}, db: 'customer' }" data-name="gender" data-title="Giới tính" data-source="[{value: 1, text: 'Nam'}, {value: 2, text: 'Nữ'}]" data-value="{{ $bill->customer->gender == 'Nam' ? 1 : 2 }}">{{ $bill->customer->gender }}</a>
                    </div>
                </div>
                <div class="row mb-1">
                    <div class="col-md-6"><b>Email:</b></div>
                    <div class="col-md-6">
                        <a href="#" class="editable" data-type="text" data-pk="{ id: {{ $bill->customer->id }}, db: 'customer' }" data-name="email" data-title="Email">{{ $bill->customer->email }}</a>
                    </div>
                </div>
                <div class="row mb-1">
                    <div class="col-md-6"><b>Số điện thoại:</b></div>
                    <div class="col-md-6">
                        <a href="#" class="editable" data-type="text" data-pk="{ id: {{ $bill->customer->id }}, db: 'customer' }" data-name="phone_number" data-title="Số điện thoại">{{ $bill->customer->phone_number }}</a>
                    </div>
                </div>
                <div class="row mb-1">
                    <div class="col-md-6"><b>Địa chỉ:</b></div>
                    <div class="col-md-6">
                        <a href="#" class="editable" data-type="textarea" data-pk="{ id: {{ $bill->customer->id }}, db: 'customer' }" data-name="address" data-title="Địa chỉ">{{ $bill->customer->address }}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-6 mb-5 mb-xl-0">
        <div class="card">
            <div class="card-header">
                <div class="col-md-6">
                    <h3>Thông tin đơn hàng</h3>
                </div>
            </div>
            <div class="card-body">
                <div class="row mb-1">
                    <div class="col-md-6"><b>Trạng thái:</b></div>
                    <div class="col-md-6">
                        <a href="#" class="editable" data-type="select" data-pk="{ id: {{ $bill->id }}, db: 'bills' }" data-name="status" data-title="Trạng thái" data-source="{{ $bill->editableArray() }}" data-value="{{ $bill->status }}">{{ $bill->getValueStatus() }}</a>
                    </div>
                </div>
                <div class="row mb-1">
                    <div class="col-md-6"><b>Hình thức thanh toán:</b></div>
                    <div class="col-md-6">
                        <a href="#" class="editable" data-type="select" data-pk="{ id: {{ $bill->id }}, db: 'bills' }" data-name="payment" data-title="Thanh toán" data-source="[{ value: 1, text: 'COD' }, { value: 2, text: 'ATM' }]" data-value="{{ $bill->payment == 'COD' ? 1 : 2 }}">{{ $bill->payment }}</a>
                    </div>
                </div>
                <div class="row mb-1">
                    <div class="col-md-6"><b>Ghi chú:</b></div>
                    <div class="col-md-6">
                        <a href="#" class="editable" data-type="textarea" data-pk="{ id: {{ $bill->id }}, db: 'bills' }" data-name="note" data-title="Ghi chú">{{ $bill->note }}</a>
                    </div>
                </div>
                <div class="row mb-1">
                    <div class="col-md-6"><b>Tổng tiền hóa đơn:</b></div>
                    <div class="col-md-6">
                        <b class="text-danger" id="total_bill">{{ number_format($bill->totalPrice()) }}đ</b>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-12 mb-5 mb-xl-0">
        <div class="card">
            <div class="card-header">
                <div class="col-md-6">
                    <h3>Danh sách sản phẩm</h3>
                </div>
            </div>
            <form action="{{ route('bill.them-detail') }}" method="post">
                {{ csrf_field() }}
                <div class="card-body table-responsive">
                    <input type="hidden" name="bill_id" value="{{ $bill->id }}">
                    @if(Session::has('success'))
                    <div class="alert alert-success">
                        {{ Session::get('success') }}
                    </div>
                    @endif

                    @if(Session::has('error'))
                    <div class="alert alert-danger">
                        {{ Session::get('error') }}
                    </div>
                    @endif

                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th scope="col" width="30%">Tên sản phẩm</th>
                                <th scope="col">Màu sắc</th>
                                <th scope="col" class="text-right">Kích thước</th>
                                <th scope="col" class="text-right">Giá bán</th>
                                <th scope="col" class="text-right">Số lượng</th>
                                <th scope="col" class="text-right">Tổng tiền</th>
                                <th scope="col" class="text-center not-print">#</th>
                            </tr>
                        </thead>
                        <tbody id="product-list">
                            @foreach ($bill->bill_detail as $detail)
                                <tr>
                                    <td>{{ $detail->product->name }}</td>
                                    <td>
                                        <a href="#" class="editable" data-type="select" data-pk="{ id: {{ $detail->id }}, db: 'bill_detail' }" data-name="color" data-title="Màu sắc" data-source="{{ $detail->editableArrayColor() }}" data-value="{{ $detail->getColor()->value }}">{{ $detail->getColor()->name }}</a>
                                    </td>
                                    <td class="text-right">
                                        <a href="#" class="editable" data-type="select" data-pk="{ id: {{ $detail->id }}, db: 'bill_detail' }" data-name="size" data-title="Kích cỡ" data-source="{{ $detail->editableArraySize() }}" data-value="{{ $detail->size }}">{{ $detail->size }}</a>
                                    </td>
                                    <td class="text-right">
                                        <a href="#" class="editable" data-type="number" min="0" data-pk="{ id: {{ $detail->id }}, db: 'bill_detail' }" data-name="price" data-title="Giá bán">{{ $detail->price }}</a>
                                    </td>
                                    <td class="text-right">
                                        x <a href="#" class="editable" data-type="number" min="1" max="99" data-pk="{ id: {{ $detail->id }}, db: 'bill_detail' }" data-name="quantity" data-title="Số lượng">{{ $detail->quantity }}</a>
                                    </td>
                                    <td class="text-right" id="total_item_{{ $detail->id }}">
                                        {{ number_format($detail->totalPrice()) }}đ
                                    </td>
                                    <td class="text-center not-print">
                                        <button type="button" onclick="remove('{{ route('bill.xoa-detail', ['id' => $detail->id]) }}')" class="btn btn-icon rounded-circle btn-outline-danger mr-1 mb-1 waves-effect waves-light" {{ $bill->status > 0 ? 'disabled' : '' }}><i class="fa fa-trash"></i></button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @if ($bill->status  ==0 )
                    <div class="card-footer not-print">
                        <button type="button" class="btn btn-warning" data-role="add-product"><i class="fa fa-plus-circle"></i> Thêm sản phẩm</button>
                        <button id="btn-save" type="submit" class="btn btn-success" style="display: none"><i class="fa fa-save"></i> Lưu lại</button>
                    </div>
                @endif
            </form>
        </div>
    </div>
    
    <div class="col-xl-12 mb-5 mb-xl-0 print">
        <div class="row">
            <div class="col-md-6 text-center">
                <p><b>Nhân viên bán hàng</b></p>
                <p><i>(Ghi rõ họ tên)</i></p>
            </div>
            <div class="col-md-6 text-center">
                <p><b>Khách hàng</b></p>
                <p><i>(Ghi rõ họ tên)</i></p>
            </div>
        </div>
    </div>
</div>


<!-- Modal Add Product-->
<div class="modal fade" id="addProduct" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Thêm sản phẩm</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
    
        <div class="modal-body">
            <div class="row mb-3">
                <div class="col-md-4">Tìm sản phẩm</div>
                <div class="col-md-8">
                    <input type="text" class="form-control" data-role="find-product" placeholder="Mã, tên, loại,...">
                </div>
            </div>
            <div class="row table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Ảnh</th>
                            <th scope="col">Tên sản phẩm</th>
                            <th scope="col">Đơn giá</th>
                            <th scope="col">#</th>
                        </tr>
                    </thead>
                    <tbody id="find-product-list">
                        
                    </tbody>
                </table>
            </div>
        </div>
    
        <div class="modal-footer">
            <button type="button" class="btn btn-link" data-dismiss="modal">Đóng</button>
        </div>
        </div>
    </div>
</div>

@endsection

@section('script')
<script src="admin-assets/bootstrap4-editable/js/bootstrap-editable.js"></script>

<script>
    $.fn.editable.defaults.mode = 'inline';
    $.fn.editable.defaults.url = '{{ route('bill.sua', ['bill_id' => $bill->id]) }}';

    $(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': csrf_token
            }
        });

        //editables 
        $('.editable').editable({
            success: function(response, newValue) {
                console.log(response);

                if(response.status == 'success') {
                    if($(this).attr('data-name') == 'price' || $(this).attr('data-name') == 'quantity') {
                        $("#total_item_" + response.id).html(response.total + "đ");
                        $("#total_bill").html(response.total_bill + "đ");
                    }
                    toastr.success('Đã cập nhật thành công!', 'Thành công', { "closeButton": true });
                } else {
                    if(response.text)
                        toastr.error(response.text, 'Thất bại', { "closeButton": true });
                    else
                        toastr.error('Cập nhật không thành công!', 'Thất bại', { "closeButton": true });
                    return false;
                }
            },
            error: function(response, newValue) {
                // console.log(response);
                toastr.error('Cập nhật không thành công!', 'Thất bại', { "closeButton": true });
            }
        });

        $("[data-role='add-product']").click(function() {
            $('#addProduct').modal('show');
        });
    });

    $("[data-role='find-product']").on('keyup', function() {
        let list_product = $('#find-product-list');
        $.get('{{ route('bill.find-product') }}', { find: $(this).val() }, function(data, status) {
            if(status == 'success') {
                list_product.html('');

                $.each(data, function(index, e) {
                    list_product.append('<tr>\
                        <td><div class="avatar-group"><span class="avatar avatar-lg rounded-circle"><img src="' + e.image + '" alt="..."></span></div></td>\
                        <td>' + e.name + '</td>\
                        <td>' + e.price + '</td>\
                        <td>\
                            <button class="btn btn-danger" onclick="selectProduct(' + e.id + ')">Chọn</button>\
                        </td>\
                    </tr>');
                });
            }
        });
    });

    function selectProduct(id) {
        loading_page('show');
        $.get('{{ route('bill.product') }}', { id: id }, function(data, status) {
            if(status == 'success') {
                
                let arr_color = JSON.parse(data.colors);
                let arr_size = JSON.parse(data.sizes);

                let html_color = '';
                for(let i = 0; i < arr_color.length; i++) {
                    html_color += '<option value="' + arr_color[i].value + '" style="color: ' + arr_color[i].value + '">' + arr_color[i].name + '</option>';
                }

                let html_size = '';
                for(let i = 0; i < arr_size.length; i++) {
                    html_size += '<option value="' + arr_size[i] + '">' + arr_size[i] + '</option>';
                }
                
                $('#product-list').append('<tr class="new-detail">\
                    <td id="product-name">\
                        <input type="text" class="form-control" value="' + data.name + '" disabled>\
                        <input type="hidden" name="prod_id[]" value="' + data.id + '">\
                    </td>\
                    <td>\
                        <select name="prod_color[]" class="form-control">' + html_color + '</select>\
                    </td>\
                    <td>\
                        <select name="prod_size[]" class="form-control">' + html_size + '</select>\
                    </td>\
                    <td>\
                        <input type="number" name="prod_price[]" class="form-control" onchange="change(this)" id="product-price" value="' + data.price + '" required>\
                    </td>\
                    <td>\
                        <input type="number" name="prod_quantity[]" class="form-control" onchange="change(this)" id="product-quantity" value="1" min="1" max="' + data.quantity + '" required>\
                    </td>\
                    <td>\
                        <input type="text" class="form-control" id="product-total" value="' + formatNumber(data.price) + '" disabled>\
                    </td>\
                    <td>\
                        <button class="btn btn-danger" onclick="removeProduct(this)"><i class="fa fa-trash"></i></button>\
                    </td>\
                </tr>');
                
                $('#addProduct').modal('hide');
                $('#btn-save').show();
            }
            loading_page('hide');
        });
    }

    function change(e) {
        if($(e).attr("id") == 'product-quantity') {
            let quantity = $(e).val();
            let quantity_max = $(e).attr("max");
            if(quantity > quantity_max) {
                error("Số lượng không được vượt quá " + quantity_max);
                $(e).val(quantity_max);
            }
        }

        let parent = $(e).parent().parent();

        let price = parent.find('#product-price');
        let quantity = parent.find('#product-quantity');
        let total = parent.find('#product-total');

        let result = price.val() * quantity.val();

        total.val(formatNumber(result == 0 ? 'Không hợp lệ' : result));
    }

    function removeProduct(e) {
        let parent = $(e).parent().parent();
        parent.remove();

        let curr_detail = $("#product-list .new-detail");
        if(curr_detail.length == 0) {
            $('#btn-save').hide();
        }
    }

    $("button[data-role='print_bill']").click(function() {
        $('.not-print').hide();
        $('.print').show();
        let title = $('title').html();
        $('title').html("Hóa đơn điện tử - NDT Sneaker");
        window.print();
        $('title').html(title);
        $('.not-print').show();
        $('.print').hide();
    });
</script>
@endsection