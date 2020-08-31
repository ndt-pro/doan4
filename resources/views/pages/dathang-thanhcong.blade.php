
@extends('layouts.master')

@section('style')
    <style>
        .box-register {
            width: 80%;
        }

        .box-register .header {
            color: var(--color-success-hover);
        }

        .info {
            margin-top: 30px
        }

        .title {
            font-weight: bold;
            text-transform: uppercase;
        }

        .cont {
            color: #666
        }
    </style>
@endsection

@section('content')
<div class="row">
    <div class="box-register">
        <div class="header">
            <h1>Bạn đã đặt hàng thành công!</h1>
            <div class="line"></div>
        </div>
        <div class="text-center">
            Mã đơn hàng của bạn là #{{ $bill->id }}
        </div>
        <div class="row info">
            <div class="col-6">
                <div class="row mb-3">
                    <div class="col-6 title">Họ tên:</div>
                    <div class="col-6 cont">{{ $bill->customer->full_name }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-6 title">Giới tính:</div>
                    <div class="col-6 cont">{{ $bill->customer->gender }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-6 title">Email:</div>
                    <div class="col-6 cont">{{ $bill->customer->email }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-6 title">Số điện thoại:</div>
                    <div class="col-6 cont">{{ $bill->customer->phone_number }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-6 title">Địa chỉ:</div>
                    <div class="col-6 cont">{{ $bill->customer->address }}</div>
                </div>
            </div>
            <div class="col-6 pl-2">
                <div class="row mb-3">
                    <div class="col-6 title">Trạng thái:</div>
                    <div class="col-6 cont">{{ $bill->getValueStatus() }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-6 title">Hình thức thanh toán:</div>
                    <div class="col-6 cont">{{ $bill->payment }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-6 title">Ghi chú:</div>
                    <div class="col-6 cont">{{ $bill->note }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-6 title">Tổng hóa đơn:</div>
                    <div class="col-6 cont"><b class="text-danger" id="total_bill">{{ number_format($bill->totalPrice()) }}đ</b></div>
                </div>
            </div>
        </div>
        <div class="footer">
            <div class="line"></div>
            <div class="text-center text-uppercase mt-3">
                <a href="{{ route('index') }}" class="btn btn-success">Về trang chủ</a>
            </div>
        </div>
    </div>
</div>
@endsection