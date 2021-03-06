<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>@yield('title')</title>
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <!-- Bootstrap 3.3.7 -->
        <link rel="stylesheet" href="{{ asset('backend/template/bower_components/bootstrap/dist/css/bootstrap.min.css') }}">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="{{ asset('backend/template/bower_components/font-awesome/css/font-awesome.min.css') }}">
        <!-- Ionicons -->
        <link rel="stylesheet" href="{{ asset('backend/template/bower_components/Ionicons/css/ionicons.min.css') }}">
        <!-- Theme style -->
        <link rel="stylesheet" href="{{ asset('backend/template/dist/css/AdminLTE.min.css') }}">
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
        <link rel="stylesheet" type="text/css" href="{{ asset('backend/css/style.css') }}">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
        <!-- jQuery 3 -->
        <script src="{{ asset('backend/template/bower_components/jquery/dist/jquery.min.js') }}"></script>
        <script src="{{ asset('backend/js/jquery.easing.min.js') }}"></script>
        <script src="{{ asset('backend/js/priority.js') }}"></script>
        <script type="text/javascript">
            $.ajaxSetup({
              headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              }
            });
        </script>
    </head>
    <body class="hold-transition skin-blue sidebar-mini">
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
                    <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    </a>
                    <div class="navbar-custom-menu">
                        <ul class="nav navbar-nav">
                            <li class="dropdown user user-menu">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
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
                                        <div class="pull-left">
                                            <a href="#" class="btn btn-default btn-flat">Profile</a>
                                        </div>
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
                            <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
                        </div>
                    </div>
                    <!-- search form -->
                    <form action="#" method="get" class="sidebar-form">
                        <div class="input-group">
                            <input type="text" name="q" class="form-control" placeholder="Search...">
                            <span class="input-group-btn">
                            <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                            </button>
                            </span>
                        </div>
                    </form>
                    <!-- /.search form -->
                    <!-- sidebar menu: : style can be found in sidebar.less -->
                    <ul class="sidebar-menu" data-widget="tree">
                        <li class="@if ( Request::is('admincp') ) active @endif">
                            <a href="{{ url('/admincp') }}">
                            <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                            </a>
                        </li>
                 
                        <li class="treeview @if ( Request::is('admincp/users*') || Request::is('admincp/permissions*') || Request::is('admincp/roles*') ) active @endif">
                            <a href="#">
                                <i class="fa fa-user-md"></i>
                                <span>Tài khoản</span>
                                <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">
                                @if (Helper::checkPermissions('users.list', $list_roles)) 
                                    <li class="@if ( Request::is('admincp/users*') ) active @endif">
                                        <a href="{{ url('/') }}/admincp/users"><i class="fa fa-minus"></i> Danh sách</a>
                                    </li>
                                @endif
 
                                @if (Helper::checkPermissions('users.list_permissions', $list_roles)) 
                                    <li class="@if ( Request::is('admincp/permissions*') ) active @endif">
                                        <a href="{{ url('/') }}/admincp/permissions"><i class="fa fa-minus"></i> Phân quyền</a>
                                    </li>
                                @endif

                                @if (Helper::checkPermissions('users.list_roles', $list_roles)) 
                                    <li class="@if ( Request::is('admincp/roles*') ) active @endif">
                                        <a href="{{ url('/') }}/admincp/roles"><i class="fa fa-minus"></i> Vai trò</a>
                                    </li>
                                @endif

                            </ul>
                        </li>

                    </ul>
                </section>
                <!-- /.sidebar -->
            </aside>
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                @yield('content')
            </div>
            <!-- /.content-wrapper -->
            <footer class="main-footer">
                <div class="pull-right hidden-xs">
                    <b>Version</b> 2.4.0
                </div>
                <strong>Copyright &copy; 2018 <a href="#">Tran Ba</a>.</strong> All rights
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
        </script>
    </body>
</html>