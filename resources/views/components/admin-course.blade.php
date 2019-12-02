<?php
    $course->vote_count = $course->five_stars+$course->four_stars+$course->three_stars+$course->two_stars+$course->one_stars;
    $initial_vote_count = $course->vote_count;
    // if($course->vote_count == 0) {
    //     $course->vote_count = 1;
    // }
    $image = url('/frontend/images/'.$course->image);
    $lecturers = count($course->Lecturers()) > 1 ? 'Nhiều tác giả' : count($course->Lecturers()) > 0 ? $course->Lecturers()[0]->user->name : "Courdemy";
    $course_status = $course->status;
    $teacher_id = 0;
    $lecs = $course->Lecturers()->first();
    if($lecs){
        if($lecs->user){
            $teacher_id = $lecs->teacher->id;
        }
    }
    // dd(Auth::user());
?>
<div class="col-sm-3" id="course-{{ $course->id }}">
    <div class="box-course">
        <button class="btn btn-primary btn-unit-course" id="btn-unit-{{ $course->id }}" title="Thêm bài giảng"><i class="fas fa-bars fa-fw"></i></button>
        <button class="btn btn-primary btn-edit-course" id="btn-edit-{{ $course->id }}" title="Sửa khóa học"><i class="fas fa-edit fa-fw"></i></button>
        @if ( $course_status == 1 )
            <button class="btn btn-success btn-status-course active" title="Khóa học đang được bán"><i class="fas fa-dollar-sign fa-fw"></i></button>
        @else
            @if ( $course_status == 0 )
                <button class="btn btn-warning btn-status-course active" title="Khóa học đang được xét duyệt"><i class="fas fa-dollar-sign fa-fw"></i></button>
            @endif
            @if ( $course_status == -1 )
                <button class="btn btn-danger btn-status-course active" title="Khóa học đã bị ngừng bán"><i class="fas fa-dollar-sign fa-fw"></i></button>
            @endif
        @endif
        <button class="btn btn-warning view-edit-course" id="view-edit-{{ $course->id }}" data-id="{{ $course->id }}" title="Xem chỉnh sửa khóa học" style="display:none"><i class="far fa-eye fa-fw"></i></i></button>
        <div class="img-course">
            <a href="{{ url('/') }}/course/{{ $course->id }}/{{ $course->slug }}" title="{{ $course->name }}" class="teacher-course">
            <img class="img-responsive"
                src="{{ $image }}"
                alt="{{ $course->name }}">
            @if (isset($course->heart))
            <i class="fa fa-heart fa-lg heart-icon" aria-hidden="true"></i>
            @endif

            @if (isset($course->setup))  
            <i class="fa fa-cog fa-lg setting-icon" aria-hidden="true"></i>
            @endif
            </a>
        </div>
        {{-- <a href="{{ url('/') }}/course/{{ $course->id }}/{{ $course->slug }}" title="{{ $course->name }}" class="pop">            
            <div class="content-course">
                <h3 class="title-course">{{ \Helper::smartStr($course->name) }}</h3>
                <div class="clearfix" style="line-height:1.7">
                <span class="name-teacher pull-left" data-teacher-id="{{$teacher_id}}">
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
                        <i class="fa fa-eye" aria-hidden="true"></i> {!! number_format($course->view_count, 0, ',' , '.') !!}
                    </span>
                </div>
            </div>
        </a> --}}
        <a href="{{ url('/') }}/course/{{ $course->id }}/{{ $course->slug }}" title="{{ $course->name }}" class="teacher-course">
            <div class="content-course">
                <h3 class="title-course">{{ \Helper::smartStr($course->name) }}</h3>
                <div class="clearfix" style="line-height:1.7">
                    <span class="name-teacher pull-left" data-teacher-id="{{$teacher_id}}" title="{{ $lecturers }}">
                        {{ $lecturers }}
                        {{-- {{ $course->author }} --}}
                    </span>
                    <br>
                    <span class="pull-left" title="Đánh giá">
                        {{-- @php
                            echo($course->vote_count);
                        @endphp --}}
                        @if($course->vote_count == 0)
                            @include(
                                'components.vote', 
                                [
                                    'rate' => 0,
                                    'rating_number' => $course->vote_count,
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
                    <span class="time pull-right" title="Tổng thời lượng">
                        <i class="fas fa-stopwatch"></i> {{ intval($course->duration / 3600) }}h {{ intval(($course->duration % 3600) / 60) }}m
                    </span>
                </div>
                @if (isset($setup))  
                <div class="progress">
                    <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 60%;">
                        60%
                    </div>
                </div>
                @endif
                <div class="price-course pull-right">
                    @if ($course->real_price != 0)
                        @if ($course->price == $course->real_price)
                            <span class="sale" title="Giá bán">
                                <b>{!! number_format($course->real_price, 0, ',' , '.') !!}</b><sup>₫</sup>
                            </span> 
                        @else
                            <span class="price line-through" title="Giá gốc">
                                {!! number_format($course->real_price, 0, ',' , '.') !!}<sup>₫</sup>
                            </span>
                            {{-- @if ($course->real_price != $course->price) --}}
                            <span class="sale" title="Giá bán">
                                &nbsp;<b>{!! number_format((float)$course->price, 0, ',' , '.') !!}</b><sup>₫</sup>
                            </span>                        
                            {{-- @endif --}}
                            
                        @endif
                    @else
                        <span class="sale">
                            &nbsp;<b>{!! number_format((float)$course->price, 0, ',' , '.') !!}</b><sup>₫</sup>
                        </span> 
                    @endif
                </div>
                <div class="clearfix"></div>
                {{-- @if (isset($btn_start_learning))  
                <div class="text-center">
                    <a href="{{ url('coming-soon') }}" class="btn btn-primary btn-sm btn-start-learning">Vào học</a>
                </div>
                @endif --}}
            </div>
        </a>
    </div>
</div>

<div id="editCourse-{{ $course->id }}" class="box-course modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title" id="exampleModalLabel">Chỉnh sửa khóa học: <b>{{ $course->name }}</b></h3>
            </div>
            <div class="modal-body">
                <div class="notify-edit-course" style="display:none">Yêu cầu chỉnh sửa đang được xem xét. <button class="btn btn-info" id="viewRequestEdit{{ $course->id }}">Xem chi tiết</button></div>
                <div class="row">
                    <div class="image-cropit-editor">
                        <div class="box-course-preview" id="image-cropper-{{$course->id}}">
                            <div class="cropit-preview text-center preview-image-course" id="cropitPreview{{$course->id}}" data-name="{{$course->image}}">
                                <img class="" src="{{ asset('frontend/images/'.$course->image) }}" alt="Course Image">
                            </div>
                            <input type="range" class="cropit-image-zoom-input" id="cropit-zoom-input-{{$course->id}}" style="display: none"/>
                            <input type="file" class="cropit-image-input" style="display:none" value="" id="image-file-input-{{$course->id}}"/>
                            <div class="text-center form-html">
                                <div class="note">(Kích thước nhỏ nhất: 640x360)</div>
                                <div class="btn btn-primary select-image-btn" id="btn-cropit-upload-{{$course->id}}"><i class="fas fa-image fa-fw"></i> Tải lên ảnh khóa học</div>
                                <div class="form-html-validate image"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <form class="row form-edit-course" autocomplete="off">
                        <div class="col-md-8">
                            {{-- <div class="form-group">
                                <label for="name" class="control-label">Tên khóa học:</label>
                                <input type="text" class="form-control" id="course-name-{{ $course->id }}" name="name" value="{{ $course->name }}">
                            </div> --}}
                            {!! \App\Helper\Helper::insertInputForm('text', 'name', 'Tên khóa học:', $course->name, 'name', 'id="course-name-'.$course->id.'"') !!}
                            {{-- <div class="form-group">
                                <label for="short_description" class="control-label">Tóm tắt:</label>
                                <input type="text" class="form-control" id="short-description-{{ $course->id }}" name="short-description-{{ $course->id }}" value="{{ $course->short_description }}">
                            </div> --}}
                            {!! \App\Helper\Helper::insertInputForm('text', 'short-description-'.$course->id, 'Tóm tắt:', $course->short_description, 'short_description', 'id="short-description-'.$course->id.'"') !!}
                            <div class="form-group form-html">
                                <label for="description" class="control-label">Mô tả:</label>
                                <textarea id="course-description-{{$course->id}}" class="form-control" rows="6" cols="50" name="description-course-{{ $course->id }}">{!! $course->description !!}</textarea>
                                <script>
                                        CKEDITOR.replace( 'description-course-{{ $course->id }}', {
                                                height: '300px',
                                            },
                                        )
                                </script>
                                <div class="form-html-validate description"></div>
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
                                {{-- <div class="form-group">
                                    <label for="requirement" class="control-label">Yêu cầu:</label> 
                                    <input type="text" class="form-control" id="course-requirement-{{$course->id}}" name="requirement-{{$course->id}}" value="{{ $requirement_string }}">
                                </div> --}}
                                {!! \App\Helper\Helper::insertInputForm('text', 'requirement-'.$course->id, 'Yêu cầu:', $requirement_string, 'requirement', 'id="course-requirement-'.$course->id.'"') !!}
                            @else
                                {{-- <div class="form-group">
                                    <label for="requirement" class="control-label">Yêu cầu:</label> 
                                    <input type="text" class="form-control" id="course-requirement-{{$course->id}}" name="requirement-{{$course->id}}" value="{{$course->requirement}}">
                                </div> --}}
                                {!! \App\Helper\Helper::insertInputForm('text', 'requirement-'.$course->id, 'Yêu cầu:', $course->requirement, 'requirement', 'id="course-requirement-'.$course->id.'"') !!}
                            @endif
                            {{-- <div class="form-group">
                                <label for="link_video" class="control-label">Video giới thiệu:</label>
                                <input type="text" class="form-control" id="course-intro-{{$course->id}}" name="course-intro-{{$course->id}}" value="{{$course->link_intro}}" placeholder="Link Youtube">
                            </div> --}}
                            {!! \App\Helper\Helper::insertInputForm('text', 'course-intro-'.$course->id, 'Video giới thiệu:', $course->link_intro, 'link_intro', 'id="course-intro-'.$course->id.'"') !!}
                        </div>
                    <div class="col-md-4">
                        {{-- <div class="form-group">
                            <label for="price" class="control-label">Giá gốc khóa học: (₫)</label>
                            <input type="text" class="form-control" id="courseOriginalPrice{{$course->id}}" name="price-{{$course->id}}" value="{{$course->real_price}}" onpaste="return false">
                        </div> --}}
                        {!! \App\Helper\Helper::insertInputForm('text', 'price-'.$course->id, 'Giá gốc khóa học: (₫)', $course->real_price, 'original_price', 'id="courseOriginalPrice'.$course->id.'" onpaste="return false"') !!}
                        {{-- <div class="form-group">
                            <label for="price" class="control-label">Giá sau khi giảm: (₫)</label>
                            <input type="text" class="form-control" id="courseDiscountPrice{{$course->id}}" name="price-{{$course->id}}"
                            @if ( $course->real_price == $course->price )
                                value=""
                            @else
                                value="{{$course->price}}"
                            @endif
                            onpaste="return false">
                        </div> --}}
                        <?php $course_price = $course->real_price == $course->price ? '' : $course->price ; ?>
                        {!! \App\Helper\Helper::insertInputForm('text', 'price-'.$course->id, 'Giá sau khi giảm: (₫)', $course_price, 'discount_price', 'id="courseDiscountPrice'.$course->id.'" onpaste="return false"') !!}
                        {{-- <div class="form-group">
                            <label for="approx_time" class="control-label">Thời gian dự kiến hoàn thành: (giờ)</label>
                            <input type="number" class="form-control" id="course-approx-time-{{$course->id}}" name="approx-time-{{$course->id}}" value="{{$course->approx_time}}" min="0" onpaste="return false">
                        </div> --}}
                        {!! \App\Helper\Helper::insertInputForm('number', 'approx-time-'.$course->id, 'Thời gian dự kiến hoàn thành: (giờ)', $course->approx_time, 'approx_time', 'id="course-approx-time-'.$course->id.'" min="0" onpaste="return false"') !!}
                        <div class="form-group">
                            <label for="category" class="control-label">Danh mục:</label>
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
                        <div class="form-group form-html">
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
                                        height: '299px',
                                    },
                                );
                            </script>
                            <div class="form-html-validate will_learn"></div>
                        </div>
                    </div>
                    <input id="resetForms{{$course->id}}" type="reset" value="Reset the form" style="display:none">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal" id="clearModal{{$course->id}}">Hủy</button>
                <button type="button" class="btn btn-primary" id="save-btn-{{$course->id}}">Cập nhật</button>
            </div>
            {{-- <script>
                $('#clearModal{{$course->id}}').click(function() {
                    $('#resetForms{{$course->id}}').click()

                    var t_des = '{!! $course->description !!}'
                    var t_wl = '{!! $course->will_learn !!}'
                    CKEDITOR.instances['course-description-{{$course->id}}'].setData(t_des)
                    CKEDITOR.instances['course-will-learn-{{$course->id}}'].setData(t_wl)
                    $('#cropitPreview').css('display', 'none')
                    $('#cropit-zoom-input-{{$course->id}}').css('display', 'none')

                    $('input.cropit-image-input').val('');
                    $('.cropit-preview').removeClass('cropit-image-loaded');
                    // $('.cropit-preview-image').removeAttr('style');
                    $('.cropit-preview-image').attr('src','');
                });
            </script> --}}
        </div>
    </div>
