@extends("layout")
@section("content")
<style type="text/css">
.prod-image-thumb-container
{
	width: 100%;
}

.prod-image-thumb-container .holder
{
	
}

.slick-slide img
{
	object-fit: cover !important;
}

</style>
<div class="content">
	<div class="bg-container">
		
	</div>
	<div class="breadcrumb-container">
		<div class="container">
			<ol class="breadcrumb">
			  <li><a href="/">Home</a></li>
			  <li><a href="/product">Products</a></li>
			  <li class="active">{{ get_product_first_name($product) }}</li>
			</ol>
		</div>
	</div>
	<div class="top-1-container">
		<div class="container">
			@foreach($product['variant'] as $key => $product_variant)
				<div class="product-content prod-content-container row clearfix {{ $loop->first ? '' : 'hide' }}" variant-id="{{ $product_variant['evariant_id'] }}">
					<div class="col-md-6">
						<!-- PRODUCT IMAGE -->
						<div class="prod-image-container">
							<div>
								@foreach($product_variant['image'] as $key => $image)
								{{-- <img class="single-product-img" src="{{ get_product_first_image($product) }}"> --}}
								<img key="{{ $key }}" variant-id="{{ $product_variant['evariant_id'] }}" class="single-product-img 4-3-ratio {{ $key == 0 ? '' : 'hide' }}" key="{{ $key }}" style="width: 100%;" src="{{ $image['image_path'] }}" data-zoom-image="{{ $image['image_path'] }}">
								@endforeach
							</div>
						</div>
						{{-- JUST NOW --}}
						<div class="prod-image-thumb-container" style="margin-left: -7.5px; margin-right: -7.5px;">
							@foreach($product_variant['image'] as $key => $image)
                            <div class="holder" style="cursor: pointer; padding: 0 7.5px;" key="{{ $key }}" variant-id="{{ $product_variant['evariant_id'] }}"><img style="width: 100%; object-fit: cover;" class="item-image-small small-yellow-bag 4-3-ratio" src="{{ $image['image_path'] }}"></div>
                            @endforeach
						</div>
					</div>
					<div class="col-md-6">
						<div class="purchase-details-container">
							<div class="product-name-container">{{ $product["eprod_name"] }}{{-- <div class="line-bot"></div> --}}</div>
							<!-- PRODUCT DESCRIPTION -->
							<div class="prod-description-container">
								<div class="description-title">
									Description
								</div>
								<div class="prod-description">
									<p>
										{!! $product["variant_desc"] !!}
										
									</p>
								</div>
								<div class="cat-title">
									{{-- Category --}}
								</div>
								<div class="cat-description">
									<p>
										{{-- {!! get_product_first_description($product) !!} --}}
										{{-- Home Appliances --}}
										{{-- {!! $product_variant["evariant_description"] !!} --}}
									</p>
								</div>
							</div>
						</div>
					</div>
				</div>
			@endforeach
		</div>
	</div>
</div>
@endsection

@section("css")
<link rel="stylesheet" type="text/css" href="/themes/{{ $shop_theme }}/css/app.css">
@endsection

@section("script")
<script type="text/javascript">
    $(function()
    {
        $('#close-menu').on('click',function()
        {
            $(this).closest('#menu').toggle(500,function(){
            $('.mini-submenu').fadeIn();
            $('#cat-title').fadeIn();
        });
    });
        $('.mini-submenu').on('click',function()
        {
            $(this).next('#menu').toggle(500);
            $('.mini-submenu').hide();
            $('#cat-title').hide();
        })
    })
</script>
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
<script type="text/javascript" src="/themes/{{ $shop_theme }}/js/product_content.js?version=1"></script>
<script type="text/javascript">
$('.prod-image-thumb-container').slick({
  infinite: true,
  slidesToShow: 4,
  slidesToScroll: 1
});	
</script>
@endsection