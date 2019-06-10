<?php
    if($course->vote_count == 0) $course->vote_count = 1;
    $random_name = ['Steve Rogers', 'Natasha Romanoff', 'Tony Stark', 'Peter Quill', "Bruce Banner", "Stephen Strange"];
    $lecturers = count($course->Lecturers()) > 1 ? 'Nhiều tác giả' : (count($course->Lecturers()) > 0 ? $course->Lecturers()[0]->user->name : "Courdemy");
?>
<div class="col-sm-3">
    <div class="box-course">
        <a href="{{ url('/') }}/course/{{ $course->slug }}" title="{{ $course->name }}" class="course-box-slider pop">
            <div class="img-course">
            	<img class="img-responsive"
                    src="{{ url('/frontend/images').'/'.$course->image }}"
                    alt="{{ $course->name }}">
                @if (isset($heart))
                <i class="fa fa-heart fa-lg heart-icon" aria-hidden="true"></i>    
                @endif

                @if (isset($setup))  
                <i class="fa fa-cog fa-lg setting-icon" aria-hidden="true"></i>
                @endif
                @if (!in_array($course->id, $list_bought))
                <div class="img-mask">
                    <div class="btn-add-to-cart">
                        <button class="btn btn-success" data-id="{{ $course->id }}" data-image="{{ $course->image }}" data-lecturer="{{ $lecturers }}" data-name="{{ $course->name }}" data-price="{{ $course->price }}" data-real-price="{{ $course->real_price }}" data-slug="{{ $course->slug }}">
                            <span class="img">
                                <img src="{{asset("frontend/images/ic_add_to_card.png")}}" width="20px">
                            </span>
                            <span class="text">
                                Add to cart
                            </span>
                        </button>
                    </div>                        
                </div>               
                @endif
             </div>
                    
            <div class="content-course">
                <h3 class="title-course">{{ $course->name }}</h3>
                <div class="clearfix" style="line-height:1.7">
                    <span class="name-teacher pull-left">
                        {{ $lecturers }}
                    </span>
                    <br>
                    <span class="pull-left">
                        @include(
                            'components.vote', 
                            [
                                'rate' => intval($course->star_count) / intval($course->vote_count),
                                'rating_number' => $course->vote_count,
                            ]
                        )
                    </span>
                </div>
                <div class="time-view">
                    <span class="time">
                        <i class="fas fa-stopwatch"></i> {{ $course->approx_time }}h
                    </span>
                    <span class="view pull-right">
                        <i class="fa fa-eye" aria-hidden="true"></i> {!! number_format($course->view_number, 0, ',' , '.') !!} views
                    </span>
                </div>
                @if (isset($setup))  
                <div class="progress">
                    <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 60%;">
                        60%
                    </div>
                </div>
                @endif

                <?php
                    $check_time_sale = false;
                    if ($course->from_sale != '' && $course->to_sale != '') {
                        $start_sale = strtotime($course->from_sale.' 00:00:00');
                        $end_sale = strtotime($course->to_sale.' 23:59:59');
                        // $date_to = new DateTime($to_sale);
                        // $date_from = new DateTime(date('Y-m-d'));
                        if (time() >= $start_sale && time() <= $end_sale) {
                            $check_time_sale = true;
                        }
                    }
                ?>
                <div class="price-course">
                    @if ($check_time_sale == true)                                        
                    <span class="price line-through">
                        {!! number_format($course->real_price, 0, ',' , '.') !!}đ
                    </span>
                    <span class="sale pull-right">
                        {!! number_format($course->price, 0, ',' , '.') !!}đ
                    </span>
                    @else
                    <span class="price">
                        {!! number_format($course->real_price, 0, ',' , '.') !!}đ
                    </span>
                    @endif
                </div>
                @if (isset($btn_start_learning))  
                <div class="text-center">
                    <a href="{{ url('coming-soon') }}" class="btn btn-primary btn-sm btn-start-learning">Start Learning</a>
                </div>
                @endif
            </div>
        </a>
    </div>
</div>