</div>

<div id="listUnit{{ $course->id }}" class="box-unit modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="btn btn-primary pull-right" id="add-unit-btn"><i class="fas fa-plus fa-fw"></i>Thêm phần học</div>
                <h3 class="modal-title" id="exampleModalLabel">Danh sách phần học</h3>
            </div>
            <div class="modal-body">
                <div class="row">
                    <ul id="sortable" class="unit-holder-{{ $course->id }}">
                        <?php //dd($course->units); ?>
                        @foreach($course->units as $key => $unit)
                        <li class="ui-state-default form-html" data-unit-id="{{ $unit->id }}" data-unit-key="{{ $key }}">
                            <i class="fas fa-sort"></i> 
                            <span class="unit-content">{{ $unit->name }}</span> 
                            <i class="far fa-trash-alt remove-unit" id="remove-unit-{{ $unit->id }}" data-unit-id="{{ $unit->id }}" data-course-id="{{ $course->id }}"></i>
                            <i class="far fa-edit edit-unit" id="edit-unit-{{ $unit->id }}" data-unit-id="{{ $unit->id }}" data-course-id="{{ $course->id }}"></i>
                            <i class="fas fa-bars list-vid-unit" id="list-vid-unit-{{ $unit->id }}" data-unit-id="{{ $unit->id }}" data-course-id="{{ $course->id }}"></i>
                        </li>                        
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal" id="closeModal{{ $course->id }}">Đóng</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function(){
        checkRequestEdit({{ $course->id }})

        document.getElementById('courseOriginalPrice{{$course->id}}').onkeydown = function(e) {
            if(!((e.keyCode > 95 && e.keyCode < 106)
            || (e.keyCode > 47 && e.keyCode < 58) 
            || e.keyCode == 8)) {
                return false;
            }
        }
        document.getElementById('courseDiscountPrice{{$course->id}}').onkeydown = function(e) {
            if(!((e.keyCode > 95 && e.keyCode < 106)
            || (e.keyCode > 47 && e.keyCode < 58)
            || e.keyCode == 8)) {
                return false;
            }
        }
        document.getElementById('course-approx-time-{{$course->id}}').onkeydown = function(e) {
            if(!((e.keyCode > 95 && e.keyCode < 106)
            || (e.keyCode > 47 && e.keyCode < 58) 
            || (e.keyCode == 8)
            || e.keyCode == 190)) {
                return false;
            }
        }

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
                addEvent()
            }
        });

        j( "#listUnit{{ $course->id }} #sortable" ).disableSelection();

        $("#listUnit{{ $course->id }} #add-unit-btn").click(function(){
            

            var data = {
                name: "Item",
                course_id: {{ $course->id }}
            }

            $.ajax({
                method: "POST",
                url: "{{ url('user/units/store') }}",
                data: data,
                dataType: 'json',
                success: function (response) {
                    if(response.status == 200){
                        var html = '<li class="ui-state-default form-html" data-unit-id="'+response.unit.data.id+'" data-unit-key="'+(response.unit.data.index-1)+'"><i class="fas fa-sort"></i> <span class="unit-content">Item</span> <i class="far fa-trash-alt remove-unit" id="remove-unit-'+response.unit.data.id+'" data-unit-id="'+response.unit.data.id+'" data-course-id="{{ $course->id }}"></i><i class="far fa-edit edit-unit" id="edit-unit-'+response.unit.data.id+'" data-unit-id="'+response.unit.data.id+'" data-course-id="{{ $course->id }}"></i><i class="fas fa-bars list-vid-unit" id="list-vid-unit-'+response.unit.data.id+'" data-unit-id="'+response.unit.data.id+'" data-course-id="'+response.unit.data.id+'"></i></li>';
                        $("#listUnit{{ $course->id }} #sortable").append(html);
                        j("#listUnit{{ $course->id }} #sortable").sortable('refresh');
                        addEvent();
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
            })
        })

        addEvent()
        function addEvent(){
            $("#listUnit{{ $course->id }} .edit-unit").off('click')
            $("#listUnit{{ $course->id }} .remove-unit").off('click')
            $("#listUnit{{ $course->id }} .save-unit").off('click')
          
            $("#listUnit{{ $course->id }} .save-unit").click(function(){
                // var html = '<i class="fas fa-sort"></i> <span class="unit-content">'+content+'</span> <i class="far fa-trash-alt remove-unit" id="remove-unit" data-id="{{ $course->id }}"></i><i class="far fa-edit edit-unit" id="edit-unit" data-id="{{ $course->id }}"></i>'
                var parent = $(this).parent()
                var name = parent.find('input').val()
                
                // send data to server
                var unit_id = $(this).attr('data-unit-id')
                var content = $('#unit-input-'+unit_id).val()
                var course_id = $(this).attr('data-course-id')
                var data = {
                    name: name
                }

                $.ajax({
                    method: "PUT",
                    url: "{{ url('/') }}/user/units/"+unit_id+"/update",
                    data: data,
                    dataType: 'json',
                    beforeSend: function() {
                        $(".ajax_waiting").addClass("loading");
                    },
                    success: function (response) {
                        $(".ajax_waiting").removeClass("loading");
                        if(response.status == 200){
                            parent.find('input').remove()
                            parent.find('i.save-unit').remove()

                            var html = ""
                            html += '<i class="fas fa-sort"></i> '
                            html += '<span class="unit-content">'+content+'</span>'
                            html += '<i class="far fa-trash-alt remove-unit" id="remove-unit-'+ unit_id +'" data-unit-id="'+ unit_id +'" data-course-id="'+ course_id +'"></i>'
                            html += '<i class="far fa-edit edit-unit" id="edit-unit-'+ unit_id +'" data-unit-id="'+ unit_id +'" data-course-id="'+ course_id +'"></i>'
                            html += '<i class="fas fa-bars list-vid-unit" id="list-vid-unit-'+ unit_id +'" data-unit-id="'+ unit_id +'" data-course-id="'+ course_id +'"></i>'

                            parent.append(html)
                            addEvent()
                        }
                    },
                    error: function (error) {
                        // var obj_errors = error.responseJSON.errors;
                        // var txt_errors = '';
                        // for (k of Object.keys(obj_errors)) {
                        //     txt_errors += obj_errors[k][0] + '</br>';
                        // }
                        // Swal.fire({
                        //     type: 'warning',
                        //     html: 'txt_errors',
                        //     allowOutsideClick: false,
                        // })
                        $(".ajax_waiting").removeClass("loading");
                        var obj_errors = error.responseJSON.errors;
                        $('.form-html-validate').css('display', 'block')
                        $('.form-html-validate').html('')
                        $.each(obj_errors, function( index, value ) {
                            var content = '<i class="fas fa-exclamation fa-fw"></i><div class="hover-alert">'+ value +'</div>'
                            $('li[data-unit-id='+unit_id+'] .form-html-validate.' + index).html(content);
                        })
                        $('.form-html .form-html-validate i').on('click',function(e){ e.stopPropagation() })
                    }
                });
                // end send data to server
                addEvent()
            })

            $("#listUnit{{ $course->id }} .edit-unit").click(function(){
                var unit_id = $(this).attr('data-unit-id');
                var content = $(this).parent().find('span.unit-content').html()
                var html = "<input class='form-control' id='unit-input-"+unit_id+"' value='" + content +"'><i class='fas fa-check save-unit' id='btn-save-unit' data-unit-id='"+unit_id+"'></i><div class='form-html-validate name'></div>"
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
                                text: response.message,
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
                
            })

            $('#listUnit{{ $course->id }} .list-vid-unit').on('click', function () {
                var unit_id = $(this).attr('data-unit-id')
                $(".box-unit").modal('hide')
                $("#listVideo").attr("data-unit-id", unit_id)
                $("#listVideo").modal({
                    backdrop: 'static',
                    keyboard: false
                })
            })
        }

        $('#btn-edit-{{ $course->id }}').click(function(){
            $('#resetForms{{$course->id}}').click()

            if ( {{$course_status}} == -1 ){
                Swal.fire({
                    type: 'warning',
                    html: 'Không thể sửa khóa học đã ngừng bán.',
                })
                return
            }

            var t_des = '{!! $course->description !!}'
            var t_wl = '{!! $course->will_learn !!}'
            CKEDITOR.instances['course-description-{{$course->id}}'].setData(t_des)
            CKEDITOR.instances['course-will-learn-{{$course->id}}'].setData(t_wl)
            $('#cropitPreview').css('display', 'none')
            $('#cropit-zoom-input-{{$course->id}}').css('display', 'none')

            $('input.cropit-image-input').val('');
            $('.cropit-preview').removeClass('cropit-image-loaded');
            // $('.cropit-preview-image').removeAttr('style');1
            $('.cropit-preview-image').attr('src','');
            $('#editCourse-{{ $course->id }}').modal('toggle')

            $('.notify-edit-course').css('display','none')
            $('#cropitPreview{{$course->id}} img').attr('src','{{ asset("frontend/images/".$course->image) }}')
            // checkRequestEdit({{ $course->id }})
            $('.form-html-validate').css('display', 'none')
        })


        $('#view-edit-{{ $course->id }}').click(function(){
            // $('#btn-edit-{{ $course->id }}').click()
            if ( {{$course_status}} == -1 ){
                Swal.fire({
                    type: 'warning',
                    html: 'Không thể sửa khóa học đã ngừng bán.',
                })
                return
            }
            $('#editCourse-{{ $course->id }}').modal('toggle')
            $('#viewRequestEdit{{ $course->id }}').click()
        })

        $('#viewRequestEdit{{ $course->id }}').click(function(){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            })
            $.ajax({
                method: 'POST',
                url: "{{ url('/user/courses/view-request-edit')}}",
                data: {
                    'course_id': {{ $course->id }}
                },
                dataType: 'json',
                success: function (response) {
                    if(response.status == 200){
                        $('#cropitPreview{{$course->id}} img').attr('src','')
                        $('#cropitPreview{{$course->id}} img').attr('src','frontend/images/'+response.image)

                        $('#course-name-{{ $course->id }}').val(response.name)

                        $('#short-description-{{ $course->id }}').val(response.short_description)

                        CKEDITOR.instances['course-description-{{$course->id}}'].setData(response.description)

                        $('#course-requirement-{{$course->id}}').val(response.requirement)

                        $('#course-intro-{{$course->id}}').val(response.video)

                        $('#courseOriginalPrice{{$course->id}}').val(response.real_price)

                        $('#courseDiscountPrice{{$course->id}}').val(response.price)

                        $('#course-approx-time-{{$course->id}}').val(response.approx_time)

                        $('select[name=category-{{$course->id}}]').val(response.category_id)

                        CKEDITOR.instances['course-will-learn-{{$course->id}}'].setData(response.will_learn)

                        // document.getElementById("editCourse-{{$course->id}}").scrollTo(0, 500);
                        // $('#editCourse-{{$course->id}}').animate({scrollTop:450}, '300')
                    }
                },
            }) 
        })

        // $('#btnStop{{ $course->id }}').click(function(){
        //     var data = {
        //         id: {{ $course->id }},
        //         user_id: {{ Auth::user()->id }}
        //     };
        //     Swal.fire({
        //             type: 'warning',
        //             text: 'Bạn có chắc chắn muốn ngừng bán khóa học này không?',
        //             showCancelButton: true,
        //         })
        //     .then(function (result) {
        //         if(result.value){
        //             $.ajax({
        //                 method: "POST",
        //                 url: "{{ url('user/courses/stop-sell') }}",
        //                 data: data,
        //                 dataType: 'json',
        //                 beforeSend: function() {
        //                     $("#pre_ajax_loading").show();
        //                 },
        //                 complete: function() {
        //                     $("#pre_ajax_loading").hide();
        //                 },
        //                 success: function (response) {
        //                     if(response.status == 200){
        //                         Swal.fire({
        //                             type: 'success',
        //                             html: response.message,
        //                             allowOutsideClick: false,
        //                         }).then((result) => {
        //                             if (result.value) {
        //                                 location.reload();
        //                             }
        //                         });
        //                     }else{
        //                         Swal.fire({
        //                             type: 'warning',
        //                             html: 'Lỗi',
        //                             allowOutsideClick: false,
        //                         })
        //                     }
        //                 },
        //                 error: function (error) {
        //                     var obj_errors = error.responseJSON.errors;
        //                     var txt_errors = '';
        //                     for (k of Object.keys(obj_errors)) {
        //                         txt_errors += obj_errors[k][0] + '</br>';
        //                     }
        //                     Swal.fire({
        //                         type: 'warning',
        //                         html: txt_errors,
        //                         allowOutsideClick: false,
        //                     })
        //                 }
        //             })
        //         }
        //     })
        // })

        // $('#btnContinue{{ $course->id }}').click(function(){
        //     var data = {
        //         id: {{ $course->id }},
        //         user_id: {{ Auth::user()->id }}
        //     };
        //     Swal.fire({
        //         type: 'warning',
        //         text: 'Bạn có chắc chắn muốn tiếp tục bán khóa học này không?',
        //         showCancelButton: true,
        //     })
        //     .then(function (result) {
        //         if(result.value){
        //             $.ajax({
        //                 method: "POST",
        //                 url: "{{ url('user/courses/continue-sell') }}",
        //                 data: data,
        //                 dataType: 'json',
        //                 beforeSend: function() {
        //                     $("#pre_ajax_loading").show();
        //                 },
        //                 complete: function() {
        //                     $("#pre_ajax_loading").hide();
        //                 },
        //                 success: function (response) {
        //                     if(response.status == 200){
        //                         Swal.fire({
        //                             type: 'success',
        //                             html: response.message,
        //                             allowOutsideClick: false,
        //                         }).then((result) => {
        //                             if (result.value) {
        //                                 location.reload();
        //                             }
        //                         });
        //                     }else{
        //                         Swal.fire({
        //                             type: 'warning',
        //                             html: 'Lỗi',
        //                             allowOutsideClick: false,
        //                         })
        //                     }
        //                 },
        //                 error: function (error) {
        //                     var obj_errors = error.responseJSON.errors;
        //                     var txt_errors = '';
        //                     for (k of Object.keys(obj_errors)) {
        //                         txt_errors += obj_errors[k][0] + '</br>';
        //                     }
        //                     Swal.fire({
        //                         type: 'warning',
        //                         html: txt_errors,
        //                         allowOutsideClick: false,
        //                     })
        //                 }
        //             })
        //         }
        //     })
        // })

        $('#btn-unit-{{ $course->id }}').click(function(){
            // $('#listUnit{{ $course->id }}').modal('toggle')
            $('#listUnit{{ $course->id }}').modal({
                backdrop: 'static',
                keyboard: false
            })
            $(".box-unit").removeClass('active-modal')
            $('#listUnit{{ $course->id }}').addClass('active-modal')
        })

        $('#closeModal{{ $course->id }}').click(function(){
            location.reload()
        })
    });
