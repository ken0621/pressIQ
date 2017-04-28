@extends("layout")
@section("content")
<div class="about">
	<div class="intro" style="background-image: url('/themes/{{ $shop_theme }}/img/company-bg.jpg');">
		<div class="holder container">
			<div class="text">
				<div class="blue text-holder">LIVE</div>
				<div></div>
				<div class="orange text-holder">WITHOUT</div>
				<div></div>
				<div class="green text-holder">LIMITS</div>
			</div>
		</div>
	</div>
	<div class="main">
		<div class="container">
			<div class="row clearfix">
				<div class="col-md-4">
					<div class="holder">
						<h2>About Us</h2>
						<p>We are an International direct advertising company from multiple sources of business enterprise formed to create partners all across the world. Companies in the Network Marketing Industry today are creating vast opportunities in line with wellness products for people to form a concrete Global Business Opportunity. We believe that financial education will improve the quality of life for people in the world, and we strive in becoming a global knowledge enterprise. Developing high quality health & wealth creation products, and to shift common paradigms through education, research and service.</p>
					</div>
				</div>
				<div class="col-md-4">
					<div class="holder">
						<h2>How do you ear money?</h2>
						<p>We offer one of the Strongest Compensations plans in the Industry with Multiple Ways to Earn Weekly and Monthly Income!</p>
					</div>
					<div class="holder">
						<h2>Company Initiatives</h2>
						<div class="image">
							<img src="/themes/{{ $shop_theme }}/img/car.jpg">
						</div>
					</div>
				</div>
				<div class="col-md-4">
					<div class="holder contact">
						<h2>Contact Information</h2>
						<table>
							<tbody>
								<tr>
									<td><i class="fa fa-map-marker" aria-hidden="true"></i></td>
									<td><span>8/F Wong Hing Building 74-78 Stanley Street, Central Hong Kong</span></td>
								</tr>
								<tr>
									<td><i class="fa fa-envelope-o" aria-hidden="true"></i></td>
									<td><span>info@youremail.com</span></td>
								</tr>
								<tr>
									<td><i class="fa fa-phone" aria-hidden="true"></i></td>
									<td><span>(+852) 9472 6184 / (+852) 9145 7698</span></td>
								</tr>
								<tr>
									<td><i class="fa fa-mobile" aria-hidden="true"></i></td>
									<td><span>+63997 000 0000</span></td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection

@section("css")
<link rel="stylesheet" type="text/css" href="/themes/{{ $shop_theme }}/css/aboutus.css">
@endsection
