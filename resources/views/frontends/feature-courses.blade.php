
@if (isset($feature_course[0]))
<div class="container">
    <div>
        <h2><strong>Khoá học tiêu biểu</strong></h2>
    </div>
    <div class="feature-course" style="margin-top: 1em;">
        @foreach ($feature_course as $key => $course)
            @if ($key % 3 == 0)
                <div class="row">
                    <div class="col-sm-7">
                        <a href="{{ url('/') }}/course/{{ $course->slug }}">
                            @if (strpos($feature_course[0]->image, 'unica') !== false)
                            <div class="top-feature-course" style="background-image:url({{ $course->image }}); width: 100%; height:390">
                            @else
                            <div class="top-feature-course" style="background-image:url({{ asset('frontend/images/'.$course->image) }}); width: 100%; height:390">
                            @endif
                                <div class="course-info">
                                <h3>{{ $course->name }}</h3>
                                    <div class="course-detail">
                                        <div class="course-info-author">
                                            @if (strpos($course->Lecturers()[0]->user->avatar, 'unica') !== false)
                                            <img src="{{ $course->Lecturers()[0]->user->avatar }}" alt="">
                                            @else
                                            <img src="{{url('frontend/'.$course->Lecturers()[0]->user->avatar)}}" alt="">
                                            @endif
                                            <span class="info-author-name">Giảng viên:<b> {{$course->Lecturers()[0]->user->name}}</b></span>
                                        </div>
                                        
                                        <div class="course-info-price">Học phí: <b style="font-size:20px">{{ number_format($course->price, 0, ',' , '.') }} ₫</b></div>
                                        
                                    </div>            
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-sm-5">
                        <div class="row"></div>
                    
            @else
                <div>
                    <a href="{{ url('/') }}/course/{{ $course->slug }}">
                        <div class="img-top">
                            @if (strpos($course->image, 'unica') !== false)
                            <div class="top-feature-course" style="background-image:url({{ $course->image }}); width: 100%; height:187">          <div class="course-info">
                                    <h5>{{ $course->name }}</h5>
                                </div>
                            </div>                  
                            @else
                            <div class="top-feature-course" style="background-image:url({{ asset('frontend/images/'.$course->image) }}); width: 100%; height:187">
                                <div class="course-info">
                                    <h5>{{ $course->name }}</h5>
                                </div>
                            </div>
                            @endif
                        </div>
                    </a>
                </div>

                @if (($key + 1) % 3 == 0)
                        </div>
                    </div>
                @endif
            @endif
        @endforeach
    </div>
</div>
</div>
@endif

<script type="text/javascript">
    $('.feature-course').slick({
        autoplay: true,
        arrows: false,
        infinite: true,
        dots: true,
        // fade: true
    });
</script>