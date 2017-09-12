@extends("layout")
@section("content")
<div class="container">
	<div class="register">
		<table>
			<tbody>
				<tr>
					<td class="c1">
						<div class="register-side">
							<img src="/themes/{{ $shop_theme }}/img/login-bg.jpg">
						</div>
					</td>
					<td class="c2">
						<div class="register-form">
							<div class="text-right social-button">
								<div class="holder">
									<div class="img">
										<img src="/themes/{{ $shop_theme }}/img/fb.png">
									</div>
									<div class="name">Sign Up With Facebook</div>
								</div>
								<div class="holder">
									<div class="img">
										<img src="/themes/{{ $shop_theme }}/img/google.png">
									</div>
									<div class="name">Sign Up With Google</div>
								</div>
							</div>

							@if (session("error"))
							    <div class="alert alert-danger">
							    	{!! session("error") !!}
							    </div>
							@endif

							@if ($errors->any())
							    <div class="alert alert-danger">
							        <ul>
							            @foreach ($errors->all() as $error)
							                <li>{{ $error }}</li>
							            @endforeach
							        </ul>
							    </div>
							@endif

							<form method="post">
								{{ csrf_field() }}
								<div class="form-group">
									<div class="register-label">EMAIL</div>
									<div class="form-input">
										<input class="form-control input-sm" type="email" name="email" value="">
									</div>
								</div>
								<div class="form-group">
									<div class="register-label">PASSWORD</div>
									<div class="form-input">
										<input class="form-control input-sm" type="password" name="password" value="">
									</div>
								</div>
								<div class="form-group">
									<div class="choice">
										<div class="holder">
											<button class="btn btn-brown">Login</button>
										</div>
										<div class="holder"><span class="or">OR</span></div>
										<div class="holder"><a class="login-href" href="javascript:">Create an Account</a></div>
									</div>
								</div>
							</form>

							<div class="form-group text-center">
								<div class="forgot" style="color: #808080; font-weight: 600; font-size: 11px;">Forgot Password? <a style="color: #4d575e;" href="javascript:">Click Here</a></div>
							</div>
						</div>
					</td>
				</tr>
			</tbody>
		</table>		
	</div>
</div>
@endsection
@section("script")

@endsection
@section("css")
<link rel="stylesheet" type="text/css" href="/themes/{{ $shop_theme }}/css/member_login.css">
@endsection