@extends("layout")
@section("content")
<div class="content">
	<div class="container">
	<!-- TOP CONTENT -->
		<div class="row clearfix">
			<div class="col-md-3">
				<div class="left-bar-categories">
					<div class="left-bar-title">
						<img src="/themes/{{ $shop_theme }}/img/menu.png">
						<span>Shop By Category</span>
					</div>
					{{-- @if(isset($_categories))
						@foreach($_categories as $category)
						<div class="button-shop">
							<div class="text" style="cursor: pointer;" onClick="location.href='/product?type={{ $category['type_id'] }}'">
								<!-- <img src="/themes/{{ $shop_theme }}/img/electronics.png"> -->
								{{ $category['type_name'] }}
							</div>
							@if($category['subcategory'])
							<div class="hover">
								<div class="hover-holder">
									<div class="row clearfix">
										<ul class="col-md-12">
											@foreach($category['subcategory'] as $subcategory)
											<li><a href="/product?type={{ $subcategory['type_id'] }}">{{ $subcategory['type_name'] }}</a></li>
												@foreach($subcategory['subcategory'] as $subcategory1)
												<li><a href="/product?type={{ $subcategory1['type_id'] }}">{{ $subcategory1['type_name'] }}></a></li>
													@foreach($subcategory1['subcategory'] as $subcategory2)
													<li><a href="/product?type={{ $subcategory2['type_id'] }}">{{ $subcategory2['type_name'] }}></a></li>
													@endforeach
												@endforeach
											@endforeach
										</ul>
									</div>
									<div class="banner-holder">
										<img src="/themes/{{ $shop_theme }}/img/big-discount.jpg">
									</div>
								</div>
							</div>
							@endif
						</div>
						@endforeach
					@endif --}}
					<div class="button-shop">
						<div class="text" style="cursor: pointer;" onClick="location.href='/product/test'">
							<img src="/themes/{{ $shop_theme }}/img/sidebar/dth.png">
							<span>DTH PRODUCTS</span>
						</div>
					</div>
					<div class="button-shop">
						<div class="text" style="cursor: pointer;" onClick="location.href='/product/test'">
							<img src="/themes/{{ $shop_theme }}/img/sidebar/card.png">
							<span>PREPAID CARDS</span>
						</div>
					</div>
					<div class="button-shop">
						<div class="text" style="cursor: pointer;" onClick="location.href='/product/test'">
							<img src="/themes/{{ $shop_theme }}/img/sidebar/gadgets.png">
							<span>GADGETS</span>
						</div>
					</div>
					<div class="button-shop">
						<div class="text" style="cursor: pointer;" onClick="location.href='/product/test'">
							<img src="/themes/{{ $shop_theme }}/img/sidebar/electronics.png">
							<span>ELECTRONICS</span>
						</div>
					</div>
					<div class="button-shop">
						<div class="text" style="cursor: pointer;" onClick="location.href='/product/test'">
							<img src="/themes/{{ $shop_theme }}/img/sidebar/services.png">
							<span>SERVICES</span>
						</div>
					</div>
					<div class="button-shop">
						<div class="text" style="cursor: pointer;" onClick="location.href='/product/test'">
							<img src="/themes/{{ $shop_theme }}/img/sidebar/entertainment.png">
							<span>ENTERTAINMENT</span>
						</div>
					</div>
					<div class="button-shop">
						<div class="text" style="cursor: pointer;" onClick="location.href='/product/test'">
							<img src="/themes/{{ $shop_theme }}/img/sidebar/apparel.png">
							<span>APPAREL</span>
						</div>
					</div>
					<div class="button-shop">
						<div class="text" style="cursor: pointer;" onClick="location.href='/product/test'">
							<img src="/themes/{{ $shop_theme }}/img/sidebar/accessories.png">
							<span>ACCESSORIES</span>
						</div>
					</div>
					<div class="button-shop">
						<div class="text" style="cursor: pointer;" onClick="location.href='/product/test'">
							<img src="/themes/{{ $shop_theme }}/img/sidebar/health.png">
							<span>HEALTH & WELLNESS</span>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-9">
				<div class="grid-holder">
					<div class="row-no-padding clearfix">
						<div class="col-md-8">
							<div class="grid-1"></div>
						</div>
						<div class="col-md-4">
							<div class="grid-2"></div>
							<div class="grid-2"></div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- BOTTOM CONTENT -->
		<div class="row clearfix">
			<div class="col-md-3">
				<div class="hot-deals-container">
					<div class="wow-title">
						<span class="orange">HOT</span><span class="blue">DEALS</span>
						<span class="scroll-button"><a class="left" href="#"><img src="/themes/{{ $shop_theme }}/img/left-button-scroll.png"></a><a class="right" href="#"><img src="/themes/{{ $shop_theme }}/img/right-button-scroll.png"></a></span>
					</div>
					<div class="daily-container">
						{{-- @foreach(get_collection(get_content($shop_theme_info, "home", "daily_hot_deals"), $shop_id) as $collection)
							<div class="holder">
								<div class="hot-deals-item-container">
									<img class="4-3-ratio" src="{{ get_collection_first_image($collection) }}">
									<div class="item-details">
										<a href="/product/view/{{ $collection['product']['eprod_id'] }}"><div class="item-title">{{ get_collection_first_name($collection) }}</div></a>
										<div class="item-price">{{ get_collection_first_price($collection) }}</div>
									</div>
									<button type="button" onCLick="location.href='/product/view/{{ $collection['product']['eprod_id'] }}'" class="new-add-to-cart-button btn" style="margin-top: 25px;">
										<table>
											<tbody>
												<tr>
													<td class="icon"><i class="fa fa-shopping-cart" aria-hidden="true"></i></td>
													<td class="text">View More</td>
												</tr>
											</tbody>
										</table>
									</button>
								</div>
							</div>
						@endforeach --}}
						<div class="holder">
							<div class="hot-deals-item-container">
								<img class="4-3-ratio" src="/themes/{{ $shop_theme }}/img/product/gsat.jpg">
								<div class="item-details">
									<a href="/product/view/test"><div class="item-title">Gsat Prepaid (Load Card 200)</div></a>
									<div class="item-price">P 200.00</div>
								</div>
								<button type="button" onCLick="location.href='/product/view/test'" class="new-add-to-cart-button btn" style="margin-top: 25px;">
									<table>
										<tbody>
											<tr>
												<td class="icon"><img src="/themes/{{ $shop_theme }}/img/header/cart-icon.png"></td>
												<td class="text">SHOP NOW</td>
											</tr>
										</tbody>
									</table>
								</button>
							</div>
						</div>
					</div>
				</div>
				{{-- <div class="hot-deals-container">
					<center>
						<ins class="bookingaff" data-aid="1292959" data-target_aid="1292802" data-prod="banner" data-width="200" data-height="200" data-banner_id="48509">
						    <!-- Anything inside will go away once widget is loaded. -->
						    <a href="//www.booking.com?aid=1292802">Booking.com</a>
						</ins>
					</center>
					<script type="text/javascript">
					    (function(d, sc, u) {
					      var s = d.createElement(sc), p = d.getElementsByTagName(sc)[0];
					      s.type = 'text/javascript';
					      s.async = true;
					      s.src = u + '?v=' + (+new Date());
					      p.parentNode.insertBefore(s,p);
					      })(document, 'script', '//aff.bstatic.com/static/affiliate_base/js/flexiproduct.js');
					</script>
				</div> --}}
				{{-- <div class="special-offers-container">
					<div class="left-container-title">
						<span class="orange">HOT</span><span class="blue">DEALS</span>
						<span class="scroll-button"><a class="left" href="#"><img src="/themes/{{ $shop_theme }}/img/left-button-scroll.png"></a><a class="right" href="#"><img src="/themes/{{ $shop_theme }}/img/right-button-scroll.png"></a></span>
					</div>
					<div class="item-container">
						@foreach(get_collection(get_content($shop_theme_info, "home", "special_offers"), $shop_id) as $collection)
						<div class="row-no-padding clearfix per-item">
							<div class="col-xs-4"><img class="item-img 4-3-ratio" src="{{ get_collection_first_image($collection) }}"></div>
							<div class="col-xs-8">
								<div class=" item-details-container">
									<a href="/product/view/{{ $collection['product']['eprod_id'] }}"><div class="item-title">{{ $collection['product']['eprod_name'] }}</div></a>
									<div class="item-price">{{ get_collection_first_price($collection) }}</div>
								</div>
							</div>
						</div>
						@endforeach
					</div>
				</div> --}}
				<div class="hot-deals-container">
					<div class="wow-title">
						<span class="orange">SPECIAL</span><span class="blue">OFFERS</span>
					</div>
					<div class="item-container">
						<div class="row-no-padding clearfix per-item">
							<div class="col-xs-4"><img class="item-img 4-3-ratio" src="/themes/{{ $shop_theme }}/img/product/1.jpg"></div>
							<div class="col-xs-8">
								<div class=" item-details-container">
									<a href="/product/view/test"><div class="item-title">Samsung Galaxy J2</div></a>
									<div class="item-price">P 5,990.00</div>
								</div>
							</div>
						</div>
						<div class="row-no-padding clearfix per-item">
							<div class="col-xs-4"><img class="item-img 4-3-ratio" src="/themes/{{ $shop_theme }}/img/product/2.jpg"></div>
							<div class="col-xs-8">
								<div class=" item-details-container">
									<a href="/product/view/test"><div class="item-title">Nokia 3310 (20170)</div></a>
									<div class="item-price">P 5,990.00</div>
								</div>
							</div>
						</div>
						<div class="row-no-padding clearfix per-item">
							<div class="col-xs-4"><img class="item-img 4-3-ratio" src="/themes/{{ $shop_theme }}/img/product/3.jpg"></div>
							<div class="col-xs-8">
								<div class=" item-details-container">
									<a href="/product/view/test"><div class="item-title">GSat HD (Complete Set)</div></a>
									<div class="item-price">P 2,499.00</div>
								</div>
							</div>
						</div>
						<div class="row-no-padding clearfix per-item">
							<div class="col-xs-4"><img class="item-img 4-3-ratio" src="/themes/{{ $shop_theme }}/img/product/4.jpg"></div>
							<div class="col-xs-8">
								<div class=" item-details-container">
									<a href="/product/view/test"><div class="item-title">GSat Prepaid (Load Card 500)</div></a>
									<div class="item-price">P 500.00</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			
			<div class="col-md-9">
			<!-- FEATURED TODAY -->
				<div class="featured-container">
					<div class="wow-title">
						<span class="orange">FEATURED</span><span class="blue">TODAY</span>
					</div>
					<div class="featured-item-container clearfix">
						<div class="multiple-item">
							<div>
								<div class="per-item-container">
									<div class="image-content-1">
										<img class="item-image-large 1-1-ratio" src="/themes/{{ $shop_theme }}/img/product/21.jpg">
										<button type="button" onCLick="location.href='/product/view/test'" class="new-add-to-cart-button btn">
											<table>
												<tbody>
													<tr>
														<td class="icon"><i class="fa fa-shopping-cart" aria-hidden="true"></i></td>
														<td class="text">View More</td>
													</tr>
												</tbody>
											</table>
										</button>
									</div>
									<div class="item-details">
										<a href="/product/view/test"><div class="item-title">Samsung Galaxy J2</div></a>
										<div class="item-price">P 5,990.00</div>
									</div>
								</div>
							</div>
							<div>
								<div class="per-item-container">
									<div class="image-content-1">
										<img class="item-image-large 1-1-ratio" src="/themes/{{ $shop_theme }}/img/product/22.jpg">
										<button type="button" onCLick="location.href='/product/view/test'" class="new-add-to-cart-button btn">
											<table>
												<tbody>
													<tr>
														<td class="icon"><i class="fa fa-shopping-cart" aria-hidden="true"></i></td>
														<td class="text">View More</td>
													</tr>
												</tbody>
											</table>
										</button>
									</div>
									<div class="item-details">
										<a href="/product/view/test"><div class="item-title">Oppo A37</div></a>
										<div class="item-price">P 12,990.00</div>
									</div>
								</div>
							</div>
							<div>
								<div class="per-item-container">
									<div class="image-content-1">
										<img class="item-image-large 1-1-ratio" src="/themes/{{ $shop_theme }}/img/product/23.jpg">
										<button type="button" onCLick="location.href='/product/view/test'" class="new-add-to-cart-button btn">
											<table>
												<tbody>
													<tr>
														<td class="icon"><i class="fa fa-shopping-cart" aria-hidden="true"></i></td>
														<td class="text">View More</td>
													</tr>
												</tbody>
											</table>
										</button>
									</div>
									<div class="item-details">
										<a href="/product/view/test"><div class="item-title">Samsung Galaxy A5</div></a>
										<div class="item-price">P 19,990.00</div>
									</div>
								</div>
							</div>
							<div>
								<div class="per-item-container">
									<div class="image-content-1">
										<img class="item-image-large 1-1-ratio" src="/themes/{{ $shop_theme }}/img/product/24.jpg">
										<button type="button" onCLick="location.href='/product/view/test'" class="new-add-to-cart-button btn">
											<table>
												<tbody>
													<tr>
														<td class="icon"><i class="fa fa-shopping-cart" aria-hidden="true"></i></td>
														<td class="text">View More</td>
													</tr>
												</tbody>
											</table>
										</button>
									</div>
									<div class="item-details">
										<a href="/product/view/test"><div class="item-title">Samsung Galaxy A7</div></a>
										<div class="item-price">P 23,990.00</div>
									</div>
								</div>
							</div>
							<div>
								<div class="per-item-container">
									<div class="image-content-1">
										<img class="item-image-large 1-1-ratio" src="/themes/{{ $shop_theme }}/img/product/21.jpg">
										<button type="button" onCLick="location.href='/product/view/test'" class="new-add-to-cart-button btn">
											<table>
												<tbody>
													<tr>
														<td class="icon"><i class="fa fa-shopping-cart" aria-hidden="true"></i></td>
														<td class="text">View More</td>
													</tr>
												</tbody>
											</table>
										</button>
									</div>
									<div class="item-details">
										<a href="/product/view/test"><div class="item-title">Samsung Galaxy J2</div></a>
										<div class="item-price">P 5,990.00</div>
									</div>
								</div>
							</div>
							<div>
								<div class="per-item-container">
									<div class="image-content-1">
										<img class="item-image-large 1-1-ratio" src="/themes/{{ $shop_theme }}/img/product/22.jpg">
										<button type="button" onCLick="location.href='/product/view/test'" class="new-add-to-cart-button btn">
											<table>
												<tbody>
													<tr>
														<td class="icon"><i class="fa fa-shopping-cart" aria-hidden="true"></i></td>
														<td class="text">View More</td>
													</tr>
												</tbody>
											</table>
										</button>
									</div>
									<div class="item-details">
										<a href="/product/view/test"><div class="item-title">Oppo A37</div></a>
										<div class="item-price">P 12,990.00</div>
									</div>
								</div>
							</div>
							<div>
								<div class="per-item-container">
									<div class="image-content-1">
										<img class="item-image-large 1-1-ratio" src="/themes/{{ $shop_theme }}/img/product/23.jpg">
										<button type="button" onCLick="location.href='/product/view/test'" class="new-add-to-cart-button btn">
											<table>
												<tbody>
													<tr>
														<td class="icon"><i class="fa fa-shopping-cart" aria-hidden="true"></i></td>
														<td class="text">View More</td>
													</tr>
												</tbody>
											</table>
										</button>
									</div>
									<div class="item-details">
										<a href="/product/view/test"><div class="item-title">Samsung Galaxy A5</div></a>
										<div class="item-price">P 19,990.00</div>
									</div>
								</div>
							</div>
							<div>
								<div class="per-item-container">
									<div class="image-content-1">
										<img class="item-image-large 1-1-ratio" src="/themes/{{ $shop_theme }}/img/product/24.jpg">
										<button type="button" onCLick="location.href='/product/view/test'" class="new-add-to-cart-button btn">
											<table>
												<tbody>
													<tr>
														<td class="icon"><i class="fa fa-shopping-cart" aria-hidden="true"></i></td>
														<td class="text">View More</td>
													</tr>
												</tbody>
											</table>
										</button>
									</div>
									<div class="item-details">
										<a href="/product/view/test"><div class="item-title">Samsung Galaxy A7</div></a>
										<div class="item-price">P 23,990.00</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="best-seller-container">
					<div class="wow-title">
						<span class="orange">BEST</span><span class="blue">SELLER</span>
					</div>
					<div class="best-item-container row clearfix">	
						<div class="col-md-4">
							<div class="per-item-container">
								<div class="row clearfix">
									<div class="col-md-6 col-sm-12">
										<a href="#"><img class="item-image-small 4-3-ratio" style="width: 100%;" src="/themes/{{ $shop_theme }}/img/product/31.jpg"></a>
									</div>
									<div class="col-md-6 col-sm-12">
										<div class="item-details" style="padding-top: 0;">
											<a href="/product/view/test"><div class="item-title">GSat Prepaid (Load 99)</div></a>
											<div class="item-price">P 99.00</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-4">
							<div class="per-item-container">
								<div class="row clearfix">
									<div class="col-md-6 col-sm-12">
										<a href="#"><img class="item-image-small 4-3-ratio" style="width: 100%;" src="/themes/{{ $shop_theme }}/img/product/32.jpg"></a>
									</div>
									<div class="col-md-6 col-sm-12">
										<div class="item-details" style="padding-top: 0;">
											<a href="/product/view/test"><div class="item-title">GSat Prepaid (Load 200)</div></a>
											<div class="item-price">P 200.00</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-4">
							<div class="per-item-container">
								<div class="row clearfix">
									<div class="col-md-6 col-sm-12">
										<a href="#"><img class="item-image-small 4-3-ratio" style="width: 100%;" src="/themes/{{ $shop_theme }}/img/product/33.jpg"></a>
									</div>
									<div class="col-md-6 col-sm-12">
										<div class="item-details" style="padding-top: 0;">
											<a href="/product/view/test"><div class="item-title">GSat Prepaid (Load 300)</div></a>
											<div class="item-price">P 300.00</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-4">
							<div class="per-item-container">
								<div class="row clearfix">
									<div class="col-md-6 col-sm-12">
										<a href="#"><img class="item-image-small 4-3-ratio" style="width: 100%;" src="/themes/{{ $shop_theme }}/img/product/34.jpg"></a>
									</div>
									<div class="col-md-6 col-sm-12">
										<div class="item-details" style="padding-top: 0;">
											<a href="/product/view/test"><div class="item-title">GSat Prepaid (Load 500)</div></a>
											<div class="item-price">P 500.00</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-4">
							<div class="per-item-container">
								<div class="row clearfix">
									<div class="col-md-6 col-sm-12">
										<a href="#"><img class="item-image-small 4-3-ratio" style="width: 100%;" src="/themes/{{ $shop_theme }}/img/product/35.jpg"></a>
									</div>
									<div class="col-md-6 col-sm-12">
										<div class="item-details" style="padding-top: 0;">
											<a href="/product/view/test"><div class="item-title">GSat Pinoy (Complete Set)</div></a>
											<div class="item-price">P 1,999.00</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-4">
							<div class="per-item-container">
								<div class="row clearfix">
									<div class="col-md-6 col-sm-12">
										<a href="#"><img class="item-image-small 4-3-ratio" style="width: 100%;" src="/themes/{{ $shop_theme }}/img/product/36.jpg"></a>
									</div>
									<div class="col-md-6 col-sm-12">
										<div class="item-details" style="padding-top: 0;">
											<a href="/product/view/test"><div class="item-title">GSat HD (Complete Set)</div></a>
											<div class="item-price">P 2,499.00</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="featured-container">
					<div class="wow-title">
						<span class="orange">NEW</span><span class="blue">ARRIVALS</span>
					</div>
					<div class="featured-item-container clearfix">	
						<div class="multiple-item">
							<div>
								<div class="per-item-container">
									<div class="image-content-1">
										<img class="item-image-large 1-1-ratio" src="/themes/{{ $shop_theme }}/img/product/41.jpg">
										<button type="button" onCLick="location.href='/product/view/test'" class="new-add-to-cart-button btn">
											<table>
												<tbody>
													<tr>
														<td class="icon"><i class="fa fa-shopping-cart" aria-hidden="true"></i></td>
														<td class="text">View More</td>
													</tr>
												</tbody>
											</table>
										</button>
									</div>
									<div class="item-details">
										<a href="/product/view/test"><div class="item-title">Oppo F3 Plus</div></a>
										<div class="item-price">P 23,990.00</div>
									</div>
								</div>
							</div>
							<div>
								<div class="per-item-container">
									<div class="image-content-1">
										<img class="item-image-large 1-1-ratio" src="/themes/{{ $shop_theme }}/img/product/42.jpg">
										<button type="button" onCLick="location.href='/product/view/test'" class="new-add-to-cart-button btn">
											<table>
												<tbody>
													<tr>
														<td class="icon"><i class="fa fa-shopping-cart" aria-hidden="true"></i></td>
														<td class="text">View More</td>
													</tr>
												</tbody>
											</table>
										</button>
									</div>
									<div class="item-details">
										<a href="/product/view/test"><div class="item-title">Samsung Galaxy J2</div></a>
										<div class="item-price">P 5,990.00</div>
									</div>
								</div>
							</div>
							<div>
								<div class="per-item-container">
									<div class="image-content-1">
										<img class="item-image-large 1-1-ratio" src="/themes/{{ $shop_theme }}/img/product/43.jpg">
										<button type="button" onCLick="location.href='/product/view/test'" class="new-add-to-cart-button btn">
											<table>
												<tbody>
													<tr>
														<td class="icon"><i class="fa fa-shopping-cart" aria-hidden="true"></i></td>
														<td class="text">View More</td>
													</tr>
												</tbody>
											</table>
										</button>
									</div>
									<div class="item-details">
										<a href="/product/view/test"><div class="item-title">Samsung Galaxy A7</div></a>
										<div class="item-price">P 23,990.00</div>
									</div>
								</div>
							</div>
							<div>
								<div class="per-item-container">
									<div class="image-content-1">
										<img class="item-image-large 1-1-ratio" src="/themes/{{ $shop_theme }}/img/product/44.jpg">
										<button type="button" onCLick="location.href='/product/view/test'" class="new-add-to-cart-button btn">
											<table>
												<tbody>
													<tr>
														<td class="icon"><i class="fa fa-shopping-cart" aria-hidden="true"></i></td>
														<td class="text">View More</td>
													</tr>
												</tbody>
											</table>
										</button>
									</div>
									<div class="item-details">
										<a href="/product/view/test"><div class="item-title">Vivo V5 Plus</div></a>
										<div class="item-price">P 19,990.00</div>
									</div>
								</div>
							</div>
							<div>
								<div class="per-item-container">
									<div class="image-content-1">
										<img class="item-image-large 1-1-ratio" src="/themes/{{ $shop_theme }}/img/product/41.jpg">
										<button type="button" onCLick="location.href='/product/view/test'" class="new-add-to-cart-button btn">
											<table>
												<tbody>
													<tr>
														<td class="icon"><i class="fa fa-shopping-cart" aria-hidden="true"></i></td>
														<td class="text">View More</td>
													</tr>
												</tbody>
											</table>
										</button>
									</div>
									<div class="item-details">
										<a href="/product/view/test"><div class="item-title">Oppo F3 Plus</div></a>
										<div class="item-price">P 23,990.00</div>
									</div>
								</div>
							</div>
							<div>
								<div class="per-item-container">
									<div class="image-content-1">
										<img class="item-image-large 1-1-ratio" src="/themes/{{ $shop_theme }}/img/product/42.jpg">
										<button type="button" onCLick="location.href='/product/view/test'" class="new-add-to-cart-button btn">
											<table>
												<tbody>
													<tr>
														<td class="icon"><i class="fa fa-shopping-cart" aria-hidden="true"></i></td>
														<td class="text">View More</td>
													</tr>
												</tbody>
											</table>
										</button>
									</div>
									<div class="item-details">
										<a href="/product/view/test"><div class="item-title">Samsung Galaxy J2</div></a>
										<div class="item-price">P 5,990.00</div>
									</div>
								</div>
							</div>
							<div>
								<div class="per-item-container">
									<div class="image-content-1">
										<img class="item-image-large 1-1-ratio" src="/themes/{{ $shop_theme }}/img/product/43.jpg">
										<button type="button" onCLick="location.href='/product/view/test'" class="new-add-to-cart-button btn">
											<table>
												<tbody>
													<tr>
														<td class="icon"><i class="fa fa-shopping-cart" aria-hidden="true"></i></td>
														<td class="text">View More</td>
													</tr>
												</tbody>
											</table>
										</button>
									</div>
									<div class="item-details">
										<a href="/product/view/test"><div class="item-title">Samsung Galaxy A7</div></a>
										<div class="item-price">P 23,990.00</div>
									</div>
								</div>
							</div>
							<div>
								<div class="per-item-container">
									<div class="image-content-1">
										<img class="item-image-large 1-1-ratio" src="/themes/{{ $shop_theme }}/img/product/44.jpg">
										<button type="button" onCLick="location.href='/product/view/test'" class="new-add-to-cart-button btn">
											<table>
												<tbody>
													<tr>
														<td class="icon"><i class="fa fa-shopping-cart" aria-hidden="true"></i></td>
														<td class="text">View More</td>
													</tr>
												</tbody>
											</table>
										</button>
									</div>
									<div class="item-details">
										<a href="/product/view/test"><div class="item-title">Vivo V5 Plus</div></a>
										<div class="item-price">P 19,990.00</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="brand-container">
					<div>
						<div class="wow-title" style="border-bottom: 0; padding: 15px 40px;">
							<span class="orange">OUR</span><span class="blue">BRANDS</span>
						</div>
						<div id="brand-logo" class="multiple-item">
						{{-- @if(is_serialized(get_content($shop_theme_info, "home", "home_brand")))
							@foreach(unserialize(get_content($shop_theme_info, "home", "home_brand")) as $brand)
							<div>
								<img class="item-image-small brand-image" src="{{ $brand }}">
							</div>
							@endforeach
						@else
						<div>
							<img class="item-image-small brand-image" src="/themes/{{ $shop_theme }}/img/brand1.png">
						</div>
						<div>
							<img class="item-image-small brand-image" src="/themes/{{ $shop_theme }}/img/brand2.png">
						</div>
						<div>
							<img class="item-image-small brand-image" src="/themes/{{ $shop_theme }}/img/brand3.png">
						</div>
						<div>
							<img class="item-image-small brand-image" src="/themes/{{ $shop_theme }}/img/brand4.png">
						</div>
						<div>
							<img class="item-image-small brand-image" src="/themes/{{ $shop_theme }}/img/brand1.png">
						</div>
						<div>
							<img class="item-image-small brand-image" src="/themes/{{ $shop_theme }}/img/brand2.png">
						</div>
						<div>
							<img class="item-image-small brand-image" src="/themes/{{ $shop_theme }}/img/brand3.png">
						</div>
						<div>
							<img class="item-image-small brand-image" src="/themes/{{ $shop_theme }}/img/brand4.png">
						</div>
						@endif --}}
							<div>
								<img class="item-image-small brand-image" src="/themes/{{ $shop_theme }}/img/logo/1.jpg">
							</div>
							<div>
								<img class="item-image-small brand-image" src="/themes/{{ $shop_theme }}/img/logo/2.jpg">
							</div>
							<div>
								<img class="item-image-small brand-image" src="/themes/{{ $shop_theme }}/img/logo/3.jpg">
							</div>
							<div>
								<img class="item-image-small brand-image" src="/themes/{{ $shop_theme }}/img/logo/4.jpg">
							</div>
						</div>
					</div>
				</div>
			</div>
			

			<div class="col-md-9">
			<!-- BEST SELLER -->
				
			</div>
		</div>
	</div>	
