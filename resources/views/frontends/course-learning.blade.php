@extends('frontends.layouts.app')
@section('content')
<div class="banner-course-learning">
	<div class="container">
		<div class="row">
			<div class="col-sm-5">
				<iframe src="https://www.youtube.com/embed/PT2_F-1esPk" frameborder="0" allowfullscreen></iframe>
			</div>
			<div class="col-sm-7 left-intro">
				<h2>Unread Engine C++ Developer: Learn C++ and Make Video Games</h2>
				<p class="meta-des">Linux Troubleshooting and Administration</p>
				<div class="vote">
					<div class="continue"><a href="#" title="Continue">Continue to Lecture 20</a></div>
					<div class="rating">
						<span>@for($i=1;$i<=5;$i++)<i class="fa fa-star fa-lg icon-star" aria-hidden="true"></i>@endfor</span>
						<span data-toggle="modal" data-target="#myModal">Edit your rating</span>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-9">
						<div class="number-unit">
							<p>20 of 100 items complate</p>
						</div>
					</div>
					<div class="col-xs-3">
						<div class="cup-icon">
							<i class="fa fa-trophy fa-3x" aria-hidden="true"></i>
						</div>
					</div>
				</div>
				<div class="progress border-element">
					<div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 20%;">
						20%
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="container">
	<div class="content"></div>
	<div class="row">
		<div class="col-sm-8">col-sm-8</div>
		<div class="col-sm-4">
			<div class="right-content">
				<div class="teacher-info">
					<p class="instructor">Instructor</p>
					<img class="avatar" src="{{asset('frontend/images/student-profile-ava.png')}}" alt="Avatar">
					<p class="name">Tran Thanh Tuan</p>
					<p class="office"><span>Staff Systems Engineer</span>/<span>Manager</span>/<span>Instructor</span></p>
					<div class="total-course">
						<div class="row">
							<div class="col-xs-4">
								<div class="course-number">
									<i class="fa fa-book fa-lg" aria-hidden="true"></i>
									<span>22 Courses</span>
								</div>
							</div>
							<div class="col-xs-8">
								<div class="rating">
									<span>@for($i=1;$i<=4;$i++)<i class="fa fa-star fa-lg icon-star" aria-hidden="true"></i>@endfor<i class="fa fa-star-half fa-lg icon-star" aria-hidden="true"></i></span>
									<span>4.6</span>
									<span>(24 ratings)</span>
								</div>
							</div>
						</div>
					</div>
					<div class="total-student">
						<div class="row">
							<div class="col-xs-5">
								<div class="student-number">
									<i class="fa fa-graduation-cap fa-lg" aria-hidden="true"></i>
									<span>111.000 Student</span>
								</div>
							</div>
							<div class="col-xs-7">
								<div class="btn inbox" data-toggle="modal" data-target="#myModal">
									<i class="fa fa-envelope-o fa-lg" aria-hidden="true"></i>
									<span>Inbox</span>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
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
</div>
@endsection