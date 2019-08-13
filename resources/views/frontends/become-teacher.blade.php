@extends('frontends.layouts.app')
@section('content')

<link href="https://unica.vn/media/styles_v2018/bootstrap.css" rel="stylesheet">
<link href="https://unica.vn/media/styles_v2018/font-awesome.css" rel="stylesheet">
<link href="https://unica.vn/media/styles_v2018/slick.css" rel="stylesheet">
<link href="https://unica.vn/media/styles_v2018/slick-theme.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700" rel="stylesheet">
<link href="https://unica.vn/media/styles_v2018/bootstrap.offcanvas.min.css" rel="stylesheet">
<link href="https://unica.vn/media/styles_v2018/sidenav.min.css" rel="stylesheet">
<link href="https://unica.vn/media/styles_v2018/main.css" rel="stylesheet">
<link href="https://unica.vn/media/styles_v2018/library/bootstrap-select.min.css" rel="stylesheet">
<link href="https://unica.vn/media/styles_v2018/owl.carousel.css" rel="stylesheet">
<link href="https://unica.vn/media/styles_v2018/owl.theme.default.min.css" rel="stylesheet">
<link href="https://unica.vn/media/dev/css/tet.css" rel="stylesheet">        <script type="text/javascript" src="/media/js_v2018/jquery-3.2.1.min.js"></script>
<script type="text/javascript" src="https://unica.vn/media/js_v2018/libs/lazyload/jquery.lazy.min.js" async></script>
<script type="text/javascript" src="https://unica.vn/media/js_v2018/libs/lazyload/jquery.lazy.plugins.min.js" async></script>

<link rel="stylesheet" href="https://unica.vn/media/styles_v2018/animate.css">

