@extends("layout")
@section("content")
<form method="post">
{{ csrf_field() }}
	<div class="container">
		<div class="register">
			<table>
				<tbody>
					<tr>
						<td colspan="2">
							<div class="register-header clearfix">
								<div class="left">
									<div class="title">Create new customer account</div>
								</div>
								<div class="right">
									<div class="or">
										<img src="/themes/{{ $shop_theme }}/img/or-2.png">
									</div>
									<div class="text-right social-button">
										<div class="holder fb">
											<div class="name"><i class="fa fa-facebook" aria-hidden="true"></i> Sign in with Facebook</div>
										</div>
										<div class="holder gp">
											<div class="name"><i class="fa fa-google-plus" aria-hidden="true"></i> Sign in with Google+</div>
										</div>
									</div>
								</div>
							</div>
						</td>
					</tr>
					<tr>
						<td class="c1">
							<div class="register-form">
								<div class="form-group">
									<div class="register-label">GENDER</div>
									<div class="form-input" style="margin-top: 10px; margin-left: 25px;">
										<label class="radio-inline"><input checked type="radio" name="gender" value="male">MALE</label>
										<label class="radio-inline"><input type="radio" name="gender" value="female">FEMALE</label>
									</div>
								</div>
								<div class="form-group">
									<div class="register-label">EMAIL</div>
									<div class="form-input">
										<input class="form-control input-sm" type="email" name="email" placeholder="Type Your Email Here" value="{{ old('email') }}">
									</div>
								</div>
								<div class="form-group">
									<div class="register-label">CUSTOMER NAME</div>
									<div class="form-input">
										<input class="form-control input-sm" type="text" name="first_name" placeholder="First Name" value="{{ old('first_name') }}">
									</div>
								</div>
								<div class="form-group">
									<div class="form-input">
										<input class="form-control input-sm" type="text" name="middle_name" placeholder="Middle Name" value="{{ old('middle_name') }}">
									</div>
								</div>
								<div class="form-group">
									<div class="form-input">
										<input class="form-control input-sm" type="text" name="last_name" placeholder="Last Name" value="{{ old('last_name') }}">
									</div>
								</div>
								<div class="form-group">
									<div class="register-label">BIRTHDAY</div>
									<div class="form-input">
										<div class="date-holder">
											<select name="b_month" class="form-control">
												@for($ctr = 1; $ctr <= 12; $ctr++)
												<option {{ old('b_month') == $ctr ? 'selected' : '' }} value="{{ $ctr }}">{{ date("F", strtotime($ctr . "/01/17")) }}</option>
												@endfor
											</select>
										</div>
										<div class="date-holder">
											<select name="b_day" class="form-control">
												@for($ctr = 1; $ctr <= 31; $ctr++)
												<option {{ old('b_day') == $ctr ? 'selected' : '' }} value="{{ $ctr }}">{{ $ctr }}</option>
												@endfor
											</select>
										</div>
										<div class="date-holder">
											<select name="b_year" class="form-control">
												@for($ctr = date("Y"); $ctr >= (date("Y")-100); $ctr--)
												<option {{ old('b_year') == $ctr ? 'selected' : '' }} value="{{ $ctr }}">{{ $ctr }}</option>
												@endfor
											</select>
										</div>
									</div>
								</div>
							</div>
						</td>
						<td class="c2">
							
							<div class="register-form">

								@if ($errors->any())
								    <div class="alert alert-danger">
								        <ul>
								            @foreach ($errors->all() as $error)
								                <li>{{ $error }}</li>
								            @endforeach
								        </ul>
								    </div>
								@endif
								
								<div class="form-group">
									<div class="register-label">CONTACT</div>
									<div class="form-input">
										<input class="form-control input-sm" type="text" name="contact" value="{{ old('contact') }}">
									</div>
								</div>
								<div class="form-group">
									<div class="register-label">PASSWORD</div>
									<div class="form-input">
										<input class="form-control input-sm" type="password" name="password" value="">
									</div>
								</div>
								<div class="form-group">
									<div class="register-label">REPEAT PASSWORD</div>
									<div class="form-input">
										<input class="form-control input-sm" type="password" name="password_confirmation" value="">
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
											<button class="btn btn-brown">Sign Up</button>
										</div>
										<div class="holder"><span class="or">OR</span></div>
										<div class="holder"><a class="login-href" href="javascript:">Login an Account</a></div>
									</div>
								</div>
							</div>
						</td>
					</tr>
				</tbody>
			</table>		
		</div>
	</div>
</form>
@endsection
@section("script")

@endsection
@section("css")
<link rel="stylesheet" type="text/css" href="/themes/{{ $shop_theme }}/css/member_register.css">
@endsection