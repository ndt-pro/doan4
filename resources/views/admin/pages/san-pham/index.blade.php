@extends('admin.layouts.master')

@section('content')
<div class="row">
    <div class="col-xl-12 mb-5 mb-xl-0">
        <div class="card">
            <div class="card-header">
                <div class="col-md-6">
                    <h3>Danh sách sản phẩm</h3>
                </div>
                <div class="col-md-6 text-right">
                    <a href="{{ route('products.them') }}" class="btn btn-outline-primary">
                        <span class="d-none d-md-block"><i class="fa fa-plus-circle"></i> Thêm sản phẩm</span>
                        <span class="d-md-none"><i class="fa fa-plus-circle"></i></span>
                    </a>
                </div>
            </div>
            <div class="card-body">
                @if(Session::has('success'))
                <div class="alert alert-success">
                    {{ Session::get('success') }}
                </div>
                @endif
                <div class="row mb-3">
                    <div class="col-md-4">Loại sản phẩm: 
                        <select id="product_type" class="form-control-sm">
                            <option value="">Tất cả</option>
                            @foreach ($types as $item)
                                <option value="{{ $item->id }}" {{ $id == $item->id ? 'selected' : '' }}>{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-striped" id="products-table">
                        <thead>
                            <tr>
                            <th scope="col">#</th>
                            <th scope="col">Hình ảnh</th>
                            <th scope="col">Tên sản phẩm</th>
                            <th scope="col">Loại sản phẩm</th>
                            <th scope="col">Số lượng</th>
                            <th scope="col">Đơn giá</th>
                            <th scope="col">Ngày thêm</th>
                            <th scope="col">#</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade text-left show" id="viewProduct" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Xem nhanh sản phẩm</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="data-view">
            </div>
        </div>
    </div>
</div>

@endsection

@section('script')
<script>
    $(document).ready(function() {
        $('#products-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route("products.data", ["id"=>$id]) }}',
            columns: [
                { data: 'id', name: 'id' },
                { data: 'image', name: 'image', orderable: false, searchable: false },
                { data: 'name', name: 'name' },
                { data: 'type', name: 'type' },
                { data: 'quantity', name: 'quantity' },
                { data: 'price', name: 'price' },
                { data: 'created_at', name: 'created_at' },
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ],
            "language": language,
            order: [[0, 'desc']]
        });

        $("#product_type").on("change", function() {
            let id = $(this).val();
            location.href = '{{ route('products.list') }}/' + id;
        });
    });

    function viewProduct(id) {
        $("#viewProduct #data-view").html(loading);
        $.get('{{ route('products.view') }}', { id: id }, function(data, status) {
            $("#viewProduct #data-view").html(data);
        });
        $("#viewProduct").modal("show");
    }
</script>
@endsection