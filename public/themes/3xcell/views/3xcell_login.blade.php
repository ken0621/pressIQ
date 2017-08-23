@extends("layout")
@section("content")
<div class="login-wrapper">
	<div class="container">
		<div class="login-holder">
			<div class="logo-container">
				<img src="/themes/{{ $shop_theme }}/img/logo-lg.png">
				<h1>BORN TO SUCCEED.</h1>
			</div>
			<div class="login-field-container">
				<h1>
					Login
				</h1>
				<input class="text-field" type="text" name="" placeholder="Username">
				<input class="text-field" type="password" name="" placeholder="Password">
				<div class="login-button">LOGIN</div>
				<h2>Don't have an account yet?</h2>
				<a href="/3xcell_signup"><h3>SIGN UP HERE</h3></a>
			</div>
		</div>
	</div>
</div>
@endsection

@section("css")
<link rel="stylesheet" type="text/css" href="/themes/{{ $shop_theme }}/css/3xcell_login.css">
@endsection

@section("js")
<script type="text/javascript">
$(document).ready(function()
{
	/*scroll up*/
	$(window).scroll(function () {
        if ($(this).scrollTop() > 700) {
            $('.scroll-up').fadeIn();
        } else {
            $('.scroll-up').fadeOut();
        }
    });

    $('.scroll-up').click(function () {
        $("html, body").animate({
            scrollTop: 0
        }, 700);
        return false;
    });
});
</script>
@endsection