@extends('layout')
@section('content')
<div class="container checkout">
	<div class="row clearfix">
		<div class="col-md-12 text-center">
			<img src="/resources/assets/img/checkout.jpg">
		</div>
		<div class="col-md-8">
			<div class="checkout-form">
				<form id="check-out" method="post">
					<input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
					<div class="fieldset">
						@if(!isset($customer))
						<div class="title col-md-12">You need an account to monitor your shipping.</div>
						@else
						<div class="title col-md-12">Shipping Details</div>
						@endif
					</div>

					@if(session("error"))
					    <div class="alert alert-danger">
					        <ul>

					                <li>{{ session("error") }}</li>
					        </ul>
					    </div>
					@endif

					<div class="fieldset">
						<label class="col-md-4">First and Last Name</label>
						<div class="field col-md-8">
							<input  class="form-control" type="text" name="full_name" value="{{ old('full_name') }}">
						</div>
					</div>

					<div class="fieldset">
						<label class="col-md-4">Province</label>
						<div class="field col-md-8">
							<input class="form-control" type="text" name="customer_state_province" value="{{ old('customer_state_province') }}">
						</div>
					</div>
					<div class="fieldset">
						<label class="col-md-4">City / Municipality</label>
						<div class="field col-md-8">
							<input class="form-control" type="text" name="customer_city" value="{{ old('customer_city') }}">
						</div>
					</div>
					<div class="fieldset">
						<label class="col-md-4">Complete Address</label>
						<div class="field col-md-8">
							<textarea spellcheck="false" class="form-control" name="customer_address">{{ Request::old('customer_address') }}</textarea>
						</div>
					</div>

					<div class="fieldset">
						<label class="col-md-4">Contact Number</label>
						<div class="field col-md-8">
							<input  maxlength="11" class="form-control" type="text" name="customer_mobile" value="{{ Request::input('customer_mobile') }}">
						</div>
					</div>

					<div class="fieldset text-right btn-container">
						<div class="col-md-12">
							@if(!isset($customer))
							<button class="btn btn-primary">CREATE ACCOUNT THEN CONTINUE <i class="fa fa-angle-double-right"></i></button>
							@else
							<button class="btn btn-primary">NEXT <i class="fa fa-angle-double-right"></i></button>
							@endif
						</div>
					</div>
				</form>
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
					        		<li style="display: block;">{{ $fail }}</li>
						        @endforeach
						        </ul>
						    @else
						    	<ul style="padding: 0; margin: 0;">
						    		<li style="display: block;">{{ session('fail') }}</li>
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

@section('script')
<script type="text/javascript" src="resources/assets/rutsen/js/checkout.js"></script>
<script type="text/javascript">
$(document).ready(function()
{
	if ( $('.payment-method-select').val() != 1 && $('.payment-method-select').val() != 2 && $('.payment-method-select').val() != 8 ) 
	{
		$('.payment-upload').removeClass("hide");
	}	
	else
	{
		$('.payment-upload').addClass("hide");
	}

	$('.payment-method-select').change(function(event) 
	{
		if ( $(event.currentTarget).val() != 1 && $(event.currentTarget).val() != 2 && $(event.currentTarget).val() != 8 ) 
		{
			$('.payment-upload').removeClass("hide");
		}	
		else
		{
			$('.payment-upload').addClass("hide");
		}
	});
});
</script>
@endsection

@section('css')
<link rel="stylesheet" href="resources/assets/frontend/css/checkout.css">
@endsection