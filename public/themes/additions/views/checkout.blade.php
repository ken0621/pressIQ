@extends("layout")
@section("content")
<div class="intro">
	<div class="text"><img src="/themes/{{ $shop_theme }}/assets/front/img/cart-big.png"> <span>CHECK OUT</span></div>
</div>
<div class="content">
	<form method="POST" action="/payment/getCheckout" id="form_checkout" enctype="multipart/form-data">
	<input type="hidden" name="_token" value="{{csrf_token()}}">
	<div class="info">
		<div class="container">
			<div class="row clearfix">
				<div class="col-md-6">
					@if(Session::has('error_checkout'))
					<div class="alert alert-danger">
						<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
						{{Session::get('error_checkout')}}
					</div>
					@endif

					@if(session("error"))
					    <div class="alert alert-danger" style="margin-top: 25px;">
					        <ul>
					        	<li>{{ session("error") }}</li>
					        </ul>
					    </div>
					@endif

					@if (count($errors) > 0)
					    <div class="alert alert-danger" style="margin-top: 25px;">
					        <ul>
					            @foreach ($errors->all() as $error)
					            	@if($error == "Fail(Bank Declined Transaction)")
					                	<li>Your card was declined. In order to resolve the issue, you will need to contact your back</li>
					                @else
					                	<li>{{ $error }}</li>
					                @endif
					            @endforeach
					        </ul>
					    </div>
					@endif

					<div>
						<div class="form-group col-md-6">
							<label>FULL NAME</label>
							<input class="form-control" required name="full_name" value="{{ isset($customer->first_name) && isset($customer->middle_name) && isset($customer->last_name) ? $customer->first_name . ' ' . $customer->middle_name . ' ' . $customer->last_name : '' }}"></input>
						</div>
					</div>
					<div>
						<div class="form-group col-md-6">
							<label>EMAIL</label>
							<input class="form-control" required type="email" name="email" value="{{ isset($customer->email) ? $customer->email : '' }}"></input>
						</div>
						<div class="form-group col-md-6">
							<label>CONTACT NUMBER</label>
							<input class="form-control" required name="phone" type="text" value=""></input>
						</div>
					</div>
					<div>
						<div class="form-group col-md-6">
							<label>COUNTRY</label>
							<select class="form-control" name="country" required>
			                  <option value="">Select Country</option>
			                  
			                </select>
						</div>
						<div class="form-group col-md-6">
							<label>PROVINCE</label>
							<input class="form-control" required type="text" name="province" value=""></input>
						</div>
					</div>
					<div>
						<div class="form-group col-md-6">
							<label>CITY</label>
							<input class="form-control" required type="text" name="city" value=""></input>
						</div>
						<div class="form-group col-md-6">
							<label>ADDRESS</label>
							<input class="form-control" required type="text" name="_address" value=""></input>
						</div>
					</div>
					<div>
						
						<div class="form-group col-md-6">
							<label>ZIP CODE</label>
							<input class="form-control" required type="text" name="zip_code" value=""></input>
						</div>
						<div class="form-group col-md-6">
							<label>SHIPPING METHOD</label>
							<select class="form-control shippingmethod" id="shippingmethod" name="shippingmethod" required>
								<option value="" data-price="0" selected>Select Shipping Method</option>
							</select>
						</div>	
					</div>
				</div>
				
				<div class="col-md-6">
					<div class="title">Order Summary</div>
					<div class="summary">
						<div class="c-qty">You have no item in your cart.</div>
						<table class="table">
							<thead>
								<tr>
									<th>PRODUCT</th>
									<th>QTY</th>
									<th>PRICE</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td class="name">loremipsum</td>
									<td class="qty">1</td>
									<td class="price">P 900.00</td>
								</tr>
							</tbody>
						</table>
						<div class="total">
							<table>
								<tbody>
									<tr>
										<td>Subtotal</td>
										<td class="table-sub-total text-right"></td>
									</tr>
									<tr>
										<td>Shipping Fee</td>
										<td class="table-ship-fee text-right"></td>
									</tr>
									<tr>
										<td>TOTAL</td>
										<td class="table-total text-right"></td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<input type="hidden" class="hidden-table-sub-total" name="subtotal" value="">
	<input type="hidden" name="" class="hidden-table-total" value="">
	<input type="hidden" name="shipping_fee" class="hidden-table-ship-fee" value="">

	<div class="payment">
		<div class="title">CHOOSE MODE OF PAYMENT</div>
		<div class="container">
			<div class="row clearfix text-center">
				<div class="col-md-3 col-center">
					<div class="image">
						
						<i class="fa fa-paypal fa-5x"></i>
					</div>	
					<div class="radio"><label><input type="radio" class="radio-payment" checked name="paymentmethod" value="Paypal"> PAYPAL</label></div>
					<!-- <div class="desc">Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor.</div> -->
				</div>
				<div class="col-md-3 col-center">
					<div class="image">
						
						<i class="fa fa-university fa-5x"></i>
					</div>	
					<div class="radio"><label><input type="radio" class="radio-payment" name="paymentmethod" value="Bank Deposit"> BANK DEPOSIT</label></div>
					<div></div>
				</div>
				<div class="col-md-3 col-center">
					<div class="image">
						
						<i class="fa fa-exchange fa-5x"></i>
					</div>	
					<div class="radio"><label><input type="radio" class="radio-payment" name="paymentmethod" value="Remitance"> REMITANCE</label></div>
					<!-- <div class="desc">Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor.</div> -->
				</div>
				<div class="col-md-3 col-center">
					<div class="image">
						
						<i class="fa fa-truck fa-5x"></i>
					</div>	
					<div class="radio"><label><input type="radio" class="radio-payment" name="paymentmethod" value="Cash On Delivery"> CASH ON DELIVERY</label></div>
					<!-- <div class="desc">Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor.</div> -->
				</div>
			</div><br>
			<div class="form-horizontal">
				<div class="upload form-group">
					<div class="col-md-6">
						<div class="text">UPLOAD PROOF OF PAYMENT</div>
						<label class="btn btn-orange"><input type="file" class="hide" name="file_proof" id="file_proof"><i class="fa fa-folder"></i>&nbsp;&nbsp;Choose a file</label><br>
						<p ><i class="file_name">No file chosen</i></p>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<div class="col-md-12 div-bank-select">
								<div class="form-group">
									<div class="col-md-12">
										<label for="">Select Bank</label>
										<select class="form-control" name="bank" id="bank">
											<option value="">Select Bank</option>
										</select>
									</div>
								</div>
								<div class="form-group">
									<div class="col-md-12">
										
										<table class="table table-condensed table-bordered " >
											
										</table>
									</div>
								</div>
							</div>
							<div class="col-md-12 div-remittance-select">
								<div class="form-group">
									<div class="col-md-12">
										<label for="">Select Remittance Center</label>
										<select class="form-control" name="remittance" id="remittance">
											<option value="">Select Remittance</option>
											
										</select>
									</div>
								</div>
								<div class="form-group">
									<div class="col-md-12">
										<table class="table table-condensed table-bordered">
											
										</table>
									</div>
								</div>
							</div>	
						</div>
					</div>
					
				</div>
				<div class="form-group text-center">
					<button class="btn btn-pink btn-submit" type="submit">PROCEED</button>
				</div>
			</div>
		</div>
	</div>

	</form>
</div>
@endsection
@section("css")
<link rel="stylesheet" type="text/css" href="/themes/{{ $shop_theme }}/assets/front/css/checkout.css">
@endsection
@section("script")
<script type="text/javascript" src="/themes/{{ $shop_theme }}/assets/front/js/checkout.js"></script>
@endsection