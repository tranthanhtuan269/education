@extends('frontends.layouts.app') 
@section('content')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.16/datatables.min.css"/>
<script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.10.16/datatables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/plug-ins/1.10.16/api/fnReloadAjax.js"></script>

<div class="u-dashboard-top" style="background-image:  url({{ url('frontend/images/bg-db-user.jpg') }});">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                @include('frontends.users.student.menu')
            </div>
        </div>
    </div>
</div>
<div class="container">
        <div class="row">
            <div class="col-xs-12">
                <div class="box-user tabbable-panel">
                    {{-- <div class="tabbable-line"> --}}
                        {{-- <ul class="nav nav-tabs">
                            <li class="active">
                                <a href="#buyed" class="buyed" data-toggle="tab"><i class="fas fa-history"></i>&nbsp;&nbsp;Order history</a>
                            </li>
                        </ul> --}}
                        <div class="tab-content">
                            <div class="tab-pane active">
                                <table class="table table-bordered" id="order-table">
                                    <thead class="thead-custom">
                                        <tr>
                                            <th scope="col">Mã</th>
                                            <th scope="col">Tổng giá trị đơn hàng</th>
                                            <th scope="col">Tổng giá trị ẩn</th>
                                            <th scope="col">Trạng thái</th>
                                            <th scope="col">Được tạo mới</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                    {{-- </div> --}}
                </div>
            </div>
        </div>
    </div>
    <div id="show-detail-order" class="modal fade" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header text-center">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title" style="color: #00B7F1">Chi tiết đơn hàng</h4>
                    </div>
                    <div class="modal-body">
                    </div>
                </div>
            </div>
        </div>
    <script type="text/javascript">
        var dataTable           = null;
        $(document).ready(function(){
            var dataObject = [
                { 
                    data: "code",
                    render: function(data, type, row){
                        return '<a href="javascript:void(0)" class="detail-order"  title="Detail" data-id="'+row.id+'" data-course="'+row.course+'" data-coupon="'+row.coupon+'"  data-payment="'+row.payment+'"  data-status="'+row.status+'" data-total-price-real="'+ row.total_price +'" data-create="'+ row.created_at +'">' + row.code + '</a>';
                    },
                    orderable: false,
                },
                { 
                    data: "total_price",
                    render: function(data, type, row){
                        if(type == "display"){
                            return numberFormat(row.total_price, 0, '.', '.') + ' đ';
                        }
                        return data;
                    },
                },
                { 
                    data: "total_price",
                    class: "hide"
                },
                { 
                    data: "status",
                    render: function(data, type, row){
                        return statusOrder(row.status);
                    },
                    class: "text-center",
                    orderable: false,
                },
                { 
                    data: "id",
                    render: function(data, type, row){
                        if(type == "display"){
                            return row.created_at;
                        }
                        return data;
                    },
                },
            ];
    
            dataTable = $('#order-table').DataTable( {
                            serverSide: true,
                            aaSorting: [],
                            stateSave: false,
                            search: {
                                smart: false
                            },
                            ajax: "{{ url('/') }}/user/getDataOrderAjax",
                            columns: dataObject,
                            // bLengthChange: false,
                            // pageLength: 10,
                            order: [[4, "desc" ]],
                            colReorder: {
                                fixedColumnsRight: 1,
                                fixedColumnsLeft: 1
                            },
                            oLanguage: {
                                sSearch: "Tìm kiếm",
                                sLengthMenu: "Hiển thị _MENU_ đơn hàng",
                                // zeroRecords: "Không tìm thấy bản ghi",
                                sInfo: "Hiển thị  _START_ - _END_ /_TOTAL_ đơn hàng",
                                sInfoFiltered: "",
                                sInfoEmpty: "",
                                sZeroRecords: "Chưa có đơn hàng nào",
                                oPaginate: {
                                    sPrevious: "Trang trước",
                                    sNext: "Trang sau",

                                },
                            },
                            createdRow: function( row, data, dataIndex ) {
                                $(row).attr('id', 'row-' + dataIndex);
                            },
                            // oLanguage: {
                            //     sSearch: "Tìm kiếm",
                            //     sLengthMenu: "Hiển thị _MENU_ bản ghi",
                            //     // zeroRecords: "Không tìm thấy bản ghi",
                            //     sInfo: "Hiển thị  _START_ - _END_ /_TOTAL_ bản ghi",
                            //     sInfoFiltered: "",
                            //     sInfoEmpty: "",
                            //     sZeroRecords: "Không tìm thấy kết quả tìm kiếm",
                            //     oPaginate: {
                            //         sPrevious: "Trang trước",
                            //         sNext: "Trang sau",
    
                            //     },
                            // },
                            fnServerParams: function ( aoData ) {
    
                            },
                            fnDrawCallback: function( oSettings ) {
                                // addEventListener();
                                // checkCheckboxChecked();
                            }
                        });

            $('body').on('click', '.detail-order', function() {
                var id               = $(this).attr('data-id');
                var created_at       = $(this).attr('data-create');
                var status           = $(this).attr('data-status');
                var payment          = $(this).attr('data-payment');
                var total_price_real = $(this).attr('data-total-price-real');
                var coupon           = $(this).attr('data-coupon');
                var courses          = $(this).attr('data-course');
                var courses          = JSON.parse(courses);

                $('#show-detail-order .modal-title').html('Chi tiết đơn hàng #DH_' + id)
                var html_data = '<table class="table"><thead><tr><th scope="col">Thông tin chung</th><th scope="col">Thông tin thanh toán</th></tr></thead><tbody>';

                html_data += '<tr>';
                html_data += '<td style="width:38%;">';
                    html_data += '<table><tbody><tr><td style="width:45%;">Họ tên: </td><td>{{ Auth::user()->name }}</td></tr><tr><td style="width:45%;">Ngày tạo:</td><td>' + created_at + '</td></tr><tr><td>Trạng thái: </td><td style="width:45%;">' + statusOrder(status) + '</td></tr></tbody></table>';
                html_data += '<td style="width:62%;">';
                    html_data += '<table><tbody>';
                    
                    html_data += `<tr>`
                        html_data += `<td style="width:45%;">Địa chỉ: </td>`
                        html_data += `<td>`
                            html_data += `{{Auth::user()->address}}`
                        html_data += `</td>`
                    html_data += `</tr>`

                    html_data += '<tr><td style="width:45%;">Email: </td><td>{{ Auth::user()->email }}</td></tr>';
                    html_data += '<tr><td style="width:45%;">Số điện thoại: </td><td>{{ Auth::user()->phone }}</td></tr>';
                    html_data += '<tr><td style="width:45%;">Thanh toán: </td><td>' + payment + '</td></tr>';
                    html_data += '</tbody></table>';
                html_data += '</td>';
                html_data += '</tr>';

                html_data += '</tbody></table>';

                html_data += '<table class="table table-bordered"><thead><tr><th scope="col">Tên khóa học</th><th scope="col" style="text-align:right;">Giá</th></tr></thead><tbody>';
                var totalValue = 0;
                
                for(var i = 0; i < courses.length; i++){
                    
                    html_data += '<tr>';
                    html_data += '<td>';
                    html_data += courses[i].name;
                    html_data += '</td>';
                    html_data += '<td style="font-size:15px; text-align:right;">';

                    html_data += courses[i].sale > 0 ? numberFormat(courses[i].sale, 0, '.', '.') : numberFormat(courses[i].price, 0, '.', '.') + ' đ';

                    html_data += '</td>';
                    html_data += '</tr>';

                    totalValue += courses[i].sale > 0 ? 1 * courses[i].sale : 1 * courses[i].price;
                }
                html_data += '<tr><td><b>Tổng</b></td><td style="font-size:15px; text-align:right;">'+ numberFormat(totalValue, 0, '.', '.') +' đ</td></tr>';

                if (coupon != '') {
                    html_data += '<tr><td><b>Tổng giảm giá</b></td><td style="font-size:15px; text-align:right;">'+ numberFormat(totalValue - total_price_real, 0, '.', '.') +' đ</td></tr>';
                    html_data += '<tr><td><b>Tổng cộng</b></td><td style="color:red; font-size:18px; text-align:right;">'+ numberFormat(total_price_real, 0, '.', '.') +' đ</td></tr>';
                }
                html_data += '</tbody></table>';
                
                $('#show-detail-order .modal-body').html(html_data);
                $('#show-detail-order').modal('toggle');
            });
    
        });
    </script>
@endsection