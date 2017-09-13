@extends("layout")
@section("content")
<div class="container">
	<div class="register">
		<table>
			<tbody>
				<tr>
					<td class="c1">
						<div class="register-side">
							<img src="/themes/{{ $shop_theme }}/img/forgot_password.jpg">
						</div>
					</td>
					<td class="c2">
						<div class="register-form">
							<div class="form-group">
									<div class="choice">
										<h2 class ="h1">Forgot Password</h2>
										<h2 class="h2">Lost Password</h2>
										<p class="p1">Follow these simple steps to reset your password</p>
										<p class="p2">1. Enter your brown.com.ph E-mail Address</p>
										<p class="p3">2. Wait for your recovery details to be sent</p>
										<p class="p4">3. Follow instruction to login your account again	</p>
										<div class="register-label">EMAIL</div>
											<div class="form-input">
												<input class="form-control input-sm" type="email" name="email" placeholder="Type Your Email Here" value="">
											</div>
										<div class="holder">
											<button class="btn btn-brown">Get New Password</button>
										</div>
									</div>
								</div>
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
<link rel="stylesheet" type="text/css" href="/themes/{{ $shop_theme }}/css/forgot_password.css">
@endsection