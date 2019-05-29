@extends('frontends.layouts.app')
@php
	$user_role_course_instance_video = json_decode($user_role_course_instance->videos);
	$video_count = count($user_role_course_instance_video->videos);
	$video_done_array = $user_role_course_instance_video->videos;
	$video_done_count = array_count_values($video_done_array)[1];
	$video_done_percent = (int)(($video_done_count/$video_count)*100);
	$lecturers = $info_course->Lecturers();
@endphp
@section('content')
<div class="course-learning-banner">
	<div class="container">
		<div class="row">
			<div class="col-sm-5">
				<iframe src="https://www.youtube.com/embed/PT2_F-1esPk" frameborder="0" allowfullscreen></iframe>
			</div>
			<div class="col-sm-7">
				<div class="left-intro">
					<h2>{{ $info_course->name }}</h2>
					<p class="meta-des">{{ $info_course->short_description }}</p>
					<div class="vote">
					<div class="continue"><a href="/learning-page/{{$info_course->id}}/lecture/{{$user_role_course_instance_video->learning_id}}" title="Continue">Continue to Lecture {{$user_role_course_instance_video->learning}}</a></div>
						<div class="rating">
							@if(Auth::check())
								@if(\App\Helper\Helper::getUserRoleOfCourse($info_course->id))
									<span class="" data-star="{{ isset($ratingCourse) ? $ratingCourse->score : 1 }}">
										@if($ratingCourse)
										@include(
											'components.vote', 
											[
												'rate' => $ratingCourse->score,
											]
										)
										@else
										<i id="star-1" class="far fa-star yellow-color" data-id="1"></i>
										<i id="star-2" class="far fa-star review-star" data-id="2"></i>
										<i id="star-3" class="far fa-star review-star" data-id="3"></i>
										<i id="star-4" class="far fa-star review-star" data-id="4"></i>
										<i id="star-5" class="far fa-star review-star" data-id="5"></i>
										@endif
									</span>
								@endif
							@endif
							<span data-toggle="modal" data-target="#editRatingModal" style="cursor: pointer">Edit your rating</span>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-9">
							<div class="number-unit">
								
								<p>{{$video_done_count}} of {{$video_count}} items complate</p>
							</div>
						</div>
						{{-- <div class="col-xs-3">
							<div class="cup-icon">
								<i class="fa fa-trophy fa-3x" aria-hidden="true"></i>
							</div>
						</div> --}}
					</div>
					<div class="course-progress-bar">
						<div class="progress border-element" style="width:82%">
							<div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="{{$video_done_percent}}" aria-valuemin="0" aria-valuemax="100" style="width: {{$video_done_percent}}%;">
							</div>
						</div>
						&nbsp;
						<div class="cup-progress" style="width:17%">
							@if ($video_done_percent == 100)
								<div class="progress" >
									<div class="progress-bar progress-bar-success" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
								</div>
								<i class="fa fa-trophy fa-2x" style="color: goldenrod"></i>	
							@else
								<div class="progress" >
									<div class="progress-bar bg-success" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
								</div>
								<i class="fa fa-trophy fa-2x"></i>
							@endif
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

{{-- EDIT RATING MODAL --}}
<div class="modal" id="editRatingModal" tabindex="-1" role="dialog">
	<div class="modal-dialog modal-sm" style="margin-top: 10%">
		<div class="modal-content">
			<div class="modal-header text-center">
				<span>EDIT YOUR RATING</span>
			</div>
			<div class="modal-body text-center">
				<h3>
					@if(Auth::check())
						@if(\App\Helper\Helper::getUserRoleOfCourse($info_course->id))
							<span class="reviews-star" data-star="{{ isset($ratingCourse) ? $ratingCourse->score : 1 }}">
								<i id="star-1" class="far fa-star yellow-color" data-id="1"></i>
								<i id="star-2" class="far fa-star review-star" data-id="2"></i>
								<i id="star-3" class="far fa-star review-star" data-id="3"></i>
								<i id="star-4" class="far fa-star review-star" data-id="4"></i>
								<i id="star-5" class="far fa-star review-star" data-id="5"></i>
							</span>
						@endif
					@endif
				</h3>
			</div>
			<div class="modal-footer" style="text-align:center !important;">
				<button class="btn btn-primary" id="btnEditRating">SAVE</button>
			</div>
		</div>
	</div>
</div>

