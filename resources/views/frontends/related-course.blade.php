<div class="top-course">
    <div class="row" id="box_related_course">
        <div class="col-xs-12 clearfix title-module-home">
            <div class="pull-left">
                <h3>Related Courses</h3>
            </div>
        </div>
        <div class="col-sm-12">
            <div class="tab-content">
                <div id="best-seller" class="tab-pane fade in active">
                    <div class="row">
                        @foreach ($related_course as $related)
                            <?php
                                $lecturers = count($related->Lecturers()) > 1 ? 'Nhiều tác giả' : count($related->Lecturers()) > 0 ? $related->Lecturers()[0]->user->name : "Courdemy";
                            ?>
                            @include(
                                'components.course', 
                                [
                                    'slug' => $related->slug,
                                    'image' => url('/frontend/images/'.$related->image),
                                    'title' => $related->name,
                                    'author' => $lecturers,
                                    'star_count' => $related->star_count,
                                    'vote_count' => $related->vote_count,
                                    'time' => $related->approx_time,
                                    'view_number' => $related->view_count,
                                    'price' => $related->real_price,
                                    'sale' => $related->price,
                                ]
                            )
                        @endforeach
                        {{-- <div class="col-sm-12 btn-seen-all">
                            <button type="button" class="btn">See all</button>
                        </div> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
