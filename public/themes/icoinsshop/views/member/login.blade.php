@extends("layout")
@section("content")
<div style="padding: 100px 0 50px 0;">
	<div class="container">
		<input type="hidden" id="_token" value="{{csrf_token()}}">
		<div class="register">
			<table>
				<tbody>
					<tr>
						<td class="c1">
							<div class="register-side">
								<img src="/themes/{{ $shop_theme }}/img/login-img.jpg">
							</div>
						</td>
						<td class="c2">
							@include("member2.include_login")
						</td>
					</tr>
				</tbody>
			</table>		
		</div>
	</div>
</div>
@endsection
@section("script")
<script type="text/javascript" src="/assets/member/js/google_script/google_script_auth.js"></script>

<script>startApp();</script>
@endsection
@section("css")
<link rel="stylesheet" type="text/css" href="/themes/{{ $shop_theme }}/css/member_login.css">
@endsection