{{-- SECOND BODY CONTAINER --}}
<div class="container">

	<div class="course-learning-content">
			{{-- NAV BAR aka MENU BAR --}}
		<div class="menu clearfix">
			<div class="col-sm-12">
				<ul>
					<li class="active">Overview</li>
					<li><a href="javascript:;" class="go-box" data-box="box_course_content">Course Content</a></li>
					<li><a href="javascript:;" class="go-box" data-box="box_document">Documents</a> </li>
					{{-- <li><a href="javascript:;" class="go-box" data-box="box_question">Q & A</a></li> --}}
				</ul>
			</div>
		</div>
			{{-- DESCRIPTIONS & DOCUMENT --}}
		<div class="row">
			<div class="col-sm-8">
				<div class="left-content">
					
					{{-- Description --}}
					<div class="desc">
						<h3>Description</h3>
						<p>{!! $info_course->description !!}</p>
					</div>
					<div class="lessons clearfix" id="box_course_content">
						@include('components.course-lesson-list', ['info_course' => $info_course])
					</div>

					{{-- Documents --}}
					<div class="course-document" id="box_document">
						<h3>Documents</h3>
						<div class="all-doc">
							@foreach ($info_course->units as $unit)
								@foreach ($unit->videos as $key_video => $video)
									@foreach ($video->documents as $document)
									
										<div class="lesson-doc">
											<div class="row">
												<div class="col-md-8">
													<div class="document-name">
														<i class="fa fa-download" aria-hidden="true"></i>
														&nbsp;
													<span>Lecture {{$document->video->id}}: &nbsp; {{$document->title}}</span>
													</div>
												</div>
												<div class="col-md-2">
													<a target="_blank" href="{{$document->url_document}}">
														<button class="btn btn-download-doc">Download</button>
													</a>
												</div>
												<div class="col-md-2">
													<div class="file-size">{{$document->size}} MB</div>
												</div>
											</div>
										</div>							
										
									@endforeach
								@endforeach
							@endforeach
						</div>
					</div>
				</div>
			</div>
			
				{{-- RIGHT-BAR --}}
			<div class="col-sm-4">
				{{-- Teacher Info --}}
				@if (count($lecturers) > 0)
					<div class="sidebar">
						@foreach ($lecturers as $lecturer)
						@php
							$ltr_name = $lecturer->user->name;
							$ltr_avatar = $lecturer->user->avatar;
							$ltr_expert = $lecturer->teacher->expert;
							$ltr_course_count = $lecturer->teacher->course_count;
							$ltr_student_count = $lecturer->teacher->student_count;
							$ltr_rating_count = $lecturer->teacher->rating_count;
							$ltr_rating_score = $lecturer->teacher->rating_score;
							$ltr_vote_count = $lecturer->teacher->vote_count;
						@endphp
							<div class="teacher-info">
								<p class="instructor">Instructor</p>
								<img class="avatar" src="{{asset($ltr_avatar)}}" alt="Avatar">
								<p class="name">{{$ltr_name}}</p>
								<p class="office"><span>{{$ltr_expert}}</span></p>
								<div class="total-course">
									<div class="row">
										<div class="col-xs-4">
											<div class="course-number">
												<i class="fa fa-book fa-lg" aria-hidden="true"></i>
												<span>{{$ltr_course_count}} courses</span>
											</div>
										</div>
										<div class="col-xs-8">
											<div class="rating pull-right">
												@include(
													'components.vote', 
													[
														'rate' => $ltr_rating_score,
														'rating_number' => $ltr_vote_count,
													]
												)
												{{-- <span>@for($i=1;$i<=4;$i++)<i class="fa fa-star fa-lg icon-star" aria-hidden="true"></i>@endfor<i class="fa fa-star-half fa-lg icon-star" aria-hidden="true"></i></span>
												<span>4.6</span>
												<span>(24 ratings)</span> --}}
											</div>
										</div>
									</div>
								</div>
								<div class="total-student">
									<div class="row">
										<div class="col-xs-5">
											<div class="student-number">
												<i class="fa fa-graduation-cap fa-lg" aria-hidden="true"></i>
												<span>{{$ltr_student_count}} Student</span>
											</div>
										</div>
										<div class="col-xs-7 pull-right">
											<div class="btn inbox">
												<a href="mailto:teacher@example.com?Subject=Hello" target="_top">
													<i class="fas fa-envelope fa-lg"></i>
													<span>Inbox</span>
												</a>
											</div>
										</div>
									</div>
								</div>
							</div>

						@endforeach
						</div>
					@endif
				<script>
					$(document).ready(function(){
						$('.sidebar').slick({
							autoplay: true,
							autoplaySpeed: 5000,
						});
					});
				</script>

				{{-- Related Course --}}
				<div class="relate-course">
					<p class="relate-title">Related Courses</p>
					<div class="list-course">
						@foreach ($related_courses as $related_course)
						@php
							// print_r($related_course);
						@endphp
							<div class="one-course">
								<div class="row">
									<div class="col-xs-6">
										<a href="/course/{{$related_course->slug}}">
											<img src="{{ asset($related_course->image)}}" alt="Courses" title="Courses">
										</a>
									</div>
									<div class="col-xs-6">
										<div class="title"><a href="/course/{{$related_course->slug}}">{{$related_course->name}}</a></div>
										{{-- <div class="teacher">with {{$info_course->Lecturers()->first()->user->name}}</div> --}}
										{{-- <div class="teacher">with {{$related_course->Lecturers()->first()->user->name}}</div> --}}
										<span class="time">{{$related_course->duration}}</span>
										<span class="pull-right level">{{$related_course->level == 0 ? "Beginner" : "Intermediate"}}</span>
									</div>
								</div>
							</div>						
						@endforeach
					</div>
					<div class="text-center">
						<a href="/category/{{$info_course->category->slug}}">
							<button type="button" class="btn btn-see-all">SEE ALL</button>
						</a>
					</div>
				</div>

			</div>
		</div>
	</div>
