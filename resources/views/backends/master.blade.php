<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Courdemy Admin</title>
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <!-- Bootstrap 3.3.7 -->
        <link rel="stylesheet" href="{{ asset('backend/template/bower_components/bootstrap/dist/css/bootstrap.min.css') }}">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="{{ asset('backend/template/bower_components/font-awesome/css/font-awesome.min.css') }}">
        <!-- bootstrap datepicker -->
        <link rel="stylesheet" href="{{asset('backend/template/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css')}}">
        <!-- Ionicons -->
        <link rel="stylesheet" href="{{ asset('backend/template/bower_components/Ionicons/css/ionicons.min.css') }}">
        <!-- Theme style -->
        <link rel="stylesheet" href="{{ asset('backend/template/dist/css/AdminLTE.min.css') }}">

        <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.5/cropper.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.5/cropper.css" type="text/css"/>
        <!-- AdminLTE Skins. Choose a skin from the css/skins
            folder instead of downloading all of them to reduce the load. -->
        <link rel="stylesheet" href="{{ asset('backend/template/dist/css/skins/_all-skins.min.css') }}">
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
        <!-- Google Font -->
        <link rel="stylesheet" type="text/css" href="{{ asset('backend/css/jquery.toastmessage.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('backend/css/ajsr-confirm.css') }}">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
        <!-- jQuery 3 -->
        <script src="{{ asset('backend/template/bower_components/jquery/dist/jquery.min.js') }}"></script>
        <script src="{{ asset('backend/js/jquery.easing.min.js') }}"></script>
        <script src="{{ asset('backend/js/priority.js') }}"></script>
        <script src="{{ asset('frontend/js/sweetalert2.min.js') }}"></script>
        <link rel="stylesheet" type="text/css" href="{{ asset('frontend/css/sweetalert2.min.css') }}">

        {{-- CKEditor 4 --}}
        <script src="{{asset("backend/template/bower_components/ckeditor/ckeditor.js")}}"></script>

        <script type="text/javascript">
            $.ajaxSetup({
              headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              }
            });
        </script>
    </head>
    <body class="hold-transition skin-blue sidebar-mini">
        <div class="ajax_waiting"></div>
        <div class="wrapper">
            <header class="main-header">
                <!-- Logo -->
                <a href="{{ url('/admincp') }}" class="logo">
                    <!-- mini logo for sidebar mini 50x50 pixels -->
                    <span class="logo-mini"><b>TB</b></span>
                    <!-- logo for regular state and mobile devices -->
                    <span class="logo-lg"><b>Administrator</b></span>
                </a>
                <!-- Header Navbar: style can be found in header.less -->
                <nav class="navbar navbar-static-top">
                    <!-- Sidebar toggle button-->
                    <a href="javascript:void(0)" class="sidebar-toggle" data-toggle="push-menu" role="button">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    </a>
                    <div class="navbar-custom-menu">
                        <ul class="nav navbar-nav">
                            <li class="dropdown user user-menu">
                                <a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown">
                                <img src="{{ asset('backend/template/dist/img/user2-160x160.jpg') }}" class="user-image" alt="User Image">
                                <span class="hidden-xs">{{ Auth::user()->name }}</span>
                                </a>
                                <ul class="dropdown-menu">
                                    <!-- User image -->
                                    <li class="user-header">
                                        <img src="{{ asset('backend/template/dist/img/user2-160x160.jpg') }}" class="img-minus" alt="User Image">
                                        <p>
                                            {{ Auth::user()->name }} - Web Developer
                                        </p>
                                    </li>
                                    <!-- Menu Footer-->
                                    <li class="user-footer">
                                        <!-- <div class="pull-left">
                                            <a href="javascript:void(0)" class="btn btn-default btn-flat">Profile</a>
                                        </div> -->
                                        <div class="pull-right">
                                            <a href="{{ route('logout-admin') }}" class="btn btn-default btn-flat">Sign out</a>
                                        </div>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </nav>
            </header>
            <!-- Left side column. contains the logo and sidebar -->
            <aside class="main-sidebar">
                <!-- sidebar: style can be found in sidebar.less -->
                <section class="sidebar">
                    <!-- Sidebar user panel -->
                    <div class="user-panel">
                        <div class="pull-left image">
                            <img src="{{ asset('backend/template/dist/img/user2-160x160.jpg') }}" class="img-circle" alt="User Image">
                        </div>
                        <div class="pull-left info">
                            <p>{{ Auth::user()->name }}</p>
                            <a href="javascript:void(0)"><i class="fa fa-circle text-success"></i> Trực tuyến</a>
                        </div>
                    </div>
                    <!-- sidebar menu: : style can be found in sidebar.less -->
                    <ul class="sidebar-menu" data-widget="tree">
                        <li>
                            <a href="{{ url('/') }}">
                                <i class="fa fa-home"></i> <span>Trở lại trang chính</span>
                            </a>
                        </li>
                        <li class="treeview @if ( Request::is('admincp/feature*')) active @endif">
                            <a href="javascript:void(0)">
                                <i class="fa fa-star"></i>
                                <span>Cài đặt trang chủ</span>
                                <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">
                                @if (Helper::checkPermissions('users.list', $list_roles))
                                    <li class="@if ( Request::is('admincp/feature-course*') ) active @endif">
                                        <a href="{{ url('/') }}/admincp/feature-course"><i class="fa fa-minus"></i>Khóa học nổi bật</a>
                                    </li>
                                    <li class="@if ( Request::is('admincp/feature-teacher*') ) active @endif">
                                        <a href="{{ url('/') }}/admincp/feature-teacher"><i class="fa fa-minus"></i>Giảng viên tiêu biểu</a>
                                    </li>
                                    <li class="@if ( Request::is('admincp/featured-category*') ) active @endif">
                                        <a href="{{ url('/') }}/admincp/featured-category"><i class="fa fa-minus"></i>Danh mục tiêu biểu</a>
                                    </li>
                                @endif
                            </ul>
                        </li>
                        <li class="treeview @if ( Request::is('admincp/users') || Request::is('admincp/permissions*') || Request::is('admincp/roles*') ) active @endif">
                            <a href="javascript:void(0)">
                                <i class="fa fa-user-md"></i>
                                <span>Tài khoản</span>
                                <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">
                                @if (Helper::checkPermissions('users.list', $list_roles))
                                    <li class="@if ( Request::is('admincp/users') ) active @endif">
                                        <a href="{{ url('/') }}/admincp/users"><i class="fa fa-minus"></i> Danh sách</a>
                                    </li>
                                @endif


                                @if (Helper::checkPermissions('users.list_roles', $list_roles))
                                <li class="@if ( Request::is('admincp/roles*') ) active @endif">
                                    <a href="{{ url('/') }}/admincp/roles"><i class="fa fa-minus"></i> Vai trò</a>
                                </li>
                                @endif

                                @if (Helper::checkPermissions('users.list_permissions', $list_roles))
                                    <li class="@if ( Request::is('admincp/permissions*') ) active @endif">
                                        <a href="{{ url('/') }}/admincp/permissions"><i class="fa fa-minus"></i> Phân quyền</a>
                                    </li>
                                @endif
                            </ul>
                        </li>

                        <li class="treeview @if ( Request::is('admincp/users/email*')) active @endif">
                            <a href="javascript:void(0)">
                                <i class="fa fa-user-md"></i>
                                <span>Thông báo</span>
                                <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">
                                @if (Helper::checkPermissions('users.list', $list_roles))
                                    <li class="@if ( Request::is('admincp/users/email*') ) active @endif">
                                        <a href="{{ url('/') }}/admincp/users/email"><i class="fa fa-minus"></i> Emails</a>
                                    </li>
                                @endif
                            </ul>
                        </li>

                        <li class="treeview @if ( Request::is('admincp/teachers*') ) active @endif">
                            <a href="javascript:void(0)">
                                <i class="fa fa-user-md"></i>
                                <span>Phê duyệt</span>
                                <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">
                                @if (Helper::checkPermissions('users.list', $list_roles))
                                    <li class="@if ( Request::is('admincp/teachers*') )active @endif">
                                        <a href="{{ url('/') }}/admincp/teachers"><i class="fa fa-minus"></i> Yêu cầu làm giảng viên</a>
                                    </li>
                                    <li class="@if ( Request::is('admincp/courses') )active @endif">
                                        <a href="{{ url('/') }}/admincp/courses"><i class="fa fa-minus"></i> Yêu cầu duyệt khóa học</a>
                                    </li>
                                    <li class="@if ( Request::is('admincp/courses/request-edit*') )active @endif">
                                        <a href="{{ url('/') }}/admincp/courses/request-edit"><i class="fa fa-minus"></i> Yêu cầu sửa khóa học</a>
                                    </li>
                                    {{-- <li class="@if ( Request::is('admincp/verify-video*') ) active @endif">
                                        <a href="{{ url('/') }}/admincp/verify-video"><i class="fa fa-minus"></i> Yêu cầu duyệt bài giảng</a>
                                    </li> --}}
                                    {{-- <li class="@if ( Request::is('admincp/videos*') ) active @endif">
                                        <a href="{{ url('/') }}/admincp/videos"><i class="fa fa-minus"></i> Yêu cầu duyệt bài giảng</a>
                                    </li> --}}
                                    {{-- <li class="@if ( Request::is('admincp/request-delete-videos*') ) active @endif">
                                        <a href="{{ url('/') }}/admincp/request-delete-videos"><i class="fa fa-minus"></i> Yêu cầu xóa bài giảng</a>
                                    </li> --}}
                                    {{-- <li class="@if ( Request::is('admincp/request-edit-videos*') ) active @endif">
                                        <a href="{{ url('/') }}/admincp/request-edit-videos"><i class="fa fa-minus"></i> Yêu cầu sửa bài giảng</a>
                                    </li> --}}
                                @endif
                            </ul>
                        </li>
                        <li class="@if ( Request::is('admincp/categories*') ) active @endif">
                            <a href="{{ url('/') }}/admincp/categories"><i class="fa fa-briefcase"></i>
                                <span>Danh mục</span>
                                <span class="pull-right-container">
                            </a>
                        </li>
                        <li class="treeview @if ( Request::is('admincp/courses*') ) active @endif">
                            <a href="javascript:void(0)">
                                <i class="fa fa-star"></i>
                                <span>Khóa học</span>
                                <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">
                                @if (Helper::checkPermissions('users.list', $list_roles))
                                    <li class="@if ( Request::is('admincp/courses') ) active @endif">
                                        <a href="{{ url('/') }}/admincp/courses"><i class="fa fa-minus"></i>Tất cả</a>
                                    </li>
                                    <li class="@if ( Request::is('admincp/courses/accepted-courses') ) active @endif">
                                        <a href="{{ url('/') }}/admincp/courses/accepted-courses"><i class="fa fa-minus"></i>Đã duyệt</a>
                                    </li>
                                    <li class="@if ( Request::is('admincp/courses/request-accept') ) active @endif">
                                        <a href="{{ url('/') }}/admincp/courses/request-accept"><i class="fa fa-minus"></i>Yêu cầu duyệt</a>
                                    </li>
                                    <li class="@if ( Request::is('admincp/courses/request-edit') ) active @endif">
                                        <a href="{{ url('/') }}/admincp/courses/request-edit"><i class="fa fa-minus"></i>Yêu cầu sửa</a>
                                    </li>
                                @endif
                            </ul>
                        </li>
                        <li class="treeview @if ( Request::is('admincp/videos*') || Request::is('admincp/request-accept-videos*') || Request::is('admincp/request-edit-videos*') || Request::is('admincp/request-delete-videos*') || Request::is('admincp/video-in-trash*') ) active @endif">
                            <a href="javascript:void(0)">
                                <i class="fa fa-star"></i>
                                <span>Bài giảng</span>
                                <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">
                                @if (Helper::checkPermissions('users.list', $list_roles))
                                    <li class="@if ( Request::is('admincp/videos') ) active @endif">
                                        <a href="{{ url('/') }}/admincp/videos"><i class="fa fa-minus"></i>Tất cả</a>
                                    </li>
                                    <li class="@if ( Request::is('admincp/request-accept-videos') ) active @endif">
                                        <a href="{{ url('/') }}/admincp/request-accept-videos"><i class="fa fa-minus"></i>Yêu cầu duyệt</a>
                                    </li>
                                    <li class="@if ( Request::is('admincp/request-edit-videos') ) active @endif">
                                        <a href="{{ url('/') }}/admincp/request-edit-videos"><i class="fa fa-minus"></i>Yêu cầu sửa</a>
                                    </li>
                                    <li class="@if ( Request::is('admincp/request-delete-videos') ) active @endif">
                                        <a href="{{ url('/') }}/admincp/request-delete-videos"><i class="fa fa-minus"></i>Yêu cầu xóa</a>
                                    </li>
                                    <li class="@if ( Request::is('admincp/video-in-trash') ) active @endif">
                                        <a href="{{ url('/') }}/admincp/video-in-trash"><i class="fa fa-minus"></i>Thùng rác</a>
                                    </li>
                                @endif
                            </ul>
                        </li>
                        <li class="treeview @if ( Request::is('admincp/comment*')) active @endif">
                            <a href="javascript:void(0)">
                                <i class="fa fa-star"></i>
                                <span>Phản hồi</span>
                                <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">
                                @if (Helper::checkPermissions('users.list', $list_roles))
                                    <li class="@if ( Request::is('admincp/comment/comment-course*') ) active @endif">
                                        <a href="{{ url('/') }}/admincp/comment/comment-course"><i class="fa fa-minus"></i>Phản hồi khóa học</a>
                                    </li>
                                    <li class="@if ( Request::is('admincp/comment/comment-report*') ) active @endif">
                                        <a href="{{ url('/') }}/admincp/comment/comment-report"><i class="fa fa-minus"></i>Bình luận vi phạm</a>
                                    </li>
                                    <li class="@if ( Request::is('admincp/comment/comment-video*') ) active @endif">
                                        <a href="{{ url('/') }}/admincp/comment/comment-video"><i class="fa fa-minus"></i>Phản hồi bài giảng</a>
                                    </li>
                                @endif
                            </ul>
                        </li>
                        <li class="treeview @if ( Request::is('admincp/gifts*') || Request::is('admincp/create-coupon*') ) active @endif">
                            <a href="javascript:void(0)">
                                <i class="fa fa-star"></i>
                                <span>Khuyến mãi</span>
                                <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">
                                @if (Helper::checkPermissions('users.list', $list_roles))
                                    <li class="@if ( Request::is('admincp/create-coupon*') ) active @endif">
                                        <a href="{{ url('/') }}/admincp/create-coupon"><i class="fa fa-minus"></i>Mã giảm giá</a>
                                    </li>
                                    <li class="@if ( Request::is('admincp/gifts*') ) active @endif">
                                        <a href="{{ url('/') }}/admincp/gifts"><i class="fa fa-minus"></i>Tặng quà</a>
                                    </li>
                                @endif
                            </ul>
                        </li>
                    </ul>
                </section>
                <!-- /.sidebar -->
            </aside>
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper" style="padding-bottom: 1px;">
                @yield('content')
            </div>
            <!-- /.content-wrapper -->
            <footer class="main-footer">
                <div class="pull-right hidden-xs">
                    <b>Version</b> 2.4.0
                </div>
                <strong>Copyright &copy; 2018 <a href="javascript:void(0)">Tran Ba</a>.</strong> All rights
                reserved.
            </footer>

            <!-- /.control-sidebar -->
            <!-- Add the sidebar's background. This div must be placed
                immediately after the control sidebar -->
            <div class="control-sidebar-bg"></div>
        </div>
        <!-- ./wrapper -->
        <!-- Bootstrap 3.3.7 -->
        <script src="{{ asset('backend/template/bower_components/bootstrap/dist/js/bootstrap.min.js') }}"></script>
        <!-- FastClick -->
        <script src="{{ asset('backend/template/bower_components/fastclick/lib/fastclick.js') }}"></script>
        <!-- AdminLTE App -->
        <script src="{{ asset('backend/template/dist/js/adminlte.min.js') }}"></script>
        <!-- AdminLTE for demo purposes -->
        <script src="{{ asset('backend/template/dist/js/demo.js') }}"></script>
        <script src="{{ asset('backend/js/ajsr-jq-confirm.min.js') }}"></script>
        <script src="{{ asset('backend/js/jquery.toastmessage.js') }}"></script>
        <script src="{{ asset('backend/js/script.js') }}"></script>
        <script type="text/javascript">
            var baseURL="<?php echo URL::to('/'); ?>";
            $(document).ready(function(){
                $(document).ajaxStart(function(){
                    // alert(1)
                    $(".ajax_waiting").addClass("loading")
                });

                $(document).ajaxComplete(function(){
                    $(".ajax_waiting").removeClass("loading")
                });
            })
        </script>
        <link rel="stylesheet" type="text/css" href="{{ asset('backend/css/style.css') }}">
        <style type="text/css">
        .sidebar-mini:not(.sidebar-mini-expand-feature).sidebar-collapse .sidebar-menu>li:hover>a>span:not(.pull-right), .sidebar-mini:not(.sidebar-mini-expand-feature).sidebar-collapse .sidebar-menu>li:hover>.treeview-menu {
            width:240px;
        }
        .sidebar-mini:not(.sidebar-mini-expand-feature).sidebar-collapse .sidebar-menu>li:hover>a>.pull-right-container {
            position: relative !important;
            float: right;
            width: auto !important;
            left: 240px !important;
            top: -22px !important;
            z-index: 900;
        }
        </style>
        <script>
            $(document).ready(function(){

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
                // $('.modal').modal({backdrop: "static"});
                $('.modal').attr('data-backdrop', 'static');
            })
        </script>
        <script> //fix ckeditor in bootstrap modal
        $.fn.modal.Constructor.prototype.enforceFocus = function () {
            var $modalElement = this.$element;
            $(document).on('focusin.modal', function (e) {
                var $parent = $(e.target.parentNode);
                if ($modalElement[0] !== e.target && !$modalElement.has(e.target).length
                    // add whatever conditions you need here:
                    &&
                    !$parent.hasClass('cke_dialog_ui_input_select') && !$parent.hasClass('cke_dialog_ui_input_text')) {
                    $modalElement.focus()
                }
            })
        };

        </script>
    </body>

</html>
