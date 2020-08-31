@extends('admin.layouts.master')

@section('content')
<div class="row">
    <div class="col-xl-12 mb-5 mb-xl-0">
        <div class="card">
            <div class="card-header">
                <div class="row">
                <div class="col">
                    <h2 class="mb-0">Thêm loại sản phẩm</h2>
                </div>
                </div>
            </div>
            <form action="{{ route('products-type.them') }}" method="post" role="form" enctype="multipart/form-data" class="dropzone dropzone-area" id="dpz-remove-thumb">
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

                    <div class="form-group">
                        <label>Tên loại sản phẩm</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Mô tả</label>
                        <textarea type="text" name="description" class="form-control" rows="5" required></textarea>
                    </div>
                    <div class="form-group">
                        <label>Logo thương hiệu</label>
                        <input type="file" class="form-control" name="logo" data-role="preview-image" required>
                        <div id="preview-image"></div>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-outline-success">Thêm loại sản phẩm</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection