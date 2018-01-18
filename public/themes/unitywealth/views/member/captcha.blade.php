@extends("member.member_layout")
@section("member_content")
<div class="report-container">
	<div class="report-header clearfix">
		<div class="left">
			<div class="icon">
				<h1><i class="fa fa-recycle"></i></h1>
			</div>
			<div class="text">
				<div class="name">{{$page}}</div>
				<div class="sub"></div>
			</div>
		</div>
	</div>
	<div class="report-content">
		<center>
			<form>
				<div class="holder">
				  	<div class="g-recaptcha" data-sitekey="6Let6UAUAAAAAD0MvJH0Tl_Bej1YkE1oaD0mIE-j"></div>
				  	<div style="margin-top: 10px;">
				  		<button class="btn btn-primary btn-custom-primary submit-captcha" type="submit">Submit</button>
				  	</div>
				</div>
			</form>
		</center>
	</div>
</div>
@endsection
@section("member_script")
<script src='https://www.google.com/recaptcha/api.js'></script>
<script src="/themes/unitywealth/js/recaptcha.js"></script>
@endsection
@section("member_css")
<link rel="stylesheet" type="text/css" href="/themes/{{ $shop_theme }}/css/report.css">
@endsection