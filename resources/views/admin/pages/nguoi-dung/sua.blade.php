@extends('admin.layouts.master')

@section('content')
<div class="row">
    <div class="col-xl-12 mb-5 mb-xl-0">
        <div class="card">
            <div class="card-header">
                <div class="row">
                <div class="col">
                    <h2 class="mb-0">Sửa người dùng #{{ $user->id }} </h2>
                </div>
                </div>
            </div>
            <form action="{{ route('users.sua') }}" method="post" role="form">
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

                    <input type="hidden" name="id" value="{{ $user->id }}">

                    <div class="form-group">
                        <label>Họ tên</label>
                        <input type="text" name="full_name" class="form-control" required value="{{ $user->full_name }}">
                    </div>
                    <div class="form-group">
                        <label>Số điện thoại</label>
                        <input type="text" name="phone_number" class="form-control" required maxlength="10" value="{{ $user->phone_number }}">
                    </div>
                    <div class="form-group">
                        <label>Địa chỉ</label>
                        <textarea type="text" name="address" class="form-control" rows="4" required>{{ $user->address }}</textarea>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-outline-success">Sửa thông tin</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection