@if (count($best_seller_course) > 0 || count($new_course) > 0 ||  count($feature_course) > 0)
<div class="container">
    <div class="top-course">
        <div class="row">
            <div class="col-sm-12 clearfix title-module-home">
                <div class="col-sm-4">
                <div class="pull-left">
                    <h2>All Courses</h2>
                </div>
                </div>
                <div class="col-sm-8">
                <div class="pull-right">
                    <ul class="nav nav-tabs">
                        <li class="active"><a data-toggle="tab" href="#best-seller">Bestseller</a></li>
                        <li><a data-toggle="tab" href="#menu1">New</a></li>
                        <li><a data-toggle="tab" href="#menu2">Trendding</a></li>
                    </ul>
                </div>
                </div>
            </div>
            <div class="col-sm-12">
                <div class="tab-content">
                    <div id="best-seller" class="tab-pane fade in active">
                        <div class="row">
                            @foreach ($best_seller_course as $best_seller)
                                <?php
                                    $random_name = ['Steve Rogers', 'Natasha Romanoff', 'Tony Stark', 'Peter Quill', "Bruce Banner", "Stephen Strange"];
                                    $lecturers = count($best_seller->Lecturers()) > 1 ? 'Nhiều tác giả' : (count($best_seller->Lecturers()) > 0 ? $best_seller->Lecturers()[0]->user->name : "Courdemy");
                                ?>
                                @include(
                                    'components.course', 
                                    [   
                                        'id' => $best_seller->id,
                                        'slug' => $best_seller->slug,
                                        'image' => url('/frontend/images/'.$best_seller->image),
                                        'rawImage' => $best_seller->image,                                 
                                        'title' => $best_seller->name,
                                        'author' => $lecturers,
                                        'star_count' => $best_seller->star_count,
                                        'vote_count' => $best_seller->vote_count,
                                        'time' => $best_seller->approx_time,
                                        'view_number' => $best_seller->view_count,
                                        'price' => $best_seller->real_price,
                                        'sale' => $best_seller->price,
                                        'from_sale' => $best_seller->from_sale,
                                        'to_sale' => $best_seller->to_sale,
                                        'bought' => $best_seller->checkCourseNotLearning(),
                                    ]
                                )
                            @endforeach
                            @if (Request::is('/')) 
                                <div class="col-sm-12 text-center">
                                    <a href="{{ url('list-course?type=best-seller') }}" class="btn btn-default btn-seeall">SEE ALL</a>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div id="menu1" class="tab-pane fade">
                        @foreach ($new_course as $new)
                            <?php
                                $lecturers = count($new->Lecturers()) > 1 ? 'Nhiều tác giả' : count($new->Lecturers()) > 0 ? $new->Lecturers()[0]->user->name : "Courdemy";
                            ?>
                            @include(
                                'components.course', 
                                [   
                                    'id' => $new->id,
                                    'slug' => $new->slug,
                                    'image' => url('/frontend/images/'.$new->image),
                                    'rawImage' => $new->image,                                 
                                    'title' => $new->name,
                                    'author' => $lecturers,
                                    'star_count' => $new->star_count,
                                    'vote_count' => $new->vote_count,
                                    'time' => $new->approx_time,
                                    'view_number' => $new->view_count,
                                    'price' => $new->real_price,
                                    'sale' => $new->price,
                                    'from_sale' => $new->from_sale,
                                    'to_sale' => $new->to_sale,
                                    'bought' => $new->checkCourseNotLearning(),

                                ]
                            )
                        @endforeach
                        @if (Request::is('/'))
                        <div class="col-sm-12 text-center">
                            <a href="{{ url('list-course?type=new') }}" class="btn btn-default btn-seeall">SEE ALL</a>
                        </div>
                        @endif
                    </div>
                    <div id="menu2" class="tab-pane fade">
                        @foreach ($feature_course as $feature)
                            <?php
                                $lecturers = count($feature->Lecturers()) > 1 ? 'Nhiều tác giả' : count($feature->Lecturers()) > 0 ? $feature->Lecturers()[0]->user->name : "Courdemy";
                            ?>
                            @include(
                                'components.course', 
                                [
                                    'id' => $feature->id,
                                    'slug' => $feature->slug,
                                    'image' => url('/frontend/images/'.$feature->image),
                                    'rawImage' => $feature->image,                                 
                                    'title' => $feature->name,
                                    'author' => $lecturers,
                                    'star_count' => $feature->star_count,
                                    'vote_count' => $feature->vote_count,
                                    'time' => $feature->approx_time,
                                    'view_number' => $feature->view_count,
                                    'price' => $feature->real_price,
                                    'sale' => $feature->price,
                                    'from_sale' => $feature->from_sale,
                                    'to_sale' => $feature->to_sale,
                                    'bought' => $feature->checkCourseNotLearning(),
                            
                                ]
                            )
                        @endforeach
                        @if (Request::is('/'))
                        <div class="col-sm-12 text-center">
                            <a href="{{ url('list-course?type=trendding') }}" class="btn btn-default btn-seeall">SEE ALL</a>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endif