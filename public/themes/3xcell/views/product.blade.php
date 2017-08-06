@extends("layout")
@section("content")
<div class="content">
	<div class="top-1-container">
		<div class="container">
			<div class="prod-container">
				<div class="row clearfix">
					<div class="col-md-3">
						<!-- PRODUCT CATEGORIES -->
						<div class="cat-container">
							<div class="cat-title-container">
								<span><i class="fa fa-bars" aria-hidden="true"></i></span>
								<span>Categories</span>
							</div>
							<div class="cat-list-container">
								<div class="cat-list">Beauty Skin Care</div>
								<div class="cat-list">Food Supplement</div>
								<div class="cat-list">Healthy Drinks</div>
								<div class="cat-list">Business Packages</div>
								<div class="cat-list">Retail Packages</div>
							</div>
						</div>
						<!-- PROMO CONTAINER -->
						<div class="promo-container">
							<div class="title-container">Promo</div>
							<div class="promo-content">
								<img src="/themes/{{ $shop_theme }}/img/promo-img.png">
								<div class="learn-more-button">LEARN MORE</div>
							</div>
						</div>
					</div>
					<div class="col-md-9">
						<div class="prod-list-container">
							<div class="title-container">Food Supplement<div class="line-bot"></div></div>
							<div class="prod-list row clearfix">
								<!-- PER ITEM -->
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