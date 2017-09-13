@extends("layout")
@section("content")
<div class="content">
	<div class="wrapper-1">
		<div class="container">
			<div class="top-container row clearfix">
				<!-- SLIDER -->
				<div class="col-md-8">
					<div class="slider-container">
						<div class="caption-container">
							<h1>4.7” HD IPS</h1>
							<h2>DISPLAY</h2>
							<h3>A PHONE FILIPINOS<br>CAN BE PROUD OF</h3>
							<h4>With Premium Content and Rewards App</h4>
							<div class="ads-button1"><span>Learn More</span><span>&nbsp;<i class="fa fa-caret-right" aria-hidden="true"></i></span></div>
						</div>
						<img src="/themes/{{ $shop_theme }}/img/slider-main.png">
					</div>
				</div>
				<!-- RIGHT ADS -->
				<div class="col-md-4">
					<div class="right-ads">
						<div class="ad-container">
							<div class="button-container">
								<div class="ads-button2"><span>Shop Now</span><span>&nbsp;<i class="fa fa-caret-right" aria-hidden="true"></i></span></div>
							</div>
							<img src="/themes/{{ $shop_theme }}/img/right-ad1.png">
						</div>
						<div class="ad-container">
							<div class="button-container">
								<div class="ads-button2"><span>Shop Now</span><span>&nbsp;<i class="fa fa-caret-right" aria-hidden="true"></i></span></div>
							</div>
							<img src="/themes/{{ $shop_theme }}/img/right-ad2.png">
						</div>
						<div class="ad-container">
							<div class="button-container2">
								<div class="ads-button2 button-brown"><span>Shop Now</span><span>&nbsp;<i class="fa fa-caret-right" aria-hidden="true"></i></span></div>
							</div>
							<img src="/themes/{{ $shop_theme }}/img/right-ad3.png">
						</div>
					</div>
				</div>				
			</div>
			<div class="mid-container">
				
			</div>
			<div class="bottom-container"></div>
		</div>
	</div>
	<!-- VIDEO ADS -->
	<div class="wrapper-2"></div>
	<!-- INTRODUCING BROWN EDITION -->
	<div class="wrapper-3"></div>
	<!-- BROWN ARTICLES -->
	<div class="wrapper-4"></div>
</div>
@endsection
@section("script")

@endsection
@section("css")
<link rel="stylesheet" type="text/css" href="/themes/{{ $shop_theme }}/css/home.css">
@endsection