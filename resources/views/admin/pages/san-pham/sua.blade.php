@extends('admin.layouts.master')

@section('style')
    <link rel="stylesheet" type="text/css" href="admin-assets/app-assets/vendors/css/editors/quill/katex.min.css">
    <link rel="stylesheet" type="text/css" href="admin-assets/app-assets/vendors/css/editors/quill/monokai-sublime.min.css">
    <link rel="stylesheet" type="text/css" href="admin-assets/app-assets/vendors/css/editors/quill/quill.snow.css">
    <link rel="stylesheet" type="text/css" href="admin-assets/app-assets/vendors/css/editors/quill/quill.bubble.css">
@endsection

@section('content')
<div class="row">
    <div class="col-xl-12 mb-5 mb-xl-0">
        <div class="card">
            <div class="card-header">
                <div class="row">
                <div class="col">
                    <h2 class="mb-0">Sửa sản phẩm #{{ $product->id }} </h2>
                </div>
                </div>
            </div>
            <form action="{{ route('products.sua') }}" method="post" role="form" enctype="multipart/form-data">
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

                    <input type="hidden" name="id" value="{{ $product->id }}">

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Tên sản phẩm</label>
                                <input type="text" name="name" class="form-control" value="{{ $product->name }}" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Loại sản phẩm</label>
                                <select name="type_id" class="form-control" required>
                                    @foreach ($types as $item)
                                        <option value="{{ $item->id }}" {{ $product->type_id == $item->id ? 'selected' : '' }}>{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Mô tả</label>
                        
                        <input type="hidden" name="description" id="description">
                        <div id="edit-description" style="min-height: 300px">
                            {!! $product->description !!}
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Số lượng</label>
                                <input type="number" name="quantity" class="form-control" value="{{ $product->quantity }}" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Đơn giá</label>
                                <input type="number" name="price" class="form-control" value="{{ $product->price }}" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            {{-- option color --}}
                            <div class="col-xl-6">
                                <div class="vs-checkbox-con vs-checkbox-primary mb-2">
                                    <input type="checkbox" id="checkColor" name="checkColor" value="true" checked>
                                    <span class="vs-checkbox">
                                        <span class="vs-checkbox--check">
                                            <i class="vs-icon feather icon-check"></i>
                                        </span>
                                    </span>
                                    <span class="">Sử dụng màu sắc</span>
                                </div>
                                <div data-option="color">
                                    @forelse ($colors as $item)
                                        <div class="row mb-1">
                                            <div class="col-sm-7">
                                                <input class="form-control" type="color" name="color[]" value="{{ $item->value }}">
                                            </div>
                                            <div class="col-sm-3">
                                                <input class="form-control" type="text" name="color_name[]" value="{{ $item->name }}">
                                            </div>
                                            @if ($colors[0] != $item)
                                                <div class="col-sm-2">
                                                    <button type="button" class="btn btn-sm btn-danger btn-block mt-1" onclick="removeColor(this)"><i class="fa fa-times-circle"></i></button>
                                                </div>
                                            @endif
                                        </div>
                                    @empty
                                    <div class="row mb-1">
                                        <div class="col-sm-7">
                                            <input class="form-control" type="color" name="color[]" value="#ffffff">
                                        </div>
                                        <div class="col-sm-3">
                                            <input class="form-control" type="text" name="color_name[]" value="Trắng">
                                        </div>
                                    </div>
                                    @endforelse
                                </div>
                                <button type="button" class="btn btn-sm btn-primary btn-block" data-role="addColor"><i class="fa fa-plus-circle"></i> Thêm màu sắc</button>
                            </div>

                            {{-- option size --}}
                            <div class="col-xl-6">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="vs-checkbox-con vs-checkbox-primary mb-2">
                                            <input type="checkbox" id="checkSize" name="checkSize" value="true" checked>
                                            <span class="vs-checkbox">
                                                <span class="vs-checkbox--check">
                                                    <i class="vs-icon feather icon-check"></i>
                                                </span>
                                            </span>
                                            <span class="">Sử dụng kích thước</span>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="vs-checkbox-con vs-checkbox-primary mb-2">
                                            <input type="checkbox" id="checkAllSize">
                                            <span class="vs-checkbox">
                                                <span class="vs-checkbox--check">
                                                    <i class="vs-icon feather icon-check"></i>
                                                </span>
                                            </span>
                                            <span class="">Chọn tất cả</span>
                                        </div>
                                    </div>
                                </div>
                                <div data-option="size">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            @for ($i = 35; $i <= 38; $i += 0.5)
                                                <div class="vs-checkbox-con vs-checkbox-primary">
                                                    <input type="checkbox" name="size[]" value="{{ $i }}" {{ in_array("$i", $sizes) ? 'checked' : '' }}>
                                                    <span class="vs-checkbox">
                                                        <span class="vs-checkbox--check">
                                                            <i class="vs-icon feather icon-check"></i>
                                                        </span>
                                                    </span>
                                                    <span class="">{{ $i }}</span>
                                                </div>
                                            @endfor
                                        </div>
                                        <div class="col-sm-6">
                                            @for ($i = 39; $i <= 42; $i += 0.5)
                                                <div class="vs-checkbox-con vs-checkbox-primary">
                                                    <input type="checkbox" name="size[]" value="{{ $i }}" {{ in_array("$i", $sizes) ? 'checked' : '' }}>
                                                    <span class="vs-checkbox">
                                                        <span class="vs-checkbox--check">
                                                            <i class="vs-icon feather icon-check"></i>
                                                        </span>
                                                    </span>
                                                    <span class="">{{ $i }}</span>
                                                </div>
                                            @endfor
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label>Hình ảnh sản phẩm</label>
                        <div class="row mb-2 ml-1">
                            @foreach ($product->product_image as $item)
                            <div class="remove-image" data-role="removeImage">
                                <img src="{{ $product->getLinkImage().$item->image }}" alt=".">
                                <div class="remove"><i class="fa fa-trash"></i></div>
                                <input type="hidden" name="remove[]" value="{{ $item->id }}" disabled>
                            </div>
                            @endforeach
                        </div>
                        <div class="row mt-3 ml-1">
                            <input type="file" class="form-control" name="image[]" accept="image/*" data-role="preview-image" multiple>
                            <div id="preview-image"></div>
                        </div>
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

@section('script')

    <script src="admin-assets/app-assets/vendors/js/editors/quill/katex.min.js"></script>
    <script src="admin-assets/app-assets/vendors/js/editors/quill/highlight.min.js"></script>
    <script src="admin-assets/app-assets/vendors/js/editors/quill/quill.min.js"></script>
    <script src="admin-assets/app-assets/vendors/js/extensions/jquery.steps.min.js"></script>
    <script src="admin-assets/app-assets/vendors/js/forms/validation/jquery.validate.min.js"></script>

    <script>
        $("input[type=file]").change(function() {
            $("#preview").html("");

            if (this.files) {
                for(let i = 0; i < this.files.length; i++) {
                    let reader = new FileReader();

                    reader.onload = function(e) {
                        $("#preview").append('<img src="' + e.target.result + '" alt="...">');
                    }

                    reader.readAsDataURL(this.files[i]); // convert to base64 string
                }
            }
        });

        $("button[data-role=addColor]").click(function() {
            $("[data-option=color]").append('<div class="row mb-1">\
                <div class="col-sm-7">\
                    <input class="form-control" type="color" name="color[]" value="#ffffff">\
                </div>\
                <div class="col-sm-3">\
                    <input class="form-control" type="text" name="color_name[]" value="">\
                </div>\
                <div class="col-sm-2">\
                    <button type="button" class="btn btn-sm btn-danger btn-block mt-1" onclick="removeColor(this)"><i class="fa fa-times-circle"></i></button>\
                </div>\
            </div>');
        });

        $("#checkColor").change(function() {
            if(this.checked) {
                $("[data-option=color] input").removeAttr("disabled");
                $("[data-option=color] button").removeAttr("disabled");
                $("button[data-role=addColor]").removeAttr("disabled");
            } else {
                $("[data-option=color] input").attr("disabled", "true");
                $("[data-option=color] button").attr("disabled", "true");
                $("button[data-role=addColor]").attr("disabled", "true");
            }
        });

        function removeColor(my) {
            $(my).parent().parent().remove();
        }

        $("#checkSize").change(function() {
            if(this.checked) {
                $("[data-option=size] input").removeAttr("disabled");
            } else {
                $("[data-option=size] input").attr("disabled", "true");
            }
        });

        $("#checkAllSize").change(function() {
            if(this.checked) {
                $("[data-option=size] input").prop("checked", true);
            } else {
                $("[data-option=size] input").prop("checked", false);
            }
        });

        $("[data-role=removeImage]").click(function() {
            $remove = $(this).children(".remove");
            $id = $(this).children("input");

            if($remove.hasClass("active")) {
                $remove.removeClass("active");
                $id.attr("disabled", "true");
            } else {
                $remove.addClass("active");
                $id.removeAttr("disabled");
            }
        });

        var fullEditor = new Quill('#edit-description', {
            bounds: '#edit-description',
            modules: {
                'formula': true,
                'syntax': true,
                'toolbar': [
                    [{
                        'font': []
                    }, {
                        'size': []
                    }],
                    ['bold', 'italic', 'underline', 'strike'],
                    [{
                        'color': []
                    }, {
                        'background': []
                    }],
                    [{
                        'script': 'super'
                    }, {
                        'script': 'sub'
                    }],
                    [{
                        'header': '1'
                    }, {
                        'header': '2'
                    }, 'blockquote', 'code-block'],
                    [{
                        'list': 'ordered'
                    }, {
                        'list': 'bullet'
                    }, {
                        'indent': '-1'
                    }, {
                        'indent': '+1'
                    }],
                    ['direction', {
                        'align': []
                    }],
                    ['link', 'image', 'video', 'formula'],
                    ['clean']
                ],
            },
            theme: 'snow'
        });

        fullEditor.on('text-change', function(delta, oldDelta, source) {
            let text = fullEditor.root.innerHTML;
            $('#description').val(text);
        });
    </script>
@endsection