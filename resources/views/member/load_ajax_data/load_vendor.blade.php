<!-- @url '/member/vendor/load_vendor' -->

@foreach($_vendor as $key=>$vendor)
	<option value="{{$vendor['vendor_id']}}" email="{{$vendor['vendor_email']}}" billing-address="{{ $vendor['ven_billing_street'] }}" {{ isset($vendor_id) ?  $vendor_id == $vendor['vendor_id'] ? 'selected' : '' : '' }}>{{$vendor['vendor_company'] != "" ? $vendor['vendor_company'] : ucwords($vendor['vendor_title_name'].' '.$vendor['vendor_first_name'].' '.$vendor['vendor_middle_name'].' '.$vendor['vendor_last_name']) }} </option>
	@if(sizeOf($_vendor)-1 == $key)
		<option class="hidden" value="" />
	@endif
@endforeach 