<div class="hidden-xs" style="margin-top: 63px;"></div>
<div class="hidden-md hidden-sm hidden-lg" style="margin-top: 45px;"></div>
        <main>
    <div class="unica-teacher">
        <div class="unica-teacher-top">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <p>Hợp tác giảng dạy cùng Courdemy</p>
                        <div class="register_check" style="cursor: pointer;">
                            <a href="{{ Auth::check() ? url('user/register-teacher') : 'javascript:void(0)' }}" title="Register Teacher" {{ Auth::check() ? '' : ' data-toggle=modal data-target=#myModalLogin data-dismiss=modal id=redirect_register_teacher' }}>ĐĂNG KÝ NGAY</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="unica-teacher-video">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <p>“MỖI CHÚNG TA ĐỀU CÓ MỘT SƯ MỆNH CHIA SẺ LẠI GIÁ TRỊ CHO THẾ HỆ SAU”</p>
                        <span>- Trần Thanh Tuấn - Web Team Leader TOHsoft -</span>
                        <div class="video-youtube">
                            <iframe width="100%" height="315" src="https://www.youtube.com/embed/BqeGaO4-XSY?rel=0" frameborder="0" allowfullscreen=""></iframe>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="unica-teacher-block-2">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="title-block-2">
                            <p><b>Unica là e-learning platform, là cổng kết nối các CHUYÊN GIA tới hàng triệu người dân Việt Nam.</b></p>
                            <p>Các bài giảng được dưới dạng video giúp học viên có thể xem được bất kỳ khi nào, bất kỳ đâu.</p>
                        </div>
                        <div class="block-3">
                            <div class="row slider">
                                <div class="col-lg-4 col-md-4 col-sm-4">
                                    <div class="box-teacher-2">
                                        <img src="https://unica.vn/media/img/tc1.png" alt="" />
                                        <p>unica partner</p>
                                        <ul>
                                            <li>- Chuyên gia</li>
                                            <li>- Giảng viên</li>
                                            <li>- Doanh nhân</li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-4">
                                    <div class="box-teacher-2">
                                        <img src="https://unica.vn/media/img/tc2.png" alt="" />
                                        <p>sứ mệnh</p>
                                        <span>Mang tri thức thực tiễn tới 10 triệu người dân Việt Nam</span>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-4">
                                    <div class="box-teacher-2">
                                        <img src="https://unica.vn/media/img/tc3.png" alt="" />
                                        <p>unica student</p>
                                        <ul>
                                            <li>- Lãnh đạo</li>
                                            <li>- Người đi làm</li>
                                            <li>- Học sinh, sinh viên</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="unica-teacher-block-3">
            <div class="container">
                <div class="row">
                    <h3>5 lý do nên giảng dạy trên unica</h3>
                    <div class="box-reason-teacher">
                        <ul class="slider">
                            <li>
                                <div class="box-inner-teacher">
                                    <img src="https://unica.vn/media/img/teacher1.png" alt="" />
                                    <p>Làm 1 lần
                                        <br>Bán n lần</p>
                                </div>
                            </li>
                            <li>
                                <div class="box-inner-teacher">
                                    <img src="https://unica.vn/media/img/teacher2.png" alt="" />
                                    <p>Quảng bá tới hàng triệu học viên</p>
                                </div>
                            </li>
                            <li>
                                <div class="box-inner-teacher">
                                    <img src="https://unica.vn/media/img/teacher3.png" alt="" />
                                    <p>Chia sẻ lợi nhuận 30%-100%</p>
                                </div>
                            </li>
                            <li>
                                <div class="box-inner-teacher">
                                    <img src="https://unica.vn/media/img/teacher4.png" alt="" />
                                    <p>Thanh toán trước ngày 10 hàng tháng</p>
                                </div>
                            </li>
                            <li>
                                <div class="box-inner-teacher">
                                    <img src="https://unica.vn/media/img/teacher5.png" alt="" />
                                    <p>Học qua VOD, Live và offline event</p>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="unica-teacher-block-4">
            <div class="container">
                <div class="row">
                    <h3>Ai nên đăng ký giảng dạy trên Courdemy.VN</h3>
                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6">
                        <div class="inner-block-4">
                            <img src="https://unica.vn/media/img/teacher10.png" alt="" />
                            <p>Chuyên gia</p>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6">
                        <div class="inner-block-4">
                            <img src="https://unica.vn/media/img/teacher9.png" alt="" />
                            <p>Giảng viên</p>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6">
                        <div class="inner-block-4">
                            <img src="https://unica.vn/media/img/teacher7.png" alt="" />
                            <p>Doanh nhân</p>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6">
                        <div class="inner-block-4">
                            <img src="https://unica.vn/media/img/teacher8.png" alt="" />
                            <p>Doanh nghiệp</p>
                        </div>
                    </div>
                    <span>“Có trên 3 năm kinh nghiệm trong lĩnh vực muốn giảng dạy <br> Kỹ năng trình bày lưu loát, dễ hiểu, ngôn ngữ cơ thể tốt.”</span>
                </div>
            </div>
        </div>
        <div class="unica-teacher-block-5">
            <div class="container">
                <div class="row">
                    <h3>3 BƯỚC ĐỂ TRỞ THÀNH GIẢNG VIÊN Courdemy</h3>
                    <div class="col-3-steps">
                        <ul class="slider">
                            <li>
                                <div class="inner-col-steps">
                                    <p>Bước 1 </p>
                                    <center><img src="https://unica.vn/media/img/teacher12.png" alt="" /></center>
                                    <span>Đăng ký giảng viên</span>
                                </div>
                            </li>
                            <li>
                                <div class="inner-col-steps">
                                    <p>Bước 2 </p>
                                    <center><img src="https://unica.vn/media/img/teacher11.png" alt="" /></center>
                                    <span>Viết outline</span>
                                </div>
                            </li>
                            <li>
                                <div class="inner-col-steps">
                                    <p>Bước 3 </p>
                                    <center><img src="https://unica.vn/media/img/teacher13.png" alt="" /></center>
                                    <span>Upload video</span>
                                </div>
                            </li>
                            <li>
                                <div class="inner-col-steps">
                                    <p>Bước 4 </p>
                                    <center><img src="https://unica.vn/media/img/teacher14.png" alt="" /></center>
                                    <span>Launching khóa học</span>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="unica-teacher-block-6">
            <div class="container">
                <h3>HƠN 400 GIẢNG VIÊN ĐÃ CÓ KHOÁ HỌC TRÊN Courdemy</h3>
                <div class="row">
                    <div class="member-box">
                        <a>
                            <div class="img-wrap">
                                <img src="https://static.unica.vn/uploads/thaoptt09@gmail.com/February282018936am_ts-le-tham-duong_thumb.jpg" alt="">
                            </div>
                            <h4 class="tp">Lê Thẩm Dương</h4>
                            <div class="position">Tiến sĩ - Giảng viên Đại học Ngân hàng TP Hồ Chí Minh</div>
                        </a>
                    </div>
                    <div class="member-box">
                        <a>
                            <div class="img-wrap">
                                <img src="https://static.unica.vn/uploads/thaoptt09@gmail.com/February282018939am_pham-thanh-long_thumb.jpg" alt="">
                            </div>
                            <h4 class="tp">Phạm Thành Long</h4>
                            <div class="position">Diễn giả - Sáng lập Công ty Luật Gia Phạm</div>
                        </a>
                    </div>
                    <div class="member-box">
                        <a>
                            <div class="img-wrap">
                                <img src="https://static.unica.vn/uploads/thaoptt09@gmail.com/November122016351pm_tuan-ha_thumb.png" alt="">
                            </div>
                            <h4 class="tp">Hà Anh Tuấn</h4>
                            <div class="position">Chủ tịch VinaLink</div>
                        </a>
                    </div>
                    <div class="member-box">
                        <a>
                            <div class="img-wrap">
                                <img src="https://static.unica.vn/uploads/thaoptt09@gmail.com/February1020181040am_ths-dang-thanh-van_thumb.jpg" alt="">
                            </div>
                            <h4 class="tp">Đặng Thanh Vân</h4>
                            <div class="position">Giám đốc điều hành công ty Thanhs</div>
                        </a>
                    </div>
                    <div class="member-box">
                        <a>
                            <div class="img-wrap">
                                <img src="https://static.unica.vn/uploads/thaoptt09@gmail.com/February82017603pm_richdadloc_thumb.png" alt="">
                            </div>
                            <h4 class="tp">Đinh Văn Lộc</h4>
                            <div class="position">Nhà đào tạo Internet Marketing - Chủ tịch Công ty cổ phần ONNET</div>
                        </a>
                    </div>
                    <div class="member-box">
                        <a>
                            <div class="img-wrap">
                                <img src="https://unica.vn/uploads/Thaoptt/August52016431pm_nguyen-hieu_thumb.jpg" alt="">
                            </div>
                            <h4 class="tp">Nguyễn Hiếu</h4>
                            <div class="position">Đại sứ Yoga Việt Nam-Tổng giám đốc công ty Zenlife Yoga Việt Nam</div>
                        </a>
                    </div>
                    
                    <div class="member-box">
                        <a>
                            <div class="img-wrap">
                                <img src="https://static.unica.vn/uploads/thaoptt09@gmail.com/January192017356pm_nguyen-huu-lam_thumb.jpg" alt="">
                            </div>
                            <h4 class="tp">Nguyễn Hữu Lam</h4>
                            <div class="position">Diễn giả - CEO công ty HPSOFT</div>
                        </a>
                    </div>
                    <div class="member-box">
                        <a>
                            <div class="img-wrap">
                                <img src="https://unica.vn/uploads/Thaoptt/August52016403pm_nguyen-trong-tho_thumb.jpg" alt="">
                            </div>
                            <h4 class="tp">Nguyễn Trọng Thơ</h4>
                            <div class="position">Chuyên gia Marketing online Nguyễn Trọng Thơ - CEO iNET</div>
                        </a>
                    </div>
                    <div class="member-box">
                        <a>
                            <div class="img-wrap">
                                <img src="https://unica.vn/uploads/Thaoptt/September132016638pm_phan-quoc-viet_thumb.jpg" alt="">
                            </div>
                            <h4 class="tp">Phan Quốc Việt</h4>
                            <div class="position">Người sáng lập, Chủ tịch HĐQT Tâm Việt Group</div>
                        </a>
                    </div>
                    
                    <div class="member-box">
                        <a>
                            <div class="img-wrap">
                                <img src="http://static.unica.vn/uploads/doanhuyen209@gmail.com/June62017533pm_nguyen-phung-phong_thumb.jpg" alt="">
                            </div>
                            <h4 class="tp">Nguyễn Phùng Phong</h4>
                            <div class="position"> Kỷ Lục Gia Siêu Trí Nhớ Thế Giới</div>
                        </a>
                    </div>
                    <div class="member-box">
                        <a>
                            <div class="img-wrap">
                                <img src="http://static.unica.vn/uploads/thaoptt09@gmail.com/May32017357pm_hoang-dong-anh_thumb.jpg" alt="">
                            </div>
                            <h4 class="tp">Hoàng Đông Anh</h4>
                            <div class="position">Chủ tịch HĐQT Nhân Hòa Group</div>
                        </a>
                    </div>
                    <div class="member-box">
                        <a>
                            <div class="img-wrap">
                                <img src="https://static.unica.vn/uploads/linhntd@unica.vn/December1320161152am_nguyen-quang-ngoc_thumb.jpg" alt="">
                            </div>
                            <h4 class="tp">Nguyễn Quang Ngọc</h4>
                            <div class="position">Diễn giả, nhà sáng lập Công ty Cơn Bão Triệu Phú</div>
                        </a>
                    </div>
                    <div class="member-box">
                        <a>
                            <div class="img-wrap">
                                <img src="https://unica.vn/uploads/thaoptt09@gmail.com/February2820181000am_hoa-yody_thumb.jpg" alt="">
                            </div>
                            <h4 class="tp">Hoà Yody</h4>
                            <div class="position">Tổng giám đốc điều hành Thời trang YODY</div>
                        </a>
                    </div>
                    <div class="member-box">
                        <a>
                            <div class="img-wrap">
                                <img src="https://unica.vn/uploads/doanhuyen209@gmail.com/March272017951pm_pham-tuan-son_thumb.jpg" alt="">
                            </div>
                            <h4 class="tp">Phạm Tuấn Sơn</h4>
                            <div class="position">Triệu phú, doanh nhân, diễn giả, Chủ tịch hội đồng quản trị Babylons JSC</div>
                        </a>
                    </div>
                    <div class="member-box">
                        <a>
                            <div class="img-wrap">
                                <img src="https://static.unica.vn/uploads/doanhuyen209@gmail.com/December232016421pm_nguyen-manh-ha_thumb.png" alt="">
                            </div>
                            <h4 class="tp">Nguyễn Mạnh Hà</h4>
                            <div class="position">Diễn giả, doanh nhân. Người sáng lập Think Big Group</div>
                        </a>
                    </div>
                    <div class="member-box">
                        <a>
                            <div class="img-wrap">
                                <img src="https://static.unica.vn/uploads/thaoptt09@gmail.com/vera-haanh.jpg" alt="">
                            </div>
                            <h4 class="tp">Vera Hà Anh</h4>
                            <div class="position">Chuyên gia tâm lý, Tổng Giám Đốc Công ty Tư Vấn Tâm Lý và Đào Tạo VERA</div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="unica-teacher-block-7">
        <div class="container">
            <h3>ĐĂNG KÝ ĐỂ TRỞ THÀNH GIẢNG VIÊN Courdemy NGAY HÔM NAY</h3>
                            <a style="cursor: pointer;" class="register_check">Đăng ký giảng viên</a>
                        <p>HOTLINE: HN: 0392791528 - HCM: 0938005451</p>
        </div>
    </div>
