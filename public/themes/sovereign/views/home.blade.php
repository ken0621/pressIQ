@extends("layout")
@section("content")
<div class="intro" style="background-image: url('/themes/{{ $shop_theme }}/img/intro-bg.jpg')">
	<div class="container">
		<div class="text">
			<div class="title">WELCOME TO</div>
			<div></div>
			<div class="desc">
				<div class="first-line">SOVEREIGN</div>
				<div class="second-line">WORLD CORPORATION</div>
				<div class="objective">Our objective is to share with you a system that is proven, tested and has changed lives of millions of people like you.</div>
				<button class="btn btn-learn">Learn More</button>
			</div>
		</div>
	</div>
</div>
<div class="company">
	<div class="container">
		<ul class="nav nav-tabs">
			<li class="active"><a data-toggle="tab" href="#company">Company</a></li>
			<li><a data-toggle="tab" href="#mission">Mission</a></li>
			<li><a data-toggle="tab" href="#vision">Vision</a></li>
		</ul>
		<div class="tab-content">
			<div id="company" class="tab-pane fade in active">
				<div class="row clearfix">
					<div class="col-md-8">
						<h1>Who We Are</h1>
						<p>We are an International direct advertising company from multiple sources of business enterprise formed to create partners all across the world. Companies in the Network Marketing Industry today are creating vast opportunities in line with wellness products for people to form a concrete Global Business Opportunity.</p>
						<div class="read-more">
							<a href="/about">Read More</a>
						</div>
					</div>
					<div class="col-md-4">
						<img class="img-reponsive" src="/themes/{{ $shop_theme }}/img/company-side.jpg">
					</div>
				</div>
			</div>
			<div id="mission" class="tab-pane fade">
				<div class="row clearfix">
					<div class="col-md-8">
						<h1>Company Mission</h1>
						<p>To serve the community and its people by providing opportunity for good health and abundant life. And inspire people to help others make a positive change in their lives.</p>
						<div class="read-more">
							<a href="/about">Read More</a>
						</div>
					</div>
					<div class="col-md-4">
						<img class="img-reponsive" src="/themes/{{ $shop_theme }}/img/mission-side.jpg">
					</div>
				</div>
			</div>
			<div id="vision" class="tab-pane fade">
				<div class="row clearfix">
					<div class="col-md-8">
						<h1>Company Vision</h1>
						<p>To be the trademark in the field of health nutrition, business education and service to the community thru its outstanding products made available for entrepreneurs worldwide.</p>
						<div class="read-more">
							<a href="/about">Read More</a>
						</div>
					</div>
					<div class="col-md-4">
						<img class="img-reponsive" src="/themes/{{ $shop_theme }}/img/vision-side.jpg">
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="values" style="background-image: url('/themes/{{ $shop_theme }}/img/values-bg.jpg')">
	<div class="container">
		<div class="row clearfix">
			<div class="col-md-6 left-holder match-height">
				<div class="holder">
					<div class="values-title">Company Core Values</div>
					<div class="divider"></div>
					<div class="values-sub">-Inspired by "Coach Wooden"</div>
				</div>
			</div>
			<div class="col-md-6 match-height">
				<div class="tower">
					<div class="tower-row">
						<div class="holder">
							<div class="name">Excellence</div>
							<div class="desc">Performing at your highest level</div>
						</div>
					</div>
					<div class="tower-row">
						<div class="holder">
							<div class="name">Character</div>
							<div class="desc">The qualities that distinguish individuals</div>
						</div>
						<div class="holder">
							<div class="name">Integrity</div>
							<div class="desc">The faithfulness to maintain high moral standards</div>
						</div>
					</div>
					<div class="tower-row">
						<div class="holder">
							<div class="name">Team Work</div>
							<div class="desc">Subordinating personal prominence to team efficiency</div>
						</div>
						<div class="holder">
							<div class="name">Communication</div>
							<div class="desc">The ingredient to organizational success</div>
						</div>
						<div class="holder">
							<div class="name">Collaboration</div>
							<div class="desc">The willingness to jointly achieve common goals</div>
						</div>
					</div>
					<div class="tower-row">
						<div class="holder">
							<div class="name">Attitude</div>
							<div class="desc">Energy, drive and enjoyment will always inspire others</div>
						</div>
						<div class="holder">
							<div class="name">Discipline</div>
							<div class="desc">Energy, drive and enjoyment will always inspire others</div>
						</div>
						<div class="holder">
							<div class="name">Initiative</div>
							<div class="desc">Failure to act will lead to the biggest failures of all</div>
						</div>
						<div class="holder">
							<div class="name">Work Ethic</div>
							<div class="desc">Success travels in the company of very hard work and dedication</div>
						</div>
					</div>
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

@endsection