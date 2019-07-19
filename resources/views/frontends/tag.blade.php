@extends('frontends.layouts.app')
@section('content')
<?php
    $list_bought = [];
    if(Auth::check() && strlen(Auth::user()->bought) > 0){
        $list_bought = \json_decode(Auth::user()->bought);
    }
    $i = 0;
?>
<div class="box-search">
  <div class="container">
      <div class="row">
          <div class="col-lg-3 col-md-3 col-sm-4 u-list-leftbar hidden-xs">
              <section>
                  <div class="u-cate-list">
                    <p style="font-size: 16px;font-weight: bold;border-bottom: 1px solid #d7d7d7;margin-bottom: 10px;padding-bottom: 5px;">
                        Tag : <a title="{!! $tag->name !!}" href="{{ url('/') }}/tags/{{ $tag->slug }}"><i class="fas {!! $tag->icon !!}"></i> {!! $tag->name !!}</a>
                    </p>
                       
                      
                  </div>
              </section>
          </div>
          <div class="col-xs-12">
              <div class="u-all-course">
                  <section>
                    @if (count($tag->courses) > 0)
                    <div class="row">
                        <div class="col-xs-12">
                            <h2>{{ count($tag->courses) }} results found</h2>
                        </div>
                        @foreach ($tag->courses as $result)
                        @if($i%4==0)
                        <div class="row">
                        @endif
                        <?php
                            $lecturers = count($result->Lecturers()) > 1 ? 'Nhiều tác giả' : count($result->Lecturers()) > 0 ? $result->Lecturers()[0]->user->name : "Courdemy";
                        ?>
                        @include(
                            'components.course', 
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
                        @if($i%4==3)
                        </div>
                        @endif
                        <?php $i++; ?>
                        @endforeach
                        <style>.img-course {position: relative;}</style>
                      <div class="col-xs-12 text-center">
                          <div class="u-number-page">{{ $tag->courses()->paginate(15)->links() }}</div>
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