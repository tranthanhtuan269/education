@extends('frontends.layouts.app') 
@section('content')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
<script src="{{ url('/') }}/frontend/js/jquery.cropit.js"></script>

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
                <div class="tabbable-line">
                    <ul class="nav nav-tabs">
                        <li data-toggle="modal" data-target="#myModalChangePass" data-dismiss="modal" class="pull-right">
                            <button id="teacherChangePassword" type="button" class="btn btn-warning">Thay đổi mật khẩu</button>
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
                                                    <input type="password" class="form-control" placeholder="Nhập lại mật khẩu mới" name="confirm-pass">
                                                    <div class="alert-validate confirmpassword"></div>
                                                </div>			
                                            </div>
                                            <div class="form-group">
                                                <input type="button" class="btn btn-danger btn-block btn-lg" value="Cập nhật" onclick="changePassAjax()">
                                            </div>
                                            <input id="resetTeacherChangePass" type="reset" value="Reset the form" style="display:none">
                                        </form>				
                                    </div>
                                </div>
                            </div>
                        </div>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="buyed">
                                <div class="row">
                                    <form action="/dashboard/user/profile" method="post" enctype="multipart/form-data">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Ảnh đại diện</label>
                                                <div class="image-cropit-editor">
                                                    <div id="image-cropper" class="box-avatar-preview">
                                                        <div class="cropit-preview text-center preview-profile">
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
                                            {{-- <div class="form-group">
                                                <label>Họ tên</label>
                                                <div class="form-group">
                                                    <input type="text" id="muser-fullname" class="form-control" name="name" value="{{ Auth::user()->name }}">
                                                </div>
                                            </div> --}}
                                            {!! \App\Helper\Helper::insertInputForm('text', 'name', 'Họ tên', Auth::user()->name, 'name') !!}
                                            @if ( Auth::user()->email != 'facebook_email@example.com' )
                                            <div class="form-group">
                                                <label>Email</label>
                                                <div class="form-group">
                                                    <input type="email" id="muser-email" class="form-control" name="email" value="{{ Auth::user()->email }}" disabled>

                                                </div>
                                            </div>
                                            @endif
                                            {{-- <div class="form-group">
                                                <label>Số điện thoại</label>
                                                <div class="form-group">
                                                    <input type="number" id="muser-phone" class="form-control" name="phone" value="{{ Auth::user()->phone }}">

                                                </div>
                                            </div> --}}
                                            {!! \App\Helper\Helper::insertInputForm('number', 'phone', 'Số điện thoại', Auth::user()->phone, 'phone') !!}
                                            <div class="form-group form-html">
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
                                                <div class="form-html-validate birthday"></div>
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
                                                    <textarea class="form-control" rows="2" cols="50" name="address">{{ Auth::user()->address }}</textarea>
                                                </div>
                                            </div>
                                            {{-- <div class="form-group">
                                                <label>Facebook</label>
                                                <div class="form-group">
                                                    <input type="text" class="form-control" name="facebook" id="FacebookUrl" value="@if(Auth::user()){{Auth::user()->facebook}}@endif">
                                                    <br><p id="warningFacebookIntro"></p>
                                                </div>
                                            </div> --}}
                                            {!! \App\Helper\Helper::insertInputForm('text', 'facebook', 'Facebook', Auth::user()->facebook, 'facebook') !!}
                                        </div>
                                        <div class="col-md-6 col-sm-6">
                                            <div class="form-group form-html">
                                                <label>Chuyên môn</label>
                                                <div class="form-group">
                                                    {{-- <textarea class="form-control" rows="3" cols="50" name="expert">@if(Auth::user()->userRolesTeacher()->teacher){{Auth::user()->userRolesTeacher()->teacher->expert}}@endif</textarea> --}}
                                                    <input type="text" class="form-control" name="expert" value="@if(Auth::user()->userRolesTeacher()->teacher){{Auth::user()->userRolesTeacher()->teacher->expert}}@endif">
                                                    <p id="boxCharacterCount" style="display:none">Số ký tự: <b><span id="count-character">0</span>/55</b>. (Tối đa 55 ký tự)</p>
                                                </div>
                                                <div class="form-html-validate expert"></div>
                                            </div>
                                            <div class="form-group form-html">
                                                <label>CV</label>
                                                <div class="form-group">
                                                    <script src="https://cdn.ckeditor.com/ckeditor5/12.1.0/classic/ckeditor.js"></script>
                                                    <textarea id="editor-cv" class="form-control" rows="6" cols="50" name="cv">@if (Auth::user()->userRolesTeacher()->teacher) {!! Auth::user()->userRolesTeacher()->teacher->cv !!} @endif</textarea>
                                                    <p id="boxWordsCount" style="display:none">Số từ: <b><span id="wordCount">0</span>/700</b> từ. (Tối thiểu 30 từ, tối đa 700 từ)</p>
                                                </div>
                                                <div class="form-html-validate cv"></div>
                                            </div>
                                            <div class="form-group form-html">
                                                <label>Video giới thiệu</label>
                                                <div class="form-group">
                                                    <input type="text" class="form-control" name="video-intro" id="YoutubeUrl" value="@if(Auth::user()->userRolesTeacher()->teacher){{Auth::user()->userRolesTeacher()->teacher->video_intro}}@endif">
                                                </div>
                                                <div class="form-html-validate video_intro"></div>
                                            </div>
                                            {{-- @php
                                                $video_intro = '';
                                                if(Auth::user()->userRolesTeacher()->teacher){
                                                    $video_intro = Auth::user()->userRolesTeacher()->teacher->video_intro;
                                                }
                                            @endphp --}}
                                            {{-- {!! \App\Helper\Helper::insertInputForm('text', 'video_intro', 'Video giới thiệu', $video_intro, 'video_intro') !!} --}}
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="form-group text-center" style="padding-top: 5px;">
                                                <button class="btn btn-success" id="save-profile" type="button"><i class="fa fa-save fa-fw"></i>Lưu</button>
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
    var wordCount;
    var characterCount = 0;
    $(document).ready(function(){
        var teacher = jQuery.noConflict();

        teacher('#teacherChangePassword').click(function(e){
            e.stopPropagation()
            e.preventDefault()
            $('#resetTeacherChangePass').click()
            $('#myModalChangePass').modal("toggle")
            $('.alert-validate').html('')
        })
        // alert(12345)
        ClassicEditor
            .create( document.querySelector( '#editor-cv' ),{
                toolbar: [ 'heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote' ]
            } )
            .then(editor => {
                cv = editor;
                wordCounter(cv)

                editor.model.document.on('change', () => {
                    wordCounter(cv)
                })

                function wordCounter(cv){
                    var value = cv.getData();
                    if (value.length == 0) {
                        $('#wordCount').html(0);
                        return;
                    }
                    var regex = /\s+/gi;
                    wordCount = value.replace(/<\/p>/g, ' ').replace(/<p>/g, ' ').replace(/&nbsp;/g, ' ').trim().replace(regex, ' ').split(' ').length;
                    // console.log(value.replace(/<\/p>/g, ' ').replace(/<p>/g, ' ').replace(/&nbsp;/g, ' ').trim().replace(regex, ' '), wordCount)
                    
                    if(wordCount > 30 && wordCount < 700){
                        $('#wordCount').css("color","green");
                    }else{
                        $('#wordCount').css("color","red");
                    }
                    $('#boxWordsCount').css('display', 'block')
                    $('#wordCount').html(wordCount);
                }
            } )
            .catch( error => {
                console.error( error );
            } );

        $('body').on('click','.dz-image-preview',function(){
            $("#myDrop").trigger("click");
        });

        $('.reorder').on('click',function(){
            $("ul.nav").sortable({ tolerance: 'pointer' });
            $('.reorder').html('Save Reordering');
            $('.reorder').attr("id","updateReorder");
            $('#reorder-msg').slideDown('');
            $('.img-link').attr("href","javascript:;");
            $('.img-link').css("cursor","move");
        });
            
        var link_base64;
        $("#save-profile").click(function(){
            link_base64 = teacher('#image-cropper').cropit('export');

            var flag = true
            $('.form-html-validate').html('')
            if ( $('input[name=name]').val().trim() == '' ){
                alertValidate('Bạn chưa nhập Tên.', 'name')
                flag = false
            }
            if ( $('input[name=phone]').val().trim() == '' ){
                alertValidate('Bạn chưa nhập Số điện thoại.', 'phone')
                flag = false
            }
            // if ( $('input[name=birthday]').val().trim() == '' ){
            //     alertValidate('Bạn chưa chọn Ngày sinh.', 'birthday')
            //     flag = false
            // }
            if (!validationDate($('#datepicker').val())) {
                alertValidate('Ngày sinh không hợp lệ.', 'birthday')
                flag = false
            }
            // if ( $('textarea[name=address]').val().trim() == '' ){
            //     alertValidate('Bạn chưa nhập Địa chỉ.', 'address')
            //     flag = false
            // }
            if ( $('input[name=expert]').val().trim() == '' ){
                alertValidate('Bạn chưa nhập Chuyên môn.', 'expert')
                flag = false
            }
            if ( wordCount > 0 ){
                if (wordCount < 30) {
                    alertValidate('CV phải có ít nhất 30 từ.', 'cv')
                    flag = false
                } else {
                    if(wordCount > 700){
                        alertValidate('CV của bạn quá dài.', 'cv')
                        flag = false
                    }
                }
            }else{
                alertValidate('CV phải có ít nhất 30 từ.', 'cv')
                flag = false
            }
            if ( $("input[name=expert]").val().length > 0 ){
                if($("input[name=expert]").val().length > 55){
                    alertValidate('Số ký tự của Chuyên môn quá dài.', 'expert')
                    flag = false
                }
            }else{
                alertValidate('Bạn chưa nhập Chuyên môn.', 'expert')
                flag = false
            }
            
            var url = $('#YoutubeUrl').val().trim();
            if ( url != '' ){
                if (url != undefined || url != '') {       
                    var regExp = /^.*(youtu.be\/|v\/|u\/\w\/|embed\/|watch\?v=|\&v=|\?v=)([^#\&\?]*).*/;
                    var match = url.match(regExp);
                    if (match && match[2].length == 11) {
                    }else{
                        alertValidate('Link Video không hợp lệ.', 'video_intro')
                        flag = false
                    }
                }
            }else{
                alertValidate('Bạn chưa nhập Link Youtube.', 'video_intro')
                flag = false
            }

            facebook_url = $('input[name=facebook]').val().trim()
            if ( facebook_url != '' ){
                validate_url(facebook_url)
                if( !validate_url(facebook_url) ){
                    alertValidate('Link Facebook không hợp lệ.', 'facebook')
                    flag = false
                }
            }
            // else{
            //     alertValidate('Bạn chưa nhập Facebook.', 'facebook')
            //     flag = false
            // }
            if ( flag == false ) return

            $.ajaxSetup(
            {
                headers:
                {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var birthday = $('input[name=birthday]').val().trim();
            if (birthday != '') {
                var data = {
                        link_base64:link_base64,
                        name: $('input[name=name]').val().trim(),
                        phone: $('input[name=phone]').val().trim(),
                        birthday: $('input[name=birthday]').val().trim(),
                        gender: $('select[name=gender]').val(),
                        address: $('textarea[name=address]').val().trim(),
                        expert: $('input[name=expert]').val().trim(),
                        video_intro : $('input[name=video-intro]').val().trim(),
                        facebook : $('input[name=facebook]').val().trim(),
                        cv : cv.getData(),
                    };
            } else {
                var data = {
                        link_base64:link_base64,
                        name: $('input[name=name]').val().trim(),
                        phone: $('input[name=phone]').val().trim(),
                        gender: $('select[name=gender]').val(),
                        address: $('textarea[name=address]').val().trim(),
                        expert: $('input[name=expert]').val().trim(),
                        video_intro : $('input[name=video-intro]').val().trim(),
                        facebook : $('input[name=facebook]').val().trim(),
                        cv : cv.getData(),
                    };
            }


            $.ajax({
                method: "POST",
                url: "{{ url('user/teacher/profile') }}",
                data: data,
                dataType: 'json',
                beforeSend: function() {
                    $(".ajax_waiting").addClass("loading");
                },
                success: function (response) {
                    $(".ajax_waiting").removeClass("loading");
                    if(response.status == 200){
                        Swal.fire({
                            type: 'success',
                            html: response.message,

                        }).then((result) => {
                            if (result.value) {
                                location.reload();
                            }
                        });
                    }else{
                        Swal.fire({
                            type: 'warning',
                            html: 'Error',
                        })
                    }
                },
                error: function (error) {
                    $(".ajax_waiting").removeClass("loading");
                    var obj_errors = error.responseJSON.errors;
                    $('.form-html-validate').css('display', 'block')
                    $('.form-html-validate').html('')
                    $.each(obj_errors, function( index, value ) {
                        var content = '<i class="fas fa-exclamation fa-fw"></i><div class="hover-alert">'+ value +'</div>'
                        $('.form-html-validate.' + index).html(content);
                    })
                    $('.form-html .form-html-validate i').on('click',function(e){ e.stopPropagation() })
                }
            });
            return;
        });  
        // function alertValidate(message, element){
        //     $('.form-html-validate').css('display', 'block')
        //     $('.form-html-validate').html('')
        //     var content = '<i class="fas fa-exclamation fa-fw"></i><div class="hover-alert">'+ message +'</div>'
        //     $('.form-html-validate.' + element).html(content);
        // }

        teacher('#image-cropper').cropit();

        $('.select-image-btn').click(function() {
            $('.cropit-image-input').click();
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

        $("input[name=video-intro]").keyup(function(){
            var url = $('#YoutubeUrl').val().trim()
            if ( url == '' ){
                $('.form-html-validate.video_intro').css('display', 'none')
            }else{
                if (url != undefined ) {       
                    var regExp = /^.*(youtu.be\/|v\/|u\/\w\/|embed\/|watch\?v=|\&v=|\?v=)([^#\&\?]*).*/;
                    var match = url.match(regExp);
                    if (match && match[2].length == 11) {
                        $('#warningVideoIntro').css("color","green");
                        $('.form-html-validate.video_intro').css('display', 'none')
                    }else{
                        alertValidate('Link video sai. Yêu cầu nhập lại!', 'video_intro')
                    }
                }

            }
        })
        $('input[name=facebook]').keyup(function(){
            facebook_url = $('input[name=facebook]').val().trim()
            if ( facebook_url != '' ){
                validate_url(facebook_url)
                if( !validate_url(facebook_url) ){
                    alertValidate('Link Facebook không hợp lệ!', 'facebook')
                }else{
                    $('.form-html-validate.facebook').css('display', 'none')
                }
            }
        })
        function validate_url(url){
            if (/^(https?:\/\/)?((w{3}\.)?)facebook.com\/.*/i.test(url)){
                return true;
            }else{ return false }
        }
    });
    $('input[type=password]').click(function(){
        $(this).css('z-index', 5)
    })
    function changePassAjax(){
        var data = {
            password_old        : $('#myModalChangePass input[name=pass-old]').val(),
            password            : $('#myModalChangePass input[name=pass-new]').val(),
            confirmpassword     : $('#myModalChangePass input[name=confirm-pass]').val(),
            _method:"put"
        };
        $.ajaxSetup(
        {
            headers:
            {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        // console.log(data);
        $.ajax({
            method: "POST",
            url: '{{ url("user/change-pass-ajax") }}',
            data: data,
            dataType: 'json',
            // beforeSend: function() {
            //     $("#pre_ajax_loading").show();
            // },
            // complete: function() {
            //     $("#pre_ajax_loading").hide();
            // },
            success: function (response) {
                if(response.status == 200){
                    Swal.fire({
                        type: 'success',
                        html: response.message,

                    }).then((result) => {
                        if (result.value) {
                            location.reload();
                        }
                    });
                }else{
                    Swal.fire({
                        type: 'warning',
                        html: response.message,
                    })
                }
            },
            error: function (error) {
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
<script>
    characterCount()
    function characterCount(){
        var characterCount = $("input[name=expert]").val().length;
        $('#count-character').html(characterCount);
        $('#boxCharacterCount').css('display','block')

        if(characterCount > 0 && characterCount <= 55){
            $('#count-character').css("color","green");
        }else{
            $('#count-character').css("color","red");
        }
    }
    // characterCount();
    $("input[name=expert]").keyup(function(){
        characterCount();
    });
</script>
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
@endsection