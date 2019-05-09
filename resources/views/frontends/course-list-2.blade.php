@extends('frontends.layouts.app')
@section('content')
<div class="course-list-top">
	<img class="banner" src="{{ asset('frontend/images/banner_profile_teacher.png') }}" alt="Banner Course List">
	<div class="container">
		<div class="box-container-top">
			<div class="title-bar">
				<div class="row">
					<div class="col-lg-6">
						<h1 class="title-page">GRAPHIC DESIGN</h1>
					</div>
					<div class="col-lg-6">
						<div class="clearfix">
							<button class="btn btn-remove pull-right">
								<i class="fa fa-heart fa-lg" aria-hidden="true"></i>&nbsp;
								<span>Remove from wishlist</span>
							</button>
							<button class="btn btn-share pull-right">
								<i class="fa fa-share-alt" aria-hidden="true"></i>&nbsp;
								<span>Share</span>
							</button>
							<span class="course-number pull-right">1.200 Courses</span>
						</div>
					</div>
				</div>
			</div>
			<div class="course-list-slider">
				@for($i=1;$i<=1;$i++)
				<div class="top-course">
					<div class="row">
						<div class="col-sm-5"><img src="{{ asset('frontend/images/learning-python.png') }}" alt="Learning Python" title="Learning Python"></div>
						<div class="col-sm-7">
							<div class="course-info">
								<h3 class="post-title">Learning Python</h3>
								<div class="clearfix last-update">
									<div class="pull-left">Last Update: May 2019</div>
									<div class="pull-right">
										<i class="fa fa-heart fa-lg" aria-hidden="true"></i>
										<span>4.6(100 Ratings)</span>
									</div>
								</div>
								<p class="instructor">Creating A Mobile App Product from Scratch | By Merai S.Syed</p>
								<div class="time-view">
									<span class="duration">
										<i class="fa fa-clock fa-lg" aria-hidden="true"></i>&nbsp;
										<span>2h 11m</span>
									</span>
									<span class="view">
										<i class="fa fa-eye" aria-hidden="true"></i>&nbsp;
										<span>81.000 views</span>
									</span>
									<span class="unit">
										<i class="fa fa-book fa-lg" aria-hidden="true"></i>&nbsp;
										<span>26 Lectures - All Levels</span>
									</span>
								</div>
								<div class="clearfix">
									<div class="pull-left"><button class="btn btn-explore">EXPLORE COURSE</button></div>
									<div class="pull-right"><span class="imaginary"><s>700.000đ</s></span><span class="real">400.000đ</span></div>
								</div>
							</div>
						</div>
					</div>
				</div>
				@endfor
			</div>
		</div>
	</div>
</div>
@include('frontends.all-courses')
@include('frontends.popular-teacher')
@include('frontends.info-others')
{{-- <script type="text/javascript">
	$('.course-list-slider').slick({
		autoplay: true,
		arrows: false,
		dots: true,
		fade: true
	});
</script> --}}
@endsection