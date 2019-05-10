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
                                <p class="name">Linux Troubleshooting Course with Practical Examples</p>
                            </div>
                        </div>
                    </div>
                    <div class="frame clearfix">
                        <div class="pull-left">
                            <div class="info">
                                <p class="expret">Linux Troubleshooting and Administration</p>
                            </div>
                        </div>
                        <div class="network pull-right">
							<button type="button" class="btn btn-default btn-xs">
								<i class="fas fa-share-alt"></i> Share
							</button>
							<button type="button" class="btn btn-default btn-xs">
								<i class="fab fa-facebook-square"></i> Facebook
							</button>
						</div>
                    </div>
                    <div class="frame_2">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="row box clearfix">
                                    <div class="col-sm-6 pull-left">
                                        <span class="sale">15,99 $</span>
                                        <span class="price">15,00 $</span>
                                        <span class="interval">3 days left off the price!</span>
                                    </div>
                                    <div class="col-sm-6">
                                        <span class="price-off pull-right">95% off</span>
                                    </div>
                                </div>
                                <div class="row box clearfix">
                                    <div class="col-sm-6 pull-left">
                                        <img src="{{ asset('frontend/images/ic_duration.png') }}" class="icon" alt="" />  <span class="special">13 hours on-demand video</span>
                                    </div>
                                    <div class="col-sm-6 pull-right">
                                        <img src="{{ asset('frontend/images/ic_download.png') }}" class="icon" alt="" />  <span class="special">3 downloadable resources</span>
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
                                        <span class="special">22 Courses</span>
                                        &nbsp &nbsp<img src="{{ asset('frontend/images/icon_student.png') }}" class="icon" alt="" /> 
                                        <span class="special">11.112 Students</span>                                        
                                    </div>
                                    <div class="col-sm-6 pull-right">
                                        @include(
                                            'components.vote', 
                                            [
                                                'rate' => 2,
                                                'rating_number' => 3500,
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
                        <h2>Descriptions</h2>
                        <p>Bạn muốn làm việc tại công ty Hàn Quốc với mức THU NHẬP KHỦNG? Hay bạn đang làm việc tại một công ty Hàn Quốc và muốn có cơ thêm CƠ HỘI THĂNG TIẾN trong công việc cũng như có thể trò chuyện, GIAO TIẾP cùng người Hàn Quốc trong công ty?</p>
                    </div>
                    <div class="knowledge clearfix">
                        <h2>What you'll learn</h2>
                        <ul>
                            <li>
                                <img src="{{ asset('frontend/images/ic_check.png') }}" alt="" /> Bạn đang học tiếng Hàn, nhưng ngại giao tiếp với người Hàn Quốc
                            </li>
                            <li>
                                <img src="{{ asset('frontend/images/ic_check.png') }}" alt="" /> Bạn đang học tiếng Hàn, nhưng ngại giao tiếp với người Hàn Quốc
                            </li>
                            <li>
                                <img src="{{ asset('frontend/images/ic_check.png') }}" alt="" /> Bạn đang học tiếng Hàn, nhưng ngại giao tiếp với người Hàn Quốc
                            </li>
                            <li>
                                <img src="{{ asset('frontend/images/ic_check.png') }}" alt="" /> Bạn đang học tiếng Hàn, nhưng ngại giao tiếp với người Hàn Quốc
                            </li>
                        </ul>
                    </div>
                    <div class="skill">
                        <h2>Skills you'll again</h2>
                        <ul>
                            <li>PHP</li>
                            <li>C#</li>
                            <li>Java</li>
                            <li>Jquery</li>
                        </ul>
                    </div>
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
                        <li>
                            <img src="{{ asset('frontend/images/features_hour.png') }}" alt="" /> 
                            <span class="txt-large">Approx 7 hours to complete</span>
                            <span class="txt-small">Content comming soon...</span>
                        </li>
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
                <div class="col-sm-4">
                    <div class="requirement" id="box_requirements">
                        <h3>Requirement</h3>
                        <ul>
                            <li>Là người thành lập trang Fanpage dạy tiếng Hàn miễn phí</li>
                            <li>Là người thành lập trang Fanpage dạy tiếng Hàn miễn phí</li>
                            <li>Là người thành lập trang Fanpage dạy tiếng Hàn miễn phí</li>
                            <li>Là người thành lập trang Fanpage dạy tiếng Hàn miễn phí</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="instructors">
        <div class="container">
            <div class="row" id="box_instructors">
                <div class="col-sm-12">
                    <h2>About the instructors</h2>
                </div>
                <div class="col-sm-6">
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
                                            <img src="{{ asset('frontend/images/ic_course.png') }}" alt="" /> 
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
                                        <img src="{{ asset('frontend/images/icon_student.png') }}" alt="" /> 
                                        <span class="special">11.112 Students</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <div class="col-sm-6">
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
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="course-learning-review">
            <div class="feedback clearfix">
                <div class="col-sm-4 student-rating">
                    <h2>Students Feedback</h2>
                    <p class="number">5</p>
                    <p class="star">
                        @include(
                            'components.vote', 
                            [
                                'rate' => 2,
                            ]
                        )
                    </p>
                    <p>Course Rating</p>
                </div>
                <div class="col-sm-8 rating-process">
                    <div class="row">
                        @for ($i = 0; $i <5; $i++)
                        <div class="item-progress">
                            <div class="col-sm-9">
                                <div class="progress">
                                    <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="40"
                                        aria-valuemin="0" aria-valuemax="100" style="width:40%"></div>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                @include(
                                    'components.vote', 
                                    [
                                        'rate' => 2,
                                    ]
                                )
                                <span class="percent-rating">80%</span>
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