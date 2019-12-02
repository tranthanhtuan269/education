@extends('frontends.layouts.app')
@section('title')
{{ $info_course->name }}
@stop
{{-- Facebook Share --}}
@section('fb_og_title')
{{ $info_course->name }}
@stop
@if (strpos($info_course->image, 'http') !== false)
    @section('fb_og_image')
    {{ $info_course->image }}
    @stop
@else
    @section('fb_og_image')
    https://courdemy.vn/frontend/images/{{ $info_course->image }}
    @stop
@endif
@section('fb_og_description')
{{ $info_course->short_description }}
@stop
@section('fb_og_image_alt')
{{ $info_course->name }}
@stop
@section('fb_og_type')
website
@stop
@section('fb_og_url')
https://courdemy.vn/course/{{ $info_course->id }}/{{ $info_course->slug }}
@stop

@section('content')
<?php
    $percent_temp = 100;
    $info_course->vote_count = $info_course->five_stars+$info_course->four_stars+$info_course->three_stars+$info_course->two_stars+$info_course->one_stars;
    $initial_vote_count = $info_course->vote_count;
    if($info_course->vote_count == 0) {
        $info_course->vote_count = 1;
        $percent_temp = 0;
    }
    $list_bought = [];
    if(Auth::check() && strlen(Auth::user()->bought) > 0){
        $list_bought = \json_decode(Auth::user()->bought);
    }
    // dd($ratingCourse)
    // $course_duration = 0;
    // foreach ( $info_course->units as $value_unit ){
    //     foreach ($value_unit->timeLessonActive as $value_video){
    //         $course_duration += $value_video->duration;
    //     }
    // }
    $course_duration = $info_course->totalDuration($info_course);    