</main>
<script type="text/javascript">
    $('body').on('click', '.register_check', function () {
            $.ajax({
                type: 'POST',
                url: '/teachregister/login',
                success: function (result) {
                    location.href = result.data.url;
                }
            });
    });
</script>        <footer>

</footer>
<link rel="manifest" href="/manifest.json">

<div id="fb-root"></div>
<script type="text/javascript" >
    var Tawk_API = Tawk_API || {}, Tawk_LoadStart = new Date();
    (function() {
        var s1 = document.createElement("script"), s0 = document.getElementsByTagName("script")[0];
        s1.async = true;
        s1.src = 'https://embed.tawk.to/5749c1065d451a4e2780a875/default';
        s1.charset = 'UTF-8';
        s1.setAttribute('crossorigin', '*');
        s0.parentNode.insertBefore(s1, s0);
    })();
    var _csrf_code = 'U3B6MXguZ1Q1BBRdDUEXYwZIG3tVcS8hFzUgSyAbVxExRz0ASGYKeQ==';
</script>
<!--End of Tawk.to Script-->
<script >(function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = 'https://connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v2.11&appId=410486232859596';
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));</script>
<!-- Google Code dành cho Thẻ tiếp thị lại -->
<script type="text/javascript" >
    /* <![CDATA[ */
    var google_conversion_id = 875197056;
    var google_custom_params = window.google_tag_params;
    var google_remarketing_only = true;
    /* ]]> */
