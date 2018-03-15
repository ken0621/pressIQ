@extends("layout")
@section("content")
<div class="content">
	<div class="top-1-container">
		<div class="container">
			<div class="prod-container">
				<div class="row clearfix">

					{{-- <div class="cat-promo-holder col-md-3 col-sm-3 col-xs-4">

						<!-- PRODUCT CATEGORIES -->
						<div class="cat-container">
							<div class="cat-title-container">
								<span><i class="fa fa-bars" aria-hidden="true"></i></span>
								<span>Categories</span>
							</div>
							<div class="cat-list-container">
								@if(count($_category) > 0)
									@foreach($_category as $category)
										<div class="cat-list {{ $category['type_id'] == Request::input('type') ? 'active' : '' }}" onClick="location.href='/product?type={{ $category['type_id'] }}'">{{ $category['type_name'] }}</div>
									@endforeach
								@else
									<div class="cat-list">Men's Apparel</div>
									<div class="cat-list">Mobile and Gadget</div>
									<div class="cat-list">Consumer Electronic</div>
									<div class="cat-list">Home and Living</div>
									<div class="cat-list">Men's Accessories</div>
									<div class="cat-list">Men's Shoes</div>
									<div class="cat-list">Foods</div>
									<div class="cat-list">Hobbies and Stationery</div>
									<div class="cat-list">Women's Apparel</div>
									<div class="cat-list">Healthy and Beauty</div>
									<div class="cat-list">Toys, Babies and Kids</div>
									<div class="cat-list">Bags</div>
								@endif
							</div>
						</div>
					</div> --}}

					<div class="product-list-holder col-md-12 col-sm-12 col-xs-12">
						<div class="prod-list-container">
							<div class="title-container">All<div class="line-bot"></div></div>
							<div class="prod-list">
								<div class="row no-gutters clearfix gutters">
									<!-- PER ITEM -->
									@if(count($_product) > 0)
										@foreach($_product as $product)

										{{-- <a href="/product/view2/{{ $product['eprod_id'] }}">
											<div class="col-md-4 col-sm-4 col-xs-6">
												<div class="per-item">
													<div class="image-container">
														<img class="1-1-ratio" src="{{ get_product_first_image($product) }}">
													</div>
													<div class="detail-container">
														<div class="item-name">
															{{ get_product_first_name($product) }}
														</div>
														<div class="price-container">{{ get_product_first_price($product) }}</div>
														<div class="button-container">SHOP NOW</div>
													</div>
												</div>
											</div>
										</a> --}}

										<div class="col-md-2">
											<div class="product-holder">
												<a class="item-hover" href="/product/view2/{{ $product['eprod_id'] }}" style="text-decoration: none;">
													<div class="product-image">
														<img src="{{ get_product_first_image($product) }}">
													</div>
												</a>
											</div>
										</div>
										@endforeach
									@else
									   
									@endif
								</div>
							</div>
						</div>
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
<link rel="stylesheet" type="text/css" href="/themes/{{ $shop_theme }}/css/product.css">
@endsection

@section("script")
<script type="text/javascript">

</script>
@endsection



