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
                        <a href="{{ url('/') }}/category/{{ $feature->slug }}" title="{{ $feature->name }}" class="item item-slider text-center" style="background-image: url('{{ url('/frontend/images/'.$feature->image) }}'); background-repeat: no-repeat; background-position: right top; background-attachment: fixed;border-radius:100px">
                            <div class="cat cat-item-slider">
                                <h2>{{ $feature->name }}</h2>
                                <p>Over {{ $feature->courses_count }} courses</p>
                            </div>
                        </a>     
                        @endforeach
                    </div>


                </div>
                <script type="text/javascript">config_slider_init();</script>
</div>

    @include('frontends.feature-courses')
    @include('frontends.all-courses')
    @include('frontends.popular-teacher')
    @include('frontends.info-others')
@endsection