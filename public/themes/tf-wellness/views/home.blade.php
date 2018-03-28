@extends("layout")
@section("content")
<div class="content">

<section class="home-banner">
	<div class="container">
		<div class="row clearfix">
			<div class="col-md-3 p-0">
				<div class="categories-container">
					<div class="title">
						<img src="/themes/{{ $shop_theme }}/img/menu.png">
						<span>Shop by Categories</span>
					</div>
					<ul class="categories">
						<li><a href="#">Health Supplements</a></li>
						<li><a href="#">Beverages</a></li>
						<li><a href="#">Beauty Products</a></li>
						<li><a href="#">Home Care Products</a></li>
						<li><a href="#">Breakfast Foods</a></li>
						<li><a href="#">RTWs</a></li>
						<li><a href="#">Groceries</a></li>
						<li><a href="#">Gadgets</a></li>
						<li><a href="#">Home Appliances</a></li>
						<li><a href="#">Beauty Salon</a></li>
						<li><a href="#">Spa</a></li>
						<li><a href="#">More</a></li>
					</ul>
				</div>
			</div>
			<div class="col-md-6 p-0">
				<div class="slider-wrapper single-item">
					<img src="/themes/{{ $shop_theme }}/img/home-slider-1.jpg">
					<img src="/themes/{{ $shop_theme }}/img/home-slider-2.jpg">
				</div>
			</div>
			<div class="col-md-3 p-0">
				<div class="ads-carousel">
					<div class="holder">
						<img src="/themes/{{ $shop_theme }}/img/ads-top-1.jpg">
					</div>
					<div class="holder">
						<img src="/themes/{{ $shop_theme }}/img/ads-bottom-1.jpg">
					</div>
				</div>
				<div class="ads-carousel">
					<div class="holder">
						<img src="/themes/{{ $shop_theme }}/img/ads-bottom-1.jpg">
					</div>
					<div class="holder">
						<img src="/themes/{{ $shop_theme }}/img/ads-top-1.jpg">
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<section class="wrapper-1">
	<div class="container pt-3 pb-4">
		<div class="jumbotron mb-0 py-4 px-5">
			<div class="row clearfix">
				<div class="col-md-3">
					<div class="media">
					  <img class="align-self-center mr-3" src="/themes/{{ $shop_theme }}/img/trust-icon.png" alt="Generic placeholder image">
					  <div class="media-body">
					    <h5 class="mt-0 mb-0">We are trusted</h5>
					    <p class="mb-0">Secured transactions, Satisfaction, Guaranteed.</p>
					  </div>
					</div>
				</div>
				<div class="col-md-3">
					<div class="media">
					  <img class="align-self-center mr-3" src="/themes/{{ $shop_theme }}/img/quality-icon.png" alt="Generic placeholder image">
					  <div class="media-body">
					    <h5 class="mt-0 mb-0">Quality Products</h5>
					    <p class="mb-0">We assure the best quality at amazing prices.</p>
					  </div>
					</div>
				</div>
				<div class="col-md-3">
					<div class="media">
					  <img class="align-self-center mr-3" src="/themes/{{ $shop_theme }}/img/payment-icon.png" alt="Generic placeholder image">
					  <div class="media-body">
					    <h5 class="mt-0 mb-0">Safe Payment</h5>
					    <p class="mb-0">Protected online payment</p>
					  </div>
					</div>
				</div>
				<div class="col-md-3">
					<div class="media">
					  <img class="align-self-center mr-3" src="/themes/{{ $shop_theme }}/img/delivery-icon.png" alt="Generic placeholder image">
					  <div class="media-body">
					    <h5 class="mt-0 mb-0">Item Delivery</h5>
					    <p class="mb-0">We assure the fast delivery</p>
					  </div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<section class="wrapper-2">
	<div class="container">
		<div class="title">
			<span>Featured Products</span><span class="button-container"><a href="">Shop All</a></span>
			<div class="line-bot"></div>
		</div>
		<div class="product-container">
			<div class="row no-gutters clearfix">
				<div class="col-md-2 prod-border">
					<div class="prod-holder">
						<a href="#" style="text-decoration: none;">
							<div class="prod-image">
								<img src="/themes/{{ $shop_theme }}/img/featured-prod-1.jpg">
							</div>
							<div class="details-container">
								<div class="prod-type">Appliances</div>
								<div class="prod-name">Kyowa 450-i Kitchen Blender</div>
								<div class="prod-price">PHP 350.00</div>
							</div>
						</a>
					</div>
				</div>
				<div class="col-md-2 prod-border">
					<div class="prod-holder">
						<a href="#" style="text-decoration: none;">
							<div class="prod-image">
								<img src="/themes/{{ $shop_theme }}/img/featured-prod-2.jpg">
							</div>
							<div class="details-container">
								<div class="prod-type">Appliances</div>
								<div class="prod-name">All-in-one Clothes Washing Machine</div>
								<div class="prod-price">PHP 2,300.00</div>
							</div>
						</a>
					</div>
				</div>
				<div class="col-md-2 prod-border">
					<div class="prod-holder">
						<a href="#" style="text-decoration: none;">
							<div class="prod-image">
								<img src="/themes/{{ $shop_theme }}/img/featured-prod-3.jpg">
							</div>
							<div class="details-container">
								<div class="prod-type">Appliances</div>
								<div class="prod-name">Kyowa Dust Buster</div>
								<div class="prod-price">PHP 700.00</div>
							</div>
						</a>
					</div>
				</div>
				<div class="col-md-2 prod-border">
					<div class="prod-holder">
						<a href="#" style="text-decoration: none;">
							<div class="prod-image">
								<img src="/themes/{{ $shop_theme }}/img/featured-prod-4.jpg">
							</div>
							<div class="details-container">
								<div class="prod-type">Beauty Products</div>
								<div class="prod-name">Loreal Beauty Products</div>
								<div class="prod-price">PHP 150.00</div>
							</div>
						</a>
					</div>
				</div>
				<div class="col-md-2 prod-border">
					<div class="prod-holder">
						<a href="#" style="text-decoration: none;">
							<div class="prod-image">
								<img src="/themes/{{ $shop_theme }}/img/featured-prod-5.jpg">
							</div>
							<div class="details-container">
								<div class="prod-type">Spa</div>
								<div class="prod-name">Body Massage and Spa</div>
								<div class="prod-price">PHP 300.00</div>
							</div>
						</a>
					</div>
				</div>
				<div class="col-md-2 prod-border">
					<div class="prod-holder">
						<a href="#" style="text-decoration: none;">
							<div class="prod-image">
								<img src="/themes/{{ $shop_theme }}/img/featured-prod-6.jpg">
							</div>
							<div class="details-container">
								<div class="prod-type">Gadgets</div>
								<div class="prod-name">Xiaomi Smart Phones</div>
								<div class="prod-price">PHP 6,990.00</div>
							</div>
						</a>
					</div>
				</div>
				<div class="col-md-2 prod-border">
					<div class="prod-holder">
						<a href="#" style="text-decoration: none;">
							<div class="prod-image">
								<img src="/themes/{{ $shop_theme }}/img/featured-prod-7.jpg">
							</div>
							<div class="details-container">
								<div class="prod-type">Appliances</div>
								<div class="prod-name">Kyowa Flat Iron G-67 (Light and Handy)</div>
								<div class="prod-price">PHP 350.00</div>
							</div>
						</a>
					</div>
				</div>
				<div class="col-md-2 prod-border">
					<div class="prod-holder">
						<a href="#" style="text-decoration: none;">
							<div class="prod-image">
								<img src="/themes/{{ $shop_theme }}/img/featured-prod-8.jpg">
							</div>
							<div class="details-container">
								<div class="prod-type">More</div>
								<div class="prod-name">Pirate Set Toys for kids</div>
								<div class="prod-price">PHP 450.00</div>
							</div>
						</a>
					</div>
				</div>
				<div class="col-md-2 prod-border">
					<div class="prod-holder">
						<a href="#" style="text-decoration: none;">
							<div class="prod-image">
								<img src="/themes/{{ $shop_theme }}/img/featured-prod-9.jpg">
							</div>
							<div class="details-container">
								<div class="prod-type">Gadget</div>
								<div class="prod-name">Xiaomi Android Tablet</div>
								<div class="prod-price">PHP 8,000.00</div>
							</div>
						</a>
					</div>
				</div>
				<div class="col-md-2 prod-border">
					<div class="prod-holder">
						<a href="#" style="text-decoration: none;">
							<div class="prod-image">
								<img src="/themes/{{ $shop_theme }}/img/featured-prod-10.jpg">
							</div>
							<div class="details-container">
								<div class="prod-type">Appliances</div>
								<div class="prod-name">Kyowa Rice Cooker</div>
								<div class="prod-price">PHP 200.00</div>
							</div>
						</a>
					</div>
				</div>
				<div class="col-md-2 prod-border">
					<div class="prod-holder">
						<a href="#" style="text-decoration: none;">
							<div class="prod-image">
								<img src="/themes/{{ $shop_theme }}/img/featured-prod-11.jpg">
							</div>
							<div class="details-container">
								<div class="prod-type">Appliances</div>
								<div class="prod-name">Kyowa Heavy Duty Blender</div>
								<div class="prod-price">PHP 799.00</div>
							</div>
						</a>
					</div>
				</div>
				<div class="col-md-2 prod-border">
					<div class="prod-holder">
						<a href="#" style="text-decoration: none;">
							<div class="prod-image">
								<img src="/themes/{{ $shop_theme }}/img/featured-prod-12.jpg">
							</div>
							<div class="details-container">
								<div class="prod-type">Appliances</div>
								<div class="prod-name">La Germania Heavy Duty Washing Machine</div>
								<div class="prod-price">PHP 4,000.00</div>
							</div>
						</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<section class="wrapper-3">
	<div class="container">
		<div class="title">
			<div>New Arrivals</div>
			<div class="line-bot"></div>
		</div>
		<div class="product-carousel">
			<div class="holder">
				<div class="prod-holder">
					<a href="#" style="text-decoration: none;">
						<div class="prod-image">
							<img src="/themes/{{ $shop_theme }}/img/arrivals-prod-1.jpg">
						</div>
						<div class="details-container">
							<div class="prod-type">Gadget</div>
							<div class="prod-name">SOny Android Smart Phones</div>
							<div class="prod-price">PHP 6,000.00</div>
						</div>
					</a>
				</div>
			</div>
			<div class="holder">
				<div class="prod-holder">
					<a href="#" style="text-decoration: none;">
						<div class="prod-image">
							<img src="/themes/{{ $shop_theme }}/img/featured-prod-6.jpg">
						</div>
						<div class="details-container">
							<div class="prod-type">Gadgets</div>
							<div class="prod-name">Xiaomi Smart Phones</div>
							<div class="prod-price">PHP 6,990.00</div>
						</div>
					</a>
				</div>
			</div>
			<div class="holder">
				<div class="prod-holder">
					<a href="#" style="text-decoration: none;">
						<div class="prod-image">
							<img src="/themes/{{ $shop_theme }}/img/featured-prod-2.jpg">
						</div>
						<div class="details-container">
							<div class="prod-type">Appliances</div>
							<div class="prod-name">All-in-one Clothes Washing Machine</div>
							<div class="prod-price">PHP 2,300.00</div>
						</div>
					</a>
				</div>
			</div>
			<div class="holder">
				<div class="prod-holder">
					<a href="#" style="text-decoration: none;">
						<div class="prod-image">
							<img src="/themes/{{ $shop_theme }}/img/arrivals-prod-4.jpg">
						</div>
						<div class="details-container">
							<div class="prod-type">Beauty Products</div>
							<div class="prod-name">Loreal Beauty Products</div>
							<div class="prod-price">PHP 265.00</div>
						</div>
					</a>
				</div>
			</div>
			<div class="holder">
				<div class="prod-holder">
					<a href="#" style="text-decoration: none;">
						<div class="prod-image">
							<img src="/themes/{{ $shop_theme }}/img/arrivals-prod-5.jpg">
						</div>
						<div class="details-container">
							<div class="prod-type">Beauty Products</div>
							<div class="prod-name">Loreal Color Nails</div>
							<div class="prod-price">PHP 350.00</div>
						</div>
					</a>
				</div>
			</div>
			<div class="holder">
				<div class="prod-holder">
					<a href="#" style="text-decoration: none;">
						<div class="prod-image">
							<img src="/themes/{{ $shop_theme }}/img/arrivals-prod-6.jpg">
						</div>
						<div class="details-container">
							<div class="prod-type">Beauty Products</div>
							<div class="prod-name">Rahua Facial Set (For Softy Skin)</div>
							<div class="prod-price">PHP 559.00</div>
						</div>
					</a>
				</div>
			</div>
			<div class="holder">
				<div class="prod-holder">
					<a href="#" style="text-decoration: none;">
						<div class="prod-image">
							<img src="/themes/{{ $shop_theme }}/img/featured-prod-7.jpg">
						</div>
						<div class="details-container">
							<div class="prod-type">Appliances</div>
							<div class="prod-name">Kyowa Flat Iron G-67 (Light and Handy)</div>
							<div class="prod-price">PHP 350.00</div>
						</div>
					</a>
				</div>
			</div>
		</div>
	</div>
