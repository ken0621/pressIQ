@extends("layout")
@section("content")
<div class="product-container">
	<div class="container">
		<div class="row clearfix">
			<div class="col-md-3">
				<div class="category-container">
					<div class="animated fadeInLeft text-header">Browse By Catergory</div>
					<div class="animated fadeInRight links-category">
						<a href="#" class="active">Brown Phone (4)</a>
						<a href="#">Phone Case (20)</a>
						<a href="#">Head Phones (30)</a>
						<a href="#">Power Banks (10)</a>
						<a href="#">Dongles (5)</a>
						<a href="#">Internet Of Things (5)</a>
						<a href="#">Health Technology (3)</a>
					</div>
				</div>
				<div class="filter-by-price-container">
					<div class="animated fadeInLeft text-header">Filter By Price</div>
					<div class="animated fadeInDown filter-control">
						<div id="slider-range"></div>
					</div>
					<div class="animated fadeInDown txt-price" id="amount">5900 - 34000</div>
					<button class="animated fadeInUp btn-go">Go</button>
				</div>
			</div>
			<div class="col-md-9" style="overflow: hidden;">
				<div class="top-item-container">
					<div class="row clearfix">
						<div class="animated zoomIn col-md-3 col-sm-6">
							<div class="img-and-lbl-container">
								<a href="/product/view/test"><img width="206" height="206" src="/themes/{{ $shop_theme }}/img/brown-device-1.png"></a>
								<div class="lbl-item-name">Brown 1</div>
								<div class="lbl-description">4.7 HD IPS Display</div>
								<div class="lbl-price">P 9,500.00</div>
							</div>
						</div>
						<div class="animated zoomIn col-md-3 col-sm-6">
							<div class="img-and-lbl-container">
								<a href="/product/view/test"><img width="206" height="206" src="/themes/{{ $shop_theme }}/img/brown-device-2.png"></a>
								<div class="lbl-item-name">Brown 2</div>
								<div class="lbl-description">5.0 HD IPS Display</div>
								<div class="lbl-price">P 9,500.00</div>
							</div>
						</div>
						<div class="animated zoomIn col-md-3 col-sm-6">
							<div class="img-and-lbl-container">
								<a href="/product/view/test"><img width="206" height="206" src="/themes/{{ $shop_theme }}/img/brown-device-3.png"></a>
								<div class="lbl-item-name">Brown 1</div>
								<div class="lbl-description">8 MP Front Camera</div>
								<div class="lbl-price">P 9,500.00</div>
							</div>
						</div>
						<div class="animated zoomIn col-md-3 col-sm-6">
							<div class="img-and-lbl-container">
								<a href="/product/view/test"><img width="206" height="206" src="/themes/{{ $shop_theme }}/img/brown-device-4.png"></a>
								<div class="lbl-item-name">Brown 1</div>
								<div class="lbl-description">13 MP Back Camera</div>
								<div class="lbl-price">P 9,500.00</div>
							</div>
						</div>
					</div>
				</div>
				<div class="bottom-item-container" style="overflow: hidden;">
					<div class="row clearfix">
						<div class="wow fadeInLeft text-header">You May Also Like This</div>
						<div class="wow zoomIn col-md-3 col-sm-6">
							<div class="img-and-lbl-container">
								<a href="/product/view/test"><img width="206" height="206" src="/themes/{{ $shop_theme }}/img/brown-accs-img-1.png"></a>
								<div class="lbl-item-name">XB-400</div>
								<div class="lbl-description">Super Bass</div>
								<div class="lbl-price">P 9,500.00</div>
							</div>
						</div>
						<div class="wow zoomIn col-md-3 col-sm-6">
							<div class="img-and-lbl-container">
								<a href="/product/view/test"><img width="206" height="206" src="/themes/{{ $shop_theme }}/img/brown-accs-img-2.png"></a>
								<div class="lbl-item-name">Sense 4</div>
								<div class="lbl-description">10400 mAh</div>
								<div class="lbl-price">P 9,500.00</div>
							</div>
						</div>
						<div class="wow zoomIn col-md-3 col-sm-6">
							<div class="img-and-lbl-container">
								<a href="/product/view/test"><img width="206" height="206" src="/themes/{{ $shop_theme }}/img/brown-accs-img-3.png"></a>
								<div class="lbl-item-name">T'nalak Brown</div>
								<div class="lbl-description">Phone Case</div>
								<div class="lbl-price">P 9,500.00</div>
							</div>
						</div>
						<div class="wow zoomIn col-md-3 col-sm-6">
							<div class="img-and-lbl-container">
								<a href="/product/view/test"><img width="206" height="206" src="/themes/{{ $shop_theme }}/img/brown-accs-img-4.png"></a>
								<div class="lbl-item-name">T'nalak Brown<br>Power Cable</div>
								<div class="lbl-description">Cable</div>
								<div class="lbl-price">P 9,500.00</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
@section("css")
<link rel="stylesheet" type="text/css" href="/themes/{{ $shop_theme }}/css/product.css">
@endsection
@section("script")
<script type="text/javascript" src="/themes/{{ $shop_theme }}/js/product.js"></script>
@endsection