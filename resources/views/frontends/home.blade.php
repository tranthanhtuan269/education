@extends('frontends.layouts.app')
@section('content')
<div class="banner">
    <img class="pd-mb-banner hidden-xs" src="{{ asset('frontend/images/banner_home.png') }}" width="100%" alt="Banner home">
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
                        @foreach ($feature_category as $feature)
                        <a href="{{ url('/') }}/category/{{ $feature->id }}" title="{{ $feature->name }}" class="item item-slider text-center">
                            <img data-u="image" src="{{ url('/frontend/images/'.$feature->image) }}" alt="{{ $feature->name }}"/>
                            <div class="cat cat-item-slider">
                                <h2>{{ $feature->name }}</h2>
                                <p>Over {{ $feature->course_count }} courses</p>
                            </div>
                        </a>     
                        @endforeach
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
                            @foreach ($best_seller_course as $best_seller)
                                <?php
                                    $lecturers = count($best_seller->Lecturers()) > 1 ? 'Nhiều tác giả' : count($best_seller->Lecturers()) > 0 ? $best_seller->Lecturers()[0]->user->name : "Courdemy";
                                ?>
                                @include(
                                    'components.course', 
                                    [
                                        'id' => $best_seller->id,
                                        'image' => url('/frontend/images/'.$best_seller->image),
                                        'title' => $best_seller->name,
                                        'author' => $lecturers,
                                        'star_count' => $best_seller->star_count,
                                        'vote_count' => $best_seller->vote_count,
                                        'time' => $best_seller->approx_time,
                                        'view_number' => $best_seller->view_count,
                                        'price' => $best_seller->real_price,
                                        'sale' => $best_seller->price,
                                    ]
                                )
                            @endforeach
                            <div class="col-sm-12 text-center">
                                <button type="button" class="btn btn-default btn-seeall">SEE ALL</button>
                            </div>
                        </div>
                    </div>
                    <div id="menu1" class="tab-pane fade">
                        @foreach ($new_course as $new)
                            <?php
                                $lecturers = count($new->Lecturers()) > 1 ? 'Nhiều tác giả' : count($new->Lecturers()) > 0 ? $new->Lecturers()[0]->user->name : "Courdemy";
                            ?>
                            @include(
                                'components.course', 
                                [
                                    'id' => $new->id,
                                    'image' => url('/frontend/images/'.$new->image),
                                    'title' => $new->name,
                                    'author' => $lecturers,
                                    'star_count' => $new->star_count,
                                    'vote_count' => $new->vote_count,
                                    'time' => $new->approx_time,
                                    'view_number' => $new->view_count,
                                    'price' => $new->real_price,
                                    'sale' => $new->price,
                                ]
                            )
                        @endforeach
                    </div>
                    <div id="menu2" class="tab-pane fade">
                        @foreach ($feature_course as $feature)
                            <?php
                                $lecturers = count($feature->Lecturers()) > 1 ? 'Nhiều tác giả' : count($feature->Lecturers()) > 0 ? $feature->Lecturers()[0]->user->name : "Courdemy";
                            ?>
                            @include(
                                'components.course', 
                                [
                                    'id' => $feature->id,
                                    'image' => url('/frontend/images/'.$feature->image),
                                    'title' => $feature->name,
                                    'author' => $lecturers,
                                    'star_count' => $feature->star_count,
                                    'vote_count' => $feature->vote_count,
                                    'time' => $feature->approx_time,
                                    'view_number' => $feature->view_count,
                                    'price' => $feature->real_price,
                                    'sale' => $feature->price,
                                ]
                            )
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@include('frontends.popular-teacher')
@include('frontends.info-others')

@endsection