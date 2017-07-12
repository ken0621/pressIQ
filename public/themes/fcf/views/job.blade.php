@extends("layout")
@section("content")
<!-- OUR VALUES -->
<div class="content">
	<div class="container-fluid">
		<!-- TOP BANNER -->
		<div class="top-bg-container">
			<img src="/themes/{{ $shop_theme }}/img/job-bg.png">
			<div class="top-bg-detail-container">
				<img src="/themes/{{ $shop_theme }}/img/jobs-logo.png">
			</div>
		</div>
		<!-- CONTENT -->
		<div class="row clearfix">
			<!-- LEFT COLUMN -->
			<div class="col-md-8">
				<div class="left-top-container">
					<div class="top-title">MINING ENGINEER</div>
					<div class="row clearfix">
						<div class="col-md-6">
							<div class="job-details-container">
								<p>
									Male or Female, Bachelor degree in Mining Engineering, Proficient in Mine Software such as SURPAC, Auto CAD and other related Mine Software, Minimum of five (5) year) related experience.
								</p>
								<div class="min-title">
									Job Description
								</div>
								<p>
									Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.<br><br> 
									Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim. Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu.
								</p>
							</div>
						</div>
						<div class="col-md-6">
							<div class="job-image-container">
								<img src="/themes/{{ $shop_theme }}/img/job-image.png">
							</div>
						</div>
					</div>
				</div>
				<div class="row-no-padding clearfix">
					<div class="col-md-6">
						<div class="left-top-container container-min">
							<div class="min-title">
								Application Details
							</div>
							<ul>
								<li>
									Lorem ipsum dolor sit amet, consectetuer adipiscing elit.
								</li>
								<li>
									Lorem ipsum dolor
								</li>
								<li>
									Aenean imperdiet. Etiam ultricies nisi vel augue.
								</li>
								<li>
									Maecenas nec odio et ante tincidunt tempus.
								</li>
								<li>
									Donec sodales sagittis magna. 
								</li>
								<li>
									Sed consequat, leo eget bibendum sodales
								</li>
							</ul>
						</div>
					</div>
					<div class="col-md-6">
						<div class="left-top-container container-min">
							<div class="min-title">
								Company Compensation
							</div>
							<ul>
								<li>
									Lorem ipsum dolor sit amet, consectetuer adipiscing elit.
								</li>
								<li>
									Lorem ipsum dolor
								</li>
								<li>
									Aenean imperdiet. Etiam ultricies nisi vel augue.
								</li>
								<li>
									Maecenas nec odio et ante tincidunt tempus.
								</li>
								<li>
									Donec sodales sagittis magna. 
								</li>
								<li>
									Sed consequat, leo eget bibendum sodales
								</li>
							</ul>
						</div>
					</div>
				</div>
			</div>
			<!-- RIGHT COLUMN -->
			<div class="col-md-4">
				<div class="left-top-container">
					<!-- PER ICON -->
					<div class="right-col-content row clearfix">
						<div class="col-md-2">
							<div class="icon-holder">
								<img src="/themes/{{ $shop_theme }}/img/icon-bg.png">
								<i class="fa fa-money" aria-hidden="true"></i>
							</div>
						</div>
						<div class="col-md-10">
							<div class="icon-caption">
								<span style="color: #004b6e; font-weight: bold;">Salary:&nbsp;</span><span>PHP 20,000 - PHP 25,000</span>
							</div>
						</div>
					</div>
					<div class="right-col-content row clearfix">
						<div class="col-md-2">
							<div class="icon-holder">
								<img src="/themes/{{ $shop_theme }}/img/icon-bg.png">
								<i class="fa fa-briefcase" aria-hidden="true"></i>
							</div>
						</div>
						<div class="col-md-10">
							<div class="icon-caption">
								<span style="color: #004b6e; font-weight: bold;">Work Experience:&nbsp;</span><span>3-5 yrs Experience</span>
							</div>
						</div>
					</div>
					<div class="right-col-content row clearfix">
						<div class="col-md-2">
							<div class="icon-holder">
								<img src="/themes/{{ $shop_theme }}/img/icon-bg.png">
								<i class="fa fa-map-marker" aria-hidden="true"></i>
							</div>
						</div>
						<div class="col-md-10">
							<div class="icon-caption">
								<span style="color: #004b6e; font-weight: bold;">Work Location:&nbsp;</span><span>Lorem Ipsum</span>
							</div>
						</div>
					</div>	
				</div>
				<!-- APPLY BUTTON -->
				<div class="left-top-container apply-container row-no-padding clearfix">
					<div class="col-md-6">
						<span>This Job suits me.</span>
					</div>
					<div class="col-md-6">
						<a href="#popup1"><div class="apply-button">APPLY NOW</div></a>
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
<link rel="stylesheet" type="text/css" href="/themes/{{ $shop_theme }}/css/job.css">
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
