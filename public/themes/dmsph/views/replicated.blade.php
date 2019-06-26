@extends("layout")
@section("content")

<div style="height: 100vh; text-align: center; background-image: url('/themes/heartzone/img/home-banner.jpg'); background-attachment: fixed; background-size: cover; background-position: center;">
	<div style="position: absolute; top: 50%;
	-webkit-transform: translateY(-50%);
	-ms-transform: translateY(-50%);
	transform: translateY(-50%); left: 0; right: 0; margin: auto;">
		<h2 style="color: #fff; text-shadow:
	   -1px -1px 0 #000,  
	    1px -1px 0 #000,
	    -1px 1px 0 #000,
	     1px 1px 0 #000;">You have been invited.</h2>
		<div>
			<button class="btn btn-primary" onclick="location.href='/members/register'">Click here to register</button>
		</div>
	</div>
</div>
@endsection

@section("css")
<style type="text/css">
.header-container, #bottom-footer, .bottom
{
	display: none;
}
</style>
@endsection