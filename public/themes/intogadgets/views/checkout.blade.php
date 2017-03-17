@extends('layout')
@section('content')
<div class="checkout">
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

				@if (count($errors) > 0)
				    <div class="alert alert-danger">
				        <ul>
				            @foreach ($errors->all() as $error)
				                <li>{{ $error }}</li>
				            @endforeach
				        </ul>
				    </div>
				@endif

				<div class="fieldset">
					<label class="col-md-4">First Name</label>
					<div class="field col-md-8">
						<input  class="form-control" type="text" name="customer_first_name" value="{{ Request::old('customer_first_name') }}">
					</div>
				</div>

				<div class="fieldset">
					<label class="col-md-4">Middle Name</label>
					<div class="field col-md-8">
						<input  class="form-control" type="text" name="customer_middle_name" value="{{ Request::old('customer_middle_name') }}">
					</div>
				</div>

				<div class="fieldset">
					<label class="col-md-4">Last Name</label>
					<div class="field col-md-8">
						<input  class="form-control" type="text" name="customer_last_name" value="{{ Request::old('customer_last_name') }}">
					</div>
				</div>

				<div class="fieldset">
					<label class="col-md-4">Email</label>
					<div class="field col-md-8">
						<input autocomplete="off"  class="form-control" type="email" name="customer_email" value="{{ Request::old('customer_email') }}">
					</div>
				</div>

				<div class="fieldset">
					<label class="col-md-4">Birthday</label>
					<div class="field col-md-8 birthday">
						<div class="bdivider month">
							<select name="customer_birthdate[]" class="form-control">
								<option value="1">January</option>
								<option value="2">February</option>
								<option value="3">March</option>
								<option value="4">April</option>
								<option value="5">May</option>
								<option value="6">June</option>
								<option value="7">July</option>
								<option value="8">August</option>
								<option value="9">September</option>
								<option value="10">October</option>
								<option value="11">November</option>
								<option value="12">December</option>
							</select>
						</div>
						<div class="bdivider day">
							<select name="customer_birthdate[]" class="form-control">
								@for($ctr=1;$ctr<=31;$ctr++)
									<option>
										{{ $ctr }}
									</option>
								@endfor		
							</select>
						</div>
						<div class="bdivider year">
							<select name="customer_birthdate[]" class="form-control">
								@for($ctr=(date("Y")-120);$ctr<=date("Y");$ctr++)
									<option {{ (date("Y")-18) == $ctr ? 'selected' : '' }}>
										{{ $ctr }}
									</option>
								@endfor
							</select>
						</div>
					</div>
				</div>

				<div class="fieldset">
					<label class="col-md-4">Contact Number</label>
					<div class="field col-md-8">
						<input  maxlength="11" class="form-control" type="text" name="customer_mobile" value="{{ Request::input('customer_mobile') }}">
					</div>
				</div>

				@if(!isset($customer))
				<!-- <div class="fieldset">
					<label class="col-md-4">Gender</label>
					<div class="field col-md-8">
						<select name="g" class="form-control">
							<option>Male</option>
							<option>Female</option>
						</select>
					</div>
					<div class="error-message text-right col-md-12">{{ isset($err) ? $err->first('customer_gender') : '' }}</div>
				</div>
			
				<div class="fieldset">
					<label class="col-md-4">Password</label>
					<div class="field col-md-8">
						<input autocomplete="off"  class="form-control" type="password" name="pw" value="">
					</div>
					<div class="error-message text-right col-md-12"></div>
				</div>
				<div class="fieldset">
					<label class="col-md-4">Confirm Password</label>
					<div class="field col-md-8">
						<input autocomplete="off"  class="form-control" type="password" name="cpw" value="">
					</div>
					<div class="error-message text-right col-md-12"></div>
				</div> -->
				@endif
				<!-- <div class="fieldset">
					<label class="col-md-4">Province</label>
					<div class="field col-md-8">
						<select name="p_id" class="form-control province load-child-location" target=".municipality">
							<option value=""></option>
						</select>
					</div>
					<div class="error-message text-right col-md-12">{{ isset($err) ? $err->first('customer_province_id') : '' }}</div>
				</div>
				<div class="fieldset">
					<label class="col-md-4">City / Municipality</label>
					<div class="field col-md-8">
						<select name="m_id" class="form-control municipality load-child-location" target=".barangay">
							<option value=""></option>
						</select>
					</div>
					<div class="error-message text-right col-md-12">{{ isset($err) ? $err->first('customer_city_id') : '' }}</div>
				</div>
				<div class="fieldset">
					<label class="col-md-4">Barangay</label>
					<div class="field col-md-8">
						<select name="b_id" class="form-control barangay">
							<option value=""></option>
						</select>
					</div>
					<div class="error-message text-right col-md-12">{{ isset($err) ? $err->first('customer_barangay_id') : '' }}</div>
				</div>
				<div class="fieldset">
					<label class="col-md-4">Complete Address</label>
					<div class="field col-md-8">
						<textarea spellcheck="false" class="form-control" name="ca"></textarea>
					</div>
					<div class="error-message text-right col-md-12">{{ isset($err) ? $err->first('customer_address') : '' }}</div>
				</div> -->

				<div class="fieldset">
					<label class="col-md-4">Province</label>
					<div class="field col-md-8">
						<input class="form-control" type="text" name="customer_state_province" value="{{ Request::old('customer_state_province') }}">
					</div>
				</div>
				<div class="fieldset">
					<label class="col-md-4">City / Municipality</label>
					<div class="field col-md-8">
						<input class="form-control" type="text" name="customer_city" value="{{ Request::old('customer_city') }}">
					</div>
				</div>
				<div class="fieldset">
					<label class="col-md-4">Complete Address</label>
					<div class="field col-md-8">
						<textarea spellcheck="false" class="form-control" name="customer_address">{{ Request::old('customer_address') }}</textarea>
					</div>
				</div>
				<div class="fieldset">
					<label class="col-md-4">Payment Method</label>
					<div class="field col-md-8">
						<select class="form-control" name="payment_method_id">
							@if(count($_payment_method) != 0)
								@foreach($_payment_method as $payment_method)
								<option value="{{ $payment_method->method_id }}" {{ Request::old('payment_method_id') == $payment_method->method_id ? 'selected' : '' }}>{{ $payment_method->method_name }}</option>
								@endforeach	
							@else
								<option disabled selected>No Payment Method Available</option>
							@endif
						</select>
					</div>
				</div>
				<div class="fieldset">
					<label class="col-md-4">Tax</label>
					<div class="field col-md-8">
						<select name="taxable" class="form-control">
							<option value="1" {{ Request::old('taxable') == 1 ? "selected" : "" }}>With tax</option>
							<option value="0" {{ Request::old('taxable') == 0 ? "selected" : "" }}>Without tax</option>
						</select>
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
				<div class="number-in-cart">You have  in your cart.</div>
				<table>
					<thead>
						<tr>
							<td>Product</td>
							<td class="text-center">Qty.</td>
							<td class="text-right">Price</td>
						</tr>
					</thead>
					<tbody>
						
						<tr>
							<td></td>
							<td class="text-center"></td>
							<td class="text-right"></td>
						</tr>
						
					</tbody>
				</table>
				<div class="text-right total">
					<div class="total-price"></div>
					<div class="total-label">Subtotal</div>
				</div>	
				<div class="text-right total">
					<div class="total-price"></div>
					<div class="total-label">tax()</div>
				</div>
				<div class="text-right total">
					<div class="total-price"></div>
					<div class="total-label">Shipping Fee</div>
				</div>
				<div class="text-right total ">
					<div class="total-price supertotal"></div>
					<div class="total-label">Total</div>
				</div>
			</div>
		</div>
	</div>
</div>

@endsection

@section('script')
<script type="text/javascript" src="resources/assets/rutsen/js/checkout.js"></script>
@endsection

@section('css')
<link rel="stylesheet" href="resources/assets/frontend/css/checkout.css">
@endsection