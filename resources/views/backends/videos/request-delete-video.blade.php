@extends('backends.master')

@section('content')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.16/datatables.min.css"/>
<script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.10.16/datatables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/plug-ins/1.10.16/api/fnReloadAjax.js"></script>
<!-- Include the plugin's CSS and JS: -->
<script type="text/javascript" src="{{ url('/') }}/backend/js/bootstrap-multiselect.js"></script>
<link rel="stylesheet" href="{{ url('/') }}/backend/css/bootstrap-multiselect.css" type="text/css"/>

<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

<section class="content-header">
    
</section>
<section class="content page">
    <h1 class="text-center font-weight-600">Yêu cầu xóa bài giảng</h1>
    <div class="row">
        <div class="col-md-12">
            <div class="table-responsive">
                <table class="table table-bordered" id="video-table">
                    <thead class="thead-custom">
                        <tr>
                            {{-- <th class="id-field" width="1%">
                                <input type="checkbox" id="select-all-btn" data-check="false">
                            </th> --}}
                            <th scope="col">Bài giảng</th>
                            <th scope="col">Xem</th>
                            <th scope="col">Khóa học</th>
                            <th scope="col">Giảng viên</th>
                            <th scope="col">Ngày gửi</th>
                            <th scope="col">Xác nhận xóa</th>
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
                            {{-- <video controls> 
                                <source src="http://education.local/uploads/videos/1564716583_dYw8EtKMA8TDBpIvtNUJ2c0xXtMwAiTJBqJ5aDOc.mp4" type="video/mp4">
                            </video> --}}
                            {{-- <style>
                                .modal.fade .modal-dialog{transform:none !important;}
                            </style> --}}
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
    .course-name-field{
        width: 250px;
    }
    .delete-video, .reject-field{
        width: 60px;
        text-align: center;
    }
    .created-at{
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

        $('#edit_user_modal').on('shown.bs.modal', function () {
            // var id      = $('#userID_upd').val();
        })

        var dataObject = [
            { 
                data: "name",
                class: "name-video"
            },
            { 
                data: "link_video",
                class: "video-item",
                render: function(data, type, row){
                    return '<a class="btn-view mr-2 view-video"><i class="fa fa-video-camera fa-fw" aria-hidden="true"></i></a>';
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
                data: "updated_at",
                class: "created-at"
            },
            { 
                data: "action", 
                class: "delete-video",
                render: function(data, type, row){
                    var html = '';
                    @if (Helper::checkPermissions('videos.delete', $list_roles)) 
                        html += '<a class="btn-delete" data-id="'+data+'" title="Xóa"><i class="fa fa-trash fa-fw" aria-hidden="true"></i></a>';
                    @endif

                    return html;
                },
                orderable: false
            },
            { 
                data: "reject", 
                class: "reject-field",
                render: function(data, type, row){
                    var html = '';
                    @if (Helper::checkPermissions('videos.delete', $list_roles)) 
                        html += '<a class="btn-reject" data-id="'+data+'" title="Hủy"><i class="fa fa-minus-circle fa-fw" aria-hidden="true"></i></a>';
                    @endif

                    return html;
                },
                orderable: false
            },
        ];

        dataTable = $('#video-table').DataTable( {
                        serverSide: false,
                        aaSorting: [],
                        stateSave: true,
                        search: {
                            smart: false
                        },
                        ajax:{
                            url: "{{ url('/') }}/admincp/request-delete-videos/getRequestDeleteVideoAjax",
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
                            sEmptyTable: "Chưa có bài giảng được yêu cầu xóa",
                            oPaginate: {
                                sPrevious: "Trang trước",
                                sNext: "Trang sau",

                            },
                        },
                        fnServerParams: function ( aoData ) {

                        },
                        fnDrawCallback: function( oSettings ) {
                            addEventListener();
                            // checkCheckboxChecked();
                        },
                        createdRow: function( row, data, dataIndex){
                            if(data['state'] == 2){
                                $(row).addClass('red-row');
                            }else{
                                $(row).addClass('green-row');
                            }
                            // $(row).attr('data-cv', data['cv']);
                            $(row).attr('data-video', data['link_video']);
                        }
                    });
                    
        var search = "{{ Request::get('search') }}";

        if ( search != '') {
            dataTable.search( search ).draw();
        } else {
            dataTable.search( "" ).draw();
        }

        $('#video-table').css('width', '100%');

        // $('body').on('click', '.page table tbody input[type="checkbox"]', function() {
        //     if(false == $(this).prop("checked")){
        //         $("#select-all-btn").prop('checked', false); 
        //     }
        //     if ($('.page table tbody input[type="checkbox"]:checked').length == $('.page table tbody input[type="checkbox"]').length ){
        //         $("#select-all-btn").prop('checked', true);
        //     }

        //     // save localstore
        //     setCheckboxChecked();
        // });

        // function setCheckboxChecked(){
        //     userCheckList = [];
        //     $.each($('.check-video'), function( index, value ) {
        //         if($(this).prop('checked')){
        //             userCheckList.push($(this).val());
        //         }
        //     });
        // }

        // function checkCheckboxChecked(){
        //     var count_row = 0;
        //     var listUser = $('.check-video');
        //     if(listUser.length > 0){
        //         $.each(listUser, function( index, value ) {
        //             if(containsObject($(this).val(), userCheckList)){
        //                 $(this).prop('checked', 'true');
        //                 count_row++;
        //             }
        //         });

        //         if(count_row == listUser.length){
        //             $('#select-all-btn').prop('checked', true);
        //         }else{
        //             $('#select-all-btn').prop('checked', false);
        //         }
        //     }else{
        //         $('#select-all-btn').prop('checked', false);
        //     }
        // }

        // function containsObject(obj, list) {
        //     var i;
        //     for (i = 0; i < list.length; i++) {
        //         if (list[i] === obj) {
        //             return true;
        //         }
        //     }
        //     return false;
        // }

        $('#showVideoIntroModal').on('hide.bs.modal', function () {
            $("#video-view").attr('src', '')
        })

        function addEventListener(){
            $('.view-video').off('click')
            $('.view-video').click(function(){
                var curr_video_intro = $(this).parent().parent().attr('data-video')

                $('#showVideoIntroModal').modal('show');
                // $("#video-view").attr('src', `http://education.local/uploads/videos/${curr_video_intro}`)
                $("#video-view").attr('src', `/uploads/videos/${curr_video_intro}`)
            })

            $('.btn-delete').off('click')
            $('.btn-delete').click(function(e){
                var _self   = $(this);
                var id      = $(this).attr('data-id');
                var row = $(e.currentTarget).closest("tr");
                Swal.fire({
                    type: 'warning',
                    text: 'Bạn có chắc chắn muốn xóa ?',
                    showCancelButton: true,
                }).then(result => {
                    if(result.value){
                        $.ajaxSetup({
                            headers: {
                              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });
                        $.ajax({
                            url: baseURL+"/admincp/request-delete-videos/delete",
                            data: {
                                video_id : id
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

            $('.btn-reject').off('click')
            $('.btn-reject').click(function(e){
                var _self   = $(this);
                var id      = $(this).attr('data-id');
                var row = $(e.currentTarget).closest("tr");
                Swal.fire({
                    type: 'warning',
                    text: 'Bạn có chắc chắn muốn hủy yêu cầu?',
                    showCancelButton: true,
                }).then(result => {
                    if(result.value){
                        $.ajaxSetup({
                            headers: {
                              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });
                        $.ajax({
                            url: baseURL+"/admincp/request-delete-videos/reject",
                            data: {
                                video_id : id
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
            if ($('#video-table tr').length <= 1 && current_page > 0) {
                current_page = current_page - 1;
            }
            return current_page;
        }
    });
</script>

@endsection