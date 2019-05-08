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
                                <p class="name">Bảo Minh</p>
                                <p class="expret">PHP, Jquery, Agular Js, Vue Js, NodeJs</p>
                            </div>
                        </div>
                        <div class="network pull-right">
                            <button type="button" class="btn btn-default btn-xs">
                                <img src="{{ asset('frontend/images/ic_share.png') }}" alt="" />
                                <span>Share</span>
                            </button>
                            <button type="button" class="btn btn-default btn-xs">
                                <img src="{{ asset('frontend/images/ic_facebook.png') }}" alt="" />
                                <span>Facebook</span>
                            </button>
                        </div>
                    </div>
                    <div class="frame_2">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="box clearfix">
                                    <div class="pull-left">
                                        <span class="sale">15,99 $</span>
                                        <span class="price">15,00 $</span>
                                        <span class="interval">3 days left off the price!</span>
                                    </div>
                                    <div class="pull-right">
                                        <span class="price-off">95% off</span>
                                    </div>
                                </div>
                                <div class="box clearfix">
                                    <div class="pull-left">
                                        <img src="{{ asset('frontend/images/ic_duration.png') }}" alt="" />  <span class="special">22 Courses</span>
                                    </div>
                                    <div class="pull-right">
                                        <img src="{{ asset('frontend/images/ic_download.png') }}" alt="" />  <span class="special">22 Courses</span>
                                    </div>
                                </div>
                                <div class="box clearfix">
                                    <div class="pull-left">
                                        <img src="{{ asset('frontend/images/ic_course.png') }}" alt="" /> 
                                        <span class="special">22 Courses</span>
                                        &nbsp &nbsp<img src="{{ asset('frontend/images/icon_student.png') }}" alt="" /> 
                                        <span class="special">11.112 Students</span>                                        
                                    </div>
                                    <div class="pull-right">
                                        <span class="star-rate">
                                            <i class="fa fa-star co-or" aria-hidden="true"></i><i class="fa fa-star co-or" aria-hidden="true"></i><i class="fa fa-star co-or" aria-hidden="true"></i><i class="fa fa-star co-or" aria-hidden="true"></i><i class="fa fa-star co-or" aria-hidden="true"></i>                </span>
                                            <span class="n-rate">4.5 (<span>11.990 ratings</span>)</span>
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
                                            30 Day Money
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
                            <p>Bạn muốn làm việc tại công ty Hàn Quốc với mức THU NHẬP KHỦNG? Hay bạn đang làm việc tại một công ty Hàn Quốc và muốn có cơ thêm CƠ HỘI THĂNG TIẾN trong công việc cũng như có thể trò chuyện, GIAO TIẾP cùng người Hàn Quốc trong công ty?</p>
                        </div>
                        <div class="knowledge clearfix">
                            <h3>What you'll learn</h3>
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
                            <h3>Skills you'll again</h3>
                            <ul>
                                <li>PHP</li>
                                <li>C#</li>
                                <li>Java</li>
                                <li>Jquey</li>
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
                        <div class="u-list-course" id="u-list-course">
                            <div class="top clearfix">
                                <h3 class="pull-left">Courses Lessions</h3>
                                <ul class="pull-right">
                                    <li>Expand all</li>
                                    <li>80 lectures</li>
                                    <li>15:58:20</li>
                                </ul>
                            </div>
                            <div class="content">
                                <div class="panel-group" id="accordion">
                                    <div class="panel panel-default">
                                        <!-- phần -->
                                        <div class="panel-heading">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <h4 class="panel-title">
                                                        <a data-toggle="collapse" data-parent="#accordion" href="#collapse1" class="collapsed" aria-expanded="true"><i class="fa fa-minus-square" aria-hidden="true"></i> Phần 1: Phát âm, bảng chữ cái</a>
                                                    </h4>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- bài -->
                                        <div id="collapse1" class="panel-collapse collapse in" aria-expanded="true">
                                            <div class="panel-body">
                                                <div class="col">
                                                    <div class="container-fluid">
                                                        <div class="row">
                                                            <div class="col-xs-5 col-md-8">
                                                                <div class="title">
                                                                    <a>
                                                                        <i class="fa fa-play-circle" aria-hidden="true"></i>
                                                                    Bài 1: Nguyên âm </a>
                                                                </div>
                                                            </div>
                                                            <div class="col-xs-4 col-md-2">
                                                                <div class="link">
                                                                    &nbsp;
                                                                    <a class="btn-preview" href="javascript:void(0)" onclick="preview_freetrial(24337);">Free Trial</a>
                                                                </div>
                                                            </div>
                                                            <div class="col-xs-3 col-md-2">
                                                                <div class="time">00:05:19</div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <div class="container-fluid">
                                                        <div class="row">
                                                            <div class="col-xs-5 col-md-8">
                                                                <div class="title">
                                                                    <a>
                                                                        <i class="fa fa-play-circle" aria-hidden="true"></i>
                                                                    Bài 2: Phụ âm</a>
                                                                </div>
                                                            </div>
                                                            <div class="col-xs-4 col-md-2">
                                                                <div class="link">
                                                                    &nbsp;
                                                                    <a class="btn-preview" href="javascript:void(0)" onclick="preview_freetrial(24338);">Free Trial</a>
                                                                </div>
                                                            </div>
                                                            <div class="col-xs-3 col-md-2">
                                                                <div class="time">00:05:47</div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <div class="container-fluid">
                                                        <div class="row">
                                                            <div class="col-xs-5 col-md-8">
                                                                <div class="title">
                                                                    <a>
                                                                        <i class="fa fa-play-circle" aria-hidden="true"></i>
                                                                    Bài 3: Phân biệt phát âm phụ âm nhẹ, phụ âm đôi và phụ âm bật hơi</a>
                                                                </div>
                                                            </div>
                                                            <div class="col-xs-4 col-md-2">
                                                                <div class="link">
                                                                    &nbsp;
                                                                </div>
                                                            </div>
                                                            <div class="col-xs-3 col-md-2">
                                                                <div class="time">00:03:04</div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <div class="container-fluid">
                                                        <div class="row">
                                                            <div class="col-xs-5 col-md-8">
                                                                <div class="title">
                                                                    <a>
                                                                        <i class="fa fa-play-circle" aria-hidden="true"></i>
                                                                    Bài 4: Cách phát âm patchim (Phụ âm cuối)</a>
                                                                </div>
                                                            </div>
                                                            <div class="col-xs-4 col-md-2">
                                                                <div class="link">
                                                                    &nbsp;
                                                                    <a class="btn-preview" href="javascript:void(0)" onclick="preview_freetrial(24340);">Free Trial</a>
                                                                </div>
                                                            </div>
                                                            <div class="col-xs-3 col-md-2">
                                                                <div class="time">00:04:14</div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <div class="container-fluid">
                                                        <div class="row">
                                                            <div class="col-xs-5 col-md-8">
                                                                <div class="title">
                                                                    <a>
                                                                        <i class="fa fa-play-circle" aria-hidden="true"></i>
                                                                    Bài 5: Ghép chữ và đánh vần như tiếng Việt </a>
                                                                </div>
                                                            </div>
                                                            <div class="col-xs-4 col-md-2">
                                                                <div class="link">
                                                                    &nbsp;
                                                                </div>
                                                            </div>
                                                            <div class="col-xs-3 col-md-2">
                                                                <div class="time">00:01:43</div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <div class="container-fluid">
                                                        <div class="row">
                                                            <div class="col-xs-5 col-md-8">
                                                                <div class="title">
                                                                    <a>
                                                                        <i class="fa fa-play-circle" aria-hidden="true"></i>
                                                                    Bài 6: Cách nối âm và thứ tự câu trong tiếng Hàn</a>
                                                                </div>
                                                            </div>
                                                            <div class="col-xs-4 col-md-2">
                                                                <div class="link">
                                                                    &nbsp;
                                                                    <a class="btn-preview" href="javascript:void(0)" onclick="preview_freetrial(24342);">Free Trial</a>
                                                                </div>
                                                            </div>
                                                            <div class="col-xs-3 col-md-2">
                                                                <div class="time">00:01:44</div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="panel panel-default">
                                        <!-- phần -->
                                        <div class="panel-heading">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <h4 class="panel-title">
                                                        <a data-toggle="collapse" data-parent="#accordion" href="#collapse2" class="collapsed" aria-expanded="true"><i class="fa fa-minus-square" aria-hidden="true"></i> Phần 2: Giới thiệu bản thân</a>
                                                    </h4>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- bài -->
                                        <div id="collapse2" class="panel-collapse collapse" aria-expanded="true">
                                            <div class="panel-body">
                                                <div class="col">
                                                    <div class="container-fluid">
                                                        <div class="row">
                                                            <div class="col-xs-5 col-md-8">
                                                                <div class="title">
                                                                    <a>
                                                                        <i class="fa fa-play-circle" aria-hidden="true"></i>
                                                                    Bài 9: Quốc gia, nghề nghiệp</a>
                                                                </div>
                                                            </div>
                                                            <div class="col-xs-4 col-md-2">
                                                                <div class="link">
                                                                    &nbsp;
                                                                </div>
                                                            </div>
                                                            <div class="col-xs-3 col-md-2">
                                                                <div class="time">00:04:46</div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tags">
                                <div class="pull-left">
                                Tags</span>
                                <ul class="pull-right">
                                    <li>PHP</li>
                                    <li>C#</li>
                                    <li>Java</li>
                                    <li>Jquey</li>
                                </ul>
                            </div>
                        </div>
                    </div>
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
                    <h3>About the instructors</h3>
                </div>
                <div class="col-sm-6">
                    <div class="row">
                        <div class="col-sm-3">
                            <img class="avatar" src="https://www.w3schools.com/howto/img_avatar.png" alt="" />
                        </div>
                        <div class="col-sm-9">
                            <div class="detail-info">
                                <p class="name">Bảo Minh</p>
                                <p class="expret">PHP, Jquery, Agular Js, Vue Js, NodeJs</p>
                                <div class="frame clearfix">
                                    <div class="pull-left">
                                        <img src="{{ asset('frontend/images/ic_course.png') }}" alt="" /> 
                                        <span class="special">22 Courses</span>
                                    </div>
                                    <div class="pull-right">
                                        <span class="star-rate">
                                            <i class="fa fa-star co-or" aria-hidden="true"></i><i class="fa fa-star co-or" aria-hidden="true"></i><i class="fa fa-star co-or" aria-hidden="true"></i><i class="fa fa-star co-or" aria-hidden="true"></i><i class="fa fa-star co-or" aria-hidden="true"></i>
                                        </span>
                                        <span class="n-rate">4.5 (<span>11.990 ratings</span>)</span>
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
                            <img class="avatar" src="https://www.w3schools.com/howto/img_avatar.png" alt="" />
                        </div>
                        <div class="col-sm-9">
                            <div class="detail-info">
                                <p class="name">Bảo Minh</p>
                                <p class="expret">PHP, Jquery, Agular Js, Vue Js, NodeJs</p>
                                <div class="frame clearfix">
                                    <div class="pull-left">
                                        <img src="{{ asset('frontend/images/ic_course.png') }}" alt="" /> 
                                        <span class="special">22 Courses</span>
                                    </div>
                                    <div class="pull-right">
                                        <span class="star-rate">
                                            <i class="fa fa-star co-or" aria-hidden="true"></i><i class="fa fa-star co-or" aria-hidden="true"></i><i class="fa fa-star co-or" aria-hidden="true"></i><i class="fa fa-star co-or" aria-hidden="true"></i><i class="fa fa-star co-or" aria-hidden="true"></i>
                                        </span>
                                        <span class="n-rate">4.5 (<span>11.990 ratings</span>)</span>
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
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row" id="box_reviews">
            <div class="feedback clearfix">
                <div class="col-sm-4 student-rating">
                    <h3>Students Feedback</h3>
                    <p class="number">5</p>
                    <p class="star">
                        <span class="star-rate">
                            <i class="fa fa-star co-or" aria-hidden="true"></i>
                            <i class="fa fa-star co-or" aria-hidden="true"></i>
                            <i class="fa fa-star co-or" aria-hidden="true"></i>
                            <i class="fa fa-star co-or" aria-hidden="true"></i>
                            <i class="fa fa-star co-or" aria-hidden="true"></i>                
                        </span>
                    </p>
                    <p>Course Rating</p>
                </div>
                <div class="col-sm-8">
                    <div class="row">
                        <div class="item-progress">
                            <div class="col-sm-9">
                                <div class="progress">
                                    <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="40"
                                    aria-valuemin="0" aria-valuemax="100" style="width:40%"></div>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <span class="star-rate">
                                    <i class="fa fa-star co-or" aria-hidden="true"></i>
                                    <i class="fa fa-star co-or" aria-hidden="true"></i>
                                    <i class="fa fa-star co-or" aria-hidden="true"></i>
                                    <i class="fa fa-star co-or" aria-hidden="true"></i>
                                    <i class="fa fa-star co-or" aria-hidden="true"></i>                
                                </span>
                                <span class="percent-rating">80%</span>
                            </div>
                        </div>
                        <div class="item-progress">
                            <div class="col-sm-9">
                                <div class="progress">
                                    <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="40"
                                    aria-valuemin="0" aria-valuemax="100" style="width:40%"></div>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <span class="star-rate">
                                    <i class="fa fa-star co-or" aria-hidden="true"></i>
                                    <i class="fa fa-star co-or" aria-hidden="true"></i>
                                    <i class="fa fa-star co-or" aria-hidden="true"></i>
                                    <i class="fa fa-star co-or" aria-hidden="true"></i>
                                    <i class="fa fa-star co-or" aria-hidden="true"></i>                
                                </span>
                                <span class="percent-rating">80%</span>
                            </div>
                        </div>
                        <div class="item-progress">
                            <div class="col-sm-9">
                                <div class="progress">
                                    <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="40"
                                    aria-valuemin="0" aria-valuemax="100" style="width:40%"></div>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <span class="star-rate">
                                    <i class="fa fa-star co-or" aria-hidden="true"></i>
                                    <i class="fa fa-star co-or" aria-hidden="true"></i>
                                    <i class="fa fa-star co-or" aria-hidden="true"></i>
                                    <i class="fa fa-star co-or" aria-hidden="true"></i>
                                    <i class="fa fa-star co-or" aria-hidden="true"></i>                
                                </span>
                                <span class="percent-rating">80%</span>
                            </div>
                        </div>
                        <div class="item-progress">
                            <div class="col-sm-9">
                                <div class="progress">
                                    <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="40"
                                    aria-valuemin="0" aria-valuemax="100" style="width:40%"></div>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <span class="star-rate">
                                    <i class="fa fa-star co-or" aria-hidden="true"></i>
                                    <i class="fa fa-star co-or" aria-hidden="true"></i>
                                    <i class="fa fa-star co-or" aria-hidden="true"></i>
                                    <i class="fa fa-star co-or" aria-hidden="true"></i>
                                    <i class="fa fa-star co-or" aria-hidden="true"></i>                
                                </span>
                                <span class="percent-rating">80%</span>
                            </div>
                        </div>
                        <div class="item-progress">
                            <div class="col-sm-9">
                                <div class="progress">
                                    <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="40"
                                    aria-valuemin="0" aria-valuemax="100" style="width:40%"></div>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <span class="star-rate">
                                    <i class="fa fa-star co-or" aria-hidden="true"></i>
                                    <i class="fa fa-star co-or" aria-hidden="true"></i>
                                    <i class="fa fa-star co-or" aria-hidden="true"></i>
                                    <i class="fa fa-star co-or" aria-hidden="true"></i>
                                    <i class="fa fa-star co-or" aria-hidden="true"></i>                
                                </span>
                                <span class="percent-rating">80%</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="reviews">
                <h3>Reviews</h3>
                <div class="box clearfix">
                    <div class="col-sm-3">
                        <img class="avatar" src="https://www.w3schools.com/howto/img_avatar.png" alt="" />
                        <div class="info-account">
                            <p class="interval">1 week ago</p>
                            <p class="name">Bảo Minh</p>
                        </div>
                    </div>
                    <div class="col-sm-9">
                        <span class="star-rate">
                            <i class="fa fa-star co-or" aria-hidden="true"></i>
                            <i class="fa fa-star co-or" aria-hidden="true"></i>
                            <i class="fa fa-star co-or" aria-hidden="true"></i>
                            <i class="fa fa-star co-or" aria-hidden="true"></i>
                            <i class="fa fa-star co-or" aria-hidden="true"></i>                
                        </span>
                        <p class="comment">
                            Khóa học em học được rất tốt rất dễ hiểu và em sẽ học lâu dài ở đây ạ. Khóa học em học được rất tốt rất dễ hiểu và em sẽ học lâu dài ở đây ạ
                        </p>
                        <div class="btn-action">
                            <button type="button" class="btn btn-default">
                                <i class="fas fa-comment"></i>
                                <span>Share</span>
                            </button>
                            <button type="button" class="btn btn-default">
                                <i class="fas fa-thumbs-up"></i>
                                <span>Reply</span>
                            </button>
                            <button type="button" class="btn btn-default">
                                <i class="fas fa-thumbs-down"></i>
                                <span>Dislike</span>
                            </button>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <hr>
                    </div>
                </div>
                <div class="box clearfix">
                    <div class="col-sm-3">
                        <img class="avatar" src="https://www.w3schools.com/howto/img_avatar.png" alt="" />
                        <div class="info-account">
                            <p class="interval">1 week ago</p>
                            <p class="name">Bảo Minh</p>
                        </div>
                    </div>
                    <div class="col-sm-9">
                        <span class="star-rate">
                            <i class="fa fa-star co-or" aria-hidden="true"></i>
                            <i class="fa fa-star co-or" aria-hidden="true"></i>
                            <i class="fa fa-star co-or" aria-hidden="true"></i>
                            <i class="fa fa-star co-or" aria-hidden="true"></i>
                            <i class="fa fa-star co-or" aria-hidden="true"></i>                
                        </span>
                        <p class="comment">
                            Khóa học em học được rất tốt rất dễ hiểu và em sẽ học lâu dài ở đây ạ. Khóa học em học được rất tốt rất dễ hiểu và em sẽ học lâu dài ở đây ạ
                        </p>
                        <div class="btn-action">
                            <button type="button" class="btn btn-default">
                                <i class="fas fa-comment"></i>
                                <span>Share</span>
                            </button>
                            <button type="button" class="btn btn-default">
                                <i class="fas fa-thumbs-up"></i>
                                <span>Reply</span>
                            </button>
                            <button type="button" class="btn btn-default">
                                <i class="fas fa-thumbs-down"></i>
                                <span>Dislike</span>
                            </button>
                        </div>
                        <div class="comment-reply">
                            <div>
                                <img class="avatar" src="https://www.w3schools.com/howto/img_avatar.png" alt="" />
                                <div class="info-account">
                                    <p class="interval">1 week ago</p>
                                    <p class="name">Bảo Minh</p>
                                </div>
                            </div>
                            <p class="comment">
                                Khóa học em học được rất tốt rất dễ hiểu và em sẽ học lâu dài ở đây ạ. Khóa học em học được rất tốt rất dễ hiểu và em sẽ học lâu dài ở đây ạ
                            </p>
                            <div class="btn-action">
                                <button type="button" class="btn btn-default">
                                    <i class="fas fa-comment"></i>
                                    <span>Share</span>
                                </button>
                                <button type="button" class="btn btn-default">
                                    <i class="fas fa-thumbs-up"></i>
                                    <span>Reply</span>
                                </button>
                                <button type="button" class="btn btn-default">
                                    <i class="fas fa-thumbs-down"></i>
                                    <span>Dislike</span>
                                </button>
                            </div>
                        </div>
                        <div class="comment-reply">
                            <div>
                                <img class="avatar" src="https://www.w3schools.com/howto/img_avatar.png" alt="" />
                                <div class="info-account">
                                    <p class="interval">1 week ago</p>
                                    <p class="name">Bảo Minh</p>
                                </div>
                            </div>
                            <p class="comment">
                                Khóa học em học được rất tốt rất dễ hiểu và em sẽ học lâu dài ở đây ạ. Khóa học em học được rất tốt rất dễ hiểu và em sẽ học lâu dài ở đây ạ
                            </p>
                            <div class="btn-action">
                                <button type="button" class="btn btn-default">
                                    <i class="fas fa-comment"></i>
                                    <span>Share</span>
                                </button>
                                <button type="button" class="btn btn-default">
                                    <i class="fas fa-thumbs-up"></i>
                                    <span>Reply</span>
                                </button>
                                <button type="button" class="btn btn-default">
                                    <i class="fas fa-thumbs-down"></i>
                                    <span>Dislike</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
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