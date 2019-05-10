<?php //dd($feature_course); ?>
<div class="container">
    <div class="feature-course">
        <div class="row">
            <div class="col-xs-12 title-module-home">
                <h2>Featured Courses</h2>
            </div>

            <div class="col-sm-7">
                <a href="{{ url('/') }}/course/{{ $feature_course[0]->id }}" title="{{ $feature_course[0]->name }}">
                    <img  alt="{{ $feature_course[0]->name }}" src="{{ asset('frontend/images/'.$feature_course[0]->image) }}" height="390">
                </a>
            </div>

            <div class="col-sm-5">
                <div class="img-top">
                    <a href="{{ url('/') }}/course/{{ $feature_course[1]->id }}" title="{{ $feature_course[1]->name }}">
                        <img  alt="{{ $feature_course[1]->name }}" src="{{ asset('frontend/images/'.$feature_course[1]->image) }}" height="187">
                    </a>
                </div>
                <div class="img-bottom">
                    <a href="{{ url('/') }}/course/{{ $feature_course[2]->id }}" title="{{ $feature_course[2]->name }}">
                        <img  alt="{{ $feature_course[2]->name }}" src="{{ asset('frontend/images/'.$feature_course[2]->image) }}" height="187">
                    </a>
                </div>
            </div>
            
        </div>
    </div>
</div>