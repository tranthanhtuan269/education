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
            {{-- <div class="img-mask">
                <div class="btn-add-to-cart">
                    <button class="btn btn-success" data-id="{{ $course->id }}" data-image="{{ $course->rawImage }}" data-lecturer="{{ $course->author }}" data-name="{{ $title }}" data-price="{{ $sale }}" data-real-price="{{ $price }}" data-slug="{{ $slug }}">
                        <span class="img">
                            <img src="{{asset("frontend/images/ic_add_to_card.png")}}" width="20px">
                        </span>
                        <span class="text">
                            Add to cart
                        </span>
                    </button>
                </div>
            </div>                --}}
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
                        <i class="fas fa-stopwatch"></i> {{ $course->approx_time }}h
                    </span>
                    <span class="view pull-right">
                        <i class="fa fa-eye" aria-hidden="true"></i> {!! number_format($course->view_number, 0, ',' , '.') !!} views
                    </span>
                </div>
                {{-- @if (isset($course->setup))  
                <div class="progress">
                    <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 60%;">
                        60%
                    </div>
                </div>
                @endif --}}

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
                {{-- <div class="price-course">
                    @if ($check_time_sale == true)                                        
                    <span class="price line-through">
                        {!! number_format($price, 0, ',' , '.') !!}đ
                    </span>
                    <span class="sale pull-right">
                        {!! number_format($sale, 0, ',' , '.') !!}đ
                    </span>
                    @else
                    <span class="price">
                        {!! number_format($price, 0, ',' , '.') !!}đ
                    </span>
                    @endif
                </div> --}}
                {{-- @if (isset($btn_start_learning))  
                <div class="text-center">
                    <a href="{{ url('coming-soon') }}" class="btn btn-primary btn-sm btn-start-learning">Start Learning</a>
                </div>
                @endif --}}
            </div>
        </a>
    </div>
</div>

<div id="editCourse{{ $course->id }}" class="box-course modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="exampleModalLabel">Edit {{ $course->name }} Course</h4>
            </div>
            <div class="modal-body">
                <form class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Choose Image</label>
                            <div class="dropzone dz-clickable" id="myDrop{{ $course->id }}">
                                <div class="dz-default dz-message" data-dz-message="">
                                    <span>Drop files here to upload</span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="price" class="control-label">Course price:</label>
                            <input type="text" class="form-control" id="course-price{{ $course->id }}" name="price" value="{{ $course->price }}">
                        </div>
                        <div class="form-group">
                            <label for="level" class="control-label">Level:</label>
                            <input type="text" class="form-control" id="course-level{{ $course->id }}" name="level" value="{{ $course->level }}">
                        </div>
                        <div class="form-group">
                            <label for="approx_time" class="control-label">Approx Time: (hours)</label>
                            <input type="text" class="form-control" id="course-approx-time{{ $course->id }}" name="approx-time" value="{{ $course->approx_time }}">
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="form-group">
                            <label for="name" class="control-label">Course Name:</label>
                            <input type="text" class="form-control" id="course-name{{ $course->id }}" name="name" value="{{ $course->name }}">
                        </div>
                        <div class="form-group">
                            <label for="short_description" class="control-label">Short Description:</label>
                            <input type="text" class="form-control" id="short-description{{ $course->id }}" name="short-description" value="{{ $course->short_description }}">
                        </div>
                        <div class="form-group">
                            <label for="description" class="control-label">Description:</label>
                            <textarea id="course-description{{ $course->id }}" name="description" class="form-control" rows="5" style="margin: 0px -11.3438px 0px 0px; width: 558px; height: 150px;">{{ $course->description }}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="will-learn" class="control-label">Will Learn:</label>
                            <input type="text" class="form-control" id="course-will-learn{{ $course->id }}" name="will-learn" value="{{ $course->will_learn }}">
                        </div>
                        <div class="form-group">
                            <label for="requirement" class="control-label">Requirement:</label>
                            <input type="text" class="form-control" id="course-requirement{{ $course->id }}" name="requirement" value="{{ $course->requirement }}">
                        </div>
                        <div class="form-group">
                            <label for="category" class="control-label">Category:</label>
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
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="save-btn{{ $course->id }}">Update</button>
            </div>
        </div>
    </div>
</div>

