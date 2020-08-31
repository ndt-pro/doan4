@extends('admin.layouts.master')

@section('content')
<div class="row">
    <div class="col-xl-12 mb-5 mb-xl-0">
        <div class="card">
            <div class="card-header">
                <div class="col-md-6">
                    <h3>Danh sách người dùng</h3>
                </div>
                <div class="col-md-6 text-right">
                    <a href="{{ route('users.them') }}" class="btn btn-outline-primary">
                        <span class="d-none d-md-block"><i class="fa fa-plus-circle"></i> Thêm người dùng</span>
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
                    <table class="table table-striped" id="users-table">
                        <thead>
                            <tr>
                            <th scope="col">#</th>
                            <th scope="col">Họ tên</th>
                            <th scope="col">Email</th>
                            <th scope="col">Số điện thoại</th>
                            <th scope="col">Ngày đăng ký</th>
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
        $('#users-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{!! route('users.data') !!}',
            columns: [
                { data: 'id', name: 'id' },
                { data: 'full_name', name: 'full_name' },
                { data: 'email', name: 'email' },
                { data: 'phone_number', name: 'phone_number' },
                { data: 'created_at', name: 'created_at' },
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ],
            "language": language,
            order: [[0, 'desc']]
        });
    });
</script>
@endsection