</section>
<section class="wrapper-4">
	<div class="container">
		<div class="row clearfix">
			<div class="col-md-8">
				<div class="left-container">
					<div class="header">TF WELLNESS</div>
					<p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim. Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu.</p>
					<p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem.</p>
					<div class="header">Shipping Options</div>
					<div class="title">PICK UP</div>
					<p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.</p>
					<div class="title">Meet Up</div>
					<p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.</p>
					<div class="title">Shipping</div>
					<p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.</p>
					<div class="header">Get Intouch With Us</div>
					<div class="title">TF Wellness</div>
					<div class="contact-info">
						<span><i class="fas fa-map-marker-alt"></i></span>
						<span>Lorem ipsum dolor sit amet, consectetuer adipiscing elit.</span>
						<div></div>
						<span><i class="fa fa-phone" aria-hidden="true"></i></span>
						<span>0946 727 3576</span>
						<div></div>
						<span><i class="fa fa-envelope" aria-hidden="true"></i></span>
						<span>yourcompany@email.com</span>
					</div>
				</div>
			</div>
			<div class="col-md-4">
				<div class="right-container">
					<img src="/themes/{{ $shop_theme }}/img/footer-logo.png">
					<div class="title">Find Us on Google Map</div>
					<div class="map-container">
					    <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d15464.659178244572!2d121.1135937!3d14.3018559!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x86f66d98403088c7!2sKolorete+Marketing!5e0!3m2!1sen!2sph!4v1516420495967" width="360" height="380" frameborder="0" style="border:0" allowfullscreen></iframe>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

<div class="scroll-up"><img src="/themes/{{ $shop_theme }}/img/scroll-up.png"></div>
</div>
@endsection

@section("css")
<link rel="stylesheet" type="text/css" href="/themes/{{ $shop_theme }}/css/home.css?version=2">

@endsection

@section("js")
<script type="text/javascript" src="/themes/{{ $shop_theme }}/js/match-height.js"></script>
<script type="text/javascript" src="/themes/{{ $shop_theme }}/js/home.js"></script>
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


