@extends("layout")

@section("content")

<div class="container">
	<div class="row clearfix">
		<div class="col-md-4 left-content">
			<div class="categories">
				<div class="categories-title"><i class="fa fa-bars" aria-hidden="true"></i><span class="title">CATEGORIES</span></div>
				<div class="categories-content">
					<div class="list"><a href="">DESKTOP & PC PARTS</a><span><a href=""><img src="/themes/{{ $shop_theme }}/img/categories-cross.png"></a></span></div>
					<div class="list"><a href="">LAPTOP & TABLET</a><span><a href=""><img src="/themes/{{ $shop_theme }}/img/categories-cross.png"></a></span></div>
					<div class="list"><a href="">SMART PHONE</a><span><a href=""><img src="/themes/{{ $shop_theme }}/img/categories-cross.png"></a></span></div>
					<div class="list"><a href="">CAMERA</a><span><a href=""><img src="/themes/{{ $shop_theme }}/img/categories-cross.png"></a></span></div>
					<div class="list"><a href="">HEADPHONE & SPEAKER</a><span><a href=""><img src="/themes/{{ $shop_theme }}/img/categories-cross.png"></a></span></div>
					<div class="list"><a href="">TV & COMPONENTS</a><span><a href=""><img src="/themes/{{ $shop_theme }}/img/categories-cross.png"></a></span></div>
				</div>
			</div>

			<div class="filter-by-price">
				<div class="filter-title"><img src="/themes/{{ $shop_theme }}/img/filter-icon.png"><span class="title">FILTER BY PRICE</span></div>
				<div class="filter-content">
					<div class="bottom"><button>Filter</button><span id="price-word">price:</span><span id="amount"> P0.00 - P1000.00</span></div>
				</div>
			</div>

			<div class="most-viewed">
				<div class="featured-content-container">
					<div class="container-title"><i class="fa fa-star-o" aria-hidden="true"></i><span class="title">MOST VIEWED</span></div>
				</div>
				<div class="most-viewed-content">
					<table>
						<tbody>
							<tr>
								<td class="most-viewed-image"><img src="/themes/{{ $shop_theme }}/img/most-viewed-img1.png"></td>
								<td>
									<div class="item-name">Lorem ipsum dolor sit</div>
										<div class="item-rating">
											<img src="/themes/{{ $shop_theme }}/img/star-colored.png">
											<img src="/themes/{{ $shop_theme }}/img/star-colored.png">
											<img src="/themes/{{ $shop_theme }}/img/star-colored.png">
											<img src="/themes/{{ $shop_theme }}/img/star-colored.png">
											<img src="/themes/{{ $shop_theme }}/img/star-not-colored.png">
										</div>
									<div class="item-price">PHP 5,000.00</div>
								</td>
							</tr>
							<tr>
								<td class="most-viewed-image"><img src="/themes/{{ $shop_theme }}/img/most-viewed-img2.png"></td>
								<td>
									<div class="item-name">Lorem ipsum dolor sit</div>
										<div class="item-rating">
											<img src="/themes/{{ $shop_theme }}/img/star-colored.png">
											<img src="/themes/{{ $shop_theme }}/img/star-colored.png">
											<img src="/themes/{{ $shop_theme }}/img/star-colored.png">
											<img src="/themes/{{ $shop_theme }}/img/star-colored.png">
											<img src="/themes/{{ $shop_theme }}/img/star-not-colored.png">
										</div>
									<div class="item-price">PHP 5,000.00</div>
								</td>
							</tr>
							<tr>
								<td class="most-viewed-image"><img src="/themes/{{ $shop_theme }}/img/most-viewed-img3.png"></td>
								<td>
									<div class="item-name">Lorem ipsum dolor sit</div>
										<div class="item-rating">
											<img src="/themes/{{ $shop_theme }}/img/star-colored.png">
											<img src="/themes/{{ $shop_theme }}/img/star-colored.png">
											<img src="/themes/{{ $shop_theme }}/img/star-colored.png">
											<img src="/themes/{{ $shop_theme }}/img/star-colored.png">
											<img src="/themes/{{ $shop_theme }}/img/star-not-colored.png">
										</div>
									<div class="item-price">PHP 5,000.00</div>
								</td>
							</tr>
							<tr>
								<td class="most-viewed-image"><img src="/themes/{{ $shop_theme }}/img/most-viewed-img4.png"></td>
								<td>
									<div class="item-name">Lorem ipsum dolor sit</div>
										<div class="item-rating">
											<img src="/themes/{{ $shop_theme }}/img/star-colored.png">
											<img src="/themes/{{ $shop_theme }}/img/star-colored.png">
											<img src="/themes/{{ $shop_theme }}/img/star-colored.png">
											<img src="/themes/{{ $shop_theme }}/img/star-colored.png">
											<img src="/themes/{{ $shop_theme }}/img/star-not-colored.png">
										</div>
									<div class="item-price">PHP 5,000.00</div>
								</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>

		<div class="col-md-8 right-content">
			<div class="banner-holder">
				<img src="/themes/{{ $shop_theme }}/img/productpage-banner.png">
			</div>

			<div class="prod-content">
				<div class="top-title">
					<div class="sortby">Sort By: 
						<select>
							<option></option>
							<option>Low-High</option>
							<option>High-Low</option>
						</select>
					</div>
					<span class="pagination-top">
						<ul class="pagination">
							<li><a class="pagination-link" href="#"><img src="/themes/{{ $shop_theme }}/img/left-button-scroll.png"></a></li>
							<li><a class="pagination-link pagination-link-number" href="#">1</a></li>
							<li><a class="pagination-link pagination-link-number" href="#">2</a></li>
							<li><a class="pagination-link pagination-link-number" href="#">3</a></li>
							<li><a class="pagination-link pagination-link-number" href="#">4</a></li>
							<li><a class="pagination-link" href="#"><img src="/themes/{{ $shop_theme }}/img/right-button-scroll.png"></a></li>
						</ul>
					</span>	
				</div>

				<div class="row clearfix">
				<div class="col-md-12 products-container">
					<div class="col-md-3 product-holder">
						<div class="per-item-container">
							<div class="image-holder">
								<img class="item-image-large first-image" src="/themes/{{ $shop_theme }}/img/prod-content-image1.png">
							</div>
							<div class="item-details">
								<div class="item-title"><a href="/product/view">Lorem ipsum dolor sit</a></div>
								<div class="rating">
									<img src="/themes/{{ $shop_theme }}/img/star-colored.png">
									<img src="/themes/{{ $shop_theme }}/img/star-colored.png">
									<img src="/themes/{{ $shop_theme }}/img/star-colored.png">
									<img src="/themes/{{ $shop_theme }}/img/star-colored.png">
									<img src="/themes/{{ $shop_theme }}/img/star-not-colored.png">
								</div>
								<div class="item-price">PHP 5,000.00</div>
							</div>
							<div class="icons">
								<a class="tooltips" href="#"><i class="fa fa-shopping-cart" aria-hidden="true"></i><span>Add to cart</span></a>
								<a class="tooltips" href=""><i class="fa fa-heart" aria-hidden="true"></i><span>Add to Favorite</span></a>
								<a class="tooltips" href=""><i class="fa fa-search" aria-hidden="true"></i><span>Search</span></a>
								<a class="tooltips" href=""><i class="fa fa-camera" aria-hidden="true"></i><span>See Pictures</span></a>
							</div>
						</div>
					</div>

					<div class="col-md-3 product-holder">
						<div class="per-item-container">
							<div class="image-holder">
								<img class="item-image-large first-image" src="/themes/{{ $shop_theme }}/img/prod-content-image2.png">
							</div>
							<div class="item-details">
								<div class="item-title"><a href="/product/view">Lorem ipsum dolor sit</a></div>
								<div class="rating">
									<img src="/themes/{{ $shop_theme }}/img/star-colored.png">
									<img src="/themes/{{ $shop_theme }}/img/star-colored.png">
									<img src="/themes/{{ $shop_theme }}/img/star-colored.png">
									<img src="/themes/{{ $shop_theme }}/img/star-colored.png">
									<img src="/themes/{{ $shop_theme }}/img/star-not-colored.png">
								</div>
								<div class="item-price">PHP 5,000.00</div>
							</div>
							<div class="icons">
								<a class="tooltips" href="#"><i class="fa fa-shopping-cart" aria-hidden="true"></i><span>Add to cart</span></a>
								<a class="tooltips" href=""><i class="fa fa-heart" aria-hidden="true"></i><span>Add to Favorite</span></a>
								<a class="tooltips" href=""><i class="fa fa-search" aria-hidden="true"></i><span>Search</span></a>
								<a class="tooltips" href=""><i class="fa fa-camera" aria-hidden="true"></i><span>See Pictures</span></a>
							</div>
						</div>
					</div>

					<div class="col-md-3 product-holder">
						<div class="per-item-container">
							<div class="image-holder">
								<img class="item-image-large first-image" src="/themes/{{ $shop_theme }}/img/prod-content-image3.png">
							</div>
							<div class="item-details">
								<div class="item-title"><a href="/product/view">Lorem ipsum dolor sit</a></div>
								<div class="rating">
									<img src="/themes/{{ $shop_theme }}/img/star-colored.png">
									<img src="/themes/{{ $shop_theme }}/img/star-colored.png">
									<img src="/themes/{{ $shop_theme }}/img/star-colored.png">
									<img src="/themes/{{ $shop_theme }}/img/star-colored.png">
									<img src="/themes/{{ $shop_theme }}/img/star-not-colored.png">
								</div>
								<div class="item-price">PHP 5,000.00</div>
							</div>
							<div class="icons">
								<a class="tooltips" href="#"><i class="fa fa-shopping-cart" aria-hidden="true"></i><span>Add to cart</span></a>
								<a class="tooltips" href=""><i class="fa fa-heart" aria-hidden="true"></i><span>Add to Favorite</span></a>
								<a class="tooltips" href=""><i class="fa fa-search" aria-hidden="true"></i><span>Search</span></a>
								<a class="tooltips" href=""><i class="fa fa-camera" aria-hidden="true"></i><span>See Pictures</span></a>
							</div>
						</div>
					</div>

					<div class="col-md-3 product-holder">
						<div class="per-item-container">
							<div class="image-holder">
								<img class="item-image-large first-image" src="/themes/{{ $shop_theme }}/img/prod-content-image4.png">
							</div>
							<div class="item-details">
								<div class="item-title"><a href="/product/view">Lorem ipsum dolor sit</a></div>
								<div class="rating">
									<img src="/themes/{{ $shop_theme }}/img/star-colored.png">
									<img src="/themes/{{ $shop_theme }}/img/star-colored.png">
									<img src="/themes/{{ $shop_theme }}/img/star-colored.png">
									<img src="/themes/{{ $shop_theme }}/img/star-colored.png">
									<img src="/themes/{{ $shop_theme }}/img/star-not-colored.png">
								</div>
								<div class="item-price">PHP 5,000.00</div>
							</div>
							<div class="icons">
								<a class="tooltips" href="#"><i class="fa fa-shopping-cart" aria-hidden="true"></i><span>Add to cart</span></a>
								<a class="tooltips" href=""><i class="fa fa-heart" aria-hidden="true"></i><span>Add to Favorite</span></a>
								<a class="tooltips" href=""><i class="fa fa-search" aria-hidden="true"></i><span>Search</span></a>
								<a class="tooltips" href=""><i class="fa fa-camera" aria-hidden="true"></i><span>See Pictures</span></a>
							</div>
						</div>
					</div>

					<div class="col-md-3 product-holder">
						<div class="per-item-container">
							<div class="image-holder">
								<img class="item-image-large first-image" src="/themes/{{ $shop_theme }}/img/prod-content-image5.png">
							</div>
							<div class="item-details">
								<div class="item-title"><a href="/product/view">Lorem ipsum dolor sit</a></div>
								<div class="rating">
									<img src="/themes/{{ $shop_theme }}/img/star-colored.png">
									<img src="/themes/{{ $shop_theme }}/img/star-colored.png">
									<img src="/themes/{{ $shop_theme }}/img/star-colored.png">
									<img src="/themes/{{ $shop_theme }}/img/star-colored.png">
									<img src="/themes/{{ $shop_theme }}/img/star-not-colored.png">
								</div>
								<div class="item-price">PHP 5,000.00</div>
							</div>
							<div class="icons">
								<a class="tooltips" href="#"><i class="fa fa-shopping-cart" aria-hidden="true"></i><span>Add to cart</span></a>
								<a class="tooltips" href=""><i class="fa fa-heart" aria-hidden="true"></i><span>Add to Favorite</span></a>
								<a class="tooltips" href=""><i class="fa fa-search" aria-hidden="true"></i><span>Search</span></a>
								<a class="tooltips" href=""><i class="fa fa-camera" aria-hidden="true"></i><span>See Pictures</span></a>
							</div>
						</div>
					</div>

					<div class="col-md-3 product-holder">
						<div class="per-item-container">
							<div class="image-holder">
								<img class="item-image-large first-image" src="/themes/{{ $shop_theme }}/img/prod-content-image6.png">
							</div>
							<div class="item-details">
								<div class="item-title"><a href="/product/view">Lorem ipsum dolor sit</a></div>
								<div class="rating">
									<img src="/themes/{{ $shop_theme }}/img/star-colored.png">
									<img src="/themes/{{ $shop_theme }}/img/star-colored.png">
									<img src="/themes/{{ $shop_theme }}/img/star-colored.png">
									<img src="/themes/{{ $shop_theme }}/img/star-colored.png">
									<img src="/themes/{{ $shop_theme }}/img/star-not-colored.png">
								</div>
								<div class="item-price">PHP 5,000.00</div>
							</div>
							<div class="icons">
								<a class="tooltips" href="#"><i class="fa fa-shopping-cart" aria-hidden="true"></i><span>Add to cart</span></a>
								<a class="tooltips" href=""><i class="fa fa-heart" aria-hidden="true"></i><span>Add to Favorite</span></a>
								<a class="tooltips" href=""><i class="fa fa-search" aria-hidden="true"></i><span>Search</span></a>
								<a class="tooltips" href=""><i class="fa fa-camera" aria-hidden="true"></i><span>See Pictures</span></a>
							</div>
						</div>
					</div>

					<div class="col-md-3 product-holder">
						<div class="per-item-container">
							<div class="image-holder">
								<img class="item-image-large first-image" src="/themes/{{ $shop_theme }}/img/prod-content-image7.png">
							</div>
							<div class="item-details">
								<div class="item-title"><a href="/product/view">Lorem ipsum dolor sit</a></div>
								<div class="rating">
									<img src="/themes/{{ $shop_theme }}/img/star-colored.png">
									<img src="/themes/{{ $shop_theme }}/img/star-colored.png">
									<img src="/themes/{{ $shop_theme }}/img/star-colored.png">
									<img src="/themes/{{ $shop_theme }}/img/star-colored.png">
									<img src="/themes/{{ $shop_theme }}/img/star-not-colored.png">
								</div>
								<div class="item-price">PHP 5,000.00</div>
							</div>
							<div class="icons">
								<a class="tooltips" href="#"><i class="fa fa-shopping-cart" aria-hidden="true"></i><span>Add to cart</span></a>
								<a class="tooltips" href=""><i class="fa fa-heart" aria-hidden="true"></i><span>Add to Favorite</span></a>
								<a class="tooltips" href=""><i class="fa fa-search" aria-hidden="true"></i><span>Search</span></a>
								<a class="tooltips" href=""><i class="fa fa-camera" aria-hidden="true"></i><span>See Pictures</span></a>
							</div>
						</div>
					</div>

					<div class="col-md-3 product-holder">
						<div class="per-item-container">
							<div class="image-holder">
								<img class="item-image-large first-image" src="/themes/{{ $shop_theme }}/img/prod-content-image8.png">
							</div>
							<div class="item-details">
								<div class="item-title"><a href="/product/view">Lorem ipsum dolor sit</a></div>
								<div class="rating">
									<img src="/themes/{{ $shop_theme }}/img/star-colored.png">
									<img src="/themes/{{ $shop_theme }}/img/star-colored.png">
									<img src="/themes/{{ $shop_theme }}/img/star-colored.png">
									<img src="/themes/{{ $shop_theme }}/img/star-colored.png">
									<img src="/themes/{{ $shop_theme }}/img/star-not-colored.png">
								</div>
								<div class="item-price">PHP 5,000.00</div>
							</div>
							<div class="icons">
								<a class="tooltips" href="#"><i class="fa fa-shopping-cart" aria-hidden="true"></i><span>Add to cart</span></a>
								<a class="tooltips" href=""><i class="fa fa-heart" aria-hidden="true"></i><span>Add to Favorite</span></a>
								<a class="tooltips" href=""><i class="fa fa-search" aria-hidden="true"></i><span>Search</span></a>
								<a class="tooltips" href=""><i class="fa fa-camera" aria-hidden="true"></i><span>See Pictures</span></a>
							</div>
						</div>
					</div>

					<div class="col-md-3 product-holder">
						<div class="per-item-container">
							<div class="image-holder">
								<img class="item-image-large first-image" src="/themes/{{ $shop_theme }}/img/prod-content-image9.png">
							</div>
							<div class="item-details">
								<div class="item-title"><a href="/product/view">Lorem ipsum dolor sit</a></div>
								<div class="rating">
									<img src="/themes/{{ $shop_theme }}/img/star-colored.png">
									<img src="/themes/{{ $shop_theme }}/img/star-colored.png">
									<img src="/themes/{{ $shop_theme }}/img/star-colored.png">
									<img src="/themes/{{ $shop_theme }}/img/star-colored.png">
									<img src="/themes/{{ $shop_theme }}/img/star-not-colored.png">
								</div>
								<div class="item-price">PHP 5,000.00</div>
							</div>
							<div class="icons">
								<a class="tooltips" href="#"><i class="fa fa-shopping-cart" aria-hidden="true"></i><span>Add to cart</span></a>
								<a class="tooltips" href=""><i class="fa fa-heart" aria-hidden="true"></i><span>Add to Favorite</span></a>
								<a class="tooltips" href=""><i class="fa fa-search" aria-hidden="true"></i><span>Search</span></a>
								<a class="tooltips" href=""><i class="fa fa-camera" aria-hidden="true"></i><span>See Pictures</span></a>
							</div>
						</div>
					</div>

					<div class="col-md-3 product-holder">
						<div class="per-item-container">
							<div class="image-holder">
								<img class="item-image-large first-image" src="/themes/{{ $shop_theme }}/img/prod-content-image10.png">
							</div>
							<div class="item-details">
								<div class="item-title"><a href="/product/view">Lorem ipsum dolor sit</a></div>
								<div class="rating">
									<img src="/themes/{{ $shop_theme }}/img/star-colored.png">
									<img src="/themes/{{ $shop_theme }}/img/star-colored.png">
									<img src="/themes/{{ $shop_theme }}/img/star-colored.png">
									<img src="/themes/{{ $shop_theme }}/img/star-colored.png">
									<img src="/themes/{{ $shop_theme }}/img/star-not-colored.png">
								</div>
								<div class="item-price">PHP 5,000.00</div>
							</div>
							<div class="icons">
								<a class="tooltips" href="#"><i class="fa fa-shopping-cart" aria-hidden="true"></i><span>Add to cart</span></a>
								<a class="tooltips" href=""><i class="fa fa-heart" aria-hidden="true"></i><span>Add to Favorite</span></a>
								<a class="tooltips" href=""><i class="fa fa-search" aria-hidden="true"></i><span>Search</span></a>
								<a class="tooltips" href=""><i class="fa fa-camera" aria-hidden="true"></i><span>See Pictures</span></a>
							</div>
						</div>
					</div>

					<div class="col-md-3 product-holder">
						<div class="per-item-container">
							<div class="image-holder">
								<img class="item-image-large first-image" src="/themes/{{ $shop_theme }}/img/prod-content-image11.png">
							</div>
							<div class="item-details">
								<div class="item-title"><a href="/product/view">Lorem ipsum dolor sit</a></div>
								<div class="rating">
									<img src="/themes/{{ $shop_theme }}/img/star-colored.png">
									<img src="/themes/{{ $shop_theme }}/img/star-colored.png">
									<img src="/themes/{{ $shop_theme }}/img/star-colored.png">
									<img src="/themes/{{ $shop_theme }}/img/star-colored.png">
									<img src="/themes/{{ $shop_theme }}/img/star-not-colored.png">
								</div>
								<div class="item-price">PHP 5,000.00</div>
							</div>
							<div class="icons">
								<a class="tooltips" href="#"><i class="fa fa-shopping-cart" aria-hidden="true"></i><span>Add to cart</span></a>
								<a class="tooltips" href=""><i class="fa fa-heart" aria-hidden="true"></i><span>Add to Favorite</span></a>
								<a class="tooltips" href=""><i class="fa fa-search" aria-hidden="true"></i><span>Search</span></a>
								<a class="tooltips" href=""><i class="fa fa-camera" aria-hidden="true"></i><span>See Pictures</span></a>
							</div>
						</div>
					</div>

					<div class="col-md-3 product-holder">
						<div class="per-item-container">
							<div class="image-holder">
								<img class="item-image-large first-image" src="/themes/{{ $shop_theme }}/img/prod-content-image12.png">
							</div>
							<div class="item-details">
								<div class="item-title"><a href="/product/view">Lorem ipsum dolor sit</a></div>
								<div class="rating">
									<img src="/themes/{{ $shop_theme }}/img/star-colored.png">
									<img src="/themes/{{ $shop_theme }}/img/star-colored.png">
									<img src="/themes/{{ $shop_theme }}/img/star-colored.png">
									<img src="/themes/{{ $shop_theme }}/img/star-colored.png">
									<img src="/themes/{{ $shop_theme }}/img/star-not-colored.png">
								</div>
								<div class="item-price">PHP 5,000.00</div>
							</div>
							<div class="icons">
								<a class="tooltips" href="#"><i class="fa fa-shopping-cart" aria-hidden="true"></i><span>Add to cart</span></a>
								<a class="tooltips" href=""><i class="fa fa-heart" aria-hidden="true"></i><span>Add to Favorite</span></a>
								<a class="tooltips" href=""><i class="fa fa-search" aria-hidden="true"></i><span>Search</span></a>
								<a class="tooltips" href=""><i class="fa fa-camera" aria-hidden="true"></i><span>See Pictures</span></a>
							</div>
						</div>
					</div>

					<div class="col-md-3 product-holder">
						<div class="per-item-container">
							<div class="image-holder">
								<img class="item-image-large first-image" src="/themes/{{ $shop_theme }}/img/prod-content-image13.png">
							</div>
							<div class="item-details">
								<div class="item-title"><a href="/product/view">Lorem ipsum dolor sit</a></div>
								<div class="rating">
									<img src="/themes/{{ $shop_theme }}/img/star-colored.png">
									<img src="/themes/{{ $shop_theme }}/img/star-colored.png">
									<img src="/themes/{{ $shop_theme }}/img/star-colored.png">
									<img src="/themes/{{ $shop_theme }}/img/star-colored.png">
									<img src="/themes/{{ $shop_theme }}/img/star-not-colored.png">
								</div>
								<div class="item-price">PHP 5,000.00</div>
							</div>
							<div class="icons">
								<a class="tooltips" href="#"><i class="fa fa-shopping-cart" aria-hidden="true"></i><span>Add to cart</span></a>
								<a class="tooltips" href=""><i class="fa fa-heart" aria-hidden="true"></i><span>Add to Favorite</span></a>
								<a class="tooltips" href=""><i class="fa fa-search" aria-hidden="true"></i><span>Search</span></a>
								<a class="tooltips" href=""><i class="fa fa-camera" aria-hidden="true"></i><span>See Pictures</span></a>
							</div>
						</div>
					</div>

					<div class="col-md-3 product-holder">
						<div class="per-item-container">
							<div class="image-holder">
								<img class="item-image-large first-image" src="/themes/{{ $shop_theme }}/img/prod-content-image14.png">
							</div>
							<div class="item-details">
								<div class="item-title"><a href="/product/view">Lorem ipsum dolor sit</a></div>
								<div class="rating">
									<img src="/themes/{{ $shop_theme }}/img/star-colored.png">
									<img src="/themes/{{ $shop_theme }}/img/star-colored.png">
									<img src="/themes/{{ $shop_theme }}/img/star-colored.png">
									<img src="/themes/{{ $shop_theme }}/img/star-colored.png">
									<img src="/themes/{{ $shop_theme }}/img/star-not-colored.png">
								</div>
								<div class="item-price">PHP 5,000.00</div>
							</div>
							<div class="icons">
								<a class="tooltips" href="#"><i class="fa fa-shopping-cart" aria-hidden="true"></i><span>Add to cart</span></a>
								<a class="tooltips" href=""><i class="fa fa-heart" aria-hidden="true"></i><span>Add to Favorite</span></a>
								<a class="tooltips" href=""><i class="fa fa-search" aria-hidden="true"></i><span>Search</span></a>
								<a class="tooltips" href=""><i class="fa fa-camera" aria-hidden="true"></i><span>See Pictures</span></a>
							</div>
						</div>
					</div>

					<div class="col-md-3 product-holder">
						<div class="per-item-container">
							<div class="image-holder">
								<img class="item-image-large first-image" src="/themes/{{ $shop_theme }}/img/prod-content-image15.png">
							</div>
							<div class="item-details">
								<div class="item-title"><a href="/product/view">Lorem ipsum dolor sit</a></div>
								<div class="rating">
									<img src="/themes/{{ $shop_theme }}/img/star-colored.png">
									<img src="/themes/{{ $shop_theme }}/img/star-colored.png">
									<img src="/themes/{{ $shop_theme }}/img/star-colored.png">
									<img src="/themes/{{ $shop_theme }}/img/star-colored.png">
									<img src="/themes/{{ $shop_theme }}/img/star-not-colored.png">
								</div>
								<div class="item-price">PHP 5,000.00</div>
							</div>
							<div class="icons">
								<a class="tooltips" href="#"><i class="fa fa-shopping-cart" aria-hidden="true"></i><span>Add to cart</span></a>
								<a class="tooltips" href=""><i class="fa fa-heart" aria-hidden="true"></i><span>Add to Favorite</span></a>
								<a class="tooltips" href=""><i class="fa fa-search" aria-hidden="true"></i><span>Search</span></a>
								<a class="tooltips" href=""><i class="fa fa-camera" aria-hidden="true"></i><span>See Pictures</span></a>
							</div>
						</div>
					</div>

					<div class="col-md-3 product-holder">
						<div class="per-item-container">
							<div class="image-holder">
								<img class="item-image-large first-image" src="/themes/{{ $shop_theme }}/img/prod-content-image16.png">
							</div>
							<div class="item-details">
								<div class="item-title"><a href="/product/view">Lorem ipsum dolor sit</a></div>
								<div class="rating">
									<img src="/themes/{{ $shop_theme }}/img/star-colored.png">
									<img src="/themes/{{ $shop_theme }}/img/star-colored.png">
									<img src="/themes/{{ $shop_theme }}/img/star-colored.png">
									<img src="/themes/{{ $shop_theme }}/img/star-colored.png">
									<img src="/themes/{{ $shop_theme }}/img/star-not-colored.png">
								</div>
								<div class="item-price">PHP 5,000.00</div>
							</div>
							<div class="icons">
								<a class="tooltips" href="#"><i class="fa fa-shopping-cart" aria-hidden="true"></i><span>Add to cart</span></a>
								<a class="tooltips" href=""><i class="fa fa-heart" aria-hidden="true"></i><span>Add to Favorite</span></a>
								<a class="tooltips" href=""><i class="fa fa-search" aria-hidden="true"></i><span>Search</span></a>
								<a class="tooltips" href=""><i class="fa fa-camera" aria-hidden="true"></i><span>See Pictures</span></a>
							</div>
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
<link rel="stylesheet" type="text/css" href="/themes/{{ $shop_theme }}/css/product.css">
@endsection
