@extends('frontends.layouts.app')
@section('content')
<div class="background-page">
	<img class="bg-category" src="{{ asset('frontend/images/banner_profile_teacher.png') }}">
	<div class='container'>
		<div class="highlight">
			<div class="row title">
				<div class="col-sm-12">
					<p>Explore topics & skills</p>	
				</div>
			</div>
			@if (count($tags) > 0)
			<div class="slider">
				@foreach ($tags as $key => $tag)
					@if ($key % 5 == 0)
						<div class="row">
							<div class="col-sm-5">
								<a href="{{ url('/') }}/tags/{{ $tag->slug }}" title="{{ $tag->name }}" class="thumbnail-img">
									<img class="" src="{{ url('/frontend/'.$tag->image) }}" alt="{{ $tag->name }}" height="290">
									<div class="explore">
										<h4 class="big-course">{{ $tag->name }}</h4>
										<p class="big-course">Over {{ $tag->course_count }} courses</p>
									</div>
								</a>
							</div>
							<div class="col-sm-7 disable-on-mobile">
								<div class="row">
					@else
							<div class="col-sm-6 item">
								<a href="{{ url('/') }}/tags/{{ $tag->slug }}" title="{{ $tag->name }}" class="thumbnail-img">
									<img class="box-full-height" src="{{ url('/frontend/'.$tag->image) }}" alt="{{ $tag->name }}" >
									<div class="explore">
										<h4>{{ $tag->name }}</h4>
										<p>Over {{ $tag->course_count }} courses</p>
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
			<script type="text/javascript">
				$('.slider').slick({
					autoplay: true,
					arrows: false,
					dots: true,
					fade: true
				});
			</script>
			@endif
		</div>
	</div>
</div>


@include('frontends.feature-courses')
@include('frontends.all-courses')
@include('frontends.popular-teacher')
@include('frontends.info-others')

@endsection