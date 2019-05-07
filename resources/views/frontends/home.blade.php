@extends('frontends.layouts.app')
@section('content')
<div class="banner">
    <img class="pd-mb-banner hidden-xs" src="https://cms.unica.vn/upload/images/65055147_30-4-1-5-chao-mung-dai-le-hoc-ngay-keo-tre-chi-249k-khoa_thumb.png" width="100%" alt="30/4 -1/5: Chào mừng đại lễ - Học ngay kẻo trễ [Chỉ 249k/khóa]">
    <div class="container">
        <div class="col-md-12">
            <div class="slick-course">
                <div class="item text-center"  style="margin:0 8px;width: 330px" class="slick-slide">
                    <img src="{{ asset('frontend/images/slide_design.png') }}" alt=""/>
                    <div class="cat">
                        <h2>GYM</h2>
                        <p>Comming soon</p>
                    </div>
                </div>
                <div class="item text-center"  style="margin:0 8px;width: 330px" class="slick-slide">
                    <img src="{{ asset('frontend/images/slide_design.png') }}" alt=""/>
                    <div class="cat">
                        <h2>GYM</h2>
                        <p>Comming soon</p>
                    </div>
                </div>
                <div class="item text-center"  style="margin:0 8px;width: 330px" class="slick-slide">
                    <img src="{{ asset('frontend/images/slide_design.png') }}" alt=""/>
                    <div class="cat">
                        <h2>GYM</h2>
                        <p>Comming soon</p>
                    </div>
                </div>
                <div class="item text-center"  style="margin:0 8px;width: 330px" class="slick-slide">
                    <img src="{{ asset('frontend/images/slide_design.png') }}" alt=""/>
                    <div class="cat">
                        <h2>GYM</h2>
                        <p>Comming soon</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $(document).ready(function(){
          $('.slick-course').slick({
            dots: false,
            infinite: true,
            speed: 1000,
            slidesToShow: 1,
            centerMode: true,
            variableWidth: true,
            centerPadding: '0px',
            prevArrow: false,
            nextArrow: false
          });
        });
    </script>


<!--                 <script type="text/javascript">
                    config_slider_init = function() {
                        var config_options = {
                          $Loop:0,
                          $FillMode:0,
                          $SlideWidth: 200,
                          $SlideSpacing:20,
                          $SlideDuration:1600,
                          $ArrowKeyNavigation:0,
                          $ArrowNavigatorOptions: {
                            $Class: $JssorArrowNavigator$
                          },
                          $BulletNavigatorOptions: {
                            $Class: $JssorBulletNavigator$
                          }
                        };

                        var config_slider = new $JssorSlider$("config-slider", config_options);

                        /*#region responsive code begin*/

                        var MAX_WIDTH = 1170;

                        function ScaleSlider() {
                            var containerElement = config_slider.$Elmt.parentNode;
                            var containerWidth = containerElement.clientWidth;

                            if (containerWidth) {

                                var expectedWidth = Math.min(MAX_WIDTH || containerWidth, containerWidth);

                                config_slider.$ScaleWidth(expectedWidth);
                            }
                            else {
                                window.setTimeout(ScaleSlider, 30);
                            }
                        }

                        ScaleSlider();

                        $Jssor$.$AddEvent(window, "load", ScaleSlider);
                        $Jssor$.$AddEvent(window, "resize", ScaleSlider);
                        $Jssor$.$AddEvent(window, "orientationchange", ScaleSlider);
                        /*#endregion responsive code end*/
                    };
                </script>

                <div id="config-slider" style="position:relative;margin:0 auto;top:0px;left:0px;width:980px;height:120px;overflow:hidden;visibility:hidden;">
     
                    <div data-u="slides" style="cursor:default;position:relative;top:0px;left:0px;width:980px;height:120px;overflow:hidden;">
                        <div>
                            <img data-u="image" src="{{ asset('frontend/images/slide_design.png') }}" alt=""/>
                        </div>
                        <div>
                            <img data-u="image" src="{{ asset('frontend/images/slide_design.png') }}" alt=""/>
                        </div>
                        <div>
                            <img data-u="image" src="{{ asset('frontend/images/slide_design.png') }}" alt=""/>
                        </div>
                        <div>
                            <img data-u="image" src="{{ asset('frontend/images/slide_design.png') }}" alt=""/>
                        </div>
                        <div>
                            <img data-u="image" src="{{ asset('frontend/images/slide_design.png') }}" alt=""/>
                        </div>
                        <div>
                            <img data-u="image" src="{{ asset('frontend/images/slide_design.png') }}" alt=""/>
                        </div>
                    </div>


                </div>
                <script type="text/javascript">config_slider_init();</script> -->
</div>

@include('frontends.feature-courses')

<div class="container">
    <div class="top-course">
        <div class="row">
            <div class="col-xs-12 clearfix title-module-home">
                <div class="pull-left">
                    <h2>All Courses</h2>
                </div>
                <div class="pull-right">
                    <ul class="nav nav-tabs">
                        <li class="active"><a data-toggle="tab" href="#best-seller">Bestseller</a></li>
                        <li><a data-toggle="tab" href="#menu1">New</a></li>
                        <li><a data-toggle="tab" href="#menu2">Trendding</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-sm-12">
                <div class="tab-content">
                    <div id="best-seller" class="tab-pane fade in active">
                        <div class="row">
                            @for($i = 0; $i < 8; $i++)
                            <div class="col-sm-3">
                                <div class="info">
                                    <a href="https://unica.vn/giao-tiep-tieng-han-de-nhu-nhai-keo" class="course-box-slider pop">
                                        <div class="img-course"><img class="img-responsive" src="https://static.unica.vn/upload/images/2019/04/giao-tiep-tieng-han-cho-nguoi-moi-bat-dau_m_1555561894.jpg" alt="Giao tiếp tiếng Hàn dành cho người mới bắt đầu"></div>
                                        <div class="content-course">
                                            <h3 class="title-course">Giangười mới ...</h3>
                                            <div class="clearfix"> 
                                                <span class="name-teacher">Bảo Minh</span>
                                                <span class="pull-right">
                                                <span class="star-rate">
                                                <i class="fa fa-star co-or" aria-hidden="true"></i><i class="fa fa-star co-or" aria-hidden="true"></i><i class="fa fa-star co-or" aria-hidden="true"></i><i class="fa fa-star co-or" aria-hidden="true"></i><i class="fa fa-star percent percent_6" aria-hidden="true"></i>                </span>
                                                <span class="n-rate">(<span>{!! number_format(3500, 0, ',' , '.') !!}</span>)</span>
                                                </span>
                                            </div>
                                            <div class="time-view"> 
                                                <span class="time">
                                                <i class="far fa-clock"></i> 2h
                                                </span>
                                                <span class="view pull-right">
                                                <i class="fa fa-eye" aria-hidden="true"></i> {!! number_format(3600, 0, ',' , '.') !!} views
                                                </span>
                                            </div>
                                            <div class="price-course">
                                                <span class="price">
                                                {!! number_format(800000, 0, ',' , '.') !!} đ
                                                </span>
                                                <span class="sale pull-right">
                                                {!! number_format(600000, 0, ',' , '.') !!} đ
                                                </span>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                            @endfor
                            <div class="col-sm-12 text-center">
                                <button type="button" class="btn btn-default btn-lg">SEE ALL</button>
                            </div>
                        </div>
                    </div>
                    <div id="menu1" class="tab-pane fade">
                        2
                    </div>
                    <div id="menu2" class="tab-pane fade">
                        3
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@include('frontends.popular-teacher')
@include('frontends.info-others')

@endsection