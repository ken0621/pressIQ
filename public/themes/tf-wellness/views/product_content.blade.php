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
	<div class="main-container">
		<div class="container">
			<div class="hamburger-container">
				<div class="mini-submenu">
				    <span class="icon-bar"></span>
				    <span class="icon-bar"></span>
				    <span class="icon-bar"></span>
				</div>
				<ul id="menu">
				    <div class="categories-header">
				        <span class="title">CATEGORIES</span><i id="close-menu" class="fa fa-times" aria-hidden="true"></i>
				    </div>
				    <li><a href="#">Health Supplements</a></li>
					<li><a href="#">Beverages</a></li>
					<li><a href="#">Beauty Products</a></li>
					<li><a href="#">Home Care Products</a></li>
					<li><a href="#">Breakfast Foods</a></li>
					<li><a href="#">RTWs</a></li>
					<li><a href="#">Groceries</a></li>
					<li><a href="#">Gadgets</a></li>
					<li><a href="#">Home Appliances</a></li>
					<li><a href="#">Beauty Salon</a></li>
					<li><a href="#">Spa</a></li>
					<li><a href="#">More</a></li>
				</ul>
				<div id="cat-title">Shop By Categories</div>
			</div>
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
							@foreach($product_variant['image'] as $key => $image)
							{{-- <img class="single-product-img" src="{{ get_product_first_image($product) }}"> --}}
							<img key="{{ $key }}" variant-id="{{ $product_variant['evariant_id'] }}" class="single-product-img 4-3-ratio {{ $key == 0 ? '' : 'hide' }}" key="{{ $key }}" style="width: 100%;" src="{{ $image['image_path'] }}" data-zoom-image="{{ $image['image_path'] }}">
							@endforeach
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
										{{-- {!! get_product_first_description($product) !!} --}}
										Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quo aliquid itaque minima eveniet alias recusandae quos placeat quasi harum qui dolore pariatur ipsum excepturi ipsam inventore, soluta ab accusamus earum?
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
							<div class="prod-price">
								Price
							</div>
							<div class="product-price">
								@if($product_variant['discounted'] == "true")
                                    <div class="price">&#8369; {{ number_format($product_variant['discounted_price'], 2) }}</div>
                                    <div class="price" style="text-decoration: line-through; font-size: 14px;">&#8369; {{ number_format($product_variant['evariant_price'], 2) }}</div>
                                @else
                                	<div class="price">&#8369; {{ number_format($product_variant['evariant_price'], 2) }}</div>
                                @endif
							</div>
							
							@if($mlm_member)
								<div class="member-only">
									<div class="labels">Member's Discounter Price</div>
									<div class="d-price">PHP 800.00</div>
									<div class="labels">Point Value</div>
									<div class="p-value">5.00</div>
								</div>
							@endif

							@if(isset($_variant) && $_variant && count($_variant) > 0)
								<div class="variant-holder" style="margin-top: 15px;">
	                                @foreach($_variant as $variant)
	                                <div class="holder">
	                                    <div class="s-label" style="color: #585858; font-size: 13px;font-weight: 500; margin-bottom: 5px;">Select {{ $variant['option_name'] }}</div>
	                                    <div class="select">
	                                        <select name="attr[{{ $variant['option_name_id'] }}]" style="text-transform: capitalize;" class="form-control select-variation" variant-label="{{ $variant['option_name'] }}" product-id="{{ $product['eprod_id'] }}" variant-id="{{ $product_variant['evariant_id'] }}">
	                                            <option value="0" style="text-transform: capitalize;">{{ $variant['option_name'] }}</option>
	                                            @foreach(explode(",", $variant['variant_value']) as $option)
	                                            <option value="{{ $option }}" style="text-transform: capitalize;">{{ $option }}</option>
	                                            @endforeach
	                                        </select>
	                                    </div>
	                                </div>
	                                @endforeach
	                            </div>
                            @endif

							<div class="product-quantity">
								<div class="info-title">
									Quantity
								</div>
								<input class="input-quantity" onChange="$(this).siblings('.product-add-cart').attr('quantity', $(this).val())" type="number" name="quantity" min="1" step="1" value="1">
								<div class="add-to-cart-button product-add-cart" item-id="{{ $product['variant'][0]['evariant_item_id'] }}" quantity="1"><span><i class="fa fa-cart-plus" aria-hidden="true"></i></span>&nbsp;&nbsp;<span>ADD TO CART</span></div>
							</div>
							
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
			@endforeach
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
					@foreach(limit_foreach($_related, 4) as $related)
					<div class="col-md-3 col-sm-6 col-xs-6">
						<div class="per-item" style="cursor: pointer;" onClick="location.href='/product/view2/{{ $related['eprod_id'] }}'">
							<div class="image-container">
								<img src="{{ get_product_first_image($related) }}">
							</div>
							<div class="detail-container">
								<div class="item-name">
									{{ get_product_first_name($related) }}
								</div>
								<div class="price-container">PHP {{ get_product_first_price($related) }}</div>
								<div class="button-container">SHOP NOW</div>
							</div>
						</div>
					</div>
					@endforeach
				</div>
			</div>
			<!-- PACKAGE -->
			@if(isset($_package))
			<div class="related-products-container">
				<div class="title-container">
					<div class="title">You May Also Like This</div>
					<div class="line-bot"></div>
				</div>
				
				<div class="per-item-container row clearfix">
					<!-- PER ITEM -->
					@if(count($_package) > 0)
						@foreach(limit_foreach($_package, 4) as $package)
						<div class="col-md-3 col-sm-6 col-xs-6">
							<div class="per-item" style="cursor: pointer;" onClick="location.href='/product/view/{{ $related['eprod_id'] }}'">
								<div class="image-container">
									<img src="{{ get_product_first_image($package) }}">
								</div>
								<div class="detail-container">
									<div class="item-name">
										{{ get_product_first_name($package) }}
									</div>
									<div class="price-container">PHP {{ get_product_first_price($package) }}</div>
									<div class="button-container">SHOP NOW</div>
								</div>
							</div>
						</div>
						@endforeach
					@endif
				</div>
			</div>
			@endif
		</div>
	</div>
</div>
@endsection

@section("css")
<link rel="stylesheet" type="text/css" href="/themes/{{ $shop_theme }}/css/product_content.css">
@endsection

@section("js")
<script type="text/javascript" src="/themes/{{ $shop_theme }}/js/home.js"></script>
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