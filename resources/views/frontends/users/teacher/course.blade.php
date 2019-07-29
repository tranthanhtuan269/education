@extends('frontends.layouts.app') 
@section('content')
<!-- Include the plugin's CSS and JS: -->
<link rel="stylesheet" href="{{ asset('frontend/css/bootstrap-multiselect.css') }}" type="text/css">
<script type="text/javascript" src="{{ asset('frontend/js/bootstrap-multiselect.js') }}"></script>

<script src="{{ asset('frontend/js/dropzone.js') }}"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<div class="u-dashboard-top" style="background-image: url({{ url('frontend/images/bg-db-user.jpg') }});">
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
            <div class="box-course-hold tabbable-panel">
                {{-- <div class="tabbable-line">
                    <ul class="nav nav-tabs">
                        <li class="active">
                            <a href="#buyed" class="buyed" data-toggle="tab"><i class="fa fa-play-circle"></i>&nbsp;&nbsp;Khóa học</a>
                        </li>
                    </ul> --}}
                    <div class="tab-content">
                        <div class="tab-pane active" id="buyed">
                            <div class="row">
                                <div class="col-sm-6">
                                    <form action="" method="get">
                                        <div class="form-inline box-search-course">
                                            <div class="form-group box-input">
                                                <input type="text" class="form-control" name="u-keyword" placeholder="Tìm kiếm..." value="{{ Request::get('u-keyword') }}">
                                            </div>
                                            <div class="form-group">
                                                <button type="submit" class="btn btn-success">Tìm kiếm</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="col-sm-6">
                                    <div class="pull-right"><button class="btn btn-primary" id="create-course-btn"><i class="fas fa-book fa-fw"></i>Tạo khóa học</button></div>
                                </div>
                            </div>
                            <div class="row">
                                @if (count($lifelong_course) > 0)
                                    @foreach ($lifelong_course as $course)
                                    @include(
                                        'components.admin-course', 
                                        [   
                                            'course' => $course
                                        ]
                                    )
                                    @endforeach
                                    <div class="col-xs-12 text-center">
                                        <div class="u-number-page">{{ $lifelong_course->appends(Request::all())->links() }}</div>
                                    </div>
                                @else
                                    <div class="col-xs-12">
                                        <p class="result-search-u-keyword">
                                            @if (Request::get('u-keyword'))
                                                No results
                                            @else
                                                Has not purchased the course on Courdemy
                                            @endif
                                        </p>
                                    </div>
                                @endif
                            </div>
                            
                        </div>
                        {{-- <div class="tab-pane" id="membership">
                            <p>Chưa kích hoạt khóa học với thẻ membership</p>
                        </div> --}}
                    </div>
                </div>
            {{-- </div> --}}
        </div>
    </div>
</div>

<div id="createCourse" class="box-course modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="exampleModalLabel">Tạo khóa học mới</h4>
            </div>
            <div class="modal-body">
                <form class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Chọn ảnh</label>
                            <div class="dropzone dz-clickable" id="myDrop0">
                                <div class="dz-default dz-message" data-dz-message="">
                                    <span>Tải lên</span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="price" class="control-label">Giá khóa học:</label>
                            <input type="text" class="form-control" id="course-price" name="price">
                        </div>
                        <div class="form-group">
                            <label for="level" class="control-label">Cấp độ:</label>
                            <input type="text" class="form-control" id="course-level" name="level">
                        </div>
                        <div class="form-group">
                            <label for="approx_time" class="control-label">Thời gian ước tính: (giờ)</label>
                            <input type="text" class="form-control" id="course-approx-time" name="approx-time">
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="form-group">
                            <label for="name" class="control-label">Tên khóa học:</label>
                            <input type="text" class="form-control" id="course-name" name="name">
                        </div>
                        <div class="form-group">
                            <label for="short_description" class="control-label">Tóm tắt:</label>
                            <input type="text" class="form-control" id="short-description" name="short-description">
                        </div>
                        <div class="form-group">
                            <label for="description" class="control-label">Mô tả:</label>
                            <textarea id="course-description" name="description" class="form-control" rows="5" style="margin: 0px -11.3438px 0px 0px; width: 558px; height: 150px;"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="will-learn" class="control-label">Học viên sẽ học được:</label>
                            <input type="text" class="form-control" id="course-will-learn" name="will-learn" placeholder="ví dụ 1, ví dụ 2, ví dụ 3">
                        </div>
                        <div class="form-group">
                            <label for="requirement" class="control-label">Yêu cầu:</label>
                            <input type="text" class="form-control" id="course-requirement" name="requirement" placeholder="ví dụ 1, ví dụ 2, ví dụ 3">
                        </div>
                        <div class="form-group">
                            <label for="category" class="control-label">Danh mục:</label>
                            <script type="text/javascript">
                                $('#course-category').multiselect();
                            </script>
                            <select class="form-control" id="course-category" name="category">
                                @foreach($categories as $category)
                                <optgroup label="{{ $category->name }}">
                                    @foreach($category->children as $child)
                                    <option value="{{ $child->id }}">{{ $child->name }}</option>
                                    @endforeach
                                </optgroup>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Hủy</button>
                <button type="button" class="btn btn-primary" id="save-btn">Tạo</button>
            </div>
        </div>
    </div>
