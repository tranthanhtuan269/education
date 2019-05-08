@extends('frontends.layouts.app')
@section('content')
<div class="banner">
    <img class="pd-mb-banner hidden-xs" src="https://cms.unica.vn/upload/images/65055147_30-4-1-5-chao-mung-dai-le-hoc-ngay-keo-tre-chi-249k-khoa_thumb.png" width="100%" alt="30/4 -1/5: Chào mừng đại lễ - Học ngay kẻo trễ [Chỉ 249k/khóa]">
    <!-- <div class="container">
        <div class="col-md-12">
            <div class="slick-course">
                @for($i = 0; $i < 10; $i++)
                <div class="item text-center" style="margin:0 8px;width: 220px" class="slick-slide">
                    <img src="{{ asset('frontend/images/slide_design.png') }}" alt=""/>
                    <div class="cat">
                        <h2>GYM {{ $i + 1 }}</h2>
                        <p>Comming soon</p>
                    </div>
                </div>
                @endfor
            </div>
        </div>
    </div> -->
    <!-- <script type="text/javascript">
        $(document).ready(function(){
          $('.slick-course').slick({
            dots: false,
            infinite: true,
            speed: 1500,
            slidesToShow: 1,
            centerMode: false,
            variableWidth: true,
            centerPadding: '0px',
            prevArrow: false,
            nextArrow: false
          });
        });
    </script> -->


                <script type="text/javascript">
                    config_slider_init = function() {
                        var config_options = {
                          $Loop:0,
                          $FillMode:5,
                          $SlideWidth: 200,
                          $SlideSpacing:20,
                          $MinDragOffsetToSlide:0,
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
                        @for($i = 0; $i < 10; $i++)
                        <div class="item item-slider text-center">
                            <img data-u="image" src="{{ asset('frontend/images/slide_design.png') }}" alt=""/>
                            <div class="cat cat-item-slider">
                                <h2>GYM {{ $i + 1 }}</h2>
                                <p>Comming soon</p>
                            </div>
                        </div>
                        @endfor
                    </div>


                </div>
                <script type="text/javascript">config_slider_init();</script>
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
                                @include(
                                    'components.course', 
                                    [
                                        'image' => 'https://static.unica.vn/upload/images/2019/04/giao-tiep-tieng-han-cho-nguoi-moi-bat-dau_m_1555561894.jpg',
                                        'title' => 'Giao tiếp tiếng Hàn dành cho người mới bắt đầu',
                                        'author' => 'Bảo Minh',
                                        'rating_number' => 3500,
                                        'time' => 2,
                                        'view_number' => 3600,
                                        'price' => 800000,
                                        'sale' => 600000,
                                    ]
                                )
                            @endfor
                            <div class="col-sm-12 text-center">
                                <button type="button" class="btn btn-default btn-seeall">SEE ALL</button>
                            </div>
                        </div>
                    </div>
                    <div id="menu1" class="tab-pane fade">
                        @for($i = 0; $i < 8; $i++)
                            @include(
                                'components.course', 
                                [
                                    'image' => 'https://static.unica.vn/upload/images/2019/04/giao-tiep-tieng-han-cho-nguoi-moi-bat-dau_m_1555561894.jpg',
                                    'title' => 'Giao tiếp tiếng Hàn dành cho người mới bắt đầu',
                                    'author' => 'Bảo Minh',
                                    'rating_number' => 3500,
                                    'time' => 2,
                                    'view_number' => 3600,
                                    'price' => 800000,
                                    'sale' => 600000,
                                ]
                            )
                        @endfor
                    </div>
                    <div id="menu2" class="tab-pane fade">
                        @for($i = 0; $i < 8; $i++)
                            @include(
                                'components.course', 
                                [
                                    'image' => 'https://static.unica.vn/upload/images/2019/04/giao-tiep-tieng-han-cho-nguoi-moi-bat-dau_m_1555561894.jpg',
                                    'title' => 'Giao tiếp tiếng Hàn dành cho người mới bắt đầu',
                                    'author' => 'Bảo Minh',
                                    'rating_number' => 3500,
                                    'time' => 2,
                                    'view_number' => 3600,
                                    'price' => 800000,
                                    'sale' => 600000,
                                ]
                            )
                        @endfor
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@include('frontends.popular-teacher')
@include('frontends.info-others')

@endsection