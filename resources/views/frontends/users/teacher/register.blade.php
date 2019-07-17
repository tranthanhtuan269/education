@extends('frontends.layouts.app') 
@section('content')

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
                            <a href="#buyed" class="buyed" data-toggle="tab"><i class="fa fa-user"></i>&nbsp;&nbsp;Register</a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="buyed">
                                <div class="row">
                                    <form action="" method="post" enctype="multipart/form-data">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Chọn ảnh đại diện</label>
                                                <div class="dropzone dz-clickable" id="myDrop">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-6">
                                            <!-- <div class="form-group">
                                                <label>Chọn ảnh đại diện</label>
                                                <div class="dropzone dz-clickable" id="myDrop">
                                                </div>
                                            </div> -->
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
                                                    <input type="text" class="form-control" name="phone" value="{{ Auth::check() ? Auth::user()->phone : '' }}">

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
                                                        <option value="1" @if( Auth::check() && Auth::user()->gender == 1) selected @endif>Nữ</option>
                                                        <option value="2" @if( Auth::check() && Auth::user()->gender == 2) selected @endif>Nam</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label>Địa chỉ</label>
                                                <div class="form-group">
                                                    <textarea class="form-control" rows="4" cols="50" name="address">{{ Auth::check() ? Auth::user()->address : '' }}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-6">
                                            <div class="form-group">
                                                <label>Chuyên môn</label>
                                                <div class="form-group">
                                                    <textarea class="form-control" rows="3" cols="50" name="expert"></textarea>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label>CV</label>
                                                <div class="form-group">
                                                    <script src="https://cdn.ckeditor.com/ckeditor5/12.1.0/classic/ckeditor.js"></script>
                                                    <textarea id="editor-cv" class="form-control textarea-cv" rows="6" cols="50" name="cv"></textarea>
                                                    <p>Số từ trong CV: <span id="wordCount">0</span>/2000 từ. (Tối thiểu 100 từ)</p>
                                                    <script>
                                                        ClassicEditor
                                                            .create( document.querySelector( '#editor-cv' ) )
                                                            .then( editor => {
                                                                cv = editor;
                                                            } )
                                                            .catch( error => {
                                                                console.error( error );
                                                            } );
                                                    </script>
                                                    <!-- <script>
                                                        $('.textarea-cv').change(function() {
                                                            var value = $('.textarea-cv').val();

                                                            if (value.length == 0) {
                                                                $('#wordCount').html(0);
                                                                return;
                                                            }
                                                            var regex = /\s+/gi;
                                                            var wordCount = value.trim().replace(regex, ' ').split(' ').length;
                                                            if(wordCount<100 || wordCount>2000){
                                                            $('#wordCount').css("color","red");
                                                            }
                                                            $('#wordCount').html(wordCount);
                                                        });
                                                    </script> -->
                                                    <!-- <script type="text/javascript">
                                                        CKEDITOR.replace( '#editor-cv',{
                                                        extraPlugins : 'wordcount',
                                                        wordcount : {
                                                            showCharCount : true,
                                                            showWordCount : true,
                                            
                                                            // Maximum allowed Word Count
                                                            maxWordCount: 300,

                                                            // Maximum allowed Char Count
                                                            maxCharCount: 1000
                                                        }
                                                        } );

                                                    //]]>
                                                    </script> -->
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
                                                <button class="btn btn-success" id="save-profile" type="button"><i class="fa fa-save"></i>Lưu</button>
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
    Dropzone.autoDiscover = false;
    $(document).ready(function(){
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
                thisDropzone.emit("thumbnail", mockFile, "{{ url('frontend/images/avatar.jpg') }}")
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
                    html: 'Ngày sinh không hợp lệ!',
                })
				return false;
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
                        expert: $('textarea[name=expert]').val().trim(),
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
                        expert: $('textarea[name=expert]').val().trim(),
                        video_intro : $('input[name=video-intro]').val().trim(),
                        cv : cv.getData(),
                    };
            }


            $.ajax({
                method: "POST",
                url: "{{ url('user/register-teacher') }}",
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
                                window.location.href = "/";
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
            $("#msg").html('<div class="alert alert-danger">Một số thông tin chưa đúng. Yêu cầu nhập lại!</div>');
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
                document.getElementById("warningVideoIntro").innerHTML = "Link Youtube.";
                // $('#videoObject').attr('src', 'https://www.youtube.com/embed/' + match[2] + '?autoplay=1&enablejsapi=1');
            }else{
                $('#warningVideoIntro').css("color","red");
                document.getElementById("warningVideoIntro").innerHTML = "Không phải link Youtube. Yêu cầu nhập lại!";
            }
        }
    });
</script>
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
<script src="http://code.jquery.com/jquery-1.7.1.min.js"></script>
@endsection