@extends('frontends.layouts.app') 
@section('content')

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
            <div class="box-user tabbable-panel">
                <div class="tabbable-line">
                    <ul class="nav nav-tabs">
                        <li class="active">
                            <a href="#buyed" class="buyed" data-toggle="tab"><i class="fa fa-play-circle"></i>&nbsp;&nbsp;Courses</a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="buyed">
                            <div class="row">
                                <div class="col-sm-6">
                                    <form action="" method="get">
                                        <div class="form-inline box-search-course">
                                            <div class="form-group box-input">
                                                <input type="text" class="form-control" name="u-keyword" placeholder="Search course..." value="{{ Request::get('u-keyword') }}">
                                            </div>
                                            <div class="form-group">
                                                <button type="submit" class="btn btn-success">Search</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="row">
                                @if (count($lifelong_course) > 0)
                                    @foreach ($lifelong_course as $course)
                                    <?php
                                        $lecturers = count($course->Lecturers()) > 1 ? 'Nhiều tác giả' : count($course->Lecturers()) > 0 ? $course->Lecturers()[0]->user->name : "Courdemy";
                                    ?>
                                    @include(
                                        'components.teaching-course', 
                                        [   
                                            'id'    => $course->id,
                                            'slug' => $course->slug,
                                            'rawImage' => $course->image,
                                            'image' => url('/frontend/images/'.$course->image),
                                            'title' => $course->name,
                                            'author' => $lecturers,
                                            'star_count' => $course->star_count,
                                            'vote_count' => $course->vote_count,
                                            'time' => $course->approx_time,
                                            'view_number' => $course->view_count,
                                            'price' => $course->real_price,
                                            'sale' => $course->price,
                                            'from_sale' => $course->from_sale,
                                            'to_sale' => $course->to_sale,
                                            'btn_start_learning' => true,
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
            </div>
        </div>
    </div>
</div>
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
                    type: 'error',
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
            $("#msg").html('<div class="alert alert-danger">There is some thing wrong, Please try again!</div>');
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
                            type: 'error',
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
                        type: 'error',
                        html: txt_errors,
                    })
                }
            });

            return;
        })
    });

    function addUnit(unit_name, course_id){
        
    }

    function saveUnit(x){
        // alert(x)
    }

@endsection