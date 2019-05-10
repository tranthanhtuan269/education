<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="vi" xmlns:og="http://ogp.me/ns#" xmlns:fb="http://ogp.me/ns/fb#">
    <head>
        <!-- Required meta tags -->
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <!-- <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"> -->
        <!-- <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no,viewport-fit=cover"> -->
        <meta name="viewport" content="width=device-width, maximum-scale=5.0, target-densitydpi=device-dpi">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <!-- Bootstrap CSS -->
        <link href="https://fonts.googleapis.com/css?family=Poppins" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="{{ asset('frontend/css/bootstrap.css') }}" />
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
        <link rel="stylesheet" type="text/css" href="{{ asset('frontend/css/bootstrap.offcanvas.min.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('frontend/css/sidenav.min.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('frontend/css/slick.css') }}">
        <link rel="stylesheet" href="{{ asset('frontend/css/style.css') }}" />
        <link rel="stylesheet" href="{{ asset('frontend/css/responsive.css') }}" />
        <script type="text/javascript" src="{{ asset('frontend/js/jquery-3.2.1.min.js') }}"></script>
        <script src="{{ asset('frontend/js/slick.min.js') }}"></script>
        <script src="{{ asset('frontend/js/jssor.slider.min.js') }}"></script>
        <title>@yield('title', 'Edu')</title>
        <meta name="description" content="@yield('description', '')"/>
        <meta name="keywords" content="@yield('keywords', '')"/>
        <meta name="copyright" content="Edu">
        <meta name="author" content="Edu"/>
        {{-- <meta http-equiv="refresh" content="2"> --}}
    </head>
    <body>
        <div class="notifications alert alert-danger fade in alert-dismissible">
            <div class="container">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="text-center">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">
                                <img src="{{ asset('frontend/images/tab_alert_close.png') }}" alt="" />    
                            </a>
                            <strong>Danger!</strong> This alert box indicates a dangerous or potentially negative action.
                        </div>
                    </div>
                </div>
            </div>
        </div>

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
                            <li><a href="/kichhoat"> Start Learning <i class="fa fa-key" aria-hidden="true"></i></a></li>
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
                <a class="cart-mobile" href="/gio-hang">
                <i class="fa fa-shopping-cart" aria-hidden="true"></i>
                <span class="unica-sl-cart" style="top:1px;"><b>0</b></span>
                </a>
                <div class="login-mobile">
                    <span class="ava-img" data-toggle="collapse" data-target="#userPanel">
                        <i class="fa fa-user"></i><!-- <img alt="ava" class="img-responsive" src="https://salemall.vn/assets/img/icon-user.svg"> -->
                    </span>
                    <div id="userPanel" class="popover user-login-panel">
                        <div class="popover-content">
                            <a class="btn btn-block btn-white" href="/login" class="btnDangxuat"><i class="fa fa-sign-in" aria-hidden="true"></i> Login</a>
                            <a class="btn btn-block btn-white" href="/register" class="btnDangxuat">Sign Up</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="unica-home-menutop hidden-xs">
                <div class="container">
                    <div class="row col-width-lg">
                        <div class="col-lg-3 col-md-3 col-sm-4 cate-md">
                            <a class="unica-logo" href="{{ route('home') }}"><img class="img-responsive" src="{{ asset('frontend/images/tab_logo.png') }}" alt="Unica - Học từ chuyên gia" width="138" height="33" /></a>
                            <div class="unica-menu-cate">
                                <i class="fa fa-th" aria-hidden="true"></i> Categories
                                <nav id="mysidebarmenu" class="amazonmenu">
                                    <ul>
                                        @foreach($category as $cat)
                                            <li>
                                                <a title="{!! $cat->name !!}" href="{{ url('/') }}/category/{{ $cat->id }}">{!! $cat->icon !!} {!! $cat->name !!}</a>
                                                <ul class="issub">
                                                    <li><a href="{{ url('/') }}/category/{{ $cat->id }}">Tất cả {!! $cat->name !!}</a></li>
                                                    @if(count($cat->tags) > 0)
                                                        @foreach($cat->tags as $tag)
                                                            <li><a href="{{ url('/') }}/tags/{{ $tag->id }}">{!! $tag->name !!}</a></li>
                                                        @endforeach
                                                    @endif
                                                </ul>
                                            </li>
                                        @endforeach
                                    </ul>
                                </nav>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4 cate-sm">
                            <form class="unica-search-boxtop navbar-form form-inline" method="GET" action="/search">
                                <input name="key" type="text" class="form-control unica-form" placeholder="Search for anything">
                                <button type="submit" class="btn unica-btn-search"><i class="fa fa-search" aria-hidden="true"></i></button>
                            </form>
                        </div>
                        <div class="col-lg-5 col-md-5 col-sm-5 cate-sm">
                            @if (Auth::check())
                            <a href="/kichhoat" class="unica-active-course">
                                <p class="hidden-md hidden-xs hidden-sm">Start Learning</p>
                            </a>
                            @endif
                   
                            <ul class="unica-acc-zone">
                                @if (Auth::check())
                                <li><a href="/gio-hang" class="unica-cart">
                                    <img src="{{ asset('frontend/images/tab_cart.png') }}" alt="" style="width: 21px;" />
                                    <span class="unica-sl-cart"><b>0</b></span>
                                </a></li>
                                <li><a href="/gio-hang" class="unica-cart">
                                    <img src="{{ asset('frontend/images/tab_notifications.png') }}" alt="" style="width: 21px;" />
                                    <span class="unica-sl-cart"><b>0</b></span>
                                </a></li>
                                @else
                                <li class="special"><a class="unica-log-acc" href="/login">Login</a></li>
                                <li class="special"><a class="unica-reg-acc" href="/register">Sign Up</a></li>
                                @endif
                            </ul>
                    
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!-- <div class="hidden-xs" style="margin-top: 63px;"></div> -->
    <div class="hidden-md hidden-sm hidden-lg" style="margin-top: 45px;"></div>

    <!-- End Google Tag Manager (noscript) -->
    <script src="{{ asset('frontend/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('frontend/js/bootstrap.offcanvas.js') }}"></script>
    <script src="{{ asset('frontend/js/sidenav.min.js') }}"></script>
    <script src="{{ asset('frontend/js/amazonmenu.js') }}"></script>
    <!-- <script src="{{ asset('frontend/js/myScript.js') }}"></script> -->
    <script>

        jQuery(function () {
            amazonmenu.init({
                menuid: 'mysidebarmenu'
            })
        })

    </script>

    @yield('content')

    {{-- Begin Footer --}}
    <footer>
        <div class="item-1">
            <div class="container">
                <div class="row">
                    <div class="col-sm-8 col-xs-12">
                        <div class="row">
                            <div class="col-md-7 col-xs-8">
                                <div class="img-logo">
                                    <img src="{{ asset('frontend/images/footer_logo.png') }}">    
                                </div>
                            </div>
                            <div class="col-sm-12">                           
                                <div class="row">
                                    <div class="col-sm-4 col-xs-6">
                                        <p><a href="#" title="Business">Business</a></p>
                                        <p><a href="#" title="Certificates">Certificates</a></p>
                                        <p><a href="#" title="Beta Testers">Beta Testers</a></p>
                                    </div>
                                    <div class="col-sm-4 col-xs-6">
                                        <p><a href="#" title="Business">Business</a></p>
                                        <p><a href="#" title="Certificates">Certificates</a></p>
                                        <p><a href="#" title="Beta Testers">Beta Testers</a></p>
                                    </div>
                                    <div class="col-sm-4 col-xs-6">
                                        <p><a href="#" title="Business">Business</a></p>
                                        <p><a href="#" title="Certificates">Certificates</a></p>
                                        <p><a href="#" title="Beta Testers">Beta Testers</a></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4 hidden-xs">
                        <div class="img-fanpage">
                            <img src="{{ asset('frontend/images/fanpage.png') }}" alt="fanpage" id="img-fanpage" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="item-2">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <ul class="pull-left">
                            <li><a href="#" title="home">Home</a></li>
                            <li><a href="#" title="private policy">Private Policy</a></li>
                            <li><a href="#" title="cookie policy">Cookie Policy</a></li>
                            <li><a href="#" title="job post">Job Post</a></li>
                        </ul>
                        <span class="pull-right copyright">Copyright C 2019 by courdemy.com. All rights servered!</span>
                    </div>
                </div>
            </div>
        </div>
    </footer>
</body>
</html>
