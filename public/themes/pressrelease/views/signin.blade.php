@extends("layout")
@section("content")
<div class="content">
	<div class="background-container" style="background-image: url('/themes/{{ $shop_theme }}/img/home-banner.jpg')">
		<div class="container">
		    		<div class="background-border">
			    		<div class="signin-container">
			    			<div class="title-container">Login</div>
			    			<div class="border"></div>
			    			<div class="register-form">
			    				<input type="text" placeholder="Email">
			    			</div>
			    			<div class="register-form">
			    				<input type="text" placeholder="Password">
			    			</div>
			    			<div class="forgot-password"><a href="#">Forgot Password?</a></div> 
			    			<div class="button-container">
			    			<a href="/pressuser/dashboard">Login</a>
			    	</div>
			    </div>
		    </div>
		</div>
	</div>
</div>
@endsection

@section("css")
<link rel="stylesheet" type="text/css" href="/themes/{{ $shop_theme }}/css/sign_in.css">
@endsection

@section("script")

<script type="text/javascript">

</script>

@endsection