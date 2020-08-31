<!-- Author NDTPRO -->

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NDT Sneaker - Đặt hàng</title>
    <base href="{{ asset('') }}">

    <link rel="shortcut icon" href="assets/image/favicon.png" type="image/x-icon">

    <!-- font -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Noto+Serif:ital,wght@0,400;0,700;1,400;1,700&display=swap">

    <!-- css -->
    <link rel="stylesheet" href="assets/css/style-checkout.css">

    <!-- jquery script -->
    <script src="assets/vendor/jquery-3.5.0/jquery-3.5.0.min.js"></script>

</head>

<body>
    <div class="loading_page">
        <div class="lds-roller"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>
    </div>
    <div class="wrap">
        <div class="info-left">
            <div class="content left">
                <div class="top">
                    <a href="{{ route('index') }}"><img src="assets/image/logo-ndtpro.png" alt="logo" width="200px"></a>
    
                    <h2>Đặt hàng</h2>
                </div>

                <div class="customer-input">
                    <form action="{{ route('checkout') }}" method="post">
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="col-8">
                                <input type="text" name="full_name" placeholder="Họ tên" value="{{ $customer['full_name'] }}" required>
                            </div>
                            <div class="col-4">
                                <select name="gender" required>
                                    <option value="">-- Giới tính --</option>
                                    <option value="1">Nam</option>
                                    <option value="2">Nữ</option>
                                </select>
                            </div>
                            <div class="col-7">
                                <input type="text" name="email" placeholder="Email" value="{{ $customer['email'] }}" required>
                            </div>
                            <div class="col-5">
                                <input type="text" name="phone_number" placeholder="Số điện thoại" value="{{ $customer['phone_number'] }}" required>
                            </div>
                            <div class="col-12">
                                <input type="text" name="address" placeholder="Địa chỉ nhận hàng" value="{{ $customer['address'] }}" required>
                            </div>
                            <div class="col-4">
                                <select name="thanh_pho" data-role="select-thanh-pho" required>
                                    <option value="">-- Chọn Tỉnh/Thành Phố --</option>
                                    @foreach ($list_thanh_pho as $item)
                                        <option value="{{ $item->matp }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-4">
                                <select name="quan_huyen" data-role="select-quan-huyen" disabled required>
                                </select>
                            </div>
                            <div class="col-4">
                                <select name="xa_phuong" data-role="select-xa-phuong" disabled required>
                                </select>
                            </div>
                            <div class="col-12">
                                <select name="payment" required>
                                    <option value="">-- Phương thức thanh toán --</option>
                                    <option value="COD">COD (Thanh toán khi nhận hàng)</option>
                                    <option value="ATM">ATM (Thanh toán ngân hàng)</option>
                                </select>
                            </div>
                            <div class="col-12">
                                <textarea name="note" rows="5" placeholder="Ghi chú"></textarea>
                            </div>
                            <div class="col-4">
                                <a href="{{ route('cart.list') }}" class="btn-back">Quay lại giỏ hàng</a>
                            </div>
                            <div class="col-8 text-right">
                                <button type="submit" class="btn-checkout">Đặt hàng ngay</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="info-right">
            <div class="content right">
                
                <div class="top">
                </div>

                <table class="table-cart">
                    @foreach ($cart as $item)
                        <tr>
                            <td class="p-image">
                                <img src="{{ $item->image }}" alt="...">
                                <span>{{ $item->quantity }}</span>
                            </td>
                            <td class="p-name">
                                {{ $item->name }}
                                <p>Size: {{ $item->size }} / {{ $item->color->name }}</p>
                            </td>
                            <td class="p-price">
                                {{ number_format($item->price) }}đ
                            </td>
                        </tr>
                    @endforeach
                </table>
                <div class="total-bill row">
                    <div class="col-6">Tổng cộng:</div>
                    <div class="col-6 text-right text-bold">{{ number_format($total) }}đ</div>
                </div>
            </div>
        </div>
    </div>
</body>

<script>
    // open loading
    function loading_page(status) {
        if (status == 'show') {
            $('.loading_page').show();
        } else if (status == 'hide') {
            $('.loading_page').hide();
        }
    }

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
</script>
</html>