<div id="listUnit{{ $course->id }}" class="box-unit modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="btn btn-primary pull-right" id="add-unit-btn"><i class="fas fa-plus"></i> Add Unit</div>
                <h4 class="modal-title" id="exampleModalLabel">List Unit</h4>
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
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

@foreach($course->units as $key => $unit)
    @foreach ($unit->videos->sortBy('index') as $key => $video)
    <div id="editVideoModal{{$video->id}}" class="modal fade edit-video-modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    Edit Lecture: {{$video->name}}
                </div>
                <div class="modal-body">
                    <div class="form-group row">
                        <label class="col-sm-3" for="name">Name:</label>
                        <input class="col-sm-9 form-control edit-video-name" data-video-id="{{ $video->id }}" type="text" class="form-control" placeholder="{{$video->name}}">
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3" for="name">Description:</label>
                        <textarea class="col-sm-9 form-control edit-video-description" data-video-id="{{ $video->id }}" rows="5" class="form-control" class="form-control">{{$video->description}}</textarea>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3" for="name">Lecture video:</label>
                        <input class="col-sm-9 form-control edit-video-file" type="file" data-video-id="{{ $video->id }}" name="lectureVideo" class="col-md-9">
                    </div>                                         
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary save-edit-video" data-video-id="{{ $video->id }}"">Save</button>
                </div>
            </div>
        </div>
        
    </div>
    @endforeach
@endforeach

<div id="listVideo" class="modal fade list-video">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <div class="btn btn-primary pull-right btn-add-video" id="addVideoBtn" ><i class="fas fa-plus"></i> Add lecture</div>
                <h4 class="modal-title">Lecture list</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <ul id="videoSortable" class="video-holder" data-unit-id="0">
                        
                    </ul>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>

    <script>
        $(document).ready( function () {
            
            // $('#listVideo #videoSortable').sortable({
            //     placeholder: "ui-state-highlight",
            //     update: function (event, ui) {
            //         var sorted_list = []
            //         var unit_id = $('#listVideo #videoSortable').attr('data-unit-id')
            //         $.each($("#listVideo li"), function (index, value) {
                        
            //                 sorted_list.push({
            //                     id: $(value).attr('data-video-id'),
            //                     v_index: $(value).attr('data-video-index'),
            //                 })
            //         })

            //         $.ajax({
            //             method: "PUT",
            //             url : "{{ url('/') }}/user/units/sort-video",
            //             data: {
            //                 sorted_list : JSON.stringify( sorted_list ),
            //                 unit_id : unit_id
            //             },
            //             success: function (response) {
            //                 if(response.status == '200'){

            //                 }
            //             },
            //             error: function (response) {
            //                 var obj_errors = error.responseJSON.errors;
            //                 var txt_errors = '';
            //                 for (k of Object.keys(obj_errors)) {
            //                     txt_errors += obj_errors[k][0] + '</br>';
            //                 }
            //                 Swal.fire({
            //                     type: 'error',
            //                     html: txt_errors,
            //                 })
            //             }
            //         })
            //     }
            // })
        })
    </script>
</div>

