<?php
    $initial_vote_count = $course->vote_count;
    if($course->vote_count == 0) {
        $course->vote_count = 1;
    }
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
                        @if ($initial_vote_count == 0)
                            @include(
                                'components.vote', 
                                [
                                    'rate' => intval($course->star_count) / intval($course->vote_count),
                                    'rating_number' => 0,
                                ]
                            )
                        @else
                            @include(
                                'components.vote', 
                                [
                                    'rate' => intval($course->star_count) / intval($course->vote_count),
                                    'rating_number' => $course->vote_count,
                                ]
                            )                            
                        @endif
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

<div id="editCourse-{{ $course->id }}" class="box-course modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="exampleModalLabel">Chỉnh sửa khóa học <b>{{ $course->name }}</b></h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="image-cropit-editor">
                        <div class="box-course-preview" id="image-cropper-{{$course->id}}">
                            <div class="cropit-preview text-center preview-image-course">
                                <img class="sample-avatar" src="{{ asset('frontend/images/'.$course->image) }}" alt="sample avatar">
                            </div>
                            <input type="range" class="cropit-image-zoom-input" id="cropit-zoom-input-{{$course->id}}" style="display: none"/>
                            <input type="file" class="cropit-image-input" style="display:none" value="" id="image-file-input-{{$course->id}}"/>
                            <div class="text-center">
                                <div class="note">(Kích thước nhỏ nhất: 640x360)</div>
                                <div class="btn btn-primary select-image-btn" id="btn-cropit-upload-{{$course->id}}"><i class="fas fa-image fa-fw"></i> Tải lên ảnh khóa học</div>
                            </div>
                        </div>
                    </div>
                </div>
                <form class="row form-edit-course">
                        <div class="col-md-8">
                            <div class="form-group">
                                <label for="name" class="control-label">Tên khóa học:</label>
                                <input type="text" class="form-control" id="course-name-{{ $course->id }}" name="name" value="{{ $course->name }}">
                            </div>
                            <div class="form-group">
                                <label for="short_description" class="control-label">Mô tả ngắn:</label>
                                <input type="text" class="form-control" id="short-description-{{ $course->id }}" name="short-description-{{ $course->id }}" value="{{ $course->short_description }}">
                            </div>
                            <div class="form-group">
                                <label for="description" class="control-label">Mô tả:</label>
                                <textarea id="course-description-{{$course->id}}" class="form-control" rows="6" cols="50" name="description-course-{{ $course->id }}">{!! $course->description !!}</textarea>
                                <script>
                                        CKEDITOR.replace( 'description-course-{{ $course->id }}', {
                                                height: '300px',
                                            },
                                        )
                                </script>
                            </div>
                            
                            @if (is_array($course->requirement))                            
                                @php
                                $requirement_string = "";
                                foreach ($requirements as $key => $course->requirement) {
                                    if($key > 0){
                                        $requirement_string .= ",";
                                    }
                                    $requirement_string .= $course->requirement;    
                                }
                                @endphp
                                <div class="form-group">
                                    <label for="requirement" class="control-label">Yêu cầu:</label> 
                                    <input type="text" class="form-control" id="course-requirement-{{$course->id}}" name="requirement-{{$course->id}}" value="{{ $requirement_string }}">
                                </div>
                            @else
                                <div class="form-group">
                                    <label for="requirement" class="control-label">Yêu cầu:</label> 
                                    <input type="text" class="form-control" id="course-requirement-{{$course->id}}" name="requirement-{{$course->id}}" value="{{$course->requirement}}">
                                </div>
                            @endif
                        </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="price" class="control-label">Giá khóa học: (₫)</label>
                            <input type="text" class="form-control" id="course-price-{{$course->id}}" name="price-{{$course->id}}" value="{{$course->price}}">
                        </div>
                        <div class="form-group">
                            <label for="approx_time" class="control-label">Thời gian dự kiến hoàn thành: (giờ)</label>
                            <input type="text" class="form-control" id="course-approx-time-{{$course->id}}" name="approx-time-{{$course->id}}" value="{{$course->approx_time}}">
                        </div>
                        <div class="form-group">
                            <label for="category" class="control-label">Danh mục:</label>
                            {{-- <script type="text/javascript">
                                $('#course-category').multiselect();
                            </script> --}}
                            <select class="form-control" id="course-category{{$course->id}}" name="category-{{$course->id}}">
                                @foreach($categories as $category)
                                <optgroup label="{{$category->name}}">
                                    @foreach($category->children as $child)
                                    @if($child->id == $course->category_id)
                                    <option value="{{$child->id}}" selected>{{$child->name}}</option>
                                    @else
                                    <option value="{{$child->id}}">{{$child->name}}</option>
                                    @endif
                                    @endforeach
                                </optgroup>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="will-learn" class="control-label">Học viên sẽ học được:</label>
                            <div class="form-group will-learn-class">
                                <textarea id="course-will-learn-{{$course->id}}" class="form-control" rows="6" cols="50" name="will-learn{{ $course->id }}">{!! $course->will_learn !!}</textarea>
                            </div>
                            <script>
                                CKEDITOR.replace( 'will-learn{{ $course->id }}', {
                                        toolbar : [
                                            { name: 'basicstyles', items: [ 'Bold', 'Italic', 'NumberedList', 'BulletedList'] },
                                        ],
                                        // removeButtons : 'Anchor,About,Link,Unlink,Outdent,Indent,Strike,Underline,Undo,Redo,Cut,Copy,Paste,Subscript,Superscript'
                                        height: '215px',
                                    },
                                );
                            </script>
                        </div>
                        <div class="form-group">
                            <label for="link_video" class="control-label">Video giới thiệu:</label>
                            <input type="text" class="form-control" id="course-intro-{{$course->id}}" name="course-intro-{{$course->id}}" value="{{$course->link_intro}}" placeholder="Link Youtube">
                        </div>
                    </div>
                    <input id="resetForms{{$course->id}}" type="reset" value="Reset the form" style="display:none">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default clear-modal" data-dismiss="modal">Hủy</button>
                <button type="button" class="btn btn-primary" id="save-btn-{{$course->id}}">Cập nhật</button>
            </div>
            <script>
                $('.clear-modal').click(function() {
                    $('#resetForms{{$course->id}}').click()

                    var t_des = '{!! $course->description !!}'
                    var t_wl = '{!! $course->will_learn !!}'
                    CKEDITOR.instances['course-description-{{$course->id}}'].setData(t_des)
                    CKEDITOR.instances['course-will-learn-{{$course->id}}'].setData(t_wl)
                });
            </script>
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
    $(document).ready(function(){
        var old_pos = 0;
        var j = jQuery.noConflict();
        j( "#listUnit{{ $course->id }} #sortable" ).sortable({
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

        j( "#listUnit{{ $course->id }} #sortable" ).disableSelection();

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
                        j("#listUnit{{ $course->id }} #sortable").sortable('refresh');
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
            $('#editCourse-{{ $course->id }}').modal('toggle')
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
    });
</script>

{{-- <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
<script src="{{ url('/') }}/frontend/js/jquery.cropit.js"></script> --}}

<script>
    $( document ).ready(function() {
        var j2 = jQuery.noConflict();

        j2('#image-cropper-{{$course->id}}').cropit();
        
        $('#btn-cropit-upload-{{$course->id}}').click(function() {
            $('#image-file-input-{{$course->id}}').click();
        });
        
        var _URL = window.URL || window.webkitURL;
        $("#image-file-input-{{$course->id}}").change(function(e) {
            var file, img;
            if ((file = this.files[0])) {
                img = new Image();
                img.onerror = function() {
                    Swal.fire({
                        type: 'warning',
                        text: 'Tập tin không hợp lệ!',
                        allowOutsideClick: false,
                    })
                    $("#image-file-input-{{$course->id}}").val('')
                };
                img.onload = function() {
                    if(this.width < 640 || this.height < 360){
                        Swal.fire({
                            type: 'warning',
                            text: 'Yêu cầu kích thước ảnh >= 640x360!',
                            allowOutsideClick: false,
                        })
                        $("#image-file-input-{{$course->id}}").val('')
                    }else{
                        $('#cropit-zoom-input-{{$course->id}}').css('display','block').css('padding-top', '15px');
                    }
                };
                img.src = _URL.createObjectURL(file);
            }
        })

        var link_base64;
        
        j2('#save-btn-{{ $course->id }}').click(function(){
            link_base64 = j2('#image-cropper-{{$course->id}}').cropit('export');

            var course_name = $('#course-name-{{$course->id}}').val()
            var short_description = $('#short-description-{{$course->id}}').val()
            var course_description = CKEDITOR.instances['course-description-{{$course->id}}'].getData()

            var course_will_learn = CKEDITOR.instances['course-will-learn-{{$course->id}}'].getData()

            var course_requirement = $('#course-requirement-{{$course->id}}').val()
            var course_price = $('#course-price-{{ $course->id }}').val()
            var course_approx_time = $('#course-approx-time-{{$course->id}}').val()

            var selector = document.getElementById('course-category{{$course->id}}')
            var course_category = selector[selector.selectedIndex].value

            var link_intro = $('#course-intro-{{$course->id}}').val()

            // $('#editCourse-{{$course->id}}').modal('toggle')

            var url = link_intro;
            if (url != undefined || url != '') {       
                var regExp = /^.*(youtu.be\/|v\/|u\/\w\/|embed\/|watch\?v=|\&v=|\?v=)([^#\&\?]*).*/;
                var match = url.match(regExp);
                if (match && match[2].length == 11) {
                }else{
                    Swal.fire({
                        type: 'warning',
                        html: 'Link Video không hợp lệ!',
                        allowOutsideClick: false,
                    })
                    return false;
                }
            }

            var data = {
                image:link_base64,
                name: course_name,
                short_description: short_description,
                description: course_description,
                will_learn: course_will_learn,
                requirement: course_requirement,
                price: course_price,
                approx_time: course_approx_time,
                category: course_category,
                link_intro: link_intro,
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
                            allowOutsideClick: false,
                        }).then((result) => {
                            if (result.value) {
                                location.reload();
                            }
                        });
                    }else{
                        Swal.fire({
                            type: 'warning',
                            html: 'Error',
                            allowOutsideClick: false,
                        })
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

            return;
        })
    });
</script>