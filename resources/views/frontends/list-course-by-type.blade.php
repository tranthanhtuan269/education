@extends('frontends.layouts.app')
@section('content')
<?php
    $list_bought = [];
    if(Auth::check() && strlen(Auth::user()->bought) > 0){
        $list_bought = \json_decode(Auth::user()->bought);
    }
?>
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
                            {{-- @if(isset($course->userRoles()->first()->teacher)) --}}
                                {{-- @if ( $course->userRoles()->first()->teacher->status == 1 ) --}}
                                    @include(
                                        'components.course', 
                                        [   
                                            'course' => $course,
                                            'list_course' => $list_bought
                                        ]
                                    )
                                {{-- @endif --}}
                            {{-- @endif --}}
                      @endforeach
                      <div class="col-xs-12 text-center">
                          <div class="u-number-page">{{ $list_course->appends(Request::all())->links() }}</div>
                      </div>
                    </div>
                    @else
                    <h1>Không có danh sách khóa học</h1>
                    @endif
                      <!--error_search-->

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