<script>
    Dropzone.autoDiscover = false;
    $(document).ready(function(){
        $( "#listUnit{{ $course->id }} #sortable" ).sortable({
            placeholder: "ui-state-highlight",
            update: function( event, ui ) {
                // check key begin vs after
                var data = [];
                $.each($( "#listUnit{{ $course->id }} li" ), function( index, value ) {
                    if(index != $(value).attr('data-unit-key'))
                    data.push({
                        id: $(value).attr('data-unit-id'),
                        index: index,
                    });
                    
                });
                // end check key 
                $.ajax({
                    method: "PUT",
                    url: "{{ url('/') }}/user/units/sort",
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
                            type: 'error',
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
                        var html = '<li class="ui-state-default"><i class="fas fa-sort"></i> <span class="unit-content">Item 1 </span> <i class="fas fa-trash remove-unit" id="remove-unit-'+response.unit.data.id+'" data-unit-id="'+response.unit.data.id+'" data-course-id="{{ $course->id }}"></i><i class="fas fa-edit edit-unit" id="edit-unit-'+response.unit.data.id+'" data-unit-id="'+response.unit.data.id+'" data-course-id="{{ $course->id }}"></i><i class="fas fa-bars list-vid-unit" id="list-vid-unit-'+response.unit.data.id+'" data-unit-id="'+response.unit.data.id+'" data-course-id="'+response.unit.data.id+'"></i></li>';
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
                        type: 'error',
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
            $('.save-edit-video').off('click')
            $('#videoSortable .remove-video').off('click')

            
            $('#videoSortable .remove-video').on('click', function () {
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
                            $("#videoSortable li[data-video-id="+video_id+"]").remove()
                        }
                    },
                    error: function () {

                    }
                })
            })

            $('#videoSortable .edit-video').on('click', function () {
                $('.list-video').modal('hide')
            })

            
            $('.save-edit-video').on('click', function () {
                var video_id = $(this).attr("data-video-id")
                var video_name = $('.edit-video-modal .edit-video-name[data-video-id='+video_id+']').val()
                var video_description = $('.edit-video-modal .edit-video-description[data-video-id='+video_id+']').val()
                // var video_file = ''
                var video_file = $('.edit-video-modal .edit-video-file[data-video-id='+video_id+']')[0].files[0]
                

                var videoFormData = new FormData()
                videoFormData.append('video_id', video_id)
                videoFormData.append('video_name', video_name)
                videoFormData.append('video_description', video_description)
                videoFormData.append('video_file', video_file)

                $.ajax({
                    method: 'POST',
                    url: "{{ url('user/units/video/edit') }}",
                    data: videoFormData,
                    processData: false,
                    contentType: false
                })
            })
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
                            type: 'error',
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
                };

                $.ajax({
                    method: "DELETE",
                    url: "{{ url('user/units/delete') }}",
                    data: data,
                    dataType: 'json',
                    success: function (response) {
                        if(response.status == 200){
                            sefl.parent().remove()
                            $("#listUnit{{ $course->id }} #sortable").sortable('refresh')
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
            })

            $('#listUnit{{ $course->id }} .list-vid-unit').off('click')
            $('#listUnit{{ $course->id }} .list-vid-unit').on('click', function () {
                var unit_id = $(this).attr('data-unit-id')
                $(".box-unit").modal('hide')
                $("#listVideo").attr("data-unit-id", unit_id)
                $("#listVideo").modal('show')
            })

            $('#listVideo').on('shown.bs.modal', function () {
                alert($(this).attr('data-unit-id'));
            })

            $('#listVideo').on('hide.bs.modal', function () {
                $('#listUnit{{ $course->id }} .list-vid-unit').on('click', function () {
                    var unit_id = $(this).attr('data-unit-id')
                    $(".box-unit").modal('hide')
                    $("#listVideo").attr("data-unit-id", unit_id)
                    $("#listVideo").modal('show')
                })
            })


            $('.list-video #addVideoBtn').on('click', function () {
                var unit_id = $(this).attr("data-unit-id")

                $.ajax({
                    method: 'POST',
                    url: "{{ url('user/units/video/store') }}",
                    data:{
                        name    : 'My Video',
                        unit_id : unit_id,
                    },
                    dataType: 'json',
                    success: function (response) {
                        if(response.status == '200'){
                            html = ''
                            html += '<li class="ui-state-default ui-sortable-handle"  data-video-id="'+response.video.data.id+'" data-video-index="'+response.video.data.index+'">'
                                html += '<i class="fas fa-sort"></i> '
                                html += '<span class="video-content">'+response.video.data.name+'</span>'
                                html += '<i class="fas fa-trash pull-right" id="remove-video-'+response.video.data.id+'" data-video-id="'+response.video.data.id+'" data-video-index="'+response.video.data.index+'"></i>'
                                html += '<i class="fas fa-edit pull-right" id="edit-video-'+response.video.data.id+'" data-video-id="'+response.video.data.id+'" data-video-index="'+response.video.data.index+'"></i>'
                            html += '</li>'

                            $('.list-video .video-holder-'+unit_id+'').append(html)
                        }
                    },
                    error: function (error) {
                        var obj_errors = error.responseJSON.errors;
                        var txt_errors = '';
                        for (k of Object.keys(obj_errors)) {
                            txt_errors += obj_errors[k][0] + '</br>';
                        }
                        Swal.fire({
                            type: 'error',
                            html: txt_errors,
                        })
                    }
                })
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
        })

        $('#btn-unit-{{ $course->id }}').click(function(){
            $('#listUnit{{ $course->id }}').modal('toggle')
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
                $('#editCourse{{ $course->id }} .dz-image-preview').show(500);
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
            $("#msg").html('<div class="alert alert-danger">There is some thing wrong, Please try again!</div>');
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
</script>