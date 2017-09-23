@extends("layout")
@section("content")
<div class="content">
	<!-- Media Slider -->
	<div class="slider-wrapper" style="background-image: url('/themes/{{ $shop_theme }}/img/top-image.png')">
		<div class="container">
			<div class="caption-logo-container"><img src="/themes/{{ $shop_theme }}/img/logo-caption.png"></div>
			<div class="caption-container">
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
					<div class="content-title">JCA WELLNESS INTERNATIONAL CORP</div>
					<div class="context">
						<p>
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
	<div class="wrapper-2">
		<div class="title-container">
			<div class="title-container">
				<span>Why</span>
				<span>JCA International</span>
			</div>
		</div>
		<div class="content-container row clearfix">
			<div class="col-md-4">
				<div class="per-image-container">
					<img src="/themes/{{ $shop_theme }}/img/logo-caption.png">
				</div>
			</div>
		</div>
	</div>
	<!-- WHY JCA -->
	<div class="wrapper-2"></div>
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