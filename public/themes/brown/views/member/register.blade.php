@extends("layout")
@section("content")
<div class="container">
	<div class="register">
		<table>
			<tbody>
				<tr>
					<td class="c1">
						<div class="register-side">
							<img src="/themes/{{ $shop_theme }}/img/register-bg.jpg">
						</div>
					</td>
					<td class="c2">
						<form method="post">
							{{ csrf_field() }}
							<div class="register-form">
								<div class="text-right social-button">
									<div class="holder">
										<div class="img">
											<img src="/themes/{{ $shop_theme }}/img/fb.png">
										</div>
										<div class="name">Sign Up With</br> Facebook</div>
									</div>
									<div class="holder">
										<div class="img">
											<img src="/themes/{{ $shop_theme }}/img/google.png">
										</div>
										<div class="name">Sign Up With</br> Google</div>
									</div>
								</div>
								<div class="form-group">
									<div class="register-label">GENDER</div>
									<div class="form-input">
										<label class="radio-inline"><input checked type="radio" name="optradio">MALE</label>
										<label class="radio-inline"><input type="radio" name="optradio">FEMALE</label>
									</div>
								</div>
								<div class="form-group">
									<div class="register-label">EMAIL</div>
									<div class="form-input">
										<input class="form-control input-sm" type="email" name="" value="">
									</div>
								</div>
								<div class="form-group">
									<div class="register-label">FULL NAME</div>
									<div class="form-input">
										<input class="form-control input-sm" type="text" name="first_name" placeholder="First Name" value="">
										<input class="form-control input-sm" type="text" name="middle_name" placeholder="Middle Name" value="">
										<input class="form-control input-sm" type="text" name="last_name" placeholder="Last Name" value="">
									</div>
								</div>
								<div class="form-group">
									<div class="register-label">BIRTHDAY</div>
									<div class="form-input">
										<div class="date-holder">
											<select class="form-control">
												<option>DD</option>
											</select>
										</div>
										<div class="date-holder">
											<select class="form-control">
												<option>MM</option>
											</select>
										</div>
										<div class="date-holder">
											<select class="form-control">
												<option>YYYY</option>
											</select>
										</div>
									</div>
								</div>
								<div class="form-group">
									<div class="register-label">PASSWORD</div>
									<div class="form-input">
										<input class="form-control input-sm" type="password" name="" value="English">
									</div>
								</div>
								<div class="form-group">
									<div class="register-label">REPEAT PASSWORD</div>
									<div class="form-input">
										<input class="form-control input-sm" type="password" name="" value="English">
									</div>
								</div>
								<div class="form-group clearfix" style="margin-top: 15px;">
									<div class="checkbox">
									  <label><input type="checkbox" value=""> I agree to the Brown <span>Terms of Use and Privacy Policy</span></label>
									</div>
								</div>
								<div class="form-group">
									<div class="choice">
										<div class="holder">
											<button class="btn btn-brown">Create an Account</button>
										</div>
										<div class="holder"><span class="or">OR</span></div>
										<div class="holder"><a class="login-href" href="javascript:">Login an Account</a></div>
									</div>
								</div>
							</div>
						</form>
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
<link rel="stylesheet" type="text/css" href="/themes/{{ $shop_theme }}/css/member_register.css">
@endsection