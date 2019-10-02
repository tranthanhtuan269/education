@extends('frontends.layouts.app')
@section('title')
Courdemy - Học online cùng những chuyên gia hàng đầu Việt Nam
@stop
@section('content')
@php
    // dd($feature_category);
@endphp
<div class="banner hidden-xs">
    {{-- <img class="pd-mb-banner hidden-xs" src="{{ asset('frontend/images/banner_home.png') }}" width="100%" alt="Banner home"> --}}
    {{-- <div class="slick-slider">
        @foreach ($feature_category as $feature)
            <div>
                <a href="{{ url('/') }}/category/{{ $feature->slug }}" title="{{ $feature->name }}" class="item item-slider text-center" style="background-image: url('{{ url('/frontend/images/'.$feature->image) }}'); background-repeat: no-repeat; background-position: right top; background-attachment: fixed;border-radius:100px">
                    <div class="cat cat-item-slider">
                        <h2>{{ $feature->name }}</h2>
                        <p>Over {{ $feature->courses_count }} courses</p>
                    </div>
                </a>     
            </div>
        @endforeach
    </div> --}}
    {{-- <div class="slider-parent"> --}}
        <div class="container category-slider">
            {{-- @dd($feature_category) --}}
            @foreach ($feature_category as $feature)
                @if( count($feature->courses) > 0 )
                    <div class="slider-div" style='background-image: url("{{ url('/frontend/images/'.$feature->image) }}"'>
                        <a href="{{ url('/') }}/category/{{ $feature->slug }}" class="text-center">
                            <div class="link-parent">
                            <!-- <a href="{{ url('/') }}/category/{{ $feature->slug }}" class="text-center"> -->
                                <h3>{{ $feature->name }}</h3>
                                <p>Có {{ $feature->courses->where('status', 1)->count() }} khóa học</p>
                            <!-- </a> -->
                            </div>
                        </a>
                    </div>
                @endif
            @endforeach
        </div>
    {{-- </div> --}}
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
