@extends("layout")
@section("content")

<!-- <div class="product-filter">
	<div class="filter-title">SHOP</div>
	<div class="filter-category">
		<div class="filter-main-category">TOPS</div>
		<div class="filter-sub-category hidden"></div>
		<div class="filter-main-category">DRESS</div>
		<div class="filter-sub-category">
			<a href="#">DRESS</a>
			<a href="#">MAXI DRESS</a>
			<a href="#">JUMPER</a>
		</div>
		<div class="filter-main-category">BOTTOMS</div>
		<div class="filter-sub-category hidden"></div>
	</div>
</div> -->
<div class="container">
	<table class="product-container">
		<tr>
			<td class="product-filter">
				<div class="filter-title">SHOP</div>
				<div class="filter-category">
					<div class="filter-main-category">
						<span class="category {{Request::input('type_id') == null ? 'active' : ''}}">All</a>
					</div>
					{{-- @foreach($_category as $category)
						<div class="filter-main-category">
							<span class="category" id="{{$category->type_id}}">{{$category->type_name}}</span>
						</div>
					@endforeach --}}
				</div>
			</td>

			<td class="body-content">
				<div class="head-data">
					<div class="">
						<div class="product-header">
							<img src="/themes/{{ $shop_theme }}/front/dress-header.jpg">
							<div class="header-container">
								<p class="header-title category_name">ALL</p>
								<p class="header-link">CLOTHES > <font class="category_name"> ALL </font></p>
							</div>
						</div>
					</div>
				</div>

				<div class="filter-search clearfix">
					<ul class="nav navbar-nav pull-right">
					    <li>
					      <div class="search-combine clearfix">
					        <h5>SORTED BY : &nbsp;</h5>
					      </div>
					    </li>
					    <li class="cart-contain">
					    	<!-- <form method="post" action="/product"> -->
					    		{{-- <input type="hidden" name="_token" value="{{csrf_token()}}">
						    	<select class="form-control sorted_by" name="sorted_by">
						    		<option {{(Request::input("sorted_by")) ? ((Request::input("sorted_by")) == 'product_name-SORT_ASC' ? 'selected=selected' : '') : '' }} value="product_name-SORT_ASC">Name : A - Z</option>
						    		<option {{(Request::input("sorted_by")) ? ((Request::input("sorted_by")) == 'product_name-SORT_DESC' ? 'selected=selected' : '') : '' }} value="product_name-SORT_DESC">Name : Z - A</option>
						    		<option {{(Request::input("sorted_by")) ? ((Request::input("sorted_by")) == 'min_price-SORT_ASC' ? 'selected=selected' : '') : '' }} value="min_price-SORT_ASC">Price : Low - High</option>
						    		<option {{(Request::input("sorted_by")) ? ((Request::input("sorted_by")) == 'max_price-SORT_DESC' ? 'selected=selected' : '') : '' }} value="max_price-SORT_DESC">Price : High - Low</option>
						    	</select>
						    	<noscript><input type="submit" value="Submit"></noscript> --}}
					    	<!-- </form> -->
					    	<form class="sort-by" method="get">
							<input type="hidden" name="type" value="{{ Request::input('type') }}">
								<div class="sortby">
									<select class="sorted_by form-control" name="sort" onChange="$('.sort-by').submit();">
										<!-- <option value="" {{ Request::input('sort') == '' ? 'selected' : '' }}>Relevance</option> -->
										<option value="name_asc" {{ Request::input('sort') == 'name_asc' ? 'selected' : '' }}>Brand: A - Z</option>
										<option value="name_desc" {{ Request::input('sort') == 'name_desc' ? 'selected' : '' }}>Brand: Z - A</option>
										<option value="price_desc" {{ Request::input('sort') == 'price_desc' ? 'selected' : '' }}>Price: Low - High</option>
										<option value="price_asc" {{ Request::input('sort') == 'price_asc' ? 'selected' : '' }}>Price: High - Low</option>
										<option value="newest" {{ Request::input('sort') == 'newest' ? 'selected' : '' }}>Newest</option>
									</select>
								</div>
							</form>
					    </li>
					</ul>
				</div>

				<div class="content">
					<div class="single-product">
						<div class="title"></div>
						<div class="row row-height ">
							<div class="load-table">
								@if($_product)
									@foreach($_product as $product)
									<div class="col-md-4 col-sm-6 col-sm-bottom col-bottom">
										<div class="list-product" id="{{$product["eprod_id"]}}" class="prodimg">
											<div class="img">
												<img src="{{get_product_first_image($product)}}">
												<div class="show-cart-view cart-hidden{{$product["eprod_id"]}} hidden">
													<a href="/product/view/{{ $product["eprod_id"] }}"><img class="magnify-glass" src="/themes/{{ $shop_theme }}/front/magnify-black.png"></a>
													<img src="/themes/{{ $shop_theme }}/front/bag-black.png" class='bag add-to-cart account-modal-button' style='cursor: pointer;'>
												</div>
											</div>
											<div class="prod-name name">{{ get_product_first_name($product) }}</div>
											<div class="prod-price price">{{ get_product_first_price($product) }}</div>
										</div>
									</div>
									@endforeach
									<div class="col-md-12 col-sm-12">
										<div class="text-right">{!! $_product->appends(Request::input())->render() !!}</div>
									</div>
								@else
									<div class="no-product-container">
										<span>-- No Product Available --</span>
									</div>
								@endif
							</div>
						</div>
					</div>
				</div>
			</td>
		</tr>
	</table>
</div>
@endsection
@section("css")
<link rel="stylesheet" type="text/css" href="/themes/{{ $shop_theme }}/assets/front/css/product.css">
@endsection
@section("script")
<script type="text/javascript" src="/themes/{{ $shop_theme }}/assets/front/js/product.js"></script>
<script type="text/javascript" src="/themes/{{ $shop_theme }}/assets/front/js/product_filter.js"></script>
@endsection