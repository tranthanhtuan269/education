@extends('frontends.layouts.app')
@section('title')
Giảng viên: {{ $info_teacher->userRole->user->name }}
@stop
@section('content')
<div class="detail-teacher">
	<img class="background bg-detail-teacher" src="{{ asset('frontend/images/banner_profile_teacher.png') }}">
	<div class="container">
		<div class="row">
			<div class="col-sm-12">
				<div class="item">
					<div class="frame clearfix frame-top">
						<div class="avatar pull-left">
							@if($info_teacher->userRole->user)
								@if (strpos($info_teacher->userRole->user->avatar, 'unica') !== false)
								<img src="{{ $info_teacher->userRole->user->avatar }}" alt="" />
								@else
								<img src="{{ url('frontend/'.$info_teacher->userRole->user->avatar) }}" alt="" />
								@endif
								<div class="info">
									<p class="name">{{ $info_teacher->userRole->user->name }}</p>
									<p class="expret">{{ $info_teacher->expert }}</p>
								</div>
							@endif
						</div>
						<div class="network pull-right network-teacher">
							<a class="btn btn-facebook-share btn-xs" style="color: #4267b2;" href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode(url()->current()); ?>" target="_blank">
								<b>
									<i class="fas fa-share-alt-square fa-fw fa-lg"></i> Chia sẻ Facebook
								</b>
							</a>
							@if($info_teacher->userRole->user)
								@if ( $info_teacher->userRole->user->facebook )
								<a  class="btn btn-facebook-share btn-xs" style="color: #4267b2;" href="{{ $info_teacher->userRole->user->facebook }}" target="_blank">
									<b>
										<i class="fab fa-facebook-square fa-fw fa-lg"></i> Facebook Giảng viên
									</b>
								</a>
								@endif
							@endif
						</div>
					</div>
					<div class="frame_2 frame_2-top">
						<div class="row">
							<div class="col-sm-6">
								<div class="desc scrollbar">
									{!! $info_teacher->cv !!}
								</div>
								<div class="info-others clearfix">
									<ul>
										<li>
											<img src="{{ asset('frontend/images/ic_course.png') }}" alt="" /> 
											<span class="special">{{ count($info_teacher->userRole->userCoursesByTeacher()->where('status', 1)) }} Khóa học</span>
										</li>
										<li>
											<img src="{{ asset('frontend/images/ic_student.png') }}" alt="" /> 
											<span class="special">{{ $info_teacher->student_count }} Học viên</span>
										</li>
										{{-- <li>
											@include(
												'components.vote', 
												[
													'rate' => $info_teacher->rating_score,
                        							'rating_number' => $info_teacher->vote_count,
												]
											)
										</li> --}}
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
<div class="container">
	<div class="row">
		<div class="col-xs-12 clearfix title-module-home">
			<div class="pull-left">
				@if($info_teacher->userRole->user)
				<h3>Khóa học của giảng viên {{$info_teacher->userRole->user->name}}</h3>
				@endif
			</div>
		</div><br><br>
		<div class="col-sm-12">
			@foreach($courses_of_teacher as $course)
			@include(
				'components.course-of-teacher',
				[
					'course' => $course
				]
				)
			@endforeach
		</div>
	</div>
</div>

{{-- @php
	$isTeacher = false;
	if(Auth::check()){
		$userRoles = Auth::user()->userRoles;
		foreach ($userRoles as $key => $userRole) {
			if($userRole->role_id == 2){
				$isTeacher = true;
			}
		}
	}
@endphp --}}
{{-- @if (!$isTeacher)
	<div class="become-teacher">
    <div class="container">
        <div class="row">
            <div class="col-sm-10 col-sm-offset-1">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="ads-teacher">
                            <p>TRỞ THÀNH</p>
                            <h2>GIẢNG VIÊN <br>COURDEMY</h2>
                            <a href="{{ Auth::check() ? url('user/register-teacher') : 'javascript:void(0)' }}" title="Register Teacher" {{ Auth::check() ? '' : ' data-toggle=modal data-target=#myModalLogin data-dismiss=modal id=redirect_register_teacher' }}>ĐĂNG KÝ NGAY</a>
                        </div>
                    </div>
                    <div class="col-sm-6 hidden-xs">
                        <div class="row">
                            <div class="col-xs-8 col-xs-offset-1">
                                <img src="{{ asset('frontend/images/courdemy-teacher.png') }}" alt="Teacher" />  
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endif --}}
{{-- @include('frontends.info-others') --}}
@endsection