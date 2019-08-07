<?php
    if($course->vote_count == 0) $course->vote_count = 1;
    $lecturers = count($course->Lecturers()) > 1 ? 'Nhiều tác giả' : (count($course->Lecturers()) > 0 ? $course->Lecturers()[0]->user->name : "Courdemy");
    $main_lecturer = $course->Lecturers()->first() ? $course->Lecturers()->first()->teacher->id : 0;
    // dd($course->userRoles()->first()->teacher->id);
?>
<div class="col-md-3 col-sm-6">
    <div class="box-course">
        <a href="{{ url('/') }}/course/{{ $course->slug }}" title="{{ $course->name }}" class="course-box-slider pop">
            <div class="img-course">
            	<img class="img-responsive"
                    {{-- src="{{ url('/frontend/images').'/'.$course->image }}" --}}
                    src="{{ $course->image }}"
                    alt="{{ $course->name }}">
                @if (isset($heart))
                <i class="fa fa-heart fa-lg heart-icon" aria-hidden="true"></i>    
                @endif

                @if (isset($setup))  
                <i class="fa fa-cog fa-lg setting-icon" aria-hidden="true"></i>
                @endif
                @if (!in_array($course->id, $list_bought))
                <div class="img-mask hidden-sm">
                    <div class="btn-add-to-cart">
                        <button class="btn btn-success" data-id="{{ $course->id }}" data-image="{{ $course->image }}" data-lecturer="{{ $lecturers }}" data-name="{{ $course->name }}" data-price="{{ $course->price }}" data-real-price="{{ $course->real_price }}" data-slug="{{ $course->slug }}">
                            <span class="img">
                                <img src="{{asset("frontend/images/ic_add_to_card.png")}}" width="20px">
                            </span>
                            <span class="text">
                                Thêm vào giỏ hàng
                            </span>
                        </button>
                    </div>                        
                </div>               
                @endif
             </div>
                    
            <div class="content-course">
                <h3 class="title-course">{{ $course->name }}</h3>
                <div class="clearfix" style="line-height:1.7">
                    <span class="name-teacher pull-left" data-teacher-id="{{$main_lecturer}}" >
                        {{-- {{ $lecturers }} --}}
                        {{ $course->author }}
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
                        {{-- <i class="fas fa-stopwatch"></i> {{ $course->approx_time }} giờ --}}
                        <i class="fas fa-stopwatch"></i> {{ intval($course->duration / 60) }} giờ {{ $course->duration % 60 }} phút
                    </span>
                    <span class="view pull-right">
                        <i class="fa fa-eye" aria-hidden="true"></i> {!! number_format($course->view_count, 0, ',' , '.') !!}
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
                    // $check_time_sale = false;
                    // if ($course->from_sale != '' && $course->to_sale != '') {
                    //     $start_sale = strtotime($course->from_sale.' 00:00:00');
                    //     $end_sale = strtotime($course->to_sale.' 23:59:59');
                    //     if (time() >= $start_sale && time() <= $end_sale) {
                    //         $check_time_sale = true;
                    //     }
                    // }
                ?>
                <div class="price-course">
                    @if ($course->price == $course->real_price)
                        <span class="sale text-right">
                            {!! number_format($course->real_price, 0, ',' , '.') !!}đ
                        </span> 
                    @else
                        <span class="price line-through">
                            {!! number_format($course->real_price, 0, ',' , '.') !!}đ
                        </span>
                        @if ($course->real_price != $course->price)
                        <span class="sale pull-right">
                            {!! number_format($course->price, 0, ',' , '.') !!}đ
                        </span>                        
                        @endif
                    @endif

                </div>
                @if (isset($btn_start_learning))  
                <div class="text-center">
                    <a href="{{ url('coming-soon') }}" class="btn btn-primary btn-sm btn-start-learning">Vào học</a>
                </div>
                @endif
            </div>
        </a>
    </div>
</div>

<script>
    $('.content-course .name-teacher').on('click', function (e){
        e.stopPropagation()
        e.preventDefault()
        var teacherId = $(this).attr('data-teacher-id')
        window.location.href = `/teacher/${teacherId}`
    })
</script>