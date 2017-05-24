@extends("layout")
@section("content")
<!-- OUR VALUES -->
<div class="content">
	<div class="container-fluid">
		<div class="top-bg-container">
			<img src="/themes/{{ $shop_theme }}/img/contactus-bg.png">
			<div class="top-bg-detail-container"><span style="color: #ffc10e;">CONTACT</span> US</div>
		</div>
		<div class="row clearfix content">
		<!-- CONTENT -->
			<div class="content">
				<div class="col-md-6">
					<div class="title-container">
						Get Intouch With Us
					</div>
					<!-- TEXT FIELD -->
					<div class="textfield-container row clearfix">
						<div class="col-md-6">
								<input type="text" class="form-control" placeholder="First Name*">
						</div>
						<div class="col-md-6">
							<input type="text" class="form-control" placeholder="Last Name*">
						</div>
					</div>
					<div class="textfield-container row clearfix">
						<div class="col-md-6">
							<input type="text" class="form-control" placeholder="Phone Number*">
						</div>
						<div class="col-md-6">
							<input type="text" class="form-control" placeholder="Email Address*">
						</div>
					</div>
					<div class="textfield-container row clearfix">
						<div class="col-md-6">
							<input type="text" class="form-control" placeholder="Subject">
						</div>
					</div>
					<div class="textfield-container">
						<textarea style="max-width: 635px; min-height: 175px; max-height: 300px;" class="form-control" placeholder="Message" style="height: 180px;"></textarea>
					</div>
					<div class="textfield-container">
						<button>SEND</button>
					</div>
				</div>
				<div class="col-md-6">
					<div class="title-container">
						Location
					</div>
					<table>
						<tr>
							<td class="icon"><i class="fa fa-map-marker" aria-hidden="true"></i></td>
							<td class="par">22nd Floor, Salcedo Towers, 169 H.V. Dela Costa Street, Salcedo Village, Makati City, Metro Manila, Philippines</td>
						</tr>
						<tr>
							<td class="icon"><i class="fa fa-phone" aria-hidden="true"></i></td>
							<td class="par">+63 (0) 2 659 5662</td>
						</tr>
						<tr>
							<td class="icon"><i class="fa fa-envelope" aria-hidden="true"></td>
							<td class="par">youremailhere@company.com</td>
						</tr>
						<tr>
							<td class="icon"><i class="fa fa-fax" aria-hidden="true"></td>
							<td class="par">+63 (0) 2 846 8507</td>
						</tr>
					</table>
					<div>
						<div class="content-title business-hours">Business Hours</div>
						<table>
							<tr>
								<td class="icon"><i class="fa fa-clock-o" aria-hidden="true"></i></td>
								<td class="par">Monday - Friday at 9:00am - 6:00pm</td>
							</tr>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- SCROLL TO TOP -->
	<div class="scroll-up"><img src="/themes/{{ $shop_theme }}/img/scroll-up.png"></div>
</div>
<!-- GOOGLE MAP -->
<div class="map-title-container">
	<div class="container-fluid">
		Find Us on Map
	</div>	
</div>
<div class="google-map">
	<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3861.6574693261337!2d121.01562731520293!3d14.561569989827394!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3397c909a1ec69eb%3A0x25b39d0024fa6ae!2sFCF+Minerals+Corporation+%2F+Metal+Exploration+Public+Limied+Company!5e0!3m2!1sen!2sph!4v1475633906034" allowfullscreen></iframe>
</div>

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


});	

</script>
@endsection

@section("css")
<link rel="stylesheet" type="text/css" href="/themes/{{ $shop_theme }}/css/contactus.css">
@endsection

