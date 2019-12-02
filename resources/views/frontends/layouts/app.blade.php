<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="vi" xmlns:og="http://ogp.me/ns#" xmlns:fb="http://ogp.me/ns/fb#">
<head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <!-- Google API login -->
    <meta name="google-signin-client_id" content="508966694234-hnjrjckdoksk236omqa9kmmtsinq99sd.apps.googleusercontent.com">

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
    <script src="{{ asset('frontend/js/sweetalert2.min.js') }}"></script>
    <link rel="stylesheet" type="text/css" href="{{ asset('frontend/css/sweetalert2.min.css') }}">
    <title>@yield('title', 'Edu')</title>
    <meta name="description" content="@yield('description', '')"/>
    <meta name="keywords" content="@yield('keywords', '')"/>
    <meta name="copyright" content="Edu">
    <meta name="author" content="Edu"/>
    <base href="{{ url('/') }}">

    {{-- Facebook Share --}}
    <meta property="og:title" content="@yield('fb_og_title', '')"/>
    <meta property="og:image" content="@yield('fb_og_image', '')"/>
    <meta property="og:description" content="@yield('fb_og_description', '')"/>
    <meta property="og:image:atl" content="@yield('fb_og_image_alt', '')"/>
    <meta property="og:type" content="@yield('fb_og_type', '')"/>
    <meta property="og:url" content="@yield('fb_og_url', '')"/>
