@extends('frontends.layouts.app')
@section('content')
<div class="detail-teacher">
	<img class="background" src="{{ asset('frontend/images/banner_profile_teacher.png') }}" width="100%" >
	<div class="container">
		<div class="row">
			<div class="col-sm-12">
				<div class="item">
					<div class="frame clearfix">
						<div class="avatar pull-left">
							<img src="{{ url($info_teacher->userRole->user->avatar) }}" alt="" />
							<div class="info">
								<p class="name">{{ $info_teacher->userRole->user->name }}</p>
								<p class="expret">{{ $info_teacher->expert }}</p>
							</div>
						</div>
						<div class="network pull-right">
							<a class="btn btn-default btn-xs" href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode(url()->current()); ?>" target="_blank">
								<i class="fas fa-share-alt"></i> Share
							</a>
							<a  class="btn btn-default btn-xs" href="{{ url($info_teacher->userRole->user->facebook) }}" target="_blank">
								<i class="fab fa-facebook-square"></i> Facebook
							</a>
						</div>
					</div>
					<div class="frame_2">
						<div class="row">
							<div class="col-sm-6">
								<div class="desc scrollbar">
									{!! $info_teacher->cv !!}
								</div>
								<!-- <div class="see-more text-center">Show full biography</div> -->
								<div class="info-others">
									<ul>
										<li>
											<img src="{{ asset('frontend/images/ic_course.png') }}" alt="" /> 
											<span class="special">{{ $info_teacher->course_count }} Courses</span>
										</li>
										<li>
											<img src="{{ asset('frontend/images/icon_student.png') }}" alt="" /> 
											<span class="special">{{ $info_teacher->student_count }} Students</span>
										</li>
										<li>
											@include(
												'components.vote', 
												[
													'rate' => $info_teacher->rating_score,
                        							'rating_number' => $info_teacher->vote_count,
												]
											)
										</li>
									</ul>
								</div>
							</div>
							<div class="col-sm-6">
								<iframe src="{{ $info_teacher->video_intro }}"  frameborder="0" allowfullscreen></iframe>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

@include('frontends.all-courses')
@include('frontends.info-others')
@endsection