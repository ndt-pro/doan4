
@extends('layouts.master')

@section('content')
<div class="row">
    <div class="box-register">
        <div class="header">
            Đăng ký tài khoản
            <div class="line"></div>
        </div>
        @if (count($errors) > 0)
            <div class="alert alert-danger">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form action="{{ route('register') }}" method="POST" class="form-control">
            @csrf
            <div class="input-icon">
                <input type="text" name="full_name" placeholder="Nhập họ tên..." required>
                <i class="fa fa-drivers-license icon"></i>
            </div>
            <div class="input-icon">
                <input type="text" name="phone_number" placeholder="Nhập số điện thoại..." required maxlength="10">
                <i class="fa fa-phone icon"></i>
            </div>
            <div class="input-icon">
                <input type="text" name="email" placeholder="Nhập Email..." required>
                <i class="fa fa-envelope-o icon"></i>
            </div>
            <div class="input-icon">
                <input type="text" name="address" placeholder="Nhập địa chỉ..." required>
                <i class="fa fa-home icon"></i>
            </div>
            <div class="input-icon">
                <input type="password" name="password" placeholder="Nhập mật khẩu..." required>
                <i class="fa fa-lock icon"></i>
            </div>
            <div class="input-icon">
                <input type="password" name="password_confirmation" placeholder="Xác nhận mật khẩu..." required>
                <i class="fa fa-lock icon"></i>
            </div>
            <img src="{{$captcha['image_src']}}" alt="..." height="75px">
            <div class="input-icon">
                <input type="text" name="captcha_code" placeholder="Nhập mã xác thực..." required>
                <i class="fa fa-key icon"></i>
            </div>
            <button type="submit" class="btn btn-success btn-block">Đăng Ký</button>
        </form>
        <div class="footer">
            <div class="line"></div>
            <a href="{{ route('index') }}" class="btn btn-block btn-warning"><i class="fa fa-arrow-left"></i> Quay lại trang chủ</a>
        </div>
    </div>
</div>
@endsection