</head>
<body>
    <div class="ajax_waiting"></div>
        <div id="fb-root"></div>
        <script async defer crossorigin="anonymous" src="https://connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v5.0&appId=426138308059078&autoLogAppEvents=1"></script>
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
        @if (\App\Helper::isMobile())
            <div id="menu-container">
                <ul class="menu-list accordion">
                    @foreach($category_fixed as $cat)
                        @if(count($cat->childrenHavingCourse) > 0)
                            <li class="toggle accordion-toggle"> 
                                <span class="icon-plus"></span>
                                <a class="menu-link" title="{!! $cat->name !!}" href="javascript:void(0)"><i class="fas {!! $cat->icon !!}"></i> {!! $cat->name !!}</a>
                            </li>
                            <ul class="menu-submenu accordion-content">
                                @foreach($cat->childrenHavingCourse as $children)
                                    @if($children->has('courses'))
                                    <li><a class="head" href="{{ url('/') }}/category/{{ $children->slug }}">{!! $children->name !!}</a></li>
                                    @endif
                                @endforeach
                            </ul>
    
                        @endif
                    @endforeach
                </ul>
                <script>
                    $(function() {
                        function slideMenu() {
                            var activeState = $("#menu-container .menu-list").hasClass("active");
                            $("#menu-container .menu-list").animate({left: activeState ? "0%" : "-100%"}, 400);
                        }
                        $("#menu-wrapper").click(function(event) {
                            event.stopPropagation();
                            $("#hamburger-menu").toggleClass("open");
                            $("#menu-container .menu-list").toggleClass("active");
                            slideMenu();
    
                            $("body").toggleClass("overflow-hidden");
                        });
    
                        $(".menu-list").find(".accordion-toggle").click(function() {
                            $(this).next().toggleClass("open").slideToggle("fast");
                            $(this).toggleClass("active-tab").find(".menu-link").toggleClass("active");
    
                            $(".menu-list .accordion-content").not($(this).next()).slideUp("fast").removeClass("open");
                            $(".menu-list .accordion-toggle").not(jQuery(this)).removeClass("active-tab").find(".menu-link").removeClass("active");
                        });
                    });
                </script>
            </div>
        @else
            <div class="unica-home-menutop hidden-xs fixed" id="showHideHeader">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-3 col-sm-4 cate-md">
                            <a class="unica-logo" href="{{ url('/') }}"><img class="img-responsive" src="{{ asset('frontend/images/tab_logo.png') }}" alt="" width="138" height="33" /></a>
                            <!-- <div class="unica-menu-cate">
                                <i class="fa fa-th" aria-hidden="true"></i> Danh mục
    
                                {{-- CATEGORY BAR --}}
                                <nav id="mysidebarmenu" class="amazonmenu">
                                    <ul>
                                        @foreach($category_fixed as $cat)
                                        @if(count($cat->childrenHavingCourse) > 0)
                                            <li>
                                                <a title="{!! $cat->name !!}" href="javascript:void(0)"><i class="fas {!! $cat->icon !!}"></i> {!! $cat->name !!}</a>
                                                <ul class="issub">
                                                        @foreach($cat->childrenHavingCourse as $children)
                                                            @if($children->has('courses'))
                                                            <li><a href="{{ url('/') }}/category/{{ $children->slug }}">{!! $children->name !!}</a></li>
                                                            @endif
                                                        @endforeach
                                                    </ul>
                                                </li>
                                        @endif
                                        @endforeach
                                    </ul>
                                </nav>
    
                                <script>
                                    var catPanelHeight = $("#mysidebarmenu").height()
                                    $("#mysidebarmenu .issub").css("height", catPanelHeight)
                                    $("#mysidebarmenu .issub").css("overflow", "auto")
    
                                </script>
                            </div> -->
                        </div>
                        <div class="col-lg-5 col-sm-4 cate-sm">
                            <form class="unica-search-boxtop navbar-form form-inline" method="GET" action="/search">
                                <input name="keyword" type="text" class="form-control unica-form" placeholder="Tìm kiếm khoá học" value="{{ Request::get('keyword') }}">
                                <button type="submit" class="unica-btn-search"><i class="fa fa-search" aria-hidden="true"></i></button>
                            </form>
                        </div>
                        <div class="col-lg-4 col-sm-4 cate-sm">
                            <div class="pull-right">
                                <ul class="unica-acc-zone db-item">
                                    @if(Auth::check())
                                        @if(!Auth::user()->isAdmin())
                                            <li style="float:left"><a href="{{ url('user/student/course') }}" class="unica-active-course responsive-start-learning"><p class="hidden-md hidden-xs hidden-sm">Vào học</p></a></li>
                                        @else
                                            <li style="float:left"><a href="{{ url('admincp') }}" class="unica-admin"><p class="hidden-md hidden-xs hidden-sm">Trang quản trị</p></a></li>
                                        @endif
                                    @endif
                                    @if (Auth::check())
                                    <li style="float:left">
                                        @if (!Auth::user()->isAdmin())
                                            <a class="unica-cart"
                                            @if (\Request::is('cart'))
                                                style="opacity:0;cursor:auto;margin-left: -30px" disabled
                                            @else
                                                href="{{route('cart.show')}}"
                                            @endif
                                            >
                                                <img src="{{ asset('frontend/images/tab_cart.png') }}" alt="" style="width: 21px;" />
                                                @if (!\Request::is('cart'))
                                                <span class="unica-sl-cart" style="display: none;"><b class="number-in-cart"></b></span>
                                                @endif
                                                <button id="cartUserId" style="display:none" data-user-id="{{Auth::user()->id}}"></button>
                                            </a>
                                        @endif
                                    </li>
                                    @elseif(!Auth::check())
                                    <li style="float:left">
                                        <a href="{{route('cart.show')}}" class="unica-cart"
                                        @if (\Request::is('cart'))
                                            style="opacity:0;cursor:auto" disabled
                                        @else
                                            href="{{route('cart.show')}}"
                                        @endif
                                        >
                                            <img src="{{ asset('frontend/images/tab_cart.png') }}" alt="" style="width: 21px;" />
                                            @if (!\Request::is('cart'))
                                            <span class="unica-sl-cart" style="display: none;"><b class="number-in-cart"></b></span>
                                            @endif
                                            <button id="cartUserId" style="display:none" data-user-id="0"></button>
                                        </a>                            
                                    </li>
                                    @endif
    
                                        @if(Auth::check())
                                            @if (!Auth::user()->isAdmin())
                                            {{-- <li style="float:left">
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
                                            </li>                                         --}}
                                            <li class="btn-group" style="float:left">
                                                @if ( Auth::user()->registeredTeacher() )
                                                <a class="unica-cart unica-mail dropdown-toggle" data-toggle="dropdown" href="javascript:void(0)">
                                                    <img src="{{ asset('frontend/images/tab_notifications.png') }}" alt="" style="width: 21px;" />
                                                    <span class="unica-sl-notify"><b></b></span>
                                                </a>                                    
                                                <ul class="dropdown-menu db-drop">
                                                    <li><a href="/user/student/mail-box" class="student-mailbox">
                                                        <img src="{{ asset('frontend/images/tab_notifications.png') }}" alt="" style="width: 21px;" />
                                                        <span style="margin-left: 12px">Học viên</span>
                                                        <span class="sl-notify-student"><b>5</b></span>
                                                    </a></li>
                                                    <li><a href="/user/teacher/mail-box" class="teacher-mailbox">
                                                        <img src="{{ asset('frontend/images/tab_notifications.png') }}" alt="" style="width: 21px;" />
                                                        <span style="margin-left: 12px">Giảng viên</span>
                                                        <span class="sl-notify-teacher"><b>3</b></span>
                                                    </a></li>
                                                </ul>
                                                @else
                                                <a class="unica-cart unica-mail" href="/user/student/mail-box">
                                                    <img src="{{ asset('frontend/images/tab_notifications.png') }}" alt="" style="width: 21px;" />
                                                    <span class="sl-notify-student-only"><b></b></span>
                                                </a>
                                                @endif
                                            </li>
                                            @endif
                                        <li class="btn-group" style="float:left">
                                            <a class="db-item-circle dropdown-toggle" data-toggle="dropdown" href="javascript:void(0)"><img class="img-responsive" src="{{ asset('frontend/'.(Auth::user()->avatar != '' ? Auth::user()->avatar : 'images/avatar.jpg')) }}" alt="avatar" style="margin-top: 5px"><span class="caret"></span></a>                                    
                                            <ul class="dropdown-menu db-drop">
                                                @if ( !Auth::user()->isAdmin() )
                                                    @if (Auth::user()->registeredTeacher())
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
                                                <li><a href="{{ url('user/logout') }}" class="btnDangxuat btn-google-logout btn-logout-account"><i class="fas fa-sign-out-alt"></i> Đăng xuất</a></li>
    
                                                @if($_SERVER['SERVER_NAME'] === "courdemy.vn")
                                                    <div class="g-signin2" data-onsuccess="onSignIn" style="display:none"></div>
                                                    <script src="https://apis.google.com/js/platform.js" async></script>
                                                    {{-- <fb:login-button scope="public_profile,email" login_text="Đăng nhập với Facebook" onlogin=checkLoginState() style="display:none"></fb:login-button> --}}
                                                    <script>
                                                        // $('.btn-google-logout').click()
                                                        function onSignIn(googleUser) {
                                                            var profile = googleUser.getBasicProfile();
    
                                                            var auth2 = gapi.auth2.getAuthInstance();
                                                            auth2.signOut().then(function () {
                                                            // console.log('User signed out.');
                                                            });
                                                            // location.reload();
                                                        }

                                                        // $('.btn-logout-account').click(function(){
                                                        //     checkLoginState()
                                                        // })

                                                        // function checkLoginState() {               // Called when a person is finished with the Login Button.
                                                        //     FB.logout(function(response) {
                                                        //         // Person is now logged out
                                                        //     });
                                                        // }
                                                    </script>
                                                @endif
                                            </ul>
                                        </li>
                                        @else
                                        <li class="special button-sign-in" data-toggle="modal" data-target="#myModalLogin" data-dismiss="modal"><a href="">Đăng nhập</a></li>
                                        <li class="special button-sign-up" data-toggle="modal" data-target="#myModalRegister" data-dismiss="modal"><a href="">Đăng ký</a></li>
                                        <script>
                                            $('.button-sign-in').click(function(e){
                                                e.stopPropagation()
                                                e.preventDefault()
                                                $('#resetFormsLogin').click()
                                                $("#myModalLogin").modal("toggle")
                                                // $('.alert-validate').html('')
                                                $('.form-html-validate').css('display', 'none')
                                            })
                                            $('.button-sign-up').click(function(e){
                                                e.stopPropagation()
                                                e.preventDefault()
                                                $('#resetFormsSignup').click()
                                                $("#myModalRegister").modal("toggle")
                                                // $('.alert-validate').html('')
                                                $('.form-html-validate').css('display', 'none')
                                            })
                                        </script>
                                        @endif
                                    </ul>
    
                                </div>
                            </div>
                        </div>
                        <div>
                            <ul class="nav main-menu-group">
                                @foreach($category_fixed as $key=>$cat)
                                    @if(count($cat->childrenHavingCourse) > 0)
                                        @if($key<7)
                                            <li class="main-menu-item"><a title="{!! $cat->name !!}" href="javascript:void(0)"><i class="fas {!! $cat->icon !!} fa-fw"></i> {!! $cat->name !!}</a>
                                                <ul class="sub-menu">
                                                    @foreach($cat->childrenHavingCourse as $children)
                                                        @if($children->has('courses'))
                                                            <li><a href="{{ url('/') }}/category/{{ $children->slug }}">{!! $children->name !!}</a></li>
                                                        @endif
                                                    @endforeach
                                                </ul>
                                            </li>
                                        @endif
                                    @endif
                                @endforeach
                                <li class="main-menu-item" id="addMenu" style="float:right">
                                    <a href="javascript:void(0)"><i class="fas fa-ellipsis-h"></i> Thêm</a>
                                    <ul class="sub-menu menu-them" id='menuThem'>
                                        @foreach($category_fixed as $key=>$cat)
                                            @if(count($cat->childrenHavingCourse) > 0)
                                                @if($key>=7)
                                                    <li ><a title="{!! $cat->name !!}" href="javascript:void(0)"><i class="fas {!! $cat->icon !!} fa-fw"></i> {!! $cat->name !!}</a>
                                                        <ul class="sub-menu menu-them-1">
                                                        @foreach($cat->childrenHavingCourse as $children)
                                                            @if($children->has('courses'))
                                                                <li><a href="{{ url('/') }}/category/{{ $children->slug }}">{!! $children->name !!}</a></li>
                                                            @endif
                                                        @endforeach
                                                        </ul>
                                                    </li>
                                                @endif
                                            @endif
                                        @endforeach
                                    </ul>
                                </li>
                            </ul>
                        </div>

                        <style>
                            .unica-home-menutop .nav>li{
                                float: left;
                            }
                                
                            .unica-home-menutop .nav>li>a{
                                color: black;
                            }
                                
                            .unica-home-menutop .nav li{
                                position: relative;
                                list-style:none;
                            }
                                
                            .unica-home-menutop .nav li a{
                                padding: 10px;
                                line-height: 20px;
                                display: inline-block;
                                color: black;
                            }
                                
                            .unica-home-menutop .nav .sub-menu{
                                display: none;
                                position: absolute;
                                top: -5px;
                                right: 100%;
                                width: 250px;
                                background-color: #ffffff;
                                padding: 5px 20px;
                                z-index: 1;
                                }
                                
                            .unica-home-menutop .nav li:hover>.sub-menu{
                                display: block;
                                }
                            .unica-home-menutop .nav>li>.sub-menu{
                                top: 40px;
                                left: 0;
                            }
                            .unica-home-menutop .nav li:hover > a {
                                background-color: #ffffff;
                                color: #428bca;
                            }
                            .unica-home-menutop .nav > li > a:focus{
                                background-color: #ffffff;
                            }
                        </style>
                    </div>
                </div>
            </div>
            <div class="menutop-side"></div>
        @endif
        <div class="sm-mobile-menu hidden-lg hidden-md hidden-sm">
            <div class="sm-navi-btn offcanvas-toggle js-offcanvas-has-events" data-toggle="offcanvas" data-target="#js-bootstrap-offcanvas">
                <div id="menu-wrapper">
                    <div id="hamburger-menu"><i class="fa fa-bars" aria-hidden="true"></i></div>
                </div>
            </div>
            <div class="c_header__search-wrapper pull-left">
                <button class="c_header__mobile-bt mobile-bt--search udi udi-search" data-toggle="collapse" data-target="#searchpanel">
                    <!-- <i class="ion-ios-search-strong"></i> -->
                    <i class="fa fa-search"></i>
                </button>
                <div class="c_header__search collapse" id="searchpanel" style="">
                    <div class="c_quick-search__form">
                        <form class="searchbox" method="GET" action="/search">
                            <input type="text" class="form-control sm-form" name="keyword" placeholder="Tìm khóa học, giảng viên bạn quan tâm">
                            <button type="submit" class="btn sm-btn-search"><i class="fa fa-search" aria-hidden="true"></i></button>
                        </form>
                    </div>
                </div>
            </div>
            <a class="logo-mobile" href="/"><img src="{{ asset('frontend/images/tab_logo.png') }}" alt=""/></a>
            <a class="cart-mobile" href="{{route('cart.show')}}">
                <i class="fa fa-shopping-cart" aria-hidden="true"></i>
                <span class="unica-sl-cart" style="top:1px; display: none;"><b class="number-in-cart">0</b></span>
            </a>
            <div class="login-mobile">
                <span class="ava-img" data-toggle="collapse" data-target="#userPanel">
                    <i class="fa fa-user"></i><!-- <img alt="ava" class="img-responsive" src="https://salemall.vn/assets/img/icon-user.svg"> -->
                </span>
                <div id="userPanel" class="popover user-login-panel">
                    <div class="popover-content">
                        @if(Auth::check())
                            @if (Auth::user()->isAdmin())
                                <a href="{{ url('admincp') }}" class="btn btn-block btn-white">Trang quản trị</a>
                            @elseif(Auth::user()->registeredTeacher())
                                <a href="{{ url('user/teacher/course') }}" class="btn btn-block btn-white">Giảng viên</a>
                                <a href="{{ url('user/student/course') }}" class="btn btn-block btn-white">Học viên</a>
                                <a href="{{ url('/user/student/top-up') }}" class="btn btn-block btn-white">Nạp tiền </a>
                            @else
                                <a href="{{ url('user/student/course') }}" class="btn btn-block btn-white">Vào học</a>
                                <a href="{{ url('/user/student/top-up') }}" class="btn btn-block btn-white">Nạp tiền </a>
                            @endif
                                <a href="{{ url('user/logout') }}" class="btn btn-block btn-white">Đăng xuất</a>
                        @else
                            <a class="btn btn-block btn-white" href="#" data-toggle="modal" data-target="#myModalLogin">Đăng nhập</a>
                            <a class="btn btn-block btn-white" href="#" data-toggle="modal" data-target="#myModalRegister">Đăng ký</a>
                        @endif
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
    <div id="min-height">
    @yield('content')
    </div>
    <div id="button" style="display:none;"><i class="fas fa-angle-double-up"></i></div>

    {{-- Begin Footer --}}
    <footer>
        <div class="item-1">
            <div class="container">
                <div class="row">
                    <div class="col-md-8 col-sm-7 col-xs-12">
                        <div class="img-logo">
                            <img src="{{ asset('frontend/images/footer_logo.png') }}">    
                        </div>
                        <div class="row">
                            <div class="col-sm-4" style="color:#fff">
                                <p><i class="fas fa-location-arrow fa-fw"></i> 48 Tố Hữu, Hà Nội</p>
                                <p><i class="fas fa-phone fa-fw"></i> 0918273645</p>
                                <p><i class="fas fa-envelope fa-fw"></i> cskh@courdemy.vn</p>
                            </div>
                            <div class="col-sm-4 col-xs-6">
                                <p><a href="/about">Giới thiệu Courdemy</a></p>
                                <p><a href="/faq">Câu hỏi thường gặp</a></p>
                                <p><a href="/terms-of-service">Điều khoản dịch vụ</a></p>
                            </div>
                            <div class="col-sm-4 col-xs-6">
                                <p><a href="/payment-guide">Hướng dẫn thanh toán</a></p>
                                @if (Auth::check())
                                    @if ( !Auth::user()->isAdmin() && !Auth::user()->registeredTeacher())
                                        <p><a href="/become-teacher">Đăng ký giảng viên</a></p>
                                    @endif
                                @else
                                    <p><a href="/become-teacher">Đăng ký giảng viên</a></p>
                                @endif
                                <p><a href="/affiliate">Tiếp thị liên kết</a></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-5 col-xs-12">
                        {{-- <div class="img-fanpage">
                            <iframe src="https://www.facebook.com/plugins/page.php?href=https%3A%2F%2Fwww.facebook.com%2Ftopthuthuat.vn%2F&tabs=timeline&width=300&height=200&small_header=false&adapt_container_width=true&hide_cover=false&show_facepile=true&appId" width="100%" height="200" style="overflow:hidden" scrolling="no" frameborder="0" allowTransparency="true" allow="encrypted-media"></iframe>
                        </div> --}}
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
                        <p class="copyright">&copy; 2019, Bản quyền thuộc về courdemy.vn. Bảo lưu mọi quyền!</p>
                        <p>v2019.12.02</p>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    @if (!Auth::check())
        <div id="myModalLogin" class="modal fade" role="dialog" >
            <div class="modal-dialog modal-login">
                <div class="modal-content">
                    <div class="modal-header">				
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <div class="modal-title"><b>Đăng nhập vào tài khoản Courdemy của bạn</b></div>
                    </div>
                    <div class="modal-body">
                        {{-- <div class="social-login">
                            <a href="{{url('/redirect')}}" class="btn btn-lg btn-primary btn-block kpx_btn-facebook" data-toggle="tooltip" data-placement="top" title="Facebook">
                                <span class="social-login-icon">
                                    <i class="fab fa-facebook-f fa-lg fa-fw"></i>
                                </span>
                                Đăng nhập với facebook
                            </a>
                            <div class="btn btn-lg btn-danger btn-block kpx_btn_google" id="btn-google-login">
                                <span class="social-login-icon">
                                    <i class="fab fa-google fa-lg fa-fw"></i>
                                </span>
                                Đăng nhập với Google
                            </div>
                        </div> --}}
                        

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
                                <div class="input-group form-html">
                                    <span class="input-group-addon"><i class="fas fa-envelope fa-fw fa-md"></i></span>
                                    <input type="email" class="form-control" name="email" placeholder="Email" required="required" id="loginEmail">
                                    <div class="form-html-validate login_email"></div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group password-group form-html">
                                    <span class="input-group-addon"><i class="fas fa-lock fa-fw fa-md"></i></span>
                                    <input type="password" class="form-control" name="pass" placeholder="Mật khẩu" required="required" id="showMyPassword">
                                    <div class="show-password" onclick="showPassword()">
                                        <i class="fas fa-eye fa-fw fa-md" id="eye"></i>
                                        <!-- <i class="fas fa-eye-slash fa-fw fa-lg" style="display:none"></i> -->
                                    </div>
                                    <div class="form-html-validate login_password"></div>
                                </div>
                                <!-- <div><input type="checkbox" onclick="showPassword()"> Hiển thị mật khẩu</div> -->
                            </div>
                            {{-- <div class="form-group">
                                <input type="checkbox" name="remember"> Keep my logged in on this computer
                            </div> --}}
                            <div class="form-group">
                                <input type="button" class="btn btn-success btn-block btn-lg" value="Đăng nhập" onclick="loginAjax()">
                            </div>
                            <input id="resetFormsLogin" type="reset" value="Reset the form" style="display:none">
                        </form>
                        <div class="forgot-password">
                            {{-- <div>
                                <a href="#">Quên mật khẩu?</a>
                            </div> --}}
                        </div>
                        @if($_SERVER['SERVER_NAME'] === "courdemy.vn")
                        <hr>
                        @include('components.facebook-login')
                        @include('components.google-login')
                        @endif
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
                        <form action="/examples/actions/confirmation.php" method="post" autocomplete="off">
                            <div class="form-group"> 
                                <div class="input-group form-html">
                                    <span class="input-group-addon"><i class="fas fa-user fa-lock fa-fw fa-md"></i></span>
                                    <input type="text" class="form-control" name="name" placeholder="Tên của bạn" required="required">
                                    <div class="form-html-validate name"></div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group form-html">
                                    <span class="input-group-addon"><i class="fas fa-envelope fa-envelope fa-fw fa-md"></i></span>
                                    <input type="email" class="form-control" name="email" autocomplete="none" placeholder="Email" required="required">
                                    <div class="form-html-validate email"></div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group form-html">
                                    <span class="input-group-addon"><i class="fas fa-lock fa-fw fa-md"></i></span>
                                    <input type="password" class="form-control" name="pass" placeholder="Mật khẩu" required="required">
                                    <div class="form-html-validate password"></div>
                                </div>				
                            </div>
                            <div class="form-group">
                                <div class="input-group form-html">
                                    <span class="input-group-addon"><i class="fas fa-lock fa-fw fa-md"></i></span>
                                    <input type="password" class="form-control" name="confirmpass" placeholder="Nhập lại mật khẩu" required="required">
                                    <div class="form-html-validate confirmpassword"></div>
                                </div>				
                            </div>
                            {{-- <div class="terms-and-policy">
                                <label class="checkbox-inline"><input type="checkbox">You agree to our <a href="#">Terms of Use</a> and <a href="#">Privacy Policy</a>!</label>
                            </div> --}}
                            <div class="form-group">
                                <input type="button" class="btn btn-success btn-block btn-lg" value="Đăng ký" onclick="registerAjax()">
                            </div>
                            <input id="resetFormsSignup" type="reset" value="Reset the form" style="display:none">
                        </form>				
                    </div>
                    <div class="modal-footer">
                        <div class="link-to-sign-up">
                            <div>
                                Bạn đã có tài khoản? 
                                <span data-toggle="modal" data-target="#myModalLogin" data-dismiss="modal">
                                    <a href=""><b>Đăng nhập</b></a>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
    <script>
        var user_id = $('button[id=cartUserId]').attr('data-user-id')

        // $(window).scroll(function(event){
        //     if ($(this).scrollTop() > 0){
        //         $('.unica-home-menutop').addClass('fixed');
        //     } else {
        //         $('.unica-home-menutop').removeClass('fixed');
        //     }
        // });
        @if (Auth::check())
            @if (Auth::user()->isAdmin())
            localStorage.setItem('cart'+user_id, '[]')
            @endif
        @endif

        if( user_id == 0 ){
            if(localStorage.getItem('cart'+0) == null){
                localStorage.setItem('cart'+0, '[]')
            }
            var localStoreageCart = JSON.parse(localStorage.getItem('cart'+0))
            if(localStoreageCart.length >= 1){
                $('.unica-sl-cart').css('display', 'block')
            }else{
                $('.unica-sl-cart').css('display', 'none')
            }
        }else{
            if(localStorage.getItem('cart'+user_id) == null){
                localStorage.setItem('cart'+user_id, '[]')
            }
            
            // Move Cart NoLogin => Cart Login
            var loginCart = JSON.parse(localStorage.getItem('cart'+user_id))
            if( localStorage.getItem('cart'+0) != null ){
                var noLoginCart = JSON.parse(localStorage.getItem('cart'+0))
                noLoginCart.forEach(function(element) {
                    var check = true
                    loginCart.forEach(function(obj) {
                        if(element.id == obj.id){
                            check = false
                        }
                    })
                    if(check == true){
                        loginCart = loginCart.concat(element)
                    }
                })
                localStorage.setItem('cart'+0, '[]')
                localStorage.setItem('cart'+user_id, JSON.stringify(loginCart))
            }
            if(loginCart.length >= 1){
                $('.unica-sl-cart').css('display', 'block')
            }else{
                $('.unica-sl-cart').css('display', 'none')
            }
        }

        @if(Auth::check())
        $(document).ready( function () {

            function updateIndicator() {
                if(!navigator.onLine) { // true|false
                Swal.fire({
                    type: 'error',
                    text: "Vui lòng kiểm tra kết nối internet của bạn và thử lại.",
                }).then((result) => {
                    window.location.href = "/";
                })
                }
            }

            window.addEventListener('online',  updateIndicator);
            window.addEventListener('offline', updateIndicator);
            updateIndicator();

            $(".modal").attr('data-backdrop', 'static');
            $(".modal").attr('data-keyboard', false);

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
                    
                    $(".unica-sl-notify b").text(response.number_unread_emails)
                    
                    if(response.number_unread_emails >= 1){
                        // $(".unica-sl-notify").remove()
                        $('.unica-sl-notify').css('display', 'block' )
                        $('.unica-sl-notify').show()
                    }

                    if ( response.number_of_student >= 1 ){
                        $('.sl-notify-student').css('display', 'block' )
                        $(".sl-notify-student b").text(response.number_of_student)
                        
                        $('.sl-notify-student-only').css('display', 'block' )
                        $(".sl-notify-student-only b").text(response.number_of_student)
                    }
                    if ( response.number_of_teacher >= 1 ){
                        $('.sl-notify-teacher').css('display', 'block' )
                        $(".sl-notify-teacher b").text(response.number_of_teacher)
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

                if(localStorage.getItem('cart'+user_id) == null){
                    localStorage.setItem('cart'+user_id, '[]')
                }

                var localCart = []
                localCart = localStorage.getItem('cart'+user_id)
                number_items_in_cart = JSON.parse(localStorage.getItem('cart'+user_id))

                if(localCart != null){
                    $.each( number_items_in_cart, function(i, obj) {
                        if( $(this).attr("data-id") == obj.id ){
                            return false
                        }
                    })
                }

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

                if (localCart != null) {
                    var list_item = number_items_in_cart
                    addItem(list_item, item);
                    localStorage.setItem('cart'+user_id, JSON.stringify(list_item));                        
                }else{
                    var list_item = [];
                    addItem(list_item, item);
                    localStorage.setItem('cart'+user_id, JSON.stringify(list_item));                        
                }

                // var number_items_in_cart = JSON.parse(localStorage.getItem('cart'+user_id))
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
            
            if(localStorage.getItem('cart'+user_id) !== null){
                var number_items_in_cart = JSON.parse(localStorage.getItem('cart'+user_id))
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
                var list_course_bought = "";
                var count_course_bought = 0;
                
                $.each( number_items_in_cart, function(i, obj) {                
                    
                    $('.img-mask button[data-id='+obj.id+']').remove();
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
                            // list_course_bought += '<li><b>' + obj.name + '</b></li>'
                            if(count_course_bought == 0)
                            list_course_bought += '"' + obj.name + '"'
                            else
                            list_course_bought += ', "' + obj.name + '"'
                            count_course_bought++;
                        }else{
                           
                        }
                    });

                    @if ( \Request::is('cart/payment/method-selector') )
                    if(list_course_bought.length > 0){
                        list_course_bought.trimEnd(",");
                        Swal.fire({
                            type: 'warning',
                            html: 'Khóa học <b>' + list_course_bought + '</b> đã được bạn mua rồi!'
                        }).then(result => {
                            window.location.reload()
                        })
                    }
                    @endif
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
                // alert(total_price)
                // alert(total_real_price)
                
                if(total_price == total_real_price){
                    $('.current-price span').text(number_format(total_price, 0, '.', '.') + " ₫")
                    $('.initial-price span').remove()
                    $('.percent-off span').remove()
                }else{
                    $('.current-price span').text(number_format(total_price, 0, '.', '.') + " ₫")
                    $('.initial-price span').text(number_format(total_real_price, 0, '.', '.') + " ₫");
                    $('.percent-off span').text("Tiết kiệm " + Math.floor(100-(total_price/total_real_price)*100) + "%");
                }
                // $('.unica-sl-cart').get(0).css('display', 'block' )

                if(number_items_in_cart.length < 1){
                    $(".cart-page-empty").addClass('active')
                    $(".cart-page-content").removeClass('active')
                    // $('.unica-sl-cart').remove()
                    $('.unica-sl-cart').css('display', 'none' )
                    $('.cart-page-title.container').hide()
                }else{

                }

                    localStorage.setItem('cart'+user_id,JSON.stringify(number_items_in_cart))

                $('.number-in-cart').text(number_items_in_cart.length);
            }else{
                $('.number-in-cart').text("0");
                $('.unica-sl-cart').css('display', 'none')      
            }

            // Check Course of Teacher 
            if(localStorage.getItem('cart'+user_id) != null){
            var number_items_in_cart = JSON.parse(localStorage.getItem('cart'+user_id))

            $.each( number_items_in_cart, function(i, obj) {
                $('.teacher-course button[id=addCart'+obj.id+']').html('<b>ĐÃ THÊM VÀO GIỎ HÀNG</b>').attr('disabled', true)
            });
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

        // $('#myModalLogin input').click(function(){
        //     $(this).css('z-index', 5)
        //     $('.show-password').css('z-index', 6)
        // })
        function loginAjax(){
            var email = $('#myModalLogin input[name=email]').val();
            email = email.trim();
            var password = $('#myModalLogin input[name=pass]').val();
            var remember = $('#myModalLogin input[name=remember]').prop('checked');
            var data = {
                login_email:email,
                login_password: password,
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
                        location.reload()
                    }else{
                        alertValidate(response.message, 'login_password')
                    }
                },
                error: function (error) {
                    var obj_errors = error.responseJSON.errors;
                    $('.form-html-validate').css('display', 'block')
                    $('.form-html-validate').html('')
                    $.each(obj_errors, function( index, value ) {
                        var content = '<i class="fas fa-exclamation fa-fw"></i><div class="hover-alert">'+ value +'</div>'
                        $('.form-html-validate.' + index).html(content);
                    })
                    $('.form-html .form-html-validate i').on('click',function(e){ e.stopPropagation() })
                }
            });

            return false;
        } 
        $('#myModalRegister').on('shown.bs.modal', function (e) {
            $("input[type=email]").val('');
            $("input[type=password]").val('')
        })
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
                    $('.form-html-validate').css('display', 'block')
                    $('.form-html-validate').html('')
                    $.each(obj_errors, function( index, value ) {
                        var content = '<i class="fas fa-exclamation fa-fw"></i><div class="hover-alert">'+ value +'</div>'
                        $('.form-html-validate.' + index).html(content);
                    })
                    $('.form-html .form-html-validate i').on('click',function(e){ e.stopPropagation() })
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
        
        $(document).ready(function(){
            Swal.update({
                allowOutsideClick: false,
                allowEscapeKey: false
            })	
            Swal.mixin({
                allowOutsideClick: false,
                allowEscapeKey: false
            })
        })

    </script>
    <script>
    
    $( document ).ready(function() {
        if(document.body.scrollHeight <= 1080){
            var x = document.body.scrollHeight;
            var y = $('header').height();
            var z = $('footer').height();
            x=x-y-z;
            // document.getElementById("min-height").style.minHeight = x;
            $('#min-height').css('minHeight',x);
        }

        $('input[type=password]').keydown(function(e) {
            if( e.keyCode == 32 ){
                return false;
            }
        })
    });

    /* Alert Validate Trinhnk */
    function alertValidate(message, element){
        $('.form-html-validate').css('display', 'block')
        var content = '<i class="fas fa-exclamation fa-fw"></i><div class="hover-alert">'+ message +'</div>'
        $('.form-html-validate.' + element).html('');
        $('.form-html-validate.' + element).html(content);
        $('.form-html .form-html-validate i').on('click',function(e){ e.stopPropagation() })
    }
    $('.form-html').click(function(){
        $(this).children('.form-html-validate').css('display', 'none')
    })

    // Show/Hide Header when scroll 
    var prevScrollpos = window.pageYOffset;
    window.onscroll = function() {
        if ($(window).scrollTop() > 150) {
            var currentScrollPos = window.pageYOffset;
            if (prevScrollpos > currentScrollPos) {
                document.getElementById("showHideHeader").style.top = "0";
            } else {
                document.getElementById("showHideHeader").style.top = "-101px";
            }
            prevScrollpos = currentScrollPos
        }
    }
