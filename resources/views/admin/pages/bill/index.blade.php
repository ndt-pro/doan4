@extends('admin.layouts.master')

@section('content')
<div class="row">
    <div class="col-xl-12 mb-5 mb-xl-0">
        <div class="card">
            <div class="card-header">
                <div class="col-md-6">
                    <h3>Tất cả đơn hàng</h3>
                </div>
                <div class="col-md-6 text-right">
                    <a href="{{ route('bill.them') }}" class="btn btn-outline-primary">
                        <span class="d-none d-md-block"><i class="fa fa-plus-circle"></i> Tạo đơn hàng</span>
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
                    <table class="table table-striped" id="bill-table">
                        <thead>
                            <tr>
                            <th scope="col">#</th>
                            <th scope="col">Khách hàng</th>
                            <th scope="col">Email</th>
                            <th scope="col">Tổng sản phẩm</th>
                            <th scope="col">Tổng tiền</th>
                            <th scope="col">Trạng thái</th>
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
        $('#bill-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{!! route('bill.data') !!}',
            columns: [
                { data: 'id', name: 'id' },
                { data: 'full_name', name: 'full_name' },
                { data: 'email', name: 'email' },
                { data: 'c_product', name: 'c_product' },
                { data: 'total_price', name: 'total_price' },
                { data: 'status', name: 'status' },
                { data: 'created_at', name: 'created_at' },
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ],
            "language": language,
            order: [[0, 'desc']]
        });
    });
</script>
@endsection