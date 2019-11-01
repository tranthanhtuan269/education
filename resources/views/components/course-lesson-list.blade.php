<?php
    // $course_duration = 0;
    // foreach ( $info_course->units as $value_unit ){
    //     foreach ($value_unit->timeLessonActive as $value_video){
    //         $course_duration += $value_video->duration;
    //     }
    // }
    // dd($course_duration);
    // dd($info_course->totalDuration($info_course));
    $course_duration = $info_course->totalDuration($info_course);
?>
<div class="u-list-course" id="u-list-course" data-course-id="{{$info_course->id}}">
    <div class="top clearfix">
        <h3 class="pull-left">Bài học</h3>
        <ul class="pull-right">
            {{-- <li>Expand all</li> --}}
            <li>{{ $info_course->all_videos() }} bài học</li>
            <li>{{ intval($course_duration / 3600) }} giờ {{ intval(($course_duration % 3600) / 60 ) }} phút</li>
        </ul>
    </div>
    <div class="content">
        <div class="panel-group" id="accordion">
            @foreach ($info_course->units->sortBy('index') as $key_unit => $value_unit)
            <div class="panel panel-default event-click">
                <!-- phần -->
                {{-- <a data-toggle="collapse" data-parent="#accordion" href="#collapse{{ $key_unit }}" class="accordion-toggle @if ($key_unit != 0) collapsed in @endif" aria-expanded="true"> --}}
                <div class="panel-heading" data-toggle="collapse" data-parent="#accordion" href="#collapse{{ $key_unit }}" class="accordion-toggle @if ($key_unit != 0) collapsed in @endif" aria-expanded="true" style="cursor: pointer;">
                    <div>
                        <div class="row">
                            <div class="col-md-12">
                                <h4 class="panel-title">

                                        <span>{{ $value_unit->name }}</span>
                                    <!-- <a data-toggle="collapse" data-parent="#accordion" href="#collapse{{ $key_unit }}" class="accordion-toggle @if ($key_unit != 0) collapsed in @endif" aria-expanded="true"><span>Section {{ $key_unit + 1 }}:&nbsp; {{ $value_unit->name }}</span></a> -->
                                </h4>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- </a> --}}

                <!-- bài -->
                <div id="collapse{{ $key_unit }}" class="panel-collapse collapse  @if ($key_unit == 0) in @endif" aria-expanded="true">
                    <div class="panel-body">
                        @foreach ($value_unit->videosLessonList->sortBy('index') as $key_video => $value_video)
                            @if ( $value_video->state == 1 || $value_video->state == 2 || $value_video->state == 4 )
                            <div class="col">
                                <div class="container-fluid">
                                    <div class="row">
                                        <div class="col-xs-8">
                                            <div class="title">
                                                @if(App\Helper\Helper::getUserRoleOfCourse($info_course->id))
                                                <a href="javascript:void(0)" class="click-link-video" data-course="{{$info_course->id}}" data-video="{{$value_video->id}}">
                                                    <i class="fa fa-play-circle" aria-hidden="true"></i>
                                                    <!-- <span>Lecture {{ $value_video->index }}: &nbsp;{{ $value_video->name }}</span>  -->
                                                    <span>{{ $value_video->name }}</span>
                                                </a>
                                                @else
                                                    <i class="fa fa-play-circle" aria-hidden="true"></i>
                                                    <!-- <span>Lecture {{ $value_video->index }}: &nbsp;{{ $value_video->name }}</span>  -->
                                                    <span>{{ $value_video->name }}</span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-xs-2 text-center">
                                            @if(App\Helper\Helper::getUserRoleOfCourse($info_course->id))
                                            <a class="btn-preview btn-success" id="view-from-course-detail{{$value_video->id}}" style="cursor:pointer" >Xem</a>
                                            <script>
                                                $(document).ready(function(){
                                                    $("#view-from-course-detail{{$value_video->id}}").off('click')
                                                    $("#view-from-course-detail{{$value_video->id}}").click(function(){
                                                        var learning_id = {{$value_video->id}}
                                                        var course_id = {{$info_course->id}}
                                                        var course_slug = "{{$info_course->slug}}"
                                                        $.ajaxSetup({
                                                            headers:{
                                                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                                            }
                                                        });
                                                        const request = $.ajax({
                                                            method: 'POST',
                                                            url: "/user-course/update-watched",
                                                            data: {
                                                                'video_id': learning_id
                                                            },
                                                            dataType: "json",
                                                            success: function () {
                                                                @if(Auth::user()->isAdmin() || $info_course->Lecturers()[0]->user->id == Auth::user()->id)
                                                                    window.location.href = ("/learning-page/"+ course_id +"/lecture/"+ learning_id)
                                                                @else
                                                                    window.location.href = ("/learning-page/"+ course_id +"/"+ course_slug)
                                                                @endif
                                                            },
                                                            error: function () {

                                                            }
                                                        });
                                                    })
                                                })
                                            </script>
                                            @else
                                                @if (Auth::check())
                                                    @if (Auth::user()->isAdmin())
                                                    {{-- khong hien gi ca --}}
                                                    @else
                                                    <i class="fas fa-lock fa-fw" aria-hidden="true"></i>
                                                    @endif
                                                @else
                                                <i class="fas fa-lock fa-fw" aria-hidden="true"></i>
                                                @endif
                                            @endif
                                            {{-- @if ($value_video->state == 1)
                                            <div class="link">
                                                &nbsp;
                                                <a class="btn-preview" href="javascript:void(0)" onclick="preview_freetrial(24337);">Free Trial</a>
                                            </div>
                                            @endif --}}
                                            {{-- @if (Auth::check())
                                                @if (Auth::user()->isAdmin())
                                                <a class="btn-preview btn-success" href="/learning-page/{{$info_course->id}}/lecture/{{$value_video->id}}">Xem</a>
                                                @endif
                                            @else
                                            @endif --}}
                                        </div>
                                        <div class="col-xs-2">
                                            <div class="time">{{ App\Helper::convertSecondToTimeFormat($value_video->duration) }}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif
                            @if ( $value_video->state == 0 || $value_video->state == 3 )
                                @if(App\Helper\Helper::getUserRoleOfCourse($info_course->id))
                                <div class="col">
                                    <div class="container-fluid">
                                        <div class="row">
                                            <div class="col-xs-8">
                                                <div class="title">
                                                    <i class="fa fa-play-circle" aria-hidden="true"></i>
                                                    <span>{{ $value_video->name }}</span>
                                                </div>
                                            </div>
                                            <div class="col-xs-2 text-center">
                                                <div>Đang xét duyệt</div>
                                            </div>
                                            <div class="col-xs-2">
                                                <div class="time">{{ App\Helper::convertSecondToTimeFormat($value_video->duration) }}</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endif
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    {{-- <div class="tags">
        <div class="pull-left">
            Tags</span>
            <ul class="pull-right">
                <li>PHP</li>
                <li>C#</li>
                <li>Java</li>
                <li>Jquey</li>
            </ul>
        </div>
    </div> --}}
    {{-- @if (count($info_course->tags) > 0) --}}
    {{-- <div class="tags">
        <div class="pull-left">
            <span>Tags</span>
            <ul class="pull-right">
                @foreach ($info_course->tags as $tag)
                <li>{{ $tag->name }}</li>
                @endforeach
            </ul>
        </div>
    </div> --}}
    {{-- @endif --}}
</div>
<script>
    $('.click-link-video').click(function(){
        var learning_id = $(this).attr('data-video')
        var course_id = $(this).attr('data-course')
        $.ajaxSetup({
            headers:{
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        const request = $.ajax({
            method: 'POST',
            url: "/user-course/update-watched",
            data: {
                'video_id': learning_id
            },
            dataType: "json",
            success: function () {
                window.location.href = ("/learning-page/"+ course_id +"/lecture/"+ learning_id)
            },
            error: function () {

            }
        });
    });

    // $('#accordion .event-click').click(function(){
    //     $("#sidebar-content").addClass('sidebar-unfix').css('top', 0);
    // })
</script>
