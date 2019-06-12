@extends('frontends.layouts.app')
@section('content')
<div class="banner">
    
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
            @foreach ($feature_category as $feature)
                <div class="slider-div" style='background-image: url("{{ url('/frontend/images/'.$feature->image) }}"'>
                    <div class="link-parent">
                        <a href="" class="text-center">
                            <h3>{{ $feature->name }}</h3>
                            <p>Over {{ $feature->courses_count }} courses</p>
                        </a>
                    </div>
                </div>
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
                });
            })
        </script>

    @include('frontends.feature-courses')
    @include('frontends.all-courses')
    @include('frontends.popular-teacher')
    @include('frontends.info-others')
@endsection
