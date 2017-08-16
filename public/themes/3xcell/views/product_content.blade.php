@extends("layout")
@section("content")
<?php $ctr = 0; ?>
@foreach($product["variant"] as $product_variant)
<div class="single-product-content content {{ $ctr != 0 ? 'hide' : '' }}" variant-id="{{ $product_variant['evariant_id'] }}">
	<div class="top-1-container">
		<div class="container">
			<div class="prod-content-container row clearfix">
				<div class="col-md-6">
					<!-- PRODUCT IMAGE -->
					<div class="prod-image-container">
						<img src="/themes/{{ $shop_theme }}/img/item-sample.png">
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
								FitPro– “The Sexy Pill’’ The long wait is over! Achieve your weight the healthiest way. FitPro is developed to provide health conscious individuals to attain their desired weight naturally. Scientifically studied for their curative properties in combating and expelling the toxins from the body, combinations of herbs were selected. FitPro is found to be effective in: Helping fight obesity, Working as a natural appetite suppressant while keeping the body in active condition. Acting as an anti-oxidant that promotes healthy skin. Lose weight like a Pro with FitPro.
							</p>
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="purchase-details-container">
						<div class="product-name-container">3XCELL Fit Proprietary Herbal Blend Food Supplement Tablets<div class="line-bot"></div></div>
						<div class="product-price">PHP 200.00</div>
						<div class="product-quantity">
							<div class="info-title">
								Quantity
							</div>
							<input class="input-quantity" type="number" name="quantity" min="1" step="1" value="1">
						</div>
						<div class="add-to-cart-button"><span><i class="fa fa-cart-plus" aria-hidden="true"></i></span>&nbsp;&nbsp;<span>ADD TO CART</span></div>
						<div class="share-product">
							<div class="info-title">Share This Product</div>
							<div class="share-button-container">
								<div class="share-button"><span><i class="fa fa-facebook" aria-hidden="true"></i></span><span>&nbsp;Facebook</span></div>
								<div class="share-button"><span><i class="fa fa-twitter" aria-hidden="true"></i></span><span>&nbsp;Twitter</span></div>
							</div>
						</div>
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
<?php $ctr++; ?>
@endforeach
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
@endsection