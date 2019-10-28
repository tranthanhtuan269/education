@extends('frontends.layouts.app')
@section('content')
@section('title')
Trở thành giảng viên Courdemy
@stop
<div class="courdemy-teacher">
    <div class="container-fluid">
        <div class="banner-top">
            <div class="row">
                <div class="container">
                    <div class="title">
                        <h1>Trở thành <br>giảng viên Courdemy</h1>
                        <p>Courdemy là e-learning platform, là cổng kết nối các CHUYÊN GIA tới hàng triệu người dân Việt Nam. Các bài giảng trực tuyến dưới dạng video giúp học viên có thể xem được bất kỳ khi nào, bất kỳ đâu.</p>
                        @if ( Auth::check() )
                            @if ( Auth::user()->notRegisteredTeacher() && !Auth::user()->isAdmin() )
                            <a href="{{ asset('/user/register-teacher') }}">ĐĂNG KÝ</a>
                            @endif
                        @else
                        <a href="{{ asset('/user/register-teacher') }}">ĐĂNG KÝ</a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="discover">
            <div class="title text-center">Khám phá tiềm năng của bạn</div>
            <hr>
            <div class="row">
                <div class="col-md-4">
                    <div class="discover-box text-center">
                        <img src="{{ asset('/frontend/images/money.png') }}" alt="Earn Money">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="discover-box text-center">
                        <img src="{{ asset('/frontend/images/inspiration.png') }}" alt="Inspire Students">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="discover-box text-center">
                        <img src="{{ asset('/frontend/images/community.png') }}" alt="Join our commnunity">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="discover-box text-center">
                        <p class="discover-title">Tăng thu nhập</p>
                        <p class="discover-content">Nhận được thu nhập thụ động mỗi khi học viên mua khóa học của bạn. Nhận tiền qua tài khoản ngân hàng hoặc trựa tiếp tại văn phòng của Courdemy.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="discover-box text-center">
                        <p class="discover-title">Truyền cảm hứng cho học viên</p>
                        <p class="discover-content">Nhận được thu nhập thụ động mỗi khi học viên mua khóa học của bạn. Nhận tiền qua tài khoản ngân hàng hoặc trựa tiếp tại văn phòng của Courdemy.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="discover-box text-center">
                        <p class="discover-title">Tham gia cộng đồng Courdemy</p>
                        <p class="discover-content">Nhận được thu nhập thụ động mỗi khi học viên mua khóa học của bạn. Nhận tiền qua tài khoản ngân hàng hoặc trựa tiếp tại văn phòng của Courdemy.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="statistic">
            <div class="container">
                <div class="box-statistic">
                    <div class="details">
                        <div class="title text-center">Thống kê của Courdemy</div>
                        <hr>
                        <div class="statistic-number text-center">
                            <ul>
                                <li>
                                    <div class="number">30 triệu</div>
                                    <div class="type">Học viên</div>
                                </li>
                                <li>
                                    <div class="number">50+</div>
                                    <div class="type">Ngôn ngữ</div>
                                </li>
                                <li>
                                    <div class="number">190.000</div>
                                    <div class="type">Khóa học</div>
                                </li>
                                <li>
                                    <div class="number">190+</div>
                                    <div class="type">Quốc gia</div>
                                </li>
                                <li>
                                    <div class="number">42.000</div>
                                    <div class="type">Nhân viên</div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="steps-register">
            <div class="container">
                <div class="title text-center">Các bước trở thành giảng viên Courdemy</div>
                <hr>
                <div class="row">
                    <div class="col-md-4">
                        <div class="box-step box-step-1 text-center active">
                            <a data-toggle="tab" href="#make-a-plan">
                                <img src="{{ asset('/frontend/images/plan_active.png') }}" alt="">
                                <p>1. Lên kế hoạch</p>
                            </a>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="box-step box-step-2 text-center">
                            <a data-toggle="tab" href="#record-video">
                                <img src="{{ asset('/frontend/images/record_inactive.png') }}" alt="">
                                <p>2. Quay Video</p>
                            </a>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="box-step box-step-3 text-center">
                            <a data-toggle="tab" href="#build-community">
                                <img src="{{ asset('/frontend/images/community_inactive.png') }}" alt="">
                                <p>3. Xây dựng cộng đồng</p>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="steps-register-content">
            <div class="container">
                <div class="tab-content">
                    <div id="make-a-plan" class="tab-pane fade in active tab-steps-register">
                        <div class="row">
                            <div class="col-md-6">
                                <p>Since we do not have any page to link it to, and we do not want to get a "404" message, we put # as the link in our examples. It should be a real URL to a specific page.
                                </p>
                                <p>Since we do not have any page to link it to, and we do not want to get a "404" message, we put # as the link in our examples. It should be a real URL to a specific page.</p>
                                <p>Since we do not have any page to link it to, and we do not want to get a "404" message, we put # as the link in our examples. It should be a real URL to a specific page.</p>
                            </div>
                            <div class="col-md-6">
                                <img src="{{ asset('/frontend/images/plan_img.png') }}" alt="Lên kế hoạch">
                            </div>
                        </div>
                    </div>
                    <div id="record-video" class="tab-pane fade tab-steps-register">
                        <div class="row">
                            <div class="col-md-6">
                                <p>Since we do not have any page to link it to, and we do not want to get a "404" message, we put # as the link in our examples. It should be a real URL to a specific page.
                                </p>
                                <p>Since we do not have any page to link it to, and we do not want to get a "404" message, we put # as the link in our examples. It should be a real URL to a specific page.</p>
                                <p>Since we do not have any page to link it to, and we do not want to get a "404" message, we put # as the link in our examples. It should be a real URL to a specific page.</p>
                            </div>
                            <div class="col-md-6">
                                <img src="{{ asset('/frontend/images/record_img.png') }}" alt="Quay Video">
                            </div>
                        </div>
                    </div>
                    <div id="build-community" class="tab-pane fade tab-steps-register">
                        <div class="row">
                            <div class="col-md-6">
                                <p>Since we do not have any page to link it to, and we do not want to get a "404" message, we put # as the link in our examples. It should be a real URL to a specific page.
                                </p>
                                <p>Since we do not have any page to link it to, and we do not want to get a "404" message, we put # as the link in our examples. It should be a real URL to a specific page.</p>
                                <p>Since we do not have any page to link it to, and we do not want to get a "404" message, we put # as the link in our examples. It should be a real URL to a specific page.</p>
                            </div>
                            <div class="col-md-6">
                                <img src="{{ asset('/frontend/images/comminty_img.png') }}" alt="Xây dựng cộng đồng">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="teacher-review">
            <div class="container">
                <div class="title text-center">Đánh giá của những người nổi tiếng</div>
                <hr>
                <div class="row">
                    <div class="col-md-4">
                        <div class="box-teacher text-center">
                            <div class="teacher-info">
                                <div class="avatar">
                                    <img src="{{ asset('/frontend/images/Archimedes.jpeg') }}" alt="Teacher Review">
                                </div>
                                <div class="name">
                                    Archimedes
                                </div>
                                <div class="expert">
                                    Nhà toán học, Nhà vật lý, Nhà phát minh
                                </div>
                            </div>
                            <div class="review">
                                <i class="fas fa-quote-right fa-fw"></i>
                                <p>Courdemy là nơi tốt nhất để bạn phát huy tài năng của mình trên mọi lĩnh vực. Hãy đến với Courdemy và truyền cảm hứng cho những người có chung đam mê với bạn.</p>
                                <i class="fas fa-quote-left fa-fw"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="box-teacher text-center">
                            <div class="teacher-info">
                                <div class="avatar">
                                    <img src="{{ asset('/frontend/images/newton.jpg') }}" alt="Teacher Review">
                                </div>
                                <div class="name">
                                    Isaac Newton
                                </div>
                                <div class="expert">
                                    Nhà vật lý, Nhà thiên văn học, Nhà toán học
                                </div>
                            </div>
                            <div class="review">
                                <i class="fas fa-quote-right fa-fw"></i>
                                <p>Courdemy là nơi tốt nhất để bạn phát huy tài năng của mình trên mọi lĩnh vực. Hãy đến với Courdemy và truyền cảm hứng cho những người có chung đam mê với bạn.</p>
                                <i class="fas fa-quote-left fa-fw"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="box-teacher text-center">
                            <div class="teacher-info">
                                <div class="avatar">
                                    <img src="{{ asset('/frontend/images/anhxtanh.jpg') }}" alt="Teacher Review">
                                </div>
                                <div class="name">
                                    Albert Einstein
                                </div>
                                <div class="expert">
                                    Thiên tài, Nhà vật lý lý thuyết
                                </div>
                            </div>
                            <div class="review">
                                <i class="fas fa-quote-right fa-fw"></i>
                                <p>Courdemy là nơi tốt nhất để bạn phát huy tài năng của mình trên mọi lĩnh vực. Hãy đến với Courdemy và truyền cảm hứng cho những người có chung đam mê với bạn.</p>
                                <i class="fas fa-quote-left fa-fw"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="partner">
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <h2>Đào tạo nâng cao <br> đội ngũ nhân viên của bạn?</h2>
                    <p>Chúng tôi cung cấp giải pháp tiết kiệm, linh hoạt và hiệu quả <br> cho chương trình đạo tạo của bạn </p>
                </div>
            </div>
            <div class="partner-img clearfix">
                <ul>
                    <li><div><img src="{{ asset('frontend/images/partner_5.png') }}"></div></li>
                    <li><div><img src="{{ asset('frontend/images/partner_4.png') }}"></div></li>
                    <li><div><img src="{{ asset('frontend/images/partner_3.png') }}"></div></li>
                    <li><div><img src="{{ asset('frontend/images/partner_2.png') }}"></div></li>
                    <li><div><img src="{{ asset('frontend/images/partner_1.png') }}"></div></li>
                </ul>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function(){
        // $('.steps-register .active a img').attr('src', "{{ asset('/frontend/images/plan_active.png') }}")
        $('.steps-register .box-step-1 a').on('click', function(e){
            $('.box-step').removeClass('active')
            $(this).parent().addClass('active')
            $('.steps-register .box-step-1 a img').attr('src', "{{ asset('/frontend/images/plan_active.png') }}")
            $('.steps-register .box-step-2 a img').attr('src', "{{ asset('/frontend/images/record_inactive.png') }}")
            $('.steps-register .box-step-3 a img').attr('src', "{{ asset('/frontend/images/community_inactive.png') }}")
        })
        $('.steps-register .box-step-2 a').on('click', function(e){
            $('.box-step').removeClass('active')
            $(this).parent().addClass('active')
            $('.steps-register .box-step-1 a img').attr('src', "{{ asset('/frontend/images/plan_inactive.png') }}")
            $('.steps-register .box-step-2 a img').attr('src', "{{ asset('/frontend/images/record_active.png') }}")
            $('.steps-register .box-step-3 a img').attr('src', "{{ asset('/frontend/images/community_inactive.png') }}")
        })
        $('.steps-register .box-step-3 a').on('click', function(e){
            $('.box-step').removeClass('active')
            $(this).parent().addClass('active')
            $('.steps-register .box-step-1 a img').attr('src', "{{ asset('/frontend/images/community_inactive.png') }}")
            $('.steps-register .box-step-2 a img').attr('src', "{{ asset('/frontend/images/record_inactive.png') }}")
            $('.steps-register .box-step-3 a img').attr('src', "{{ asset('/frontend/images/community_active.png') }}")
        })
    })
</script>
@endsection
