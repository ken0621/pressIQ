@extends("layout")
@section("content")
<div class="content">
	<div class="home-wrapper">
		<div class="container">
			<div class="row clearfix">
				<div class="col-md-3">
					<div class="categories-container">
						<div class="title">
							<img src="/themes/{{ $shop_theme }}/img/menu.png">
							<span>Our Products & Services</span>
						</div>
						<ul class="categories">
							@if(isset($_category))
								@foreach($_category as $category)
								<li><a href="/product?type={{ $category['type_id'] }}">{{ $category['type_name'] }}</a></li>
								@endforeach
							@else
								<li><a href="#">Games</a></li>
								<div class="divider"></div>
								<li><a href="#">General Consultancy</a></li>
								<div class="divider"></div>
								<li><a href="#">General Supply Srvices</a></li>
								<div class="divider"></div>
								<li><a href="#">Holding Services</a></li>
								<div class="divider"></div>
								<li><a href="#">I.T. Srvices</a></li>
								<div class="divider"></div>
								<li><a href="#">Import & Export Services</a></li>
								<div class="divider"></div>
								<li><a href="#">Man Power Services</a></li>
								<div class="divider"></div>
								<li><a href="#">Marketing</a></li>
								<div class="divider"></div>
								<li><a href="#">Real Estate</a></li>
							@endif
						</ul>
					</div>
				</div>
				<div class="col-md-6">
					<div class="slider-wrapper single-item">
						<img src="/themes/{{ $shop_theme }}/img/main-slider.jpg">
						<img src="/themes/{{ $shop_theme }}/img/main-slider.jpg">
					</div>
				</div>
				<div class="col-md-3">
					<div class="img-holder">
						<img src="/themes/{{ $shop_theme }}/img/home-ads-1.jpg">
					</div>
					<div class="img-holder" style="padding-top: 30px;">
						<img src="/themes/{{ $shop_theme }}/img/home-ads-2.jpg">
					</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="wrapper-1">
		<div class="container">
			<div class="row clearfix">
				<div class="col-md-3">
					<div class="title-container">FEATURED SERVICES</div>
				</div>
				<div class="col-md-9">
					<div class="line"></div>
				</div>
			</div>
			<div class="row clearfix">
				<div class="col-md-3">
					<div class="featured-main-img">
						<img src="/themes/{{ $shop_theme }}/img/featured-main-img.jpg">
					</div>
				</div>
				<div class="col-md-9">
					<!-- Swiper -->
					<div class="swiper-container featured-swiper-container">
					    <div class="swiper-wrapper">
					        <div class="swiper-slide">
						      	<div class="img-holder">
						      		<img src="/themes/{{ $shop_theme }}/img/featured-img-1.jpg">
						      	</div>
						      	<div class="info-container">
						      		<div class="title">General Consultancy</div>
						      		<div class="desc">Add Description Here</div>
						      	</div>
					      	</div>
						     <div class="swiper-slide">
	  					      	<div class="img-holder">
	  					      		<img src="/themes/{{ $shop_theme }}/img/featured-img-2.jpg">
	  					      	</div>
	  					      	<div class="info-container">
	  					      		<div class="title">Marketing</div>
	  					      		<div class="desc">Add Description Here</div>
	  					      	</div>
	  					    </div>
  					      	<div class="swiper-slide">
    					      	<div class="img-holder">
    					      		<img src="/themes/{{ $shop_theme }}/img/featured-img-3.jpg">
    					      	</div>
    					      	<div class="info-container">
    					      		<div class="title">General Supply Services</div>
    					      		<div class="desc">Add Description Here</div>
    					      	</div>
    					    </div>
    					    <div class="swiper-slide">
      					      	<div class="img-holder">
      					      		<img src="/themes/{{ $shop_theme }}/img/featured-img-4.jpg">
      					      	</div>
      					      	<div class="info-container">
      					      		<div class="title">I.T. Services</div>
      					      		<div class="desc">Add Description Here</div>
      					      	</div>
      					    </div>
    					    <div class="swiper-slide">
      					      	<div class="img-holder">
      					      		<img src="/themes/{{ $shop_theme }}/img/featured-img-5.jpg">
      					      	</div>
      					      	<div class="info-container">
      					      		<div class="title">Import and Export Services</div>
      					      		<div class="desc">Add Description Here</div>
      					      	</div>
      					    </div>
    					    <div class="swiper-slide">
      					      	<div class="img-holder">
      					      		<img src="/themes/{{ $shop_theme }}/img/featured-img-6.jpg">
      					      	</div>
      					      	<div class="info-container">
      					      		<div class="title">Manpower Services</div>
      					      		<div class="desc">Add Description Here</div>
      					      	</div>
      					    </div>
					        <div class="swiper-slide">
						      	<div class="img-holder">
						      		<img src="/themes/{{ $shop_theme }}/img/featured-img-1.jpg">
						      	</div>
						      	<div class="info-container">
						      		<div class="title">General Consultancy</div>
						      		<div class="desc">Add Description Here</div>
						      	</div>
					      	</div>
						     <div class="swiper-slide">
	  					      	<div class="img-holder">
	  					      		<img src="/themes/{{ $shop_theme }}/img/featured-img-2.jpg">
	  					      	</div>
	  					      	<div class="info-container">
	  					      		<div class="title">Marketing</div>
	  					      		<div class="desc">Add Description Here</div>
	  					      	</div>
	  					    </div>
    				        <div class="swiper-slide">
    					      	<div class="img-holder">
    					      		<img src="/themes/{{ $shop_theme }}/img/featured-img-1.jpg">
    					      	</div>
    					      	<div class="info-container">
    					      		<div class="title">General Consultancy</div>
    					      		<div class="desc">Add Description Here</div>
    					      	</div>
    				      	</div>
    					    <div class="swiper-slide">
      					      	<div class="img-holder">
      					      		<img src="/themes/{{ $shop_theme }}/img/featured-img-2.jpg">
      					      	</div>
      					      	<div class="info-container">
      					      		<div class="title">Marketing</div>
      					      		<div class="desc">Add Description Here</div>
      					      	</div>
      					    </div>
					    </div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="wrapper-2">
		<div class="container">
			<div class="row clearfix">
				<div class="col-md-2">
					<div class="title-container">REAL ESTATE</div>
				</div>
				<div class="col-md-10">
					<div class="line"></div>
				</div>
			</div>
			<!-- Swiper -->
			<div class="swiper-container real-estate-container">
			    <div class="swiper-wrapper">
				    <div class="swiper-slide">
				    	<div class="img-holder">
				    		<img src="/themes/{{ $shop_theme }}/img/real-img-1.jpg">
				    	</div>
				    	<div class="info-container">
				    		<div class="price">P 2,000,000.00</div>
				    		<div class="desc">This space is for your address, Lorem Ipsum Dolor Sit Amet</div>
				    	</div>
				    </div>
				    <div class="swiper-slide">
				    	<div class="img-holder">
				    		<img src="/themes/{{ $shop_theme }}/img/real-img-2.jpg">
				    	</div>
				    	<div class="info-container">
				    		<div class="price">P 2,400,000.00</div>
				    		<div class="desc">This space is for your address, Lorem Ipsum Dolor Sit Amet</div>
				    	</div>
				    </div>
				    <div class="swiper-slide">
				    	<div class="img-holder">
				    		<img src="/themes/{{ $shop_theme }}/img/real-img-3.jpg">
				    	</div>
				    	<div class="info-container">
				    		<div class="price">P 25,000,000.00</div>
				    		<div class="desc">This space is for your address, Lorem Ipsum Dolor Sit Amet</div>
				    	</div>
				    </div>
				    <div class="swiper-slide">
				    	<div class="img-holder">
				    		<img src="/themes/{{ $shop_theme }}/img/real-img-4.jpg">
				    	</div>
				    	<div class="info-container">
				    		<div class="price">P 15,000,000.00</div>
				    		<div class="desc">This space is for your address, Lorem Ipsum Dolor Sit Amet</div>
				    	</div>
				    </div>
				    <div class="swiper-slide">
				    	<div class="img-holder">
				    		<img src="/themes/{{ $shop_theme }}/img/real-img-1.jpg">
				    	</div>
				    	<div class="info-container">
				    		<div class="price">P 2,000,000.00</div>
				    		<div class="desc">This space is for your address, Lorem Ipsum Dolor Sit Amet</div>
				    	</div>
				    </div>
				    <div class="swiper-slide">
				    	<div class="img-holder">
				    		<img src="/themes/{{ $shop_theme }}/img/real-img-2.jpg">
				    	</div>
				    	<div class="info-container">
				    		<div class="price">P 2,400,000.00</div>
				    		<div class="desc">This space is for your address, Lorem Ipsum Dolor Sit Amet</div>
				    	</div>
				    </div>
			    </div>
			    <!-- Add Pagination -->
			    <div class="swiper-state-next">
			    	<img src="/themes/{{ $shop_theme }}/img/arrow-right.png">
			    </div>
			    <div class="swiper-state-prev">
			    	<img src="/themes/{{ $shop_theme }}/img/arrow-left.png">
			    </div>
			</div>
		</div>
	</div>
	<div class="wrapper-3">
		<div class="container">
			<div class="row clearfix">
				<div class="col-md-3">
					<div class="img-holder">
						<img src="/themes/{{ $shop_theme }}/img/ahm-games-img.jpg">
					</div>
				</div>
				<div class="col-md-9">
					<div class="swiper-container ahm-games-container">
					    <div class="swiper-wrapper">
						    <div class="swiper-slide">
						    	<div class="img-holder">
						    		<img src="/themes/{{ $shop_theme }}/img/games-img-1.jpg">
						    	</div>
						    	<div class="info-container">
						    		<div class="title">AHM E-GAMES STARTER PACK</div>
						    		<div class="desc">400,000 GOLD CHIPS</div>
						    		<div class="price">P 99.00</div>
						    	</div>
						    </div>
						    <div class="swiper-slide">
						    	<div class="img-holder">
						    		<img src="/themes/{{ $shop_theme }}/img/games-img-2.jpg">
						    	</div>
						    	<div class="info-container">
						    		<div class="title">AHM E-GAMES PRO PACKAGE</div>
						    		<div class="desc">800,000 GOLD CHIPS</div>
						    		<div class="price">P 499.00</div>
						    	</div>
						    </div>
						    <div class="swiper-slide">
						    	<div class="img-holder">
						    		<img src="/themes/{{ $shop_theme }}/img/games-img-3.jpg">
						    	</div>
						    	<div class="info-container">
						    		<div class="title">AHM E-GAMES VIP PACKAGE</div>
						    		<div class="desc">1,000,000 GOLD CHIPS</div>
						    		<div class="price">P 999.00</div>
						    	</div>
						    </div>
						    <div class="swiper-slide">
						    	<div class="img-holder">
						    		<img src="/themes/{{ $shop_theme }}/img/games-img-1.jpg">
						    	</div>
						    	<div class="info-container">
						    		<div class="title">AHM E-GAMES STARTER PACK</div>
						    		<div class="desc">400,000 GOLD CHIPS</div>
						    		<div class="price">P 99.00</div>
						    	</div>
						    </div>
						    <div class="swiper-slide">
						    	<div class="img-holder">
						    		<img src="/themes/{{ $shop_theme }}/img/games-img-2.jpg">
						    	</div>
						    	<div class="info-container">
						    		<div class="title">AHM E-GAMES STARTER PACK</div>
						    		<div class="desc">400,000 GOLD CHIPS</div>
						    		<div class="price">P 99.00</div>
						    	</div>
						    </div>
					    </div>
					    <div class="swiper-games-next">
					    	<img src="/themes/{{ $shop_theme }}/img/arrow-right.png">
					    </div>
					    <div class="swiper-games-prev">
					    	<img src="/themes/{{ $shop_theme }}/img/arrow-left.png">
					    </div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="wrapper-4">
		<div class="container">
			<div class="row-no-padding">
				<div class="col-md-6">
					<div class="left-container">
						<img src="/themes/{{ $shop_theme }}/img/wrapper-4-bg.jpg">
					</div>
				</div>
				<div class="col-md-6">
					<div class="right-container">
						<div class="title">SINGLE / MULTIPLE QUOTATION REQUEST</div>
						<div class="row clearfix">
							<div class="col-md-6"  style="padding-right: 5px;">
								<div class="row clearfix">
									<div class="col-md-12">
										<input type="text" class="form-control" placeholder="Full Name*">
									</div>
									<div class="col-md-12">
										<input type="email" class="form-control" placeholder="Email Address*">
									</div>
									<div class="col-md-12">
										<input type="number" class="form-control" placeholder="Contact Number*">
									</div>
								</div>
							</div>
							<div class="col-md-6" style="padding-left: 5px;">
								<textarea class="form-control" placeholder="Type your message here..."></textarea>
							</div>
						</div>
						<div class="btn-container">
							<button>Reques for Quotation</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="wrapper-5">
		<div class="container">
			<div class="row clearfix">
				<div class="col-md-6">
					<div class="info-container">
						<div class="title">ahmecommerce.com</div>
						<div class="desc">
							<p>
								Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim. Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. In enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo. Nullam dictum felis eu pede mollis pretium. Integer tincidunt. Cras dapibus. Vivamus elementum semper nisi. Aenean vulputate eleifend tellus. Aenean leo ligula, porttitor eu, consequat vitae, eleifend ac, enim. Aliquam lorem ante, dapibus in, viverra quis, feugiat a, tellus. Phasellus viverra nulla ut metus varius laoreet. Quisque rutrum. Aenean imperdiet.<br><br>
								
								Etiam ultricies nisi vel augue. Curabitur ullamcorper ultricies nisi. Nam eget dui. Etiam rhoncus. Maecenas tempus, tellus eget condimentum rhoncus, sem quam semper libero, sit amet adipiscing sem neque sed ipsum. Nam quam nunc, blandit vel, luctus pulvinar, hendrerit id, lorem.
							</p>
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="img-holder">
						<img src="/themes/{{ $shop_theme }}/img/logo-about.png">
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="wrapper-6">
		<div class="container">
			<div class="row clearfix">
				<div class="col-md-6">
					<div class="map-container">
						<iframe class="map" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d15439.672607472603!2d121.03694842734843!3d14.660586160660534!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3397b719dcc15bd1%3A0xfd4fe4f1c0982e9a!2sVicars+Building!5e0!3m2!1sen!2sph!4v1501901215371" width="550" height="290" frameborder="0" style="border:0" allowfullscreen></iframe>
					</div>
				</div>
				<div class="col-md-6">
					<div class="right-container">
						<div class="title">Contact Us</div>
						<div class="info">
							<div class="row clearfix">
								<div class="col-md-2" style="padding-right: 5px">
									<div class="icon"><img src="/themes/{{ $shop_theme }}/img/location-icon.png"></div>
								</div>
								<div class="col-md-10" style="padding-left: 5px">
									<div class="location">Unit 810 8/F Raffles Corporate Center, F. Ortigas Ave., Ortigas Center, San Antonio, Pasig City</div>
								</div>
							</div>
						</div>
						<div class="info">
							<div class="row clearfix">
								<div class="col-md-2" style="padding-right: 5px">
									<div class="icon"><img src="/themes/{{ $shop_theme }}/img/phone-icon.png"></div>
								</div>
								<div class="col-md-10" style="padding-left: 5px">
									<div class="number">000 - 00 - 00 / 0000 - 000 - 0000</div>
								</div>
							</div>
						</div>
						<div class="info">
							<div class="row clearfix">
								<div class="col-md-2" style="padding-right: 5px">
									<div class="icon"><img src="/themes/{{ $shop_theme }}/img/mail-icon.png"></div>
								</div>
								<div class="col-md-10" style="padding-left: 5px">
									<div class="email">ahmecommerce.support@email.com</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="scroll-up"><img src="/themes/{{ $shop_theme }}/img/scroll-up.png"></div>
</div>
@endsection

@section("css")
<link rel="stylesheet" type="text/css" href="/themes/{{ $shop_theme }}/css/app.css?version=1.2">

@endsection

@section("script")
<script type="text/javascript" src="/themes/{{ $shop_theme }}/js/home.js"></script>
<script type="text/javascript" src="/themes/{{ $shop_theme }}/js/scroll_spy.js"></script>
{{-- <script type="text/javascript" src="/themes/{{ $shop_theme }}/js/theme_custom.js"></script> --}}
<script type="text/javascript">
	$(document).ready(function()
	{
		$('.single-item').slick({
			prevArrow:"<img class='a-left control-c prev slick-prev' src='/themes/{{ $shop_theme }}/img/arrow-left.png'>",
	      	nextArrow:"<img class='a-right control-c next slick-next' src='/themes/{{ $shop_theme }}/img/arrow-right.png'>",
	      	dots: false,
	      	autoplay: true,
	  		autoplaySpeed: 3000,
		});

	    lightbox.option({
	      'disableScrolling': true,
	      'wrapAround': true
	    });
	});
</script>

@endsection


