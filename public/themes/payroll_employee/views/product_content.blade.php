@extends("layout")
@section("content")
<div class="product-bg">
	<div class="container">
		<div class="product-content">
			<table>
				<tr>
					<td class="left">
						<div class="product-holder">
							<div class="product-title">Brown and Proud 1 Smart Phone 4.7" HD IPS Display</div>
							<div class="product-main">
								<div class="row clearfix">
									<div class="col-md-7">
										<div class="product-img">
											<table>
												<tr>
													<td class="thumb-holder">
														<div class="thumb">
															<div class="holder">
																<img src="/themes/{{ $shop_theme }}/img/thumb-1.jpg">
															</div>
															<div class="holder">
																<img src="/themes/{{ $shop_theme }}/img/thumb-2.jpg">
															</div>
															<div class="holder">
																<img src="/themes/{{ $shop_theme }}/img/thumb-3.jpg">
															</div>
														</div>
													</td>
													<td class="img-holder">
														<img class="img" src="/themes/{{ $shop_theme }}/img/1k-reso.jpg">
													</td>
												</tr>
											</table>
										</div>
									</div>
									<div class="col-md-5">
										<div class="product-info">
											<div class="desc">A phone that Filipinos can be proud of Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor.</div>
											<div class="spec">
												<div class="spec-title">Specification</div>
												<div class="spec-list">
													<ul>
														<li><i class="fa fa-circle" aria-hidden="true"></i> 4.7 HD IPS Display</li>
														<li><i class="fa fa-circle" aria-hidden="true"></i> LTE Connection</li>
														<li><i class="fa fa-circle" aria-hidden="true"></i> Android Nougat</li>
														<li><i class="fa fa-circle" aria-hidden="true"></i> 13 MP Back Camera</li>
														<li><i class="fa fa-circle" aria-hidden="true"></i> 8 MP Front Camera</li>
														<li><i class="fa fa-circle" aria-hidden="true"></i> OTG Support</li>
														<li><i class="fa fa-circle" aria-hidden="true"></i> Finger print sensor</li>
														<li><i class="fa fa-circle" aria-hidden="true"></i> Infared Sensor</li>
													</ul>
												</div>
											</div>
											<div class="stock">In Stock</div>
											<div class="price">P 9,500.00</div>
											<div class="qty-add-cart clearfix">
												<div class="qty">
													<div class="qty-title">Quantity</div>
													<div class="qty-input">
														<input class="form-control input-lg" type="number" name="">
													</div>
												</div>
												<div class="add-cart">
													<button class="btn btn-orange">Add to Cart</button>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="product-feature">
								<div class="feature-title">General Features</div>
								<div class="feature-content">
									<p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim.</p>
									<p><img class="img-responsive" src="/themes/{{ $shop_theme }}/img/sample-vid.jpg"></p>
									<p><img class="img-responsive" src="/themes/{{ $shop_theme }}/img/ad-wow.jpg"></p>
									<p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim. Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. In enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo. Nullam dictum felis eu pede mollis pretium. Integer tincidunt.</p>
								</div>
							</div>
						</div>
					</td>
					<td class="right">
						<div class="side-holder">
							<div class="side-title">You May Also Like This</div>
							<div class="side-content">
								<div class="holder">
									<div class="img">
										<img src="/themes/{{ $shop_theme }}/img/side-1.jpg">
									</div>
									<div class="name">Brown 1</div>
									<div class="sub">4.7 HD IPS Display</div>
									<div class="price">P 9,500.00</div>
								</div>
								<div class="holder">
									<div class="img">
										<img src="/themes/{{ $shop_theme }}/img/side-2.jpg">
									</div>
									<div class="name">XB-400</div>
									<div class="sub">4.7 HD IPS Display</div>
									<div class="price">P 9,500.00</div>
								</div>
								<div class="holder">
									<div class="img">
										<img src="/themes/{{ $shop_theme }}/img/side-3.jpg">
									</div>
									<div class="name">Sense 4</div>
									<div class="sub">4.7 HD IPS Display</div>
									<div class="price">P 9,500.00</div>
								</div>
								<div class="holder">
									<div class="img">
										<img src="/themes/{{ $shop_theme }}/img/side-4.jpg">
									</div>
									<div class="name">Sense 4</div>
									<div class="sub">4.7 HD IPS Display</div>
									<div class="price">P 9,500.00</div>
								</div>	
							</div>
						</div>
					</td>
				</tr>
			</table>
		</div>
	</div>
</div>
@endsection
@section("css")
<link rel="stylesheet" type="text/css" href="/themes/{{ $shop_theme }}/css/product_content.css">
@endsection
@section("script")
<script type="text/javascript" src="/assets/front/js/zoom.js"></script>
<script type="text/javascript" src="/themes/{{ $shop_theme }}/js/product_content.js"></script>
@endsection