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
							<img src="https://www.w3schools.com/howto/img_avatar.png" alt="" />
							<div class="info">
								<p class="name">Bảo Minh</p>
								<p class="expret">PHP, Jquery</p>
							</div>
						</div>
						<div class="network pull-right">
							<button type="button" class="btn btn-default btn-xs">
								<img src="{{ asset('frontend/images/ic_share.png') }}" alt="" />
								<span>Share</span>
							</button>
							<button type="button" class="btn btn-default btn-xs">
								<img src="{{ asset('frontend/images/ic_facebook.png') }}" alt="" />
								<span>Facebook</span>
							</button>
						</div>
					</div>
					<div class="frame_2">
						<div class="row">
							<div class="col-sm-6">
								<div class="desc">
									<p>Chuyên gia <strong>Yoga Nguyễn Hiếu </strong>đã có hơn 12 năm nghiên cứu và giảng dạy Yoga tại các trung tâm và đã huấn luyện cho hàng nghìn học viên khắp Việt Nam và thế giới.</p>

									<p>Chị là Đại sứ Yoga Việt Nam do Trung tâm Unesco Phát triển Văn hóa và Thể thao phong tặng.&nbsp;</p>

									<p>Chị đã thiết kế rất nhiều chương trình Yoga trực tuyến, sở hữu kênh &nbsp;đào tạo Yoga online lớn nhất Việt Nam.</p>

									<p>Hiện tại, Nguyễn Hiếu đang&nbsp;là tổng giám đốc công ty Zenlife Yoga Việt Nam và là huấn luyện viên trưởng cho chương trình đào tạo giáo viên Yoga.</p>

									<p>Hiện nay, dù đã gần 40&nbsp;tuổi và có 2 con lớn, <strong>Chuyên gia Yoga Nguyễn Hiếu </strong>vẫn sở hữu một cơ thể cân đối trẻ trung, khỏe mạnh và dẻo dai như ở tuổi đôi mươi, với vòng eo 60 cm là niềm ao ước của mọi phụ nữ ở độ tuổi này.</p>
								</div>
								<!-- <div class="see-more text-center">Show full biography</div> -->
								<div class="info-others">
									<ul>
										<li>
											<img src="{{ asset('frontend/images/ic_course.png') }}" alt="" /> 
											<span class="special">22 Courses</span>
										</li>
										<li>
											<img src="{{ asset('frontend/images/icon_student.png') }}" alt="" /> 
											<span class="special">11.112 Students</span>
										</li>
										<li>
											
											    <span class="star-rate">
											    <i class="fa fa-star co-or" aria-hidden="true"></i><i class="fa fa-star co-or" aria-hidden="true"></i><i class="fa fa-star co-or" aria-hidden="true"></i><i class="fa fa-star co-or" aria-hidden="true"></i><i class="fa fa-star co-or" aria-hidden="true"></i>                </span>
											    <span class="n-rate">4.5 (<span>11.990 ratings</span>)</span>
											
										</li>
									</ul>
								</div>
							</div>
							<div class="col-sm-6">
								<iframe src="https://www.youtube.com/embed/tgbNymZ7vqY?controls=0"  frameborder="0" allowfullscreen></iframe>
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