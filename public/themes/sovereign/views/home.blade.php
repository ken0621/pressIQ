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
				
			</div>
			<div id="vision" class="tab-pane fade">
				
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