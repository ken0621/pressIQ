@extends("layout")
@section("content")
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
		</div>
	</div>
	<div class="top-1-container">
		<div class="container">
			<div class="prod-container">
				<div class="row clearfix">
					<div class="product-list-holder col-md-12 col-sm-12 col-xs-12">
						<div class="prod-list-container">
							<div class="title-container">Featured Products<div class="line-bot"></div></div>
							<div class="prod-list">
								<div class="row-no-padding clearfix">
									<!-- PER ITEM -->
									{{-- @if(count($_product) > 0)
										@foreach($_product as $product)
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
									   
									@endif --}}
									@if(count($_product) > 0)
										@foreach($_product as $product)
										<div class="col-md-2 prod-border">
											<div class="prod-holder">
												<a class="item-hover" href="/product/view2/{{ $product['eprod_id'] }}" style="text-decoration: none;">
													<div class="prod-image">
														<img src="{{ get_product_first_image($product) }}">
													</div>
													<div class="details-container">
														<div class="prod-type">Appliances</div>
														<div class="prod-name">{{ get_product_first_name($product) }}</div>
														<div class="prod-price">{{ get_product_first_price($product) }}</div>
													</div>
												</a>
											</div>
										</div>
										@endforeach
									@else
									   <div class="col-md-3" >
                                            <strong>"NO ITEMS FOUND"</strong>
                                       </div>
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

@section("js")
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
@endsection



