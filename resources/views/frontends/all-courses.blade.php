@if (count($best_seller_course) > 0 || count($new_course) > 0 ||  count($feature_course) > 0)
<?php
    $list_bought = [];
    if(Auth::check() && strlen(Auth::user()->bought) > 0){
        $list_bought = \json_decode(Auth::user()->bought);
    }
?>
<div class="container">
    <div class="top-course">
        <div class="row">
            <div class="col-sm-12 clearfix title-module-home">
                <div class="pull-left" id="allCoursesTitle">
                    <h2></h2>
                </div>
                <div class="pull-right">
                    <ul class="nav nav-tabs">
                        <li class="active" data-title="Mua nhiều nhất"><a data-toggle="tab" href="#best-seller">Mua nhiều nhất</a></li>
                        <li data-title="Mới nhất"><a data-toggle="tab" href="#menu1">Mới nhất</a></li>
                        <li data-title="Thịnh hành"><a data-toggle="tab" href="#menu2">Thịnh hành</a></li>
                    </ul>
                    <script>
                        $(document).ready(function(){
                            switchAllCoursesTitle()
                            $(document).on('click', '.nav.nav-tabs li', function(){
                                switchAllCoursesTitle()
                            })
                        })
                        function switchAllCoursesTitle(){
                            $('.nav.nav-tabs li').each(function(index, element){
                                if($(this).hasClass('active')){
                                    var title = $(this).attr('data-title')
                                    $('#allCoursesTitle h2').text(title)
                                }                       
                            })
                        }
                    </script>
                </div>
                <br>
            </div>
            <div class="col-sm-12">
                <div class="tab-content">
                    <div id="best-seller" class="tab-pane fade in active">
                        <div class="row">
                            @foreach ($best_seller_course as $key => $best_seller)
                            @if($key%4 == 0)
                            <div class="row open">
                            @endif
                                @include(
                                    'components.course', 
                                    [   
                                        'course' => $best_seller,
                                        'list_course' => $list_bought
                                        // 'id' => $best_seller->id,
                                        // 'slug' => $best_seller->slug,
                                        // 'image' => url('/frontend/images/'.$best_seller->image),
                                        // 'rawImage' => $best_seller->image,                                 
                                        // 'title' => $best_seller->name,
                                        // 'author' => $lecturers,
                                        // 'star_count' => $best_seller->star_count,
                                        // 'vote_count' => $best_seller->vote_count,
                                        // 'time' => $best_seller->approx_time,
                                        // 'view_number' => $best_seller->view_count,
                                        // 'price' => $best_seller->real_price,
                                        // 'sale' => $best_seller->price,
                                        // 'from_sale' => $best_seller->from_sale,
                                        // 'to_sale' => $best_seller->to_sale,
                                        // 'bought' => $best_seller->checkCourseNotLearning(),
                                    ]
                                )
                            @if($key%4 == 3)
                            </div>
                            @endif
                            @endforeach
                            @if (Request::is('/')) 
                                <div class="col-sm-12 text-center">
                                    <a href="{{ url('list-course?type=best-seller') }}" class="btn btn-default btn-seeall">Tất cả</a>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div id="menu1" class="tab-pane fade">
                        @foreach ($new_course as $key => $new)
                        @if($key%4 == 0)
                        <div class="row open">
                        @endif
                            <?php
                                $lecturers = count($new->Lecturers()) > 1 ? 'Nhiều tác giả' : count($new->Lecturers()) > 0 ? $new->Lecturers()[0]->user->name : "Courdemy";
                            ?>
                            @include(
                                'components.course', 
                                [   
                                    'course' => $new,
                                    'list_course' => $list_bought
                                    // 'id' => $new->id,
                                    // 'slug' => $new->slug,
                                    // 'image' => url('/frontend/images/'.$new->image),
                                    // 'rawImage' => $new->image,                                 
                                    // 'title' => $new->name,
                                    // 'author' => $lecturers,
                                    // 'star_count' => $new->star_count,
                                    // 'vote_count' => $new->vote_count,
                                    // 'time' => $new->approx_time,
                                    // 'view_number' => $new->view_count,
                                    // 'price' => $new->real_price,
                                    // 'sale' => $new->price,
                                    // 'from_sale' => $new->from_sale,
                                    // 'to_sale' => $new->to_sale,
                                    // 'bought' => $new->checkCourseNotLearning(),

                                ]
                            )
                        @if($key%4 == 3)
                        </div>
                        @endif
                        @endforeach
                        @if (Request::is('/'))
                        <div class="col-sm-12 text-center">
                            <a href="{{ url('list-course?type=new') }}" class="btn btn-default btn-seeall">Tất cả</a>
                        </div>
                        @endif
                    </div>
                    <div id="menu2" class="tab-pane fade">
                        @foreach ($feature_course as $feature)
                        @if($key%4 == 0)
                        <div class="row open">
                        @endif
                            <?php
                                $lecturers = count($feature->Lecturers()) > 1 ? 'Nhiều tác giả' : count($feature->Lecturers()) > 0 ? $feature->Lecturers()[0]->user->name : "Courdemy";
                            ?>
                            @include(
                                'components.course', 
                                [
                                    'course' => $feature,
                                    'list_course' => $list_bought
                                    // 'id' => $feature->id,
                                    // 'slug' => $feature->slug,
                                    // 'image' => url('/frontend/images/'.$feature->image),
                                    // 'rawImage' => $feature->image,                                 
                                    // 'title' => $feature->name,
                                    // 'author' => $lecturers,
                                    // 'star_count' => $feature->star_count,
                                    // 'vote_count' => $feature->vote_count,
                                    // 'time' => $feature->approx_time,
                                    // 'view_number' => $feature->view_count,
                                    // 'price' => $feature->real_price,
                                    // 'sale' => $feature->price,
                                    // 'from_sale' => $feature->from_sale,
                                    // 'to_sale' => $feature->to_sale,
                                    // 'bought' => $feature->checkCourseNotLearning(),
                            
                                ]
                            )
                        @if($key%4 == 3)
                        </div>
                        @endif
                        @endforeach
                        @if (Request::is('/'))
                        <div class="col-sm-12 text-center">
                            <a href="{{ url('list-course?type=trendding') }}" class="btn btn-default btn-seeall">Tất cả</a>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endif