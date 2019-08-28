@extends('frontends.layouts.app') 
@section('content')

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
                        {{-- <li class="active">
                            <a href="#buyed" class="buyed" data-toggle="tab"><i class="fa fa-user"></i>&nbsp;&nbsp;Hồ sơ</a>
                        </li> --}}
                        <li data-toggle="modal" data-target="#myModalChangePass" data-dismiss="modal" class="pull-right">
                            <button type="button" class="btn btn-warning">Thay đổi mật khẩu</button>
                        </li>
                        <div id="myModalChangePass" class="modal fade" role="dialog" >
                            <div class="modal-dialog modal-login">
                                <div class="modal-content">
                                    <div class="modal-header">				
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        <div class="modal-title"><b>Thay đổi mật khẩu</b></div>
                                    </div>
                                    <div class="modal-body">
                                        <p class="change-password-notice">Thay đổi mật khẩu của bạn tại đây</p>
                                        <form action="" method="post">
                                            <div class="form-group">
                                                <div class="input-group">
                                                    <span class="input-group-addon"><i class="fas fa-lock fa-fw fa-md"></i></span>
                                                    <input type="password" class="form-control" placeholder="Mật khẩu hiện tại" name="pass-old">
                                                </div>				
                                            </div>
                                            <div class="form-group">
                                                <div class="input-group">
                                                    <span class="input-group-addon"><i class="fas fa-lock fa-fw fa-md"></i></span>
                                                    <input type="password" class="form-control" placeholder="Mật khẩu mới" name="pass-new">
                                                </div>				
                                            </div>
                                            <div class="form-group">
                                                <div class="input-group">
                                                    <span class="input-group-addon"><i class="fas fa-lock fa-fw fa-md"></i></span>
                                                    <input type="password" class="form-control" placeholder="Nhập lại mật khẩu mới" name="confirm-pass">
                                                </div>			
                                            </div>
                                            <div class="form-group">
                                                <input type="button" class="btn btn-danger btn-block btn-lg" value="Đổi mật khẩu" onclick="changePassAjax()">
                                            </div>
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
                                                <label>Chọn ảnh đại diện</label>
                                                <div class="dropzone dz-clickable" id="myDrop">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-6">
                                            <div class="form-group">
                                                <label>Họ tên</label>
                                                <div class="form-group">
                                                    <input type="text" id="muser-fullname" class="form-control" name="name" value="{{ Auth::user()->name }}">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label>Email</label>
                                                <div class="form-group">
                                                    <input type="email" id="muser-email" class="form-control" name="email" value="{{ Auth::user()->email }}" disabled>

                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label>Số điện thoại</label>
                                                <div class="form-group">
                                                    <input type="text" id="muser-phone" class="form-control" name="phone" value="{{ Auth::user()->phone }}">

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
                                                        <option value="1" @if(Auth::user()->gender == 1) selected @endif>Nữ</option>
                                                        <option value="2" @if(Auth::user()->gender == 2) selected @endif>Nam</option>
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
                                        <div class="col-md-6 col-sm-6">
                                            <div class="form-group">
                                                <label>Chuyên môn</label>
                                                <div class="form-group">
                                                    {{-- <textarea class="form-control" rows="3" cols="50" name="expert">@if(Auth::user()->userRolesTeacher()->teacher){{Auth::user()->userRolesTeacher()->teacher->expert}}@endif</textarea> --}}
                                                    <input type="text" class="form-control" name="expert" value="@if(Auth::user()->userRolesTeacher()->teacher){{Auth::user()->userRolesTeacher()->teacher->expert}}@endif">
                                                    <p>Số ký tự: <b><span id="count-character">0</span>/55</b>. (Tối đa 55 ký tự)</p>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label>CV</label>
                                                <div class="form-group">
                                                    <script src="https://cdn.ckeditor.com/ckeditor5/12.1.0/classic/ckeditor.js"></script>
                                                    <textarea id="editor-cv" class="form-control" rows="6" cols="50" name="cv">@if (Auth::user()->userRolesTeacher()->teacher) {!! Auth::user()->userRolesTeacher()->teacher->cv !!} @endif</textarea>
                                                    <p id="boxWordsCount" style="display:none">Số từ: <b><span id="wordCount">0</span>/700</b> từ. (Tối thiểu 30 từ, tối đa 700 từ)</p>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label>Video giới thiệu</label>
                                                <div class="form-group">
                                                    <input type="text" class="form-control" name="video-intro" id="YoutubeUrl" value="@if(Auth::user()->userRolesTeacher()->teacher){{Auth::user()->userRolesTeacher()->teacher->video_intro}}@endif">
                                                    <br><p id="warningVideoIntro"></p>
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
<script src="{{ asset('frontend/js/dropzone.js') }}"></script>
<script>
    var wordCount;
    var characterCount = 0;
    Dropzone.autoDiscover = false;
    $(document).ready(function(){
        // alert(12345)
        ClassicEditor
            .create( document.querySelector( '#editor-cv' ) )
            .then(editor => {
                cv = editor;
                editor.model.document.on('change', () => {
                    var value = cv.getData();
                    if (value.length == 0) {
                        $('#wordCount').html(0);
                        return;
                    }
                    var regex = /\s+/gi;
                    wordCount = value.trim().replace(regex, ' ').split(' ').length;
                    
                    if(wordCount > 30 && wordCount < 700){
                        $('#wordCount').css("color","green");
                    }else{
                        $('#wordCount').css("color","red");
                    }
                    $('#boxWordsCount').css('display', 'block')
                    $('#wordCount').html(wordCount);
                } );
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
        var myDropzone = new Dropzone("div#myDrop", 
        { 
            paramName: "files", // The name that will be used to transfer the file
            addRemoveLinks: true,
            uploadMultiple: false,
            autoProcessQueue: true,
            parallelUploads: 50,
            maxFilesize: 5, // MB
            acceptedFiles: ".png, .jpeg, .jpg, .gif",
            url: "{{ url('upload-image') }}",
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },

            success: function(file, response){
                // alert(response);
            },
            accept: function(file, done) {
                // alert(2)
                done();
            },
            error: function(file, message, xhr){
                if (xhr == null) this.removeFile(file);
                $('.dz-image-preview').show(500);
                Swal.fire({
                    type: 'warning',
                    html: message,
                })
            },
            sending: function(file, xhr, formData) {
                // $.each($('form').serializeArray(), function(key,value) {
                //     formData.append(this.name, this.value);
                // });
                // data_request = formData;
                // alert(data);
                // console.log(formData);

            },
            init: function() {
                var thisDropzone = this;
                var mockFile = { name: '', size: 12345, type: 'image/jpeg' };
                thisDropzone.emit("addedfile", mockFile);
                thisDropzone.emit("success", mockFile);
                thisDropzone.emit("thumbnail", mockFile, "{{ url('frontend/'.((Auth::user()->avatar != '') ? Auth::user()->avatar : 'images/avatar.jpg') ) }}")
                // this.on("maxfilesexceeded", function(file){
                // this.removeFile(file);
                //     alert("No more files please!");
                // });

                this.on('addedfile', function(file) {
                    $('.dz-image-preview').hide(500);
                    $('.dz-progress').hide();
                    if (this.files.length > 1) {
                        this.removeFile(this.files[0]);
                    }

                });
            },
            // error: function (file, response){
            //     alert(1);
            //     if ($.type(response) === "string")
            //         var message = response; //dropzone sends it's own error messages in string
            //     else
            //         var message = response.message;
            //     file.previewElement.classList.add("dz-error");
            //     _ref = file.previewElement.querySelectorAll("[data-dz-errormessage]");
            //     _results = [];
            //     for (_i = 0, _len = _ref.length; _i < _len; _i++) {
            //         node = _ref[_i];
            //         _results.push(node.textContent = message);
            //     }
            //     return _results;
            // },

            // reset: function () {
            //     console.log("resetFiles");
            //     this.removeAllFiles(true);
            // }
        });

        $("#save-profile").click(function(){
			// Validate Birthday
			if (!validationDate( $('#datepicker').val() )) {
                Swal.fire({
                    type: 'warning',
                    html: 'Field birthday is invalid!',
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
            var url = $('#YoutubeUrl').val();
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
                        cv : cv.getData(),
                    };
            }


            $.ajax({
                method: "POST",
                url: "{{ url('user/teacher/profile') }}",
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
                            html: 'Error',
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
            return;
        });  
                  
                      
        myDropzone.on("sending", function(file, xhr, formData) {
            var filenames = [];
            
            $('.dz-preview .dz-filename').each(function() {
                filenames.push($(this).find('span').text());
            });
            
            formData.append('filenames', filenames);
        });
            
        /* Add Files Script*/
        myDropzone.on("success", function(file, message){
            $("#msg").html(message);
            //setTimeout(function(){window.location.href="index.php"},200);
        });
            
        myDropzone.on("error", function (data) {
            $("#msg").html('<div class="alert alert-danger">There is some thing wrong, Please try again!</div>');
        });
            
        myDropzone.on("complete", function(file) {
            //myDropzone.removeFile(file);
        });
            
        myDropzone.on('thumbnail', function(file, dataUri) {
            link_base64 = dataUri;
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
        if (url != undefined || url != '') {       
            var regExp = /^.*(youtu.be\/|v\/|u\/\w\/|embed\/|watch\?v=|\&v=|\?v=)([^#\&\?]*).*/;
            var match = url.match(regExp);
            if (match && match[2].length == 11) {
                $('#warningVideoIntro').css("color","green");
                document.getElementById("warningVideoIntro").innerHTML = "Link được chấp nhận.";
                // $('#videoObject').attr('src', 'https://www.youtube.com/embed/' + match[2] + '?autoplay=1&enablejsapi=1');
            }else{
                $('#warningVideoIntro').css("color","red");
                document.getElementById("warningVideoIntro").innerHTML = "Link video sai. Yêu cầu nhập lại!";
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
    characterCount();
    $("input[name=expert]").keyup(function(){
        characterCount();
    });
</script>
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
@endsection