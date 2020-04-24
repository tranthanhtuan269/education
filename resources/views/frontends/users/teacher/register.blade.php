@extends('frontends.layouts.app') 
@section('content')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
<script src="{{ url('/') }}/frontend/js/jquery.cropit.js"></script>

<div class="u-dashboard-top" style="background-image:  url({{ url('frontend/images/bg-db-user.jpg') }});">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <p>Đăng ký làm giảng viên</p>
                <br><br>
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
                        <li class="active">
                            <a href="#buyed" class="buyed" data-toggle="tab"><i class="fa fa-user"></i>&nbsp;&nbsp;Đăng kí</a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="buyed">
                                <div class="row">
                                    <form action="" method="post" enctype="multipart/form-data">
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
                                            {!! \App\Helper\Helper::insertInputForm('text', 'name', 'Tên đầy đủ', Auth::user()->name, 'name') !!}
                                            <?php $user_email = Auth::check() ? Auth::user()->email : ''; ?>
                                            {!! \App\Helper\Helper::insertInputForm('email', 'email', 'Email', $user_email, 'email', 'disabled') !!}
                                            {!! \App\Helper\Helper::insertInputForm('number', 'phone', 'Số điện thoại', Auth::user()->phone, 'phone') !!}
                                            <?php $birthday=Auth::check() ?  (Auth::user()->birthday != '') ? Helper::formatDate('Y-m-d', Auth::user()->birthday, 'd/m/Y') : '' :'' ; ?>
                                            {!! \App\Helper\Helper::insertInputForm('text', 'birthday', 'Ngày sinh', $birthday, 'birthday', 'id="datepicker" pattern="\d{1,2}/\d{1,2}/\d{4}" autocomplete="off"') !!}
                                            <div class="form-group">
                                                <label>Giới tính</label>
                                                <div class="form-group">
                                                    <select class="form-control" name="gender">
                                                        <option value="1" @if( Auth::check() && Auth::user()->gender == 1) selected @endif>Nam</option>
                                                        <option value="2" @if( Auth::check() && Auth::user()->gender == 2) selected @endif>Nữ</option>
                                                        <option value="3" @if( Auth::check() && Auth::user()->gender == 3) selected @endif>Khác</option>
                                                    </select>
                                                </div>
                                            </div>
                                            {!! \App\Helper\Helper::insertTextareaForm('Địa chỉ', '2', '50', 'address', Auth::user()->address, 'address') !!}
                                            {!! \App\Helper\Helper::insertInputForm('text', 'facebook', 'Facebook', Auth::user()->facebook, 'facebook') !!}
                                        </div>
                                        <div class="col-md-6 col-sm-6">
                                            <div class="form-group form-html">
                                                <label>Chuyên môn</label>
                                                <div class="form-group">
                                                    <input type="text" class="form-control" name="expert" value="">
                                                    <p id="boxCharacterCount">Số ký tự: <b><span id="count-character">0</span>/55</b>. (Tối đa 55 ký tự)</p>
                                                </div>
                                                <div class="form-html-validate expert"></div>
                                            </div>
                                            <script src="https://cdn.ckeditor.com/ckeditor5/12.1.0/classic/ckeditor.js"></script>
                                            <div class="form-group form-html">
                                                <label>CV</label>
                                                <div class="form-group">
                                                    <textarea id="editor-cv" class="form-control textarea-cv" rows="6" cols="50" name="cv"></textarea>
                                                    <p>Số từ: <b><span id="wordCount">0</span>/700</b> từ. (Tối thiểu 30 từ, tối đa 700 từ)</p>
                                                </div>
                                                <div class="form-html-validate cv"></div>
                                            </div>
                                            {!! \App\Helper\Helper::insertInputForm('text', 'video-intro', 'Video giới thiệu', '', 'video_intro', 'id="YoutubeUrl" placeholder="Yêu cầu link Youtube"') !!}
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
<script>
    var wordCount;
    $(document).ready(function(){
        ClassicEditor
            .create(document.querySelector('#editor-cv'),{
                toolbar: [ 'heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote' ]
            })
            .then(editor => {
                cv = editor;
                editor.model.document.on('change', () => {
                    var value = cv.getData();
                    if (value.length == 0) {
                        $('#wordCount').html(0);
                        return;
                    }
                    var regex = /\s+/gi;
                    wordCount = value.replace(/<\/p>/g, ' ').replace(/<p>/g, ' ').replace(/&nbsp;/g, ' ').trim().replace(regex, ' ').split(' ').length;
                    // wordCount = value.trim().replace(regex, ' ').split(' ').length;

                    if(wordCount >= 30 && wordCount <= 700) {
                        $('#wordCount').css("color", "green");
                    }else{
                        $('#wordCount').css("color", "red");
                    }

                    $('#wordCount').html(wordCount);
                });
            })
            .catch(error => {
                console.error(error);
            });

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

        $("#save-profile").off('click')
        $("#save-profile").on('click',function() {
            link_base64 = $('#image-cropper').cropit('export');
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
            // }else{
                if (!validationDate($('#datepicker').val())) {
                    alertValidate('Ngày sinh không hợp lệ.', 'birthday')
                    flag = false
                }
            // }
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
            if ($("input[name=expert]").val().length > 0){
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
                alertValidate('Bạn chưa nhập Video giới thiệu.', 'video_intro')
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
                    facebook: $('input[name=facebook]').val().trim(),
                    expert: $('input[name=expert]').val().trim(),
                    video_intro: $('input[name=video-intro]').val().trim(),
                    cv: cv.getData(),
                };
            } else {
                var data = {
                    link_base64: link_base64,
                    name: $('input[name=name]').val().trim(),
                    phone: $('input[name=phone]').val().trim(),
                    gender: $('select[name=gender]').val(),
                    address: $('textarea[name=address]').val().trim(),
                    facebook: $('input[name=facebook]').val().trim(),
                    expert: $('input[name=expert]').val().trim(),
                    video_intro: $('input[name=video-intro]').val().trim(),
                    cv: cv.getData(),
                };
            }


            $.ajax({
                method: "POST",
                url: "{{ url('user/register-teacher') }}",
                data: data,
                dataType: 'json',
                beforeSend: function() {
                    $(".ajax_waiting").addClass("loading");
                },
                complete: function() {
                    $(".ajax_waiting").removeClass("loading");
                },
                success: function(response) {
                    if (response.status == 200) {
                        Swal.fire({
                            type: 'success',
                            html: response.message,

                        }).then((result) => {
                            if (result.value) {
                                window.location.href = "/";
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
        
        $('#image-cropper').cropit();

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
                        if ($('cropit-preview-image').data('src') != '') {
                            $('.sample-avatar').css('display', 'none')
                        }
                    }
                };
                img.src = _URL.createObjectURL(file);

            }
        });
    });
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

        return false;
    }
</script>
<script>
    // Date Picker
    $(function() {
        $( "#datepicker" ).datepicker({
                changeMonth: true,
                changeYear: true,
                yearRange: "1950:2020",
                dateFormat: 'dd/mm/yy',
                maxDate: new Date(),
            }	
        );
    })

    $("input[name=video-intro]").keyup(function(){
        var url = $('#YoutubeUrl').val().trim();
        if ( url == '' ){
            $('.form-html-validate.video_intro').css('display', 'none')
        }else{
            if (url != undefined ) {       
                var regExp = /^.*(youtu.be\/|v\/|u\/\w\/|embed\/|watch\?v=|\&v=|\?v=)([^#\&\?]*).*/;
                var match = url.match(regExp);
                if (match && match[2].length == 11) {
                    $('.form-html-validate.video_intro').css('display', 'none')
                }else{
                    alertValidate('Link video sai. Yêu cầu nhập lại!', 'video_intro')
                }
            }
        }
    })
    $("input[name=facebook]").keyup(function(){
        facebook_url = $('input[name=facebook]').val().trim()
        if ( facebook_url != '' ){
            validate_url(facebook_url)
            if( !validate_url(facebook_url) ){
                alertValidate('Link Facebook không hợp lệ!', 'facebook')
                return false;
            }
        }
    })
    function validate_url(url){
        if (/^(https?:\/\/)?((w{3}\.)?)facebook.com\/.*/i.test(url)){
            return true;
        }else{ return false }
    }
    function characterCount(){
        var characterCount = $("input[name=expert]").val().length;
        $('#count-character').html(characterCount);
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