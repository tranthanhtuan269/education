
@if (isset($feature_course[0]))
<div class="container">
    <div class="feature-course">
        <div class="row">
            <div class="col-xs-12 title-module-home mt-xs-30px">
                <h2>Featured Courses</h2>
            </div>
            @if (isset($feature_course[0]))
            <div class="col-sm-7 mt-xs-120px">
                <a href="{{ url('/') }}/course/{{ $feature_course[0]->slug }}" title="{{ $feature_course[0]->name }}">
                    <img  alt="{{ $feature_course[0]->name }}" src="{{ asset('frontend/images/'.$feature_course[0]->image) }}" height="390">
                </a>
            </div>
            @endif

            <div class="col-sm-5">
                @if (isset($feature_course[1]))
                <div class="img-top">
                    <a href="{{ url('/') }}/course/{{ $feature_course[1]->slug }}" title="{{ $feature_course[1]->name }}">
                        <img  alt="{{ $feature_course[1]->name }}" src="{{ asset('frontend/images/'.$feature_course[1]->image) }}" height="187">
                    </a>
                </div>
                @endif

                @if (isset($feature_course[2]))
                <div class="img-bottom">
                        <a href="{{ url('/') }}/course/{{ $feature_course[2]->slug }}" title="{{ $feature_course[2]->name }}">
                            <img  alt="{{ $feature_course[2]->name }}" src="{{ asset('frontend/images/'.$feature_course[2]->image) }}" height="187">
                        </a>
                </div>
                @endif

            </div>
            
        </div>
    </div>
</div>
@endif