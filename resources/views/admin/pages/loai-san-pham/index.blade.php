@extends('admin.layouts.master')

@section('content')

<div class="row">
    <div class="col-xl-12 mb-5 mb-xl-0">
        <div class="card">
            <div class="card-header">
                <div class="col-md-6">
                    <h3>Danh sách loại sản phẩm</h3>
                </div>
                <div class="col-md-6 text-right">
                    <a href="{{ route('products-type.them') }}" class="btn btn-outline-primary">
                        <span class="d-none d-md-block"><i class="fa fa-plus-circle"></i> Thêm loại sản phẩm</span>
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
                <div class="table-responsive">
                    <table class="table table-striped" id="products-type-table">
                        <thead>
                            <tr>
                            <th scope="col">#</th>
                            <th scope="col">Logo</th>
                            <th scope="col">Tên loại</th>
                            <th scope="col">Mô tả</th>
                            <th scope="col">Ngày tạo</th>
                            <th scope="col">#</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    $(document).ready(function() {
        $('#products-type-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{!! route('products-type.data') !!}',
            columns: [
                { data: 'id', name: 'id' },
                { data: 'logo', name: 'logo', orderable: false, searchable: false },
                { data: 'name', name: 'name' },
                { data: 'description', name: 'description' },
                { data: 'created_at', name: 'created_at' },
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ],
            "language": language,
            order: [[0, 'desc']]
        });
    });
</script>
@endsection