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
				<div class="browseby-title-holder">
					<p class="title">Browse By Category</p>
				</div>
				<div class="browseby-tiles-holder">
					<div class="browseby-paddingformat">
						
						<a class="browseby-active" href="">
							<div class="browseby-image-holder">
								<img class="image-responsive" src="/themes/{{ $shop_theme }}/img/browseby-brown-androidphone-icon.png">
							</div>
							<div class="browseby-icon-title-holder">
								<p class="browseby-icon-title">Brown Phone</p>
							</div>
						</a>

						<a class="browseby" href="">
							<div class="browseby-image-holder">
								<img class="image-responsive" src="/themes/{{ $shop_theme }}/img/browseby-phonecase-icon.png">
							</div>
							<div class="browseby-icon-title-holder">
								<p class="browseby-icon-title">Phone Case</p>
							</div>
						</a>

						<a class="browseby" href="">
							<div class="browseby-image-holder">
								<img class="image-responsive" src="/themes/{{ $shop_theme }}/img/browseby-headphone-icon.png">
							</div>
							<div class="browseby-icon-title-holder">
								<p class="browseby-icon-title">Head Phones</p>
							</div>
						</a>

						<a class="browseby" href="">
							<div class="browseby-image-holder">
								<img class="image-responsive" src="/themes/{{ $shop_theme }}/img/browseby-powerbank-icon.png">
							</div>
							<div class="browseby-icon-title-holder">
								<p class="browseby-icon-title">Power Bank</p>
							</div>
						</a>

						<a class="browseby" href="">
							<div class="browseby-image-holder">
								<img class="image-responsive" src="/themes/{{ $shop_theme }}/img/browseby-dongles-icon.png">
							</div>
							<div class="browseby-icon-title-holder">
								<p class="browseby-icon-title">Dongles</p>
							</div>
						</a>

						<a class="browseby" href="">
							<div class="browseby-image-holder">
								<img class="image-responsive" src="/themes/{{ $shop_theme }}/img/browseby-internetofthings-icon.png">
							</div>
							<div class="browseby-icon-title-holder">
								<p class="browseby-icon-title">Internet Of Things</p>
							</div>
						</a>

						<a class="browseby" href="">
							<div class="browseby-image-holder">
								<img class="image-responsive" src="/themes/{{ $shop_theme }}/img/browseby-healthtechnology-icon.png">
							</div>
							<div class="browseby-icon-title-holder">
								<p class="browseby-icon-title">Health Technology</p>
							</div>
						</a>
					</div>
				</div>
			</div>
			<div class="mid-container">
				<div class="browseby-title-holder">
					<p class="title">Featured</p>
				</div>
				<div class="product-carousel">
					<div>
						<div class="product-holder">
							<img src="/themes/{{ $shop_theme }}/img/feature-1.jpg">
						</div>	
					</div>
					<div>
						<div class="product-holder">
							<img src="/themes/{{ $shop_theme }}/img/feature-2.jpg">
						</div>	
					</div>
					<div>
						<div class="product-holder">
							<img src="/themes/{{ $shop_theme }}/img/feature-3.jpg">
						</div>	
					</div>
					<div>
						<div class="product-holder">
							<img src="/themes/{{ $shop_theme }}/img/feature-4.jpg">
						</div>	
					</div>
				</div>
			</div>
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
<script type="text/javascript" src="/themes/{{ $shop_theme }}/js/home.js"></script>
@endsection
@section("css")
<link rel="stylesheet" type="text/css" href="/themes/{{ $shop_theme }}/css/home.css">
@endsection