</div>

<div id="editCourse" class="box-course modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="exampleModalLabel">Chỉnh sửa <span id="course-name"></span>Khóa học</h4>
            </div>
            <div class="modal-body">
                <form class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Chọn ảnh</label>
                            <div class="dropzone dz-clickable" id="myDrop">
                                <div class="dz-default dz-message" data-dz-message="">
                                    <span>Tải lên</span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="price" class="control-label">Giá:</label>
                            <input type="text" class="form-control" id="course-price" name="price">
                        </div>
                        <div class="form-group">
                            <label for="level" class="control-label">Cấp độ:</label>
                            <input type="text" class="form-control" id="course-level" name="level">
                        </div>
                        <div class="form-group">
                            <label for="approx_time" class="control-label">Thời gian ước tính: (giờ)</label>
                            <input type="text" class="form-control" id="course-approx-time" name="approx-time">
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="form-group">
                            <label for="name" class="control-label">Tên khóa học:</label>
                            <input type="text" class="form-control" id="course-name" name="name">
                        </div>
                        <div class="form-group">
                            <label for="short_description" class="control-label">Mô tả ngắn:</label>
                            <input type="text" class="form-control" id="short-description" name="short-description">
                        </div>
                        <div class="form-group">
                            <label for="description" class="control-label">Mô tả:</label>
                            <textarea id="course-description" name="description" class="form-control" rows="5" style="margin: 0px -11.3438px 0px 0px; width: 558px; height: 150px;"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="will-learn" class="control-label">Học viên sẽ học được:</label>
                            <input type="text" class="form-control" id="course-will-learn" name="will-learn">
                        </div>
                        <div class="form-group">
                            <label for="requirement" class="control-label">Yêu cầu:</label>
                            <input type="text" class="form-control" id="course-requirement" name="requirement">
                        </div>
                        <div class="form-group">
                            <label for="category" class="control-label">Danh mục:</label>
                            <select class="form-control" id="course-category" name="category">
                            </select>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Hủy</button>
                <button type="button" class="btn btn-primary" id="save-btn">Tải lên</button>
            </div>
        </div>
    </div>
</div>

<div id="listVideo" class="modal fade list-video">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <div class="btn btn-primary pull-right btn-add-video" id="addVideoBtn" ><i class="fas fa-plus"></i> Thêm bài học</div>
                <h4 class="modal-title">Danh sách bài học</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <ul id="videoSortable" class="video-holder" data-unit-id="0">
                        
                    </ul>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default close-popup-lecture" data-dismiss="modal">Đóng</button>
            </div>
        </div>
    </div>
</div>

