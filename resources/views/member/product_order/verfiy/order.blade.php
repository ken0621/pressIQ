<table class="table table-bordered">
@if($order)

<tr>
	<td>Order #{{$order->ec_order_id}}</td>
</tr>
<tr>
	<td>Customer: {{name_format_from_customer_info($order)}}</td>
</tr>
<tr>
	<td>Payment Method: {{$order->method_name}}</td>
</tr>
@if($order->checkout_id)
<tr>
	<td>Checkout ID (Paymaya) : {{ str_replace("-", "", $order->checkout_id) }} </td>
</tr>
@endif
<tr>
	<td>Order Status: {{$order->order_status}}</td>
</tr>
<tr>
	<td>Payment Status: {{ec_order_payment_status($order->payment_status)}}</td>
</tr>

	@if($order->order_slot_used == 1)
		<tr>
			<td>Slot Status: Created</td>
		</tr>
		<tr>
			<td>Slot No: {{$order->slot_no}}</td>
		</tr>
		<tr>
			<td>Sponsor : 
						@if($order->order_slot_sponsor != 0)
							@if(isset($slots[$order->order_slot_sponsor]->slot_no)) 
								{{$slots[$order->order_slot_sponsor]->slot_no}} 
							@else 
								Independent Tree 
							@endif
						@else
							Independent Tree 
						@endif
			</td>
		</tr>
	@else
		
		<tr>
			<td>Slot Status: Not Created</td>
		</tr>
		@if($order->payment_status == 1)
			<tr>
				<td>
					<center>--- Create slot ----</center>
					<center><span style="color:gray"><small>For orders withour slot (PAID)</small></span></center>
				</td>
			</tr>
			@if($order->order_slot_id)
			<!-- Paid With Track on Ec order Slot -->
				<tr>
					<td>
						<form class="global-submit" method="post" action="/member/ecommerce/paymaya/verify/order/update/slot">
						{!! csrf_field() !!}
							<div class="col-md-12">
							<input type="hidden" name="order_slot_id" value="{{$order->order_slot_id}}">
							<input type="hidden" name="ec_order_id" value="{{$order->ec_order_id}}">
							Sponsor : 
								@if(isset($slots[$order->order_slot_sponsor]->slot_no)) 
									{{$slots[$order->order_slot_sponsor]->slot_no}} 
								@else 
									Independent Tree 
								@endif
							</div>
							<div class="col-md-12">
								<button class="btn btn-primary pull-right">Create Slot</button>
							</div>	
						</form>
					</td>
				</tr>
			@else
			<!-- Paid Without Track on Ec order slot -->
				<tr>
					<td>
						<form class="global-submit" method="post" action="/member/ecommerce/paymaya/verify/order/update/slot">
							{!! csrf_field() !!}
							<input type="hidden" name="ec_order_id" value="{{$order->ec_order_id}}">
							<div class="col-md-12">
								<label>Referrer</label>
								<input type="text" class="form-control" name="referrer" placeholder="username or slot no of Referrer">
							</div>
							<div class="col-md-12">
								<br>
								<button class="btn btn-primary pull-right">Create Slot</button>
							</div>
						</form>
						
					</td>
				</tr>
			@endif
		@else
			@if($order->order_status != 'Failed')		
			<tr>
				<td>
					<center>--- Merchant Verification ----</center>
					<center><span style="color:gray"><small>Use the Checkout ID (Paymaya) to be verify from paymaya that the transaction has been paid. Upon clicking the Verify button the order status will be Processing and Paid.</small></span></center>
					@if($order->order_slot_id)
					<!-- Paid With Track on Ec order Slot -->
						<tr>
							<td>
								<form class="global-submit" method="post" action="/member/ecommerce/paymaya/verify/order/update/slot/payment">
								{!! csrf_field() !!}
									<div class="col-md-12">
									<input type="hidden" name="order_slot_id" value="{{$order->order_slot_id}}">
									<input type="hidden" name="ec_order_id" value="{{$order->ec_order_id}}">
									Sponsor : 
										@if(isset($slots[$order->order_slot_sponsor]) && isset($slots[$order->order_slot_sponsor]->slot_no)) 
											{{$slots[$order->order_slot_sponsor]->slot_no}} 
										@else 
											Independent Tree 
										@endif
									</div>
									<div class="col-md-12">
										<button class="btn btn-primary pull-right">Verify Payment</button>
									</div>	
								</form>
							</td>
						</tr>
					@else
					<!-- Unpaid Without Track on Ec order slot -->
						<tr>
							<td>
								<form class="global-submit" method="post" action="/member/ecommerce/paymaya/verify/order/update/slot/payment">
									{!! csrf_field() !!}
									<input type="hidden" name="ec_order_id" value="{{$order->ec_order_id}}">
									<div class="col-md-12">
										<label>Referrer</label>
										<input type="text" class="form-control" name="referrer" placeholder="username or slot no of Referrer">
									</div>
									<div class="col-md-12">
										<br>
										<button class="btn btn-primary pull-right">Verify Payment</button>
									</div>
								</form>
							</td>
						</tr>
					@endif
				</td>
			</tr>
			@else
			<tr>
				<td>No Slot for failed transaction</td>
			</tr>
			@endif
		@endif


	@endif
	<script>
		var order_id = {{$order->ec_order_id}};
		function submit_done(data)
		{
			if(data.status== 'error') 
			{
				toastr.warning(data.message);
				load_append_order(order_id);
			}
			else if(data.status == 'success')
			{
				load_append_order(order_id);
			}
		}

	</script>
@endif
</table>
