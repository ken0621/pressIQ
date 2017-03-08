<!-- @url '/member/customer/load_customer' -->

@foreach($_customer as $key=>$customer)
	<option value="{{$customer->customer_id}}" email="{{$customer->email}}" {{ isset($customer_id) ?  $customer_id == $customer->customer_id ? 'selected' : '' : '' }}>{{$customer->title_name or ''}} {{$customer->first_name or ''}} {{$customer->middle_name or ''}} {{$customer->last_name or ''}}</option>
	@if(sizeOf($_customer)-1 == $key)
		<option class="hidden" value="" />
	@endif
@endforeach