?>
<div class="detail-course">
    <img class="background bg-course-detail" src="{{ asset('frontend/images/banner_profile_teacher.png') }}">
    <div class="container">
        <div class="row">
            <div class="item clearfix">
                <div class="col-sm-12">
                    <div class="frame clearfix mb-25px" id="boxTitleCourse">
                        <div class="col-md-9 col-xs-12 title-reponsive">
                            <div class="info col-xs-12">
                                <h1 class="name">{{ $info_course->name }}</h1>
                                <p class="expert id="tomTat">{{ $info_course->short_description }}</p>
                            </div>
                        </div>
                        <div class="network network-reponsive col-md-3 col-xs-12">
                        {{-- @if( strlen($info_course->short_description) >= 200 )
                            style="padding-top: 43px"
                        @endif
                        @if( strlen($info_course->name) >= 65)
                            @if ( strlen($info_course->short_description) >= 200 )
                                style="padding-top: 93px"
                            @else
                                style="padding-top: 63px"
                            @endif
                        @endif --}}
                        
                        <div class="pull-right">
                            <a class="btn btn-facebook-share btn-xs" data-src="{{$info_course->image}}" href="https://www.facebook.com/sharer/sharer.php?u=
                            <?php
                            echo urlencode(url()->current());
                            ?>
                            " target="_blank"><b>
                                    <i class="fab fa-facebook-square fa-fw fa-lg"></i> Chia sẻ
                            </b></a>
                        </div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="top-box-course-detail">
                        <div class="teacher-of-course">
                        @foreach ($info_course->Lecturers() as $lecturer)
                            @if($lecturer->teacher && $lecturer->user)
                            <a href="{{ url('/') }}/teacher/{{ $lecturer->teacher->id }}" title="{{ $lecturer->user->name }}" >
                                @if(filter_var($lecturer->user->avatar, FILTER_VALIDATE_URL))
                                    <img class="avatar" alt="{{ $lecturer->user->name }}" src="{{ $lecturer->user->avatar }}">
                                @else
                                    <img class="avatar" alt="{{ $lecturer->user->name }}" src="{{ asset('frontend/'.$lecturer->user->avatar) }}">
                                @endif
                            </a>
                            <p class="name"><a href="{{ url('/') }}/teacher/{{ $lecturer->teacher->id }}" title="{{ $lecturer->user->name }}" ><b>{{ $lecturer->user->name }}</b></a></p>
                            @endif
                        @endforeach
                        </div>
                        <div class="vote-of-course">
                            <div class="col-xs-12 full-width-mobile pb-10px">
                                @if ($initial_vote_count == 0)
                                    @include(
                                        'components.vote', 
                                        [
                                            'rate' => intval($info_course->star_count) / intval($info_course->vote_count),
                                            'rating_number' => $initial_vote_count,
                                            'rating_txt' => true
                                        ]
                                    )    
                                @else
                                    @include(
                                        'components.vote', 
                                        [
                                            'rate' => intval($info_course->star_count) / intval($info_course->vote_count),
                                            'rating_number' => $info_course->vote_count,
                                            'rating_txt' => true
                                        ]
                                    )
                                    
                                @endif
                            </div>
                        </div>
                        <div class="student-of-course">
                            <i class="fas fa-user-graduate fa-fw fa-lg"></i>
                            <span class="special">{{ number_format($info_course->student_count, 0, ',' , '.') }} <span>Học viên</span></span>
                        </div>
                    </div>
                    <div class="clearfix"></div>
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
                                    @if ($check_time_sale == true || $info_course->price != $info_course->real_price)                                        
                                    <div class="col-sm-6 pull-left">
                                        <span class="sale">{!! number_format((float)$info_course->price, 0, ',' , '.') !!}đ</span>
                                        <span class="price">{!! number_format((float)$info_course->real_price, 0, ',' , '.') !!}đ</span>
                                        {{-- <span class="interval">Còn {{ $date_to->diff($date_from)->format("%d") }} ngày tại mức giá này </span> --}}
                                    </div>
                                    <div class="col-sm-6">
                                        @if( $info_course->price != 0 && $info_course->real_price != 0 )
                                        <span class="percent-price-off pull-right">Tiết kiệm {{ (int)(100 - ($info_course->price/$info_course->real_price)*100) }}%</span>
                                        @endif
                                    </div>
                                    @else
                                    <div class="col-sm-6 pull-left">
                                        <span class="sale">{!! number_format((float)$info_course->price, 0, ',' , '.') !!}đ</span>
                                    </div>
                                    @endif
                                </div>
                                <div class="row box clearfix">
                                    <div class="col-xs-6 full-width-mobile pb-10px">
                                        <span class="box-img"><img src="{{ asset('frontend/images/ic_duration.png') }}" class="icon" alt="" /></span>
                                        <span class="special">Tổng số giờ học: {{ intval($course_duration / 3600) }} giờ {{ intval(($course_duration % 3600) / 60 ) }} phút</span>
                                    </div>
                                    <div class="col-xs-6 full-width-mobile pb-10px">
                                        <span class="box-img"><img src="{{ asset('frontend/images/ic_download.png') }}" class="icon" alt="" /></span>
                                        <span class="special">{{ $document_count }} Tài liệu đính kèm</span>
                                    </div>
                                </div>
                                <div class="row box clearfix">
                                    <div class="col-xs-6 full-width-mobile pb-10px">
                                        <span class="box-img"><img src="{{ asset('frontend/images/ic_lifetime.png') }}" class="icon" alt="" /></span>
                                        <!-- <i class="fas fa-infinity fa-2x fa-fw"></i> -->
                                        <span class="special">Sở hữu trọn đời</span>
                                    </div>
                                    <div class="col-xs-6 full-width-mobile pb-10px">
                                        <span class="box-img"><img src="{{ asset('frontend/images/ic_mtuli_device.png') }}" class="icon" alt="" /></span>
                                        <span class="special">Học trên Smartphone và TV</span>
                                        
                                    </div>
                                </div>
                                <div class="row box clearfix">
                                    <div class="col-xs-6 full-width-mobile pb-10px">
                                        <span class="box-img"><img src="{{ asset('frontend/images/ic_course.png') }}" class="icon" alt="" /></span>
                                        <span class="special">{{ $info_course->all_videos() }} Videos</span>
                                    </div>
                                    <div class="col-xs-6 full-width-mobile pb-10px">
                                        <span class="box-img"><img src="{{ asset('frontend/images/features_deadline.png') }}" class="icon" alt="" style="width:30px" /></span>
                                        <span class="special">Thời gian học linh hoạt</span>
                                    </div>
                                </div>
                                @if (Auth::check())
                                    @if (!Auth::user()->isAdmin())
                                        @if(isset($info_course->userRoles[0]->user_id))
                                            @if( (int)($info_course->userRoles[0]->user_id) != (int)(Auth::user()->id) )
                                                @if (!in_array($info_course->id, $list_bought))
                                                <div class="box clearfix">
                                                    <div class="btn-add-cart">
                                                        <button type="button" id="add-cart" data-id="{{ $info_course->id }}" class="btn btn-primary btn-toh"><b>Thêm vào giỏ hàng</b></button>
                                                    </div>
                                                    <div class="btn-buy-now">
                                                        <button type="button" id="buy-now" data-id="{{ $info_course->id }}" class="btn btn-warning btn-toh"><b>Mua ngay</b></button>
                                                    </div>
                                                </div>
                                                <div class="box clearfix">
                                                    <div class="pull-left money-back">
                                                        {{-- (Hoàn tiền trong 30 ngày nếu không hài lòng) --}}
                                                    </div>
                                                </div>
                                                @endif
                                            @endif   
                                        @endif
                                    @endif
                                @else
                                    <div class="box clearfix">
                                        <div class="btn-add-cart">
                                            <button type="button" id="add-cart" data-id="{{ $info_course->id }}" class="btn btn-primary btn-toh"><b>Thêm vào giỏ hàng</b></button>
                                        </div>
                                        <div class="btn-buy-now">
                                            {{-- <button type="button" id="buy-now" data-id="{{ $info_course->id }}" class="btn btn-warning btn-toh"><b>Mua ngay</b></button> --}}
                                            <button class="btn btn-warning btn-toh course-detail-buy-now" data-toggle=modal data-target=#modalLoginCourseDetail data-dismiss=modal data-id="{{ $info_course->id }}"><b>Mua ngay</b></button>
                                        </div>
                                    </div>
                                    <div class="box clearfix">
                                        <div class="pull-left money-back">
                                            {{-- (Hoàn tiền trong 30 ngày nếu không hài lòng) --}}
                                        </div>
                                    </div>
                                @endif
                            </div>
                            <div class="col-sm-6">
                                @if( $info_course->link_intro == null )
                                    <iframe src="https://www.youtube.com/embed/JKi4M6ME64o"  frameborder="0" allowfullscreen></iframe>
                                @else
                                    <iframe src="{{$info_course->link_intro}}"  frameborder="0" allowfullscreen></iframe>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="menu clearfix">
                <div class="col-sm-12">
                    <ul>
                        <li class="active"> Mô tả </li>
                        <li><a href="javascript:;" class="go-box" data-box="box_content">Danh sách bài học</a></li>                        
                        {{-- <li><a href="javascript:;" class="go-box" data-box="box_requirements">Yêu cầu</a></li> --}}
                        @if (count($info_course->Lecturers()) >= 1) <li><a href="javascript:;" class="go-box" data-box="box_instructors">Thông tin giảng viên</a></li> @endif
                        <li><a href="javascript:;" class="go-box" data-box="box_reviews">Đánh giá</a> </li>
                        <li><a href="javascript:;" class="go-box" data-box="box_related_course">Khóa học liên quan </a></li>
                    </ul>
                </div>
            </div>
            <div class="info clearfix col-xs-12" id="benefit-course">
                <div class="row">
                    <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                        <div class="desc">
                            <h3>Mô tả khóa học</h3>
                            <p>
                                {!! $info_course->description !!}
                            </p>
                        </div>
                        
                        <div class="knowledge clearfix">
                            <h3>Bạn sẽ học được gì</h3>
                            <?php 
                                $info_course->will_learn = str_replace(";","", $info_course->will_learn);
                                $will_learn = $info_course->will_learn;
                                $will_learn = str_replace('<li>','<br>',$will_learn);
                                $will_learn = str_replace('<p>','<br>',$will_learn);
                                $will_learn = explode("<br>", $will_learn);
                                $counter_w = count($will_learn);
                                for( $i = 0 ; $i < $counter_w ; $i++){
                                    $will_learn[$i] = trim($will_learn[$i]);
                                    $will_learn[$i] = strip_tags($will_learn[$i]);
                                }
                                $will_learn = array_filter($will_learn);
                            ?>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div>
                                        <?php
                                            $counter_i = 0;
                                            for( $i = 0 ; $i < $counter_w ; $i++){
                                                if(isset($will_learn[$i])){        
                                                    $counter_i++;
                                                    if ( $counter_i % 2 == 1 ){
                                                        echo '<div class="row">';
                                                    }
                                                    echo '<div class="col-md-6"><img src="/frontend/images/ic_check.png" width:"100%"><div class="will-learn-s">' . $will_learn[$i] . '</div></div>';
                                                    if ( $counter_i % 2 == 0 ){
                                                        echo '</div>';
                                                    }
                                                }
                                            }
                                            if ( $counter_i % 2 == 1 ){
                                                echo '</div>';
                                            }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <style type="text/css">
                            .knowledge ul {
                                /* columns: 2; */
                                /* -webkit-columns: 2; */
                                /* -moz-columns: 2; */
                                /* height: 30px; */
                                /* list-style-image: url('/frontend/images/ic_check.png'); */
                            }
                            .knowledge .will-learn-s{
                                /* margin-left: 10px; */
                                display: inline-flex;
                                width: 88%;
                                min-height: 30px;
                                margin-bottom: 10px;
                            }
                        </style>
                        <div class="lessons clearfix" id="box_content">
                            <div class="">
                                    @include('components.course-lesson-list')
                            </div>
                            <?php 
                            // $requirements = json_decode($info_course->requirement); 
                            ?>
                            {{-- @if ($requirements != '')                    
                            <div class="col-sm-4">
                                <div class="requirement" id="box_requirements">
                                    <h3>Yêu cầu</h3>
                                    <ul>
                                        @foreach ($requirements as $requirement)
                                        <li>{!! $requirement !!}</li>    
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                            @endif --}}
                        </div>
                        @if (count($info_course->tags) > 0)
                        <div class="skill clearfix my-30px">
                                <div class="col-xs-12">
                                    <h3>Các mục liên quan</h3>
                                    <ul class="row row-centered">
                                        @foreach ($info_course->tags as $key => $tag)
                                        <?php
                                        if($key == 4){
                                            break;
                                        } 
                                        ?>
                                        <div class="col-md-3 col-sm-4 col-xs-6 full-width-480p col-centered">
                                        <a href="/tags/{{$tag->slug}}">
                                            <li class="css-course-tag">{{ $tag->name }}</li>
                                        </a>
                                        </div>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        @endif
                        @if (count($info_course->Lecturers()) >= 1)
                        <div class="instructors">
                            <div class="row" id="box_instructors">
                                <div class="col-sm-12">
                                    <h3>Thông tin giảng viên</h3>
                                </div>
                                @foreach ($info_course->Lecturers() as $lecturer)
                                @if($lecturer->teacher && $lecturer->user)
                                <div class="col-xs-12">
                                    <div class="row">
                                        <div class="col-sm-4 avatar-center">
                                            <a href="{{ url('/') }}/teacher/{{ $lecturer->teacher->id }}" title="{{ $lecturer->user->name }}" >
                                                @if(filter_var($lecturer->user->avatar, FILTER_VALIDATE_URL))
                                                    <img class="avatar" alt="{{ $lecturer->user->name }}" src="{{ $lecturer->user->avatar }}">
                                                @else
                                                    <img class="avatar" alt="{{ $lecturer->user->name }}" src="{{ asset('frontend/'.$lecturer->user->avatar) }}">
                                                @endif
                                            </a><br><br>
                                            <div class="detail-info">
                                                <p class="name"><a href="{{ url('/') }}/teacher/{{ $lecturer->teacher->id }}" title="{{ $lecturer->user->name }}" >{{ $lecturer->user->name }}</a></p>
                                                <p class="expret">{{ $lecturer->teacher->expert }}</p>
                                                <div class="frame clearfix">
                                                    <div class="">
                                                        <img src="{{ asset('frontend/images/ic_course.png') }}" alt="" /> 
                                                        <?php
                                                        $count_teacher_course = count($lecturer->teacher->userRole->userCoursesByTeacher()->where('status', 1))
                                                        ?>
                                                        <span class="special">{{ $count_teacher_course }} Khóa học</span>
                                                    </div>
                                                    <div class="">
                                                        <img src="{{ asset('frontend/images/ic_student.png') }}" alt="" /> 
                                                        <span class="special">{{ $lecturer->teacher->student_count }} Học viên</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-8">
                                            <div class="info-teacher-right">
                                                {{-- <p class="name"><a href="{{ url('/') }}/teacher/{{ $lecturer->teacher->id }}" title="{{ $lecturer->user->name }}" >{{ $lecturer->user->name }}</a></p>
                                                <div class="expert-teacher">{{$lecturer->teacher->expert}}</div> --}}
                                                <div class="cv-teacher">
                                                    {!! $lecturer->teacher->cv !!}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @else
                                <div>
                                    Thông tin giảng viên đang được cập nhật.
                                </div>
                                @endif
                                @endforeach
                            </div>
                        </div>
                        @endif
                        <div class="course-learning-review" id="box_reviews">
                            <div class="feedback clearfix">
                                <h3>Đánh giá học viên</h3>
                                <div class="col-sm-4 student-rating">
                                    <div class="number">
                                        {{ number_format(intval($info_course->star_count) / intval($info_course->vote_count), 1, '.' , '.') }}
                                    </div>
                                    <p class="star">
                                        @include(
                                            'components.vote', 
                                            [
                                                'rate' => intval($info_course->star_count) / intval($info_course->vote_count),
                                            ]
                                        )
                                    </p>
                                    <p class="course-vote-count">{{$initial_vote_count}} đánh giá</p>
                                </div>
                                <div class="col-sm-8 rating-process">
                                    <div class="row">
                                        <?php $tmp_percent_vote = 0; ?>
                                        @for ($i = 5; $i <10; $i++)
                                        <?php
                                            if ($i == 5) {
                                                $count_star = $info_course->five_stars;
                                                $percent_vote = number_format(($count_star / $info_course->vote_count)*100, 0, ',' , '.');
                                            } elseif ($i == 6) {
                                                $count_star = $info_course->four_stars;
                                                $percent_vote = number_format(($count_star / $info_course->vote_count)*100, 0, ',' , '.');
                                            } elseif ($i == 7) {
                                                $count_star = $info_course->three_stars;
                                                $percent_vote = number_format(($count_star / $info_course->vote_count)*100, 0, ',' , '.');
                                            } elseif ($i == 8) {
                                                $count_star = $info_course->two_stars;
                                                $percent_vote = number_format(($count_star / $info_course->vote_count)*100, 0, ',' , '.');
                                            } else{
                                                $count_star = $info_course->one_stars;
                                                $percent_vote = $percent_temp;
                                            }
                
                                            $percent_temp -= (int)$percent_vote;
                                        ?>
                                        <div class="item-progress" id="rate-{{ 10 - $i }}" data-rate="{{ 10 - $i }}" data-vote="{{ $count_star }}" data-percent="{{ (int)$percent_vote }}">
                                            <div class="col-sm-8">
                                                <div class="progress">
                                                    <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="{{ $percent_vote }}"
                                                        aria-valuemin="0" aria-valuemax="100" style="width:{{ $percent_vote }}%"></div>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
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
                            <div class="reviews"  id="">
                                @if ( !isset($ratingCourse) )
                                    @if(\App\Helper\Helper::getUserRoleOfCourse($info_course->id))
                                        <h4 style="display:inline-block">Đánh giá của bạn: </h4>
                                        <h3 style="display:inline-block">
                                        @if(isset($info_course->userRoles[0]->user_id))
                                            @if( (int)($info_course->userRoles[0]->user_id) != (int)(Auth::user()->id) )
                                                <span class="reviews-star" data-star="{{ isset($ratingCourse) ? $ratingCourse->score : 0 }}">
                                                    @if($ratingCourse)
                                                    @include(
                                                        'components.vote', 
                                                        [
                                                            'rate' => $ratingCourse->score,
                                                        ]
                                                    )
                                                    @else
                                                    <i id="star-1" class="far fa-star review-star" data-id="1"></i>
                                                    <i id="star-2" class="far fa-star review-star" data-id="2"></i>
                                                    <i id="star-3" class="far fa-star review-star" data-id="3"></i>
                                                    <i id="star-4" class="far fa-star review-star" data-id="4"></i>
                                                    <i id="star-5" class="far fa-star review-star" data-id="5"></i>
                                                    @endif
                                                </span>
                                            @endif
                                        @endif
                                        </h3>
                                    @endif
                                    @if(\App\Helper\Helper::getUserRoleOfCourse($info_course->id))
                                        @if(isset($info_course->userRoles[0]->user_id))
                                            @if( (int)($info_course->userRoles[0]->user_id) != (int)(Auth::user()->id) )
                                                <textarea name="content" id="editor" class="form-control" placeholder="Nội dung"></textarea>
                                                <div class="btn-submit text-center mt-10 mb-20">
                                                    <input class="btn btn-primary submit-question" type="submit" value="Gửi đánh giá" id="create-comment-new"/>
                                                </div>
                                                <script>
                                                    var baseURL = $('base').attr('href');
                
                                                    function hideStar(){
                                                        for(var j = 0; j <= 5; j++){
                                                            $('#star-' + j).removeClass('fa').addClass('far');
                                                        }
                                                    }
                
                                                    function showStar(i){
                                                        for(var j = 1; j <= i; j++){
                                                            $('#star-' + j).addClass('fa').removeClass('far');
                                                        }
                                                    }
                
                                                    $('.review-star').mouseenter(function(){
                                                        switch($(this).attr('data-id')){
                                                            case "1":
                                                                hideStar();showStar(1);
                                                                break;
                                                            case "2":
                                                                hideStar();showStar(2);
                                                                break;
                                                            case "3":
                                                                hideStar();showStar(3);
                                                                break;
                                                            case "4":
                                                                hideStar();showStar(4);
                                                                break;
                                                            case "5":
                                                                hideStar();showStar(5);
                                                                break;
                                                        }
                                                    }).mouseleave(function(){
                                                        hideStar();
                                                    }).click(function(){
                                                        console.log($(this));
                                                        hideStar();showStar($(this).attr('data-id'))
                                                        $('.review-star').off( "mouseenter")
                                                        $('.review-star').off( "mouseleave")
                                                        $('.reviews-star').attr('data-star', $(this).attr('data-id'))
                                                    });
                
                                                    $.ajaxSetup({
                                                        headers: {
                                                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                                        }
                                                    });
                
                                                    $('#create-comment-new').on('click', function (e) {
                                                        var score = $('.reviews-star').attr('data-star');
                                                        if($('#editor').val().trim() == ''){
                                                            Swal.fire({
                                                                type: 'warning',
                                                                html: 'Bạn chưa nhập nhận xét.',
                                                            })
                                                            return false;
                                                        }
                
                                                        if($('.reviews-star').attr("data-star") == 0){
                                                            Swal.fire({
                                                                type: 'warning',
                                                                html: 'Bạn chưa nhập sao.',
                                                            })
                                                            return false;
                                                        }
                
                                                        var request = $.ajax({
                                                            url: baseURL + '/reviews/store',
                                                            method: "POST",
                                                            data: {
                                                                course_id: {{ $info_course->id }},
                                                                content : $('#editor').val().trim(),
                                                                score: score
                                                            },
                                                            dataType: "json"
                                                        });
                
                                                        request.done(function( data ) {
                                                            if(data.status == 201){
                                                                var html = "";
                                                                var htmlRate = $('.reviews-star').html();
                                                                var avt = "images/avatar.jpg";
                                                                if(data.commentCourse.data.avatar != null && data.commentCourse.data.avatar.length > 0){
                                                                    avt = data.commentCourse.data.avatar;
                                                                }
                                                                html += '<div class="box clearfix">';
                                                                    html += '<div class="col-sm-4">';
                                                                        html += '<img class="avatar" src="'+baseURL + '/frontend/' + avt +'" alt="">';
                                                                        html += '<div class="info-account">';
                                                                            html += '<p class="interval">' + data.commentCourse.data.created_at +'</p>';
                                                                            html += '<p class="name">' + data.commentCourse.data.username +'</p>';
                                                                        html += '</div>';
                                                                    html += '</div>';
                                                                    html += '<div class="col-sm-8">';
                                                                        html += htmlRate;
                
                                                                        html += '<p class="comment">';
                                                                            html += data.commentCourse.data.content;
                                                                        html += '</p>';
                                                                        html += '<div class="btn-action">';
                                                                            html += '<button type="button" class="btn btn-default btn-reply" data-comment-id="'+data.commentCourse.data.id+'">';
                                                                                html += '<i class="fas fa-comment"></i>';
                                                                                html += '<span>Reply</span>';
                                                                            html += '</button>';
                                                                            html += '<button type="button" class="btn btn-default btn-like" data-comment-id="'+data.commentCourse.data.id+'">';
                                                                                html += '<i class="fas fa-thumbs-up"></i>';
                                                                                html += '<span>Like</span>';
                                                                            html += '</button>';
                                                                            html += '<button type="button" class="btn btn-default btn-dislike" data-comment-id="'+data.commentCourse.data.id+'">';
                                                                                html += '<i class="fas fa-thumbs-down"></i>';
                                                                                html += '<span>Dislike</span>';
                                                                            html += '</button>';
                                                                        html += '</div>';
                                                                        html += '<div id="reply-textbox-'+data.commentCourse.data.id+'" class="reply-textbox hide">';
                                                                            html += '<textarea name="reply-'+data.commentCourse.data.id+'" id="reply-'+data.commentCourse.data.id+'" class="form-control" placeholder="Nội dung"></textarea>';
                                                                            html += '<div class="btn-submit text-center mt-10 mb-20">';
                                                                                html += '<input class="btn btn-primary create-reply-btn" type="submit" value="Gửi trả lời" id="create-reply-'+data.commentCourse.data.id+'" data-id="'+data.commentCourse.data.id+'"/>';
                                                                            html += '</div>';
                                                                        html += '</div>';
                                                                        html += '<div class="reply-hold-'+data.commentCourse.data.id+'"></div>';
                                                                    html += '</div>';
                                                                    html += '<div class="col-sm-12">';
                                                                        html += '<hr>';
                                                                    html += '</div>';
                                                                html += '</div>';
                                                                $('#review-box').prepend(html);
                                                                
                                                                addEventToButton();
                
                                                                // change vote 
                                                                var rate_arr = [];
                                                                $(".item-progress").each(function( index ) {
                                                                    rate_arr[$( this ).attr('data-rate')] = $(this).attr('data-vote'); 
                                                                });
                
                                                                // console.log(rate_arr[$( this ).attr('data-rate')]);
                                                                location.reload();
                                                            }else if(data.status == 200){
                                                                Swal.fire({
                                                                    type: 'warning',
                                                                    text: data.message
                                                                })
                                                            }
                                                        });
                                                        request.fail(function( jqXHR, textStatus ) {
                                                            // alert( "Request failed: " + textStatus );
                                                            Swal.fire({
                                                                type: 'warning',
                                                                html: 'Có lỗi! Nhấn tải lại trang và thử lại!',
                                                            })
                                                            return false;
                                                        });
                                                    });
                                                </script>
                                            @endif
                                        @endif
                                    @endif
                                @else
                                    <div class="alert alert-success text-center" role="alert"><b>Bạn đã đánh giá khóa học này rồi!</b></div>
                                @endif
                                <div id="review-box">
                                    @foreach($info_course->takeComment(0, 3) as $comment)
                                        @include('components.question-answer', ['comment' => $comment])
                                    @endforeach
                                    <?php 
                                    // dd($info_course->takeComment()->first());
                                    ?>
                                </div>
                            </div>
                            @if( $info_course->commentOfStudentBought()->count() > 3)
                            <div class="col-sm-12 btn-see-more" data-skip="3" data-take="3">
                                <button type="button" class="btn">Xem thêm</button>
                            </div>
                            @endif
                            <div class="facebook-comment">
                                <h3>Thảo luận</h3>
                                <div class="fb-comments" data-href="https://courdemy.vn/course/{{ $info_course->id }}/{{$info_course->slug}}" data-width="700" data-numposts="5"></div>
                            </div>
                        </div>

                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-12 hidden-xs">
                        <ul class="others fixed" id="benifit-first">
                            <li>
                                <img src="{{ asset('frontend/images/features_online.png') }}" alt="" /> 
                                <span class="txt-large">100% trực tuyến</span>
                            </li>
                            <li>
                                <img src="{{ asset('frontend/images/features_deadline.png') }}" alt="" /> 
                                <span class="txt-large">Thời gian học linh hoạt</span>
                            </li>
                            <li>
                                <img src="{{ asset('frontend/images/features_level.png') }}" alt="" /> 
                                <span class="txt-large">Cho người mới học</span>
                            </li>
                            @if ($info_course->approx_time != '')
                            <li>
                                <img src="{{ asset('frontend/images/features_hour.png') }}" alt="" /> 
                                <span class="txt-large">Khoảng {{ $info_course->approx_time }} giờ để hoàn thành</span>
                            </li>
                            @endif
                            <li>
                                <img src="{{ asset('frontend/images/features_subtitle.png') }}" alt="" /> 
                                <span class="txt-large">Tiếng Việt</span>
                            </li>
                        </ul>
                        <div class="info-course-sidebar hidden-md hidden-xs hidden-sm" style="position: relative;">
                            <div id="sidebar-content">
                                <div class="u-sm-left">
                                    <div class="block-price clearfix">
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
                                        @if ($check_time_sale == true || $info_course->price != $info_course->real_price)                                        
                                        <div class="col-sm-6 pull-left">
                                            <span class="sale">{!! number_format($info_course->price, 0, ',' , '.') !!}đ</span>
                                            <span class="price">{!! number_format($info_course->real_price, 0, ',' , '.') !!}đ</span>
                                            {{-- <span class="interval">Còn {{ $date_to->diff($date_from)->format("%d") }} ngày tại mức giá này </span> --}}
                                        </div>
                                        <div class="col-sm-6">
                                            @if( $info_course->price != 0 && $info_course->real_price != 0 )
                                            <span class="percent-price-off pull-right">-{{ (int)(100 - ($info_course->price/$info_course->real_price)*100) }}%</span>
                                            @endif
                                        </div>
                                        @else
                                        <div class="col-sm-6 pull-left">
                                            <span class="sale">{!! number_format($info_course->price, 0, ',' , '.') !!}đ</span>
                                        </div>
                                        @endif
                                    </div>
                                    <div class="button-class clearfix">
                                        @if (Auth::check())
                                            @if (!Auth::user()->isAdmin())
                                            @if(isset($info_course->userRoles[0]->user_id))
                                                @if( (int)($info_course->userRoles[0]->user_id) == (int)(Auth::user()->id) )
                                                    <div class="sidebar-add-cart">
                                                        <button type="button" id="add-cart2" class="btn btn-primary button-add-to-cart" disabled><b>Đây là khóa học của bạn</b></button>
                                                    </div>
                                                    <div class="sidebar-buy-now">
                                                        <a href="/list-course?type=best-seller" class="btn btn-warning" style="width: 90%;padding: 10px 0;margin-top: 10px;text-transform: uppercase;"><b>Xem các khóa học khác</b></a>
                                                    </div>
                                                @else 
                                                    @if (!in_array($info_course->id, $list_bought))
                                                        <div class="sidebar-add-cart">
                                                            <button type="button" id="{{ $info_course->id }}" class="btn btn-primary button-add-to-cart"><b>Thêm vào giỏ hàng</b></button>
                                                        </div>
                                                        <div class="sidebar-buy-now">
                                                            <button type="button" id="buy-now2" class="btn btn-warning"><b>Mua ngay</b></button>
                                                        </div>
                                                    @else
                                                        <div class="sidebar-add-cart">
                                                            <button type="button" id="add-cart2" class="btn btn-primary button-add-to-cart" disabled><b>Bạn đã mua khóa học này</b></button>
                                                        </div>
                                                        <div class="sidebar-buy-now">
                                                            <a href="/list-course?type=best-seller" class="btn btn-warning" style="width: 90%;padding: 10px 0;margin-top: 10px;text-transform: uppercase;"><b>Xem các khóa học khác</b></a>
                                                        </div>
                                                    @endif
                                                @endif
                                            @endif
                                            @endif
                                        @else
                                            <div class="sidebar-add-cart">
                                                <button type="button" id="{{ $info_course->id }}" class="btn btn-primary button-add-to-cart"><b>Thêm vào giỏ hàng</b></button>
                                            </div>
                                            <div class="sidebar-buy-now">
                                                {{-- <button type="button" id="buy-now2" class="btn btn-warning"><b>Mua ngay</b></button> --}}
                                                <button class="btn btn-warning course-detail-buy-now" data-toggle=modal data-target=#modalLoginCourseDetail data-dismiss=modal ><b>Mua ngay</b></button>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="clearfix">
                                        <div class="text-center money-back">
                                            {{-- (Hoàn tiền trong 30 ngày nếu không hài lòng) --}}
                                        </div>
                                    </div>
                                </div>
                                <div class="u-sm-right">
                                    <div class="block-ulti">
                                        <ul style="margin-left: 0">
                                            <li><i class="far fa-clock fa-fw" aria-hidden="true"></i> Thời lượng: <b>{{ intval($course_duration / 3600) }} giờ {{ intval(($course_duration % 3600 ) / 60) }} phút</b></li>
                                            <li><i class="far fa-play-circle fa-fw" aria-hidden="true"></i> Bài giảng: <b>{{ $info_course->all_videos() }} Videos</b></li>
                                            <li><i class="fas fa-user-graduate fa-fw" aria-hidden="true"></i> <b>{{ number_format($info_course->student_count, 0, ',' , '.') }} Học viên</b> theo học</li>                                        
                                        </ul>
                                        <div class="clearfix"></div>
                                    </div>
                                </div>
                            </div>                    
                        </div>
                        <script>
                            $(document).ready(function() { 
                                // var block_on = $('#benefit-course').position().top + $('#benifit-first').height() + 62 //Padding
                                // var block_below = $('.related-course').position().top - $('#sidebar-content').height() - 32 - 60 //Padding
                                // if( block_on < block_below + 20 ){
                                //     $('#sidebar-content').css('display', 'block')
                                //     $('#benefit-course').css('min-height', '660px')
                                // }
                                var block_on = $('#benefit-course').position().top + $('#benifit-first').height() + 62 //Padding
                                var block_below = $('.related-course').position().top - $('#sidebar-content').height() - 20 - 62 //Padding
                                if ($(window).scrollTop() >= block_on - 40) {
                                    if($(window).scrollTop() <= block_below - 40){
                                        document.getElementById("sidebar-content").classList.add("sidebar-fixed");
                                        $("#sidebar-content").removeClass('sidebar-unfix').css('top', '');
                                    }else{
                                        document.getElementById("sidebar-content").classList.remove("sidebar-fixed");
                                        $("#sidebar-content").addClass('sidebar-unfix').css('top', block_below - block_on + 20);
                                    }
                                } else {
                                    document.getElementById("sidebar-content").classList.remove("sidebar-fixed");
                                }
                                $(window).scroll(function() {
                                    var block_on = $('#benefit-course').position().top + $('#benifit-first').height() + 62 //Padding
                                    var block_below = $('.related-course').position().top - $('#sidebar-content').height() - 30 - 62 //Padding
                                    if ($(window).scrollTop() >= block_on - 40 - 60) {
                                        if($(window).scrollTop() <= block_below - 40 - 60){
                                            document.getElementById("sidebar-content").classList.add("sidebar-fixed");
                                            $("#sidebar-content").removeClass('sidebar-unfix').css('top', '');
                                        }else{
                                            document.getElementById("sidebar-content").classList.remove("sidebar-fixed");
                                            $("#sidebar-content").addClass('sidebar-unfix').css('top', block_below - block_on + 20);
                                        }
                                    } else {
                                        document.getElementById("sidebar-content").classList.remove("sidebar-fixed");
                                    }
                                });
                            })
                        </script>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
    
    <div class="container">
        
    </div>
    <div class="related-course">
        <div class="container">
            @include('frontends.related-course')
        </div>
    </div>
    @if (Auth::check())
        @if(isset($info_course->userRoles[0]->user_id))
            @if( (int)($info_course->userRoles[0]->user_id) != (int)(Auth::user()->id) )
                <div class="interactive-bar" data-i="{{ $info_course->id }}">
                    <div class="row">
                        <div class="info col-xs-12 col-md-8 col-sm-7">
                            <div class="title">
                                <strong><p>{{ $info_course->name }}</p></strong>
                            </div>
                            <div class="lecturer">
                                @foreach ($info_course->Lecturers() as $lecturer)
                                    @if ( $lecturer->user ) 
                                    <p>{{$lecturer->user->name}}</p> 
                                    @endif             
                                @endforeach
                            </div>
                        </div>
                        @if (!Auth::user()->isAdmin())
                        @if (!in_array($info_course->id, $list_bought))
                        <div class="buttons col-xs-12 col-md-4 col-sm-5">
                            <div class="group-btn-buy-course">
                                <button class="btn btn-primary">Thêm vào giỏ hàng</button>
                                <button class="btn btn-warning btn-buy-now">Mua ngay</button>
                            </div>
                        </div>
                        @endif
                        @endif
                    </div>
                </div>
            @endif
        @endif
    @else
        <div class="interactive-bar" data-i="{{ $info_course->id }}">
            <div class="row">
                <div class="info col-xs-12 col-md-8 col-sm-7">
                    <div class="title">
                        <strong><p>{{ $info_course->name }}</p></strong>
                    </div>
                    <div class="lecturer">
                        @foreach ($info_course->Lecturers() as $lecturer)
                        <p>{{$lecturer->user->name}}</p>              
                        @endforeach
                    </div>
                </div>
                <div class="buttons col-xs-12 col-md-4 col-sm-5">
                    <div class="group-btn-buy-course">
                        <button class="btn btn-primary">Thêm vào giỏ hàng</button>
                        {{-- <button class="btn btn-warning">Mua ngay</button> --}}
                        <button class="btn btn-warning course-detail-buy-now" data-toggle=modal data-target=#modalLoginCourseDetail data-dismiss=modal ><b>Mua ngay</b></button>
                    </div>
                </div>
            </div>
        </div>
    @endif
    <script>
        $('.course-detail-buy-now').click(function(e){
            e.stopPropagation()
            e.preventDefault()
            addCart()
            $('#resetCourseDetailFormsLogin').click()
            $('#resetCourseDetailFormsSignup').click()
            $("#modalLoginCourseDetail").modal("toggle")
            // $('.alert-validate').html('')
            $('.form-html-validate').css('display', 'none')
        })
        $(window).scroll(function() {
            var barHeight = $(".interactive-bar").outerHeight()
                if ($(window).scrollTop() > 300) {
                    $("footer .item-2").css("margin-bottom", barHeight)
                    $("#button").css("bottom", "-26")
                    // console.log(barHeight);
                    
                    $(".interactive-bar").fadeIn();
                } else {
                    $(".interactive-bar").fadeOut();
                    $("footer .item-2").css("margin-bottom", "0 !important")
                }
        });
    </script>
