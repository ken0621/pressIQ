@extends('layout')
@section('content')
<form method="post" action="/checkout" enctype="multipart/form-data">
	<div class="hide">
		@foreach($_input as $key => $input)
			@if(is_array($input))
				@foreach($input as $key0 => $value0)
					<input type="hidden" name="{{ $key }}[]" value="{{ $value0 }}">
				@endforeach
			@else
				<input type="hidden" name="{{ $key }}" value="{{ $input }}">
			@endif
		@endforeach
	</div>
	<div class="container">
		<h2>Choose Payment Method</h2>
		<div class="payment-container">
			<div class="row clearfix">
				<div class="col-md-8">
					@if(count($_payment_method) != 0)
						@foreach($_payment_method as $payment_method)
							<div class="holder">
								<div class="image">
									<img src="{{ $payment_method->image_path ? $payment_method->image_path : '/assets/front/img/default.jpg' }}">
								</div>
								<div class="radio">
								  <label><input type="radio" name="payment_method_id" value="{{ $payment_method->method_id }}">{{ $payment_method->method_name }}</label>
								</div>
							</div>
						@endforeach	
					@else
						<div class="text-center"><h3>No Payment Method Available</h3></div>
					@endif
					<div class="details">
						<div class="detail-holder">
							<div class="details-title">Upload Proof of Payment</div>
							<button class="btn btn-primary" id="upload-button" type="button" onClick="$('.payment-upload-file').trigger('click');">UPLOAD</button>
							<input onChange="$('.upload-name').text($(this).val().split('\\').pop());" class="hide payment-upload-file" type="file" name="payment_upload">
							<div class="upload-name"></div>
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
					<div class="button">
						<button class="btn btn-primary" type="submit">PLACE YOUR ORDER</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</form>
@endsection

@section('script')
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
<link rel="stylesheet" href="resources/assets/frontend/css/checkout_payment.css">
@endsection