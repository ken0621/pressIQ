@extends("layout")
@section("content")
<!-- OUR VALUES -->
<div class="content">
	<div class="container-fluid">
		<!-- TOP BANNER -->
		<div class="top-bg-container">
			<img src="/themes/{{ $shop_theme }}/img/jobs-bg.png">
			<div class="top-bg-detail-container">
				<img src="/themes/{{ $shop_theme }}/img/jobs-logo.png">
			</div>
		</div>
		<!-- CONTENT -->
		<div class="row clearfix content">
			<!-- LEFT COLUMN -->
			<div class="col-md-8">
				<div class="content-title">
					JOB VACANCIES
				</div>
				<div class="title-caption">
					<p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.
					</p>
				</div>
				<div class="list-title-container">
					<img src="/themes/{{ $shop_theme }}/img/list-title-bg.png">
					<div class="list-title">Job List</div>
				</div>
				<!-- LIST CONTAINER -->
				<div class="list-container-holder">
					<div class="list-container">
						<div class="per-list">
							<div class="per-list-title"><a href="/job">Mining Engineer</a></div>
							<div class="per-list-description">
								Male or Female, Minimum of five (5) year) related experience. Lorem ipsum dolor sit amet, consectetuer adipiscing elit.
							</div>
							<div class="per-list-details">Date Posted: August 7, 2017</div>
							
						</div>
						<div class="per-list2">
							<div class="per-list-title"><a href="/job">Geoscience Coordinator</a></div>
							<div class="per-list-description">
								Male or Female, Minimum of five (5) year) related experience. Lorem ipsum dolor sit amet, consectetuer adipiscing elit.
							</div>
							<div class="per-list-details">Date Posted: August 7, 2017</div>
							
						</div>
						<div class="per-list">
							<div class="per-list-title"><a href="/job">Maintenance Mechanical Filter</a></div>
							<div class="per-list-description">
								Male or Female, Minimum of five (5) year) related experience. Lorem ipsum dolor sit amet, consectetuer adipiscing elit.
							</div>
							<div class="per-list-details">Date Posted: August 7, 2017</div>
							
						</div>
					</div>
				</div>
			</div>
			<!-- RIGHT COLUMN -->
			<div class="col-md-4">
				<!-- ATTACHED RESUME -->
				<div class="right-per-container">
					<div class="title-container">
						<div class="title">Let us find a job for you</div>
						<div class="details">Attached your resume directly to us</div>
					</div>
					<div class="img-container">
						<img src="/themes/{{ $shop_theme }}/img/find-job.png">
						<a href="#popup1"><div class="submit-button">SUBMIT RESUME</div></a>
					</div>
				</div>
				<!-- COMPANY PROFILE -->
				<div class="right-per-container">
					<div class="right-tab">
						<div class="title">Company Profile</div>
						<div class="details">Learn more about our company</div>
					</div>
					<div class="right-tab-content">
						<p>
						FCF Minerals Corporation (FCF) was incorporated in the 
						Philippines and was duly registered with the Philippine SEC 
						on December 3, 2001 to engage in continuing exploration, development and commercial operation of mineral claims with full power and authority to do any and all acts, things, business and activities which are related, incidental or conducive directly or indirectly to the attainment of the foregoing objectives as a mining company.
						</p>
					</div>
				</div>
				<!-- MAP -->
				<div class="right-per-container">
					<div class="title-container">
						<div class="title">Head Office Location</div>
						<div class="details">Walk-in applicatns are welcomed</div>
					</div>
					<div class="img-container">
						<img src="/themes/{{ $shop_theme }}/img/head-office.png">
						<a href="https://www.google.com.ph/maps/place/FCF+Minerals+Corporation+%2F+Metal+Exploration+Public+Limied+Company/@14.5615752,121.0156273,17z/data=!3m1!4b1!4m5!3m4!1s0x3397c909a1ec69eb:0x25b39d0024fa6ae!8m2!3d14.56157!4d121.017816" target="_blank"><div class="location-map-button">LOCATION MAP</div></a>
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
<link rel="stylesheet" type="text/css" href="/themes/{{ $shop_theme }}/css/jobs.css">
@endsection

@section("js")
<script type="text/javascript">

$(document).ready(function()
{
	/*scroll up*/
	$(window).scroll(function () {
        if ($(this).scrollTop() > 600) {
            $('.scroll-up').fadeIn();
        } else {
            $('.scroll-up').fadeOut();
        }
    });

    $('.scroll-up').click(function () {
        $("html, body").animate({
            scrollTop: 0
        }, 600);
        return false;
    });

    $(".per-img-container").click(function()
	{
		var source = $(this).find("img").attr("src");
		$(".lightbox-target").find("img").attr("src", source);
	})


});	

</script>
@endsection
