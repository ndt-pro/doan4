
<!-- Card stats -->
<div class="row mb-2 not-print">
    <div class="col-xl-3 col-lg-6">
        <div class="card card-stats mb-4 mb-xl-0">
            <div class="card-body">
            <div class="row">
                <div class="col">
                <h5 class="card-title text-uppercase text-muted mb-0">Tổng đơn hàng</h5>
                <span class="h2 font-weight-bold mb-0">{{ $bills }}</span>
                </div>
                <div class="col-auto">
                <div class="avatar avatar-xl bg-danger mr-1">
                    <div class="avatar-content">
                        <i class="avatar-icon feather icon-pie-chart"></i>
                    </div>
                </div>
                </div>
            </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-lg-6">
        <div class="card card-stats mb-4 mb-xl-0">
            <div class="card-body">
            <div class="row">
                <div class="col">
                <h5 class="card-title text-uppercase text-muted mb-0">Đơn hàng mới</h5>
                <span class="h2 font-weight-bold mb-0">{{ $new_bills }}</span>
                </div>
                <div class="col-auto">
                    <div class="avatar avatar-xl bg-success mr-1">
                        <div class="avatar-content">
                            <i class="avatar-icon feather icon-pie-chart"></i>
                        </div>
                    </div>
                </div>
            </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-lg-6">
        <div class="card card-stats mb-4 mb-xl-0">
            <div class="card-body">
            <div class="row">
                <div class="col">
                <h5 class="card-title text-uppercase text-muted mb-0">Thành viên</h5>
                <span class="h2 font-weight-bold mb-0">{{ $users }}</span>
                </div>
                <div class="col-auto">
                    <div class="avatar avatar-xl bg-warning mr-1">
                        <div class="avatar-content">
                            <i class="avatar-icon feather icon-user"></i>
                        </div>
                    </div>
                </div>
            </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-lg-6">
        <div class="card card-stats mb-4 mb-xl-0">
            <div class="card-body">
            <div class="row">
                <div class="col">
                <h5 class="card-title text-uppercase text-muted mb-0">Tổng sản phẩm</h5>
                <span class="h2 font-weight-bold mb-0">{{ $products }}</span>
                </div>
                <div class="col-auto">
                    <div class="avatar avatar-xl bg-primary mr-1">
                        <div class="avatar-content">
                            <i class="avatar-icon feather icon-box"></i>
                        </div>
                    </div>
                </div>
            </div>
            </div>
        </div>
    </div>
</div>