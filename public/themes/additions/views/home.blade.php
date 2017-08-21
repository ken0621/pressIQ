@extends("layout")
@section("content")
<div class="container">
	<div class="clearfix demo">
        <div class="item">
            <ul id="image-gallery" class="gallery list-unstyled cS-hidden">
                <li data-thumb="/themes/{{ $shop_theme }}/assets/front/global/lightslider/demo/img/thumb/cS-1.jpg"> 
                    <img src="/themes/{{ $shop_theme }}/assets/front/global/lightslider/demo/img/1st.jpg" />
      <!--               <div class="carousel-click">-->
						<!--<button onClick="location.href='http://google.com'">Shop Now</button>-->
				  <!--  </div>-->
                </li>
                <li data-thumb="/themes/{{ $shop_theme }}/assets/front/global/lightslider/demo/img/thumb/cS-2.jpg"> 
                    <img src="/themes/{{ $shop_theme }}/assets/front/global/lightslider/demo/img/1st.jpg" />
                </li>
            </ul>
        </div>
    </div>
</div>
<div class="container">
	<div class="maternity-promo">
		<div class="maternity-line">
		<span class="maternity-title">MATERNITY <font class="maternity-clothes">CLOTHES</font></span></div>
	</div>
</div>
<div class="container">
	<div class="clearfix maternity-products">
		<div class="left">
			<div class="product-left1">
			<img src="/themes/{{ $shop_theme }}/front/category2.jpg">
			<div class="title">BOTTOMS</div>
			<div class="shop-now">
				<button onClick="location.href='/product?type_id=bottoms'">Shop Now</button>
			</div>
			</div>

			<div class="product-left2">
				<img src="/themes/{{ $shop_theme }}/front/category3.jpg">
				<div class="title">DRESS</div>
				<div class="shop-now">
					<button onClick="location.href='/product?type_id=dress'">Shop Now</button>
				</div>
			</div>
		</div>
		<div class="right">
			<div class="product-right">
				<img src="/themes/{{ $shop_theme }}/front/category4.jpg">
				<div class="title">TOPS</div>
				<div class="shop-now">
					<button onClick="location.href='/product?type_id=tops'">Shop Now</button>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="container">
	<div class="maternity-promo">
		<div class="maternity-line">
		<span class="maternity-title">WHAT'S <font class="maternity-clothes">NEW</font></span></div>
	</div>
</div>
<div class="main">
	<div class="container">
		<div class="list-container">
			<div class="row clearfix">
				<!-- <div class="col-md-4 col-sm-4 match-height">
					<div class="list-product-maternity" id="1">
						<div class="img"><img src="/themes/{{ $shop_theme }}/front/1st.jpg" class="prodimg">
						</div>
						<div class="show-cart-view cart-hidden1 hidden">
							<a href="/product/view?id=1"><img class="magnify-glass" src="/themes/{{ $shop_theme }}/front/magnify-black.png"></a>
							<img class="bag" src="/themes/{{ $shop_theme }}/front/bag-black.png">
						</div>
						<div class="name">NUTRA-CEUTICALS</div>
						<div class="price">P 200.00</div>
					</div>
				</div> -->
				@if($_product)
					@foreach($_product as $product)
					<div class="col-md-4 col-sm-6 col-sm-bottom col-bottom">
						<div class="list-product" id="{{$product["eprod_id"]}}" class="prodimg">
							<div class="triangle-topright">
								<div class="label-name">New</div>
								<div class="label-desc">Releases</div>
							</div>
							<div class="img">
								<img class="4-3-ratio" src="{{get_product_first_image($product)}}">
								<div class="show-cart-view cart-hidden{{$product["eprod_id"]}} hidden">
									<a href="/product/view/{{ $product["eprod_id"] }}"><img class="magnify-glass" src="/themes/{{ $shop_theme }}/front/magnify-black.png"></a>
									<img src="/themes/{{ $shop_theme }}/front/bag-black.png" class='bag add-to-cart account-modal-button' style='cursor: pointer;'>
								</div>
							</div>
							<div class="prod-name name">{{get_product_first_name($product)}}</div>
							<div class="prod-price price">{{get_product_first_price($product)}}</div>
						</div>
					</div>
					@endforeach
				@endif
			</div>
		</div>
	</div>	
</div>

@endsection
@section("script")
<script type="text/javascript" src='/themes/{{ $shop_theme }}/assets/front/js/home.js'></script>
<script type="text/javascript" src="/themes/{{ $shop_theme }}/assets/front/global/lightslider/dist/js/lightslider.min.js"></script>
<script>
	$(document).ready(function() {
		$("#content-slider").lightSlider({
	        loop:true,
        keyPress:true
	    });
	    $('#image-gallery').lightSlider({
	        item:1,
	        thumbItem:9,
	        slideMargin: 0,
	        speed:500,
	        auto:true,
	        loop:true,
	        onSliderLoad: function() {
	            $('#image-gallery').removeClass('cS-hidden');
	        }  
	    });
	});
</script>
@endsection
@section("css")
<link rel="stylesheet" type="text/css" href="/themes/{{ $shop_theme }}/assets/front/css/home.css">
<link rel="stylesheet" type="text/css" href="/themes/{{ $shop_theme }}/assets/front/css/product.css">
<link rel="stylesheet" type="text/css" href="/themes/{{ $shop_theme }}/assets/front/global/lightslider/dist/css/lightslider.css">
@endsection