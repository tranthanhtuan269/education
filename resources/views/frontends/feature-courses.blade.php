
@if (isset($feature_course[0]))
<div class="container">
    <div class="feature-course">
        <div class="row">
            <div class="col-xs-12 title-module-home mt-xs-30px">
                <h2>Khóa học nổi bật</h2>
            </div>
            @if (isset($feature_course[0]))
            <div class="col-sm-7 mt-xs-120px">
                <a href="{{ url('/') }}/course/{{ $feature_course[0]->slug }}">
                    @if (strpos($feature_course[0]->image, 'unica') !== false)
                    <div class="top-feature-course" style="background-image:url({{ $feature_course[0]->image }}); width: 100%; height:390">
                    @else
                    <div class="top-feature-course" style="background-image:url({{ asset('frontend/images/'.$feature_course[0]->image) }}); width: 100%; height:390">
                    @endif
                        <div class="course-info">
                        <h3>{{ $feature_course[0]->name }}</h3>
                            <div class="course-detail">
                                <div class="course-info-author">
                                    @if (strpos($feature_course[0]->Lecturers()[0]->user->avatar, 'unica') !== false)
                                    <img src="{{ $feature_course[0]->Lecturers()[0]->user->avatar }}" alt="">
                                    @else
                                    <img src="{{url('frontend/'.$feature_course[0]->Lecturers()[0]->user->avatar)}}" alt="">
                                    @endif
                                    <span class="info-author-name">Giảng viên:<b> {{$feature_course[0]->Lecturers()[0]->user->name}}</b></span>
                                </div>
                                
                                <div class="course-info-price">Học phí: <b style="font-size:20px">{{ number_format($feature_course[0]->price, 0, ',' , '.') }} ₫</b></div>
                                
                            </div>

                            <!-- <h3>{{ $feature_course[0]->name }}</h3> -->
                        </div>
                    </div>
                    <!-- <a href="{{ url('/') }}/course/{{ $feature_course[0]->slug }}" title="{{ $feature_course[0]->name }}">
                        <img  alt="{{ $feature_course[0]->name }}" src="{{ asset('frontend/images/'.$feature_course[0]->image) }}" height="390">
                    </a> -->
                </a>
            </div>
            @endif
            <div class="col-sm-5">
                    @if (isset($feature_course[1]))
                    <a href="{{ url('/') }}/course/{{ $feature_course[1]->slug }}">
                        <div class="img-top">
                            <!-- <a href="{{ url('/') }}/course/{{ $feature_course[1]->slug }}" title="{{ $feature_course[1]->name }}">
                                <img  alt="{{ $feature_course[1]->name }}" src="{{ asset('frontend/images/'.$feature_course[1]->image) }}" height="187">
                            </a> -->
                            @if (strpos($feature_course[1]->image, 'unica') !== false)
                            <div class="top-feature-course" style="background-image:url({{ $feature_course[1]->image }}); width: 100%; height:187">          <div class="course-info">
                                    <h5>{{ $feature_course[1]->name }}</h5>
                                </div>
                            </div>                  
                            @else
                            <div class="top-feature-course" style="background-image:url({{ asset('frontend/images/'.$feature_course[1]->image) }}); width: 100%; height:187">
                                <div class="course-info">
                                    <h5>{{ $feature_course[1]->name }}</h5>
                                </div>
                            </div>
                            @endif
                        </div>
                    </a>
                    @endif

                    @if (isset($feature_course[2]))
                    <a href="{{ url('/') }}/course/{{ $feature_course[2]->slug }}">
                        <div class="img-top">
                            <!-- <a href="{{ url('/') }}/course/{{ $feature_course[2]->slug }}" title="{{ $feature_course[2]->name }}">
                                <img  alt="{{ $feature_course[2]->name }}" src="{{ asset('frontend/images/'.$feature_course[2]->image) }}" height="187">
                            </a> -->
                            @if (strpos($feature_course[2]->image, 'unica') !== false)
                            <div class="top-feature-course" style="background-image:url({{ $feature_course[2]->image }}); width: 100%; height:187">          <div class="course-info">
                                    <h5>{{ $feature_course[2]->name }}</h5>
                                </div>
                            </div>                  
                            @else
                            <div class="top-feature-course" style="background-image:url({{ asset('frontend/images/'.$feature_course[2]->image) }}); width: 100%; height:187">
                                <div class="course-info">
                                    <h5>{{ $feature_course[2]->name }}</h5>
                                </div>
                            </div>
                            @endif
                        </div>
                    </a>
                    @endif                    
            </div>            
        </div>

        <div class="row">
            <div class="col-xs-12 title-module-home mt-xs-30px">
                <h2>Khóa học nổi bật</h2>
            </div>
            @if (isset($feature_course[0]))
            <div class="col-sm-7 mt-xs-120px">
                <a href="{{ url('/') }}/course/{{ $feature_course[0]->slug }}">
                    @if (strpos($feature_course[0]->image, 'unica') !== false)
                    <div class="top-feature-course" style="background-image:url({{ $feature_course[0]->image }}); width: 100%; height:390">
                    @else
                    <div class="top-feature-course" style="background-image:url({{ asset('frontend/images/'.$feature_course[0]->image) }}); width: 100%; height:390">
                    @endif
                        <div class="course-info">
                        <h3>{{ $feature_course[0]->name }}</h3>
                            <div class="course-detail">
                                <div class="course-info-author">
                                    @if (strpos($feature_course[0]->Lecturers()[0]->user->avatar, 'unica') !== false)
                                    <img src="{{ $feature_course[0]->Lecturers()[0]->user->avatar }}" alt="">
                                    @else
                                    <img src="{{url('frontend/'.$feature_course[0]->Lecturers()[0]->user->avatar)}}" alt="">
                                    @endif
                                    <span class="info-author-name">Giảng viên:<b> {{$feature_course[0]->Lecturers()[0]->user->name}}</b></span>
                                </div>
                                
                                <div class="course-info-price">Học phí: <b style="font-size:20px">{{ number_format($feature_course[0]->price, 0, ',' , '.') }} ₫</b></div>
                                
                            </div>

                            <!-- <h3>{{ $feature_course[0]->name }}</h3> -->
                        </div>
                    </div>
                    <!-- <a href="{{ url('/') }}/course/{{ $feature_course[0]->slug }}" title="{{ $feature_course[0]->name }}">
                        <img  alt="{{ $feature_course[0]->name }}" src="{{ asset('frontend/images/'.$feature_course[0]->image) }}" height="390">
                    </a> -->
                </a>
            </div>
            @endif
            <div class="col-sm-5">
                    @if (isset($feature_course[1]))
                    <a href="{{ url('/') }}/course/{{ $feature_course[1]->slug }}">
                        <div class="img-top">
                            <!-- <a href="{{ url('/') }}/course/{{ $feature_course[1]->slug }}" title="{{ $feature_course[1]->name }}">
                                <img  alt="{{ $feature_course[1]->name }}" src="{{ asset('frontend/images/'.$feature_course[1]->image) }}" height="187">
                            </a> -->
                            @if (strpos($feature_course[1]->image, 'unica') !== false)
                            <div class="top-feature-course" style="background-image:url({{ $feature_course[1]->image }}); width: 100%; height:187">          <div class="course-info">
                                    <h5>{{ $feature_course[1]->name }}</h5>
                                </div>
                            </div>                  
                            @else
                            <div class="top-feature-course" style="background-image:url({{ asset('frontend/images/'.$feature_course[1]->image) }}); width: 100%; height:187">
                                <div class="course-info">
                                    <h5>{{ $feature_course[1]->name }}</h5>
                                </div>
                            </div>
                            @endif
                        </div>
                    </a>
                    @endif

                    @if (isset($feature_course[2]))
                    <a href="{{ url('/') }}/course/{{ $feature_course[2]->slug }}">
                        <div class="img-top">
                            <!-- <a href="{{ url('/') }}/course/{{ $feature_course[2]->slug }}" title="{{ $feature_course[2]->name }}">
                                <img  alt="{{ $feature_course[2]->name }}" src="{{ asset('frontend/images/'.$feature_course[2]->image) }}" height="187">
                            </a> -->
                            @if (strpos($feature_course[2]->image, 'unica') !== false)
                            <div class="top-feature-course" style="background-image:url({{ $feature_course[2]->image }}); width: 100%; height:187">          <div class="course-info">
                                    <h5>{{ $feature_course[2]->name }}</h5>
                                </div>
                            </div>                  
                            @else
                            <div class="top-feature-course" style="background-image:url({{ asset('frontend/images/'.$feature_course[2]->image) }}); width: 100%; height:187">
                                <div class="course-info">
                                    <h5>{{ $feature_course[2]->name }}</h5>
                                </div>
                            </div>
                            @endif
                        </div>
                    </a>
                    @endif                    
            </div>            
        </div>
    </div>