</script>

@if (!Auth::check())
    @if($_SERVER['SERVER_NAME'] === "courdemy.vn")
    <script>
        $('.buttonFacebookLogin').click(function(){
            checkLoginState()
        })
        function statusChangeCallback(response) {  // Called with the results from FB.getLoginStatus().
            // console.log('statusChangeCallback');
            // console.log(response);                   // The current login status of the person.
            if (response.status === 'connected') {   // Logged into your webpage and Facebook.
                testAPI();
            } else {                                 // Not logged into your webpage or we are unable to tell.
                // document.getElementById('status').innerHTML = 'Bạn chưa đăng nhập Facebook!';
                FB.login(function(response){
                    // handle the response 
                    checkLoginState()
                }, {scope: 'email'});
            }
        }

        function checkLoginState() {               // Called when a person is finished with the Login Button.
            FB.getLoginStatus(function(response) {   // See the onlogin handler
                statusChangeCallback(response);
                if (response.status === 'connected') {
                    console.log(response.authResponse);
                }
            });
        }


        window.fbAsyncInit = function() {
            FB.init({
                appId      : '426138308059078',
                cookie     : true,
                xfbml      : true,
                version    : '5.0'
            });
            
            FB.AppEvents.logPageView();   
            
        };

        (function(d, s, id){
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) {return;}
            js = d.createElement(s); js.id = id;
            js.src = "https://connect.facebook.net/en_US/sdk.js";
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));

        // window.fbAsyncInit = function() {
        //     FB.init({
        //         appId      : '2474435149283816',
        //         cookie     : true,                     // Enable cookies to allow the server to access the session.
        //         xfbml      : true,                     // Parse social plugins on this webpage.
        //         version    : '4.0'           // Use this Graph API version for this call.
        //     });

        //     FB.getLoginStatus(function(response) {   // Called after the JS SDK has been initialized.
        //         statusChangeCallback(response);        // Returns the login status.
        //     });
        // }

        // (function(d, s, id) {                      // Load the SDK asynchronously
        //     var js, fjs = d.getElementsByTagName(s)[0];
        //     if (d.getElementById(id)) return;
        //     js = d.createElement(s); js.id = id;
        //     js.src = "https://connect.facebook.net/en_US/sdk.js";
        //     fjs.parentNode.insertBefore(js, fjs);
        // }(document, 'script', 'facebook-jssdk'));

        function testAPI() {                      // Testing Graph API after login.  See statusChangeCallback() for when this call is made.
            // console.log('Welcome!  Fetching your information.... ');
            FB.api('/me',
                'GET',
                {"fields":"id,name,email"},
                function(response) {
                console.log(response)
                var facebook_id = response.id;
                var facebook_name = response.name;
                var facebook_email = response.email;
                @if (Request::is('/teacher/*'))
                course_id = course_of_teacher_id;
                @endif
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN'    : $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: "/facebookLogin",
                    data: {
                        name        : facebook_name,
                        facebook_id : facebook_id,
                        email       : facebook_email,
                        course_id   : course_id,
                    },
                    method: "POST",
                    dataType:'json',
                    beforeSend: function(r, a){
                        $('.alert-errors').addClass('d-none');
                    },
                    success: function (response) {
                        if(response.status == 200){
                            if (response.role){
                                $('#modalLoginCourseDetail').modal('toggle');
                                if ( response.role == 1 ){
                                    Swal.fire({
                                        type: 'warning',
                                        html: 'Chú là admin nên không thể mua khóa học. Chú hiểu chứ?',
                                    }).then((result)=>{
                                        window.location.reload()
                                    })
                                }else if ( response.role == 2 ){
                                    Swal.fire({
                                        type: 'warning',
                                        html: 'Khóa học này là của bạn.',
                                    }).then((result)=>{
                                        window.location.reload()
                                    })
                                }else if ( response.role ==3 ){
                                    Swal.fire({
                                        type: 'warning',
                                        html: 'Bạn đã mua khóa học này.',
                                    }).then((result)=>{
                                        window.location.reload()
                                    })
                                }else{
                                    window.location.href = ("/cart/payment/method-selector")
                                }
                            }else{
                                Swal.fire({
                                    type: 'success',
                                    text: 'Đăng nhập thành công!'
                                }).then(result => {
                                    location.reload()
                                })
                            }
                        } else {
                            if(response.status == 201){
                                Swal.fire({
                                    type: 'success',
                                    text: 'Đăng ký tài khoản thành công!'
                                }).then(result => {
                                    location.reload()
                                })
                            }else{
                                Swal.fire({
                                    type: 'warning',
                                    text: 'Đăng nhập thất bại'
                                })
                            }
                        }
                    },
                    error: function (error) {
                        var obj_errors = error;
                        console.log(obj_errors)
                        var txt_errors = 'Lỗi';
                        Swal.fire({
                            type: 'warning',
                            html: txt_errors,
                        })
                    }
                });
            });
        }

        // window.fbAsyncInit = function() {
        //   FB.init({
        //     appId      : '2474435149283816',
        //     cookie     : true,
        //     xfbml      : true,
        //     version    : '5.0'
        //   });
        //   FB.AppEvents.logPageView();   
        // };
        
        // (function(d, s, id){
        //     var js, fjs = d.getElementsByTagName(s)[0];
        //     if (d.getElementById(id)) {return;}
        //     js = d.createElement(s); js.id = id;
        //     js.src = "https://connect.facebook.net/en_US/sdk.js";
        //     fjs.parentNode.insertBefore(js, fjs);
        // }(document, 'script', 'facebook-jssdk'));


        // FB.getLoginStatus(function(response) {
        //     statusChangeCallback(response);
        // });

        // function checkLoginState() {
        //     FB.getLoginStatus(function(response) {
        //         statusChangeCallback(response);
        //     });
        // }
    </script>
    @endif
@endif

{{-- Là admin thì ẩn button mua --}}
@if (Auth::check())
    @if (Auth::user()->isAdmin())
    <style>
    .box-course>a .img-course:hover .img-mask{
        display: none;
    }
    </style>
    @endif
@endif

    <script>
        $(document).ready(function(){
            var mainmenugroupWidth = $('.main-menu-group').width();
            var count = 0;
            
            $.each($('.main-menu-item'), function( index, value ) {
                count++;
                mainmenugroupWidth -= $(value).width();
                if(index == 7 && $(value).width() < 70){
                    mainmenugroupWidth -= 5;
                }
            });


            mainmenugroupMargin = mainmenugroupWidth / (count - 1);
        
            $('.main-menu-item').css('margin-right', mainmenugroupMargin - 2);
            $("ul.main-menu-group li:nth-child("+ (count - 1) +")").css('margin-right', '0');
            $('.main-menu-item:last-child').css('margin-right', -1);

            var menuthem = $('#addMenu').width() - 250;
            $('#menuThem').css('left', menuthem);
        })
    </script>
</body>
</html>
