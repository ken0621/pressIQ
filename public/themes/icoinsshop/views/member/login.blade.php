@extends("layout")
@section("content")
<div id="home" class="slider-wrapper" style="background-image: url('/themes/{{ $shop_theme }}/img/slider-img.jpg')">
	<div style="padding: 100px 0 50px 0;">
		<div class="container">
			<input type="hidden" id="_token" value="{{csrf_token()}}">
			<div class="register">
				{{-- <table>
					<tbody>
						<tr>
							<td class="c1">
								<div class="register-side">
									<img src="/themes/{{ $shop_theme }}/img/logo-2.png">
								</div>
							</td>
							<td class="c2">
								@include("member2.include_login")
							</td>
						</tr>
					</tbody>
				</table> --}}
				<div class="logo-holder">
					<img src="/themes/{{ $shop_theme }}/img/logo-2.png" alt="">
				</div>		
				<div class="register-form">					
					<form class="autoform" method="post">
						<div class="form-group">
							<div class="form-input">
								<div class="register-label">EMAIL</div>
								<input class="form-control input-sm" type="email" name="email" placeholder="Email / Username">
							</div>
						</div>
						<div class="form-group">
							<div class="form-input">
								<div class="register-label">PASSWORD</div>
								<input class="form-control input-sm" type="password" name="password" placeholder="Password">
							</div>
						</div>
					</form>
					<div class="button-container">
						<button class="btn-login">LOGIN</button>
					</div>
				</div>
			</div>
			<div class="create-account">
				<span>Dont have an account yet?</span><span><a href="/members/register">Register Here</a></span>
			</div>
		</div>
	</div>
</div>
@endsection
@section("script")
<script type="text/javascript" src="/assets/member/js/google_script/google_script_auth.js"></script>
<script>startApp();</script>
<script src='https://www.google.com/recaptcha/api.js'></script>
@endsection
@section("css")
<link rel="stylesheet" type="text/css" href="/themes/{{ $shop_theme }}/css/member_login.css">
@endsection