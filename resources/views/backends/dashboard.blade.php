@extends('backends.master')
@section('title', 'System Manager')

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Dashboard
        <small>Control panel</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="javascript:void(0)"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Dashboard</li>
    </ol>
</section>
<!-- Main content -->
<section class="content">
    <!-- Small boxes (Stat box) -->
    <div class="row">
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-aqua">
                <div class="inner">
                    <h3>{{ $totalOrders }}</h3>
                    <p>Tổng số đơn hàng</p>
                </div>
                <div class="icon">
                    <i class="ion ion-bag"></i>
                </div>
                <a href="javascript:void(0)" class="small-box-footer">Xem thêm <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-yellow">
                <div class="inner">
                    <h3>{{ $totalCustomers }}</h3>
                    <p>Tổng số khách hàng đăng ký</p>
                </div>
                <div class="icon">
                    <i class="ion ion-person-add"></i>
                </div>
                <a href="{{ url('admincp/customers') }}" class="small-box-footer">Xem thêm <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-green">
                <div class="inner">
                    <h3>53<sup style="font-size: 20px">%</sup></h3>
                    <p>Bounce Rate</p>
                </div>
                <div class="icon">
                    <i class="ion ion-stats-bars"></i>
                </div>
                <a href="javascript:void(0)" class="small-box-footer">Xem thêm <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-red">
                <div class="inner">
                    <h3>65</h3>
                    <p>Unique Visitors</p>
                </div>
                <div class="icon">
                    <i class="ion ion-pie-graph"></i>
                </div>
                <a href="javascript:void(0)" class="small-box-footer">Xem thêm <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">Đơn đặt hàng mới nhất</h3>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="table-responsive">
                        <div id="show-detail" class="modal fade" tabindex="-1" role="dialog">
                            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header text-center">
                                        <h5 class="modal-title w-100" style="color: #8cc63f">Chi tiết đơn hàng </h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                    </div>
                                    <div class="modal-footer">

                                    </div>
                                </div>
                            </div>
                        </div>
                        <table class="table no-margin" id="show-detail">
                            <thead>
                                <tr>
                                    <th>Mã đơn hàng</th>
                                    <th>Ngày đặt hàng</th>
                                    <th>Trạng thái</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                    <!-- /.table-responsive -->
                </div>
                <!-- /.box-body -->
                <div class="box-footer clearfix">
                    <a href="javascript:void(0)" class="btn btn-sm btn-default btn-flat pull-right">Xem tất cả đơn hàng</a>
                </div>
                <!-- /.box-footer -->
            </div>
            <!-- /.box -->
        </div>
        <div class="col-md-6">
            <div class="box box-danger">
                <div class="box-header with-border">
                    <h3 class="box-title"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Thành viên mới nhất</font></font></h3>
                    <div class="box-tools pull-right">
                        <span class="label label-danger"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">8 thành viên mới</font></font></span>
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i>
                        </button>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body no-padding">
                    <ul class="users-list clearfix">
                        <li>
                            <img src="{{ asset('backend/template/dist/img/user1-128x128.jpg') }}" alt="Hình ảnh người dùng">
                            <a class="users-list-name" href="javascript:void(0)"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Alexander Pierce </font></font></a>
                            <span class="users-list-date"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Hôm nay</font></font></span>
                        </li>
                        <li>
                            <img src="{{ asset('backend/template/dist/img/user8-128x128.jpg') }}" alt="Hình ảnh người dùng">
                            <a class="users-list-name" href="javascript:void(0)"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Norman </font></font></a>
                            <span class="users-list-date"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Hôm qua</font></font></span>
                        </li>
                        <li>
                            <img src="{{ asset('backend/template/dist/img/user7-128x128.jpg') }}" alt="Hình ảnh người dùng">
                            <a class="users-list-name" href="javascript:void(0)"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Jane </font></font></a>
                            <span class="users-list-date"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">12 tháng 1</font></font></span>
                        </li>
                        <li>
                            <img src="{{ asset('backend/template/dist/img/user6-128x128.jpg') }}" alt="Hình ảnh người dùng">
                            <a class="users-list-name" href="javascript:void(0)"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">John </font></font></a>
                            <span class="users-list-date"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">12 Jan</font></font></span>
                        </li>
                        <li>
                            <img src="{{ asset('backend/template/dist/img/user5-128x128.jpg') }}" alt="Hình ảnh người dùng">
                            <a class="users-list-name" href="javascript:void(0)"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Alexander </font></font></a>
                            <span class="users-list-date"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">13 Jan</font></font></span>
                        </li>
                        <li>
                            <img src="{{ asset('backend/template/dist/img/user4-128x128.jpg') }}" alt="Hình ảnh người dùng">
                            <a class="users-list-name" href="javascript:void(0)"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Sarah </font></font></a>
                            <span class="users-list-date"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">14 Jan</font></font></span>
                        </li>
                        <li>
                            <img src="{{ asset('backend/template/dist/img/user3-128x128.jpg') }}" alt="Hình ảnh người dùng">
                            <a class="users-list-name" href="javascript:void(0)"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Nora </font></font></a>
                            <span class="users-list-date"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">15 tháng 1</font></font></span>
                        </li>
                        <li>
                            <img src="{{ asset('backend/template/dist/img/user8-128x128.jpg') }}" alt="Hình ảnh người dùng">
                            <a class="users-list-name" href="javascript:void(0)"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Nadia </font></font></a>
                            <span class="users-list-date"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">15 tháng 1</font></font></span>
                        </li>
                    </ul>
                    <!-- /.users-list -->
                </div>
                <!-- /.box-body -->
                <div class="box-footer text-center">
                    <a href="javascript:void(0)" class="uppercase"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Xem tất cả người dùng</font></font></a>
                </div>
                <!-- /.box-footer -->
            </div>
        </div>
    </div>
</section>


@endsection