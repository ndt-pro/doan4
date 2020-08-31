@extends('admin.layouts.master')

@section('content')
<div class="row">
    <div class="col-xl-12 mb-5 mb-xl-0">
        <div class="card">
            <div class="card-header">
                <div class="col-md-6">
                    <h3>Danh sách nhãn hiệu</h3>
                </div>
                <div class="col-md-6 text-right">
                    <a href="#" class="btn btn-outline-primary" data-role="add-brand">
                        <span class="d-none d-md-block"><i class="fa fa-plus-circle"></i> Thêm nhãn hiệu</span>
                        <span class="d-md-none"><i class="fa fa-plus-circle"></i></span>
                    </a>
                </div>
            </div>
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

                @if(Session::has('error'))
                <div class="alert alert-danger">
                    {{ Session::get('error') }}
                </div>
                @endif

                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                            <th scope="col">#</th>
                            <th scope="col">Hình ảnh</th>
                            <th scope="col">Hiển thị</th>
                            <th scope="col">#</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($brands as $item)
                                <tr>
                                    <td>#{{ $item->id }}</td>
                                    <td>
                                        <div class="avatar-group">
                                            <span class="avatar avatar-lg rounded-circle">
                                                <img src="storage/brand/{{ $item->image }}" alt="">
                                            </span>
                                        </div>
                                    </td>
                                    <td>
                                        @if ($item->show)
                                            <span class="badge badge-success">BẬT</span>
                                        @else
                                            <span class="badge badge-danger">TẮT</span>
                                        @endif
                                    </td>
                                    <td>
                                        <button class="btn btn-icon rounded-circle btn-outline-warning mr-1 mb-1 waves-effect waves-light" data-role="edit-brand" data-id="{{ $item->id }}"><i class="fa fa-edit"></i></button>
                                        <button type="button" onclick="remove('{{ route('brand.xoa', ['id'=>$item->id]) }}')" class="btn btn-icon rounded-circle btn-outline-danger mr-1 mb-1 waves-effect waves-light"><i class="fa fa-trash"></i></button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer">
                {{ $brands->links() }}
            </div>
        </div>
    </div>
</div>

<div class="modal fade text-left show" id="modal-action" tabindex="-1" role="dialog" aria-labelledby="modal-action" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title" id="modal-action-title"></h2>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>

            <form action="{{ route('brand.action') }}" method="post" role="form" enctype="multipart/form-data">
                {{ csrf_field() }}
                <input type="hidden" name="action" id="action">
                <input type="hidden" name="id" id="id">

                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-md-4">Hình ảnh</div>
                        <div class="col-md-8">
                            <input type="file" class="form-control" name="image" accept="image/*" data-role="preview-image">
                            <div id="preview-image"></div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">Hiển thị</div>
                        <div class="col-md-8">
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" id="show1" name="show" class="custom-control-input" value="1">
                                <label class="custom-control-label" for="show1">Bật</label>
                            </div>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" id="show2" name="show" class="custom-control-input" value="0">
                                <label class="custom-control-label" for="show2">Tắt</label>
                            </div>
                        </div>
                    </div>
                </div>
    
                <div class="modal-footer">
                    <button type="button" class="btn btn-link" data-dismiss="modal">Đóng</button>
                    <button type="submit" class="btn btn-primary" id="modal-action-submit"></button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@section('script')
<script>
    $(document).ready(function() {
        // add brand
        $("[data-role=add-brand]").on("click", function(e) {
            e.preventDefault();

            $("#action").val("add");
            $("#id").val("0");
            $("#modal-action-title").html("Thêm nhãn hiệu");
            $("#preview-image").html("");
            $("#show1").attr("checked", "true");
            $("input[data-role='preview-image']").val("");
            $("input[data-role='preview-image']").attr("required", "true");
            $("#modal-action-submit").html("Thêm");

            $("#modal-action").modal("show");
        });

        // edit brand
        $("[data-role=edit-brand]").on("click", function(e) {
            e.preventDefault();

            const id = $(this).attr('data-id');

            $.get('{{ route('brand.getjson') }}', { id: id }, function(data) {
                if(!jQuery.isEmptyObject(data)) {
                    $("#action").val("edit");
                    $("#id").val(data.id);
                    $("#modal-action-title").html("Sửa nhãn hiệu #" + data.id);
                    $("#preview-image").html('<img src="storage/brand/' + data.image + '" alt="...">');
                    if(data.show == 1) {
                        $("#show1").attr("checked", "true");
                    } else {
                        $("#show2").attr("checked", "true");
                    }
                    $("input[data-role='preview-image']").val("");
                    $("input[data-role='preview-image']").removeAttr("required");
                    $("#modal-action-submit").html("Sửa");
                    $("#modal-action").modal("show");
                } else {
                    $("#modal-notification-content").html("Không thể đọc dữ liệu!");
                    $("#modal-notification").modal("show");
                }
            });
        });
    });
</script>
@endsection