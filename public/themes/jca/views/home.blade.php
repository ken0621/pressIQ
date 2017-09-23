@extends("layout")
@section("content")
<div class="content">
	<!-- Media Slider -->
	<div class="slider-wrapper" style="background-image: url('/themes/{{ $shop_theme }}/img/top-image.png')">
		<div class="container">
			<div class="caption-logo-container"><img src="/themes/{{ $shop_theme }}/img/logo-caption.png"></div>
			<div class="caption-container animated fadeInDown">
				<h1>Your road to financial wellness</h1>
				<h1>Lifestyle at it’s finest!</h1>
			</div>
		</div>
	</div>
	<!-- WHO WE ARE -->
	<div class="wrapper-1">
		<div class="container">
			<div class="title-container">
				<span>Who</span>
				<span>Are We</span>
			</div>
			<div class="content-container row clearfix">
				<div class="col-md-6">
					<div class="content-title animated fadeInUp">JCA WELLNESS INTERNATIONAL CORP</div>
					<div class="context">
						<p class="animated fadeInLeft">
							JCA Wellness International Corporation is a company that’s founded by group
							of entrepreneurs that’s driven to build a global community that will bring
							various business opportunities to aspiring entrepreneurs, to provide products
							and services that will enhance one’s beauty and wellness and to teach every
							aspiring entrepreneurs the various ways of earning.<br><br>

							JCA Wellness International Corporation is currently building its network in
							Raffles Corporate Center in Emerald Ave. Ortigas Pasig City and is starting to
							grow its market in the Philippines and to other countries.
						</p>
					</div>
				</div>
				<div class="col-md-6">
					<div class="image-container">
						<img src="/themes/{{ $shop_theme }}/img/who-we-are-pic.png">
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- WHY JCA -->
	<div class="wrapper-2">
		<div class="container">
			<div class="title-container">
				<div class="title-container">
					<span>Why</span>
					<span>JCA International</span>
				</div>
			</div>
			<div class="content-container row clearfix">
				<!-- WE BELIEVE -->
				<div class="col-md-4">
					<div class="per-image-container">
						<img src="/themes/{{ $shop_theme }}/img/we-believe.png">
						<div class="content-text-container">
							<h1>We Believe</h1>
							<div class="title-line"></div>
							<p class="animated fadeInLeft">
								JCA International Corporation believes that natural health and wellness has the ability to change the lives of humanity. This inspired its founders to introduce a product that will provide opportunities to aspiring entrepreneurs ways.
							</p>
						</div>
					</div>
				</div>
				<!-- WE ARE SAFE -->
				<div class="col-md-4">
					<div class="per-image-container">
						<img src="/themes/{{ $shop_theme }}/img/we-are-safe.png">
						<div class="content-text-container">
							<h1>We Believe</h1>
							<div class="title-line"></div>
							<p class="animated fadeInLeft">
								Instead of the usual chemical-based beauty and wellness products, JCA International Corporation’s products are 100% safe and organic that will definitely have an everlasting benefits to its buyers and users.
							</p>
						</div>
					</div>
				</div>
				<!-- WE AIM -->
				<div class="col-md-4">
					<div class="per-image-container">
						<img src="/themes/{{ $shop_theme }}/img/we-aim.png">
						<div class="content-text-container">
							<h1>We Believe</h1>
							<div class="title-line"></div>
							<p class="animated fadeInLeft">
								Lastly, JCA Wellness International Corporation aims to deliver these broad selection of safe and organic products that will showcase its commitment to innovate today’s beauty and wellness.
							</p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- BENEFITS IN JCA -->
	<div class="wrapper-3"></div>
	<!-- COMPANY MISISON VISION -->
	<div class="wrapper-4"></div>
	<div class="wrapper-5"></div>
	<!-- SCROLL TO TOP -->
	<div class="scroll-up"><img src="/themes/{{ $shop_theme }}/img/scroll-up.png"></div>
</div>
@endsection

@section("css")
<link rel="stylesheet" type="text/css" href="/themes/{{ $shop_theme }}/css/home.css">

@endsection


@section("js")
<script src="js/wow.min.js"></script>
<script>
	new WOW().init();
</script>


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

    /*TEXT FADEOUT*/
    $(window).scroll(function(){
	    	$(".caption-container, .caption-logo-container").css("opacity", 1 - $(window).scrollTop() / 250);
	});

});
</script>
@endsection