<?php
    if($course->vote_count == 0) $course->vote_count = 1;
    $image = url('/frontend/images/'.$course->image);
    $lecturers = count($course->Lecturers()) > 1 ? 'Nhiều tác giả' : count($course->Lecturers()) > 0 ? $course->Lecturers()[0]->user->name : "Courdemy";
?>
<div class="col-sm-3" id="course-{{ $course->id }}">
    <div class="box-course">
        <button class="btn btn-primary btn-unit-course" id="btn-unit-{{ $course->id }}"><i class="fas fa-bars"></i></button>
        <button class="btn btn-primary btn-edit-course" id="btn-edit-{{ $course->id }}"><i class="fas fa-edit"></i></button>
        <button class="btn btn-danger btn-remove-course" id="btn-remove-{{ $course->id }}"><i class="fas fa-trash"></i></button>
        <div class="img-course">
            <img class="img-responsive"
                src="{{ $image }}"
                alt="{{ $course->name }}">
            @if (isset($course->heart))
            <i class="fa fa-heart fa-lg heart-icon" aria-hidden="true"></i>    
            @endif

            @if (isset($course->setup))  
            <i class="fa fa-cog fa-lg setting-icon" aria-hidden="true"></i>
            @endif
        </div>
        <a href="{{ url('/') }}/course/{{ $course->slug }}" title="{{ $course->name }}" class="pop">            
            <div class="content-course">
                <h3 class="title-course">{{ $course->name }}</h3>
                <div class="clearfix" style="line-height:1.7">
                    <span class="name-teacher pull-left">
                        {{ $lecturers }}
                    </span>
                    <br>
                    <span class="pull-left">
                        @include(
                            'components.vote', 
                            [
                                'rate' => intval($course->star_count) / intval($course->vote_count),
                                'rating_number' => $course->vote_count,
                            ]
                        )
                    </span>
                </div>
                <div class="time-view">
                    <span class="time">
                        <i class="fas fa-stopwatch"></i> {{ $course->approx_time }} giờ
                    </span>
                    <span class="view pull-right">
                        <i class="fa fa-eye" aria-hidden="true"></i> {!! number_format($course->view_number, 0, ',' , '.') !!}
                    </span>
                </div>

                <?php
                    $check_time_sale = false;
                    if ($course->from_sale != '' && $course->to_sale != '') {
                        $course->start_sale = strtotime($course->from_sale.' 00:00:00');
                        $course->end_sale = strtotime($course->to_sale.' 23:59:59');
                        if (time() >= $course->start_sale && time() <= $end_sale) {
                            $check_time_sale = true;
                        }
                    }
                ?>
            </div>
        </a>
    </div>
</div>

