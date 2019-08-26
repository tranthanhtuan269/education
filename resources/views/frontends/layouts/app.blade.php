<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="vi" xmlns:og="http://ogp.me/ns#" xmlns:fb="http://ogp.me/ns/fb#">
<head>
    <!-- Google API login -->
    <meta name="google-signin-client_id" content="658704434303-kgbsdp88qh3avffl16blio0s3kkd7gfa.apps.googleusercontent.com">

    <!-- Required meta tags -->
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"> -->
    <!-- <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no,viewport-fit=cover"> -->
    <meta name="viewport" content="width=device-width, maximum-scale=5.0, target-densitydpi=device-dpi">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Bootstrap CSS -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans|Poppins&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Palanquin+Dark&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" type="text/css" href="{{ asset('frontend/css/bootstrap.css') }}" />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="{{ asset('frontend/css/bootstrap.offcanvas.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('frontend/css/sidenav.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('frontend/css/slick.css') }}">

    <link rel="stylesheet" href="{{ asset('frontend/css/style.css') }}" />
    <link rel="stylesheet" href="{{ asset('frontend/css/responsive.css') }}" />
    <script type="text/javascript" src="{{ asset('frontend/js/jquery-3.2.1.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('frontend/js/format-currency.js') }}"></script>
    <script type="text/javascript" src="{{ asset('frontend/js/bootstrap.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('frontend/js/slick.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('frontend/js/jssor.slider.min.js') }}"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
    <title>@yield('title', 'Edu')</title>
    <meta name="description" content="@yield('description', '')"/>
    <meta name="keywords" content="@yield('keywords', '')"/>
    <meta name="copyright" content="Edu">
    <meta name="author" content="Edu"/>
    <base href="{{ url('/') }}">
</head>
<body>
        <div id="fb-root"></div>
        <script async defer crossorigin="anonymous" src="https://connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v4.0&appId=2474435149283816&autoLogAppEvents=1"></script>
    {{-- <div class="notifications alert alert-danger fade in alert-dismissible">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div class="text-center">
                        <a href="javascript:void(0)" class="close" data-dismiss="alert" aria-label="close" title="close">
                            <img src="{{ asset('frontend/images/tab_alert_close.png') }}" alt="" />    
                        </a>
                        <strong>Danger!</strong> This alert box indicates a dangerous or potentially negative action.
                    </div>
                </div>
            </div>
        </div>
    </div> --}}

    <header>
        <div class="sm-mobile-menu hidden-lg hidden-md hidden-sm">
            <div class="sm-navi-btn offcanvas-toggle js-offcanvas-has-events" data-toggle="offcanvas" data-target="#js-bootstrap-offcanvas"><i class="fa fa-bars" aria-hidden="true"></i></div>
            <div class="c_header__search-wrapper pull-left">
                <button class="c_header__mobile-bt mobile-bt--search udi udi-search" data-toggle="collapse" data-target="#searchpanel">
                    <!-- <i class="ion-ios-search-strong"></i> -->
                    <i class="fa fa-search"></i>
                </button>
                <div class="c_header__search collapse" id="searchpanel" style="">
                    <div class="c_quick-search__form">
                        <form class="searchbox" method="GET" action="/search">
                            <input type="text" class="form-control sm-form" name="key" placeholder="Tìm khóa học, giảng viên bạn quan tâm">
                            <button type="submit" class="btn sm-btn-search"><i class="fa fa-search" aria-hidden="true"></i></button>
                        </form>
                    </div>
                </div>
            </div>
            <nav class="navibar-mobile" role="navigation">
                <div class="navbar-offcanvas navbar-offcanvas-touch" id="js-bootstrap-offcanvas">
                    <div class="sidenav-brand">
                        <a class="remove-navibar"><i class="fa fa-arrow-left" aria-hidden="true"></i></a>
                        <div class="sm_logo_brand"><img src="{{ asset('frontend/images/tab_logo.png') }}" alt="" /></div>
                    </div>
                    <ul class="nav navbar-nav sm-customize-menu">
                        <li><a href="/"><i class="fa fa-home" aria-hidden="true"></i> Trang chủ</a></li>
                        <li><a href="javascript:void(0)"> Vào học <i class="fa fa-key" aria-hidden="true"></i></a></li>
                        <li>
                            <a title="Các khóa học công nghệ thông tin Online từ cơ bản đến chuyên sâu" href="/course/cong-nghe-thong-tin"><i class="fa fa-angle-code" aria-hidden="true"></i> Công nghệ thông tin</a>
                            <ul class="issub" style="z-index: 1002; display: none;">
                                <li><a href="/course/cong-nghe-thong-tin">Tất cả Công nghệ thông tin</a></li>
                                <li><a href="/tag/co-so-du-lieu">Cơ sở dữ liệu</a></li>
                                <li><a href="/tag/hoc-quan-tri-mang">quản trị mạng</a></li>
                                <li><a href="/tag/lap-trinh">Lập trình</a></li>
                                <li><a href="/tag/lap-trinh-web">Lập trình web</a></li>
                            </ul>
                        </li>
                        <li>
                            <a title="Các khóa học tin học văn phòng từ cơ bản đến nâng cao tốt nhất" href="/course/tin-hoc-van-phong"><i class="fa fa fa-desktop" aria-hidden="true"></i> Tin học văn phòng</a>
                            <ul class="issub" style="z-index: 1002; display: none;">
                                <li><a href="/course/tin-hoc-van-phong">Tất cả Tin học văn phòng</a></li>
                                <li><a href="/tag/excel">Excel</a></li>
                                <li><a href="/tag/word">Word</a></li>
                                <li><a href="/tag/ke-toan">Tài chính - Kế toán</a></li>
                                <li><a href="/tag/powerpoint">PowerPoint</a></li>
                            </ul>
                        </li>
                        <li>
                            <a title="Các khóa học thiết kế từ cơ bản đến chuyên sâu" href="/course/thiet-ke"><i class="fa fa fa-paint-brush" aria-hidden="true"></i> Thiết kế</a>
                            <ul class="issub" style="z-index: 1002; display: none;">
                                <li><a href="/course/thiet-ke">Tất cả Thiết kế</a></li>
                                <li><a href="/tag/phan-mem-thiet-ke">Phần mềm thiết kế</a></li>
                                <li><a href="/tag/kien-truc">Kiến trúc</a></li>
                                <li><a href="/tag/thiet-ke-web">Thiết kế web</a></li>
                                <li><a href="/tag/wordpress">wordpress</a></li>
                                <li><a href="/tag/thiet-ke">Thiết kế</a></li>
                                <li><a href="/tag/ui-ux">UI-UX</a></li>
                                <li><a href="/tag/illustrator">Illustrator</a></li>
                                <li><a href="/tag/photoshop">Photoshop</a></li>
                                <li><a href="/tag/thiet-ke-do-hoa">Thiết kế đồ họa</a></li>
                                <li><a href="/tag/thiet-ke-noi-that">Thiết kế nội thất</a></li>
                            </ul>
                        </li>
                        <li>
                            <a title="Khóa học Marketing thực chiến từ những giảng viên hàng đầu Việt Nam" href="/course/marketing"><i class="fa fa fa-line-chart" aria-hidden="true"></i> Marketing</a>
                            <ul class="issub" style="z-index: 1002; display: none;">
                                <li><a href="/course/marketing">Tất cả Marketing</a></li>
                                <li><a href="/tag/facebook-marketing">Facebook Marketing</a></li>
                                <li><a href="/tag/tu-dong-hoa-marketing">Tự động hóa marketing</a></li>
                                <li><a href="/tag/email-marketing">Email Marketing</a></li>
                                <li><a href="/tag/marketing-online">marketing online</a></li>
                                <li><a href="/tag/google-adwords">Google Ads</a></li>
                                <li><a href="/tag/content-marketing">Content marketing</a></li>
                                <li><a href="/tag/social-viral-marketing">Social & Viral Marketing</a></li>
                                <li><a href="/tag/branding-thuong-hieu">Branding, thương hiệu</a></li>
                                <li><a href="/tag/seo-analytics">SEO & Analytics</a></li>
                                <li><a href="/tag/affiliate">Affiliate</a></li>
                                <li><a href="/tag/video-marketing">Video marketing</a></li>
                                <li><a href="/tag/chien-luoc-marketing">Chiến lược marketing</a></li>
                            </ul>
                        </li>
                        <li>
                            <a title="Khóa học Sale, bán hàng từ các chuyên gia Marketing hàng đầu Unica" href="/course/sale-ban-hang"><i class="fa fa fa-shopping-cart" aria-hidden="true"></i> Sale, bán hàng</a>
                            <ul class="issub" style="z-index: 1002; display: none;">
                                <li><a href="/course/sale-ban-hang">Tất cả Sale, bán hàng</a></li>
                                <li><a href="/tag/ban-hang-online">Bán hàng online</a></li>
                                <li><a href="/tag/ban-hang-livestream">Bán hàng livestream</a></li>
                                <li><a href="/tag/kich-ban-ban-hang">Kịch bản bán hàng</a></li>
                                <li><a href="/tag/ky-nang-telesale">Kỹ năng telesale</a></li>
                                <li><a href="/tag/ky-nang-chot-sale">Kỹ năng chốt sale</a></li>
                                <li><a href="/tag/ky-nang-ban-hang">Kỹ năng bán hàng</a></li>
                            </ul>
                        </li>
                        <li>
                            <a title="Các khóa học kinh doanh và khởi nghiệp để gia tăng doanh số hiệu quả" href="/course/kinh-doanh-khoi-nghiep"><i class="fa fa fa-rocket" aria-hidden="true"></i> Kinh doanh - Khởi nghiệp</a>
                            <ul class="issub" style="z-index: 1002; display: none;">
                                <li><a href="/course/kinh-doanh-khoi-nghiep">Tất cả Kinh doanh - Khởi nghiệp</a></li>
                                <li><a href="/tag/chien-luoc-kinh-doanh">Chiến lược kinh doanh</a></li>
                                <li><a href="/tag/bat-dong-san">Bất động sản</a></li>
                                <li><a href="/tag/crypto">Crypto</a></li>
                                <li><a href="/tag/kinh-doanh-online">Kinh doanh online</a></li>
                                <li><a href="/tag/kinh-doanh">Kinh doanh</a></li>
                                <li><a href="/tag/khoi-nghiep">Khởi nghiệp</a></li>
                                <li><a href="/tag/startup">startup</a></li>
                                <li><a href="/tag/kiem-tien-online">Kiếm tiền online</a></li>
                                <li><a href="/tag/lam-giau-tai-chinh-ca-nhan">Làm giàu & Tài chính cá nhân</a></li>
                                <li><a href="/tag/ban-le-dich-vu">Bán lẻ - Dịch vụ</a></li>
                                <li><a href="/tag/chung-khoan">Chứng khoán</a></li>
                                <li><a href="/tag/dau-tu">Đầu tư</a></li>
                            </ul>
                        </li>
                        <li>
                            <a title="Các khóa học phát triển cá nhân để cải thiện cuộc sống và sự nghiệp" href="/course/phat-trien-ca-nhan"><i class="fa fa fa-lightbulb-o" aria-hidden="true"></i> Phát triển cá nhân</a>
                            <ul class="issub" style="z-index: 1002; display: none;">
                                <li><a href="/course/phat-trien-ca-nhan">Tất cả Phát triển cá nhân</a></li>
                                <li><a href="/tag/tai-chinh-ca-nhan">Tài chính cá nhân</a></li>
                                <li><a href="/tag/ky-nang-lanh-dao">Kỹ năng lãnh đạo</a></li>
                                <li><a href="/tag/tang-hieu-qua-cong-viec">Tăng hiệu quả công việc</a></li>
                                <li><a href="/tag/ren-luyen-tri-nho">Rèn luyện trí nhớ</a></li>
                                <li><a href="/tag/thuyet-trinh">thuyết trình</a></li>
                                <li><a href="/tag/ky-nang-giao-tiep">Kỹ năng giao tiếp</a></li>
                            </ul>
                        </li>
                        <li>
                            <a title="Các khóa học nâng các kiến thức sức khỏe và giới tính cho người Việt" href="/course/suc-khoe-gioi-tinh"><i class="fa fa fa-heartbeat" aria-hidden="true"></i> Sức khỏe - Giới tính</a>
                            <ul class="issub" style="z-index: 1002; display: none;">
                                <li><a href="/course/suc-khoe-gioi-tinh">Tất cả Sức khỏe - Giới tính</a></li>
                                <li><a href="/tag/suc-khoe">Sức khoẻ</a></li>
                                <li><a href="/tag/giam-can">giảm cân</a></li>
                                <li><a href="/tag/suc-khoe-tinh-than">Sức khỏe tinh thần</a></li>
                                <li><a href="/tag/thien">Thiền</a></li>
                                <li><a href="/tag/nghe-thuat-quyen-ru">Nghệ thuật quyến rũ</a></li>
                                <li><a href="/tag/giam-stress">Giảm stress</a></li>
                                <li><a href="/tag/fitness-giam-can">Fitness - Giảm cân</a></li>
                                <li><a href="/tag/tinh-yeu">Tình yêu</a></li>
                                <li><a href="/tag/yoga">Yoga</a></li>
                                <li><a href="/tag/massage">Massage</a></li>
                                <li><a href="/tag/dinh-duong">Dinh dưỡng</a></li>
                            </ul>
                        </li>
                        <li>
                            <a title="Khóa học phong cách sống giúp thành công hơn trong cuốc sống" href="/course/phong-cach-song"><i class="fa fa fa-cutlery" aria-hidden="true"></i> Phong cách sống</a>
                            <ul class="issub" style="z-index: 1002; display: none;">
                                <li><a href="/course/phong-cach-song">Tất cả Phong cách sống</a></li>
                                <li><a href="/tag/guitar">Guitar</a></li>
                                <li><a href="/tag/lam-dep">Làm đẹp</a></li>
                                <li><a href="/tag/handmade">Handmade</a></li>
                                <li><a href="/tag/sao">Sáo</a></li>
                                <li><a href="/tag/san-xuat-nhac">Sản xuất nhạc</a></li>
                                <li><a href="/tag/ao-thuat">Ảo thuật</a></li>
                                <li><a href="/tag/am-nhac">Âm nhạc</a></li>
                                <li><a href="/tag/am-thuc-nau-an">Ẩm thực - Nấu ăn</a></li>
                                <li><a href="/tag/dance-zumba">Dance - Zumba</a></li>
                                <li><a href="/tag/phong-thuy">Phong thuỷ</a></li>
                            </ul>
                        </li>
                        <li>
                            <a title="Các khóa học nuôi dạy con đúng cách theo khoa học" href="/course/nuoi-day-con"><i class="fa fa fa-child" aria-hidden="true"></i> Nuôi dạy con </a>
                            <ul class="issub" style="z-index: 1002; display: none;">
                                <li><a href="/course/nuoi-day-con">Tất cả Nuôi dạy con </a></li>
                                <li><a href="/tag/giao-duc-som">Giáo dục sớm</a></li>
                                <li><a href="/tag/thai-giao">Thai giáo</a></li>
                                <li><a href="/tag/ky-nang-mem-cho-con">Kỹ năng mềm cho con</a></li>
                                <li><a href="/tag/an-dam">Ăn dặm</a></li>
                                <li><a href="/tag/tri-bieng-an">Trị biếng ăn</a></li>
                            </ul>
                        </li>
                        <li>
                            <a title="Các khoá học về hôn nhân, giữ gìn gia đình hạnh phúc" href="/course/hon-nhan-gia-dinh"><i class="fa fa fa-group" aria-hidden="true"></i> Hôn nhân & Gia đình</a>
                            <ul class="issub" style="z-index: 1002; display: none;">
                                <li><a href="/course/hon-nhan-gia-dinh">Tất cả Hôn nhân & Gia đình</a></li>
                                <li><a href="/tag/hon-nhan">Hôn nhân</a></li>
                            </ul>
                        </li>
                        <li>
                            <a title="Khóa học Tiếng Anh, Tiếng Nhật, Tiếng Hàn, Tiếng Trung Giao Tiếp" href="/course/ngoai-ngu"><i class="fa fa fa-language" aria-hidden="true"></i> Ngoại ngữ</a>
                            <ul class="issub" style="z-index: 1002; display: none;">
                                <li><a href="/course/ngoai-ngu">Tất cả Ngoại ngữ</a></li>
                                <li><a href="/tag/tieng-anh-giao-tiep">Tiếng anh giao tiếp</a></li>
                                <li><a href="/tag/tieng-han">Tiếng Hàn</a></li>
                                <li><a href="/tag/ngoai-ngu">Ngoại ngữ</a></li>
                                <li><a href="/tag/tieng-anh">Tiếng anh</a></li>
                                <li><a href="/tag/tieng-trung">Tiếng trung</a></li>
                                <li><a href="/tag/tieng-nhat">Tiếng nhật</a></li>
                                <li><a href="/tag/ielts">IELTS</a></li>
                                <li><a href="/tag/toeic">toeic</a></li>
                            </ul>
                        </li>
                        <li>
                            <a title="Các khóa học nhiếp ảnh, dựng phim từ chuyên gia trên Unica" href="/course/nhiep-anh-dung-phim"><i class="fa fa fa-camera" aria-hidden="true"></i> Nhiếp ảnh, dựng phim</a>
                            <ul class="issub" style="z-index: 1002; display: none;">
                                <li><a href="/course/nhiep-anh-dung-phim">Tất cả Nhiếp ảnh, dựng phim</a></li>
                                <li><a href="/tag/kien-thuc-nhiep-anh">Kiến thức nhiếp ảnh</a></li>
                                <li><a href="/tag/bien-tap-video">Biên tập video</a></li>
                                <li><a href="/tag/adobe-premiere">Adobe Premiere</a></li>
                                <li><a href="/tag/cong-cu-chinh-sua-anh">Công cụ chỉnh sửa ảnh</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>
            <a class="logo-mobile" href="/"><img src="{{ asset('frontend/images/tab_logo.png') }}" alt=""/></a>
            <a class="cart-mobile" href="{{route('cart.show')}}">
                <i class="fa fa-shopping-cart" aria-hidden="true"></i>
                {{-- <span class="unica-sl-cart" style="top:1px;"><b class="number-in-cart">0</b></span> --}}
            </a>
            <div class="login-mobile">
                <span class="ava-img" data-toggle="collapse" data-target="#userPanel">
                    <i class="fa fa-user"></i><!-- <img alt="ava" class="img-responsive" src="https://salemall.vn/assets/img/icon-user.svg"> -->
                </span>
                <div id="userPanel" class="popover user-login-panel">
                    <div class="popover-content">
                        <a class="btn btn-block btn-white" href="/login" class="btnDangxuat"><i class="fa fa-sign-in" aria-hidden="true"></i> Login</a>
                        <a class="btn btn-block btn-white" href="/register" class="btnDangxuat">Đăng ký</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="unica-home-menutop hidden-xs">
            <div class="container">
                <div class="row">
                    <div class="col-lg-3 col-sm-4 cate-md">
                        <a class="unica-logo" href="{{ url('/') }}"><img class="img-responsive" src="{{ asset('frontend/images/tab_logo.png') }}" alt="" width="138" height="33" /></a>
                        <div class="unica-menu-cate">
                            <i class="fa fa-th" aria-hidden="true"></i> Danh mục

                            {{-- CATEGORY BAR --}}
                            <nav id="mysidebarmenu" class="amazonmenu">
                                <ul>
                                    @foreach($category_fixed as $cat)
                                        <li>
                                            <a title="{!! $cat->name !!}" href="javascript:void(0)"><i class="fas {!! $cat->icon !!}"></i> {!! $cat->name !!}</a>
                                            <ul class="issub">
                                                {{-- <li><a href="{{ url('/') }}/category/{{ $cat->slug }}"><strong>All {!! $cat->name !!}</strong></a></li> --}}
                                                @if(count($cat->childrenHavingCourse) > 0)
                                                    @foreach($cat->childrenHavingCourse as $children)
                                                    @php
                                                        // print_r($children);
                                                    @endphp
                                                        @if($children->has('courses'))
                                                        <li><a href="{{ url('/') }}/category/{{ $children->slug }}">{!! $children->name !!}</a></li>
                                                        @endif
                                                    @endforeach
                                                @endif
                                            </ul>
                                        </li>
                                    @endforeach
                                </ul>
                            </nav>

                            <script>
                                var catPanelHeight = $("#mysidebarmenu").height()
                                $("#mysidebarmenu .issub").css("height", catPanelHeight)
                                $("#mysidebarmenu .issub").css("overflow", "auto")

                            </script>
                        </div>
                    </div>
                    <div class="col-lg-5 col-sm-4 cate-sm">
                        <form class="unica-search-boxtop navbar-form form-inline" method="GET" action="/search">
                            <input name="keyword" type="text" class="form-control unica-form" placeholder="Tìm kiếm khoá học" value="{{ Request::get('keyword') }}">
                            <button type="submit" class="unica-btn-search"><i class="fa fa-search" aria-hidden="true"></i></button>
                        </form>
                    </div>
                    <div class="col-lg-4 col-sm-4 cate-sm">
                        <?php //echo $check_course_of_the_user;die; ?>
                        <div class="pull-right">
                            <ul class="unica-acc-zone db-item">
                                @if(Auth::check())
                                    @if ( !(count(Auth::user()->userRoles) == 1 && (Auth::user()->userRoles->first()->role_id) == 1) )
                                        <li><a href="{{ url('user/student/course') }}" class="unica-active-course responsive-start-learning"><p class="hidden-md hidden-xs hidden-sm">Vào học</p></a></li>
                                    @else
                                        <li><a href="{{ url('admincp') }}" class="unica-admin"><p class="hidden-md hidden-xs hidden-sm">Trang quản trị</p></a></li>
                                    @endif
                                {{-- </li> --}}
                                @endif
                            <li>
                                <a href="{{route('cart.show')}}" class="unica-cart">

                                    <img src="{{ asset('frontend/images/tab_cart.png') }}" alt="" style="width: 21px;" />
                                    <span class="unica-sl-cart"><b class="number-in-cart">0</b></span>
                                </a>
                                <li>

                                    @if(Auth::check())
                                    <li>
                                        <div class="dropdown" id="btnMailBoxNav">
                                            <a class="unica-cart unica-mail" href="/user/student/mail-box">
                                                <img src="{{ asset('frontend/images/tab_notifications.png') }}" alt="" style="width: 21px;" />
                                                <span class="unica-sl-notify"><b></b></span>
                                            </a>
                                            <ul class="dropdown-menu hidden" id="mailBoxNavDropdown" style="top:3em;">
                                                <li class="row">
                                                    <div class="col-xs-12 w-100">Lorem ipsum dolor sit amet conser ve</div>
                                                </li>
                                            </ul>
                                        </div>
                                    </li>
                                    <li class="btn-group">
                                        <a class="db-item-circle dropdown-toggle" data-toggle="dropdown" href="javascript:void(0)"><img class="img-responsive" src="{{ asset('frontend/'.(Auth::user()->avatar != '' ? Auth::user()->avatar : 'images/avatar.jpg')) }}" alt="avatar"><span class="caret"></span></a>                                    
                                        <ul class="dropdown-menu db-drop">
                                            @if ( !(count(Auth::user()->userRoles) == 1 && (Auth::user()->userRoles->first()->role_id) == 1) )
                                                @if ($check_multi_role_user == 2)
                                                    <li><a href="{{ url('user/teacher/course') }}"><i class="fas fa-chalkboard-teacher"></i> Giảng viên</a></li>
                                                    <li><a href="{{ url('user/student/course') }}"><i class="fas fa-user-graduate"></i> Học viên</a></li>
                                                @else                                                
                                                    <li><a href="{{ url('user/student/course') }}"><i class="fa fa-list-alt" aria-hidden="true"></i> Vào học</a></li>
                                                    {{-- <li><a href="{{ route('coming-soon') }}"><i class="fa fa-share-alt" aria-hidden="true"></i> Affiliate</a></li> --}}
                                                    {{-- <li><a href="{{ route('coming-soon') }}"><i class="fa fa-key" aria-hidden="true"></i> Activate course</a></li> --}}
                                                    <li><a href="{{ url('user/student/profile') }}"><i class="fa fa-user" aria-hidden="true"></i> Hồ sơ </a></li>
                                                    <li><a href="{{ url('/user/student/top-up') }}"><i class="fa fa-credit-card" aria-hidden="true"></i>  Nạp tiền </a></li>
                                                @endif
                                            @else
                                                {{-- <li><a href="{{ url('admincp') }}"><i class="fas fa-user-shield"></i> Admin Page</a></li>           --}}

                                            @endif
                                            <li class="divider"></li>
                                            <li><a href="{{ url('user/logout') }}" class="btnDangxuat"><i class="fas fa-sign-out-alt"></i> Đăng xuất</a></li>
                                            <li><a href="#" onclick="signOut();">Sign out</a></li>
                                            <script src="https://apis.google.com/js/platform.js" async></script>
                                            <script>
                                                function signOut() {
                                                    var auth2 = gapi.auth2.getAuthInstance();
                                                    // var auth2 = gapi.auth2.GoogleAuth.signOut();
                                                    auth2.signOut().then(function () {
                                                    console.log('User signed out.');
                                                    });
                                                }
                                            </script>
                                        </ul>
                                    </li>
                                    @else
                                    <li class="special" data-toggle="modal" data-target="#myModalLogin" data-dismiss="modal"><a class="unica-log-acc" href="javascript:void(0)" >Đăng nhập</a></li>
                                    <li class="special button-sign-up" data-toggle="modal" data-target="#myModalRegister" data-dismiss="modal"><a class="unica-reg-acc" href="javascript:void(0)">Đăng ký</a></li>
                                    <div id="myModalLogin" class="modal fade" role="dialog" >
                                        <div class="modal-dialog modal-login">
                                            <div class="modal-content">
                                                <div class="modal-header">				
                                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                    <div class="modal-title"><b>Đăng nhập vào tài khoản Courdemy của bạn</b></div>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="social-login">
                                                        <a href="{{url('/redirect')}}" class="btn btn-lg btn-primary btn-block kpx_btn-facebook" data-toggle="tooltip" data-placement="top" title="Facebook">
                                                            <span class="social-login-icon">
                                                                <i class="fab fa-facebook-f fa-lg fa-fw"></i>
                                                            </span>
                                                            Đăng nhập với facebook
                                                        </a>
                                                        <a href="#" class="btn btn-lg btn-danger btn-block kpx_btn_google" data-toggle="tooltip" data-placement="top" title="Google">
                                                            <span class="social-login-icon">
                                                                <i class="fab fa-google fa-lg fa-fw"></i>
                                                            </span>
                                                            Đăng nhập với Google
                                                        </a>
                                                    </div>
                                                    @include('components.google-login')

                                                    <br />
                        {{-- <p style="margin-left:265px">OR</p>
                        <br />
                        <div class="form-group">
                            <div class="col-md-8 col-md-offset-4">
                              <a href="{{url('/redirect')}}" class="btn btn-primary">Login with Facebook</a>
                            </div>
                        </div> --}}

                                                    <form action="/examples/actions/confirmation.php" method="post">
                                                        <div class="form-group">
                                                            <div class="input-group">
                                                                <span class="input-group-addon"><i class="fas fa-envelope fa-fw fa-md"></i></span>
                                                                <input type="t" class="form-control" name="email" placeholder="Email" required="required">
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="input-group password-group">
                                                                <span class="input-group-addon"><i class="fas fa-lock fa-fw fa-md"></i></span>
                                                                <input type="password" class="form-control" name="pass" placeholder="Mật khẩu" required="required" id="showMyPassword">
                                                                <div class="show-password" onclick="showPassword()">
                                                                    <i class="fas fa-eye fa-fw fa-md" id="eye"></i>
                                                                    <!-- <i class="fas fa-eye-slash fa-fw fa-lg" style="display:none"></i> -->
                                                                </div>
                                                            </div>
                                                            <!-- <div><input type="checkbox" onclick="showPassword()"> Hiển thị mật khẩu</div> -->
                                                        </div>
                                                        {{-- <div class="form-group">
                                                            <input type="checkbox" name="remember"> Keep my logged in on this computer
                                                        </div> --}}
                                                        <div class="form-group">
                                                            <input type="button" class="btn btn-success btn-block btn-lg" value="Đăng nhập" onclick="loginAjax()">
                                                        </div>
                                                    </form>
                                                    <div class="forgot-password">
                                                        <div>
                                                            <a href="#">Quên mật khẩu?</a>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="modal-footer">
                                                    <div class="link-to-sign-up">
                                                        <div>
                                                            Bạn chưa có tài khoản? <a href="javascript:void(0)" data-toggle="modal" data-target="#myModalRegister" data-dismiss="modal"><b>Đăng ký</b></a>
                                                        </div>
                                                    </div>
                                                    {{-- <a href="javascript:void(0)" data-toggle="modal" data-target="#myModalRegister" data-dismiss="modal">Need an account</a> --}}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="myModalRegister" class="modal fade" role="dialog" >
                                        <div class="modal-dialog modal-login">
                                            <div class="modal-content">
                                                <div class="modal-header">				
                                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                    <div class="modal-title"><b>Tạo tài khoản mới</b></div>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="/examples/actions/confirmation.php" method="post">
                                                        <div class="form-group">
                                                            <div class="input-group">
                                                                <span class="input-group-addon"><i class="fas fa-user fa-lock fa-fw fa-md"></i></span>
                                                                <input type="text" class="form-control" name="name" placeholder="Tên của bạn" required="required">
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="input-group">
                                                                <span class="input-group-addon"><i class="fas fa-envelope fa-envelope fa-fw fa-md"></i></span>
                                                                <input type="email" class="form-control" name="email" placeholder="Email" required="required">
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="input-group">
                                                                <span class="input-group-addon"><i class="fas fa-lock fa-fw fa-md"></i></span>
                                                                <input type="password" class="form-control" name="pass" placeholder="Mật khẩu" required="required">
                                                            </div>				
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="input-group">
                                                                <span class="input-group-addon"><i class="fas fa-lock fa-fw fa-md"></i></span>
                                                                <input type="password" class="form-control" name="confirmpass" placeholder="Nhập lại mật khẩu" required="required">
                                                            </div>				
                                                        </div>
                                                        {{-- <div class="terms-and-policy">
                                                            <label class="checkbox-inline"><input type="checkbox">You agree to our <a href="#">Terms of Use</a> and <a href="#">Privacy Policy</a>!</label>
                                                        </div> --}}
                                                        <div class="form-group">
                                                            <input type="button" class="btn btn-success btn-block btn-lg" value="Đăng ký" onclick="registerAjax()">
                                                        </div>
                                                    </form>				
                                                </div>
                                                <div class="modal-footer">
                                                    <div class="link-to-sign-up">
                                                        <div>
                                                            Bạn đã có tài khoản? <a href="javascript:void(0)" data-toggle="modal" data-target="#myModalLogin" data-dismiss="modal"><b>Đăng nhập</b></a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                </ul>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!-- <div class="hidden-xs" style="margin-top: 63px;"></div> -->
    <!-- <div class="hidden-md hidden-sm hidden-lg" style="margin-top: 45px;"></div> -->
    <div class="hidden-md hidden-sm hidden-lg"></div>
    <!-- End Google Tag Manager (noscript) -->
    <script src="{{ asset('frontend/js/bootstrap.offcanvas.js') }}"></script>
    <script src="{{ asset('frontend/js/sidenav.min.js') }}"></script>
    <script src="{{ asset('frontend/js/amazonmenu.js') }}"></script>

    @yield('content')

    <div id="button" style="display:none;"><i class="fas fa-angle-double-up"></i></div>

    {{-- Begin Footer --}}
    <footer>
        <div class="item-1">
            <div class="container">
                <div class="row">
                    <div class="col-sm-8 col-xs-12">
                        <div class="img-logo">
                            <img src="{{ asset('frontend/images/footer_logo.png') }}">    
                        </div>
                        <div class="row">
                            <div class="col-xs-4">
                                <p><a href="javascript:void(0)" title="Business">Business</a></p>
                                <p><a href="javascript:void(0)" title="Certificates">Certificates</a></p>
                                <p><a href="javascript:void(0)" title="Beta Testers">Beta Testers</a></p>
                            </div>
                            <div class="col-xs-4">
                                <p><a href="javascript:void(0)" title="Business">Business</a></p>
                                <p><a href="javascript:void(0)" title="Certificates">Certificates</a></p>
                                <p><a href="javascript:void(0)" title="Beta Testers">Beta Testers</a></p>
                            </div>
                            <div class="col-xs-4">
                                <p><a href="javascript:void(0)" title="Business">Business</a></p>
                                <p><a href="javascript:void(0)" title="Certificates">Certificates</a></p>
                                <p><a href="javascript:void(0)" title="Beta Testers">Beta Testers</a></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4 hidden-xs">
                        <div class="img-fanpage">
                            <!-- <img src="{{ asset('frontend/images/fanpage.png') }}" alt="fanpage" id="img-fanpage" /> -->
                            <iframe src="https://www.facebook.com/plugins/page.php?href=https%3A%2F%2Fwww.facebook.com%2Ftopthuthuat.vn%2F&tabs=timeline&width=300&height=200&small_header=false&adapt_container_width=true&hide_cover=false&show_facepile=true&appId" width="300" height="200" style="overflow:hidden" scrolling="no" frameborder="0" allowTransparency="true" allow="encrypted-media"></iframe>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="item-2">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 text-center">
                        {{-- <ul class="pull-left">
                            <li><a href="javascript:void(0)" title="home">Home</a></li>
                            <li><a href="javascript:void(0)" title="private policy">Private Policy</a></li>
                            <li><a href="javascript:void(0)" title="cookie policy">Cookie Policy</a></li>
                            <li><a href="javascript:void(0)" title="job post">Job Post</a></li>
                        </ul> --}}
                        <p class="copyright">Copyright &copy; 2019 by courdemy.com. All rights servered!</p>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <script>
        $(window).scroll(function(event){
            if ($(this).scrollTop() > 0){
                $('.unica-home-menutop').addClass('fixed');
            } else {
                $('.unica-home-menutop').removeClass('fixed');
            }
        });
        if(localStorage.getItem('cart') != []){
            
        }
        @if(Auth::check())
        $(document).ready( function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                method: 'GET',
                url: 'user/getDataMailBoxNavAjax',
                success: function (response) {
                    $("#mailBoxNavDropdown").empty()
                    
                    var unreadEmails = response.unread_emails
                    unreadEmails.forEach( email => {
                        var html = ''
                        html += '<li class="row">'
                            html += '<div class="col-xs-12 w-100">'+email.title+'</div>'
                        html += '</li>'
                        
                        $("#mailBoxNavDropdown").append(html)                            
                    });
                    
                    $(".unica-sl-notify b").text(response.unread_emails.length)

                    if(response.unread_emails.length < 1){
                        // $(".unica-sl-notify").remove()
                        $('.unica-sl-notify').css('display', 'none' )
                    }

                },
                error: function (response) {

                }
            })
            // $("#btnMailBoxNav").on('show.bs.dropdown', function () {
            // })
        })
        @endif

        jQuery(function () {
            amazonmenu.init({
                menuid: 'mysidebarmenu'
            })

            var btn = $('#button');

            $(window).scroll(function() {
                if ($(window).scrollTop() > 300) {
                    btn.fadeIn();
                } else {
                    btn.fadeOut();
                }
            });

            btn.on('click', function(e) {
                e.preventDefault();
                $('html, body').animate({scrollTop:0}, '300');
            });

            $('.unica-btn-search').click(function(){
                if($("input[name=keyword]").val().trim().length > 0){
                    $('.unica-search-boxtop').submit()
                }else{
                    Swal.fire({
                            type: 'warning',
                            html: 'Bạn chưa nhập từ khoá!',
                        })
                        .then((result) => {
                            if (result.value) {
                                $("input[name=keyword]").focus();
                            }
                        });
                    return false;
                }
            })

            $(".box-course .img-course .img-mask .btn-add-to-cart button").click( function(e){
                e.stopPropagation()
                e.preventDefault()

                var item = {
                    'id' : $(this).attr("data-id"),
                    'image' : $(this).attr("data-image"),
                    'slug' : $(this).attr("data-slug"),
                    'lecturer' : $(this).attr("data-lecturer"),
                    'name' : $(this).attr("data-name"),
                    'price' : parseInt($(this).attr("data-price")),
                    'real_price' : parseInt($(this).attr("data-real-price")),
                    'coupon_price' : parseInt($(this).attr("data-price")),
                    'coupon_code' : '',
                }

                if (localStorage.getItem("cart") != null) {
                    var list_item = JSON.parse(localStorage.getItem("cart"));
                    addItem(list_item, item);
                    localStorage.setItem("cart", JSON.stringify(list_item));
                }else{
                    var list_item = [];
                    addItem(list_item, item);
                    localStorage.setItem("cart", JSON.stringify(list_item));
                }

                var number_items_in_cart = JSON.parse(localStorage.getItem('cart'))
                // alert(number_items_in_cart.length)
                $('.number-in-cart').text(number_items_in_cart.length);

                if(number_items_in_cart.length < 1){
                    $('.unica-sl-cart').css('display', 'none')
                }
                if(number_items_in_cart.length >= 1){
                    $('.unica-sl-cart').css('display', 'block' )
                }

                $('.course-'+$(this).attr("data-id")).remove();
                Swal.fire({
                    type: 'success',
                    text: 'Đã thêm vào giỏ hàng!'
                })
            })

            if(localStorage.getItem('cart') !== null){
                var number_items_in_cart = JSON.parse(localStorage.getItem('cart'))
                var product_bought = [];
                @if(\Auth::check())
                    @php
                        $bought = [];
                        $products = [];
                        if(\Auth::user()->bought) $bought = \json_decode(\Auth::user()->bought);
                        if(\Auth::user()->products) $products = \json_decode(\Auth::user()->products);
                        $product_bought = array_merge($bought,$products);
                        foreach($product_bought as $b){
                            echo "product_bought.push(".$b.");";
                        }
                    @endphp
                @endif
                
                // alert(1)
                var id_to_remove = []
                
                $.each( number_items_in_cart, function(i, obj) {                
                    
                    $('button[data-id='+obj.id+']').remove();
                    // console.log(obj);
                    
                    
                    // for(var k = 0; k < product_bought.length; k++){
                    //     if(obj.id == product_bought[k]){
                    //         console.log(`phantu thu ${k}`);
                    //         id_to_remove.push(i)
                    //     }
                    // }
                    
                    product_bought.forEach( (element, index) => {
                        if(element == obj.id){
                            id_to_remove.push(obj.id)
                            $('.cart-single-item[data-parent='+obj.id+']').remove()
                        }else{
                           
                        }
                    });
                });
                
                id_to_remove.forEach(element => {
                    var result = number_items_in_cart.filter( item => item.id != element)
                    number_items_in_cart = result

                });                
                $('.course-amount').text(`(${number_items_in_cart.length})`)
                $('#course-amount').text(total_amount);
                var total_price = 0;
                var total_real_price = 0;
                var total_amount = 0;
                number_items_in_cart.forEach(item => {
                    total_price += item.coupon_price
                    total_real_price += item.real_price
                    total_amount++;
                })
                
                if(total_price == total_real_price){
                    $('.current-price span').text(number_format(total_price, 0, '.', '.') + " ₫");
                }else{
                    $('.initial-price span').text(number_format(total_real_price, 0, '.', '.') + " ₫");
                    $('.percent-off span').text("Tiết kiệm " + Math.floor(100-(total_price/total_real_price)*100) + "%");
                }
                // $('.unica-sl-cart').get(0).css('display', 'block' )

                if(number_items_in_cart.length < 1){
                    $(".cart-page-empty").addClass('active')
                    $(".cart-page-content").removeClass('active')
                    // $('.unica-sl-cart').remove()
                    $('.unica-sl-cart').css('display', 'none' )

                }


                localStorage.setItem('cart',JSON.stringify(number_items_in_cart))
                

                $('.number-in-cart').text(number_items_in_cart.length);
            }else{
                $('.number-in-cart').text("0");
                $('.unica-sl-cart').css('display', 'none')      
            }
        })

        @if (Request::is('home') && !Auth::check())
        $(window).on('load',function(){
            $('#myModalLogin').modal('show');
        });
        @endif

        $("#redirect_register_teacher").click(function(){
            localStorage.setItem('redirect_register_teacher', 1);  
            // alert(localStorage.getItem('redirect_register_teacher'));
        });

        $('#myModalLogin input[name=email],#myModalLogin input[name=pass],#myModalLogin input[name=remember]').keypress(function(event){
            var keycode = (event.keyCode ? event.keyCode : event.which);
            if(keycode == '13'){
                loginAjax();
                return false;
            }
        });

        function loginAjax(){
            var email = $('#myModalLogin input[name=email]').val();
            email = email.trim();
            var password = $('#myModalLogin input[name=pass]').val();
            var remember = $('#myModalLogin input[name=remember]').prop('checked');
            var data = {
                email:email,
                password: password,
                remember: remember,
            };
            $.ajaxSetup(
            {
                headers:
                {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            // console.log(data);
            $.ajax({
                method: "POST",
                url: '{{ url("loginAjax") }}',
                data: data,
                dataType: 'json',
                // beforeSend: function() {
                //     $("#pre_ajax_loading").show();
                // },
                // complete: function() {
                //     $("#pre_ajax_loading").hide();
                // },
                success: function (response) {
                    if(response.status == 200){
                        location.reload(true);
                    }else{
                        Swal.fire({
                            type: 'warning',
                            html: response.message,
                        })
                    }
                },
                error: function (error) {

                    var obj_errors = error.responseJSON.errors;
                    // console.log(obj_errors)
                    var txt_errors = '';
                    for (k of Object.keys(obj_errors)) {
                        txt_errors += obj_errors[k][0] + '</br>';
                    }
                    Swal.fire({
                        type: 'warning',
                        html: txt_errors,
                    })
                }
            });

            return false;
        } 

        function registerAjax(){
            var name = $('#myModalRegister input[name=name]').val();
            name = name.trim();
            var email = $('#myModalRegister input[name=email]').val();
            email = email.trim();
            var password = $('#myModalRegister input[name=pass]').val();
            var confirmpassword = $('#myModalRegister input[name=confirmpass]').val();
            var data = {
                name : name,
                email:email,
                password: password,
                confirmpassword: confirmpassword,
            };
            $.ajaxSetup(
            {
                headers:
                {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            // console.log(data);
            $.ajax({
                method: "POST",
                url: '{{ url("registerAjax") }}',
                data: data,
                dataType: 'json',
                // beforeSend: function() {
                //     $("#pre_ajax_loading").show();
                // },
                // complete: function() {
                //     $("#pre_ajax_loading").hide();
                // },
                success: function (response) {
                    if(response.status == 200){
                        Swal.fire({
                            type: 'success',
                            html: response.message,

                        }).then((result) => {
                            if (result.value) {
                                var check_redirect_register_teacher = localStorage.getItem('redirect_register_teacher');
                                if (check_redirect_register_teacher == 1) {
                                    localStorage.setItem('redirect_register_teacher', false); 
                                    window.location.href = "{{ url('user/register-teacher') }}";
                                } else {
                                    location.reload();
                                }
                            }
                        });
                    }else{
                        Swal.fire({
                            type: 'warning',
                            html: 'Error',
                        })
                    }
                },
                error: function (error) {             
                    var obj_errors = error.responseJSON.errors;
                    // console.log(obj_errors)
                    var txt_errors = '';
                    for (k of Object.keys(obj_errors)) {
                        txt_errors += obj_errors[k][0] + '</br>';
                    }
                    Swal.fire({
                        type: 'warning',
                        html: txt_errors,
                    })
                }
            });

            return false;
        }

        function addItem(arr, obj) {
            const { length } = arr;
            const found = arr.some(el => el.id === obj.id);
            if (!found) arr.push(obj);
            return arr;
        }
    </script>
    <script src="{{ asset('frontend/js/function.js') }}"></script>
    <script>
        var flag = 1;
        function showPassword() {
            var x = document.getElementById("showMyPassword");
            if (x.type === "password") {
                x.type = "text";
                flag = 1;
                $('#eye').removeClass('fa-eye')
                $('#eye').addClass('fa-eye-slash')
            } else {
                x.type = "password";
                flag = 0;
                $('#eye').removeClass('fa-eye-slash')
                $('#eye').addClass('fa-eye')
            }
        }
    </script>
</body>
</html>
