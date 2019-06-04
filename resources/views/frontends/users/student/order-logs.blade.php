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
                                            <th scope="col">Code</th>
                                            <th scope="col">Total price</th>
                                            <th scope="col">Total price hide</th>
                                            <th scope="col">Status</th>
                                            <th scope="col">Created at</th>
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
                        <h4 class="modal-title" style="color: #00B7F1">Detail order</h4>
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
                        return numberFormat(row.total_price, 0, '.', '.') + ' đ';
                    },
                    // class: "hide"
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
                            order: [[4, "desc" ]],
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
                var id               = $(this).attr('data-id');
                var created_at       = $(this).attr('data-create');
                var status           = $(this).attr('data-status');
                var payment          = $(this).attr('data-payment');
                var total_price_real = $(this).attr('data-total-price-real');
                var coupon           = $(this).attr('data-coupon');
                var courses          = $(this).attr('data-course');
                var courses          = JSON.parse(courses);

                $('#show-detail-order .modal-title').html('Detail order #DH_' + id)
                var html_data = '<table class="table"><thead><tr><th scope="col">General</th><th scope="col">Info payment</th></tr></thead><tbody>';

                html_data += '<tr>';
                html_data += '<td style="width:38%;">';
                    html_data += '<table><tbody><tr><td style="width:45%;">Full name: </td><td>{{ Auth::user()->name }}</td></tr><tr><td style="width:45%;">Created at:</td><td>' + created_at + '</td></tr><tr><td>Status: </td><td style="width:45%;">' + statusOrder(status) + '</td></tr></tbody></table>';
                html_data += '<td style="width:62%;">';
                    html_data += '<table><tbody>';
                    html_data += '<tr><td style="width:45%;">Address: </td><td>{{ Auth::user()->address }}</td></tr>'
                    html_data += '<tr><td style="width:45%;">Email: </td><td>{{ Auth::user()->email }}</td></tr>';
                    html_data += '<tr><td style="width:45%;">Phone: </td><td>{{ Auth::user()->phone }}</td></tr>';
                    html_data += '<tr><td style="width:45%;">Payment: </td><td>' + payment + '</td></tr>';
                    html_data += '</tbody></table>';
                html_data += '</td>';
                html_data += '</tr>';

                html_data += '</tbody></table>';

                html_data += '<table class="table table-bordered"><thead><tr><th scope="col">Course</th><th scope="col">Quantity</th><th scope="col">Price</th></tr></thead><tbody>';
                var totalValue = 0;
                for(var i = 0; i < courses.length; i++){
                    html_data += '<tr>';
                    html_data += '<td>';
                    html_data += courses[i].name;
                    html_data += '</td>';
                    html_data += '<td>';
                    html_data += 1;
                    html_data += '</td>';
                    html_data += '<td>';

                    html_data += courses[i].sale > 0 ? numberFormat(courses[i].sale, 0, '.', '.') : numberFormat(courses[i].price, 0, '.', '.') + ' đ';

                    html_data += '</td>';
                    html_data += '</tr>';

                    totalValue += courses[i].sale > 0 ? 1 * courses[i].sale : 1 * courses[i].price;
                }
                html_data += '<tr><td></td><td><b>Total</b></td><td style="color:red; font-size:18px;">'+ numberFormat(totalValue, 0, '.', '.') +' đ</td></tr>';
                if (coupon != '') {
                    html_data += '<tr><td></td><td><b>Total real (Coupon: ' + coupon + ')</b></td><td style="color:red; font-size:18px;">'+ numberFormat(total_price_real, 0, '.', '.') +' đ</td></tr>';
                }
                html_data += '</tbody></table>';
                
                $('#show-detail-order .modal-body').html(html_data);
                $('#show-detail-order').modal('toggle');
            });
    
        });
    </script>
@endsection