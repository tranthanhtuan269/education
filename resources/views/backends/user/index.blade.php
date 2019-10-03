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
    <h1 class="text-center font-weight-600">Danh sách tài khoản</h1>
    @if (Helper::checkPermissions('users.add', $list_roles))
        <div class="add-item text-center">
            <a id="create_user" data-toggle="modal" data-target="#add_user_modal" class="btn btn-success btn-sm" title="Thêm tài khoản"><i class="fa fa-plus"></i> Thêm tài khoản</a>
        </div>
    @endif
</section>
<section class="content page">
    <div class="row">
        <div class="col-md-12">
            <div class="table-responsive">
                <table class="table table-bordered" id="account-table">
                    <thead class="thead-custom">
                        <tr>
                            <th class="id-field" width="1%">
                                <input type="checkbox" id="select-all-btn" data-check="false">
                            </th>
                            <th scope="col">Tên</th>
                            <th scope="col">Email</th>
                            <th scope="col">Vai trò</th>
                            <th scope="col">Status</th>
                            <th scope="col">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
                @if (Helper::checkPermissions('users.delete', $list_roles))
                    <p class="action-selected-rows">
                        <span >Hành động trên các hàng đã chọn:</span>
                        {{-- <span class="btn btn-info ml-2" id="apply-all-btn">Xóa</span> --}}
                        <span class="btn btn-info ml-5" id="openMultipleEmailModal">Gửi Emails</span>
                    </p>
                @endif
            </div>
        </div>
    </div>
    <div id="edit_user_modal" class="modal fade" tabindex="-1" role="dialog">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title font-weight-600">Chỉnh sửa tài khoản</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
                <div class="nav-tabs-custom" style="margin:unset !important; box-shadow: unset !important; ">
                    <ul class="nav nav-tabs">
                        <li id="toggle_tab_edit_admin" class="active"><a href="#tab_edit_admin" data-toggle="tab" aria-expanded="true">Sửa người quản trị</a></li>
                        <li id="toggle_tab_edit_teacher" ><a href="#tab_edit_teacher" data-toggle="tab" aria-expanded="false">Sửa Giảng viên</a></li>
                        <li id="toggle_tab_edit_student"><a href="#tab_edit_student" data-toggle="tab" aria-expanded="false">Sửa Học Viên</a></li>
                        <button class="btn bg-olive btn-flat pull-right" id="btnSwitchToTeacher" data-user-id>Chuyển thành giảng viên</button>
                        <button class="btn bg-red btn-flat pull-right" id="btnSwitchOffTeacher" data-user-id>Khoá giảng viên</button>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab_edit_admin">
                            @include('backends.user.modals.edit-admin-modal')
                        </div>
                        <div class="tab-pane" id="tab_edit_teacher">
                            @include('backends.user.modals.edit-teacher-modal')
                        </div>
                        <div class="tab-pane" id="tab_edit_student">
                            @include('backends.user.modals.edit-student-modal')
                        </div>
                    </div>
                </div>
          </div>
        </div>
      </div>
    </div>

    <div id="add_user_modal" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title font-weight-600">Thêm tài khoản</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="nav-tabs-custom" style="margin:unset !important; box-shadow: unset !important;">
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#tab_add_admin" data-toggle="tab" aria-expanded="true">Thêm người quản trị</a></li>
                            <li class=""><a href="#tab_add_teacher" data-toggle="tab" aria-expanded="false">Thêm Giảng viên</a></li>
                            <li class=""><a href="#tab_add_student" data-toggle="tab" aria-expanded="false">Thêm Học Viên</a></li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane active" id="tab_add_admin">
                                    <div class="form-group row">
                                        <label  class="col-sm-4 col-form-label">Tên <span class="text-danger">*</span></label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="userName_Ins" name="name" autocomplete="userName_Ins" value="{{ Request::old('name') }}">
                                            <div class="alert-errors d-none" role="alert" id="nameErrorIns">

                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="userEmail_upd" class="col-sm-4 col-form-label">Email <span class="text-danger">*</span></label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="email_Ins" name="email" autocomplete="email_Ins"  value="{{ Request::old('email') }}">
                                            <div class="alert-errors d-none" role="alert" id="emailErrorIns">

                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="userPassword" class="col-sm-4 col-form-label">Mật khẩu <span class="text-danger">*</span></label>
                                        <div class="col-sm-8">
                                            <input type="password" class="form-control" id="password_Ins" name="password" autocomplete="password_Ins" value="{{ Request::old('password') }}">
                                            <div class="alert-errors d-none" role="alert" id="passwordErrorIns">

                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="passConfirm" class="col-sm-4 col-form-label">Nhập lại mật khẩu <span class="text-danger">*</span></label>
                                        <div class="col-sm-8">
                                            <input type="password" class="form-control" id="confirmpassword_Ins" name="confirmpassword" autocomplete="confirmpassword_Ins" value="{{ Request::old('confirmpassword') }}">
                                            <div class="alert-errors d-none" role="alert" id="confirmpasswordErrorIns"></div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="userEmail_upd" class="col-sm-4 col-form-label">Vai trò <span class="text-danger">*</span></label>
                                        <div class="col-sm-8">
                                            <select id="role-list-ins" multiple="multiple">
                                                @foreach ($roles as $role)
                                                    @if ($role->id != 2 && $role->id != 3)
                                                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                            <div class="alert-errors d-none" role="alert" id="role_idErrorIns"></div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-primary" id="createUser">Thêm mới</button>
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal" id="closeCreateUser">Hủy bỏ</button>
                                    </div>
                            </div>
                            <!-- /.tab-pane -->
                            <div class="tab-pane" id="tab_add_teacher">
                            @include('backends.user.modals.add-teacher-modal')
                            </div>
                            <!-- /.tab-pane -->
                            <div class="tab-pane" id="tab_add_student">
                            @include('backends.user.modals.add-student-modal')
                            </div>
                        <!-- /.tab-pane -->
                        </div>
                    <!-- /.tab-content -->
                    </div>
                </div>
                <div style="display:none;" class="modal-footer">
                </div>

            </div>

        </div>
    </div>

    <div class="modal fade" tabindex="-1" role="dialog" id="sendEmailModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4>Gửi Email</h4>
                </div>
                <div class="modal-body">
                    <div class="row my-4">
                        <div class="col-md-3">
                            Người gửi :
                        </div>
                        <div class="col-md-9">
                            <span id="recipientName"></span>
                        </div>
                    </div>
                    <div class="row my-4">
                        <div class="col-md-3">
                            Email :
                        </div>
                        <div class="col-md-9">
                            <span id="recipientEmail"></span>
                        </div>
                    </div>
                    <div class="row my-4">
                        <div class="col-md-3">
                            Chủ đề :
                        </div>
                        <div class="col-md-9">
                            <select class="form-control" name="emailType" id="selectedTemplate">
                                @foreach ($emailTemplates as $emailTemplate)
                                <option value="{{$emailTemplate->id}}">{{$emailTemplate->title}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" data-userId id="sendEmail">Gửi</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" id="cancelEmail">Hủy bỏ</button>
                </div>
            </div>
        </div>
    </div>

    <div id="sendMultipleEmailModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4>Gửi email cho nhiều người dùng</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-2">
                            Chủ đề :
                        </div>
                        <div class="col-md-10">
                            <select class="form-control" name="emailType" id="mulSelectedTemplate">
                                @foreach ($emailTemplates as $emailTemplate)
                                <option value="{{$emailTemplate->id}}">{{$emailTemplate->title}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" id="sendMultipleEmail">Gửi</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" id="cancelAddEmail">Hủy bỏ</button>
                </div>
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

    const imageEdit = document.getElementById('imageEditTch');
    const cropperEdit = new Cropper(imageEdit, {
        viewMode: 1,
        aspectRatio: 1,
        autoCropArea: 1,
        scalable: true,
        zoomable: true,
        zoomOnTouch: false,
        cropBoxResizable: false,
        rotatable: true,
        dragMode: 'none',
    });

    const imageEditStu = document.getElementById('imageEditStu');
    const cropperEditStu = new Cropper(imageEditStu, {
        viewMode: 1,
        aspectRatio: 1,
        autoCropArea: 1,
        scalable: true,
        zoomable: true,
        zoomOnTouch: false,
        cropBoxResizable: false,
        rotatable: true,
        dragMode: 'none',
        // modal: false,
    });


    $(document).ready(function(){
        // $("input").attr('autocomplete', "off")

        // DuongNT - Khoá giảng viên
        $('#btnSwitchOffTeacher').click(function(){
            var user_id = $(this).attr('data-user-id')
            Swal.fire({
                type: 'warning',
                text: 'Bạn có chắc chắn muốn bỏ chức năng giảng viên của tài khoản này?',
                showCancelButton: true,
            }).then((result)=>{
                if(result.value){
                    $.ajax({
                        method: 'POST',
                        url: `{{ url('/admincp/') }}/users/disable-teacher`,
                        data:{
                            '_method': 'PUT',
                            'user_id' : user_id
                        },
                        success: response => {
                            if(response.status == 200){
                                Swal.fire({
                                    type: 'success',
                                    text: response.message
                                })
                                // $('#tab_edit_teacher').hide()
                                $("#toggle_tab_edit_teacher").show()
                                $('#toggle_tab_edit_teacher').removeClass('active')
                                $('#tab_edit_teacher').removeClass('active')
                                $('#toggle_tab_edit_admin').addClass('active')
                                $('#tab_edit_admin').addClass('active')
                                $('#edit_user_modal').modal('hide')
                                dataTable.ajax.reload();

                            }
                        },
                        error: error => {
                            Swal.fire({
                                type: 'warning',
                                text: 'Có lỗi!'
                            })
                        }
                    })
                }
            })
        })

        // DuongNT - Chuyển thành giảng viên
        $("#btnSwitchToTeacher").click(function(){
            $('#toggle_tab_edit_student').fadeOut()
            $('#toggle_tab_edit_student').removeClass('active')
            $('#tab_edit_student').fadeOut()
            $('#tab_edit_student').removeClass('active')

            $("#toggle_tab_edit_teacher").fadeIn()
            $('#toggle_tab_edit_teacher').addClass('active')
            $('#tab_edit_teacher').fadeIn()
            $('#tab_edit_teacher').addClass('active')

            $('#toggle_tab_edit_admin').removeClass('active')
            $('#tab_edit_admin').removeClass('active')
            $('#editTchExpert').val('')
            $('#editTchYoutube').val('')
            editTchCvEditor.setData()

            var user_id = $(this).attr('data-user-id')
            $.ajax({
                url: baseURL+"/admincp/users/getInfoByID/" + user_id,
                method: "GET",
                dataType:'json',
                success: function (response) {
                    var html_data = '';
                    if(response.status == 200){
                        // $("#userPassword_upd").val(response.user.password);
                        // $("#passConfirm_upd").val(response.user.password);

                        $("#toggle_tab_edit_teacher").show()
                        $("#editTchName").val(response.user.name)
                        $('#editTchEmail').val(response.user.email)
                        $('#editTchPhone').val(response.user.phone)
                        $('#editTchDob').datepicker("setDate", new Date(response.user.birthday))
                        $('#editTchGender').val(response.user.gender)
                        $('#editTchAddress').val(response.user.address)
                        $('#saveEditTeacher').attr('data-user-id', response.user.id)

                        cropperEdit.destroy()
                        $("#imageEditTch").removeClass('cropper-hidden')
                        $(".cropper-container").hide()
                        $("#imageEditTch").attr("src", `/frontend/${response.user.avatar}`)

                        // $('#btnSwitchToTeacher').hide()
                        // $('#btnSwitchOffTeacher').show()

                    }else{
                        Swal.fire({
                            type: 'warning',
                            text: response.Message
                        })
                        $("#toggle_tab_edit_teacher").hide()
                    }
                },
                error: function (data) {
                    if(data.status == 401){
                    window.location.replace(baseURL);
                    }else{
                        Swal.fire({
                            type: 'warning',
                            text: errorConnect
                        })
                    }
                }
            });
        })

        $('#openMultipleEmailModal').click(function(){
            let isChecked = false
            $.each($('.check-user'), function (key, value){
                if($(this).prop('checked') == true) {
                    isChecked = true;
                    return $('#sendMultipleEmailModal').modal('show')
                }

            })
            if(isChecked == false){
                return Swal.fire({
                    type: 'info',
                    text: 'Bạn chưa chọn tài khoản nào!'
                })
            }
        })

        function getRoleList($id){
            var id      = $id;
            $.ajax({
                url: baseURL+"/admincp/roles/getRoleByID/" + id,
                method: "GET",
                dataType:'html',
                success: function (response) {
                    $('#userPassword_upd').val("")
                    $('#passConfirm_upd').val("")
                    $("#role-list-ins-edit").html(response);

                    $('#role-list-ins-edit').multiselect({
                        includeSelectAllOption: true,
                        includeSelectAllIfMoreThan: 0,
                        numberDisplayed: 2,
                        enableClickableOptGroups: true,
                    });
                    $('#role-list-ins-edit').multiselect('rebuild')

                    $.ajax({
                        url: baseURL+"/admincp/users/getInfoByID/" + id,
                        method: "GET",
                        dataType:'json',
                        success: function (response) {
                            var html_data = '';
                            if(response.status == 200){
                                // $("#userPassword_upd").val(response.user.password);
                                // $("#passConfirm_upd").val(response.user.password);
                                $('#btnSwitchOffTeacher').attr('data-user-id', response.user.id)
                                $('#btnSwitchToTeacher').attr('data-user-id', response.user.id)
                                $('#editStudent').attr('data-user-id', response.user.id)

                                $('#editStuName').val(response.user.name)
                                $('#editStuEmail').val(response.user.email)
                                $('#editStuPhone').val(response.user.phone)
                                $('#editStuDob').datepicker("setDate", new Date(response.user.birthday))
                                $('#editStuGender').val(response.user.gender)
                                $('#editStuAddress').val(response.user.address)
                                $("#imageEditStu").attr("src", `/frontend/${response.user.avatar}`)
                                cropperEditStu.destroy()
                                $("#imageEditStu").removeClass('cropper-hidden')
                                $(".cropper-container").hide()

                                if(response.isStudent){
                                    $("#toggle_tab_edit_admin").hide()
                                    $("#toggle_tab_edit_admin").removeClass('active')
                                    $('#tab_edit_admin').hide()
                                    $('#tab_edit_admin').removeClass('active')

                                    // $("#toggle_tab_edit_teacher").hide()
                                    // $("#toggle_tab_edit_teacher").removeClass('active')
                                    // $('#tab_edit_teacher').hide()
                                    // $('#tab_edit_teacher').removeClass('active')

                                    $("#toggle_tab_edit_student").show()
                                    $("#toggle_tab_edit_student").addClass('active')
                                    $('#tab_edit_student').show()
                                    $('#tab_edit_student').addClass('active')
                                }


                                if(response.isTeacher){
                                    $("#toggle_tab_edit_teacher").show()
                                    $("#toggle_tab_edit_teacher").addClass('active')
                                    $('#tab_edit_teacher').show()
                                    $('#tab_edit_teacher').addClass('active')


                                    $("#btnSwitchOffTeacher").show()
                                    $("#btnSwitchToTeacher").hide()
                                    $("#toggle_tab_edit_teacher").show()
                                    $("#editTchName").val(response.user.name)
                                    $('#editTchEmail').val(response.user.email)
                                    $('#editTchPhone').val(response.user.phone)
                                    $('#editTchDob').datepicker("setDate", new Date(response.user.birthday))
                                    $('#editTchGender').val(response.user.gender)
                                    $('#editTchAddress').val(response.user.address)
                                    $('#editTchExpert').val(response.teacher_info.expert)
                                    $('#editTchYoutube').val(response.teacher_info.video_intro)
                                    editTchCvEditor.setData(response.teacher_info.cv)
                                    $('#saveEditTeacher').attr('data-user-id', response.user.id)

                                    cropperEdit.destroy()
                                    $("#imageEditTch").removeClass('cropper-hidden')
                                    $(".cropper-container").hide()
                                    $("#imageEditTch").attr("src", `/frontend/${response.user.avatar}`)

                                    //Ẩn tab student
                                    $("#toggle_tab_edit_student").hide()
                                    $("#toggle_tab_edit_student").removeClass('active')
                                    $('#tab_edit_student').hide()
                                    $('#tab_edit_student').removeClass('active')

                                }else{
                                    $("#btnSwitchOffTeacher").hide()
                                    $("#btnSwitchToTeacher").show()

                                    //Ẩn tab teacher
                                    $("#toggle_tab_edit_teacher").hide()
                                    $("#toggle_tab_edit_teacher").removeClass('active')
                                    $('#tab_edit_teacher').hide()
                                    $('#tab_edit_teacher').removeClass('active')
                                }

                                if(!response.isTeacher && !response.isStudent){
                                    $('#btnSwitchToTeacher').hide()
                                    $('#btnSwitchOffTeacher').hide()

                                    $("#toggle_tab_edit_admin").show()
                                    $("#toggle_tab_edit_admin").addClass('active')
                                    $('#tab_edit_admin').show()
                                    $('#tab_edit_admin').addClass('active')

                                    $("#toggle_tab_edit_teacher").hide()
                                    $("#toggle_tab_edit_teacher").removeClass('active')
                                    $('#tab_edit_teacher').hide()
                                    $('#tab_edit_teacher').removeClass('active')

                                    $("#toggle_tab_edit_student").hide()
                                    $("#toggle_tab_edit_student").removeClass('active')
                                    $('#tab_edit_student').hide()
                                    $('#tab_edit_student').removeClass('active')
                                }


                            }else{
                                Swal.fire({
                                    type: 'warning',
                                    text: response.Message
                                })
                                $("#toggle_tab_edit_teacher").hide()
                            }
                        },
                        error: function (data) {
                            if(data.status == 401){
                            window.location.replace(baseURL);
                            }else{
                                Swal.fire({
                                    type: 'warning',
                                    text: errorConnect
                                })
                            }
                        }
                    });
                },
                error: function (data) {
                    if(data.status == 401){
                      window.location.replace(baseURL);
                    }else{
                        Swal.fire({
                                type: 'warning',
                                text: errorConnect
                            })
                    }
                }
            });
        }

        $('#role-list-ins').multiselect({
            includeSelectAllOption: true,
            includeSelectAllIfMoreThan: 0,
            numberDisplayed: 2,
            enableClickableOptGroups: true,
            onInitialized: function(select, container) {
                var studentInput = $(container).find('input[value="3"]')// không cho chỉnh sửa student
                var teacherInput = $(container).find('input[value="2"]') // không cho chỉnh sửa teacher
                studentInput.prop('disabled', true)
                teacherInput.prop('disabled', true)

            },
            onChange: function(element, checked){
                const role_id = element.attr('value')
                if(checked === true){
                    if(role_id == 1){ //nếu chọn super-admin thì chọn cả teacher và student
                        $('#role-list-ins').multiselect('select', ['2', '3'])
                    }else if(role_id == 2){ //nếu chọn teacher thì chọn cả student
                        $('#role-list-ins').multiselect('select', ['3'])
                    }

                }else if(checked === false){
                    if(role_id == 3){ //nếu bỏ chọn student thì bỏ chọn cả teacher
                        $('#role-list-ins').multiselect('deselect', ['2'])
                    }
                }else{
                    $("#role-list-ins").multiselect('select', element.val());
                }
            }
        });


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
            var id      = $('#userID_upd').val();
             getRoleList(id);


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
                data: "email",
                class: "email-field"
            },
            {
                data: "role_name",
                class: "role_name-field",
                render: function(data, type, row){
                    return data;
                },
            },
            {
                data: "action",
                class: "action-field",
                render: function(data, type, row){
                    var html = '';

                    @if (Helper::checkPermissions('users.block-user', $list_roles))
                        if(row['status'] == 0){
                            html += '<a class="btn-block block-user" data-id="'+data+'" data-title="'+row.title+'" data-content="'+row.content+'" title="Block"><i class="fa fa-times fa-fw"></i></a>';
                        }else{

                            html += '<a class="btn-block not-block-user" data-id="'+data+'" data-title="'+row.title+'" data-content="'+row.content+'" title="Unblock"><i class="fa fa-check fa-fw"></i></a>';
                        }

                    @endif
                    return html;
                },
                orderable: false
            },
            {
                data: "action",
                class: "action-field",
                render: function(data, type, row){
                    var html = '';
                    @if (Helper::checkPermissions('users.edit', $list_roles))
                        html += '<a class="btn-send-email" data-toggle="modal" data-target="#sendEmailModal" data-id="'+data+'" data-name="'+row.name+'" data-email="'+row.email+'" title="Gửi"><i class="fa fa-envelope-square fa-fw" aria-hidden="true"></i></a>';
                    @endif

                    @if (Helper::checkPermissions('users.edit', $list_roles))
                        html += '<a class="btn-edit mr-2 edit-user" data-id="'+data+'" data-name="'+row.name+'" data-email="'+row.email+'" title="Sửa"> <i class="fa fa-edit fa-fw"></i></a>';
                    @endif

                    return html;
                },
                orderable: false
            },
        ];

        dataTable = $('#account-table').DataTable( {
                        serverSide: false,
                        // aaSorting: [],
                        stateSave: true,
                        search: {
                            smart: false
                        },
                        ajax: "{{ url('/') }}/admincp/users/getDataAjax",
                        columns: dataObject,
                        // bLengthChange: false,
                        // pageLength: 10,
                        order: [[ 1, "desc" ]],
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
                        },
                        // "searching": false,
                    });

        $('#account-table').css('width', '100%');

        // $('#user-table').on( 'page.dt', function () {
        //     $('html,body').animate({
        //         scrollTop: $("#user-table").offset().top},
        //         'slow');
        // } );

        // dataTable.search("").draw();

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
            $('.edit-user').off('click');
            $('.edit-user').click(function(){
                var id              = $(this).attr('data-id');
                curr_user_name            = $(this).attr('data-name');
                curr_user_email           = $(this).attr('data-email');

                $('#edit_user_modal').modal('show');

                $('#userID_upd').val(id);
                $('#userName_upd').val(curr_user_name);
                $('#userEmail_upd').val(curr_user_email);

                getRoleList(id)
                // $('#userPassword_upd').val("not_change");
                // $('#passConfirm_upd').val("not_change");
                $(".alert-errors").addClass("d-none");
            });

            // Begin Block User
            $('.btn-block').off('click')
            $('.btn-block').click(function(){
                var _self   = $(this);
                var id      = $(this).attr('data-id');
                // alert(id)
                var status  = 0;
                var message = "Bạn có chắc chắn muốn bỏ chặn người dùng?";
                if(_self.hasClass('not-block-user')){
                    status = 1;
                    message = "Bạn có chắc chắn muốn chặn người dùng?";
                }
                Swal.fire({
                    type: 'warning',
                   text: message,
                   showCancelButton: true,
               }).then(result => {
                   if(result.value){
                    $.ajaxSetup({
                            headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });
                        $.ajax({
                            url: baseURL+"/admincp/users/block-user",
                            data: {
                                user_id : id,
                                status : 1 - status
                            },
                            method: "PUT",
                            dataType:'json',
                            beforeSend: function(r, a){
                                current_page = dataTable.page.info().page;
                            },
                            success: function (response) {
                                if(response.status == 200){
                                    dataTable.ajax.reload();
                                    // if(_self.parent().parent()){
                                    //     _self.find('i').removeClass('fa-check').addClass('fa-times');
                                    //     _self.removeClass('not-block-user').addClass('block-user');
                                    // }else{
                                    //     _self.find('i').removeClass('fa-times').addClass('fa-check');
                                    //     _self.addClass('block-user').removeClass('not-block-user');
                                    // }
                                    if (status == 0){
                                        Swal.fire({
                                            type: 'success',
                                            text: "Bạn đã bỏ chặn thành công"
                                        })
                                    }
                                    else {
                                        Swal.fire({
                                            type: 'success',
                                            text:"Bạn đã chặn thành công"
                                        })
                                    }
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
                                    Swal.fire({
                                        type: 'warning',
                                        text: errorConnect
                                    })
                                }
                            }
                        });
                   }
               })
            });
            // End Block User

            // $('.btn-delete').off('click');
            // $('.btn-delete').click(function(){
            //     var _self   = $(this);
            //     var id      = $(this).attr('data-id');
            //     $.ajsrConfirm({
            //         message: "Bạn có chắc chắn muốn xóa ?",
            //         okButton: "Đồng ý",
            //         onConfirm: function() {
            //             var data    = {
            //                 _method             : "DELETE"
            //             };
            //             $.ajaxSetup({
            //                 headers: {
            //                   'X-CSRF-TOKEN'    : $('meta[name="csrf-token"]').attr('content')
            //                 }
            //             });
            //             $.ajax({
            //                 url: baseURL+"/admincp/users/" + id,
            //                 data: data,
            //                 method: "POST",
            //                 dataType:'json',
            //                 beforeSend: function(r, a){
            //                     current_page = dataTable.page.info().page;
            //                 },
            //                 success: function (response) {
            //                     var html_data = '';
            //                     if(response.status == 200){
            //                       dataTable.page(checkEmptyTable()).draw(false);
            //                       Swal.fire({
            //                             type: 'success',
            //                             text: response.Message
            //                         })
            //                       dataTable.ajax.reload();
            //                     }else{
            //                         Swal.fire({
            //                             type: 'warning',
            //                             text: response.Message
            //                         })
            //                     }
            //                 },
            //                 error: function (data) {
            //                     if(data.status == 401){
            //                       window.location.replace(baseURL);
            //                     }else{
            //                         Swal.fire({
            //                             type: 'warning',
            //                             text: errorConnect
            //                         })
            //                     }
            //                 }
            //             });
            //         },
            //         nineCorners: false,
            //     });
            // });

            $('.btn-send-email').off('click');
            $('.btn-send-email').click( function () {
                var userId = $(this).attr("data-id")
                var userName = $(this).attr("data-name")
                var userEmail = $(this).attr("data-email")

                $("#sendEmail").attr("data-userId", userId)
                $("#recipientName").html(userName)
                $("#recipientEmail").html(userEmail)
            })

            $('#sendEmail').off('click')
            $('#sendEmail').click( function () {
                var userId = $(this).attr('data-userid')
                var templateId = $("#selectedTemplate").val()

                $.ajaxSetup({
                    headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                var request = $.ajax({
                    method: "GET",
                    url: 'users/send-email',
                    data:{
                        user_id : userId,
                        template_id : templateId
                    }
                })

                request.done(function (response) {
                    Swal.fire({
                        text: response.message
                    })
                    if(response.status == "200"){
                        $("#sendEmailModal").modal("hide")
                    }
                })
            })
            $("#sendMultipleEmail").off('click')
            $("#sendMultipleEmail").click( function (){
                var user_id_list = []
                var templateId = $("#mulSelectedTemplate").val()
                $.each($('.check-user'), function (key, value){
                    if($(this).prop('checked') == true) {
                        user_id_list.push($(this).attr("data-column"))
                    }
                });
                if(user_id_list.length > 0){
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN'    : $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        method: 'GET',
                        url: baseURL+"/admincp/users/send-multiple-emails",
                        data: {
                            user_id_list : user_id_list,
                            template_id : templateId
                        },
                        dataType : 'json',
                        success : function (response) {
                            Swal.fire({
                                text: response.message
                            })
                            if(response.status == "200"){
                                $("#sendEmailModal").modal("hide")
                            }
                        },
                        error : function (response) {
                            Swal.fire({
                                text: response.message
                            })
                        }
                    })
                }
            })

        }

        function checkEmptyTable(){
            if ($('#account-table').DataTable().data().count() <= 1 && current_page > 0) {
                current_page = current_page - 1;
            }
            return current_page;
        }

        $('#saveUser').click(function(){
            var id = $('#userID_upd').val();
            // var name = $('#userName_upd').val();
            var password = $('#userPassword_upd').val()
            var confirmpassword = $('#passConfirm_upd').val()
            console.log(password);

            var data = {}
            if(password != ""){
                data    = {
                    // name                : name,
                    name                : $('#userName_upd').val(),
                    email               : $('#userEmail_upd').val(),
                    password            : password,
                    confirmpassword     : confirmpassword,
                    role_id             : $('#role-list-ins-edit').val(),
                    _method             : "PUT"
                };
            }else{
                data    = {
                    name                : $('#userName_upd').val(),
                    email               : $('#userEmail_upd').val(),
                    role_id             : $('#role-list-ins-edit').val(),
                    _method             : "PUT"
                }
            }
            $.ajaxSetup({
                headers: {
                  'X-CSRF-TOKEN'    : $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: baseURL+"/admincp/users/" + id,
                data: data,
                method: "POST",
                dataType:'json',
                beforeSend: function(r, a){
                    $('.alert-errors').addClass('d-none');
                    current_page = dataTable.page.info().page;
                },
                success: function (data) {
                    var html_data = '';
                    if(data.status == 200){
                        if(id == {{ Auth::user()->id }}){
                            $('#user-name-txt').html(name);
                        }
                        $('#edit_user_modal').modal('hide');
                        dataTable.page(current_page).draw(false);
                        // $().toastmessage('showSuccessToast', data.Message);
                        dataTable.ajax.reload();
                        Swal.fire({
                            type: 'success',
                            text: 'Chỉnh sửa tài khoản thành công!'
                        })
                    }else{
                        $.each(data.responseJSON.errors, function( index, value ) {
                            $('#' + index + 'ErrorUpd').html(value);
                            $('#' + index + 'ErrorUpd').removeClass('d-none');
                        });
                    }
                },
                error: function (error) {
                    var obj_errors = error.responseJSON.errors;
                    var txt_errors = '';
                    for (k of Object.keys(obj_errors)) {
                        txt_errors += obj_errors[k][0] + '</br>';
                    }
                    Swal.fire({
                        type: 'warning',
                        html: txt_errors,
                        allowOutsideClick: false,
                    })
                }
            });
        });

        // $('#apply-all-btn').click(function (){
        //     let isChecked = false;
        //     $.each($('.check-user'), function (key, value){
        //         if($(this).prop('checked') == true) {
        //             return isChecked = true;

        //         }else{
        //             return Swal.fire({
        //                 type: 'info',
        //                 text: 'Bạn chưa chọn tài khoản nào!'
        //             })
        //         }
        //     });
        //     if(isChecked){
        //         Swal.fire({
        //             type: 'warning',
        //             text: 'Bạn có chắc chắn xóa tất cả những gì bạn chọn?',
        //             showCancelButton: true,
        //         })
        //         .then(function (result) {
        //             if(result.value){
        //                 var $id_list = '';
        //                 $.each($('.check-user'), function (key, value){
        //                     if($(this).prop('checked') == true) {
        //                         $id_list += $(this).attr("data-column") + ',';
        //                     }
        //                 });

        //                 if ($id_list.length > 0) {
        //                     var data = {
        //                         id_list:$id_list,
        //                         _method:'delete'
        //                     };
        //                     $.ajaxSetup({
        //                         headers: {
        //                             'X-CSRF-TOKEN'    : $('meta[name="csrf-token"]').attr('content')
        //                         }
        //                     });
        //                     $.ajax({
        //                         type: "POST",
        //                         url: "{{ url('/') }}/admincp/users/delMultiUser",
        //                         data: data,
        //                         success: function (response) {
        //                             var obj = $.parseJSON(response);
        //                             if(obj.status == 200){
        //                                 $.each($('.check-user'), function (key, value){
        //                                     if($(this).prop('checked') == true) {
        //                                         $(this).parent().parent().hide("slow");
        //                                     }
        //                                 });
        //                                 dataTable.ajax.reload();
        //                                 Swal.fire({
        //                                     type: 'success',
        //                                     text: obj.Message
        //                                 })
        //                             }
        //                         },
        //                         error: function (data) {
        //                             if(data.status == 401){
        //                                 window.location.replace(baseURL);
        //                             }else{
        //                                 Swal.fire({
        //                                     type: 'wa',
        //                                     text: errorConnect
        //                                 })
        //                             }
        //                         }
        //                     });

        //                 }else{
        //                     Swal.fire({
        //                         type: 'warning',
        //                         text: 'Cần chọn ít nhất 1 tài khoản!'
        //                     })
        //                 }
        //             }
        //         })
        //     }
        // });

        $('#createUser').click(function(){
            var data    = {
                name             : $('#userName_Ins').val(),
                email            : $('#email_Ins').val(),
                password         : $('#password_Ins').val(),
                role_id          : $('#role-list-ins').val(),
                confirmpassword  : $('#confirmpassword_Ins').val(),
            };

            $.ajaxSetup({
                headers: {
                  'X-CSRF-TOKEN'    : $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: baseURL+"/admincp/users",
                data: data,
                method: "POST",
                dataType:'json',
                beforeSend: function(r, a){
                    $('.alert-errors').addClass('d-none');
                },
                success: function (response) {
                    var html_data = '';
                    if(response.status == 200){
                        clearFormCreate();
                        $('#add_user_modal').modal('toggle');
                        Swal.fire({
                            type: 'success',
                            text: response.Message
                        })
                        dataTable.ajax.reload();
                    } else {
                        Swal.fire({
                            type: 'warning',
                            text: response.Message
                        })
                    }
                },
                error: function (data) {
                    if(data.status == 422){
                        $.each(data.responseJSON.errors, function( index, value ) {
                            $('#'+index+'ErrorIns').html(value);
                            $('#'+index+'ErrorIns').removeClass('d-none');
                        });
                    }
                }
            });
        });

        function clearFormCreate(){
            $('#userName_Ins').val('')
            $('#email_Ins').val('')
            $('#password_Ins').val('')
            $('#confirmpassword_Ins').val('')
            $('select[name=role_id]').val(1)
            $('.alert-errors').addClass("d-none")

        }

        // $('#search_txt').keyup(function() {
        //     if($('#search_txt').val().length <= 0){
        //         dataTable.search("").draw();
        //         old_search = '';
        //         $('.delete_text').hide();
        //     }else{
        //         $('.delete_text').show();
        //     }
        // });

        // $('.delete_text').click(function(){
        //   $('#search_txt').val('');
        //   if($('#search_txt').val().trim() != old_search){
        //     old_search = '';
        //     dataTable.search("").draw();
        //   }
        //   $(this).hide();
        // });

        $('#add_user_modal').on('hidden.bs.modal', function () {
            clearFormCreate();
        })

        $('#closeCreateUser').click(function(){
            $('option', $('#role-list-ins')).each(function(element) {
                if($(this).attr('value') != 3){
                    $(this).removeAttr('selected').prop('selected', false);
                }else{
                    $(this).prop('disabled', true)
                }
            });
            $('#role-list-ins').multiselect('refresh');
        })
        $('#cancelEmail').click(function(){
            $('#selectedTemplate').prop('selected', false).find('option:first').prop('selected', true);
        })
        $('#cancelAddEmail').click(function(){
            $('#mulSelectedTemplate').prop('selected', false).find('option:first').prop('selected', true);
        })
    });
</script>

@endsection
