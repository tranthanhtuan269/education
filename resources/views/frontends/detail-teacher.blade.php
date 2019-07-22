@extends('frontends.layouts.app')
@section('content')
<div class="detail-teacher">
	<img class="background bg-category" src="{{ asset('frontend/images/banner_profile_teacher.png') }}">
	<div class="container">
		<div class="row">
			<div class="col-sm-12">
				<div class="item">
					<div class="frame clearfix frame-top">
						<div class="avatar pull-left">
							<img src="{{ url('frontend/'.$info_teacher->userRole->user->avatar) }}" alt="" />
							<div class="info">
								<p class="name">{{ $info_teacher->userRole->user->name }}</p>
								<p class="expret">{{ $info_teacher->expert }}</p>
							</div>
						</div>
						<div class="network pull-right network-teacher">
							<a class="btn btn-default btn-xs" href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode(url()->current()); ?>" target="_blank">
								<i class="fas fa-share-alt"></i> Share Fb
							</a>
							<a  class="btn btn-default btn-xs" href="{{ url($info_teacher->userRole->user->facebook) }}" target="_blank">
								<i class="fab fa-facebook-square"></i> Fb Teacher
							</a>


							@if(Auth::check())
								@if(Helper::getUserRoleOfTeacher($info_teacher->user_role_id) )
									<div class="rating big">
										<span class="reviews-star" data-star="{{ isset($ratingTeacher) ? $ratingTeacher->score : 1 }}">
											@if($ratingTeacher)
											@include(
												'components.vote', 
												[
													'rate' => $ratingTeacher->score,
												]
											)
											<span data-toggle="modal" data-target="#editRatingModal" class="edit-rating">Edit your rating</span>
											
											{{-- EDIT RATING MODAL --}}
											<div class="modal" id="editRatingModal" tabindex="-1" role="dialog">
												<div class="modal-dialog modal-sm" style="margin-top: 10%">
													<div class="modal-content">
														<div class="modal-header text-center">
															<span>EDIT YOUR RATING</span>
														</div>
														<div class="modal-body text-center">
															<h3>
																<span class="reviews-star" data-star="{{ isset($ratingTeacher) ? $ratingTeacher->score : 1 }}">
																	<i id="star-1" class="far fa-star review-star" data-id="1"></i>
																	<i id="star-2" class="far fa-star review-star" data-id="2"></i>
																	<i id="star-3" class="far fa-star review-star" data-id="3"></i>
																	<i id="star-4" class="far fa-star review-star" data-id="4"></i>
																	<i id="star-5" class="far fa-star review-star" data-id="5"></i>
																</span>
															</h3>
														</div>
														<div class="modal-footer" style="text-align:center !important;">
															<button class="btn btn-primary" id="btnEditRating">SAVE</button>
														</div>
													</div>
												</div>
											</div>
											@else
											<span class="star-rate edit">
												<i id="star-1" class="far fa-star review-star" data-id="1"></i>
												<i id="star-2" class="far fa-star review-star" data-id="2"></i>
												<i id="star-3" class="far fa-star review-star" data-id="3"></i>
												<i id="star-4" class="far fa-star review-star" data-id="4"></i>
												<i id="star-5" class="far fa-star review-star" data-id="5"></i>
											</span>
											@endif
										</span>
									</div>
									<script>
										function hideStar(){
											for(var j = 1; j <= 5; j++){
												$('#star-' + j).removeClass('fa').addClass('far');
											}
										}
					
										function showStar(i){
											for(var j = 1; j <= i; j++){
												$('#star-' + j).addClass('fa').removeClass('far');
											}
										}
					
										$('.review-star').mouseenter(function(){
											switch($(this).attr('data-id')){
												case "1":
													hideStar();showStar(1);
													break;
												case "2":
													hideStar();showStar(2);
													break;
												case "3":
													hideStar();showStar(3);
													break;
												case "4":
													hideStar();showStar(4);
													break;
												case "5":
													hideStar();showStar(5);
													break;
											}
										}).mouseleave(function(){
											hideStar();
										}).click(function(){
											showStar($(this).attr('data-id'))
											$('.review-star').off( "mouseenter")
											$('.review-star').off( "mouseleave")
											$('.reviews-star').attr('data-star', $(this).attr('data-id'))
											if ($('.star-rate.edit').length > 0) {
												$.ajaxSetup({
													headers: {
														'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
													}
												});
	
												var request = $.ajax({
													url: '{{ url("stars-teacher/insert") }}',
													method: 'POST',
													data: {
														teacher_id: {{ $info_teacher->user_role_id }},
														score: $('.reviews-star').attr('data-star')
													},
													dataType: "json",
												})
												request.done(function (response){
													if(response.status == 200){
														Swal.fire({
															type: "success",
															html: response.message,
														}).then(function(result){
															if(result.value){
																location.reload();
															}
														})
													}
												})
											}
										});

										$.ajaxSetup({
											headers: {
												'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
											}
										});
										$("#btnEditRating").click(function (){
											var request = $.ajax({
												url: '{{ url("stars-teacher/update") }}',
												method: "PUT",
												data: {
													teacher_id: {{ $info_teacher->user_role_id }},
													score: $('.reviews-star').attr('data-star')
												},
												dataType: "json"
											})
											request.done(function (response){
												if(response.status == 200){
													Swal.fire({
														type: "success",
														html: response.message,
													}).then(function(result){
														if(result.value){
															location.reload();
														}
													})
												}
											})
										})
									</script>
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
								<!-- <div class="see-more text-center">Show full biography</div> -->
								<div class="info-others clearfix">
									<ul>
										<li>
											<img src="{{ asset('frontend/images/ic_course.png') }}" alt="" /> 
											<span class="special">{{ $info_teacher->course_count }} Courses</span>
										</li>
										<li>
											<img src="{{ asset('frontend/images/ic_student.png') }}" alt="" /> 
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
@php
	$isTeacher = false;
	if(Auth::check()){
		$userRoles = Auth::user()->userRoles;
		foreach ($userRoles as $key => $userRole) {
			if($userRole->role_id == 2){
				$isTeacher = true;
			}
		}
	}
@endphp
@if (!$isTeacher)
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
@endif
{{-- @include('frontends.info-others') --}}
@endsection