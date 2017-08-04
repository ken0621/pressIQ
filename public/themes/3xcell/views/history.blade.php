@extends("layout")
@section("content")
<div class="content">
	<div class="top-1-container">
		<div class="container">
			<div class="title-container">Our History</div>
		</div>
	</div>
	<div class="top-2-container">
		<div class="container">
			<div class="top-2-content-container row clearfix">
				<div class="col-md-8">
					<div class="title-container">About 3XCELL</div>
					<div class="top-2-content">
						<p>
							It was in 2004 when the principal incorporator of the company, who is then and now into logistics and trading business started joining network marketing companies. He has seen the beauty of how a network of people worked together to attain a company’s goal with the freedom of time and financial entitlement.<br><br>

							From this experience blossomed the concept of 3xcell-E Sales & Marketing Inc. Through time, studies and research looking for health products with the most benefit and affordability to many made a part of his daily and nightly routine.<br><br>

							A heart and care for the people working to attain success and sustain longevity of a company is his prime motivator as he has seen through experience how a networker would jump in and out of one company to another. Believing to change the face of network marketing from its traditional ways and practices, 3xcell-E has formulated a breakthrough of its own market introduction.<br><br>

							3xcell-E Sales & Marketing Inc. is composed of five dynamic individuals who share the same motivation and common values strengthened and lead by their principal incorporator.<br><br>

							Formally organized in October 2015, 3xcell-E believed that it is the best way to provide additional opportunities to its circle of peers and employees and extend further to others.
						</p>
					</div>
				</div>
				<div class="col-md-4">
					<div class="img-container">
						<img src="/themes/{{ $shop_theme }}/img/founder-img.png">
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- VISION MISION -->
	<div class="mid-container" style="background-image: url('/themes/{{ $shop_theme }}/img/vision-mission-img.png')">
		<div class="container">
			<div class="mid-content row clearfix">
				<div class="col-md-6">
					<div class="mid-content-single">
						<div class="title-container row clearfix">
							<div class="col-sm-4"><i class="fa fa-binoculars" aria-hidden="true" style="color: white; font-size: 35px;"></i></div>
							<div class="col-sm-8">
								<h1>VISION</h1>
								<h2>Major Views</h2>
							</div>
						</div>
						<div class="detail-container">
							To be an instrument of inspiration to others through the knowledge of leveraging time, money and effort.
						</div>			
					</div>
				</div>
				<div class="col-md-6">
					<div class="mid-content-single">
						<div class="title-container row clearfix">
							<div class="col-sm-4"><i class="fa fa-rocket" aria-hidden="true" style="color: white; font-size: 35px;"></i></div>
							<div class="col-sm-8">
								<h1>MISSION</h1>
								<h2>Our Aims</h2>
							</div>
						</div>
						<div class="detail-container">
							To influence and empower others in achieving goal to be healthy and wealthy with the freedom of time especially in today’s very crowded populace.
						</div>			
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- 3XCELL PERMITS -->
	<div class="bot-container">
		<div class="container">
			<div class="title-container">
				3XCELL Permits
				<div class="line-bot"></div>
			</div>
			<div class="bot-content row clearfix">
				<div class="col-md-2">
					<div class="img-container">
						<img src="/themes/{{ $shop_theme }}/img/permit1.png">
					</div>
				</div>
				<div class="col-md-2">
					<div class="img-container">
						<img src="/themes/{{ $shop_theme }}/img/permit2.png">
					</div>
				</div>
				<div class="col-md-2">
					<div class="img-container">
						<img src="/themes/{{ $shop_theme }}/img/permit3.png">
					</div>
				</div>
				<div class="col-md-2">
					<div class="img-container">
						<img src="/themes/{{ $shop_theme }}/img/permit4.png">
					</div>
				</div>
				<div class="col-md-2">
					<div class="img-container">
						<img src="/themes/{{ $shop_theme }}/img/permit5.png">
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
<link rel="stylesheet" type="text/css" href="/themes/{{ $shop_theme }}/css/history.css">
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
});
</script>
@endsection