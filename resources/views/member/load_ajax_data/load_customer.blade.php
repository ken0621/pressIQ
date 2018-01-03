<!-- @url '/member/customer/load_customer' -->

@if(count($_customer) > 0)
@foreach($_customer as $key => $customer)
	<option value="{{$customer->customer_id}}" billing-address="{{$customer->billing_address ? $customer->billing_address : $customer->customer_street}}" salesrep_id="{{$customer->agent_id}}" salesrep="{{$customer->salesrep_fname.' '.$customer->salesrep_mname.' '.$customer->salesrep_lname}}" email="{{$customer->email}}" {{ isset($customer_id) ? ($customer_id == $customer->customer_id ? 'selected' : '') : '' }}
		>{{$customer->company != "" ? $customer->company : ucwords($customer->title_name.' '.$customer->first_name.' '.$customer->middle_name.' '.$customer->last_name) }}</option>
	@if(sizeOf($_customer)-1 == $key)
		<option class="hidden" value="" />
	@endif
@endforeach
@else
<option>No Customer</option>
@endif