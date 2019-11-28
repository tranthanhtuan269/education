@extends('backends.master')

@section('content')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.16/datatables.min.css"/>
<script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.10.16/datatables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/plug-ins/1.10.16/api/fnReloadAjax.js"></script>

<section class="content-header">
</section>

<section class="content page">
    <h1 class="text-center font-weight-600">Yêu cầu sửa bài giảng</h1>
    <div class="row">
        <div class="col-md-12">
            <div class="table-responsive">
                <table class="table table-bordered" id="editVideoTable">
                    <thead class="thead-custom">
                        <tr>
                            <th scope="col">Bài giảng</th>
                            <th scope="col">Xem</th>
                            <th scope="col">Khóa học</th>
                            <th scope="col">Giảng viên</th>
                            <th scope="col">Ngày gửi</th>
                            <th scope="col">Đồng ý</th>
                            <th scope="col">Hủy yêu cầu</th>
                        </tr>
                    </thead>
                    <tbody>
                        
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>
<section>
    <div class="modal fade" id="showVideoIntroModal" tabindex="-1">
        <div class="modal-dialog" style="transform:none">
            <div class="modal-content" >
                <div class="modal-header">
                    <h3>Xem Video</h3>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group col-sm-12 text-center">
                            <video id="video-view" controls autoplay src="" frameborder="0" width="545" height="280" allowscriptaccess="always" allowfullscreen="true"></video>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="form-group row">
                        <div class="col-sm-1"></div>
                        <div class="col-sm-11">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<style>
    .name-video{
        width: 250px;
    }
    .action-field{
        width: 60px;
    }
    .course-name-field{
        width: 250px;
    }
    .created_at-name-field{
        width: 60px;
    }
