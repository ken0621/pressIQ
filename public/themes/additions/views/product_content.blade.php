@extends("layout")
@section("content")
<form method="POST" class="form-to-submit">
<input type="hidden" name="_token" value="{{csrf_token()}}">
<div class="container">
	<?php $ctr = 0; ?>
	@foreach($product["variant"] as $product_variant)
	<div class="body-content container {{ $ctr != 0 ? 'hide' : '' }}" variant-id="{{ $product_variant['evariant_id'] }}">
		<div class="intro">
			<div class="row clearfix">
				<div class="col-md-6">
					<div class="image match-height">
						<div class="slider-for">
						{{-- @foreach($product->product_image as $key => $image) --}}
							<div>
								<div class="holder">
									@foreach($product_variant['image'] as $key => $image)
									{{ dd($image['image_path']) }}
									<img class="single-product-img key-{{$key}} {{ $key == 0 ? '' : 'hide' }} {{$ctr != 0 ? '' : 'first-img'}}" variant-id="{{ $product_variant['evariant_id'] }}" key="{{ $key }}" src="{{ $image['image_path'] }}" data-zoom-image="{{ $image['image_path'] }}">
									@endforeach
								</div>
							</div>
						{{-- @endforeach --}}
						</div>
						<div class="slider-nav">
                        {{-- @foreach($product->product_image as $key => $image) --}}
                            {{-- <div>
                                <div class="holder product-image"><img src="/assets/front/img/placeholder.png"></div>
                            </div> --}}
                        {{-- @endforeach --}}
                    	</div>
					</div>
					<div class="image-gallery">
						
					</div>
				</div>
				<div class="col-md-6">
					<div class="info match-height">
						<div class="name">
							<div class="product-title-price">
								<font>Product Name</font>
								<font class="pull-right top-price variant-price">PHP. 1.00</font>
								<img src="/themes/{{ $shop_theme }}/assets/front/img/loader.gif" style="width:30px" class="ajax-loading hide pull-right">
							</div>
						</div>
						<div class="desc-title">Description</div>
						<div class="desc">Description Here</div>
						<div class="item-number-title">Item No.</div>
						<div class="item-number">123</div>
						<div class="available-stocks-title">Available Stocks</div>
						<img src="/themes/{{ $shop_theme }}/assets/front/img/loader.gif" style="width:18px" class="ajax-loading hide">
						<div class="available-stocks variant-inventory-count" value="0">Please select a variant</div>
						<div class="row" id="option_container">
							{{-- @foreach($product_option as $key=>$option) --}}
								<div class="clearfix col-md-4">
									<div class="size-title">Option Name</div>
									 <div class="size-desc ">
										<select name="option_value[]" class="size-desc option_value">
											<option>--Choose One--</option>
											{{-- @foreach($option['option_value'] as $key2=>$value)
												<option value="{{$value}}">{{$value}}</option>
											@endforeach --}}
										</select>
									</div> 
								</div>
							{{-- @endforeach --}}
						</div>

						<div class="row quantity">
							<div class="col-md-6">
								<button class="btn add-cart add-to-cart-button" type="submit" formaction="/product/addtocart" >ADD TO CART <img src="/themes/{{ $shop_theme }}/assets/front/img/loader.gif" style="width:18px" class="ajax-loading-cart hide"><img src="/themes/{{ $shop_theme }}/front/add-to-cart-white.png"></button>
								<!-- <span class="note variant-note">*Select a Variant</span> -->
							</div>
							<div class="input-count col-md-6">
								<table>
									<tbody>
										<tr>
											<td><div class="adjust btn-add">+</div></td>
											<td><input type="text" onkeypress='return event.charCode >= 48 && event.charCode <= 57' class="input-adjust form-control" autocomplete="off" name="quantity" value="1"></td>
											<td><div class="adjust btn-minus">-</div></td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		</form>

		<!-- RELATED PRODUCTS -->
		<div class="rel-product">
			<div class="rel-product-title">RELATED <font class="product">PRODUCT</font></div>
			{{-- @if($_related)
				@foreach($_related as $related) --}}
				<div class="col-md-3 col-sm-33 col-sm-bottom col-bottom">
					<div class="list-product"  class="prodimg">
						<div class="img">
							<img src="/assets/front/img/placeholder.png">
							<div class="show-cart-view cart-hidden hidden">
								<a href="/product/view?id="><img class="magnify-glass" src="/themes/{{ $shop_theme }}/front/magnify-black.png"></a>
								{{-- @if($related->product_has_variations == 0) --}}
									<img src="/themes/{{ $shop_theme }}/front/bag-black.png" class='bag add-to-cart account-modal-button' style='cursor: pointer;' type='cart'>
								{{-- @endif --}}
							</div>
						</div>
						<div class="prod-name name">Product Name</div>
						<div class="prod-price price">Product Price</div>
					</div>
				</div>
				{{-- @endforeach
			@endif --}}
			<!-- <div class="col-md-3">
				<div class="list">
					<div class="img"><img src="/assets/front/img/test-product.jpg"></div>
					<div class="prod-name">NUTRA-CEUTICALS</div>
					<div class="prod-price">P 200.00</div>
				</div>
			</div> -->
		</div>
	</div>
	@endforeach
</div>

@endsection
@section("css")
<link rel="stylesheet" type="text/css" href="/themes/{{ $shop_theme }}/assets/front/css/view_product.css">
<link rel="stylesheet" type="text/css" href="/themes/{{ $shop_theme }}/assets/front/css/product.css">
@endsection
@section("script")
{{-- <script type="text/javascript" src="/themes/{{ $shop_theme }}/assets/front/js/product.js"></script> --}}
<script type="text/javascript" src="/assets/front/js/zoom.js"></script>
<script type="text/javascript">
var product_image = ".single-product-img";
var button_cart = ".add-to-cart-button";
var product_container = ".body-content";
var product_quantity = ".input-adjust";
var cart_holder = '.cart-dropdown';
</script>
<script type="text/javascript" src="/assets/front/js/global_addcart.js"></script>
@endsection