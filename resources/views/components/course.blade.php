<?php
    // if($course->vote_count == 0) $course->vote_count = 0;
    $lecturers = count($course->Lecturers()) > 1 ? 'Nhiều tác giả' : (count($course->Lecturers()) > 0 ? ($course->Lecturers()[0]->user ? $course->Lecturers()[0]->user->name : "Courdemy") : "Courdemy");
    // dd($course->userRoles()->first()->teacher->id);
    if (isset($course->Lecturers()->first()->teacher->id)) {
        $main_lecturer = $course->Lecturers()->first() ? $course->Lecturers()->first()->teacher->id : 0;
    }else{
        $main_lecturer = null;
    }
?>
<div class="col-md-3 col-sm-6">
    <div class="box-course">
        <a title="{{ $course->name }}" class="course-box-slider pop">
            <div class="img-course">
                @if (strpos($course->image, 'unica') !== false)
                    <img class="img-responsive"
                        {{-- src="{{ url('/frontend/images').'/'.$course->image }}" --}}
                        src="{{ $course->image }}"
                        alt="{{ $course->name }}">
                @else
                    <img class="img-responsive"
                    src="{{ url('/frontend/images').'/'.$course->image }}"
                    {{-- src="{{ $course->image }}" --}}
                    alt="{{ $course->name }}">             
                @endif
                @if (isset($heart))
                <i class="fa fa-heart fa-lg heart-icon" aria-hidden="true"></i>    
                @endif

                @if (isset($setup))  
                <i class="fa fa-cog fa-lg setting-icon" aria-hidden="true"></i>
                @endif
                @if ($course->real_price != 0)
                    @if ($course->real_price != $course->price)
                    <span class="percent-discount">-{{(int)(($course->real_price - $course->price)/($course->real_price)*100)}}%</span>
                    @endif                    
                @endif
                
                <div class="img-mask hidden-sm">
                    <div class="btn-add-to-cart course-{{$course->id}}">
                        @if (!in_array($course->id, $list_bought))
                            @if (Auth::check())
                                @if( (int)($course->userRoles[0]->user_id) != (int)(Auth::user()->id) )
                                    <button class="btn btn-success" data-id="{{ $course->id }}" data-image="{{ $course->image }}" data-lecturer="{{ $lecturers }}" data-name="{{ $course->name }}" data-price="{{ $course->price }}" data-real-price="{{ $course->real_price }}" data-slug="{{ $course->slug }}">
                                        <span class="img">
                                            <img src="{{asset("frontend/images/ic_add_to_card.png")}}" width="20px">
                                        </span>
                                        <span class="text">
                                            Thêm vào giỏ hàng
                                        </span>
                                    </button>
                                @endif
                            @endif
                        @endif
                    </div>                        
                </div>               
             </div>
        <a href="{{ url('/') }}/course/{{ $course->slug }}" title="{{ $course->name }}" class="course-box-slider pop">
            
            <div class="content-course">
                <h3 class="title-course">{{ $course->name }}</h3>
                <div class="clearfix" style="line-height:1.7">
                    <span class="name-teacher pull-left" data-teacher-id="{{$main_lecturer}}" >
                        {{ $lecturers }}
                        {{-- {{ $course->author }} --}}
                    </span>
                    <br>
                    <span class="pull-left">
                        {{-- @php
                            echo($course->vote_count);
                        @endphp --}}
                        @if($course->vote_count == 0)
                            @include(
                                'components.vote', 
                                [
                                    'rate' => 0,
                                    'rating_number' => $course->vote_count,
                                ]
                            )
                        @else
                            @include(
                                'components.vote', 
                                [
                                    'rate' => intval($course->star_count) / intval($course->vote_count),
                                    'rating_number' => $course->vote_count,
                                ]
                            )
                        @endif
                    </span>
                    <span class="time pull-right">
                        <i class="fas fa-stopwatch"></i> {{ intval($course->duration / 3600) }}h {{ intval($course->duration % 60) }}m
                    </span>
                </div>
                {{-- <div class="time-view"> --}}
                    {{-- <span class="time"> --}}
                        {{-- <i class="fas fa-stopwatch"></i> {{ $course->approx_time }} giờ --}}
                        {{-- <i class="fas fa-stopwatch"></i> {{ intval($course->duration / 60) }} giờ --}}
                    {{-- </span> --}}
                    {{-- <span class="view pull-right"> --}}
                        {{-- <i class="fa fa-eye" aria-hidden="true"></i> {!! number_format($course->view_count, 0, ',' , '.') !!} --}}
                    {{-- </span> --}}
                {{-- </div> --}}
                @if (isset($setup))  
                <div class="progress">
                    <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 60%;">
                        60%
                    </div>
                </div>
                @endif
                <div class="price-course pull-right">
                    @if ($course->real_price != 0)
                        @if ($course->price == $course->real_price)
                            <span class="sale">
                                <b>{!! number_format($course->real_price, 0, ',' , '.') !!}</b><sup>₫</sup>
                            </span> 
                        @else
                            <span class="price line-through">
                                {!! number_format($course->real_price, 0, ',' , '.') !!}<sup>₫</sup>
                            </span>
                            {{-- @if ($course->real_price != $course->price) --}}
                            <span class="sale">
                                &nbsp;<b>{!! number_format((float)$course->price, 0, ',' , '.') !!}</b><sup>₫</sup>
                            </span>                        
                            {{-- @endif --}}
                            
                        @endif
                    @else
                        <span class="sale">
                            &nbsp;<b>{!! number_format((float)$course->price, 0, ',' , '.') !!}</b><sup>₫</sup>
                        </span> 
                    @endif
                </div>
                <div class="clearfix"></div>
                @if (isset($btn_start_learning))  
                <div class="text-center">
                    <a href="{{ url('coming-soon') }}" class="btn btn-primary btn-sm btn-start-learning">Vào học</a>
                </div>
                @endif
            </div>
        </a>
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