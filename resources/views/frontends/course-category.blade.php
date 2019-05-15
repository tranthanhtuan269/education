@extends('frontends.layouts.app')
@section('content')
<div class="background-page">
	<img class="" src="{{ asset('frontend/images/banner_profile_teacher.png') }}" width="100%" >
	<div class='container'>
		<div class="highlight">
			<div class="row title">
				<div class="col-sm-12">
					<p>Explore topics & skills</p>	
				</div>
			</div>
			<div class="slider">
				@foreach ($feature_category as $key => $feature)
					@if ($key % 5 == 0)
						<div class="row">
							<div class="col-sm-5">
								<a href="{{ url('/') }}/category/{{ $feature->slug }}" title="{{ $feature->name }}" class="thumbnail-img">
									<img class="" src="{{ url('/frontend/images/'.$feature->image) }}" alt="{{ $feature->name }}" height="290">
									<div class="explore">
										<h4 class="big-course">{{ $feature->name }}</h4>
										<p class="big-course">Over {{ $feature->course_count }} courses</p>
									</div>
								</a>
							</div>
							<div class="col-sm-7">
								<div class="row">
						@else
							<div class="col-sm-6 item">
								<a href="{{ url('/') }}/category/{{ $feature->slug }}" title="{{ $feature->name }}" class="thumbnail-img">
									<img class="" src="{{ url('/frontend/images/'.$feature->image) }}" alt="{{ $feature->name }}" >
									<div class="explore">
										<h4>{{ $feature->name }}</h4>
										<p>Over {{ $feature->course_count }} courses</p>
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
		</div>
	</div>
</div>
<script type="text/javascript">
	$('.slider').slick({
	    autoplay: true,
	    arrows: false,
	    dots: true,
	    fade: true
    });
</script>

@include('frontends.feature-courses')
@include('frontends.all-courses')
@include('frontends.popular-teacher')
@include('frontends.info-others')

@endsection