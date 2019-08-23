@extends('frontends.layouts.app')
@section('content')
<?php
    $list_bought = [];
    if(Auth::check() && strlen(Auth::user()->bought) > 0){
        $list_bought = \json_decode(Auth::user()->bought);
    }
    dd($list_course);
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
                        <?php
                            $lecturers = count($course->Lecturers()) > 1 ? 'Nhiều tác giả' : count($course->Lecturers()) > 0 ? $course->Lecturers()[0]->user->name : "Courdemy";
                        ?>
                        @include(
                            'components.course', 
                            [   
                                'course' => $course,
                                'list_course' => $list_bought
                                // 'id'    => $course->id,
                                // 'slug' => $course->slug,
                                // 'image' => url('/frontend/images/'.$course->image),
                                // 'rawImage' => $course->image,
                                // 'title' => $course->name,
                                // 'author' => $lecturers,
                                // 'star_count' => $course->star_count,
                                // 'vote_count' => $course->vote_count,
                                // 'time' => $course->approx_time,
                                // 'view_number' => $course->view_count,
                                // 'price' => $course->real_price,
                                // 'sale' => $course->price,
                                // 'from_sale' => $course->from_sale,
                                // 'to_sale' => $course->to_sale,
                                // 'bought' => $course->checkCourseNotLearning(),
                                
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