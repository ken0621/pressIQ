@extends("layout")
@section("content")

<div class="content">
	<!-- HOME SLIDESHOW -->
	<div class="slider-container">
		<div class="slider1">
			<img class="image" src="/themes/{{ $shop_theme }}/img/slider-banner2.png">
			<div class="container">
				<div class="slider-caption">
					<div class="slider-caption-text">THE BEST FOR</div>
					<div class="slider-caption-sub-text">YOUR BUSINESS</div>
				</div>
			</div>
			<div class="slider-title-container" style="background-image: url('/themes/{{ $shop_theme }}/img/slider-details-bg.png');" data-img-width="1366" data-img-height="700" data-diff="100">
				<div class="container">
					<div class="row clearfix">
						<div class="col-md-9">
							<div class="slider-details">
								<div class="slider-text">The fastest way to grow your business with the leader in investments.</div>
								<div class="slider-sub-text">Learn more about our strategy &nbsp &nbsp <i class="fa fa-long-arrow-right" aria-hidden="true"></i></div>
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

{{-- TOP CONTAINER --}}
<div class="top-container">
	<div class="container">

		<div class="tabs">
		  <button class="tablinks"></button>
		  <button class="tablinks tab-middle"></button>
		  <button class="tablinks"></button>
		</div>

		<div class="row clearfix">
			<div class="col-md-9">
				<div class="text-header">Lorem ipsum dolor</div>
					<div>
						<p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor.<br>Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur<br>ridiculus mus.
						</p>
					</div>
				<div class="btn-container">
					<button class="read-more-btn2">Read More</button>
				</div>
			</div>

			<div class="col-md-3">
				<img src="/themes/{{ $shop_theme }}/img/img-circle1.png">
			</div>

		</div>
	</div>
</div>
 
{{-- MID CONTAINER 1 --}}
<div class="mid-container1">
	<div class="parallax background not-fullscreen" style="background-image: url('/themes/{{ $shop_theme }}/img/mission-vision-coreval.png');" data-img-width="1366" data-img-height="700" data-diff="100">
		
		<div class="container">

			<div class="mid-container1-content row clearfix">

				<div class="col-md-12">

					<div>
						<a id="mission" class="text-header-links">Mission&nbsp&nbsp</a>
						<a id="vision" class="text-header-links">Vision&nbsp&nbsp</a>
						<a id="core-values" class="text-header-links">Core Values</a>
					</div>

					<div>
						<p class="mvc">Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo<br>ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis<br>parturient montes, nascetur ridiculus mus.</p>
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
<section class="mid-container2">
	<div class="container">
		<div class="row clearfix">
			<div class="col-md-6">
				<div class="text-header">Lorem Ipsum Dolor Sit Amet</div>
				<div class="mid-container2-texts">
					<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Fuga suscipit ab quia qui maxime maiores sapiente placeat doloremque natus porro, ipsam reprehenderit laborum id officiis eum cupiditate dolorum ipsum itaque!</p>
				</div>
				<div class="btn-container">
					<button class="see-all-btn">See All</button>
				</div>
			</div>

			<div class="img-gallery-container col-md-6">
				<div>
					<a href="#"><img class="img-zoom" src="/themes/{{ $shop_theme }}/img/gallery-img1.png"></a>
					<a href="#"><img class="img-zoom" src="/themes/{{ $shop_theme }}/img/gallery-img1.png"></a>
					<a href="#"><img class="img-zoom" src="/themes/{{ $shop_theme }}/img/gallery-img1.png"></a>
					<a href="#"><img class="img-zoom" src="/themes/{{ $shop_theme }}/img/gallery-img1.png"></a>
					<a href="#"><img class="img-zoom" src="/themes/{{ $shop_theme }}/img/gallery-img1.png"></a>
					<a href="#"><img class="img-zoom" src="/themes/{{ $shop_theme }}/img/gallery-img1.png"></a>
				</div>
			</div>
		</div>
	</div>
</section>

