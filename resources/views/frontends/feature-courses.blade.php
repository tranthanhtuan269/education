
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
                        <div class="top-feature-course" style="background-image:url({{ $feature_course[1]->image }}); width: 100%; height:187">                            
                        @else
                        <div class="top-feature-course" style="background-image:url({{ asset('frontend/images/'.$feature_course[1]->image) }}); width: 100%; height:187">
                        @endif
                            <div class="course-info">
                                <h5>{{ $feature_course[1]->name }}</h5>
                            </div>
                        </div>
                    </div>
                </a>
                @endif

                @if (isset($feature_course[2]))
                <a href="{{ url('/') }}/course/{{ $feature_course[2]->slug }}">
                    <div class="img-bottom">
                            <!-- <a href="{{ url('/') }}/course/{{ $feature_course[2]->slug }}" title="{{ $feature_course[2]->name }}">
                                <img  alt="{{ $feature_course[2]->name }}" src="{{ asset('frontend/images/'.$feature_course[2]->image) }}" height="187">
                            </a> -->
                        @if (strpos($feature_course[1]->image, 'unica') !== false)
                        <div class="top-feature-course" style="background-image:url({{ $feature_course[2]->image }}); width: 100%; height:187">                            
                        @else
                        <div class="top-feature-course" style="background-image:url({{ asset('frontend/images/'.$feature_course[2]->image) }}); width: 100%; height:187">
                        @endif
                        <div class="course-info">
                            <h5>{{ $feature_course[2]->name }}</h5>
                        </div>
                    </div>
                </a>
                @endif

            </div>
            
        </div>
    </div>
</div>
</div>
@endif