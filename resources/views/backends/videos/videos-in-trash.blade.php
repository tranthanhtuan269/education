@extends('backends.master')

@section('content')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.16/datatables.min.css"/>
<script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.10.16/datatables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/plug-ins/1.10.16/api/fnReloadAjax.js"></script>

<section class="content-header">
</section>

<section class="content page">
    <h1 class="text-center font-weight-600">Các bài giảng trong thùng rác</h1>
    <div class="row">
        <div class="col-md-12">
            <div class="table-responsive">
                <table class="table table-bordered" id="videoInTrashTable">
                    <thead class="thead-custom">
                        <tr>
                            <th class="id-field" width="1%">
                                <input type="checkbox" id="select-all-btn" data-check="false">
                            </th>
                            <th scope="col">Bài giảng</th>
                            <th scope="col">Xem</th>
                            <th scope="col">Khóa học</th>
                            <th scope="col">Ngày xóa</th>
                            <th scope="col">Đồng ý xóa</th>
                        </tr>
                    </thead>
                    <tbody>
                        
                    </tbody>
                </table>
                @if (Helper::checkPermissions('users.email', $list_roles))
                    <p class="action-selected-rows">
                        <span >Xóa những bài giảng đã chọn:</span>
                        <span class="btn btn-info ml-2" id="deleteAllApplied">Xóa</span>
                    </p>
                @endif
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
    .video-item{
        width: 60px;
        text-align: center;
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
                data: "rows",
                class: "rows-item",
                render: function(data, type, row){
                    return '<input type="checkbox" name="selectCol" class="check-user" value="' + data + '" data-column="' + data + '">';
                },
                orderable: false
            },
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
                data: "created_at",
                class: "created_at-name-field"
            },
            { 
                data: "action", 
                class: "action-field",
                render: function(data, type, row){
                    var html = '';
                        html += '<a class="btn btn-danger btn-delete-in-trash" data-id="'+data+'" title="Xóa"><i class="fa fa-trash fa-fw"></i></a>';

                    return html;
                },
                orderable: false
            },
        ];

        dataTable = $('#videoInTrashTable').DataTable( {
                        serverSide: false,
                        aaSorting: [],
                        stateSave: true,
                        search: {
                            smart: false
                        },
                        ajax:{
                            url: "{{ url('/') }}/admincp/get-videos-in-trash-ajax",
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
                            checkCheckboxChecked();
                        },
                        createdRow: function( row, data, dataIndex){
                            $(row).attr('data-video', data['link_video']);
                        }
                    });

        $('#videoInTrashTable').css('width', '100%');

        $('#showVideoIntroModal').on('hide.bs.modal', function () {
            $("#video-view").attr('src', '')
        })

        $("#select-all-btn").change(function(){
            $('.page table tbody input[type="checkbox"]').prop('checked', $(this).prop("checked"));
            // save localstore
            setCheckboxChecked();
        });

        $('body').on('click', '.page table tbody input[type="checkbox"]', function() {
            if(false == $(this).prop("checked")){
                $("#select-all-btn").prop('checked', false);
            }
            if ($('.page table tbody input[type="checkbox"]:checked').length == $('.page table tbody input[type="checkbox"]').length ){
                $("#select-all-btn").prop('checked', true);
            }

            // save localstore
            setCheckboxChecked();
        });

        function setCheckboxChecked(){
            userCheckList = [];
            $.each($('.check-user'), function( index, value ) {
                if($(this).prop('checked')){
                    userCheckList.push($(this).val());
                }
            });
            // console.log(userCheckList);
        }

        function checkCheckboxChecked(){
            // console.log(userCheckList);
            var count_row = 0;
            var listUser = $('.check-user');
            if(listUser.length > 0){
                $.each(listUser, function( index, value ) {
                    if(containsObject($(this).val(), userCheckList)){
                        $(this).prop('checked', 'true');
                        count_row++;
                    }
                });

                if(count_row == listUser.length){
                    $('#select-all-btn').prop('checked', true);
                }else{
                    $('#select-all-btn').prop('checked', false);
                }
            }else{
                $('#select-all-btn').prop('checked', false);
            }
        }

        function containsObject(obj, list) {
            var i;
            for (i = 0; i < list.length; i++) {
                if (list[i] === obj) {
                    return true;
                }
            }

            return false;
        }

        function addEventListener(){
            $('.view-video').off('click')
            $('.view-video').click(function(){
                var curr_video_intro = $(this).parent().parent().attr('data-video')

                $('#showVideoIntroModal').modal('show');
                // $("#video-view").attr('src', `http://education.local/uploads/videos/${curr_video_intro}`)
                $("#video-view").attr('src', `/uploads/videos/${curr_video_intro}`)
            })

            $('.btn-delete-in-trash').off('click')
            $('.btn-delete-in-trash').click(function(e){
                var video_id      = $(this).attr('data-id');
                var row = $(e.currentTarget).closest("tr");
                Swal.fire({
                    type: 'warning',
                    text: 'Xác nhận xóa bài giảng.',
                    showCancelButton: true,
                }).then(result => {
                    if(result.value){
                        $.ajaxSetup({
                            headers: {
                              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });
                        $.ajax({
                            url: baseURL+"/admincp/delete-video-in-trash",
                            data: {
                                video_id : video_id
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
            if ($('#videoInTrashTable tr').length <= 1 && current_page > 0) {
                current_page = current_page - 1;
            }
            return current_page;
        }

        $('#deleteAllApplied').off('click')
        $('#deleteAllApplied').click(function(){
            let isChecked = false;
            $.each($('.check-user'), function (key, value){
                if($(this).prop('checked') == true) {
                    return isChecked = true;
                }
            });
            if(isChecked == false){
                return Swal.fire({
                        type: 'info',
                        text: 'Bạn chưa chọn chủ đề nào!'
                    })
            }
            Swal.fire({
                type: 'warning',
                text: 'Bạn có chắc chắn muốn xóa?',
                showCancelButton: true,
            })
            .then(function (result) {
                if(result.value){
                    var video_id_list = []
                    $.each($('.check-user'), function (key, value){
                        if($(this).prop('checked') == true) {
                            // id_list += $(this).attr("data-column") + ',';
                            video_id_list.push($(this).attr("data-column"))
                        }
                    });
                    // console.log(video_id_list);
                    if(video_id_list.length > 0){
                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN'    : $('meta[name="csrf-token"]').attr('content')
                            }
                        });
                        $.ajax({
                            method: "PUT",
                            url: baseURL+"/admincp/delete-multi-video-in-trash",
                            data: {
                                video_id_list: video_id_list
                            },
                            dataType: 'json',
                            success: function (response) {
                                Swal.fire({
                                    type: 'success',
                                    text: response.message
                                })
                                dataTable.ajax.reload(); 
                            },
                            error: function (response) {
                                Swal.fire({
                                    type: 'warning',
                                    text: response.message
                                })
                            }
                        })
                    }

                }
            })
        })
    });
</script>

@endsection