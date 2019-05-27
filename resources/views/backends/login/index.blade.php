<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>@yield('title')</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('backend/css/bootstrap.min.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('backend/css/font-awesome.min.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('backend/css/dataTables.bootstrap4.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('backend/css/sb-admin.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('backend/css/style.css') }}">
    </head>

    <body class="fixed-nav sticky-footer bg-dark">
		<div class="container">
			<div class="card card-login mx-auto mt-5">
			  <div class="card-header text-center"><h3>Login</h3></div>
			  <div class="card-body">
			    <form action="{{url('login-admin')}}" method="POST">
			      <div class="form-group">
			        <label>Email address</label>
			        <input class="form-control" name="email" type="email" aria-describedby="emailHelp" placeholder="Enter email" value="{{ old('email') }}">
					@if($errors->has('email'))
						<span class="alert-errors">{{$errors->first('email')}}</span>
					@endif
			      </div>
			      <div class="form-group">
			        <label>Password</label>
			        <input class="form-control" name="password" type="password" placeholder="Password" value="{{ old('password') }}">
					@if($errors->has('password'))
						<span class="alert-errors">{{$errors->first('password')}}</span>
					@endif
			      </div>
			      <div class="form-group">
<!-- 			        <div class="form-check">
			          <label class="form-check-label">
			            <input class="form-check-input" type="checkbox" name="remember"> Remember Password</label>
			        </div> -->
					@if($errors->has('errorlogin'))
						<span class="alert-errors">{{ $errors->first('errorlogin') }}</span>
					@endif
			      </div>
			      {!! csrf_field() !!}
			      <button type="submit" class="btn btn-primary btn-block">Login</button>
			    </form>
<!-- 			    <div class="text-center">
			      <a class="d-block small" href="javascript:void(0)">Forgot Password?</a>
			    </div> -->
			  </div>
			</div>
		</div>
        <!--  /.content-wrapper -->
        <script src="{{ asset('backend/js/jquery.min.js') }}"></script>
        <script src="{{ asset('backend/js/bootstrap.min.js') }}"></script>
        <script src="{{ asset('backend/js/jquery.easing.min') }}"></script>
        <script src="{{ asset('backend/js/Chart.min.js') }}"></script>
        <script src="{{ asset('backend/js/jquery.dataTables.js') }}"></script>
        <script src="{{ asset('backend/js/dataTables.bootstrap4.js') }}"></script>
        <script src="{{ asset('backend/js/sb-admin.min.js') }}"></script>
        <script src="{{ asset('backend/js/sb-admin-charts.min.js') }}"></script>
    </body>
</html>