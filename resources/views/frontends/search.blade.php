@extends('frontends.layouts.app')
@section('content')
<?php
    $list_bought = [];
    if(Auth::check() && strlen(Auth::user()->bought) > 0){
        $list_bought = \json_decode(Auth::user()->bought);
    }
?>
<div class="box-search">
  <div class="container">
      <div class="row">
          {{-- <div class="col-lg-3 col-md-3 col-sm-4 u-list-leftbar hidden-xs">
              <section>
                  <div class="u-cate-list">
                      <p style="font-size: 16px;font-weight: bold;border-bottom: 1px solid #d7d7d7;margin-bottom: 10px;padding-bottom: 5px;">Categories</p>
                      <ul>
                        @foreach($category_fixed as $cat)
                          <li>
                              <a title="{!! $cat->name !!}" href="{{ url('/') }}/category/{{ $cat->slug }}"><i class="fas {!! $cat->icon !!}"></i> {!! $cat->name !!}</a>
                          </li>
                        @endforeach
                      </ul>
                  </div>
              </section>
          </div> --}}
          <div class="col-xs-12">
              <div class="u-all-course">
                  <section>
                    @if (count($results) > 0)
                    <div class="row">
                        <div class="col-xs-12">
                            <h2>{{ $results->total() }} results found</h2>
                        </div>
                        @foreach ($results as $result)
                        <?php
                            $lecturers = count($result->Lecturers()) > 1 ? 'Nhiều tác giả' : count($result->Lecturers()) > 0 ? $result->Lecturers()[0]->user->name : "Courdemy";
                        ?>
                        @include(
                            'components.course-search', 
                            [
                                'course' => $result,
                                'list_course' => $list_bought
                                // 'id' => $result->id,
                                // 'slug' => $result->slug,
                                // 'rawImage' => $result->image,
                                // 'image' => url('/frontend/images/'.$result->image),
                                // 'title' => $result->name,
                                // 'author' => $lecturers,
                                // 'star_count' => $result->star_count,
                                // 'vote_count' => $result->vote_count,
                                // 'time' => $result->approx_time,
                                // 'view_number' => $result->view_count,
                                // 'price' => $result->real_price,
                                // 'sale' => $result->price,
                                // 'from_sale' => $result->from_sale,
                                // 'to_sale' => $result->to_sale,
                                // 'bought' => $result->checkCourseNotLearning(),

                            ]
                        )
                        @endforeach
                      <div class="col-xs-12 text-center">
                          <div class="u-number-page">{{ $results->appends(Request::all())->links() }}</div>
                      </div>
                    </div>
                    @else
                    <div class="error_search">
                        <div class="search_style">
                            <h2>No results</h2>
                        </div>
                    </div>
                    @endif
                      <!--error_search-->

                  </section>
              </div>
          </div>
      </div>
  </div>
</div>

@endsection