<div id="addVideoModal" class="modal fade add-video-modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                Thêm bài học
            </div>
            <div class="modal-body">
                <div class="form-group row">
                    <label class="col-sm-3" for="name">Tên bài học:</label>
                    <input class="col-sm-9 form-control add-video-name" type="text" class="form-control">
                </div>
                <div class="form-group row">
                    <label class="col-sm-3" for="name">Mô tả:</label>
                    <textarea class="col-sm-9 form-control add-video-description" rows="5" class="form-control" class="form-control"></textarea>
                </div>
                <div class="form-group row">
                    <div class="clearfix">
                        <label class="col-sm-3" for="name">Video bài học:</label>
                        <div class="btn-upload clearfix">
                            <span class="file-wrapper">
                              <input type="file" name="file-mp4-upload-off" id="file-mp4-upload-off">
                              <span class="button text-uppercase" >Tải lên</span>
                            </span>
                        </div>
                    </div>

                    {{-- <input type="file" name="file-mp4-upload-off" id="file-mp4-upload-off"> --}}
                    <div class="progress">
                        <div class="progress-bar" role="progressbar" aria-valuenow="70"aria-valuemin="0" aria-valuemax="100" style="width:0%">
                            <span class="sr-only">Hoàn thành 0%</span>
                        </div>
                    </div>
                    <video controls="controls" src="" style="max-width:100%" class="hidden">
                        Your browser does not support the HTML5 Video element.
                    </video>
                </div>                                         
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary save-add-video">Lưu</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
            </div>
        </div>
    </div>
</div>

<input type="hidden" id="fileName" name="fileName" value="">
<input type="hidden" id="duration" value="">

<div id="editVideoModal" class="modal fade edit-video-modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                Chỉnh sửa bài học: <span id="lecture-name"></span>
            </div>
            <div class="modal-body">
                <div class="form-group row">
                    <label class="col-sm-3" for="name">Tên:</label>
                    <input class="col-sm-9 form-control edit-video-name" type="text" class="form-control">
                </div>
                <div class="form-group row">
                    <label class="col-sm-3" for="name">Mô tả:</label>
                    <textarea class="col-sm-9 form-control edit-video-description" rows="5" class="form-control" class="form-control"></textarea>
                </div>
                <div class="form-group row">
                    <div class="clearfix">
                        <label class="col-sm-3" for="name">Video bài học:</label>
                        <div class="btn-upload clearfix">
                            <span class="file-wrapper">
                              <input type="file" name="file-mp4-upload-off" id="file-mp4-upload-off-updated">
                              <span class="button text-uppercase" >Tải lên</span>
                            </span>
                        </div>
                    </div>
                    <div class="progress">
                        <div class="progress-bar" role="progressbar" aria-valuenow="70"aria-valuemin="0" aria-valuemax="100" style="width:0%">
                            <span class="sr-only">Hoàn thành 0%</span>
                        </div>
                    </div>
                    <video controls="controls" src="" style="max-width:100%">
                        Your browser does not support the HTML5 Video element.
                    </video>
                </div>       
                        
            </div>

            <div class="modal-footer">
                <button class="btn btn-primary save-edit-video">Lưu</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
            </div>
        </div>
    </div>