</div>

{{-- QUESTION ANSWER BOX --}}
@if (false)
<div class="course-learning-question" id="box_question">
	<div class="container">
		<h3 class="title">Questions & Answers</h3>
		<div class="text-box">
			<form>
				<div class="form-group">
				<textarea class="form-control" rows="10" placeholder="Type here"></textarea>
					{{-- <input type="text" class="form-control" id="name" placeholder="Type here"> --}}
				</div>
				<div class="btn-submit">
					<input class="submit-question" type="submit" value="SUBMIT A QUESTION" />
				</div>
			</form>
		</div>
	</div>
</div>
	
@endif


@if (false)
<div class="container">
		<div class="course-learning-review">
			<div class="reviews">
				@if(false)
				@include('components.question-answer')
				@endif
			</div>
			<div class="col-sm-12 btn-seen-all">
				<button type="button" class="btn">See all student feedback</button>
			</div>
		</div>
	</div>
	
@endif
@if(false)
<div class="container">
	<div class="course-recommend">
		<div class="row">
			<div class="col-sm-12">
				<h3>Student also bought</h3>
			</div>
			@for($i = 0; $i < 4; $i++)
				@include(
					'components.course', 
					[
						'id'	=> 1, //tam thoi
						'image' => 'https://static.unica.vn/upload/images/2019/04/giao-tiep-tieng-han-cho-nguoi-moi-bat-dau_m_1555561894.jpg',
						'title' => 'Giao tiếp tiếng Hàn dành cho người mới bắt đầu',
						'author' => 'Bảo Minh',
						'rating_number' => 3500,
						'time' => 2,
						'view_number' => 3600,
						'price' => 800000,
						'sale' => 600000,
					]
				)
			@endfor
		</div>
	</div>
</div>
@endif
<!-- Modal -->
<script>
    var baseURL = $('base').attr('href');

	function hideStar(){
		for(var j = 1; j <= 5; j++){
			$('#editRatingModal #star-' + j).removeClass('fa').addClass('far');
		}
	}

	function showStar(i){
		for(var j = 1; j <= i; j++){
			$('#editRatingModal #star-' + j).addClass('fa').removeClass('far');
		}
	}

	$('#editRatingModal .review-star').mouseenter(function(){
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
		$('#editRatingModal .review-star').off( "mouseenter")
		$('#editRatingModal .review-star').off( "mouseleave")
		$('#editRatingModal .reviews-star').attr('data-star', $(this).attr('data-id'))
	});

	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});
	$("#editRatingModal #btnEditRating").click(function (){
		var request = $.ajax({
			url: baseURL + '/stars/update',
			method: "PUT",
			data: {
				course_id: {{ $info_course->id }},
				score: $('.reviews-star').attr('data-star')
			},
			dataType: "json"
		})
		request.done(function (response){
			if(response.status == 200){
				Swal.fire({
					type: "success",
				}).then(function(result){
					if(result.value){
						$("#editRatingModal").modal('hide')
					}
				})
			}
		})
	})

</script>

<script type="text/javascript">
    $(document).ready(function() {  
        $('.go-box').click(function() {
            var box = $(this).attr('data-box');
            if($('#' + box).length) {
                var top_scroll = 0;
                top_scroll = $("#" + box).offset().top;
                $('html,body').animate({
                    scrollTop: top_scroll - 100
                }, 'slow');
            }
            // $('.box_header .menu-main.mobile').addClass('hidden-xs hidden-sm');
            // $('.go-box').removeClass('active');
            // $(this).addClass('active');
        });
    });
</script>
{{-- <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Modal title</h4>
			</div>
			<div class="modal-body">
				...
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				<button type="button" class="btn btn-primary">Save changes</button>
			</div>
		</div>
	</div>
</div> --}}
@endsection