@extends('frontends.layouts.app')
@section('content')
<div class="background-page">
	<img class="" src="{{ asset('frontend/images/banner_profile_teacher.png') }}" width="100%" >
	<div class='container'>
		<div class="row highlight">
			<div class="col-sm-12">
				<p>Expolde topics & skills</p>	
			</div>
		</div>
		<div class="slider">
			
			<div class="row">
				<div class="col-sm-4"><img class="" src="{{ asset('frontend/images/featured_hero_big.png') }}" ></div>
				<div class="col-sm-8">
					<div class="row">
						<div class="col-sm-6 item"><img class="" src="{{ asset('frontend/images/featured_hero_3.png') }}"></div>
						<div class="col-sm-6 item"><img class="" src="{{ asset('frontend/images/featured_hero_1.png') }}" ></div>
						<div class="col-sm-6"><img class="" src="{{ asset('frontend/images/featured_hero_3.png') }}"></div>
						<div class="col-sm-6"><img class="" src="{{ asset('frontend/images/featured_hero_1.png') }}" ></div>
					</div>
				</div>
			</div>
	
			<div class="row">
				<div class="col-sm-4"><img class="" src="{{ asset('frontend/images/featured_hero_big.png') }}" ></div>
				<div class="col-sm-8">
					<div class="row">
						<div class="col-sm-6 item"><img class="" src="{{ asset('frontend/images/featured_hero_3.png') }}"></div>
						<div class="col-sm-6 item"><img class="" src="{{ asset('frontend/images/featured_hero_1.png') }}" ></div>
						<div class="col-sm-6"><img class="" src="{{ asset('frontend/images/featured_hero_3.png') }}"></div>
						<div class="col-sm-6"><img class="" src="{{ asset('frontend/images/featured_hero_1.png') }}" ></div>
					</div>
				</div>
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
@include('frontends.info-others')

@endsection