@extends("layout")
@section("content")

<div class="content">

	<div class="signin-form-container">
		<div class="container">
			<div class="row clearfix">
				<div class="col-md-4">
					<div class="signin-form">
						
						<div class="signin-text-header">Welcome to Digima House!</div>
						<div class="signin-subtext-header">Not a Member?  <span><a href="">Sign Up >></a></span></div>

						<!-- <input type="text" class="email_textbox">
						<input type="Password" class="password_textbox">
						<button>Sign in to you account</button> -->
					</div>
				</div>

				<div class="col-md-8">

				</div>

			</div>
		</div>
	</div>

</div>

@endsection

@section("css")
<link rel="stylesheet" type="text/css" href="/themes/{{ $shop_theme }}/css/signin.css">
@endsection

@section("js")

<script type="text/javascript">
$(document).ready(function()
{
	
});
</script>
@endsection