@extends("layout")
@section("content")

<div class="content">
	<!-- HOME SLIDESHOW -->
	<div class="slider-container">
		<div>
			<div class="slider">
				<img class="image" src="/themes/{{ $shop_theme }}/img/slider-banner1.png">
				
				<div class="slider-details-bg"></div>

				<div class="slider-caption">
					<div class="slider-text">THE BEST FOR</div>
					<div class="slider-text-sub">YOUR BUSINESS</div>
				</div>

				<div class="slider-title-container" style="background-image: url('/themes/{{ $shop_theme }}/img/slider-details-bg.png');">
					<div class="container">
						<div class="row clearfix">
							<div class="col-md-9">
								<div class="slider-details">
									<div class="slider-title">The fastest way to grow your business with the leader in investments.</div>
									<div class="slider-title-details">Learn more about our strategy &nbsp &nbsp <i class="fa fa-long-arrow-right" aria-hidden="true"></i></div>
								</div>
							</div>
							<div class="col-md-3">
								<div class="btn-container">
									<button class="read-more-btn1">READ MORE</button>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

{{-- TOP CONTAINER --}}
<div class="top-container">
	<div class="container">
		<div class="tab">
		  <button class="tablinks"></button>
		  <button class="tablinks"></button>
		  <button class="tablinks"></button>
		  <button class="tablinks"></button>
		</div>

		<div class="row clearfix">
			<div class="col-md-9">
				<div class="top-container-text-header">Lorem ipsum dolor</div>
					<div class="top-container-text-content">
						<p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor.<br>Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur<br>ridiculus mus.
						</p>
					</div>
				<div class="btn-container">
					<button class="read-more-btn2">Read More</button>
				</div>
			</div>

			<div class="col-md-3 img-innov">
				<img src="/themes/{{ $shop_theme }}/img/innovation.png">
			</div>
		</div>
	</div>
</div>
 
{{-- MID CONTAINER 1 --}}
<div class="mid-container1">
	<div style="background-image: url('/themes/{{ $shop_theme }}/img/mid-container.png');">
		
		<div class="container">

			<div class="mid-container1-content row clearfix">

				<div class="col-md-12">

					<div>
						<a class="mid-container1-links" href="#">Mission&nbsp&nbsp</a>
						<a class="mid-container1-links" href="#">Vision&nbsp&nbsp</a>
						<a class="mid-container1-links" href="#">Core Values</a>
					</div>

					<div>
						Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo<br>ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis<br>parturient montes, nascetur ridiculus mus.
					</div>

					<div class="btn-container">
						<button class="read-more-btn3">Read More</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

{{-- MID CONTAINER 2 --}}
<div class="mid-container2">
	<div class="container">
		<div class="row clearfix">
			<div class="col-md-9">
				<div class="mid-container2-header">Be Healthy and Live Wealthy</div>
					<div class="mid-container2-texts">
						<p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo<br>ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis<br>parturient montes, nascetur ridiculus mus.
						</p>
					</div>
				<div class="btn-container">
					<button class="see-all-btn">See All</button>
				</div>
			</div>
		</div>
	</div>
</div>

{{-- TESTIMONIALS --}}
<div class="testimonials">
	<div style="background-image: url('/themes/{{ $shop_theme }}/img/testimonials.png');">

		<div class="container">

			<p class="head">What People Say</p>

			<div class="testimonial-img-container1 row clearfix">
				<div class="col-md-4">
					<img src="/themes/{{ $shop_theme }}/img/img-testimonial1.png">
				</div>

				<div class="col-md-4">
					<img src="/themes/{{ $shop_theme }}/img/img-testimonial1.png">
				</div>

				<div class="col-md-4">
					<img src="/themes/{{ $shop_theme }}/img/img-testimonial1.png">
				</div>
			</div>

			<div class="testimonial-img-container2 row clearfix">
			
				<div class="col-md-4">
					<img src="/themes/{{ $shop_theme }}/img/img-testimonial2.png">
					<p>Mr. Lorem Ipsum</p>
				</div>

				<div class="col-md-4">
					<img src="/themes/{{ $shop_theme }}/img/img-testimonial2.png">
					<p>Mr. Lorem Ipsum</p>
				</div>

				<div class="col-md-4">
					<img src="/themes/{{ $shop_theme }}/img/img-testimonial2.png">
					<p>Mr. Lorem Ipsum</p>
				</div>
			</div>

		</div>
	</div>
</div>

@endsection 	

@section("css")
<link rel="stylesheet" type="text/css" href="/themes/{{ $shop_theme }}/css/home.css">
@endsection

@section("js")
<script type="text/javascript">
$(document).ready(function()
{
	$('.slider-container').slick({
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