</script>
<script  type="text/javascript" src="//www.googleadservices.com/pagead/conversion.js">
</script>
<noscript>
    <div style="display:inline;">
        <img height="1" width="1" style="border-style:none;" alt="" src="//googleads.g.doubleclick.net/pagead/viewthroughconversion/875197056/?value=0&amp;guid=ON&amp;script=0"/>
    </div>
</noscript>
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-5HFBS73"
                  height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-5HFBS73"
                  height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
<script type="text/javascript">
    function getTimeRemaining(endtime) {
        var t = Date.parse(endtime) - Date.parse(new Date());
        var seconds = Math.floor((t / 1000) % 60);
        var minutes = Math.floor((t / 1000 / 60) % 60);
        var hours = Math.floor((t / (1000 * 60 * 60)) % 24);
        var days = Math.floor(t / (1000 * 60 * 60 * 24));
        return {
            'total': t,
            'days': days,
            'hours': hours,
            'minutes': minutes,
            'seconds': seconds
        };
    }

    function initializeClock(id, endtime) {
        var clock = document.getElementById(id);
//        var daysSpan = clock.querySelector('.days');
        var hoursSpan = clock.querySelector('.hours');
        var minutesSpan = clock.querySelector('.minutes');
        var secondsSpan = clock.querySelector('.seconds');

        function updateClock() {
            var t = getTimeRemaining(endtime);

//            daysSpan.innerHTML = t.days;
            hoursSpan.innerHTML = ('0' + t.hours).slice(-2);
            minutesSpan.innerHTML = ('0' + t.minutes).slice(-2);
            secondsSpan.innerHTML = ('0' + t.seconds).slice(-2);

            if (t.total <= 0) {
                clearInterval(timeinterval);
            }
        }

        updateClock();
        var timeinterval = setInterval(updateClock, 1000);
    }

        var deadline = new Date(Date.parse(new Date(1542992399 * 1000)) + 0 * 24 * 60 * 60 * 1000);
    if($("#clockdiv").is(":visible")) {
        initializeClock('clockdiv', deadline);
    }
    window.insider_object = {
        "user": {
            "email": "",
            "gdpr_optin": true,
            "email_optin": true,
            "name": "",
            "surname": ""
        }
    };
