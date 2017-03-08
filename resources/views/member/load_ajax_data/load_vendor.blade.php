<!-- @url '/member/vendor/load_vendor' -->

@foreach($_vendor as $key=>$vendor)
	<option value="{{$vendor['vendor_id']}}" email="{{$vendor['vendor_email']}}" {{ isset($vendor_id) ?  $vendor_id == $vendor['vendor_id'] ? 'selected' : '' : '' }}>{{$vendor['vendor_title_name'] or ''}} {{$vendor['vendor_first_name'] or ''}} {{$vendor['vendor_middle_name'] or ''}} {{$vendor['vendor_last_name'] or ''}}</option>
	@if(sizeOf($_vendor)-1 == $key)
		<option class="hidden" value="" />
	@endif
@endforeach