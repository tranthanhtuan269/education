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
                                            <div class="form-group">
                                                <label>Tên đầy đủ</label>
                                                <div class="form-group">
                                                    <input type="text" class="form-control" name="name" value="{{ Auth::check() ? Auth::user()->name : '' }}">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label>Email</label>
                                                <div class="form-group">
                                                    <input type="email" class="form-control" name="email" value="{{ Auth::check() ? Auth::user()->email : '' }}" {{ Auth::check() ? 'disabled' : '' }}>

                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label>Số điện thoại</label>
                                                <div class="form-group">
                                                    <input type="number" class="form-control" name="phone" value="{{ Auth::check() ? Auth::user()->phone : '' }}">

                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label>Ngày sinh</label>
                                                <div class="form-group">
                                                    <input type="text" class="form-control"  id="datepicker" name="birthday"  pattern="\d{1,2}/\d{1,2}/\d{4}" value="{{ Auth::check() ?  (Auth::user()->birthday != '') ? Helper::formatDate('Y-m-d', Auth::user()->birthday, 'd/m/Y') : '' :'' }}" autocomplete="off">
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
                                                        <option value="1" @if( Auth::check() && Auth::user()->gender == 1) selected @endif>Nam</option>
                                                        <option value="2" @if( Auth::check() && Auth::user()->gender == 2) selected @endif>Nữ</option>
                                                        <option value="3" @if( Auth::check() && Auth::user()->gender == 3) selected @endif>Khác</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label>Địa chỉ</label>
                                                <div class="form-group">
                                                    <textarea class="form-control" rows="2" cols="50" name="address">{{ Auth::check() ? Auth::user()->address : '' }}</textarea>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label>Facebook</label>
                                                <div class="form-group">
                                                    <input type="text" class="form-control" name="facebook" id="FacebookUrl" value="@if(Auth::user()){{Auth::user()->facebook}}@endif">
                                                    <br><p id="warningFacebookIntro"></p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-6">
                                            <div class="form-group">
                                                <label>Chuyên môn</label>
                                                <div class="form-group">
                                                    <input type="text" class="form-control" name="expert" value="">
                                                    <p id="boxCharacterCount">Số ký tự: <b><span id="count-character">0</span>/55</b>. (Tối đa 55 ký tự)</p>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label>CV</label>
                                                <div class="form-group">
                                                    <script src="https://cdn.ckeditor.com/ckeditor5/12.1.0/classic/ckeditor.js"></script>
                                                    <textarea id="editor-cv" class="form-control textarea-cv" rows="6" cols="50" name="cv"></textarea>
                                                    <p>Số từ: <b><span id="wordCount">0</span>/700</b> từ. (Tối thiểu 30 từ, tối đa 700 từ)</p>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label>Video giới thiệu</label>
                                                <div class="form-group">
                                                    <input type="text" class="form-control" name="video-intro" placeholder="Yêu cầu link Youtube" value="" id="YoutubeUrl">
                                                    <br><p id="warningVideoIntro"></p>
                                                    <!-- <iframe id="videoObject" type="text/html" width="500" height="265" frameborder="0" allowfullscreen></iframe> -->
                                                </div>
                                            </div>
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
            .create(document.querySelector('#editor-cv'))
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
            // Validate Birthday
            if (!validationDate($('#datepicker').val())) {
                Swal.fire({
                    type: 'warning',
                    html: 'Ngày sinh không hợp lệ!',
                })
                return false;
            }
            if (wordCount < 30) {
                Swal.fire({
                    type: 'warning',
                    html: 'CV của bạn quá ngắn!',
                })
                return false;
            } else {
                if(wordCount > 700){
                    Swal.fire({
                        type: 'warning',
                        html: 'CV của bạn quá dài!',
                    })
                    return false;
                }
            }
            if($("input[name=expert]").val().length > 55){
                Swal.fire({
                    type: 'warning',
                    html: 'Số ký tự của "Chuyên môn" quá dài!',
                })
                return false;
            }
            var url = $('#YoutubeUrl').val().trim();
            if ( url != '' ){
                if (url != undefined || url != '') {       
                    var regExp = /^.*(youtu.be\/|v\/|u\/\w\/|embed\/|watch\?v=|\&v=|\?v=)([^#\&\?]*).*/;
                    var match = url.match(regExp);
                    if (match && match[2].length == 11) {
                    }else{
                        Swal.fire({
                            type: 'warning',
                            html: 'Link Video không hợp lệ!',
                        })
                        return false;
                    }
                }
            }

            facebook_url = $('input[name=facebook]').val().trim()
            function validate_url(url){
                if (/^(https?:\/\/)?((w{3}\.)?)facebook.com\/.*/i.test(url)){
                    return true;
                }else{ return false }
            }
            if ( facebook_url != '' ){
                validate_url(facebook_url)
                if( !validate_url(facebook_url) ){
                    Swal.fire({
                        type: 'warning',
                        html: 'Link Facebook không hợp lệ!',
                    })
                    return false;
                }
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
    $("input[name=video-intro]").keyup(function(){
        var url = $('#YoutubeUrl').val();
        if ( url == '' ){
            document.getElementById("warningVideoIntro").innerHTML = ""
        }else{
            if (url != undefined ) {       
                var regExp = /^.*(youtu.be\/|v\/|u\/\w\/|embed\/|watch\?v=|\&v=|\?v=)([^#\&\?]*).*/;
                var match = url.match(regExp);
                if (match && match[2].length == 11) {
                    $('#warningVideoIntro').css("color","green");
                    document.getElementById("warningVideoIntro").innerHTML = "Link video được chấp nhận.";
                    // $('#videoObject').attr('src', 'https://www.youtube.com/embed/' + match[2] + '?autoplay=1&enablejsapi=1');
                }else{
                    $('#warningVideoIntro').css("color","red");
                    document.getElementById("warningVideoIntro").innerHTML = "Link video sai. Yêu cầu nhập lại!";
                }
            }
        }
    });
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