<div id="editCourse{{ $course->id }}" class="box-course modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="exampleModalLabel">Chỉnh sửa {{ $course->name }} khóa học</h4>
            </div>
            <div class="modal-body">
                <form class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Chọn ảnh</label>
                            <div class="dropzone dz-clickable" id="myDrop{{ $course->id }}">
                                <div class="dz-default dz-message" data-dz-message="">
                                    <span>Tải ảnh lên</span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="price" class="control-label">Giá khóa học:</label>
                            <input type="text" class="form-control" id="course-price{{ $course->id }}" name="price" value="{{ $course->price }}">
                        </div>
                        <div class="form-group">
                            <label for="level" class="control-label">Cấp độ:</label>
                            <input type="text" class="form-control" id="course-level{{ $course->id }}" name="level" value="{{ $course->level }}">
                        </div>
                        <div class="form-group">
                            <label for="approx_time" class="control-label">Thời gian dự kiến hoàn thành: (giờ)</label>
                            <input type="text" class="form-control" id="course-approx-time{{ $course->id }}" name="approx-time" value="{{ $course->approx_time }}">
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="form-group">
                            <label for="name" class="control-label">Tên khóa học:</label>
                            <input type="text" class="form-control" id="course-name{{ $course->id }}" name="name" value="{{ $course->name }}">
                        </div>
                        <div class="form-group">
                            <label for="short_description" class="control-label">Mô tả ngắn:</label>
                            <input type="text" class="form-control" id="short-description{{ $course->id }}" name="short-description" value="{{ $course->short_description }}">
                        </div>
                        <div class="form-group">
                            <label for="description" class="control-label">Mô tả:</label>
                            <textarea id="course-description{{ $course->id }}" name="description" class="form-control" rows="5" style="margin: 0px -11.3438px 0px 0px; width: 558px; height: 150px;">{{ $course->description }}</textarea>
                        </div>
                        @php
                        $will_learns = \json_decode($course->will_learn);
                        $requirements = \json_decode($course->requirement);
                        @endphp
                        @if (is_array($will_learns))
                            @php
                                $will_learn_string = "";
                                foreach ($will_learns as $key => $will) {
                                    if($key > 0){
                                        $will_learn_string .= ",";
                                    }
                                    $will_learn_string .= $will;    
                                }
                            @endphp
                            <div class="form-group">
                                <label for="will-learn" class="control-label">Học viên sẽ học được:</label>                            
                                <input type="text" class="form-control" id="course-will-learn{{ $course->id }}" name="will-learn" value="{{$will_learn_string}}">
                            </div>
                        @else
                            <div class="form-group">
                                <label for="will-learn" class="control-label">Học viên sẽ học được:</label>                            
                                <input type="text" class="form-control" id="course-will-learn{{ $course->id }}" name="will-learn" value="{{$will_learns}}">
                            </div>
                        @endif
                        @if (is_array($requirements))                            
                            @php
                            $requirement_string = "";
                            foreach ($requirements as $key => $requirement) {
                                if($key > 0){
                                    $requirement_string .= ",";
                                }
                                $requirement_string .= $requirement;    
                            }
                            @endphp
                            <div class="form-group">
                                <label for="requirement" class="control-label">Yêu cầu:</label> 
                                <input type="text" class="form-control" id="course-requirement{{ $course->id }}" name="requirement" value="{{ $requirement_string }}">
                            </div>
                        @else
                            <div class="form-group">
                                <label for="requirement" class="control-label">Yêu cầu:</label> 
                                <input type="text" class="form-control" id="course-requirement{{ $course->id }}" name="requirement" value="{{$requirements}}">
                            </div>
                        @endif
                        <div class="form-group">
                            <label for="category" class="control-label">Danh mục:</label>
                            <script type="text/javascript">
                                $('#course-category{{ $course->id }}').multiselect();
                            </script>
                            <select class="form-control" id="course-category{{ $course->id }}" name="category">
                                @foreach($categories as $category)
                                <optgroup label="{{ $category->name }}">
                                    @foreach($category->children as $child)
                                    @if($category->id == $course->category_id)
                                    <option value="{{ $child->id }}" selected>{{ $child->name }}</option>
                                    @else
                                    <option value="{{ $child->id }}">{{ $child->name }}</option>
                                    @endif
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
                <button type="button" class="btn btn-primary" id="save-btn{{ $course->id }}">Cập nhật</button>
            </div>
        </div>
    </div>
</div>

<div id="listUnit{{ $course->id }}" class="box-unit modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="btn btn-primary pull-right" id="add-unit-btn"><i class="fas fa-plus"></i>Thêm phần học</div>
                <h4 class="modal-title" id="exampleModalLabel">Danh sách các phần</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <ul id="sortable" class="unit-holder-{{ $course->id }}">
                        <?php //dd($course->units); ?>
                        @foreach($course->units as $key => $unit)
                        <li class="ui-state-default" data-unit-id="{{ $unit->id }}" data-unit-key="{{ $key }}">
                            <i class="fas fa-sort"></i> 
                            <span class="unit-content">{{ $unit->name }}</span> 
                            <i class="fas fa-trash remove-unit" id="remove-unit-{{ $unit->id }}" data-unit-id="{{ $unit->id }}" data-course-id="{{ $course->id }}"></i>
                            <i class="fas fa-edit edit-unit" id="edit-unit-{{ $unit->id }}" data-unit-id="{{ $unit->id }}" data-course-id="{{ $course->id }}"></i>
                            <i class="fas fa-bars list-vid-unit" id="list-vid-unit-{{ $unit->id }}" data-unit-id="{{ $unit->id }}" data-course-id="{{ $course->id }}"></i>
                        </li>                        
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
            </div>
        </div>
    </div>
</div>

