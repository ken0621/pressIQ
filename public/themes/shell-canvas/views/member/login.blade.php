@extends("layout")
@section("content")
<div class="signin-wrapper" style="background-image: url('/themes/heartzone/img/login-banner.jpg');">
	<div class="top-banner">
		<div class="container">
			<div class="signin-container">
				<div class="title-container">
					USER LOGIN
				</div>
				<div class="icon-profile">
					<img src="/themes/{{ $shop_theme }}/img/profile-icon.png">
				</div>

				 @if (session("error"))
				    <div class="alert">
				    	{!! session("error") !!}
				    </div>
				@endif

				@if ($errors->any())
				    <div class="alert">
				        <ul>
				            @foreach ($errors->all() as $error)
				                <li>{{ $error }}</li>
				            @endforeach
				        </ul>
				    </div>
				@endif

				<form method="post">
					<input type="hidden" name="_token" value="{{ csrf_token() }}">
					<div class="form-group">
						<div class="input-group input-group-lg">
						  <span class="input-group-addon" id="sizing-addon1"><i class="fa fa-user" aria-hidden="true"></i></span>
						  <input type="email" name="email" value="" class="form-control" placeholder="Email / Username" aria-describedby="sizing-addon1">
						</div>
					</div>
					<div class="form-group">
						<div class="input-group input-group-lg">
						  <span class="input-group-addon" id="sizing-addon1"><i class="fa fa-lock" aria-hidden="true"></i></span>
						  <input type="password" name="password" value="" class="form-control" placeholder="Password" aria-describedby="sizing-addon1">
						</div>
					</div>
					<label onClick="location.href='/members/forgot-password'">Forgot Password? Click Here</label>
					<div class="btn-container">
						<button type="submit" class="btn-red">LOGIN</button>
					</div>
				</form>
			</div>
			<div class="border"></div>
			<div class="register">
				<span>Dont have an account yet?</span><span onClick="location.href='/members/register'">REGISTER HERE</span>
			</div>
		</div>
	</div>
</div>
@endsection
@section("script")
<script type="text/javascript" src="/assets/member/js/google_script/google_script_auth.js"></script>
<script>startApp();</script>
@endsection
@section("css")
<link rel="stylesheet" type="text/css" href="/themes/{{ $shop_theme }}/css/app.css">
@endsection