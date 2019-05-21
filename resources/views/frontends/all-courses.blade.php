@if (count($best_seller_course) > 0 || count($new_course) > 0 ||  count($feature_course) > 0)
<div class="container">
    <div class="top-course">
        <div class="row">
            <div class="col-xs-12 clearfix title-module-home">
                <div class="pull-left">
                    <h2>All Courses</h2>
                </div>
                <div class="pull-right">
                    <ul class="nav nav-tabs">
                        <li class="active"><a data-toggle="tab" href="#best-seller">Bestseller</a></li>
                        <li><a data-toggle="tab" href="#menu1">New</a></li>
                        <li><a data-toggle="tab" href="#menu2">Trendding</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-sm-12">
                <div class="tab-content">
                    <div id="best-seller" class="tab-pane fade in active">
                        <div class="row">
                            @foreach ($best_seller_course as $best_seller)
                                <?php
                                    $lecturers = count($best_seller->Lecturers()) > 1 ? 'Nhiều tác giả' : count($best_seller->Lecturers()) > 0 ? $best_seller->Lecturers()[0]->user->name : "Courdemy";
                                ?>
                                @include(
                                    'components.course', 
                                    [
                                        'slug' => $best_seller->slug,
                                        'image' => url('/frontend/images/'.$best_seller->image),
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
                                    ]
                                )
                            @endforeach
                            <div class="col-sm-12 text-center">
                                {{-- <a href="#" class="btn">Pagging</a> --}}
                                <!-- <nav>
                                    <ul class="pagination">
                                        <li><a href="#"><img src="{{ asset('frontend/images/pagination_previous.png') }}"></a></li>
                                        <li class="active"><a class="page-link" href="#">1</a></li>
                                        <li><a class="page-link" href="#">2</a></li>
                                        <li><a class="page-link" href="#">3</a></li>
                                        <li><a href="#"><img src="{{ asset('frontend/images/pagination_next.png') }}"></a></li>
                                    </ul>
                                </nav> -->
                            </div>
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
                                    'slug' => $new->slug,
                                    'image' => url('/frontend/images/'.$new->image),
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
                                ]
                            )
                        @endforeach
                        <div class="col-sm-12 text-center">
                            <button type="button" class="btn">Pagging</button>
                        </div>
                    </div>
                    <div id="menu2" class="tab-pane fade">
                        @foreach ($feature_course as $feature)
                            <?php
                                $lecturers = count($feature->Lecturers()) > 1 ? 'Nhiều tác giả' : count($feature->Lecturers()) > 0 ? $feature->Lecturers()[0]->user->name : "Courdemy";
                            ?>
                            @include(
                                'components.course', 
                                [
                                    'slug' => $feature->slug,
                                    'image' => url('/frontend/images/'.$feature->image),
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
                                ]
                            )
                        @endforeach
                        <div class="col-sm-12 text-center">
                            <button type="button" class="btn">Pagging</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endif