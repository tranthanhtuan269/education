<?php
    $lecturers = $course->author;
    $main_lecturer = 0;
    if( isset($course->teacherId) ){
        $main_lecturer = $course->teacherId;
    }else{
        $lecs = $course->Lecturers()->first();
        $main_lecturer = 1;
        if($lecs){
            if($lecs->user){
                $main_lecturer = $course->Lecturers()->first()->user->id;
            }
        }
    }
    $userId = 0;
    if( isset($course->userRoles[0]->user_id) ){
        $userId = $course->userRoles[0]->user_id;
    }elseif( isset($course->userRoleId) ){
        $userId = $course->userRoleId;
    }
?>
<div class="col-md-3 col-sm-6">
    <div class="box-course">
        <div class="box-info-course">
            <a title="{{ $course->name }}">
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
                                    @if( $userId != (int)(Auth::user()->id) )
                                        <button class="btn btn-success" data-id="{{ $course->id }}" data-image="{{ $course->image }}" data-lecturer="{{ $lecturers }}" data-name="{{ $course->name }}" data-price="{{ $course->price }}" data-real-price="{{ $course->real_price }}" data-slug="{{ $course->slug }}">
                                            <span class="img">
                                                <img src="{{asset("frontend/images/ic_add_to_card.png")}}" width="20px">
                                            </span>
                                            <span class="text">
                                                Thêm vào giỏ hàng
                                            </span>
                                        </button>
                                    @endif
                                @else
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
                        </div>                        
                    </div>               
                 </div>
            </a>
            <a href="{{ url('/') }}/course/{{ $course->id }}/{{ $course->slug }}" title="{{ $course->name }}">
                <div class="content-course">
                    <h3 class="title-course">{{ \Helper::smartStr($course->name) }}</h3>
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
                            <i class="fas fa-stopwatch"></i> {{ intval($course->duration / 3600) }}h {{ intval(($course->duration % 3600) / 60) }}m
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
                    {{-- @if (isset($btn_start_learning))  
                    <div class="text-center">
                        <a href="{{ url('coming-soon') }}" class="btn btn-primary btn-sm btn-start-learning">Vào học</a>
                    </div>
                    @endif --}}
                </div>
            </a>
        </div>
    </div>
</div>
{{-- @endif --}}
{{-- @endif --}}
<script>
    $('.content-course .name-teacher').on('click', function (e){
        e.stopPropagation()
        e.preventDefault()
        var teacherId = $(this).attr('data-teacher-id')
        window.location.href = `/teacher/${teacherId}`
    })
</script>