@extends("layout")
@section("content")
<div class="content">

	<section class="wrapper-1 parallax" style="background-image: url('/themes/{{ $shop_theme }}/img/home-banner.jpg')">
		<div class="container">
			<div class="title-container">
				<div class="upper-subtitle">
					Welcome to
				</div>
				<div class="main-title">
					Digital Marketing Solution Ph, Inc.
				</div>
				<div class="bottom-subtitle">
					“Choose the provider who Cares. Choose DMS”
				</div>
				<div class="border-holder"></div>
				<div class="bottom-paragraph">
					A company that serves as your whole package business integration from technology to marketing!
				</div>
			</div>
		</div>
	</section>

	<section class="wrapper-2">
		<div class="container">
			<div class="about-container-1">
				<div class="about-company">
					<div class="about-title">
						WHO WE ARE?
					</div>
					<div class="about-paragraph">
						Digital & Marketing Solutions PH, Inc., also referred as DMSPH, was established and registered to Securities and Exchange Commission (SEC) on February 19, 2013. Inspired by accounting process automation and business management development, Ms. Rose Ann Amarillo and Mr. Karl Landicho ventured to create an institution and a family named DMSPH.
					</div>
				</div>
				<div class="about-image">
					<img src="/themes/{{ $shop_theme }}/img/model.png">
				</div>
			</div>
			<div class="about-container-2">
				<div class="about-title">
					WHAT WE DO?
				</div>
				<div class="about-paragraph">
					We are called Intuit ProAdvisor who resells Intuit Products such as QuickBooks Accounting Software and QuickBooks Point of Sale (POS). Selling QuickBooks Accounting as our main line of business, we also offer complimentary services such as training and implementation. We mean to help your business grow. We improve and automate business from accounting, inventory, sales, billing and collection.
				</div>
			</div>
			<div class="about-container-3">
				<div class="about-company">
					<div class="about-title">
						VISION
					</div>
					<div class="about-paragraph">
						To be the top software developer first in Philippines before we venture the Globe. We envision ourselves to be the top service provider of innovative accounting and management process which will support all growing businesses and will inspire huge businesses to soar even bigger.
					</div>
				</div>
				<div class="about-company">
					<div class="about-title">
						MISSION
					</div>
					<div class="about-paragraph">
						To inform every business entity that accounting process and business transaction recording should be easy, fast, secured, convenient and we exist to help them apply it in reality.
					</div>
				</div>
			</div>
			<div class="about-container-4">
				<div class="about-title">
					VALUES & CULTURE
				</div>
				<div class="about-values-container">
					<div class="about-values-holder">
						<div class="values-icon">
							<img src="/themes/{{ $shop_theme }}/img/icon-1.png">
						</div>
						<div class="values-name">
							Consistency
						</div>
					</div>
					<div class="about-values-holder">
						<div class="values-icon">
							<img src="/themes/{{ $shop_theme }}/img/icon-2.png">
						</div>
						<div class="values-name">
							Focus
						</div>
					</div>
					<div class="about-values-holder">
						<div class="values-icon">
							<img src="/themes/{{ $shop_theme }}/img/icon-3.png">
						</div>
						<div class="values-name">
							Preparedness
						</div>
					</div>
					<div class="about-values-holder">
						<div class="values-icon">
							<img src="/themes/{{ $shop_theme }}/img/icon-4.png">
						</div>
						<div class="values-name">
							Prompt and Attentive
						</div>
					</div>
					<div class="about-values-holder">
						<div class="values-icon">
							<img src="/themes/{{ $shop_theme }}/img/icon-5.png">
						</div>
						<div class="values-name">
							Professionalism
						</div>
					</div>
					<div class="about-values-holder">
						<div class="values-icon">
							<img src="/themes/{{ $shop_theme }}/img/icon-6.png">
						</div>
						<div class="values-name">
							Nurture Relationship
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>

	<section class="wrapper-3">
		<div class="container">
			<div class="product-container">
				<div class="product-title">
					QUICKBOOKS PRODUCTS
				</div>
			</div>
		</div>
	</section>

	<div class="scroll-up"><img src="/themes/{{ $shop_theme }}/img/scroll-up.png"></div>
</div>
@endsection

@section("css")
<link rel="stylesheet" type="text/css" href="/themes/{{ $shop_theme }}/css/app.css?version=1.2">

@endsection

@section("script")
<script type="text/javascript" src="/themes/{{ $shop_theme }}/js/home.js"></script>
<script type="text/javascript" src="/themes/{{ $shop_theme }}/js/scroll_spy.js"></script>
<script type="text/javascript" src="/themes/{{ $shop_theme }}/js/home-swiper.js"></script>
<script type="text/javascript" src="/themes/{{ $shop_theme }}/js/product-swiper.js"></script>
<script type="text/javascript" src="/themes/{{ $shop_theme }}/js/gallery-swiper.js"></script>
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

		function event_slick()
		{
			$('.prod-image-thumb-container').slick({
				prevArrow:"<img class='a-left control-c prev slick-prev' src='/themes/{{ $shop_theme }}/img/arrow-left1.png'>",
		      	nextArrow:"<img class='a-right control-c next slick-next' src='/themes/{{ $shop_theme }}/img/arrow-right1.png'>",
				infinite: false,
				slidesToShow: 4,
				slidesToScroll: 1,
				arrows: false
			});
		}

	    lightbox.option({
	      'disableScrolling': true,
	      'wrapAround': true
	    });
	});
</script>
<script>
	$('.btn-more, .btn-show').click(function() {
	    $('#morecontact, #hiddenabout').slideDown(1000);
	    $('.btn-more, .btn-show').hide(0);
	    $('.btn-less, .btn-hide').show(0);
	});

$('.btn-less, .btn-hide').click(function() {
	    $('#morecontact, #hiddenabout').slideUp(1000);
	    $('.btn-more, .btn-show').show(0);
	    $('.btn-less, .btn-hide').hide(0);
	});
</script>

@endsection