</script>        <script src="/media/js_v2018/bootstrap.min.js"></script>
<script src="/media/js_v2018/slick.js"></script>
<script src="/media/js_v2018/bootstrap.offcanvas.js"></script>
<script src="/media/js_v2018/sidenav.min.js"></script>
<script src="/media/js_v2018/amazonmenu.js"></script>
<script src="/media/js_v2018/sticky-sidebar.js"></script>
<script src="/media/js_v2018/libs/selectpicker/bootrap-select.js"></script>
<script src="/media/js_v2018/chosen.js"></script>
<script src="/media/js_v2018/owl.carousel.js"></script>
<script src="/media/js_v2018/hieu.js"></script>
<script src="/media/dev/popup/learn_v2.js"></script>
<script src="/media/js_v2018/dev/global.js"></script>
<script src="/media/js_v2018/dev/membership.js"></script>
<script src="/media/js_v2018/dev/userprofile.js"></script>
<script src="/media/js/myScript.js"></script>
<script src="/media/js_v2018/dev/blog.js"></script>        <script >
            $(document).ready(function() {
                $('.owl-slider').owlCarousel({
                    animateOut: 'fadeOut',
                    items: 1,
                    autoplay: true,
                    nav: false,
                    loop: true,
                    autoplayTimeout: 5000,
                    dots: true,
                });
            });

            jQuery(function () {
                amazonmenu.init({
                    menuid: 'mysidebarmenu'
                })
            })

			resizeWindow();

            window.addEventListener('resize', resizeWindow);

            function resizeWindow() {
                $('.slider').slick({
                    responsive: [{
                            breakpoint: 2500,
                            settings: "unslick"
                        },
                        {
                            breakpoint: 640,
                            settings: {
                                dots: true,
                                infinite: true
                            }
                        }
                    ]
                });
            }

			$('.u-blog-slide').slick({
					infinite: true,
					slidesToShow: 1,
					slidesToScroll: 1,
					responsive: [{
							breakpoint: 1025,
							settings: {
								slidesToShow: 1,
								slidesToScroll: 1,
								infinite: true
							}
						},
						{
							breakpoint: 769,
							settings: {
								slidesToShow: 1,
								slidesToScroll: 1
							}
						},
						{
							breakpoint: 480,
							settings: {
								slidesToShow: 1,
								slidesToScroll: 1
							}
						}
					]
			});

            $('.unica-lt-box').owlCarousel({
				loop: true,
				margin: 10,
				responsiveClass: true,
				autoplay: true,
				autoplayTimeout: 5000,
				nav: true,
				navText: ['<i class="fa fa-chevron-left"></i>', '<i class="fa fa-chevron-right"></i>'],
				dots: false,
				responsive: {
					320: {
						items: 2,
						nav: true,
						loop: true,
						margin: 5
					},
					600: {
						items: 5,
						nav: true,
						loop: true,
						margin: 15
					},
					1000: {
						items: 6,
						nav: true,
						loop: true,
						margin: 15
					}
				}
			});

            if($('.lazy').length){
                $('.lazy').lazy();
            }
		</script>
        <!--trazk js không biết cái gì. A Vương cài-->
        <script type='text/javascript' src='//c.trazk.com/c.js?_key=undefined' async > </script>

@endsection