{{-- TESTIMONIALS --}}
<div class="testimonials">
	<div style="background-image: url('/themes/{{ $shop_theme }}/img/testimonials.png');">
		<div class="container">
			<div class="text-header">What People Say</div>
			<div class="testimonial-img-container row clearfix">

				<section class="autoplay slider">

					<div class="img-container">
						<div class="my-style">
							<div class="comments">
								<p><i class="fa fa-quote-left" aria-hidden="true"></i>  Ut id praesent. Egestas lacinia. Feugiat magna, vel adipiscing non, vehicula eu pharetra.  <i class="fa fa-quote-right" aria-hidden="true"></i></p>
							</div>
						</div>

						<div class="img-sub-container">
							<img src="/themes/{{ $shop_theme }}/img/img2-testimonial.png">
						</div>
						<div class="name-container">
							<div class="bold-name">Mr. Lorem Ipsum</div>
							<div class="title-name">Lorem ipsum dolor</div>
						</div>
					</div>

					<div class="img-container">
						<div class="my-style">
							<div class="comments">
								<p><i class="fa fa-quote-left" aria-hidden="true"></i>  Ut id praesent. Egestas lacinia. Feugiat magna, vel adipiscing non, vehicula eu pharetra.  <i class="fa fa-quote-right" aria-hidden="true"></i></p>
							</div>
						</div>

						<div class="img-sub-container">
							<img src="/themes/{{ $shop_theme }}/img/img4-testimonial.png">
						</div>
						<div class="name-container">
							<div class="bold-name">Mr. Lorem Ipsum</div>
							<div class="title-name">Lorem ipsum dloor</div>
						</div>
					</div>

					<div class="img-container">
						<div class="my-style">
							<div class="comments">
								<p><i class="fa fa-quote-left" aria-hidden="true"></i>  Ut id praesent. Egestas lacinia. Feugiat magna, vel adipiscing non, vehicula eu pharetra.  <i class="fa fa-quote-right" aria-hidden="true"></i></p>
							</div>
						</div>

						<div class="img-sub-container">
							<img src="/themes/{{ $shop_theme }}/img/img3-testimonial.png">
						</div>
						<div class="name-container">
							<div class="bold-name">Mr. Lorem Ipsum</div>
							<div class="title-name">Lorem ipsum dolor</div>
						</div>
					</div>

					<div class="img-container">
						<div class="my-style">
							<div class="comments">
								<p><i class="fa fa-quote-left" aria-hidden="true"></i>  Ut id praesent. Egestas lacinia. Feugiat magna, vel adipiscing non, vehicula eu pharetra.  <i class="fa fa-quote-right" aria-hidden="true"></i></p>
							</div>
						</div>

						<div class="img-sub-container">
							<img src="/themes/{{ $shop_theme }}/img/img4-testimonial.png">
						</div>
						<div class="name-container">
							<div class="bold-name">Mr. Lorem Ipsum</div>
							<div class="title-name">Lorem ipsum dolor</div>
						</div>
					</div>

				</section>
			</div>
		</div>
	</div>
</div>{{-- END OF TESTIMONIALS --}}

{{-- PRE-FOOTER --}}
<div class="pre-footer">
    <div class="parallax background not-fullscreen" style="background-image: url('/themes/{{ $shop_theme }}/img/img-home-hq.png');" data-img-width="1366" data-img-height="700" data-diff="100">
        
        <div class="container">

            <div class="logo">
                <img src="/themes/{{ $shop_theme }}/img/default-logo2.png">
            </div>

            <div class="row clearfix">
                <div class="col-md-6">
                    <a href="#"><u>He</u>ad Quarters</a>
                </div>

                <div class="col-md-6">
                    <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.</p>
                </div>
            </div>
            
        </div>
    </div>
</div>

@endsection 	

@section("css")
<link rel="stylesheet" type="text/css" href="/themes/{{ $shop_theme }}/css/home.css">

<link rel="stylesheet" type="text/css" href="/themes/{{ $shop_theme }}/assets/slick/slick.css">
<link rel="stylesheet" type="text/css" href="/themes/{{ $shop_theme }}/assets/slick/slick-theme.css">

@endsection

@section("js")

<script src="https://code.jquery.com/jquery-2.2.0.min.js" type="text/javascript"></script>
<script type="text/javascript" src="/themes/{{ $shop_theme }}/assets/slick/slick.min.js"></script>
<script type="text/javascript" src="/themes/{{ $shop_theme }}/assets/slick/slick.js"></script>
<script type="text/javascript" src="/themes/{{ $shop_theme }}/js/parallax.js"></script>

<script>

$(document).ready(function(){

    $("#mission").click(function(){
        $(".mvc").html("Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo<br>ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis<br>parturient montes, nascetur ridiculus mus.");
    });

    $("#vision").click(function(){
        $(".mvc").html("Pellentesque erat, in augue. Mollis viverra quam, sodales urna amet,<br>nibh dolor. At vel, leo iaculis, mollis consequat. Amet justo ligula.<br>Justo est placerat, id dolor, consectetuer rutrum. Ut arcu.");
    });

    $("#core-values").click(function(){
        $(".mvc").html("Felis ac, elementum ligula diam, ut sit porttitor.<br>Suspendisse elit vestibulum, a vitae at. Ut pellentesque, nonummy vitae nonummy.<br>Volutpat diam, tellus imperdiet. Lorem nullam, tortor dui.");
    });

});

</script>

{{-- image-zoom --}}
<script type="text/javascript">
	$(document).ready(function(){
		$('.img-zoom').hover(function() {
			$(this).addClass('transition');

		}, function() {
			$(this).removeClass('transition');
		});
	});
</script>{{-- end of img-zoom --}}


<script type="text/javascript">
$(document).ready(function()
{
/*	$('.autoplay').slick({
		prevArrow:"<img class='a-left control-c prev slick-prev' src='/themes/{{ $shop_theme }}/img/arrow-left.png'>",
      	nextArrow:"<img class='a-right control-c next slick-next' src='/themes/{{ $shop_theme }}/img/arrow-right.png'>",
      	slidesToShow: 3,
      	slidesToScroll: 1,
      	dots: true,
      	autoplay: true,
  		autoplaySpeed: 3000,
	});*/

	$('.autoplay').slick({
		slidesToShow: 3,
		slidesToScroll: 1,
		dots: true,
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