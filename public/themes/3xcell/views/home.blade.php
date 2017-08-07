@extends("layout")
@section("content")
<div class="content">
	<!-- Media Slider -->
	<div class="slider-wrapper single-item">
		<img src="/themes/{{ $shop_theme }}/img/slide-img-2.jpg">
		<img src="/themes/{{ $shop_theme }}/img/slide-img-1.png">
		<img src="/themes/{{ $shop_theme }}/img/slide-img-3.jpg">
	</div>
	<!-- INFORMATIVE -->
	<div class="top-1-container">
		<div class="container">
		<!-- INFO -->
			<div class="info-container row-no-padding clearfix">
				<div class="col-md-4 col-padding">
					<div class="box1-container">
						<div class="title-container">
							<span class="info-icon"><img src="/themes/{{ $shop_theme }}/img/people-icon.png"></span>
							<span class="info-title">Who We Are</span>	
						</div>
						<div class="context-container">
							<p>
								3xcell-E Sales & Marketing Inc. is composed of five dynamic individuals who share the same motivation and common values strengthened and lead by their principal incorporator.
							</p>
						</div>
						<div class="small-button">Read More</div>
					</div>
				</div>
				<div class="col-md-4 col-padding">
					<div class="box2-container">
						<div class="title-container">
							<span class="info-icon"><img src="/themes/{{ $shop_theme }}/img/handshake-icon.png"></span>
							<span class="info-title">Opportunity</span>	
						</div>
						<div class="context-container">
							<div><span><img src="/themes/{{ $shop_theme }}/img/check-icon.png"></span><span>&nbsp;BE A RETAILER</span></div>
							<div><span><img src="/themes/{{ $shop_theme }}/img/check-icon.png"></span><span>&nbsp;BE A FULL PLEDGE DISTRIBUTOR</span></div>
							<div><span><img src="/themes/{{ $shop_theme }}/img/check-icon.png"></span><span>&nbsp;AVAIL OF THE LAY-AWAY PROGRAM</span></div>
						</div>
						<div class="small-button">Know More</div>
					</div>
				</div>
				<div class="col-md-4 col-padding">
					<div class="box3-container">
						<div class="title-container">
							<span class="info-icon"><img src="/themes/{{ $shop_theme }}/img/buah-merah-icon.png"></span>
							<span class="info-title">Buah Merah</span>	
						</div>
						<div class="context-container">
							<p>
								Until now, red fruit still used by Papua's people. Most of the population that consume red fruit, wether in pasta for daily food and also the oil. 
							</p>
						</div>
						<div class="small-button">Learn More</div>
					</div>
				</div>				
			</div>
		</div>
	</div>
	<!-- FEATURED PRODUCTS -->
	<div class="top-2-container">
		<div class="container">
			<div class="featured-prod-container">
				<div class="title-container">
					Featured Products
				</div>
				<div class="prod-container row clearfix">
					<div class="col-md-6">
						<div class="prod-cat">
							<div class="hover-detail-container">
								<h3>TAKE IT EVERYDAY</h3>
								<h4>FEEL IT ALL THE WAY</h4>
								<div class="medium-button blue-button">SHOP NOW</div>								
							</div>
							<div class="hover-bg"></div>
							<img src="/themes/{{ $shop_theme }}/img/supplement-cat.png">
							<div class="bg-overlay">
								<img src="/themes/{{ $shop_theme }}/img/black-overlay.png">
							</div>
							<div class="detail-container">
								<span>Food Supplement</span>
							</div>
							<!-- <div class="medium-button">Shop Now</div> -->
						</div>
						<div class="prod-cat">
							<div class="hover-detail-container">
								<h5>FEEL THE</h5>
								<h6 class="h-red">NATURE'S BEAUTY</h6>
								<div class="medium-button red-button">SHOP NOW</div>								
							</div>
							<div class="hover-bg"></div>
							<img src="/themes/{{ $shop_theme }}/img/beauty-cat.png">
							<div class="bg-overlay">
								<img src="/themes/{{ $shop_theme }}/img/black-overlay.png">
							</div>
							<div class="detail-container">
								<span>Beauty Skin Care</span>
							</div>
							<!-- <div class="medium-button">Shop Now</div> -->
						</div>
					</div>
					<div class="col-md-6">
						<div class="prod-cat">
							<div class="hover-detail-container">
								<h5>YOUR EVERYDAY</h5>
								<h6 class="h-green">HEALTHY DRINK</h6>
								<div class="medium-button green-button">SHOP NOW</div>								
							</div>
							<div class="hover-bg"></div>
							<img src="/themes/{{ $shop_theme }}/img/healthy-drink-cat.png">
							<div class="bg-overlay">
								<img src="/themes/{{ $shop_theme }}/img/black-overlay.png">
							</div>
							<div class="detail-container">
								<span>Healthy Drinks</span>
							</div>
							<!-- <div class="medium-button">Shop Now</div> -->
						</div>
						<div class="row-no-padding clearfix">
							<div class="col-md-6">
								<div class="prod-cat">
									<div class="hover-detail-container hover-detail-container-sml">
										<h3 class="h-gray">BUSINESS</h3>
										<h4>PACKAGE</h4>
										<div class="medium-button blue-button gray-button-short">SHOP NOW</div>								
									</div>
									<div class="hover-bg"></div>
									<img src="/themes/{{ $shop_theme }}/img/package-cat.png">
									<div class="bg-overlay">
										<img src="/themes/{{ $shop_theme }}/img/black-overlay.png">
									</div>
									<div class="detail-container">
										<span>Business Package</span>
									</div>
									<!-- <div class="medium-button button-short">Shop Now</div> -->
								</div>
							</div>
							<div class="col-md-6">
								<div class="prod-cat">
									<div class="hover-detail-container hover-detail-container-sml">
										<h3 class="h-gray">RETAIL</h3>
										<h4>PACKAGE</h4>
										<div class="medium-button green-button gray-button-short">SHOP NOW</div>								
									</div>
									<div class="hover-bg"></div>
									<img src="/themes/{{ $shop_theme }}/img/retail-cat.png">
									<div class="bg-overlay">
										<img src="/themes/{{ $shop_theme }}/img/black-overlay.png">
									</div>
									<div class="detail-container">
										<span>Retail Package</span>
									</div>
									<!-- <div class="medium-button button-short">Shop Now</div> -->
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- TRUSTED BRAND -->
	<div class="top-3-container">
		<div class="container">
			<div class="trusted-brand">
				<div class="title-container"></div>
				<div class="brand-container row clearfix">
					<div class="col-md-4">
						<div class="per-brand">
							<img src="/themes/{{ $shop_theme }}/img/shield-icon.png">
							<h1>TRUSTED</h1>
							<h2>
								Secured transactions
								Satisfaction Guaranteed
							</h2>
						</div>
					</div>
					<div class="col-md-4">
						<div class="per-brand">
							<img src="/themes/{{ $shop_theme }}/img/quality-icon.png">
							<h1>QUALITY PRODUCTS</h1>
							<h2>
								We assure that we provide the best
								protection and wuality at amazing prices. 
								This is the ultimate protection.
							</h2>
						</div>
					</div>
					<div class="col-md-4">
						<div class="per-brand">
							<img src="/themes/{{ $shop_theme }}/img/cart-icon.png">
							<h1>FAST SHIPPING</h1>
							<h2>
								Fast Delivery on all
								places locally
							</h2>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- COMPANY IMAGES -->
	<div class="mid-container">
		<div class="container">
			<div class="gallery-container">
				<div class="title-container">Company Images</div>
				<div class="image-container row-no-padding clearfix">
					<div class="col-md-4 col-padding-2">
						<div class="per-image-container"><img src="/themes/{{ $shop_theme }}/img/gallery-sample1.png" alt=""></div>
					</div>
					<div class="col-md-4 col-padding-2">
						<div class="per-image-container"><img src="/themes/{{ $shop_theme }}/img/gallery-sample2.png" alt=""></div>
					</div>
					<div class="col-md-4 col-padding-2">
						<div class="per-image-container"><img src="/themes/{{ $shop_theme }}/img/gallery-sample3.png" alt=""></div>
					</div>
					<div class="col-md-4 col-padding-2">
						<div class="per-image-container"><img src="/themes/{{ $shop_theme }}/img/gallery-sample4.png" alt=""></div>
					</div>
					<div class="col-md-4 col-padding-2">
						<div class="per-image-container"><img src="/themes/{{ $shop_theme }}/img/gallery-sample5.png" alt=""></div>
					</div>
					<div class="col-md-4 col-padding-2">
						<div class="per-image-container"><img src="/themes/{{ $shop_theme }}/img/gallery-sample6.png" alt=""></div>
					</div>
					<div class="col-md-4 col-padding-2">
						<div class="per-image-container"><img src="/themes/{{ $shop_theme }}/img/gallery-sample7.png" alt=""></div>
					</div>
					<div class="col-md-4 col-padding-2">
						<div class="per-image-container"><img src="/themes/{{ $shop_theme }}/img/gallery-sample8.png" alt=""></div>
					</div>
					<div class="col-md-4 col-padding-2">
						<div class="per-image-container"><img src="/themes/{{ $shop_theme }}/img/gallery-sample9.png" alt=""></div>
					</div>
				</div>
				<div class="link-container"><span>View All From The Gallery</span></div>
			</div>
		</div>
	</div>
	<!-- EVENTS -->
	<div class="mid-container-2">
		<div class="container">
			<div class="title-container">Events</div>
			<div class="events-container row-no-padding clearfix">
				<div class="col-md-8">
					<div class="per-event-container">
						<div class="per-event row clearfix">
							<div class="col-md-4">
								<div class="event-image-container">
									<img src="/themes/{{ $shop_theme }}/img/event1.png">
								</div>
							</div>
							<div class="col-md-8">
								<div class="event-details-container">
									<h1>
										Business & Product Presentation	
									</h1>
									<h2>
										July 27, 2017
									</h2>
								</div>
							</div>
						</div>
						<div class="per-event row clearfix">
							<div class="col-md-4">
								<div class="event-image-container">
									<img src="/themes/{{ $shop_theme }}/img/event2.png">
								</div>
							</div>
							<div class="col-md-8">
								<div class="event-details-container">
									<h1>
										Quezon City Main Office Opening 
										and Blessing	
									</h1>
									<h2>
										July 27, 2017
									</h2>
								</div>
							</div>
						</div>
						<div class="per-event row clearfix">
							<div class="col-md-4">
								<div class="event-image-container">
									<img src="/themes/{{ $shop_theme }}/img/event3.png">
								</div>
							</div>
							<div class="col-md-8">
								<div class="event-details-container">
									<h1>
										General Santos City Branch 
										Opening and Blessing	
									</h1>
									<h2>
										July 27, 2017
									</h2>
								</div>
							</div>
						</div>
					</div>
					<div class="link-container">
						<span>View All Events</span>
					</div>
				</div>
				<div class="col-md-4">
					<div class="fb-container">
						<div class="container-title-header">Facebook Fanpage</div>
						<div class="body-container">
							<div class="fb-page" data-href="https://www.facebook.com/3xcell.ph/" data-tabs="timeline" data-small-header="false" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true"><blockquote cite="https://www.facebook.com/3xcell.ph/" class="fb-xfbml-parse-ignore"><a href="https://www.facebook.com/3xcell.ph/">3xcell-E Sales &amp; Marketing Inc.</a></blockquote></div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- SUBSCRIBE -->	
	<div class="fullscreen background parallax" style="background-image: url('/themes/{{ $shop_theme }}/img/subscribe-bg3.png');" data-img-width="1366" data-img-height="400" data-diff="100">
		<div class="container">
			<div class="bot-container-1">
				<h1>Subscribe For Promos and Update</h1>
				<div class="input-container">
					<input class="subscribe-input" type="text" name="" placeholder="Email">
					<div class="subscribe-button">Subscribe</div>
				</div>
			</div>
		</div>
	</div>
	<!-- LIVE HEALTHY BE WEALTHY -->
	<div class="bot-container-2">
		<div class="container">
			<div class="content-container row clearfix">
				<div class="col-md-6">
					<div class="health-image-container">
						<img src="/themes/{{ $shop_theme }}/img/healthy-people.png">
					</div>
				</div>
				<div class="col-md-6">
					<div class="caption-container">
						<h1>Live Healthy, Be Wealthy!</h1>
						<p>
							Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem.
						</p>
					</div>
					<div class="join-button">
						<img src="/themes/{{ $shop_theme }}/img/join-icon.png"><span>JOIN US TODAY</span>
					</div>
				</div>
			</div>
		</div>
	</div>

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
	$('.single-item').slick({
		prevArrow:"<img class='a-left control-c prev slick-prev' src='/themes/{{ $shop_theme }}/img/arrow-left.png'>",
      	nextArrow:"<img class='a-right control-c next slick-next' src='/themes/{{ $shop_theme }}/img/arrow-right.png'>",
      	dots: false,
      	autoplay: true,
  		autoplaySpeed: 3000,
	});

	$('#myCarousel').carousel({
	interval: 5000
	})
    
    $('#myCarousel').on('slid.bs.carousel', function() {
    	//alert("slid");
	});

	$(".gallery-img-holder").click(function()
	{
		var source = $(this).find(".full-image").attr("path");
		$(".lightbox-target").find("img").attr("src", source);
	})

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
});
</script>
@endsection