</div>
@endsection

@section("css")
<link rel="stylesheet" type="text/css" href="/themes/{{ $shop_theme }}/css/home.css">
<style type="text/css">
.slick-initialized .slick-slide {
    float: none;
    display: inline-block;
    vertical-align: middle;
}
</style>
@endsection

@section("js")
<script type="text/javascript">
$(document).ready(function()
{
	$('.multiple-item').slick({
	  infinite: true,
	  slidesToShow: 4,
	  slidesToScroll: 1,
	  autoplay: true,
  	  autoplaySpeed: 5000,
  	  arrows: true,
  	  prevArrow:"<img class='a-left control-c prev slick-prev' src='/themes/{{ $shop_theme }}/img/left-carousel.jpg'>",
      nextArrow:"<img class='a-right control-c next slick-next' src='/themes/{{ $shop_theme }}/img/right-carousel.jpg'>"
	});

	$('.add-slider .add-top').slick({
	  lazyLoad: 'ondemand',
	  prevArrow:"<img class='a-left control-c prev slick-prev' src='/themes/{{ $shop_theme }}/img/arrow-left.png'>",
      nextArrow:"<img class='a-right control-c next slick-next' src='/themes/{{ $shop_theme }}/img/arrow-right.png'>",
      autoplay: true,
  	  autoplaySpeed: 5000,
	});
});
</script>
@endsection