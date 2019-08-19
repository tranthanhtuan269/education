@extends('frontends.layouts.app')
@section('content')
<?php
    $percent_temp = 100;
    $initial_vote_count = $info_course->vote_count;
    if($info_course->vote_count == 0) {
        $info_course->vote_count = 1;
        $percent_temp = 0;
    }
    // dd($info_course->Lecturers()->first());
    $list_bought = [];
    if(Auth::check() && strlen(Auth::user()->bought) > 0){
        $list_bought = \json_decode(Auth::user()->bought);
    }
?>
<div class="detail-course">
    <img class="background bg-category" src="{{ asset('frontend/images/banner_profile_teacher.png') }}">
    <div class="container">
        <div class="row">
            <div class="item clearfix">
                <div class="col-sm-12">
                    <div class="frame clearfix pb-40px">
                        <div class="pull-left">
                            <div class="info">
                                <p class="name">{{ $info_course->name }}</p>
                                <p class="expret">{{ $info_course->short_description }}</p>
                            </div>
                        </div>
                        <div class="network pull-right network-reponsive">
                            <a class="btn btn-default btn-xs" href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode(url()->current()); ?>" target="_blank">
                                <i class="fas fa-share-alt"></i> Chia sẻ
                            </a>
                            {{-- <a class="btn btn-default btn-xs" href="https://www.facebook.com/canhchimcodon26988" target="_blank">
                                <i class="fab fa-facebook-square"></i> Facebook
                            </a> --}}
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
                                    @if ($check_time_sale == true || $info_course->price != $info_course->real_price)                                        
                                    <div class="col-sm-6 pull-left">
                                        <span class="sale">{!! number_format($info_course->price, 0, ',' , '.') !!}đ</span>
                                        <span class="price">{!! number_format($info_course->real_price, 0, ',' , '.') !!}đ</span>
                                        {{-- <span class="interval">Còn {{ $date_to->diff($date_from)->format("%d") }} ngày tại mức giá này </span> --}}
                                    </div>
                                    <div class="col-sm-6">
                                        <span class="percent-price-off pull-right">Tiết kiệm {{ (int)(100 - ($info_course->price/$info_course->real_price)*100) }}%</span>
                                    </div>
                                    @else
                                    <div class="col-sm-6 pull-left">
                                        <span class="sale">{!! number_format($info_course->price, 0, ',' , '.') !!}đ</span>
                                    </div>
                                    @endif
                                </div>
                                <div class="row box clearfix">
                                    <div class="col-xs-6 full-width-mobile pb-10px">
                                        <span class="box-img"><img src="{{ asset('frontend/images/ic_duration.png') }}" class="icon" alt="" /></span>
                                        <span class="special">Tổng số giờ học: {{ intval($info_course->duration / 60) }} giờ</span>
                                    </div>
                                    <div class="col-xs-6 full-width-mobile pb-10px">
                                        <span class="box-img"><img src="{{ asset('frontend/images/ic_download.png') }}" class="icon" alt="" /></span>
                                        <span class="special">{{ $info_course->downloadable_count	 }} Tài liệu đính kèm</span>
                                        
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
                                        <span class="special">{{ $info_course->video_count }} Videos</span>
                                    </div>
                                    <div class="col-xs-6 full-width-mobile pb-10px">
                                        <span class="box-img"><img src="{{ asset('frontend/images/ic_student.png') }}" class="icon" alt="" /></span>
                                        <span class="special">{{ number_format($info_course->student_count, 0, ',' , '.') }} Học viên</span>
                                    </div>
                                </div>
                                <div class="row box clearfix">
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
                                        30 ngày hoàn tiền
                                    </div>
                                </div>
                                @endif
                                
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
                        <li class="active"> Mô tả </li>
                        <li><a href="javascript:;" class="go-box" data-box="box_content">Danh sách bài học</a></li>                        
                        <li><a href="javascript:;" class="go-box" data-box="box_requirements">Yêu cầu</a></li>
                        <li><a href="javascript:;" class="go-box" data-box="box_reviews">Đánh giá</a> </li>
                        @if (count($info_course->Lecturers()) >= 1) <li><a href="javascript:;" class="go-box" data-box="box_instructors">Thông tin giảng viên</a></li> @endif
                        <li><a href="javascript:;" class="go-box" data-box="box_related_course">Khóa học liên quan </a></li>
                    </ul>
                </div>
            </div>
            <div class="info clearfix my-30px col-xs-12">
                <div class="row">
                    <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                        <div class="desc">
                            <h3>Mô tả khóa học</h3>
                            <p>
                                {!! $info_course->description !!}
                            </p>
                        </div>
                        @php
                            $will_learn = $info_course->will_learn;
                            $will_learn = explode(";;", $will_learn);
                            $will_learn = array_filter($will_learn, function($will){
                                $will = trim($will);
                                return $will != '';
                            });
                            // $will_learn = json_decode($will_learn);
                        @endphp
                        @if ($will_learn != null)
                        
                        <div class="knowledge clearfix">
                            <h3>Bạn sẽ học được gì</h3>
                            <ul class="row">
                                @foreach ($will_learn as $will)                            
                                <li class="col-lg-6">
                                    <img src="{{ asset('frontend/images/ic_check.png') }}" alt="" /> {!! ltrim($will,";") !!}
                                </li>
                                @endforeach
                            </ul>
                        </div>
                        @endif
                        <div class="lessons clearfix">
                            {{-- <div class="col-sm-8" id="box_content"> --}}
                                    @include('components.course-lesson-list')
                            {{-- </div> --}}
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
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-12 hidden-xs">
                        <ul class="others fixed">
                            <li>
                                <img src="{{ asset('frontend/images/features_online.png') }}" alt="" /> 
                                <span class="txt-large">100% trực tuyến</span>
                                {{-- <span class="txt-small">Content comming soon...</span> --}}
                            </li>
                            <li>
                                <img src="{{ asset('frontend/images/features_deadline.png') }}" alt="" /> 
                                <span class="txt-large">Thời gian học linh hoạt</span>
                                {{-- <span class="txt-small">Content comming soon...</span> --}}
                            </li>
                            <li>
                                <img src="{{ asset('frontend/images/features_level.png') }}" alt="" /> 
                                <span class="txt-large">Cho người mới học</span>
                                {{-- <span class="txt-small">Content comming soon...</span> --}}
                            </li>
                            @if ($info_course->approx_time != '')
                            <li>
                                <img src="{{ asset('frontend/images/features_hour.png') }}" alt="" /> 
                                <span class="txt-large">Khoảng {{ $info_course->approx_time }} giờ để hoàn thành</span>
                                {{-- <span class="txt-small">Content comming soon...</span> --}}
                            </li>
                            @endif
                            <li>
                                <img src="{{ asset('frontend/images/features_subtitle.png') }}" alt="" /> 
                                <span class="txt-large">Tiếng Việt</span>
                                {{-- <span class="txt-small">Content comming soon...</span> --}}
                            </li>
                        </ul>
                        <div class="info-course-sidebar" style="height: 475px; position: relative;">
                            {{-- <div class="sidebar-content" style="position: fixed; top: 75px; width: 376.66px"> --}}
                            <div class="sidebar-fixed" id="sidebar-content">
                                <div class="u-sm-left">
                                    <div class="block-price">
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
                                            <span class="percent-price-off pull-right">-{{ (int)(100 - ($info_course->price/$info_course->real_price)*100) }}%</span>
                                        </div>
                                        @else
                                        <div class="col-sm-6 pull-left">
                                            <span class="sale">{!! number_format($info_course->price, 0, ',' , '.') !!}đ</span>
                                        </div>
                                        @endif
                                    </div>
                                    @if (!in_array($info_course->id, $list_bought))
                                    <div class="button-class clearfix">
                                        <div class="btn-add-cart">
                                            <button type="button" id="add-cart2" data-id="{{ $info_course->id }}" class="btn btn-primary btn-toh"><b>Thêm vào giỏ hàng</b></button>
                                        </div>
                                        <div class="btn-buy-now">
                                            <button type="button" id="buy-now2" data-id="{{ $info_course->id }}" class="btn btn-warning btn-toh"><b>Mua ngay</b></button>
                                        </div>
                                    </div>
                                    <div class="clearfix">
                                        <div class="text-center money-back">
                                            (Hoàn tiền trong 30 ngày nếu không hài lòng)
                                        </div>
                                    </div>
                                    @endif
                                </div>
                                <div class="u-sm-right">
                                    <div class="block-ulti">
                                        <ul style="margin-left: 0">
                                            <li><i class="far fa-clock fa-fw" aria-hidden="true"></i> Thời lượng: <b>{{ intval($info_course->duration / 60) }} giờ</b></li>
                                            <li><i class="far fa-play-circle fa-fw" aria-hidden="true"></i> Bài giảng: <b>{{ $info_course->video_count }} Videos</b></li>
                                            <li><i class="fas fa-user-graduate fa-fw" aria-hidden="true"></i> <b>{{ number_format($info_course->student_count, 0, ',' , '.') }} Học viên</b> theo học</li>                                        
                                        </ul>
                                        <div class="clearfix"></div>
                                    </div>
                                </div>
                            </div>                    
                        </div>
                        <script>
                            $(window).scroll(function() {
                            // var barHeight = $(".interactive-bar").outerHeight()
                            if ($(window).scrollTop() > 830 ) {
                                //    $(".sidebar-content").css("margin-bottom", barHeight)
                                //    $("#button").css("bottom", "-26")
                                //    console.log(barHeight);
                                
                                // $(".sidebar-content").show();
                                document.getElementById("sidebar-content").classList.add("sidebar-fixed");
                            } else {
                                document.getElementById("sidebar-content").classList.remove("sidebar-fixed");
                                // $(".sidebar-content").hide();
                                // $(".sidebar-content").css("position", "static !important")
                            }
                            });
                        </script>
                    </div>
                </div>
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
        </div>
    </div>
    @if (count($info_course->Lecturers()) >= 1)
    <div class="instructors">
        <div class="container">
            <div class="row" id="box_instructors">
                <div class="col-sm-12">
                    <h3>Thông tin giảng viên</h3>
                </div>
                @foreach ($info_course->Lecturers() as $lecturer)
                @if($lecturer->teacher)
                <div class="col-md-8 col-sm-10">
                    <div class="row">
                        <div class="col-sm-3 avatar-center">
                            <a href="{{ url('/') }}/teacher/{{ $lecturer->teacher->id }}" title="{{ $lecturer->user->name }}" >
                                <!-- <img class="avatar" alt="{{ $lecturer->user->name }}" src="{{ asset('frontend/'.$lecturer->user->avatar) }}"> -->
                                <img class="avatar" alt="{{ $lecturer->user->name }}" src="{{ $lecturer->user->avatar }}">
                            </a>
                        </div>
                        <div class="col-sm-9">
                            <div class="detail-info">
                                <p class="name"><a href="{{ url('/') }}/teacher/{{ $lecturer->teacher->id }}" title="{{ $lecturer->user->name }}" >{{ $lecturer->user->name }}</a></p>
                                <p class="expret">{{ $lecturer->teacher->expert }}</p>
                                <div class="frame clearfix">
                                    <div class="pull-left">
                                        <img src="{{ asset('frontend/images/ic_course.png') }}" alt="" /> 
                                        <span class="special">{{ $lecturer->teacher->course_count }} Khóa học</span>
                                    </div>
                                    {{-- <div class="pull-right">
                                        @include(
                                            'components.vote', 
                                            [
                                                'rate' => $lecturer->teacher->rating_score,
                                                'rating_number' => $lecturer->teacher->vote_count,
                                                'rating_txt' => true,
                                            ]
                                        )
                                    </div> --}}
                                </div>
                                <div class="">
                                    <img src="{{ asset('frontend/images/ic_student.png') }}" alt="" /> 
                                    <span class="special">{{ $lecturer->teacher->student_count }} Học viên</span>
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
    </div>
    @endif
    <div class="container">
        <div class="course-learning-review">
            <div class="feedback clearfix">
                <div class="col-sm-4 student-rating">
                    <h3>Đánh giá của học viên</h3>
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
                    <p>Đánh giá khóa học</p>
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
            <div class="reviews"  id="box_reviews">
                <h3>Nhận xét của học viên
                    {{-- @if(Auth::check()) --}}
                        @if(\App\Helper\Helper::getUserRoleOfCourse($info_course->id))
                            <span class="reviews-star" data-star="{{ isset($ratingCourse) ? $ratingCourse->score : 1 }}">
                                @if($ratingCourse)
                                @include(
                                    'components.vote', 
                                    [
                                        'rate' => $ratingCourse->score,
                                    ]
                                )
                                @else
                                <i id="star-1" class="fa fa-star yellow-color" data-id="1"></i>
                                <i id="star-2" class="far fa-star review-star" data-id="2"></i>
                                <i id="star-3" class="far fa-star review-star" data-id="3"></i>
                                <i id="star-4" class="far fa-star review-star" data-id="4"></i>
                                <i id="star-5" class="far fa-star review-star" data-id="5"></i>
                                @endif
                            </span>
                        @endif
                    {{-- @else
                    Đăng nhập để xem nhận xét của các học viên khác
                    @endif --}}
                </h3>
                {{-- @if(Auth::check()) --}}
                @if(\App\Helper\Helper::getUserRoleOfCourse($info_course->id))
                <textarea name="content" id="editor" class="form-control" placeholder="Nội dung"></textarea>
                <div class="btn-submit text-center mt-10 mb-20">
                    <input class="btn btn-primary submit-question" type="submit" value="Gửi nhận xét" id="create-comment-new"/>
                </div>
                <script>
                    var baseURL = $('base').attr('href');

                    function hideStar(){
                        for(var j = 1; j <= 5; j++){
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
                        showStar($(this).attr('data-id'))
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
                        var request = $.ajax({
                            url: baseURL + '/reviews/store',
                            method: "POST",
                            data: {
                                course_id: {{ $info_course->id }},
                                content : $('#editor').val(),
                                score: $('.reviews-star').attr('data-star')
                            },
                            dataType: "json"
                        });

                        request.done(function( data ) {
                            if(data.status == 200){
                                var html = "";
                                var htmlRate = $('.reviews-star').html();
                                html += '<div class="box clearfix">';
                                    html += '<div class="col-sm-3">';
                                        html += '<img class="avatar" src="'+baseURL + '/frontend/' + data.commentCourse.data.avatar +'" alt="">';
                                        html += '<div class="info-account">';
                                            html += '<p class="interval">' + data.commentCourse.data.created_at +'</p>';
                                            html += '<p class="name">' + data.commentCourse.data.username +'</p>';
                                        html += '</div>';
                                    html += '</div>';
                                    html += '<div class="col-sm-9">';
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
                            }
                        });

                        request.fail(function( jqXHR, textStatus ) {
                            alert( "Request failed: " + textStatus );
                        });
                    });
                </script>
                @endif
                {{-- @else
                <h4>Đăng nhập để xem đánh giá</h4>
                @endif --}}
                <div id="review-box">
                    @foreach($info_course->takeComment(0, 3) as $comment)
                        @include('components.question-answer', ['comment' => $comment])
                    @endforeach
                </div>
            </div>
            @if(count($info_course->comments) > 0)
            <div class="col-sm-12 btn-see-more" data-skip="3" data-take="3">
                <button type="button" class="btn">Xem thêm</button>
            </div>
            @endif
        </div>
    </div>
    <div class="related-course">
        <div class="container">
            @include('frontends.related-course')
        </div>
    </div>

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
            @if (!in_array($info_course->id, $list_bought))
            <div class="buttons col-xs-12 col-md-4 col-sm-5">
                <div class="group-btn-buy-course">
                    <button class="btn btn-primary">Thêm vào giỏ hàng</button>
                    <button class="btn btn-warning">Mua ngay</button>
                </div>
            </div>
            @endif
        </div>
    </div>
    <script>
        $(window).scroll(function() {
            var barHeight = $(".interactive-bar").outerHeight()
                if ($(window).scrollTop() > 300) {
                    $("footer .item-2").css("margin-bottom", barHeight)
                    $("#button").css("bottom", "-26")
                    console.log(barHeight);
                    
                    $(".interactive-bar").fadeIn();
                } else {
                    $(".interactive-bar").fadeOut();
                    $("footer .item-2").css("margin-bottom", "0 !important")
                }
        });
    </script>
