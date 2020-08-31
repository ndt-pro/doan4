@extends('admin.layouts.master')

@section('content')
<div class="row">
    <div class="col-xl-12 mb-5 mb-xl-0">
        <div class="card">
            <div class="card-header">
                <div class="row">
                <div class="col">
                    <h2 class="mb-0">Sửa loại sản phẩm #{{ $type->id }} </h2>
                </div>
                </div>
            </div>
            <form action="{{ route('products-type.sua') }}" method="post" role="form" enctype="multipart/form-data">
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

                    <input type="hidden" name="id" value="{{ $type->id }}">


                    <div class="form-group">
                        <label>Tên loại sản phẩm</label>
                        <input type="text" name="name" class="form-control" required value="{{ $type->name }}">
                    </div>
                    <div class="form-group">
                        <label>Mô tả</label>
                        <textarea type="text" name="description" class="form-control" rows="5" required>{{ $type->description }}</textarea>
                    </div>
                    <div class="form-group">
                        <label>Logo thương hiệu</label> (bỏ trống để sử dụng ảnh cũ)
                        <input type="file" class="form-control" name="logo" data-role="preview-image">
                        <div id="preview-image"></div>
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