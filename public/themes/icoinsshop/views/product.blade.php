@extends("layout")
@section("content")
<div class="content">
	<div class="top-1-container">
		<div class="container">
			<div class="prod-container">
				<div class="row clearfix">
					<div class="product-list-holder">
						<div class="prod-list-container">
							<div class="title-container">All<div class="line-bot"></div></div>
							<div class="prod-list row clearfix">
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
									<div class="col-md-4">
										<div class="product-holder wow fadeIn" data-wow-delay=".2s" data-wow-duration="2s">
										    <div class="top">
										        <img src="{{ get_product_first_image($product) }}">
										    </div>
										    <div class="bottom">
										        <div class="product-title">{{ get_product_first_name($product) }}</div>
										        <div class="price-cont">{{ get_product_first_price($product) }}</div>
										        <div class="btn-container">
										            <a href="/product/view2/{{ $product['eprod_id'] }}"><button class="btn-more-info">MORE INFO</button></a>
										            <a href="javascript:"><button class="btn-buy-tokens">BUY TOKENS</button></a>
										        </div>
										    </div>
										</div>
									</div>
									@endforeach
								@else
									<a href="/product/view/test">
										<div class="col-md-4">
											<div class="per-item">
												<div class="image-container">
													<img src="/themes/{{ $shop_theme }}/img/item-sample.png">
												</div>
												<div class="detail-container">
													<div class="item-name">
														3XCELL Neuro Proprietary Herbal Bend Food Supplement Capsules
													</div>
													<div class="price-container">PHP 250.00</div>
													<div class="button-container">SHOP NOW</div>
												</div>
											</div>
										</div>
									</a>
									<a href="/product/view/test">
										<div class="col-md-4>
											<div class="per-item">
												<div class="image-container">
													<img src="/themes/{{ $shop_theme }}/img/item-sample.png">
												</div>
												<div class="detail-container">
													<div class="item-name">
														3XCELL Neuro Proprietary Herbal Bend Food Supplement Capsules
													</div>
													<div class="price-container">PHP 250.00</div>
													<div class="button-container">SHOP NOW</div>
												</div>
											</div>
										</div>
									</a>
									<a href="/product/view/test">
										<div class="col-md-4">
											<div class="per-item">
												<div class="image-container">
													<img src="/themes/{{ $shop_theme }}/img/item-sample.png">
												</div>
												<div class="detail-container">
													<div class="item-name">
														3XCELL Neuro Proprietary Herbal Bend Food Supplement Capsules
													</div>
													<div class="price-container">PHP 250.00</div>
													<div class="button-container">SHOP NOW</div>
												</div>
											</div>
										</div>
									</a>
									<a href="/product/view/test">
										<div class="col-md-4 col-sm-4 col-xs-6">
											<div class="per-item">
												<div class="image-container">
													<img src="/themes/{{ $shop_theme }}/img/item-sample.png">
												</div>
												<div class="detail-container">
													<div class="item-name">
														3XCELL Neuro Proprietary Herbal Bend Food Supplement Capsules
													</div>
													<div class="price-container">PHP 250.00</div>
													<div class="button-container">SHOP NOW</div>
												</div>
											</div>
										</div>
									</a>
									<a href="/product/view/test">
										<div class="col-md-4 col-sm-4 col-xs-6">
											<div class="per-item">
												<div class="image-container">
													<img src="/themes/{{ $shop_theme }}/img/item-sample.png">
												</div>
												<div class="detail-container">
													<div class="item-name">
														3XCELL Neuro Proprietary Herbal Bend Food Supplement Capsules
													</div>
													<div class="price-container">PHP 250.00</div>
													<div class="button-container">SHOP NOW</div>
												</div>
											</div>
										</div>
									</a>
									<a href="/product/view/test">
										<div class="col-md-4 col-sm-4 col-xs-6">
											<div class="per-item">
												<div class="image-container">
													<img src="/themes/{{ $shop_theme }}/img/item-sample.png">
												</div>
												<div class="detail-container">
													<div class="item-name">
														3XCELL Neuro Proprietary Herbal Bend Food Supplement Capsules
													</div>
													<div class="price-container">PHP 250.00</div>
													<div class="button-container">SHOP NOW</div>
												</div>
											</div>
										</div>
									</a>
								@endif
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