</div>
@if ( !Auth::check() )
<div id="modalLoginCourseDetail" class="modal fade" role="dialog" >
    <div class="modal-dialog modal-login">
        <div class="modal-content">
            <div class="modal-header">				
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <div class="modal-title"><b>Đăng nhập vào tài khoản Courdemy của bạn</b></div>
            </div>
            <div class="modal-body">
                <br/>
                <form action="/examples/actions/confirmation.php" method="post">
                    <div class="form-group">
                        <div class="input-group form-html">
                            <span class="input-group-addon"><i class="fas fa-envelope fa-fw fa-md"></i></span>
                            <input type="t" class="form-control" name="email" placeholder="Email" required="required">
                            <div class="form-html-validate login_email"></div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group form-html">
                            <span class="input-group-addon"><i class="fas fa-lock fa-fw fa-md"></i></span>
                            <input type="password" class="form-control" name="pass" placeholder="Mật khẩu" required="required" id="courseShowMyPassword">
                            <div class="show-password" onclick="courseShowPassword()">
                                <i class="fas fa-eye fa-fw fa-md" id="eye"></i>
                            </div>
                            <div class="form-html-validate login_password"></div>
                        </div>
                    </div>
                    <div class="form-group">
                        <input type="button" class="btn btn-success btn-block btn-lg" value="Đăng nhập" onclick="loginCourseDetailAjax()">
                    </div>
                    <input id="resetCourseDetailFormsLogin" type="reset" value="Reset the form" style="display:none">
                </form>
                @if($_SERVER['SERVER_NAME'] === "courdemy.vn")
                    <hr>
                    @include('components.fb-login-buy-now',['course_fb_login' => $info_course])
                    @include('components.google-login')
                @endif
            </div>

            <div class="modal-footer">
                <div class="link-to-sign-up">
                    <div>
                        Bạn chưa có tài khoản? <a href="javascript:void(0)" data-toggle="modal" data-target="#modalRegisterCourseDetail" data-dismiss="modal"><b>Đăng ký</b></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="modalRegisterCourseDetail" class="modal fade" role="dialog" >
    <div class="modal-dialog modal-login">
        <div class="modal-content">
            <div class="modal-header">				
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <div class="modal-title"><b>Tạo tài khoản mới</b></div>
            </div>
            <div class="modal-body">
                <form action="/examples/actions/confirmation.php" method="post">
                    <div class="form-group">
                        <div class="input-group form-html">
                            <span class="input-group-addon"><i class="fas fa-user fa-lock fa-fw fa-md"></i></span>
                            <input type="text" class="form-control" name="name" placeholder="Tên của bạn" required="required">
                            <div class="form-html-validate name"></div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group form-html">
                            <span class="input-group-addon"><i class="fas fa-envelope fa-envelope fa-fw fa-md"></i></span>
                            <input type="email" class="form-control" name="email" placeholder="Email" required="required">
                            <div class="form-html-validate email"></div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group form-html">
                            <span class="input-group-addon"><i class="fas fa-lock fa-fw fa-md"></i></span>
                            <input type="password" class="form-control" name="pass" placeholder="Mật khẩu" required="required">
                            <div class="form-html-validate password"></div>
                        </div>				
                    </div>
                    <div class="form-group">
                        <div class="input-group form-html">
                            <span class="input-group-addon"><i class="fas fa-lock fa-fw fa-md"></i></span>
                            <input type="password" class="form-control" name="confirmpass" placeholder="Nhập lại mật khẩu" required="required">
                            <div class="form-html-validate confirmpassword"></div>
                        </div>				
                    </div>
                    {{-- <div class="terms-and-policy">
                        <label class="checkbox-inline"><input type="checkbox">You agree to our <a href="#">Terms of Use</a> and <a href="#">Privacy Policy</a>!</label>
                    </div> --}}
                    <div class="form-group">
                        <input type="button" class="btn btn-success btn-block btn-lg" value="Đăng ký" onclick="registerCourseDetailAjax()">
                    </div>
                    <input id="resetCourseDetailFormsSignup" type="reset" value="Reset the form" style="display:none">
                </form>				
            </div>
            <div class="modal-footer">
                <div class="link-to-sign-up">
                    <div>
                        Bạn đã có tài khoản? <a href="javascript:void(0)" data-toggle="modal" data-target="#modalLoginCourseDetail" data-dismiss="modal"><b>Đăng nhập</b></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endif
