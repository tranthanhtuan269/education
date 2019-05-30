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
                    <div class="tabbable-line">
                        <ul class="nav nav-tabs">
                            <li class="active">
                                <a href="#buyed" class="buyed" data-toggle="tab"><i class="fas fa-envelope"></i>&nbsp;&nbsp;Mailbox</a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane active">
                                <table class="table table-bordered" id="order-table">
                                    <thead class="thead-custom">
                                        <tr>
                                            <th scope="col">Code</th>
                                            <th scope="col">Total price</th>
                                            <th scope="col">Status</th>
                                            <th scope="col">Created at</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
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
                        return '<a href="javascript:void(0)" data-id="'+row.id+'" class="detail-order" title="Detail" data-value="'+ row.code +'">' + row.code + '</a>';
                    },
                },
                { 
                    data: "total_price",
                    // class: "hide"
                },
                { 
                    data: "status",
                    render: function(data, type, row){
                        var status = '';
                        if (row.status == 0) {
                            status = '<span class="btn btn-sm text-center btn-warning">Unapproved</span>';
                        } else if(row.status == 1) {
                            status = '<span class="btn btn-sm text-center btn-success" >Approved</span>';
                        } else if(row.status == 2) {
                            status = '<span class="btn btn-sm text-center btn-danger" >Cancelled</span>';
                        }
                        return status;
                    },
                },
                { 
                    data: "created_at",
                },
            ];
    
            dataTable = $('#order-table').DataTable( {
                            serverSide: false,
                            aaSorting: [],
                            stateSave: false,
                            ajax: "{{ url('/') }}/user/getDataOrderAjax",
                            columns: dataObject,
                            // bLengthChange: false,
                            // pageLength: 10,
                            order: [[2, "desc" ]],
                            colReorder: {
                                fixedColumnsRight: 1,
                                fixedColumnsLeft: 1
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
                $.ajaxSetup(
                {
                    headers:
                    {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                var id      = $(this).attr('data-id');
                $.ajax({
                    url: '{{ url("user/student/order") }}' + '/' + id,
                    method: "GET",
                    dataType:'json',
                    success: function (response) {
                    	console.log(response);
                        $('#show-detail .modal-title').html('Chi tiết đơn hàng + id');
                        var html_data = '<table class="table"><thead><tr><th scope="col">Thông tin chung</th><th scope="col">Thông tin thanh toán</th></tr></thead><tbody>';
    
                        html_data += '<tr>';
                        html_data += '<td style="width:38%;">';
                            html_data += '<table><tbody><tr><td>Họ và tên: </td><td>' + response.infoCustomer.username + '</td></tr><tr><td>Ngày tạo: </td><td>' + response.infoCustomer.order_created_at + '</td></tr><tr><td>Trạng thái: </td><td class="status_order"><span class="btn btn-sm" style="background-color:' + response.infoCustomer.color + '">' + response.infoCustomer.order_status_name + '</span></td></tr></tbody></table>';
                        html_data += '<td style="width:62%;">';
                            html_data += '<table><tbody>';
                            html_data += '<tr><td style="width:45%;">Địa chỉ: </td><td>';
                            html_data += response.infoCustomer.address + (response.infoCustomer.district_name == null ? '' : ', ' + response.infoCustomer.district_name) + (response.infoCustomer.city_name == null ? '' : ', ' + response.infoCustomer.city_name) + '</td></tr>';
                            html_data += '<tr><td style="width:45%;">Email: </td><td>' + response.infoCustomer.email + '</td></tr>';
                            html_data += '<tr><td style="width:45%;">Số điện thoại: </td><td>' + response.infoCustomer.phone + '</td></tr>';
                            html_data += '<tr><td style="width:45%;">Phương thức thanh toán: </td><td>'+ response.infoCustomer.method_payment +'</td></tr>';
                            html_data += '</tbody></table>';
                        html_data += '</td>';
                        html_data += '</tr>';
    
                        html_data += '</tbody></table>';
    
                        html_data += '<table class="table table-bordered"><thead><tr><th scope="col">Tên sản phẩm</th><th scope="col">Số lượng</th><th scope="col">Giá</th></tr></thead><tbody>';
                        var totalValue = 0;
                        for(var i = 0; i < response.productList.length; i++){
                           html_data += '<tr>';
                           html_data += '<td>';
                           html_data += response.productList[i].name;
                           html_data += '</td>';
                           html_data += '<td>';
                           html_data += response.productList[i].pieces;
                           html_data += '</td>';
                           html_data += '<td>';
    
                           html_data += response.productList[i].sale > 0 ? numberFormat(response.productList[i].sale, 0, '.', '.') : numberFormat(response.productList[i].price, 0, '.', '.');
    
                           html_data += '</td>';
                           html_data += '</tr>';
    
                           totalValue += response.productList[i].sale > 0 ? response.productList[i].pieces * response.productList[i].sale : response.productList[i].pieces * response.productList[i].price;
                        }
                        html_data += '<tr><td></td><td><b>Tổng cộng</b></td><td style="color:red; font-size:18px;">'+ numberFormat(totalValue, 0, '.', '.') +'</td></tr>';
                        html_data += '</tbody></table>';
                        
                    	$('#show-detail .modal-body').html(html_data);
                    	$('#show-detail').modal('toggle');
                    },
                    error: function (data) {
                        if(data.status == 401){
                          window.location.replace(baseURL);
                        }else{
                         $().toastmessage('showErrorToast', errorConnect);
                        }
                    }
                });
                // $('#myModalDetailOrder h4.modal-title').html( $(this).text() ); 
                // $('#myModalDetailOrder .modal-body').html( $(this).attr("data-value") ); 
                $('#myModalDetailOrder').modal('show'); 
            });
    
        });
    </script>
@endsection