<script>
    Dropzone.autoDiscover = false;
    $(document).ready(function(){
        var old_pos = 0;
        $( "#listUnit{{ $course->id }} #sortable" ).sortable({
            placeholder: "ui-state-highlight",
            update: function( event, ui ) {
                // check key begin vs after

                old_pos = $(ui.item).attr('data-unit-key');                

                var data = [];
                var new_pos;
                $.each($( "#listUnit{{ $course->id }} li" ), function( index, value ) {

                    if($(value).attr('data-unit-key') == old_pos){
                        new_pos = index
                    }
                    if(index != $(value).attr('data-unit-key'))
                    data.push({
                        id: $(value).attr('data-unit-id'),
                        index: index,                        
                    });
                    $(value).attr('data-unit-key', index)

                });
                console.log(`old_pos: ${old_pos}`)
                console.log(`new_pos: ${new_pos}`)
                // end check key 
                $.ajax({
                    method: "PUT",
                    url: "{{ url('/') }}/user/units/sort",
                    data: {
                        data: JSON.stringify( data ),
                        old_pos: old_pos,
                        new_pos: new_pos
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

        $( "#listUnit{{ $course->id }} #sortable" ).disableSelection();

        $("#listUnit{{ $course->id }} #add-unit-btn").click(function(){
            var data = {
                name: "My Unit",
                course_id: {{ $course->id }}
            }

            $.ajax({
                method: "POST",
                url: "{{ url('user/units/store') }}",
                data: data,
                dataType: 'json',
                success: function (response) {
                    if(response.status == 200){
                        console.log(response.unit.data.id);
                        var html = '<li class="ui-state-default" data-unit-id="'+response.unit.data.id+'" data-unit-key="'+(response.unit.data.index-1)+'"><i class="fas fa-sort"></i> <span class="unit-content">Item 1 </span> <i class="fas fa-trash remove-unit" id="remove-unit-'+response.unit.data.id+'" data-unit-id="'+response.unit.data.id+'" data-course-id="{{ $course->id }}"></i><i class="fas fa-edit edit-unit" id="edit-unit-'+response.unit.data.id+'" data-unit-id="'+response.unit.data.id+'" data-course-id="{{ $course->id }}"></i><i class="fas fa-bars list-vid-unit" id="list-vid-unit-'+response.unit.data.id+'" data-unit-id="'+response.unit.data.id+'" data-course-id="'+response.unit.data.id+'"></i></li>';
                        $("#listUnit{{ $course->id }} #sortable").append(html);
                        $("#listUnit{{ $course->id }} #sortable").sortable('refresh');
                        addEvent();
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
            })
        })

        addEvent()
        function addEvent(){
            $("#listUnit{{ $course->id }} .edit-unit").off('click')
            $("#listUnit{{ $course->id }} .remove-unit").off('click')
            $("#listUnit{{ $course->id }} .save-unit").off('click')
          
            $("#listUnit{{ $course->id }} .save-unit").click(function(){
                var content = $('#unit-input').val()
                // var html = '<i class="fas fa-sort"></i> <span class="unit-content">'+content+'</span> <i class="fas fa-trash remove-unit" id="remove-unit" data-id="{{ $course->id }}"></i><i class="fas fa-edit edit-unit" id="edit-unit" data-id="{{ $course->id }}"></i>'
                var parent = $(this).parent()
                var name = parent.find('input').val()

                // send data to server
                var unit_id = $(this).attr('data-unit-id')
                var course_id = $(this).attr('data-course-id')
                var data = {
                    name: name
                }

                $.ajax({
                    method: "PUT",
                    url: "{{ url('/') }}/user/units/"+unit_id+"/update",
                    data: data,
                    dataType: 'json',
                    success: function (response) {
                        if(response.status == 200){
                            parent.find('input').remove()
                            parent.find('i.save-unit').remove()

                            var html = ""
                            html += '<i class="fas fa-sort"></i> '
                            html += '<span class="unit-content">'+content+'</span>'
                            html += '<i class="fas fa-trash remove-unit" id="remove-unit-'+ unit_id +'" data-unit-id="'+ unit_id +'" data-course-id="'+ course_id +'"></i>'
                            html += '<i class="fas fa-edit edit-unit" id="edit-unit-'+ unit_id +'" data-unit-id="'+ unit_id +'" data-course-id="'+ course_id +'"></i>'
                            html += '<i class="fas fa-bars list-vid-unit" id="list-vid-unit-'+ unit_id +'" data-unit-id="'+ unit_id +'" data-course-id="'+ course_id +'"></i>'

                            parent.append(html)
                            addEvent()
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
                // end send data to server
                addEvent()
            })

            $("#listUnit{{ $course->id }} .edit-unit").click(function(){
                var unit_id = $(this).attr('data-unit-id');
                var content = $(this).parent().find('span.unit-content').html()
                var html = "<input class='form-control' id='unit-input' value='" + content +"'><i class='fas fa-check save-unit' id='btn-save-unit' data-unit-id='"+unit_id+"'></i>"
                $(this).parent().html(html);
                addEvent()
            })

            $("#listUnit{{ $course->id }} .remove-unit").click(function(){
                var unit_id = $(this).attr('data-unit-id')
                var sefl = $(this)
                var data = {
                    id: unit_id
                }

                //DuongNT // Đánh lại index cho từng unit sau khi xoá 1 unit
                var deleted_key = $(this).parent().attr("data-unit-key")
                $.each($( "#listUnit{{ $course->id }} #sortable li"), function( index, value ) {
                    if(index > (deleted_key)){
                        $(value).attr("data-unit-key", index-1)
                    }
                })

                $.ajax({
                    method: "DELETE",
                    url: "{{ url('user/units/delete') }}",
                    data: data,
                    dataType: 'json',
                    success: function (response) {
                        if(response.status == 200){
                            sefl.parent().remove()
                            $("#listUnit{{ $course->id }} #sortable").sortable('refresh')
                        }else if(response.status == 201) {
                            Swal.fire({
                                type:'warning',
                                text: response.message
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
                
            })

            $('#listUnit{{ $course->id }} .list-vid-unit').on('click', function () {
                var unit_id = $(this).attr('data-unit-id')
                $(".box-unit").modal('hide')
                $("#listVideo").attr("data-unit-id", unit_id)
                $("#listVideo").modal('show')
            })
        }

        $('#btn-edit-{{ $course->id }}').click(function(){
            $('#editCourse{{ $course->id }}').modal('toggle')
        })

        $('#btn-remove-{{ $course->id }}').click(function(){
            var data = {
                id: {{ $course->id }}
            };

            $.ajax({
                method: "DELETE",
                url: "{{ url('user/courses/delete') }}",
                data: data,
                dataType: 'json',
                beforeSend: function() {
                    $("#pre_ajax_loading").show();
                },
                complete: function() {
                    $("#pre_ajax_loading").hide();
                },
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
                            html: 'Lỗi',
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
        })

        $('#btn-unit-{{ $course->id }}').click(function(){
            $('#listUnit{{ $course->id }}').modal('toggle')
            $(".box-unit").removeClass('active-modal')
            $('#listUnit{{ $course->id }}').addClass('active-modal')
        })

        $('body').on('click','#editCourse{{ $course->id }} .dz-image-preview',function(){
            $("#myDrop{{ $course->id }}").trigger("click")
        })

        var link_base64;
        var myDropzone = new Dropzone("div#myDrop{{ $course->id }}", 
        { 
            paramName: "files", // The name that will be used to transfer the file
            addRemoveLinks: true,
            uploadMultiple: false,
            autoProcessQueue: true,
            parallelUploads: 50,
            maxFilesize: 5, // MB
            thumbnailWidth:"640",
            thumbnailHeight:"370",
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
                $('#editCourse{{ $course->id }} .dz-image-preview').show(500);
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
                thisDropzone.emit("thumbnail", mockFile, "{{ url('frontend/images/'.$course->image) }}")
                // this.on("maxfilesexceeded", function(file){
                // this.removeFile(file);
                //     alert("No more files please!");
                // });

                this.on('addedfile', function(file) {
                    $('#editCourse{{ $course->id }} .dz-image-preview').hide(500);
                    $('#editCourse{{ $course->id }} .dz-progress').hide();
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
            $("#msg").html('<div class="alert alert-danger">Có lỗi, làm ơn thử lại!</div>');
        });

        myDropzone.on("complete", function(file) {
            //myDropzone.removeFile(file);
        });

        myDropzone.on('thumbnail', function(file, dataUri) {
            link_base64 = dataUri;
        });

        $('#save-btn{{ $course->id }}').click(function(){
            var course_name = $('#course-name{{ $course->id }}').val()
            var short_description = $('#short-description{{ $course->id }}').val()
            var course_description = $('#course-description{{ $course->id }}').val()
            var course_will_learn = $('#course-will-learn{{ $course->id }}').val()
            var course_requirement = $('#course-requirement{{ $course->id }}').val()
            var course_price = $('#course-price{{ $course->id }}').val()
            var course_level = $('#course-level{{ $course->id }}').val()
            var course_approx_time = $('#course-approx-time{{ $course->id }}').val()
            var course_category = $('#course-category{{ $course->id }}').val()
            $('#editCourse{{ $course->id }}').modal('toggle')

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
                method: "PUT",
                url: "{{ url('user/courses/'.$course->id.'/update') }}",
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
    });
</script>