<?php
    if($vote_count == 0) $vote_count = 1;
    $user_role_course_instance = App\Helper\Helper::getUserRoleOfCourse($courseId);
    // dd($user_role_course_instance );
    $user_role_course_instance_video = json_decode($user_role_course_instance->videos);
    // dd($user_role_course_instance_video);
    $learningId = $user_role_course_instance_video->learning_id;
    $video_count = count($user_role_course_instance_video->videos);
    $video_done_array = $user_role_course_instance_video->videos;
    if(count(array_count_values($video_done_array)) < 2){
        $video_done_count = 0;
    }else{
        $video_done_count = array_count_values($video_done_array)[1];
    }
    $video_done_percent = (int)(($video_done_count/$video_count)*100);
?>
<div class="col-md-3 col-sm-6">
    <div class="box-course">
        <!-- <a href="{{ url('/') }}/course/{{ $slug }}" title="{{ $title }}" class="course-box-slider pop"> -->
        <div class="purchase_course">
            <div class="img-course">
            	<img class="img-responsive img-full-width"
                    src="{{ $image }}"
                    alt="{{ $title }}">
                @if (isset($heart))
                <i class="fa fa-heart fa-lg heart-icon" aria-hidden="true"></i>    
                @endif

                @if (isset($setup))  
                <i class="fa fa-cog fa-lg setting-icon" aria-hidden="true"></i>
                @endif        
             </div>
                    
            <div class="content-course">
                <h3 class="title-course">{{ $title }}</h3>
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
                    <a href="{{ "learning-page/".$courseId."/lecture/".$learningId }}" class="btn btn-primary btn-sm btn-start-learning">Continue learning</a>
                </div>
                @endif
            </div>
        </div>
        <!-- </a> -->
    </div>
</div>