</div>
<script>
    Dropzone.autoDiscover = false;
    $(document).ready(function(){
        $('#create-course-btn').click(function(){
            // alert(1)
            $('#createCourse').modal('toggle')
        })

        $('body').on('click','#createCourse .dz-image-preview',function(){
            $("#myDrop0").trigger("click")
        })


        var link_base64;
        var myDropzone = new Dropzone("div#myDrop0", 
        { 
            paramName: "files", // The name that will be used to transfer the file
            addRemoveLinks: true,
            uploadMultiple: false,
            autoProcessQueue: true,
            parallelUploads: 50,
            maxFilesize: 5, // MB
            thumbnailWidth:"259",
            thumbnailHeight:"200",
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
                $('#createCourse .dz-image-preview').show(500);
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
                // var thisDropzone = this;
                // var mockFile = { name: '', size: 12345, type: 'image/jpeg' };
                // thisDropzone.emit("addedfile", mockFile);
                // thisDropzone.emit("success", mockFile);
                // // thisDropzone.emit("thumbnail", mockFile, "{{ url('frontend/'.((Auth::user()->avatar != '') ? Auth::user()->avatar : 'images/avatar.jpg') ) }}")
                // // this.on("maxfilesexceeded", function(file){
                // // this.removeFile(file);
                // //     alert("No more files please!");
                // // });

                this.on('addedfile', function(file) {
                    $('#createCourse .dz-image-preview').hide(500);
                    $('#createCourse .dz-progress').hide();
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
            $("#msg").html('<div class="alert alert-danger">Có lỗi, mời thử lại!</div>');
        });

        myDropzone.on("complete", function(file) {
            //myDropzone.removeFile(file);
        });

        myDropzone.on('thumbnail', function(file, dataUri) {
            link_base64 = dataUri;
        });

        $('#save-btn').click(function(){
            var course_name = $('#course-name').val()
            var short_description = $('#short-description').val()
            var course_description = $('#course-description').val()
            var course_will_learn = $('#course-will-learn').val()
            var course_requirement = $('#course-requirement').val()
            var course_price = $('#course-price').val()
            var course_level = $('#course-level').val()
            var course_approx_time = $('#course-approx-time').val()
            var course_category = $('#course-category').val()
            $('#createCourse').modal('toggle')

            var data = {
                image:link_base64,
                name: course_name,
                short_description: short_description,
                description: course_description,
                will_learn: course_will_learn,
                requirement: course_requirement,
                price: course_price,
                level: course_level,
                approx_time: course_approx_time,
                category: course_category,
            };

            $.ajax({
                method: "POST",
                url: "{{ url('user/courses/store') }}",
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
        })

        $('#addVideoModal').on('hidden.bs.modal', function () {
            $('#listVideo').modal('toggle');
        });

        $('#editVideoModal').on('hidden.bs.modal', function () {
            $('#listVideo').modal('toggle');
        });

        $('#listVideo').on('shown.bs.modal', function () {
            var unit_id = $(this).attr('data-unit-id');
            $('#addVideoBtn').attr('data-unit-id', unit_id);
            $.ajax({
                method: 'GET',
                url: "{{ url('/') }}/user/units/"+unit_id+"/get-video",
                dataType: 'json',
                success: function (response) {
                    if(response.status == '200'){
                        var html = "";
                        for(var i = 0; i < response.videos.length; i++){
                            html += '<li class="ui-state-default ui-sortable-handle"  data-video-id="'+response.videos[i].id+'" data-unit-id="'+unit_id+'" data-video-index="'+response.videos[i].index+'">'
                            html += '<i class="fas fa-sort"></i> '
                            html += '<span class="video-content">'+response.videos[i].name+'</span>'
                            html += '<i class="fas fa-trash pull-right remove-video" data-video-id="'+response.videos[i].id+'" data-unit-id="'+unit_id+'" data-video-index="'+response.videos[i].index+'"></i>'
                            html += '<i class="fas fa-edit pull-right edit-video" data-video-id="'+response.videos[i].id+'" data-unit-id="'+unit_id+'" data-video-index="'+response.videos[i].index+'"></i>'
                            html += '</li>'
                        }
                        $('#videoSortable').html(html);

                        addEventAndSort();
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
                    })
                }
            })
        })

        $('#listVideo').on('hide.bs.modal', function () {
            $('#videoSortable').html("");
            var unit_id = $(this).attr('data-unit-id');
        });

        $('.close-popup-lecture').click(function(){
			$('.active-modal').modal('toggle');
        })

        $('#addVideoBtn').on('click', function () {
            $('#listVideo').modal('toggle')
            $('#addVideoModal').modal('toggle');
            $('.save-add-video').attr('data-unit-id', $(this).attr('data-unit-id'));
            $('#addVideoModal input.add-video-name').val('');
            $('#addVideoModal textarea.add-video-description').val('');
            $('#addVideoModal video').addClass('hidden');
        })

        function addEventAndSort(){
            $(".progress-bar").html('');
            $(".progress-bar").css("width", "0%");
            $(".progress-bar").attr("aria-valuemax", "0");
            $(".edit-video").off('click')
            $(".edit-video").click(function(){
                var video_id = $(this).attr('data-video-id');
                $('#listVideo').modal('hide')
                $('#editVideoModal').attr('data-video-id', video_id).modal('toggle')

                $.ajax({
                method: 'GET',
                url: "{{ url('/') }}/user/videos/"+video_id,
                dataType: 'json',
                success: function (response) {
                    console.log(response);
                    if(response.status == '200'){
                        $('#editVideoModal input.edit-video-name').val(response.video.name);
                        $('#editVideoModal textarea').val(response.video.description);
                        $('#editVideoModal video').attr('src', "{{ url('uploads/videos') }}/" + response.video.link_video);
                        $("#editVideoModal video")[0].load();
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
                    })
                }
            })

            });

            $('.save-add-video').off('click');
            $('.save-add-video').click(function(){
                var unit_id = $(this).attr('data-unit-id');
                var video_name = $('.add-video-name').val()
                var video_description = $('.add-video-description').val()
                var link_video = $('#fileName').val()
                // alert(link_video);return;
                $.ajax({
                    method: 'POST',
                    url: "{{ url('user/units/video/store') }}",
                    data:{
                        name        : video_name,
                        description : video_description,
                        unit_id     : unit_id,
                        link_video  : link_video,
                    },
                    dataType: 'json',
                    success: function (response) {
                        if(response.status == '200'){
                            $('#addVideoModal').modal('hide')
                            // $('#listVideo').modal('toggle')
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
                        })
                    }
                })
            })

            $('.save-edit-video').off('click');
            $('.save-edit-video').on('click', function () {
                var video_id = $('#editVideoModal').attr('data-video-id');
                var video_name = $('.edit-video-name').val()
                var video_description = $('.edit-video-description').val()
                var link_video = $('#fileName').val()

                $.ajax({
                    method: 'PUT',
                    url: "{{ url('/') }}/user/units/video/"+ video_id + "/update",
                    data:{
                        name        : video_name,
                        description : video_description,
                        link_video  : link_video,
                    },
                    dataType: 'json',
                    success: function (response) {
                        if(response.status == '200'){
                            $('#editVideoModal').modal('hide')
                            // $('#listVideo').modal('toggle')
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
                        })
                    }
                })
            })

            $(".remove-video").off('click');
            $(".remove-video").click(function(){
                var sefl = $(this)
                var video_id = $(this).attr('data-video-id')

                $.ajax({
                    method: 'DELETE',
                    url: "{{ url('/') }}/user/units/video/remove",
                    data: {
                        video_id : video_id
                    },
                    dataType: 'json',
                    success: function (response) {
                        if(response.status == '200'){
                            sefl.parent().remove();
                        }
                    },
                    error: function () {

                    }
                })
            });

            $( "#videoSortable" ).sortable({
                placeholder: "ui-state-highlight",
                update: function( event, ui ) {
                    // check key begin vs after
                    var data = [];
                    $.each($( "#videoSortable li" ), function( index, value ) {
                        if(index != $(value).attr('data-video-index'))
                        data.push({
                            id: $(value).attr('data-video-id'),
                            index: index,
                        });
                        
                    });
                    // end check key 
                    $.ajax({
                        method: "PUT",
                        url: "{{ url('/') }}/user/videos/sort",
                        data: {
                            data: JSON.stringify( data )
                        },
                        dataType: 'json',
                        success: function (response) {

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
                    addEvent()
                }
            });

            //// upload video updated
            $("#editVideoModal #file-mp4-upload-off-updated").change(function(){
                $.ajaxSetup(
                    {
                        headers:
                        {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                var file = document.getElementById("file-mp4-upload-off-updated").files[0];
                var extension = document.getElementById("file-mp4-upload-off-updated").files[0].name;
                extension = extension.split(".");
                extension_input = extension[extension.length - 1];
                extension_input = extension_input.toLowerCase();
                var arrExtension = ["mp4"];
                if(jQuery.inArray(extension_input, arrExtension) !== -1) {
                    // $('.btn-upload, .or, .btn-link').hide();
                    $('.progressBar').show();
                    var formdata = new FormData();
                    formdata.append("file-mp4-upload-off", file);
                    formdata.append("_token", $('meta[name="csrf-token"]').attr('content'));
                    // formdata.append("data", "{ demo : '{{ time() }}'  }");
                    var ajax = new XMLHttpRequest();
                    ajax.upload.addEventListener("progress", progressHandler, false);
                    ajax.addEventListener("load", completeHandlerEdit, false);
                    ajax.addEventListener("error", errorHandler, false);
                    ajax.addEventListener("abort", abortHandler, false);
                    ajax.open("POST", "{{ url('/') }}/saveFileAjax");
                    ajax.setRequestHeader("X-CSRF-Token", $('meta[name="csrf-token"]').attr('content'));
                    ajax.send(formdata);
                } else {
                    Swal.fire({
                        type: 'warning',
                        html: 'Lỗi định dạng.',
                    })
                }
                $('#file-mp4-upload-off-updated').val('');
            });

            //// upload video
            $("#addVideoModal #file-mp4-upload-off").change(function(){
                uploadFile();
            });

            function uploadFile(){
                $.ajaxSetup(
                    {
                        headers:
                        {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                var file = document.getElementById("file-mp4-upload-off").files[0];
                var extension = document.getElementById("file-mp4-upload-off").files[0].name;
                extension = extension.split(".");
                extension_input = extension[extension.length - 1];
                extension_input = extension_input.toLowerCase();
                var arrExtension = ["mp4"];
                if(jQuery.inArray(extension_input, arrExtension) !== -1) {
                    // $('.btn-upload, .or, .btn-link').hide();
                    $('.progressBar').show();
                    var formdata = new FormData();
                    formdata.append("file-mp4-upload-off", file);
                    formdata.append("_token", $('meta[name="csrf-token"]').attr('content'));
                    // formdata.append("data", "{ demo : '{{ time() }}'  }");
                    var ajax = new XMLHttpRequest();
                    ajax.upload.addEventListener("progress", progressHandler, false);
                    ajax.addEventListener("load", completeHandler, false);
                    ajax.addEventListener("error", errorHandler, false);
                    ajax.addEventListener("abort", abortHandler, false);
                    ajax.open("POST", "{{ url('/') }}/saveFileAjax");
                    ajax.setRequestHeader("X-CSRF-Token", $('meta[name="csrf-token"]').attr('content'));
                    ajax.send(formdata);
                } else {
                    Swal.fire({
                        type: 'warning',
                        html: 'Lỗi định dạng.',
                    })
                }
                $('#file-mp4-upload-off').val('');
            }

            function progressHandler(event){
                var percent = (event.loaded / event.total) * 100;
                console.log(percent);
                var type_txt = checkTypeFile(extension_input);
                waitting_upload_file = true;

                $(".progress-bar").css("width", Math.round(percent) + "%");
                $(".progress-bar").html(Math.round(percent) + "%");
            }

            function completeHandler(event) {
                unsaved = true;
                textUpload = event.target.responseText;
                // alert(textUpload)
                $('#fileName').val(textUpload);
                $('#addVideoModal video').removeClass('hidden');
                $('#addVideoModal video').attr('src', "{{ url('uploads/videos') }}/" + textUpload + '.mp4');
                $("#addVideoModal video")[0].load();
            }

            function completeHandlerEdit(event) {
                unsaved = true;
                textUpload = event.target.responseText;
                $('#fileName').val(textUpload);
                $('#editVideoModal video').attr('src', "{{ url('uploads/videos') }}/" + textUpload + '.mp4');
                $("#editVideoModal video")[0].load();
            }

            function errorHandler(event) {
                // alert("Upload Failed");
                document.getElementById("status").innerHTML = "Tải lên thất bại";
            }

            function abortHandler(event) {
                // swal({
                //   title: "Are you sure?",
                //   text: "Once cancel, you will not be able to recover this imaginary file!",
                //   icon: "warning",
                //   buttons: true,
                //   dangerMode: true,
                // });

                //alert("Upload Aborted");
                //document.getElementById("status").innerHTML = "Upload Aborted";
            }

            function checkTypeFile(extension) {
                if (extension == 'mp3' || extension == 'aac' || extension == 'ogg' || extension == 'm4a' || extension == 'wma' || extension == 'wav' || extension == 'wma'|| extension == 'flac') {
                    return 'Audio';
                } else {
                    return '100%';
                } 
            }

        }
    });
</script>
@endsection