</style>
<script type="text/javascript">
    var dataTable           = null;
    var userCheckList       = [];
    var curr_user_name      = '';
    var curr_user_email     = '';
    var current_page        = 0;
    var old_search          = '';
    var errorConnect        = "Please check your internet connection and try again.";

    $(document).ready(function(){
        window.onbeforeunload = function() {
            if($('#edit_user_modal').hasClass('show') && ( 
                $('#userName_upd').val() != curr_user_name ||
                $('#userEmail_upd').val() != curr_user_email ||
                $('#userPassword_upd').val() != 'not_change' || 
                $('#passConfirm_upd').val() != 'not_change' )
                ){
                return "Bye now!";
            }
        };

        var dataObject = [
            { 
                data: "name",
                class: "name-video"
            },
            { 
                data: "link_video",
                class: "video-item",
                render: function(data, type, row){
                    if( data != null ){
                    return '<a class="btn-view mr-2 view-video"><i class="fa fa-video-camera fa-fw" aria-hidden="true"></i></a>';
                    }else{
                        return '<i class="fa fa-video-camera fa-fw" aria-hidden="true" style="color:gray"></i>';
                    }
                },
                orderable: false
            },
            {
                data: "course_name",
                class: "course-name-field"
            },
            {
                data: "teacherName",
                // class: "teacher_name-field"
            },
            {
                data: "created_at",
                class: "created_at-name-field"
            },
            { 
                data: "action", 
                class: "action-field",
                render: function(data, type, row){
                    var html = '';
                        html += '<a class="btn btn-success btn-accept-edit" data-id="'+data+'" title="Xóa"><i class="fa fa-check fa-fw"></i></a>';

                    return html;
                },
                orderable: false
            }, 
            { 
                data: "reject", 
                class: "action-field",
                render: function(data, type, row){
                    var html = '';
                        html += '<a class="btn btn-danger btn-reject-edit" data-id="'+data+'" title="Hủy"><i class="fa fa fa-trash fa-fw"></i></a>';

                    return html;
                },
                orderable: false
            },
        ];

        dataTable = $('#editVideoTable').DataTable( {
                        serverSide: false,
                        aaSorting: [],
                        stateSave: true,
                        search: {
                            smart: false
                        },
                        ajax:{
                            url: "{{ url('/') }}/admincp/request-edit-videos-ajax",
                            beforeSend: function() {
                                $(".ajax_waiting").addClass("loading");
                            }
                        }, 
                        columns: dataObject,
                        bLengthChange: true,
                        pageLength: 10,
                        order: [[ 4, "desc" ]],
                        colReorder: {
                            fixedColumnsRight: 1,
                            fixedColumnsLeft: 1
                        },
                        oLanguage: {
                            sSearch: "Tìm kiếm",
                            sLengthMenu: "Hiển thị _MENU_ bản ghi",
                            // zeroRecords: "Không tìm thấy bản ghi",
                            sInfo: "Hiển thị  _START_ - _END_ /_TOTAL_ bản ghi",
                            sInfoFiltered: "",
                            sInfoEmpty: "",
                            sZeroRecords: "Không tìm thấy kết quả tìm kiếm",
                            sEmptyTable: "Chưa có yêu cầu sửa bài giảng",
                            oPaginate: {
                                sPrevious: "Trang trước",
                                sNext: "Trang sau",

                            },
                        },
                        fnServerParams: function ( aoData ) {

                        },
                        fnDrawCallback: function( oSettings ) {
                            addEventListener();
                        },
                        createdRow: function( row, data, dataIndex){
                            $(row).attr('data-video', data['link_video']);
                        }
                    });

        $('#editVideoTable').css('width', '100%');

        $('#showVideoIntroModal').on('hide.bs.modal', function () {
            $("#video-view").attr('src', '')
        })

        function addEventListener(){
            $('.view-video').off('click')
            $('.view-video').click(function(){
                var curr_video_intro = $(this).parent().parent().attr('data-video')

                $('#showVideoIntroModal').modal('show');
                $("#video-view").attr('src', `/uploads/videos/${curr_video_intro}`)
            })

            $('.btn-accept-edit').off('click')
            $('.btn-accept-edit').click(function(e){
                var _self   = $(this);
                var id      = $(this).attr('data-id');
                var row = $(e.currentTarget).closest("tr");
                Swal.fire({
                    type: 'warning',
                    text: 'Xác nhận sửa bài giảng.',
                    showCancelButton: true,
                }).then(result => {
                    if(result.value){
                        $.ajaxSetup({
                            headers: {
                              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });
                        $.ajax({
                            url: baseURL+"/admincp/accept-edit-video",
                            data: {
                                temp_video_id : id
                            },
                            method: "PUT",
                            dataType:'json',
                            beforeSend: function(r, a){
                                current_page = dataTable.page.info().page;
                            },
                            success: function (response) {
                                if(response.status == 200){
                                    Swal.fire({
                                        type: 'success',
                                        text: response.message
                                    })
                                    dataTable.row( row ).remove().draw(true);
                                    dataTable.page( checkEmptyTable() ).draw( false );
                                }else{
                                  Swal.fire({
                                      type: 'warning',
                                      text: response.message
                                  })
                                }
                            },
                            error: function (data) {
                                if(data.status == 401){
                                  window.location.replace(baseURL);
                                }else{
                                 $().toastmessage('showErrorToast', errorConnect);
                                }
                            }
                        });
                    }
                })
            });

            $('.btn-reject-edit').off('click')
            $('.btn-reject-edit').click(function(e){
                var _self   = $(this);
                var id      = $(this).attr('data-id');
                var row = $(e.currentTarget).closest("tr");
                Swal.fire({
                    type: 'warning',
                    text: 'Xác nhận hủy yêu cầu.',
                    showCancelButton: true,
                }).then(result => {
                    if(result.value){
                        $.ajaxSetup({
                            headers: {
                              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });
                        $.ajax({
                            url: baseURL+"/admincp/reject-edit-video",
                            data: {
                                temp_video_id : id
                            },
                            method: "PUT",
                            dataType:'json',
                            beforeSend: function(r, a){
                                current_page = dataTable.page.info().page;
                            },
                            success: function (response) {
                                if(response.status == 200){
                                    Swal.fire({
                                        type: 'success',
                                        text: response.message
                                    })
                                    dataTable.row( row ).remove().draw(true);
                                    dataTable.page( checkEmptyTable() ).draw( false );
                                }else{
                                  Swal.fire({
                                      type: 'warning',
                                      text: response.message
                                  })
                                }
                            },
                            error: function (data) {
                                if(data.status == 401){
                                  window.location.replace(baseURL);
                                }else{
                                 $().toastmessage('showErrorToast', errorConnect);
                                }
                            }
                        });
                    }
                })
            });
        }

        function checkEmptyTable(){
            if ($('#editVideoTable tr').length <= 1 && current_page > 0) {
                current_page = current_page - 1;
            }
            return current_page;
        }
    });
</script>

@endsection