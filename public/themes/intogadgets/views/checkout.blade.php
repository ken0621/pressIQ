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
						<div class="title col-md-12">Shipping Details</div>
					</div>

					@if(session("error"))
					    <div class="alert alert-danger">
					        <ul>
					                <li>{{ session("error") }}</li>
					        </ul>
					    </div>
					@endif

					@if(!$customer_info_a)
					<div class="fieldset">
						<label class="col-md-4">First and Last Name</label>
						<div class="field col-md-8">
							<input  class="form-control" type="text" name="full_name" value="{{ old('full_name') }}">
						</div>
					</div>
					@endif

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
						<label class="col-md-4">Barangay</label>
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

		<!-- CART HERE -->
		<div class="col-md-4 order-summary-container">
		</div>
	</div>
</div>

@endsection

@section('script')
<script type="text/javascript">

var checkout_form = new checkout_form();

function checkout_form()
{
	init();

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
	}
	function action_load_sidecart()
	{
		$(".order-summary-container").load("/checkout/side");
	}

}




</script>
@endsection

@section('css')
<link rel="stylesheet" href="resources/assets/frontend/css/checkout.css">
@endsection