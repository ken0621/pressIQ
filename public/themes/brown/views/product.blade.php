@extends("layout")
@section("content")

<div class="product-container">
	<div class="container">
		<div class="row clearfix">
			<div class="col-md-3">
				<div class="category-container">

					<div class="text-header">Browse By Catergory</div>

					<div class="links-category">
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
					
					<div class="text-header">Filter By Price</div>
					
					<div class="filter-control">
						<img src="/themes/{{ $shop_theme }}/img/brown-filter-control.png">
					</div>

					<div class="txt-price">5900 - 34000</div>

					<button class="btn-go">Go</button>

				</div>
			</div>
			<div class="col-md-9">
				<div class="top-item-container">
					<div class="row clearfix">
						<div class="col-md-3">
							<div class="img-and-lbl-container">
								<a href="/product/view/test"><img src="/themes/{{ $shop_theme }}/img/brown-device-1.png"></a>
								<div class="lbl-item-name">Brown 1</div>
								<div class="lbl-description">4.7 HD IPS Display</div>
								<div class="lbl-price">P 9,500.00</div>
							</div>
						</div>
						<div class="col-md-3">
							<div class="img-and-lbl-container">
								<a href="/product/view/test"><img src="/themes/{{ $shop_theme }}/img/brown-device-2.png"></a>
								<div class="lbl-item-name">Brown 2</div>
								<div class="lbl-description">5.0 HD IPS Display</div>
								<div class="lbl-price">P 9,500.00</div>
							</div>
						</div>
						<div class="col-md-3">
							<div class="img-and-lbl-container">
								<a href="/product/view/test"><img src="/themes/{{ $shop_theme }}/img/brown-device-3.png"></a>
								<div class="lbl-item-name">Brown 1</div>
								<div class="lbl-description">8 MP Front Camera</div>
								<div class="lbl-price">P 9,500.00</div>
							</div>
						</div>
						<div class="col-md-3">
							<div class="img-and-lbl-container">
								<a href="/product/view/test"><img src="/themes/{{ $shop_theme }}/img/brown-device-4.png"></a>
								<div class="lbl-item-name">Brown 1</div>
								<div class="lbl-description">13 MP Back Camera</div>
								<div class="lbl-price">P 9,500.00</div>
							</div>
						</div>
					</div>
				</div>
				<div class="bottom-item-container">
					<div class="row clearfix">
						<div class="text-header">You May Also Like This</div>
						<div class="col-md-3">
							<div class="img-and-lbl-container">
								<img src="/themes/{{ $shop_theme }}/img/brown-accs-img-1.png">
								<div class="lbl-item-name">XB-400</div>
								<div class="lbl-description">Super Bass</div>
								<div class="lbl-price">P 9,500.00</div>
							</div>
						</div>
						<div class="col-md-3">
							<div class="img-and-lbl-container">
								<img src="/themes/{{ $shop_theme }}/img/brown-accs-img-2.png">
								<div class="lbl-item-name">Sense 4</div>
								<div class="lbl-description">10400 mAh</div>
								<div class="lbl-price">P 9,500.00</div>
							</div>
						</div>
						<div class="col-md-3">
							<div class="img-and-lbl-container">
								<img src="/themes/{{ $shop_theme }}/img/brown-accs-img-3.png">
								<div class="lbl-item-name">T'nalak Brown</div>
								<div class="lbl-description">Phone Case</div>
								<div class="lbl-price">P 9,500.00</div>
							</div>
						</div>
						<div class="col-md-3">
							<div class="img-and-lbl-container">
								<img src="/themes/{{ $shop_theme }}/img/brown-accs-img-4.png">
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

@endsection