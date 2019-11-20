@extends('frontends.layouts.app') 
@section('content')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
<script src="{{ url('/') }}/frontend/js/jquery.cropit.js"></script>

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
                        {{-- <li class="active">
                            <a href="#buyed" class="buyed" data-toggle="tab"><i class="fa fa-user"></i>&nbsp;&nbsp;Profile</a>
                        </li> --}}
                        <li data-toggle="modal" data-target="#myModalChangePass" data-dismiss="modal" class="pull-right">
                            <button id="studentChangePassword" type="button" class="btn btn-warning">Thay đổi mật khẩu</button>
                        </li>
                        <div id="myModalChangePass" class="modal fade" role="dialog" >
                            <div class="modal-dialog modal-login">
                                <div class="modal-content">
                                    <div class="modal-header">	
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        <div class="modal-title modal-header-title"><b>Thay đổi mật khẩu</b></div>
                                    </div>
                                    <div class="modal-body">
                                        <p class="change-password-notice">Thay đổi mật khẩu của bạn tại đây</p>
                                        <form action="" method="post">
                                            <div class="form-group">
                                                <div class="input-group">
                                                    <span class="input-group-addon"><i class="fas fa-lock fa-fw fa-md"></i></span>
                                                    <input type="password" class="form-control" placeholder="Mật khẩu hiện tại" name="pass-old">
                                                    <div class="alert-validate password_old"></div>
                                                </div>				
                                            </div>
                                            <div class="form-group">
                                                <div class="input-group">
                                                    <span class="input-group-addon"><i class="fas fa-lock fa-fw fa-md"></i></span>
                                                    <input type="password" class="form-control" placeholder="Mật khẩu mới" name="pass-new">
                                                    <div class="alert-validate password"></div>
                                                </div>				
                                            </div>
                                            <div class="form-group">
                                                <div class="input-group">
                                                    <span class="input-group-addon"><i class="fas fa-lock fa-fw fa-md"></i></span>
                                                    <input type="password" class="form-control" placeholder="Xác nhận mật khẩu mới" name="confirm-pass">
                                                    <div class="alert-validate confirmpassword"></div>
                                                </div>			
                                            </div>
                                            <div class="form-group">
                                                <input type="button" class="btn btn-danger btn-block btn-lg" value="Cập nhật" onclick="changePassAjax()">
                                            </div>
                                            <input id="resetStudentChangePass" type="reset" value="Reset the form" style="display:none">
                                        </form>				
                                    </div>
                                </div>
                            </div>
                        </div>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="buyed">
                            <div class="row">
                                <form id="w0" action="/dashboard/user/profile" method="post" enctype="multipart/form-data">
                                    <div class="col-md-6 col-sm-6">
                                        <div class="form-group">
                                            <label>Ảnh đại diện</label>
                                            <div class="image-cropit-editor">
                                                <div id="image-cropper" class="box-avatar-preview">
                                                    <div class="cropit-preview text-center preview-profile aaaaaaaa">
                                                        <img class="sample-avatar" src="{{ asset('frontend/'.(Auth::user()->avatar != '' ? Auth::user()->avatar : 'images/avatar.jpg')) }}" alt="sample avatar">
                                                    </div>
                                                    <input type="range" class="cropit-image-zoom-input" style="display: none"/>
                                                    <input type="file" class="cropit-image-input" style="display:none" value="" id="image-file-input"/>
                                                    <div class="text-center">
                                                        <div class="note">(Kích thước nhỏ nhất: 250x250)</div>
                                                        <div class="btn btn-primary select-image-btn"><i class="fas fa-image fa-fw"></i> Tải lên ảnh đại diện</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-6">
                                        <div class="form-group">
                                            <label>Họ tên</label>
                                            <div class="form-group">
                                                <input type="text" class="form-control" name="name" value="{{ Auth::user()->name }}">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label> Email </label>
                                            <div class="form-group">
                                                <input type="email" class="form-control" name="email" value="{{ Auth::user()->email }}" disabled>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>Số điện thoại</label>
                                            <div class="form-group">
                                                <input type="text" class="form-control" name="phone" value="{{ Auth::user()->phone }}">

                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>Ngày sinh</label>
                                            <div class="form-group">
                                                <input type="text" class="form-control"  id="datepicker" name="birthday"  pattern="\d{1,2}/\d{1,2}/\d{4}" value="{{ (Auth::user()->birthday != '') ? Helper::formatDate('Y-m-d', Auth::user()->birthday, 'd/m/Y') : '' }}" autocomplete="off">
                                                <script>
                                                  $(function() {
                                                    $( "#datepicker" ).datepicker({
                                                        changeMonth: true,
                                                        changeYear: true,
                                                        yearRange: "1950:2020",
                                                        dateFormat: 'dd/mm/yy',
                                                        maxDate: new Date(),
                                                    }	
                                                    );
                                                });
                                            </script>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Giới tính</label>
                                        <div class="form-group">
                                            <select class="form-control" name="gender">
                                                <option value="1" @if(Auth::user()->gender == 1) selected @endif>Nam</option>
                                                <option value="2" @if(Auth::user()->gender == 2) selected @endif>Nữ</option>
                                                <option value="3" @if(Auth::user()->gender == 3) selected @endif>Khác</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Địa chỉ</label>
                                        <div class="form-group">
                                            <textarea class="form-control" rows="4" cols="50" name="address">{{ Auth::user()->address }}</textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group text-center" style="padding-top: 5px;">
                                        <button class="btn btn-success" id="save-profile" type="button"><i class="fa fa-save"></i> Lưu</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