</script>

{{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
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
            var original_price = $('#courseOriginalPrice{{ $course->id }}').val()
            var discount_price = $('#courseDiscountPrice{{ $course->id }}').val()
            var course_approx_time = $('#course-approx-time-{{$course->id}}').val()
            var selector = document.getElementById('course-category{{$course->id}}')
            var course_category = selector[selector.selectedIndex].value
            var link_intro = $('#course-intro-{{$course->id}}').val().trim()

            if ( link_base64 == '' ){
                link_base64 = $('#cropitPreview{{$course->id}}').attr("data-name")
                
            }

            var flag = true
            $('.form-html-validate').html('')
            if ( course_name == '' ){
                alertValidate('Bạn chưa nhập Tên khóa học.', 'name')
                flag = false
            }
            if ( short_description == '' ){
                alertValidate('Bạn chưa nhập Tóm tắt.', 'short_description')
                flag = false
            }
            if ( course_description == '' ){
                alertValidate('Bạn chưa nhập Mô tả.', 'description')
                flag = false
            }
            if ( course_will_learn == '' ){
                alertValidate('Bạn chưa nhập Học viên sẽ học được gì.', 'will_learn')
                flag = false
            }
            if ( course_requirement == '' ){
                alertValidate('Bạn chưa nhập Yêu cầu.', 'requirement')
                flag = false
            }
            if ( course_approx_time == '' ){
                alertValidate('Bạn chưa nhập Thời gian dự kiến hoàn thành.', 'approx_time')
                flag = false
            }
            if( original_price != '' ){
                original_price = Number(original_price)
                if( discount_price != '' ){
                    discount_price = Number(discount_price)
                    if( discount_price > original_price ){
                        alertValidate('Giá sau khi giảm không thể lớn hơn giá gốc.', 'discount_price')
                        flag = false
                    }
                }else{
                    discount_price = original_price
                }
            }else{
                alertValidate('Bạn chưa nhập Giá khóa học.', 'original_price')
                flag = false
            }

            var url = link_intro;
            if ( url != '' ){
                if (url != undefined ) {       
                    var regExp = /^.*(youtu.be\/|v\/|u\/\w\/|embed\/|watch\?v=|\&v=|\?v=)([^#\&\?]*).*/;
                    var match = url.match(regExp);
                    if (match && match[2].length == 11) {
                    }else{
                        alertValidate('Link Video không hợp lệ!', 'link_intro')
                        return false;
                    }
                }
            }else{
                alertValidate('Bạn chưa nhập Video giới thiệu.', 'link_intro')
                flag = false 
            }
            if ( flag == false ) return

            var data = {
                image:link_base64,
                name: course_name,
                short_description: short_description,
                description: course_description,
                will_learn: course_will_learn,
                requirement: course_requirement,
                original_price: original_price,
                discount_price: discount_price,
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
        })
    });

    $('.content-course .name-teacher').on('click', function (e){
        e.stopPropagation()
        e.preventDefault()
        var teacherId = $(this).attr('data-teacher-id')
        window.location.href = `/teacher/${teacherId}`
    })

    function checkRequestEdit(course_id){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        })
        $.ajax({
            method: 'POST',
            url: "{{ url('/user/courses/check-request-edit')}}",
            data: {
                'course_id': course_id
            },
            dataType: 'json',
            success: function (response) {
                if(response.status == 200){
                    if ( response.result == true ){
                        $('#view-edit-'+course_id).css('display','block')
                    }
                }
            },
        })  
    }
</script>