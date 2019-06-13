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
    <h1 class="text-center font-weight-600">Danh sách giảng viên</h1>
    <div class="row">
        <div class="col-md-12">
            <div class="table-responsive">
                <table class="table table-bordered" id="teacher-table">
                    <thead class="thead-custom">
                        <tr>
                            <th class="id-field" width="1%">
                                <input type="checkbox" id="select-all-btn" data-check="false">
                            </th>
                            <th scope="col">Tên giảng viên</th>
                            <th scope="col">Chuyên môn</th>
                            <th scope="col">Video giới thiệu</th>
                            <th scope="col">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        
                    </tbody>
                </table>
                @if (Helper::checkPermissions('users.email', $list_roles)) 
                    <p class="action-selected-rows">
                        <span >Hành động trên các hàng đã chọn:</span>
                        <span class="btn btn-info ml-2" id="deleteAllApplied">Xóa</span>
                    </p>  
                @endif
            </div>
        </div>
    </div>
</section>

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
                data: "rows",
                class: "rows-item",
                render: function(data, type, row){
                    return '<input type="checkbox" name="selectCol" class="check-user" value="' + data + '" data-column="' + data + '">';
                },
                orderable: false
            },
            { 
                data: "name",
                class: "name-field"
            },
            { 
                data: "expert",
                class: "expert-field"
            },
            { 
                data: "video_intro",
                class: "video-item",
                render: function(data, type, row){
                    return '<a href="'+data+'">Video intro</a>';
                },
                orderable: false
            },
            { 
                data: "action", 
                class: "action-field",
                render: function(data, type, row){
                    var html = '';
                    
                    @if (Helper::checkPermissions('users.view', $list_roles)) 
                        html += '<a class="btn-view mr-2 view-user" data-id="'+data+'" data-title="'+row.title+'" data-content="'+row.content+'" title="Xem"> <i class="fa fa-eye"></i></a>';
                    @endif
                    
                    @if (Helper::checkPermissions('users.accept-teacher', $list_roles)) 
                        html += '<a class="btn-accept mr-2 accept-user" data-id="'+data+'" data-title="'+row.title+'" data-content="'+row.content+'" title="Duyệt"> <i class="fa fa-check"></i></a>';
                    @endif

                    @if (Helper::checkPermissions('users.delete', $list_roles)) 
                        html += '<a class="btn-delete" data-id="'+data+'" title="Xóa"><i class="fa fa-trash" aria-hidden="true"></i></a>';
                    @endif

                    return html;
                },
                orderable: false
            },
        ];

        dataTable = $('#teacher-table').DataTable( {
                        serverSide: false,
                        aaSorting: [],
                        stateSave: false,
                        ajax: "{{ url('/') }}/admincp/teachers/getTeacherAjax",
                        columns: dataObject,
                        // bLengthChange: false,
                        // pageLength: 10,
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
                        }
                    });

        $('#teacher-table').css('width', '100%');

        //select all checkboxes
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
            // $('.accept-user').off('click')
            // $('.accept-user').click(function(){
            //     var id       = $(this).attr('data-id')
            //     var curr_title   = $(this).attr('data-title')
            //     var curr_content = $(this).attr('data-content')

            //     $('#editEmailModal').modal('show');
            //     $('#editEmail').attr("data-id", id)
            //     $("#edit_subject_Ins").val(curr_title)
            //     edit_content_Ins.setData(curr_content)
            //     $(".alert-errors").addClass("d-none");
            // })

            $('.btn-accept').off('click')
            $('.btn-accept').click(function(){
                var _self   = $(this);
                var id      = $(this).attr('data-id');
                $.ajsrConfirm({
                    message: "Bạn có chắc chắn muốn duyệt ?",
                    okButton: "Đồng ý",
                    onConfirm: function() {
                        $.ajaxSetup({
                            headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });
                        $.ajax({
                            url: baseURL+"/admincp/teachers/accept",
                            data: {
                                teacherId : id
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
                                }else{
                                    Swal.fire({
                                        type: 'error',
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
                    },
                    nineCorners: false,
                });
            });

            $('.btn-delete').off('click')
            $('.btn-delete').click(function(){
                var _self   = $(this);
                var id      = $(this).attr('data-id');
                $.ajsrConfirm({
                    message: "Bạn có chắc chắn muốn xóa ?",
                    okButton: "Đồng ý",
                    onConfirm: function() {
                        $.ajaxSetup({
                            headers: {
                              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });
                        $.ajax({
                            url: baseURL+"/admincp/teachers/delete",
                            data: {
                                teacherId : id
                            },
                            method: "DELETE",
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
                                }else{
                                  Swal.fire({
                                      type: 'error',
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
                    },
                    nineCorners: false,
                });
            });
            
            $('#deleteAllApplied').off('click')
            $('#deleteAllApplied').click(function (){
                Swal.fire({
                    type: 'warning',
                    text: 'Bạn có chắc chắn xóa tất cả?',
                    showCancelButton: true,
                })
                .then(function (result) {
                    if(result.value){
                        var teacher_id_list = []
                        $.each($('.check-user'), function (key, value){
                            if($(this).prop('checked') == true) {
                                // id_list += $(this).attr("data-column") + ',';
                                teacher_id_list.push($(this).attr("data-column"))
                            }
                        });
                        console.log(teacher_id_list);
                        if(teacher_id_list.length > 0){
                            $.ajaxSetup({
                                headers: {
                                    'X-CSRF-TOKEN'    : $('meta[name="csrf-token"]').attr('content')
                                }
                            });
                            $.ajax({
                                method: "GET",
                                url: baseURL+"/admincp/teachers/delete-multiple-teacher",
                                data: {
                                    id_list: teacher_id_list
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
                                        type: 'error',
                                        text: response.message
                                    })
                                }
                            })
                        }
                        
                    }
                })
            })
        }

        function checkEmptyTable(){
            if ($('#teacher-table').DataTable().data().count() <= 1 && current_page > 0) {
                current_page = current_page - 1;
            }
            return current_page;
        }
        
        $("#editEmail").click(function () {
            var id = $(this).attr("data-id")
            var title = $("#edit_subject_Ins").val()
            var content = edit_content_Ins.getData()

            $.ajaxSetup({
                headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var request = $.ajax({
                method : "PUT",
                url : "edit-email",
                data : {
                    id : id,
                    title: title,
                    content: content
                },
                dataType: "json"
            })
            request.done( function (response) {
                $("#edit_subject_Ins").val("")
                edit_content_Ins.setData("")
                Swal.fire({
                    text: response.message
                })
                if(response.status == 200){
                    $("#editEmailModal").modal("hide")
                    dataTable.ajax.reload();
                }
            })
        })

    });
</script>

@endsection