@extends("layout")
@section("content")

<!-- TOP CONTENT -->
<div class="top-content">
	<div class="container">
		<div class="row clearfix">
			<div class="col-md-6 image-holder">
				<img src="/themes/{{ $shop_theme }}/img/about-us-image.png">
			</div>
			<div class="col-md-6 content-holder">
				<div class="content-title">WELCOME TO<span id="tech"> TECH</span>SIDE<span id="electronics"> ELECTRONICS</span></div>
				<div class="content-sub">Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim. Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. In enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo.</div>
				<div class="content-sub">Nullam dictum felis eu pede mollis pretium. Integer tincidunt. Cras dapibus. Vivamus elementum semper nisi. Aenean vulputate eleifend tellus. Aenean leo ligula, porttitor eu, consequat vitae, eleifend ac, enim.</div>
			</div>
		</div>
	</div>
</div>

<div class="strategy">
	<div class="container">
		<div class="row clearfix">
			<div class="col-md-4">
				<div class="title"><img src="/themes/{{ $shop_theme }}/img/check.png"> MISSION</div>
				<div class="sub-title">Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor.</div>
			</div>
			<div class="col-md-4">
				<div class="title"><img src="/themes/{{ $shop_theme }}/img/check.png"> VISION</div>
				<div class="sub-title">Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.</div>
			</div>
			<div class="col-md-4">
				<div class="title"><img src="/themes/{{ $shop_theme }}/img/check.png"> CORE VALUES</div>
				<div class="sub-title">Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.</div>
			</div>
		</div>
	</div>
</div>

<div class="our-team">
	<div class="container">

		<div class="title">MEET OUR <span>TEAM</span></div>

		<div class="row clearfix team-details">
			<div class="col-md-3 person-details">
				<div class="person-image"><img src="/themes/{{ $shop_theme }}/img/our-team-image1.png"></div>
				<div class="person-name">Lorem Ipsum Dolor</div>
				<div class="person-position">Lorem Ipsum</div>
			</div>
			<div class="col-md-3 person-details">
				<div class="person-image"><img src="/themes/{{ $shop_theme }}/img/our-team-image2.png"></div>
				<div class="person-name">Lorem Ipsum Dolor</div>
				<div class="person-position">Lorem Ipsum</div>
			</div>
			<div class="col-md-3 person-details">
				<div class="person-image"><img src="/themes/{{ $shop_theme }}/img/our-team-image3.png"></div>
				<div class="person-name">Lorem Ipsum Dolor</div>
				<div class="person-position">Lorem Ipsum</div>
			</div>
			<div class="col-md-3 person-details">
				<div class="person-image"><img src="/themes/{{ $shop_theme }}/img/our-team-image4.png"></div>
				<div class="person-name">Lorem Ipsum Dolor</div>
				<div class="person-position">Lorem Ipsum</div>
			</div>
		</div>
	</div>
</div>




<!-- BOTTOM CONTENT -->
	
@endsection

@section("css")
<link rel="stylesheet" type="text/css" href="/themes/{{ $shop_theme }}/css/aboutus.css">
@endsection