</div>
<script type="text/javascript">
    
    $(document).ready(function() { 
        $(".interactive-bar .buttons button:first-child").click(function(){
            $(".btn-add-cart button").click();
        })
        $(".interactive-bar .buttons button:last-child").click(function(){
            addCard();
            window.location.replace("/cart/payment/method-selector")
        })
        $("#buy-now").click(function(){
            addCard();
            window.location.replace("/cart/payment/method-selector")
        })
        $("#buy-now2").click(function(){
            addCard();
            window.location.replace("/cart/payment/method-selector")
        })
        // $('#add-cart').click(function(){
        // function addCard(){
        //     var item = {
        //         'id' : {!! $info_course->id !!},
        //         'image' : '{!! $info_course->image !!}',
        //         'slug' : '{!! $info_course->slug !!}',                
        //         @if(count($info_course->Lecturers()) > 0)
        //         'lecturer' : "{!! $info_course->Lecturers()[0]->user->name !!}",
        //         @else
        //         'lecturer' : 'Nhiều giảng viên',
        //         @endif
        //         'name' : "{!! $info_course->name !!}",
        //         'price' : {!! $info_course->price !!},
        //         'real_price' : {!! $info_course->real_price !!},
        //     }

        //     if (localStorage.getItem("cart") != null) {
        //         var list_item = JSON.parse(localStorage.getItem("cart"));
        //         addItem(list_item, item);
        //         localStorage.setItem("cart", JSON.stringify(list_item));
        //     }else{
        //         var list_item = [];
        //         addItem(list_item, item);
        //         localStorage.setItem("cart", JSON.stringify(list_item));
        //     }

        //     var number_items_in_cart = JSON.parse(localStorage.getItem('cart'))
        //         // alert(number_items_in_cart.length)
        //     $('.number-in-cart').text(number_items_in_cart.length);
        // }

        $('.btn-see-more').click(function(){
            var current_skip = $(this).attr('data-skip');
            var current_take = $(this).attr('data-take');
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

            request.done(function( data ) {
                if(data == ''){
                    $('.btn-see-more').hide();    
                }
                $('.btn-see-more').attr('data-skip', current_skip + current_take);
                $('#review-box').append(data);
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

        $('.create-reply-btn').on('click', function (e) {
            var comment_id = $(this).attr('data-id');
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
                    var html = "";
                    html += '<div class="comment-reply">';
                        html += '<div>';
                            html += '<img class="avatar" src="'+baseURL + '/' + data.commentCourse.data.avatar +'" alt="" />';
                            html += '<div class="info-account">';
                                html += '<p class="interval">' + data.commentCourse.data.created_at +'</p>';
                                html += '<p class="name">' + data.commentCourse.data.username +'</p>';
                            html += '</div>';
                        html += '</div>';
                        html += '<div class="comment">';
                            html += data.commentCourse.data.content;
                        html += '</div>';
                    html += '</div>';

                    $('.reply-hold-' + comment_id).prepend(html);
                }
            });

            request.fail(function( jqXHR, textStatus ) {
                alert( "Request failed: " + textStatus );
            });
        });
    }

    jQuery(function () {
        $(".btn-add-cart button").click( function(e){
            e.stopPropagation()
            e.preventDefault()

            $(this).remove();
            $(".btn-buy-now button").remove();
            $('.interactive-bar').remove();
            Swal.fire({
                type: 'success',
                text: 'Đã thêm vào giỏ hàng!'
            })
            addCard();
        })

        if(localStorage.getItem('cart') != null){
            var number_items_in_cart = JSON.parse(localStorage.getItem('cart'))

            $.each( number_items_in_cart, function(i, obj) {
                $('button[data-id='+obj.id+']').remove();
                $('.interactive-bar[data-i='+obj.id+']').remove();
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

    function addCard(){
            var item = {
                'id' : {!! $info_course->id !!},
                'image' : '{!! $info_course->image !!}',
                'slug' : '{!! $info_course->slug !!}',                
                @if(count($info_course->Lecturers()) > 0)
                'lecturer' : "{!! $info_course->Lecturers()[0]->user->name !!}",
                @else
                'lecturer' : 'Nhiều giảng viên',
                @endif
                'name' : "{!! $info_course->name !!}",
                'price' : {!! $info_course->price !!},
                'real_price' : {!! $info_course->real_price !!},
                'coupon_price' : {!! $info_course->price !!},
                'coupon_code' : '',
            }

            if (localStorage.getItem("cart") != null) {
                var list_item = JSON.parse(localStorage.getItem("cart"));
                addItem(list_item, item);
                localStorage.setItem("cart", JSON.stringify(list_item));
            }else{
                var list_item = [];
                addItem(list_item, item);
                localStorage.setItem("cart", JSON.stringify(list_item));
            }

            var number_items_in_cart = JSON.parse(localStorage.getItem('cart'))
                // alert(number_items_in_cart.length)
            $('.number-in-cart').text(number_items_in_cart.length);
        }
</script>
@endsection