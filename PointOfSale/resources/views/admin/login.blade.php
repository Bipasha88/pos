@extends('admin.layouts._login')
@section('main-content')
<div class="login-box">
	<div class="login-logo">
		<a href="../../index2.html"><b>Admin</b>LTE</a>
	</div>
	<!-- /.login-logo -->
	<div class="card">
		<div class="card-body login-card-body">
			<p class="login-box-msg">Sign in to start your session</p>

			@if(count($errors) > 0 )
				<div class="alert alert-danger alert-dismissible fade show" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<ul class="p-0 m-0" style="list-style: none;">
					@foreach($errors->all() as $error)
					<li>{{$error}}</li>
					@endforeach
				</ul>
				</div>
			@endif

			<form action="{{ Route("loginpost") }}" method="post">
				@csrf
				<div class="input-group mb-3">
					<input type="email" class="form-control" placeholder="Email" name="email" value="{{old('email')}}" required>
					<div class="input-group-append">
						<div class="input-group-text">
							<span class="fas fa-envelope"></span>
						</div>
					</div>
				</div>
				<div class="input-group mb-3">
					<input type="password" class="form-control" placeholder="Password" name="password" required>
					<div class="input-group-append">
						<div class="input-group-text">
							<span class="fas fa-lock"></span>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-8">
						<div class="icheck-primary">
							<input type="checkbox" id="remember" name="remember" value="true" {{ old('remember') ? 'checked' : '' }}>
							<label for="remember">
								Remember Me
							</label>
						</div>
					</div>
					<!-- /.col -->
					<div class="col-4">
						<button type="submit" class="btn btn-primary btn-block">Sign In</button>
					</div>
					<!-- /.col -->
				</div>
			</form>
			<div class="social-auth-links text-center mb-3">
				<p>- OR -</p>
				<a href="#" class="btn btn-block btn-primary">
					<i class="fab fa-facebook mr-2"></i> Sign in using Facebook
				</a>
				<a href="#" class="btn btn-block btn-danger">
					<i class="fab fa-google-plus mr-2"></i> Sign in using Google+
				</a>
			</div>
			<!-- /.social-auth-links -->
			<p class="mb-1">
				<a href="forgot-password.html">I forgot my password</a>
			</p>
			<p class="mb-0">
				<a href="register.html" class="text-center">Register a new membership</a>
			</p>
		</div>
		<!-- /.login-card-body -->
	</div>
</div>
<!-- /.login-box -->
@endsection