</div>
</div>
@endif

{{-- @if (count($tags) > 0)
<div class="slider">
    @foreach ($tags as $key => $tag)
        @if ($key % 5 == 0)
            <div class="row">
                <div class="col-sm-5">
                    <a href="{{ url('/') }}/tags/{{ $tag->slug }}" title="{{ $tag->name }}" class="thumbnail-img">
                        <img class="" src="{{ url('/frontend/'.$tag->image) }}" alt="{{ $tag->name }}" height="290">
                        <div class="explore">
                            <h4 class="big-course">{{ $tag->name }}</h4>
                            @if($tag->course_count)
                            <p class="big-course">Hơn {{ $tag->course_count }} khóa học</p>
                            @endif
                        </div>
                    </a>
                </div>
                <div class="col-sm-7 hidden-xs">
                    <div class="row">
        @else
                <div class="col-sm-6 item">
                    <a href="{{ url('/') }}/tags/{{ $tag->slug }}" title="{{ $tag->name }}" class="thumbnail-img">
                        <img class="box-full-height" src="{{ url('/frontend/'.$tag->image) }}" alt="{{ $tag->name }}" >
                        <div class="explore">
                            <h4>{{ $tag->name }}</h4>
                            @if($tag->course_count)
                            <p>Hơn {{ $tag->course_count }} khóa học</p>
                            @endif
                        </div>
                    </a>
                </div>
                @if (($key + 1) % 5 == 0)
                            </div>
                        </div>
                    </div>
                @endif
        @endif
    @endforeach
</div>
@endif --}}
<script type="text/javascript">
    $('.feature-course').slick({
        autoplay: true,
        arrows: true,
        infinite: true,
        dots: true,
        // fade: true
    });
</script>