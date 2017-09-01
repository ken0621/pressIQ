@extends("layout")
@section("content")
<div class="about-image">
	<img src="/themes/{{ $shop_theme }}/front/about.jpg">
</div>
<div class="content">
	<div class="info">
		@if(isset($_about))
		@foreach($_about as $key => $abt)
		<div class="about-title">
			{!!$abt['title']!!}
		</div>
		<div class="container about-desc">
			{!!$abt['content']!!}
		</div>
		<Br>
		@endforeach
		@endif
<!--		<div class="about-title">-->
<!--			<p>ABOUT <font class="about-title-pink">US</font></p>-->
<!--		</div>-->
<!--		<div class="container about-desc">-->
<!--			<p>Our company was formed on August 2009. Our typical customers are pregnant women and we do our best provide them the products and services they need at a competitive price. The company pays homepage to the fundamental philosophy we have utilized in building our businesses. We believe in "mutual success". We build mutually beneficial professional alliances with our customers, suppliers, and our employees that help all to grow and prosper. </p>-->
<!--			<p>Our main business office is Taytay, Rizal and we have branches in all leading Department Stores nationwide. -->
<!--From all of our locations, we want to provide superior products and the best customer service. </p>-->
<!--		</div>-->
		
		<!--<div class="statement">-->
		<!--	<div class="title">-->
		<!--		<p>OUR <font class="title-pink">MISSION</font></p>-->
		<!--	</div>-->
		<!--	<div class="container desc">-->
		<!--		<p>We are the #1 supplier of garments in the country, a hassle-free one stop solution to expectant mothers needs in all their maternity wear requirements. Our key strength lies in the production of the best quality and style to suit even discriminating tastes with our able in-house design and development team as well as management team. </p>-->
		<!--	</div>-->
		<!--	<div class="title">-->
		<!--		<p>OUR <font class="title-pink">VISION</font></p>-->
		<!--	</div>-->
		<!--	<div class="container desc">-->
		<!--		<p>The top and most sought maternity garments leader in the country. </p>-->
		<!--	</div>-->
		<!--	<div class="title">-->
		<!--		<p>CORE <font class="title-pink">VALUES</font></p>-->
		<!--	</div>-->
		<!--	<div class="container desc">-->
		<!--		<p>INTEGRITY</p>-->
		<!--		<p>RESPECT</p>-->
		<!--		<p>PROFESSIONALISM</p>-->
		<!--		<p>EMPOWERMENT</p>-->
		<!--		<p>QUALITY SERVICE</p>-->
		<!--		<p>CUSTOMER SATISFACTION</p>-->
		<!--		<p>PASSION FOR EXCELLENCE</p>-->
		<!--	</div>-->
		<!--</div>-->
	</div>
</div>
@endsection
@section("css")
<link rel="stylesheet" type="text/css" href="/themes/{{ $shop_theme }}/assets/front/css/about.css">
@endsection
@section("script")

@endsection