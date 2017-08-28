@extends("layout")
@section("content")
<div class="content">
	<div class="top-1-container">
		<div class="container">
			<div class="prod-content-container row clearfix">
				<div class="col-md-6">
					<!-- PRODUCT IMAGE -->
					<div class="prod-image-container">
						<img class="single-product-img" src="{{ get_product_first_image($product) }}">
					</div>
					<!-- PRODUCT DESCRIPTION -->
					<div class="prod-description-container">
						<div class="prod-description-title-container">
							<div class="description-title">
								Description
							</div>
						</div>
						<div class="prod-description">
							<p>
								{{ get_product_first_description($product) }}
							</p>
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="purchase-details-container">
						<div class="product-name-container">{{ get_product_first_name($product) }}<div class="line-bot"></div></div>
						<div class="product-price">{{ get_product_first_price($product) }}</div>
						<div class="product-quantity">
							<div class="info-title">
								Quantity
							</div>
							<input class="input-quantity" variant-id="{{ $product['variant'][0]['evariant_id'] }}" type="number" name="quantity" min="1" step="1" value="1">
						</div>
						<div class="add-to-cart-button" variant-id="{{ $product['variant'][0]['evariant_id'] }}"><span><i class="fa fa-cart-plus" aria-hidden="true"></i></span>&nbsp;&nbsp;<span>ADD TO CART</span></div>
						<!-- <div class="share-product">
							<div class="info-title">Share This Product</div>
							<div class="share-button-container">
								<div class="share-button"><span><i class="fa fa-facebook" aria-hidden="true"></i></span><span>&nbsp;Facebook</span></div>
								<div class="share-button"><span><i class="fa fa-twitter" aria-hidden="true"></i></span><span>&nbsp;Twitter</span></div>
							</div>
						</div> -->
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="top-2-container">
		<div class="container">
			<!-- RELATED PRODUCTS -->
			<div class="related-products-container">
				<div class="title-container">
					<div class="title">Related Products</div>
					<div class="line-bot"></div>
				</div>
				<div class="per-item-container row clearfix">
					<!-- PER ITEM -->
					<div class="col-md-3">
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
					<div class="col-md-3">
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
					<div class="col-md-3">
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
					<div class="col-md-3">
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
				</div>
			</div>
			<!-- PACKAGE -->
			<div class="related-products-container">
				<div class="title-container">
					<div class="title">You May Also Like This</div>
					<div class="line-bot"></div>
				</div>
				<div class="per-item-container row clearfix">
					<!-- PER ITEM -->
					<div class="col-md-3">
						<div class="per-item">
							<div class="image-container">
								<img src="/themes/{{ $shop_theme }}/img/sample-package.png">
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
					<div class="col-md-3">
						<div class="per-item">
							<div class="image-container">
								<img src="/themes/{{ $shop_theme }}/img/sample-package.png">
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
					<div class="col-md-3">
						<div class="per-item">
							<div class="image-container">
								<img src="/themes/{{ $shop_theme }}/img/sample-package.png">
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
					<div class="col-md-3">
						<div class="per-item">
							<div class="image-container">
								<img src="/themes/{{ $shop_theme }}/img/sample-package.png">
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
				</div>
			</div>
		</div>
	</div>
</div>
@endsection

@section("css")
<link rel="stylesheet" type="text/css" href="/themes/{{ $shop_theme }}/css/product_content.css">
@endsection

@section("js")
<script type="text/javascript">
$(document).ready(function()
{
	/*scroll up*/
	$(window).scroll(function () {
        if ($(this).scrollTop() > 700) {
            $('.scroll-up').fadeIn();
        } else {
            $('.scroll-up').fadeOut();
        }
    });

    $('.scroll-up').click(function () {
        $("html, body").animate({
            scrollTop: 0
        }, 700);
        return false;
    });
});
</script>
<script type="text/javascript" src="/assets/front/js/zoom.js"></script>
<script type="text/javascript" src="/assets/front/js/global_addcart.js"></script>
@endsection