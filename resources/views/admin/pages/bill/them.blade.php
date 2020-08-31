@extends('admin.layouts.master')

@section('style')
    <link rel="stylesheet" type="text/css" href="admin-assets/app-assets/vendors/css/forms/select/select2.min.css">
@endsection

@section('content')
<div class="row">
    <div class="col-xl-12 mb-5 mb-xl-0">
        <div class="card">
            <div class="card-header">
                <div class="row">
                <div class="col">
                    <h2 class="mb-0">Thêm đơn hàng</h2>
                </div>
                </div>
            </div>
            <form action="{{ route('bill.them') }}" method="post" role="form">
                {{ csrf_field() }}
                <div class="card-body">
                    @if (count($errors) > 0)
                        @foreach ($errors->all() as $error)
                            <div class="alert alert-danger">
                                {{ $error }}
                            </div>
                        @endforeach
                    @endif
            
                    @if(Session::has('success'))
                    <div class="alert alert-success">
                        {{ Session::get('success') }}
                    </div>
                    @endif

                    <div class="row">
                        <div class="col-md-5">
                            <div class="form-group">
                                <label>Khách hàng</label>
                                <div class="input-group">
                                    <select class="select2-data-ajax form-control" id="select-customer"></select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="form-group">
                                <label>Họ tên</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="full_name" id="full_name" placeholder="Nhập họ tên">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Giới tính</label>
                                <select name="gender" class="form-control" required>
                                    <option value="1">Nam</option>
                                    <option value="2">Nữ</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Email</label>
                                <input type="text" class="form-control" name="email" id="email" placeholder="Nhập email" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Số điện thoại</label>
                                <input type="text" class="form-control" name="phone_number" id="phone_number" placeholder="Nhập số điện thoại" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Địa chỉ nhận hàng</label>
                                <input type="text" class="form-control" name="address" id="address" placeholder="Nhập địa chỉ" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Phương thức thanh toán</label>
                                <select name="payment" class="form-control" required>
                                    <option value="COD">COD (Thanh toán khi nhận hàng)</option>
                                    <option value="ATM">ATM (Chuyển khoản)</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Tỉnh/Thành Phố</label>
                                <select class="form-control" name="thanh_pho" data-role="select-thanh-pho" required>
                                    <option value="">-- Chọn Tỉnh/Thành Phố --</option>
                                    @foreach ($list_thanh_pho as $item)
                                        <option value="{{ $item->matp }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Quận/Huyện</label>
                                <select class="form-control" name="quan_huyen" data-role="select-quan-huyen" disabled required>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Xã/Phường</label>
                                <select class="form-control" name="xa_phuong" data-role="select-xa-phuong" disabled required>
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label>Ghi chú</label>
                        <textarea type="text" name="note" class="form-control" rows="5" required>Quản trị viên tạo đơn hàng</textarea>
                    </div>
                </div>
                <div class="card-footer table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col" width="30%">Tên sản phẩm</th>
                                <th scope="col">Màu sắc</th>
                                <th scope="col">Kích thước</th>
                                <th scope="col">Giá bán</th>
                                <th scope="col">Số lượng</th>
                                <th scope="col">Tổng tiền</th>
                                <th scope="col">#</th>
                            </tr>
                        </thead>
                        <tbody id="product-list">
                        </tbody>
                    </table>
                    <button type="button" class="btn btn-warning mt-3" data-role="add-product"><i class="fa fa-plus-circle"></i> Thêm sản phẩm</button>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-outline-success">Tạo đơn hàng</button>
                </div>
            </form>
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
    <script src="admin-assets/app-assets/vendors/js/forms/select/select2.full.min.js"></script>
    <script>

        $("[data-role='select-thanh-pho']").on('change', function() {
            loading_page('show');
            let matp = $(this).val();

            let qh = $("[data-role='select-quan-huyen']");

            qh.html('<option value="">-- Chọn Quận/Huyện --</option>');

            $.get('{{ route('data.get-quan-huyen') }}', { matp: matp }, function(data, status) {
                if(status == 'success') {
                    $.each(data, function(index, e) {
                        qh.append('<option value="' + e.maqh + '">' + e.name + '</option>');
                    });
                    qh.removeAttr('disabled');
                }
                loading_page('hide');
            });
        });

        $("[data-role='select-quan-huyen']").on('change', function() {
            loading_page('show');
            let maqh = $(this).val();

            let xp = $("[data-role='select-xa-phuong']");

            xp.html('<option value="">-- Chọn Xã/Phường --</option>');

            $.get('{{ route('data.get-xa-phuong') }}', { maqh: maqh }, function(data, status) {
                if(status == 'success') {
                    $.each(data, function(index, e) {
                        xp.append('<option value="' + e.xaid + '">' + e.name + '</option>');
                    });
                    xp.removeAttr('disabled');
                }
                loading_page('hide');
            });
        });

        $("[data-role='add-product']").click(function() {
            $('#addProduct').modal('show');
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
                    
                    $('#product-list').append('<tr>\
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
        }

        
        $("#select-customer").select2({
            dropdownAutoWidth: true,
            width: '100%',
            ajax: {
                url: "{{ route('bill.find-customer') }}",
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        find: params.term
                    };
                },
                processResults: function (data, params) {
                    return {
                        results: data.result
                    };
                },
                cache: true
            },
            placeholder: 'Chọn khách hàng...',
            escapeMarkup: function (markup) { return markup; },
            minimumInputLength: 1,
            templateResult: function(repo) {
                if (repo.loading) return repo.text;

                return repo.full_name + '/' + repo.phone_number;
            },
            templateSelection: function(repo) {
                $('#full_name').val(repo.full_name);
                $('#email').val(repo.email);
                $('#phone_number').val(repo.phone_number);
                $('#address').val(repo.address);

                return repo.full_name || repo.text;
            }
        });
    </script>
@endsection