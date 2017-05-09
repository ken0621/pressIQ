@extends('layout')
@section('content')
<div class="container main-container">
	<div class="row clearfix">
		<div class="col-md-8">
			<div class="form-holder">
				<div class="form-header">Login or Checkout as guest</div>
				<div class="form-content">
					<div class="form-group">
						<input type="text" class="form-control" placeholder="Enter your email address" name="email_address">
					</div>
					<div class="form-group">
						<div class="radio">
						  <label><input type="radio" name="optradio"> Continue without password</label>
						</div>
						<div class="radio">
						  <label><input type="radio" name="optradio"> I already have an account</label>
						</div>
					</div>
					<div class="form-group text-right">
						<a href="javascript:">Lost your password?</a>
					</div>
					<div class="form-group">
						<button class="btn btn-primary">CONTINUE</button>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-4">
			<div class="checkout-summary">
				<div class="title">Order Summary</div>
				<div class="order-summary">
					@if (session('fail'))
					    <div class="alert alert-danger">
					    	@if(is_array(session('fail')))
					    		<ul>
						        @foreach(session('fail') as $fail)
					        		<li>{{ $fail }}</li>
						        @endforeach
						        </ul>
						    @else
						    	<ul style="padding: 0; margin: 0;">
						    		<li>{{ session('fail') }}</li>
						    	</ul>
					        @endif
					    </div>
					@endif
					<div class="number-in-cart">You have {{ count($get_cart["cart"]) }} in your cart.</div>
					<table>
						<thead>
							<tr>
								<th>Product</th>
								<th class="text-center">Qty.</th>
								<th class="text-right">Price</th>
								<th></th>
							</tr>
						</thead>
						<tbody>
							@foreach($get_cart["cart"] as $cart)
							<tr>
								<td>{{ $cart["cart_product_information"]["product_name"] }}</td>
								<td class="text-center">{{ $cart["quantity"] }}</td>
								<td class="text-right">&#8369; {{ number_format($cart['quantity'] * $cart["cart_product_information"]["product_price"], 2) }}</td>
								<td style="padding-left: 10px;"><a style="color: red;" href="/cart/remove?redirect=1&variation_id={{ $cart["product_id"] }}"><i class="fa fa-close"></i></a></td>
							</tr>
							@endforeach
						</tbody>
					</table>
					<div class="text-right total">
						<div class="total-price">&#8369; {{ number_format($get_cart["sale_information"]["total_product_price"], 2) }}</div>
						<div class="total-label">Subtotal</div>
					</div>	
					<!-- <div class="text-right total">
						<div class="total-price"></div>
						<div class="total-label">tax()</div>
					</div> -->
					<div class="text-right total">
						<div class="total-price">&#8369; {{ number_format($get_cart["sale_information"]["total_shipping"], 2) }}</div>
						<div class="total-label">Shipping Fee</div>
					</div>
					<div class="text-right total ">
						<div class="total-price supertotal">&#8369; {{ number_format($get_cart["sale_information"]["total_overall_price"], 2) }}</div>
						<div class="total-label">Total</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection

@section('css')
<link rel="stylesheet" type="text/css" href="resources/assets/frontend/css/checkout_login.css">
@endsection