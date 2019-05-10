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
				@for ($i = 0; $i < 3; $i++)
				<div class="row">
						<div class="col-sm-4">
							<a class="thumbnail-img" href="#">
								<img class="" src="{{ asset('frontend/images/banner_cat_sale.png') }}" height="335">
								<div class="explore">
									<h4> Developer {{ $i }}</h4>
									<p> PHP, Jquey, NodeJs</p>
								</div>
							</a>
						</div>
						<div class="col-sm-8">
							<div class="row">
								<div class="col-sm-6 item">
									<a class="thumbnail-img" href="#">
										<img class="" src="{{ asset('frontend/images/banner_cat_health.png') }}" >
										<div class="explore">
											<h4> Developer </h4>
											<p> PHP, Jquey, NodeJs</p>
										</div>
									</a>
								</div>
								<div class="col-sm-6 item">
									<a class="thumbnail-img" href="#">
											<img class="" src="{{ asset('frontend/images/banner_cat_technology.png') }}" >
											<div class="explore">
												<h4> Developer </h4>
												<p> PHP, Jquey, NodeJs</p>
											</div>
									</a>
								</div>
								<div class="col-sm-6">
										<a class="thumbnail-img" href="#">
											<img class="" src="{{ asset('frontend/images/banner_cat_lifestyle.png') }}" >
											<div class="explore">
												<h4> Developer </h4>
												<p> PHP, Jquey, NodeJs</p>
											</div>
										</a>
									</div>
								<div class="col-sm-6">
									<a class="thumbnail-img" href="#">
											<img class="" src="{{ asset('frontend/images/banner_cat_language.png') }}" >
											<div class="explore">
												<h4> Developer </h4>
												<p> PHP, Jquey, NodeJs</p>
											</div>
									</a>
								</div>
							</div>
						</div>
					</div>
				@endfor
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