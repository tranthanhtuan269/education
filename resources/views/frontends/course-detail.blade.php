@extends('frontends.layouts.app')
@section('content')
<div class="detail-course">
    <img class="background" src="{{ asset('frontend/images/banner_profile_teacher.png') }}" width="100%" >
    <div class="container">
        <div class="row">
            <div class="item clearfix">
                <div class="col-sm-12">
                    <div class="frame clearfix">
                        <div class="pull-left">
                            <div class="info">
                                <p class="name">{{ $info_course->name }}</p>
                                <p class="expret">{{ $info_course->short_description }}</p>
                            </div>
                        </div>
                        <div class="network pull-right">
                            <a class="btn btn-default btn-xs" href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode(url()->current()); ?>" target="_blank">
                                <i class="fas fa-share-alt"></i> Share
                            </a>
                            {{-- <button type="button" class="btn btn-default btn-xs">
                                <img src="http://edu.local/frontend/images/ic_facebook.png" alt="">
                                <span>Facebook</span>
                            </button> --}}
                        </div>
                    </div>
                    <div class="frame_2">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="row box clearfix">
                                    <?php
                                        $check_time_sale = false;
                                        if ($info_course->from_sale != '' && $info_course->to_sale != '') {
                                            $start_sale = strtotime($info_course->from_sale.' 00:00:00');
                                            $end_sale = strtotime($info_course->to_sale.' 23:59:59');
                                            $date_to = new DateTime($info_course->to_sale);
                                            $date_from = new DateTime(date('Y-m-d'));
                                            if (time() >= $start_sale && time() <= $end_sale) {
                                                $check_time_sale = true;
                                            }
                                        }
                                    ?>
                                    @if ($check_time_sale == true)                                        
                                    <div class="col-sm-6 pull-left">
                                        <span class="sale">{!! number_format($info_course->price, 0, ',' , '.') !!}đ</span>
                                        <span class="price">{!! number_format($info_course->real_price, 0, ',' , '.') !!}đ</span>
                                        <span class="interval">{{ $date_to->diff($date_from)->format("%d") }} days left off the price!</span>
                                    </div>
                                    <div class="col-sm-6">
                                        <span class="price-off pull-right">{{ round(100 - ($info_course->price/$info_course->real_price)*100,2) }}%  off</span>
                                    </div>
                                    @else
                                    <div class="col-sm-6 pull-left">
                                        <span class="sale">{!! number_format($info_course->real_price, 0, ',' , '.') !!}đ</span>
                                    </div>
                                    @endif
                                </div>
                                <div class="row box clearfix">
                                    <div class="col-sm-6 pull-left">
                                        <img src="{{ asset('frontend/images/ic_duration.png') }}" class="icon" alt="" />  <span class="special">{{ $info_course->approx_time }} hours on-demand video</span>
                                    </div>
                                    <div class="col-sm-6 pull-right">
                                        <img src="{{ asset('frontend/images/ic_download.png') }}" class="icon" alt="" />  <span class="special">{{ $info_course->downloadable_count	 }} downloadable resources</span>
                                    </div>
                                </div>
                                <div class="row box clearfix">
                                    <div class="col-sm-6 pull-left">
                                        <img src="{{ asset('frontend/images/ic_lifetime.png') }}" class="icon" alt="" />  <span class="special">Full lifetime access</span>
                                    </div>
                                    <div class="col-sm-6 pull-right">
                                        <img src="{{ asset('frontend/images/ic_mtuli_device.png') }}" class="icon" alt="" />  <span class="special">Access on Mobile & TV</span>
                                    </div>
                                </div>
                                <div class="row box clearfix">
                                    <div class="col-sm-6 pull-left">
                                        <img src="{{ asset('frontend/images/ic_course.png') }}" class="icon" alt="" /> 
                                        <span class="special">{{ number_format($info_course->video_count, 0, ',' , '.') }} videos</span>
                                        &nbsp &nbsp<img src="{{ asset('frontend/images/icon_student.png') }}" class="icon" alt="" /> 
                                        <span class="special">{{ number_format($info_course->student_count, 0, ',' , '.') }} Students</span>                                        
                                    </div>
                                    <div class="col-sm-6 pull-right">
                                        @include(
                                            'components.vote', 
                                            [
                                                'rate' => intval($info_course->star_count) / intval($info_course->vote_count),
                                                'rating_number' => $info_course->vote_count,
                                                'rating_txt' => true
                                            ]
                                        )
                                    </div>
                                </div>
                                <div class="box clearfix">
                                    <div class="pull-left">
                                        <button type="button" class="btn btn-default btn-toh">Add to cart</button>
                                    </div>
                                    <div class="pull-right">
                                        <button type="button" class="btn btn-default btn-toh">By Now</button>
                                    </div>
                                </div>
                                <div class="box clearfix">
                                    <div class="pull-left">
                                        30-Days Money-back Guarantee
                                    </div>
                                    <div class="pull-right">
                                        <a href="#">Have a coupon?</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <iframe src="https://www.youtube.com/embed/tgbNymZ7vqY?controls=0"  frameborder="0" allowfullscreen></iframe>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="menu clearfix">
                <div class="col-sm-12">
                    <ul>
                        <li class="active"> About </li>
                        <li><a href="javascript:;" class="go-box" data-box="box_requirements">Requirements</a></li>
                        <li><a href="javascript:;" class="go-box" data-box="box_reviews">Reviews</a> </li>
                        <li><a href="javascript:;" class="go-box" data-box="box_instructors">Instructors</a></li>
                        <li><a href="javascript:;" class="go-box" data-box="box_related_course">Related Courses </a></li>
                    </ul>
                </div>
            </div>
            <div class="info clearfix">
                <div class="col-sm-8">
                    <div class="desc">
                        <h3>Descriptions</h3>
                        <p>
                            {!! $info_course->description !!}
                        </p>
                    </div>
                    <?php $will_learn = json_decode($info_course->will_learn); ?>
                    @if ($will_learn != '')
                    <div class="knowledge clearfix">
                        <h3>What you'll learn</h3>
                        <ul>
                                @foreach ($will_learn as $will)                            
                                <li>
                                    <img src="{{ asset('frontend/images/ic_check.png') }}" alt="" /> {!! $will !!}
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if (count($info_course->tags) > 0)
                    <div class="skill">
                        <h3>Skills you'll again</h3>
                        <ul>
                            @foreach ($info_course->tags as $tag)
                            <li>{{ $tag->name }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                </div>
                <div class="col-sm-4">
                    <ul class="others">
                        <li>
                            <img src="{{ asset('frontend/images/features_online.png') }}" alt="" /> 
                            <span class="txt-large">100 Online</span>
                            <span class="txt-small">Content comming soon...</span>
                        </li>
                        <li>
                            <img src="{{ asset('frontend/images/features_deadline.png') }}" alt="" /> 
                            <span class="txt-large">Flexible deadlines</span>
                            <span class="txt-small">Content comming soon...</span>
                        </li>
                        <li>
                            <img src="{{ asset('frontend/images/features_level.png') }}" alt="" /> 
                            <span class="txt-large">Benginner Level</span>
                            <span class="txt-small">Content comming soon...</span>
                        </li>
                        @if ($info_course->approx_time != '')
                        <li>
                            <img src="{{ asset('frontend/images/features_hour.png') }}" alt="" /> 
                            <span class="txt-large">Approx {{ $info_course->approx_time }} hours to complete</span>
                            <span class="txt-small">Content comming soon...</span>
                        </li>
                        @endif
                        <li>
                            <img src="{{ asset('frontend/images/features_subtitle.png') }}" alt="" /> 
                            <span class="txt-large">English</span>
                            <span class="txt-small">Content comming soon...</span>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="lessons clearfix">
                <div class="col-sm-8">
                        @include('components.course-lession-list')
                </div>
                <?php $requirements = json_decode($info_course->requirement); ?>
                @if ($requirements != '')                    
                <div class="col-sm-4">
                    <div class="requirement" id="box_requirements">
                        <h3>Requirement</h3>
                        <ul>
                            @foreach ($requirements as $requirement)
                            <li>{!! $requirement !!}</li>    
                            @endforeach
                        </ul>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
    @if (count($info_course->Lecturers()) >= 1)
    <div class="instructors">
        <div class="container">
            <div class="row" id="box_instructors">
                <div class="col-sm-12">
                    <h3>About the instructors</h3>
                </div>
                @foreach ($info_course->Lecturers() as $lecturer)
                <div class="col-sm-6">
                    <div class="row">
                        <div class="col-sm-3">
                            <a href="{{ route('detail-teacher') }}">
                                <img class="avatar" alt="{{ $lecturer->user->name }}" src="{{ asset('frontend/images/'.$lecturer->user->avatar) }}">
                            </a>
                        </div>
                        <div class="col-sm-9">
                            <div class="detail-info">
                                <p class="name"><a href="{{ route('detail-teacher') }}">{{ $lecturer->user->name }}</a></p>
                                <p class="expret">{{ $lecturer->teacher->expert }}</p>
                                <div class="frame clearfix">
                                    <div class="pull-left">
                                        <img src="{{ asset('frontend/images/ic_course.png') }}" alt="" /> 
                                        <span class="special">{{ $lecturer->teacher->course_count }} Courses</span>
                                    </div>
                                    <div class="pull-right">
                                        @include(
                                            'components.vote', 
                                            [
                                                'rate' => $lecturer->teacher->rating_score,
                                                'rating_number' => $lecturer->teacher->vote_count,
                                                'rating_txt' => true,
                                            ]
                                        )
                                    </div>
                                </div>
                                <div class="">
                                    <img src="{{ asset('frontend/images/icon_student.png') }}" alt="" /> 
                                    <span class="special">{{ $lecturer->teacher->student_count }} Students</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
                {{-- <div class="col-sm-6">
                    <div class="row">
                        <div class="col-sm-3">
                            <a href="{{ route('detail-teacher') }}">
                                <img class="avatar" src="https://www.w3schools.com/howto/img_avatar.png" alt="" />
                            </a>
                        </div>
                        <div class="col-sm-9">
                            <div class="detail-info">
                                <p class="name"><a href="{{ route('detail-teacher') }}">Bảo Minh</a></p>
                                <p class="expret">PHP, Jquery, Agular Js, Vue Js, NodeJs</p>
                                <div class="frame clearfix">
                                    <div class="pull-left">
                                        <img src="{{ asset('frontend/images/ic_course.png') }}" class="icon" alt="" /> 
                                        <span class="special">22 Courses</span>
                                    </div>
                                    <div class="pull-right">
                                        @include(
                                            'components.vote', 
                                            [
                                                'rate' => 2,
                                                'rating_number' => 100,
                                                'rating_txt' => true,
                                            ]
                                        )
                                    </div>
                                </div>
                                <div class="">
                                    <img src="{{ asset('frontend/images/icon_student.png') }}" class="icon" alt="" /> 
                                    <span class="special">11.112 Students</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> --}}
            </div>
        </div>
    </div>
    @endif
    <div class="container">
        <div class="course-learning-review">
            <div class="feedback clearfix">
                <div class="col-sm-4 student-rating">
                    <h3>Students Feedback</h3>
                    <p class="number">
                            {{ number_format(intval($info_course->star_count) / intval($info_course->vote_count), 1, ',' , '.') }}
                    </p>
                    <p class="star">
                        @include(
                            'components.vote', 
                            [
                                'rate' => intval($info_course->star_count) / intval($info_course->vote_count),
                            ]
                        )
                    </p>
                    <p>Course Rating</p>
                </div>
                <div class="col-sm-8 rating-process">
                    <div class="row">
                        @for ($i = 5; $i <10; $i++)
                        <?php
                            if ($i == 5) {
                                $count_star = $info_course->five_stars;
                            } elseif ($i == 6) {
                                $count_star = $info_course->four_stars;
                            } elseif ($i == 7) {
                                $count_star = $info_course->three_stars;
                            } elseif ($i == 8) {
                                $count_star = $info_course->two_stars;
                            } else{
                                $count_star = $info_course->one_stars;
                            }
                            
                            $percent_vote = number_format(($count_star / $info_course->vote_count)*100, 0, ',' , '.');
                        ?>
                        <div class="item-progress">
                            <div class="col-sm-9">
                                <div class="progress">
                                    <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="{{ $percent_vote }}"
                                        aria-valuemin="0" aria-valuemax="100" style="width:{{ $percent_vote }}%"></div>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                @include(
                                    'components.vote', 
                                    [
                                        'rate' => 10 - $i,
                                    ]
                                )
                                <span class="percent-rating">{{ $percent_vote }}%</span>
                            </div>
                        </div>
                        @endfor
                    </div>
                </div>
            </div>
            <div class="reviews">
                <h3>Reviews</h3>
                @include('components.question-answer')
            </div>
            <div class="col-sm-12 btn-seen-all">
                <button type="button" class="btn">Seen all student feedback</button>
            </div>
            
        </div>
    </div>
    <div class="related-course">
        <div class="container">
            @include('frontends.related-course')
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function() {  
        $('.go-box').click(function() {
            var box = $(this).attr('data-box');
            if($('#' + box).length) {
                var top_scroll = 0;
                top_scroll = $("#" + box).offset().top;
                $('html,body').animate({
                    scrollTop: top_scroll - 100
                }, 'slow');
            }
            // $('.box_header .menu-main.mobile').addClass('hidden-xs hidden-sm');
            // $('.go-box').removeClass('active');
            // $(this).addClass('active');
    
        });
    });
</script>
@endsection