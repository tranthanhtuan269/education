@extends('frontends.layouts.app')
@section('title')
Courdemy - Học online cùng những chuyên gia hàng đầu Việt Nam
@stop
@section('content')
@php
    // dd($feature_category);
@endphp
<div class="banner hidden-xs">
    <div class="container">
        <h1 class="title-homepage">{!!$title_homepage!!}</h1>
    </div>
    <div class="container category-slider">
        @foreach ($feature_category as $feature)
            @if( $feature->course_count > 0 )
                <div class="slider-div" style='background-image: url("{{ url('/frontend/images/'.$feature->image) }}"'>
                    <a href="{{ url('/') }}/category/{{ $feature->slug }}" class="text-center">
                        <div class="link-parent">
                        <!-- <a href="{{ url('/') }}/category/{{ $feature->slug }}" class="text-center"> -->
                            <h3>{{ $feature->name }}</h3>
                            <p>Có {{ $feature->course_count }} khóa học</p>
                        <!-- </a> -->
                        </div>
                    </a>
                </div>
            @endif
        @endforeach
    </div>
</div>
        <style>
        
        </style>
        <script>
            $(document).ready(function(){
                $('.category-slider').slick({
                arrows: true,
                infinite: true,
                speed: 500,
                slidesToShow: 4,
                slidesToScroll: 4,
                responsive:[
                    {
                        breakpoint: 1200,
                        settings:{
                            slidesToShow: 4,
                            slidesToScroll: 4,
                        }
                    },
                    {
                        breakpoint: 992,
                        settings:{
                            slidesToShow: 3,
                            slidesToScroll: 3,
                        }
                    },
                    {
                        breakpoint: 768,
                        settings:{
                            slidesToShow: 2,
                            slidesToScroll: 2,
                        }
                    },
                    {
                        breakpoint: 576,
                        settings:{
                            slidesToShow: 1,
                            slidesToScroll: 1,
                        }
                    },
                ]
                });
            })
        </script>

    @include('frontends.feature-courses')
    @include('frontends.all-courses')
    @include('frontends.popular-teacher')
    @include('frontends.info-others')
@endsection
