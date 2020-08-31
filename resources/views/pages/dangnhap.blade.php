
@extends('layouts.master')

@section('content')
<div class="row">
    <div class="box-register">
        <div class="header">
            Đăng nhập người dùng
            <div class="line"></div>
        </div>
        @if (count($errors) > 0)
            <div class="alert alert-danger">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        @if(Session::has('danger'))
        <div class="alert alert-danger">
            Email hoặc mật khẩu không chính xác.
        </div>
        @endif
        <form action="{{ route('login') }}" method="POST" class="form-control">
            @csrf
            <div class="input-icon">
                <input type="text" name="email" placeholder="Nhập email..." autofocus>
                <i class="fa fa-envelope-o icon"></i>
            </div>
            <div class="input-icon">
                <input type="password" name="password" placeholder="Nhập mật khẩu...">
                <i class="fa fa-key icon"></i>
            </div>
            <button type="submit" class="btn btn-success btn-block">Đăng Nhập</button>
        </form>
        <div class="footer">
            <div class="line"></div>
            <div class="row">
                <div class="col-6 pr-2">
                    <a href="{{ route('index') }}" class="btn btn-block btn-warning"><i class="fa fa-arrow-left"></i> Quay lại trang chủ</a>
                </div>
                <div class="col-6 pl-2">
                    <a href="{{ route('register') }}" class="btn btn-block btn-danger">Đăng Ký Tài khoản</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection