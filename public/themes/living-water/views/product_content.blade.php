@extends("layout")
@section("content")
<div class="content">
	<div class="top-1-container">
		<div class="container">
			<div class="prod-content-container row clearfix">
				<div class="row">
		        <ul id="breadcrumb">
		          <li><a href="/product"><span class="icon icon-beaker"> </span> Gallery</a></li>
		          <li><a href="#" class="active"><span class="icon icon-arrow-down"> </span> {{ get_product_first_name($product) }}</a></li>
		        </ul>
			</div>
				<div class="col-md-6">
					<!-- PRODUCT IMAGE -->
					<div class="prod-image-container">
						<img class="single-product-img" src="{{ get_product_first_image($product) }}">
					</div>
				</div>
				<div class="col-md-6">
					<div class="purchase-details-container">
						<div class="product-name-container">{{ get_product_first_name($product) }}{{-- <div class="line-bot"></div> --}}</div>
						<!-- PRODUCT DESCRIPTION -->
						<div class="prod-description-container">
							<div class="prod-description-title-container">
								<div class="description-title">
									Description
								</div>
							</div>
							<div class="prod-description">
								<p>
									{!! get_product_first_description($product) !!}
								</p>
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
<script type="text/javascript">
var product_image = ".single-product-img";
var button_cart = ".add-to-cart-buttons";
var product_container = ".content";
var product_quantity = ".input-quantity";
var cart_holder = '.cart-dropdown';
</script>
<script type="text/javascript" src="/assets/front/js/global_addcart.js"></script>
@endsection