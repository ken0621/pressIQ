@extends('layout')
@section('content')
<form method="post" action="/checkout" enctype="multipart/form-data">
	<div class="container">
		<h2>Choose Payment Method</h2>
		<div class="payment-container">
			<div class="row clearfix">
				<div class="col-md-8">
					<div class="holder-holder">
						@if(count($_payment_method) != 0)
							@foreach($_payment_method as $payment_method)
							<label class="choose-payment-method">
								<div class="holder">
									<div class="match-height" style="line-height: 12.5px;">{{ $payment_method->method_name }}</div>
									<div class="image" style="margin-top: 7.5px;">
										<img src="{{ $payment_method->image_path ? $payment_method->image_path : '/assets/front/img/default.jpg' }}">
									</div>
									<div class="radio" style="margin-bottom: 0;">
									  <input type="radio" name="payment_method_id" value="{{ $payment_method->method_id }}">
									</div>
								</div>
							</label>
							@endforeach	
						@else
							<div class="text-center"><h3>No Payment Method Available</h3></div>
						@endif
					</div>
					<div class="details clearfix">
						<div class="detail-holder">
							{{-- <div class="details-title">Upload Proof of Payment</div>
							<button class="btn btn-primary" id="upload-button" type="button" onClick="$('.payment-upload-file').trigger('click');">UPLOAD</button>
							<input onChange="$('.upload-name').text($(this).val().split('\\').pop());" class="hide payment-upload-file" type="file" name="payment_upload">
							<div class="upload-name"></div> --}}
							<div class="details-text">You can pay in cash to our courier when you receive the goods at your doorstep.</div>
							<div class="details-order">
								<button class="btn btn-primary">PLACE YOUR ORDER</button>
							</div>
						</div>
					</div>
				</div>
				<!-- CART HERE -->
				<div class="col-md-4 order-summary-container">
				</div>
			</div>
		</div>
	</div>
</form>
@endsection

@section('script')
<script type="text/javascript" src="js/match-height.js"></script>
<script type="text/javascript">


var checkout_form = new checkout_form();
var ajax_load_location = null;
function checkout_form()
{
	init();

	action_load_location(1, 0);

	function init()
	{
		$(document).ready(function()
		{
			document_ready();
		});
	}
	function document_ready()
	{
		action_load_sidecart();
		action_match_height();
	}
	function action_match_height()
	{
		$('.match-height').matchHeight();
	}
	function action_load_sidecart()
	{
		$(".order-summary-container").load("/checkout/side");
	}
}


</script>
@endsection

@section('css')
<link rel="stylesheet" href="resources/assets/frontend/css/checkout_payment.css">
@endsection