@extends("layout")
@section("content")
<!-- OUR VALUES -->
<div class="content">
	{{-- <div class="top-bg-container">
		<img src="{{ get_content($shop_theme_info, "runruno", "runruno_banner_img") }}">
		<div class="top-bg-detail-container">{{ get_content($shop_theme_info, "runruno", "runruno_banner_title") }}</div>
	</div> --}}
	<div class="row clearfix content scroll-to">
		<div class="parallax background not-fullscreen" style="background-image: url('/themes/{{ $shop_theme }}/img/img-company-banner1.png');" data-img-width="1366" data-img-height="700" data-diff="100">
			
			<div class="container">
				<div class="company-banner-text">COMPANY</div>
			</div>

		</div>
		{{-- ABOUT US --}}
		<div class="container">
			<div class="about-us-container">
				<div class="text-header">ABOUT US</div>
				<div class="sub-text-header">Who We Are</div>
				<div><p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque<br>penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem.<br>Nulla consequat massa quis enim. Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. In enim justo, rhoncus ut, imperdiet<br>a, venenatis vitae, justo.</p></div>
			</div>
		</div>
		{{-- VISION MISSION --}}
		<div class="parallax background not-fullscreen" style="background-image: url('/themes/{{ $shop_theme }}/img/vision-mission1.png');" data-img-width="1366" data-img-height="700" data-diff="100">
			<div class="container">
				<div class="vision-mission-container row clearfix">
					<div class="col-md-6">
						<div class="col-md-3">
							<img src="/themes/{{ $shop_theme }}/img/img-vision-icon.png">
						</div>
						<div class="text-header">VISION</div>
						<div class="sub-text-header">Major Views</div>
						<div><p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.</p></div>
					</div>
					<div class="col-md-6">
						<div class="col-md-3">
							<img src="/themes/{{ $shop_theme }}/img/img-mission-icon.png">
						</div>
						<div class="text-header">MISSION</div>
						<div class="sub-text-header">Our Aims</div>
						<div><p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.</p></div>
					</div>
				</div>
			</div>
		</div>
		{{-- HISTORY --}}
		<div class="container">
			<div class="history-container row clearfix">
				<div class="col-md-6">
					<div class="text-header">OUR HISTORY</div>
					<div class="sub-text-header">Our Way of Success</div>
					<div><p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. </p></div>

					<div class="timeline">
						<div class="year">2013</div>
						<h5 class="what-happened">Company Formed</h5>
						<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Corporis, rem labore facere. Veritatis enim laborum facilis minima, illo ratione?</p>
					</div>

					<div class="timeline">
						<div class="year">2017</div>
						<h5 class="what-happened">Awards</h5>
						<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Vero, molestias numquam culpa, eligendi debitis dicta, hic delectus obcaecati accusantium quaerat magni explicabo et dolorem mollitia cumque sint deserunt. Labore vel magnam quasi.</p>
					</div>

				</div>

				<div class="col-md-6">
					<img src="/themes/{{ $shop_theme }}/img/our-history.png">
				</div>

			</div>
		</div>
		{{-- TEAM --}}
		<div style="background-image: url('/themes/{{ $shop_theme }}/img/mlm-bg-container.png');">
			
			<div class="container">
				<div class="team-container row clearfix">
					
					<div class="text-header">OUR TEAM</div>
					<div class="sub-text-header">Accumsan Cursus acus. Id Fermentum</div>
					<div class="img-container col-md-3">
						<img src="/themes/{{ $shop_theme }}/img/img-team.png">
						<div class="img-sub-container">
							<img class="img-zoom" src="/themes/{{ $shop_theme }}/img/team-face0.png">
						</div>
						<div class="name-container">
							<div class="bold-name">LOREM IPSUM</div>
							<div class="title-name">CEO and Founder</div>
						</div>
					</div>
					<div class="img-container col-md-3">
						<img src="/themes/{{ $shop_theme }}/img/img-team.png">
						<div class="img-sub-container">
							<img class="img-zoom" src="/themes/{{ $shop_theme }}/img/team-face1.png">
						</div>
						<div class="name-container">
							<div class="bold-name">LOREM IPSUM</div>
							<div class="title-name">Director of Investments</div>
						</div>
					</div>
					<div class="img-container col-md-3">
						<img src="/themes/{{ $shop_theme }}/img/img-team.png">
						<div class="img-sub-container">
							<img class="img-zoom" src="/themes/{{ $shop_theme }}/img/team-face2.png">
						</div>
						<div class="name-container">
							<div class="bold-name">LOREM IPSUM</div>
							<div class="title-name">Chief Officer</div>
						</div>
					</div>
					<div class="img-container col-md-3">
						<img src="/themes/{{ $shop_theme }}/img/img-team.png">
						<div class="img-sub-container">
							<img class="img-zoom" src="/themes/{{ $shop_theme }}/img/team-face3.png">
						</div>
						<div class="name-container">
							<div class="bold-name">LOREM IPSUM</div>
							<div class="title-name">Risk Analyst</div>
						</div>
					</div>
					<div class="btn-container">
						<button class="view-more-btn">VIEW MORE</button>
					</div>
				</div>
			</div>
		</div>
		{{-- CONTACT US --}}
		<div class="parallax background not-fullscreen" style="background-image: url('/themes/{{ $shop_theme }}/img/img-call.png');" data-img-width="1366" data-img-height="700" data-diff="100">
			<div class="container">
				<div class="contact-us-container row clearfix">
					<div class="col-md-12">
						<div class="contact-us-text">Let's talk Business</div>
						<div class="sub-text-header same-text-color">Esse pellentesque, ut sed vulputate.</div>
					</div>
					<div class="cursor col-md-6">
						<i class="fa fa-phone same-text-color" aria-hidden="true"></i>
						<p class="text-header same-text-color">CALL US NOW</p>
						<p class="sub-text-header">044-924-0022</p>
					</div>
					<div></div>
					<div class="cursor col-md-6">
						<i class="fa fa-envelope-o same-text-color" aria-hidden="true"></i>
						<p class="text-header same-text-color">SEND AN EMAIL</p>
						<p class="sub-text-header">you@email.com</p>
					</div>
				</div>
			</div>
		</div>
		<!-- SCROLL TO TOP -->
		<div class="scroll-up"><img src="/themes/{{ $shop_theme }}/img/scroll-up.png"></div>
	</div>
@endsection

@section("css")
<link rel="stylesheet" type="text/css" href="/themes/{{ $shop_theme }}/css/company.css">
@endsection

@section("js")

<script type="text/javascript" src="/themes/{{ $shop_theme }}/js/parallax.js"></script>

<script type="text/javascript">
$(document).on("click", '.nav-per-button', function()
{
	var id = $(this).attr("id");

	$(".nav-per-button").removeClass("active");
	$(".body-content .content").removeClass("active");
	$(".body-content .content").fadeOut();

	$(this).addClass("active");
	$(".body-content .content."+id).addClass("active");
	$(".body-content .content."+id).fadeIn();


});
</script>
<script type="text/javascript" src="/themes/{{ $shop_theme }}/js/sticky_side.js"></script>

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

    $('.img-zoom').hover(function() {
        $(this).addClass('transition');
 
    }, function() {
        $(this).removeClass('transition');
    });

    $(".per-img-container").click(function()
	{
		var source = $(this).find("img").attr("src");
		$(".lightbox-target").find("img").attr("src", source);
	})
});	

</script>
@endsection