<script type="text/javascript">
    var user_id = $('button[id=cartUserId]').attr('data-user-id')
    $(document).ready(function() { 

        $(".interactive-bar .buttons button:first-child").click(function(){
            $(".btn-add-cart button").click();
        })
        $(".interactive-bar .buttons .btn-buy-now").click(function(){
            addCart();
            window.location.href = ("/cart/payment/method-selector")
        })
        $("#buy-now").click(function(){
            addCart();
            window.location.href =("/cart/payment/method-selector")
        })
        $("#buy-now2").click(function(){
            addCart();
            window.location.href = ("/cart/payment/method-selector")
        })

        $('.btn-see-more').click(function(){
            var baseURL = $('base').attr('href');
            var current_skip = Number($(this).attr('data-skip'));
            var current_take = Number($(this).attr('data-take'));
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var request = $.ajax({
                url: baseURL + '/comments/see-more?course_id=' + {{ $info_course->id }} + '&skip=' + current_skip + '&take=' + current_take,
                method: "GET",
                dataType: "html"
            });
            // console.log({{ $info_course->comments()->count() }})
            // console.log(current_skip)
            // console.log(current_take)
            request.done(function( data ) {
                if(data == '' || {{ $info_course->commentOfStudentBought()->count() }} <= current_skip + current_take){
                    $('.btn-see-more').hide();
                }
                $('.btn-see-more').attr('data-skip', current_skip + current_take);
                $('#review-box').append(data);
                addEventToButton();
            });
        })



        $(document).on('click', '.btn-see-more-level-2', function(){ 
            var comment_id = Number($(this).attr('data-comment-id'));
            // alert(comment_id)
            var baseURL = $('base').attr('href');
            var current_skip = Number($(this).attr('data-skip'));
            var current_take = Number($(this).attr('data-take'));

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var request = $.ajax({
                url: baseURL + '/comments-child/see-more?comment_id=' + comment_id + '&skip=' + current_skip + '&take=' + current_take,
                method: "POST",
                dataType:'json',
            });
            // console.log({{ $info_course->comments()->count() }})
            // console.log(current_skip)
            // console.log(current_take)
            request.done(function( response ) {
                if(response.total_comment_child <= current_skip + current_take){
                   $('.btn-see-more-level-2[data-comment-id="'+ comment_id +'"]').hide();
                }
                
                $('.btn-see-more-level-2[data-comment-id="'+ comment_id +'"]').attr('data-skip', current_skip + current_take);

                var html = '';
                var data = response.data;

                $.each(data, function(key, value) {
                    html +='<div class="comment-reply">'
                        html +='<div class="row">'
                            html +='<div class="col-md-1">'
                                if(value.avatar != '') {
                                    html +='<img class="avatar" src="{{ url('/') }}/frontend/'+ value.avatar +'" alt="" />'
                                } else {
                                    html +='<img class="avatar" src="{{ url('/') }}/frontend/images/avatar.jpg" alt="" />'
                                }
                            html +='</div>'
                            html +='<div class="col-md-11">'
                                html +='<div class="info-account">'
                                    html +='<span class="name pull-left" style="padding-left:15px;">' + value.name + '</span>'
                                    html +='<span class="interval pull-right">' + value.created_at + '</span>'
                                    html +='<div class="clearfix"></div>'
                                    html +='<div class="comment">'
                                        html += value.content
                                    html +='</div>'
                                html +='</div>'
                            html +='</div>'
                        html +='</div>'
                    html +='</div>';
                });

                $('.reply-hold-' + comment_id).append(html);
                addEventToButton();
            });
        });


        $('.go-box').click(function() {
            var box = $(this).attr('data-box');
            if($('#' + box).length) {
                var top_scroll = 0;
                top_scroll = $("#" + box).offset().top;
                $('html,body').animate({
                    scrollTop: top_scroll - 100
                }, 'slow');
            }    
        });
        
        addEventToButton();

        
    });

    function vote(comment_id, type){
        var baseURL = $('base').attr('href');
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var request = $.ajax({
            url: baseURL + '/comments/vote',
            method: "POST",
            data: {
                comment_id: comment_id,
                type: type
            },
            dataType: "json"
        });
    }

    function addEventToButton(){
        $('.btn-default.btn-reply').off('click');
        $('.btn-default.btn-like').off('click');
        $('.btn-default.btn-dislike').off('click');
        $('.create-reply-btn').off('click');

        $('.btn-default.btn-reply').on('click', function (e) {
            // console.log($(this).attr('data-comment-id'));
            // $('.reply-hold').addClass('hide');
            $('.reply-hold-' + $(this).attr('data-comment-id')).removeClass('hide');

            $('.reply-textbox').addClass('hide');
            $('#reply-textbox-' + $(this).attr('data-comment-id')).removeClass('hide');
        });

        $('.btn-default.btn-like').on('click', function (e) {
            vote($(this).attr('data-comment-id'), 'up');
            $(this).removeClass('btn-default').addClass('btn-primary');
            $(this).parent().find('.btn-dislike').addClass('btn-default').removeClass('btn-primary');
        });

        $('.btn-default.btn-dislike').on('click', function (e) {
            vote($(this).attr('data-comment-id'), 'down');
            $(this).removeClass('btn-default').addClass('btn-primary');
            $(this).parent().find('.btn-like').addClass('btn-default').removeClass('btn-primary');
        });

        $('.btn-default.btn-reportcomment').off('click');
        $('.btn-default.btn-reportcomment').on('click',function(e){
            var id = $(this).attr('data-comment-id');
            var baseURL = $('base').attr('href');
            Swal.fire({
                type: 'warning',
                text: 'Bạn có chắc chắn muốn báo cáo comment này!',
                showCancelButton: true,
            }).then(result =>{
                if(result.value){
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    var request = $.ajax({
                        url: baseURL + '/comments/report',
                        method: "POST",
                        data: {
                            comment_id: id
                        },
                        dataType: "json",
                        success: function (response) {
                            if(response.status == 200){
                                Swal.fire({
                                    type: 'success',
                                    text: 'Báo cáo thành công!',
                                })
                            }
                            else{
                                Swal.fire({
                                    type: 'warning',
                                    text: response.message
                                })
                            }
                        },
                        error: function (data) {
                            if(data.status == 401){
                            window.location.replace(baseURL);
                            }else{
                                Swal.fire({
                                    type: 'warning',
                                    text: errorConnect
                                })
                            }
                        }
                    });
                }
            })
            // $('.btn-default.btn-reportcomment data-comment-id="id"').prop('disabled', true);
            // function disable(id){
            //     $(".btn-default.btn-reportcomment"+id).prop("disabled",true);
            // }
        })

        $('.create-reply-btn').on('click', function (e) {
            var comment_id = $(this).attr('data-id');
            var baseURL = $('base').attr('href');
            if($("#reply-" + comment_id).val().trim() == ''){
                Swal.fire({
                    type: 'warning',
                    html: 'Bạn chưa nhập nội dung trả lời.',
                })
                return false;
            }
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var request = $.ajax({
                url: baseURL + '/comments/reply',
                method: "POST",
                data: {
                    parent_id: comment_id,
                    content : $("#reply-" + comment_id).val()
                },
                dataType: "json"
            });

            request.done(function( data ) {
                if(data.status == 200){
                    var avt = "images/avatar.jpg";
                    if(data.commentCourse.data.avatar != null && (data.commentCourse.data.avatar + "").length > 0){
                        avt = data.commentCourse.data.avatar;
                    }
                    var html = "";
                    html += '<div class="comment-reply">'
                        html += '<div class="row">'
                            html += '<div class="col-md-1">'
                                html += '<img class="avatar" src="'+baseURL + '/frontend/' + avt +'" alt="">'
                            html += '</div>'
                            html += '<div class="col-md-11">'
                                    html += '<div class="info-account">'
                                        html += '<span class="name pull-left" style="padding-left:15px;">' + data.commentCourse.data.username +'</span>'
                                    html += '<span class="interval pull-right">' + data.commentCourse.data.created_at +'</span>'
                                    html += '<div class="clearfix"></div>'
                                    html += '<div class="comment">'
                                        html += data.commentCourse.data.content;
                                    html += '</div>'
                                html += '</div>'
                            html += '</div>'
                        html += '</div>'
                    html += '</div>'

                    $('.reply-hold-' + comment_id + ' .comment-reply:first-child').before(html);
                    $("#reply-" + comment_id).val("")
                    $('.reply-textbox').addClass('hide')
                }
            });

            request.fail(function( jqXHR, textStatus ) {
                // alert( "Request failed: " + textStatus );
                Swal.fire({
                    type: 'warning',
                    html: 'Có lỗi! Nhấn tải lại trang và thử lại!',
                })
                return false;
            });
        });
    }

    jQuery(function () {
        $(".btn-add-cart button").click( function(e){
            e.stopPropagation()
            e.preventDefault()

            $(this).remove();
            $(".btn-buy-now button").remove()
            // $('.interactive-bar ').remove()
            $('.interactive-bar .buttons button ').remove()
            
            addCart()
            Swal.fire({
                type: 'success',
                text: 'Đã thêm vào giỏ hàng!'
            })
            var number_items_in_cart = JSON.parse(localStorage.getItem('cart'+user_id))
            $('.number-in-cart').text(number_items_in_cart.length)
            $('.unica-sl-cart').css('display', 'block')
            $.each( number_items_in_cart, function(i, obj) {
                $('.sidebar-add-cart button[id='+obj.id+']').html('<b>Đã thêm vào giỏ hàng</b>').attr('disabled', true)
            });
        })
        
        $(".sidebar-add-cart button").click( function(e){
            e.stopPropagation()
            e.preventDefault()

            // $(this).remove();
            // $(".btn-buy-now button").remove();
            // $('.interactive-bar').remove();

            $(this).html('<b>Đã thêm vào giỏ hàng</b>').attr('disabled', true)

            
            addCart();
            Swal.fire({
                type: 'success',
                text: 'Đã thêm vào giỏ hàng!'
            })
            $(".btn-add-cart button").remove()
            $(".btn-buy-now button").remove()
            // $('.interactive-bar').remove()
            $('.interactive-bar .buttons button').remove()
            

            var number_items_in_cart = JSON.parse(localStorage.getItem('cart'+user_id))
            $('.number-in-cart').text(number_items_in_cart.length);
            $('.unica-sl-cart').css('display', 'block')
            
        })

        if(localStorage.getItem('cart'+user_id) != null){
            var number_items_in_cart = JSON.parse(localStorage.getItem('cart'+user_id))

            $.each( number_items_in_cart, function(i, obj) {
                $('.btn-buy-now button[data-id='+obj.id+']').remove()
                $('.btn-add-cart button[data-id='+obj.id+']').remove()
                // $('.interactive-bar[data-i='+obj.id+']').remove()
                $('.interactive-bar[data-i='+obj.id+'] .buttons button').remove()

                $('.sidebar-add-cart button[id='+obj.id+']').html('<b>Đã thêm vào giỏ hàng</b>')
                $('.sidebar-add-cart button[id='+obj.id+']').attr('disabled', true)
                
            });
            
            // $('.interactive-bar[data-i="{{ $info_course->id }}"]').remove();
        }
    })

    function addItem(arr, obj) {
        const { length } = arr;
        const found = arr.some(el => el.id === obj.id);
        if (!found) arr.push(obj);
        return arr;
    }

    function addCart(){
        var course_id = {!! $info_course->id !!}
        course_id = Number(course_id)
        var check = true
        
        if(localStorage.getItem('cart'+user_id) != null){
            var number_items_in_cart = JSON.parse(localStorage.getItem('cart'+user_id))

            $.each( number_items_in_cart, function(i, obj) {
                if( course_id == Number(obj.id) ){
                    check = false
                }
            });
        }
        if(check){
            var item = {
                'id' : {!! $info_course->id !!},
                'image' : '{!! $info_course->image !!}',
                'slug' : '{!! $info_course->slug !!}',                
                @if(count($info_course->Lecturers()) > 0)
                'lecturer' : "@if($info_course->Lecturers()[0]->user){!! $info_course->Lecturers()[0]->user->name !!}@else Courdemy @endif",
                @else
                'lecturer' : 'Nhiều giảng viên',
                @endif
                'name' : "{!! $info_course->name !!}",
                'price' : {!! $info_course->price !!},
                'real_price' : {!! $info_course->real_price !!},
                'coupon_price' : {!! $info_course->price !!},
                'coupon_code' : '',
            }
    
            if (localStorage.getItem('cart'+user_id) != null) {
                var list_item = JSON.parse(localStorage.getItem('cart'+user_id));
                addItem(list_item, item);
                localStorage.setItem('cart'+user_id, JSON.stringify(list_item));
            }else{
                var list_item = [];
                addItem(list_item, item);
                localStorage.setItem('cart'+user_id, JSON.stringify(list_item));
            }
    
            var number_items_in_cart = JSON.parse(localStorage.getItem('cart'+user_id))
            $('.number-in-cart').text(number_items_in_cart.length);
        }
    }
    $(document).ready(function() {
        @if(!(\App\Helper::isMobile()))
            $('.detail-course .frame .network-reponsive').css('margin-top',($('.detail-course .frame .info').height() - $('.detail-course .frame .network-reponsive').height())/2)
        @endif
    })

    $('#modalLoginCourseDetail input[name=email],#modalLoginCourseDetail input[name=pass],#modalLoginCourseDetail input[name=remember]').keypress(function(event){
        var keycode = (event.keyCode ? event.keyCode : event.which);
        if(keycode == '13'){
            loginCourseDetailAjax();
            return false;
        }
    });

    // Show Password
    var flag = 1;
    function courseShowPassword() {
        var x = document.getElementById("courseShowMyPassword");
        if (x.type === "password") {
            x.type = "text";
            flag = 1;
            $('#eye').removeClass('fa-eye')
            $('#eye').addClass('fa-eye-slash')
        } else {
            x.type = "password";
            flag = 0;
            $('#eye').removeClass('fa-eye-slash')
            $('#eye').addClass('fa-eye')
        }
    }

    function loginCourseDetailAjax(){
        var email = $('#modalLoginCourseDetail input[name=email]').val();
        email = email.trim();
        var password = $('#modalLoginCourseDetail input[name=pass]').val();
        var remember = $('#modalLoginCourseDetail input[name=remember]').prop('checked');
        var data = {
            login_email     : email,
            login_password  : password,
            course_id: {{$info_course->id}},
        };
        $.ajaxSetup(
        {
            headers:
            {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            method: "POST",
            url: '{{ url("loginAjax-course-detail") }}',
            data: data,
            dataType: 'json',
            success: function (response) {
                if(response.status == 200){
                    $('#modalLoginCourseDetail').modal('toggle');
                    if ( response.role == 1 ){
                        Swal.fire({
                            type: 'warning',
                            html: 'Chú là admin nên không thể mua khóa học. Hiểu chứ?',
                        }).then((result)=>{
                            window.location.reload()
                        })
                    }else if ( response.role == 2 ){
                        Swal.fire({
                            type: 'warning',
                            html: 'Khóa học này là của bạn.',
                        }).then((result)=>{
                            window.location.reload()
                        })
                    }else if ( response.role ==3 ){
                        Swal.fire({
                            type: 'warning',
                            html: 'Bạn đã mua khóa học này.',
                        }).then((result)=>{
                            window.location.reload()
                        })
                    }else{
                        window.location.href = ("/cart/payment/method-selector")
                    }
                }else{
                    Swal.fire({
                        type: 'warning',
                        html: response.message,
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
            }
        });
        return false;
    }

    function registerCourseDetailAjax(){
        var name = $('#modalRegisterCourseDetail input[name=name]').val();
        name = name.trim();
        var email = $('#modalRegisterCourseDetail input[name=email]').val();
        email = email.trim();
        var password = $('#modalRegisterCourseDetail input[name=pass]').val();
        var confirmpassword = $('#modalRegisterCourseDetail input[name=confirmpass]').val();
        var data = {
            name : name,
            email:email,
            password: password,
            confirmpassword: confirmpassword,
        };
        $.ajaxSetup(
        {
            headers:
            {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            method: "POST",
            url: '{{ url("registerAjax") }}',
            data: data,
            dataType: 'json',
            success: function (response) {
                if(response.status == 200){
                    Swal.fire({
                        type: 'success',
                        html: response.message,
                    }).then((result) => {
                        if (result.value) {
                            window.location.href = ("/cart/payment/method-selector")
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
                $(".ajax_waiting").removeClass("loading");
                var obj_errors = error.responseJSON.errors;
                $('.form-html-validate').css('display', 'block')
                $('.form-html-validate').html('')
                $.each(obj_errors, function( index, value ) {
                    var content = '<i class="fas fa-exclamation fa-fw"></i><div class="hover-alert">'+ value +'</div>'
                    $('.form-html-validate.' + index).html(content);
                })
            }
        });
        return false;
    }
</script>
@endsection