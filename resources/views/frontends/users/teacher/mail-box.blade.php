@extends('frontends.layouts.app') 
@section('content')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.16/datatables.min.css"/>
<script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.10.16/datatables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/plug-ins/1.10.16/api/fnReloadAjax.js"></script>

<div class="u-dashboard-top" style="background-image:  url({{ url('frontend/images/bg-db-user.jpg') }});">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                @include('frontends.users.teacher.menu')
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
                                            <th scope="col">Người gửi</th>
                                            <th scope="col">Tiêu đề</th>
                                            <th scope="col">Nội dung</th>
                                            <th scope="col">Ngày gửi</th>
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
                    type: "html",
                    render: function(data, type, row){
                        return '<a href="javascript:void(0)" class="content-mailbox" title="Detail" data-useremailid="'+row.user_email_id+'" data-value="'+ row.content +'">' + row.title + '</a>';
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
                            stateSave: true,
                            search: {
                                smart: false
                            },
                            ajax: "{{ url('/') }}/user/getDataMailBoxTeacherAjax",
                            columns: dataObject,
                            // bLengthChange: false,
                            // pageLength: 10,
                            order: [[ 3, "desc" ]],
                            colReorder: {
                                fixedColumnsRight: 1,
                                fixedColumnsLeft: 1
                            },
                            oLanguage: {
                                sSearch: "Tìm kiếm",
                                sLengthMenu: "Hiển thị _MENU_ tin nhắn",
                                // zeroRecords: "Không tìm thấy bản ghi",
                                sInfo: "Hiển thị  _START_ - _END_ /_TOTAL_ tin nhắn",
                                sInfoFiltered: "",
                                sInfoEmpty: "",
                                sZeroRecords: "Không tìm thấy kết quả tìm kiếm",
                                sEmptyTable: "Bạn chưa có Email",
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
            $('body').on('click', '.content-mailbox', function() {
                $('#myModalContentMailBox h4.modal-title').html( $(this).text() );                

                var user_email_id = $(this).attr('data-useremailid')
                var self = $(this)

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    method: 'GET',
                    url: '/user/getSingleEmailContentAjax',
                    data: {
                        user_email_id : user_email_id,
                    },
                    dataType: 'json',
                    success: function (response) {
                        $('#myModalContentMailBox .modal-body').html(response.email_html); 
                        $('#myModalContentMailBox').modal('show');
                        if(self.parent().parent().attr('style').length > 0){
                            var note_number = parseInt($('.unica-sl-notify b').text())
                            if(note_number - 1 > 0){
                                $('.unica-sl-notify b').text(note_number-1)
                            }else{
                                $('.unica-sl-notify').css('display', 'none')
                            }
                        }
                        self.parent().parent().attr('style','')
                    },
                    error: function (response) {
                        Swal.fire({
                            type: 'warning',
                            text: 'There was a problem while getting email content'
                        })
                    }
                })

            });
    
        });
    </script>
@endsection