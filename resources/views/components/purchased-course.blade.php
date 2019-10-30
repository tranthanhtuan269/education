<?php
    if($vote_count == 0) $vote_count = 1;

    $user_role_course_instance = App\Helper\Helper::getUserRoleOfCourse($courseId);
    $user_role_course_instance_video = json_decode($user_role_course_instance->videos);
    $learningId = $user_role_course_instance_video->learning_id;
    $video_done_units = $user_role_course_instance_video->videos;
    $video_count = \App\Course::find($courseId)->all_videos();
    $video_done_count = 0;
    $list_units = $user_role_course_instance_video->videos;

    $check = false;
    foreach($list_units as $units){
        if ( gettype($units) == 'array' ){
            $check = true;
            foreach($units as $unit){
                if($unit == 1){
                    $video_done_count++;
                }
            }
        }
    }
    // dd($video_done_count);
    
    // if(!is_array($video_done_units[0])){
    //     $video_done_units = array($video_done_units);
    // }
    // foreach ($video_done_units as $key => $unit) {
    //     // if(isset(array_count_values($unit)[1])){
    //     //     $video_done_count += array_count_values($unit)[1];
    //     // }

    // }
    if($video_count == 0){
      $video_done_percent = 100;  
    }else{
      $video_done_percent = (int)(($video_done_count/ (int) $video_count)*100);
    }
?>
@if ( $check == true )
<div class="col-md-3 col-sm-6">
    <div class="box-course">
        <div class="purchase_course">
            <div class="img-course">
                @if (strpos($rawImage, 'unica') !== false)
                    <img class="img-responsive img-full-width"
                        src="{{ $rawImage }}"
                        alt="{{ $title }}">
                @else
                    <img class="img-responsive img-full-width"
                        src="{{ $image }}"
                        alt="{{ $title }}">
                @endif
                @if (isset($heart))
                <i class="fa fa-heart fa-lg heart-icon" aria-hidden="true"></i>
                @endif

                @if (isset($setup))
                <i class="fa fa-cog fa-lg setting-icon" aria-hidden="true"></i>
                @endif
             </div>

            <div class="content-course">
                <a href="{{ url('/') }}/course/{{ $course->id }}/{{ $course->slug }}">
                    <h3 class="title-course">{{ \Helper::smartStr($course->name) }}</h3>
                </a>
                <div class="clearfix">
                    <span class="name-teacher pull-left">
                        {{ $author }}
                    </span>
                    <br>
                </div>
                <div class="progress">
                    <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="{{$video_done_percent}}" aria-valuemin="0" aria-valuemax="100" style="width: {{$video_done_percent}}%;">
                            {{$video_done_percent}}%
                    </div>
                </div>
                @if (isset($btn_start_learning))
                <div class="text-center">
                    <div data-courseid="{{$courseId}}" data-courseslug="{{$course->slug}}" data-learningid="{{$learningId}}" class="btn btn-primary btn-sm btn-start-learning">Tiếp tục học</div>
                    <script>
                        $(document).ready(function () {
                            $('.btn.btn-primary.btn-sm.btn-start-learning').click(function (e) {
                              e.stopPropagation()
                              e.preventDefault()

                              const course_id = $(this).attr('data-courseid')
                              const course_slug = $(this).attr('data-courseslug')
                              const learning_id = $(this).attr('data-learningid')
                              
                              $.ajaxSetup({
                                  headers: {
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
                                      window.location.href = ("/learning-page/"+ course_id +"/"+ course_slug)
                                  },
                                  error: function () {
  
                                  }
                              });
                            })
                        })
                    </script>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endif