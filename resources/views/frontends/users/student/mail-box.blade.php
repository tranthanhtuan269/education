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
                                <a href="#buyed" class="buyed" data-toggle="tab"><i class="fas fa-envelope"></i>&nbsp;&nbsp;Mailbox</a>
                            </li>
                        </ul> --}}
                        <div class="tab-content">
                            <div class="tab-pane active">
                                <table class="table table-bordered" id="mailbox-table">
                                    <thead class="thead-custom">
                                        <tr>
                                            <th scope="col">From</th>
                                            <th scope="col">Title</th>
                                            <th scope="col">Content</th>
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
    <div id="myModalContentMailBox" class="modal fade" role="dialog" >
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">				
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"></h4>
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
                    data: "sender",
                },
                { 
                    data: "title",
                    render: function(data, type, row){
                        return '<a href="javascript:void(0)" class="content-mailbox" title="Detail" data-value="'+ row.content +'">' + row.title + '</a>';
                    },
                },
                { 
                    data: "content",
                    class: "hide"
                },
                { 
                    data: "created_at",
                },
            ];
    
            dataTable = $('#mailbox-table').DataTable( {
                            serverSide: false,
                            aaSorting: [],
                            stateSave: false,
                            ajax: "{{ url('/') }}/user/getDataMailBoxAjax",
                            columns: dataObject,
                            // bLengthChange: false,
                            // pageLength: 10,
                            order: [[ 3, "desc" ]],
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
            $('body').on('click', '.content-mailbox', function() {
                $('#myModalContentMailBox h4.modal-title').html( $(this).text() ); 
                $('#myModalContentMailBox .modal-body').html( $(this).attr("data-value") ); 
                $('#myModalContentMailBox').modal('show'); 
            });
    
        });
    </script>
@endsection