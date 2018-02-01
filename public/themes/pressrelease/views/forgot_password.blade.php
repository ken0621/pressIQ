@extends("layout")
@section("content")
<div class="content">
	<div class="background-container" style="background-image: url('/themes/{{ $shop_theme }}/img/home-banner.jpg')">
		<div class="container">
			<div class="row clearfix">	
				<div class="col-md-12">
			    	<div class="background-border">
			    		@if (session('forgot_password'))
	                        <div class="alert alert-success">
	                            {{ session('forgot_password') }}
	                        </div>
                    	@endif
				   		<div class="signin-container">
				   			<div class="title-container">Enter your Email</div>

				   			<form method="post">
				    			{{csrf_field()}}	
				    			<div class="border"></div>
				    			<div class="register-form">
				    				<input type="email" name="user_email" id="user_email" placeholder="Username / Email" required>
				    			</div>
				    			<div class="button-container">
				    			<button type="submit" formaction="/forgot/password/send">Send Instruction</button>
				    		</form>
				    	</div>
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

<script async src="https://www.googletagmanager.com/gtag/js?id=UA-113245030-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-113245030-1');
</script>

@endsection