<script src="{{ asset('frontend/js/dropzone.js') }}"></script>
<script>
$(document).ready(function() {
    var student = jQuery.noConflict();

    student('#studentChangePassword').click(function(e){
        e.stopPropagation()
        e.preventDefault()
        $('#resetStudentChangePass').click()
        $('#myModalChangePass').modal("toggle")
    })

    // p('#myModalChangePass').on('shown.bs.modal', function () {
    //         // var id      = $('#userID_upd').val();
    //         alert(1)
    //     })


    $('.reorder').on('click', function() {
        $("ul.nav").sortable({
            tolerance: 'pointer'
        });
        $('.reorder').html('Save Reordering');
        $('.reorder').attr("id", "updateReorder");
        $('#reorder-msg').slideDown('');
        $('.img-link').attr("href", "javascript:;");
        $('.img-link').css("cursor", "move");
    });

    var link_base64;

    $("#save-profile").click(function() {
        link_base64 = student('#image-cropper').cropit('export');

        // Validate Birthday
        if (!validationDate($('#datepicker').val())) {
            Swal.fire({
                type: 'warning',
                html: 'Ngày sinh phải có định dạng Ngày/Tháng/Năm (Ví dụ: 31/12/1993)',
            })
            return false;
        }

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var birthday = $('input[name=birthday]').val().trim();
        if (birthday != '') {
            var data = {
                link_base64: link_base64,
                name: $('input[name=name]').val().trim(),
                phone: $('input[name=phone]').val().trim(),
                birthday: $('input[name=birthday]').val().trim(),
                gender: $('select[name=gender]').val(),
                address: $('textarea[name=address]').val().trim(),
            };
        } else {
            var data = {
                link_base64: link_base64,
                name: $('input[name=name]').val().trim(),
                phone: $('input[name=phone]').val().trim(),
                gender: $('select[name=gender]').val(),
                address: $('textarea[name=address]').val().trim(),
            };
        }

        $.ajax({
            method: "POST",
            url: "{{ url('user/student/profile') }}",
            data: data,
            dataType: 'json',
            // beforeSend: function() {
            //     $("#pre_ajax_loading").show();
            // },
            // complete: function() {
            //     $("#pre_ajax_loading").hide();
            // },
            success: function(response) {
                if (response.status == 200) {
                    Swal.fire({
                        type: 'success',
                        html: response.message,

                    }).then((result) => {
                        if (result.value) {
                            location.reload();
                        }
                    });
                } else {
                    Swal.fire({
                        type: 'warning',
                        html: 'Error',
                    })
                }
            },
            error: function(error) {
                var obj_errors = error.responseJSON.errors;
                // console.log(obj_errors)
                var txt_errors = '';
                for (k of Object.keys(obj_errors)) {
                    txt_errors += obj_errors[k][0] + '</br>';
                }
                Swal.fire({
                    type: 'warning',
                    html: txt_errors,
                })
            }
        });

        return;
    });

    student('#image-cropper').cropit();

    $('.select-image-btn').click(function() {
        $('.cropit-image-input').click();
    });

    // Handle rotation
    $('.rotate-cw-btn').click(function() {
        $('#image-cropper').cropit('rotateCW');
    });
    $('.rotate-ccw-btn').click(function() {
        $('#image-cropper').cropit('rotateCCW');
    });

    var _URL = window.URL || window.webkitURL;
    $("#image-file-input").change(function(e) {
        var file, img;
        if ((file = this.files[0])) {
            img = new Image();
            img.onerror = function() {
                // alert( "Tập tin không hợp lệ: " + file.type);
                Swal.fire({
                    type: 'warning',
                    text: 'Tập tin không hợp lệ!',
                })
                $("#image-file-input").val('')
            };
            img.onload = function() {
                /* alert(this.width + " " + this.height); */
                if(this.width < 250 || this.height < 250){
                    // alert('Kích thước ảnh >= 250px');
                    Swal.fire({
                        type: 'warning',
                        text: 'Yêu cầu kích thước ảnh >= 250x250!',
                    })
                    $("#image-file-input").val('')
                }else{
                    $('.cropit-image-zoom-input').show().css('padding-top', '15px');
                    // $('.rotate-btn-group').show();
                }
            };
            img.src = _URL.createObjectURL(file);

        }
    });
});
$('input[type=password]').click(function(){
    $(this).css('z-index', 5)
})
function changePassAjax() {
    var data = {
        password_old: $('#myModalChangePass input[name=pass-old]').val(),
        password: $('#myModalChangePass input[name=pass-new]').val(),
        confirmpassword: $('#myModalChangePass input[name=confirm-pass]').val(),
        _method: "put"
    };
    // var ch_length = ($('#myModalChangePass input[name=pass-new]').val()).length
    // var ch_length2 = ($('#myModalChangePass input[name=confirm-pass]').val()).length
    // alert($('#myModalChangePass input[name=pass-new]').val()+'xx'+ch_length)
    // alert($('#myModalChangePass input[name=confirm-pass]').val()+'xx'+ch_length2)
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        method: "POST",
        url: '{{ url("user/change-pass-ajax") }}',
        data: data,
        dataType: 'json',
        success: function(response) {
            if (response.status == 200) {
                Swal.fire({
                    type: 'success',
                    html: response.message,

                }).then((result) => {
                    if (result.value) {
                        location.reload();
                    }
                });
            } else {
                Swal.fire({
                    type: 'warning',
                    html: response.message,
                })
            }
        },
        error: function(error) {
            var obj_errors = error.responseJSON.errors;
            $('input[type=password]').css('z-index', 0)
            $('.alert-validate').html('')
            $.each(obj_errors, function( index, value ) {
                var content = '<i class="fas fa-exclamation fa-fw"></i><div class="hover-alert">'+ value +'</div>'
                $('.alert-validate.' + index).html(content);
            })
        }
    });

    return false;
} 
</script>

<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>

@endsection