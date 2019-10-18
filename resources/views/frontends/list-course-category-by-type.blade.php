@extends('frontends.layouts.app')
@section('content')
<?php
    $list_bought = [];
    if(Auth::check() && strlen(Auth::user()->bought) > 0){
        $list_bought = \json_decode(Auth::user()->bought);
    }
?>
<div class="background-page">
    <div class='container-fuild'>
        <img class="bg-category" src="{{ asset('frontend/images/banner_profile_teacher.png') }}">
        <div class="container fixed-title">
            <div class="highlight">
                <div class="row title">
                    <i class="fas {{$cat_icon}} fa-4x fa-fw"></i>
                    <h1>{{ $cat_name }}</h1>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="box-list-course-by-type">
  <div class="container">
      <div class="row">
          <div class="col-xs-12">
              <div class="u-all-course">
                    <section>
                        @if (count($list_course) > 0)
                        <div class="row">
                            <div class="col-xs-12">
                                <h1>{{ $title }}</h1>
                            </div>
                            @foreach ($list_course as $course)
                                @include(
                                    'components.course', 
                                    [   
                                        'course' => $course,
                                        'list_course' => $list_bought
                                    ]
                                )
                            @endforeach
                            <div class="col-xs-12 text-center">
                                <div class="u-number-page">{{ $list_course->appends(Request::all())->links() }}</div>
                            </div>
                        </div>
                        @else
                        <h1>Không có danh sách khóa học</h1>
                        @endif
                    </section>
              </div>
          </div>
      </div>
  </div>
</div>
<style>
.box-course .img-course{
    position: relative;
}
</style>

@endsection