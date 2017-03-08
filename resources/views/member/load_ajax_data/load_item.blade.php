<!-- @url '/member/item/load_item' -->

@foreach($_item as $key=>$item)
	<option value="{{$item->item_id}}" unit="{{$item->item_measurement_id}}" sales-info="{{$item->item_sales_information}}" 
			purchase-info="{{$item->item_purchasing_information}}" price="{{$item->item_price}}" cost="{{$item->item_cost}}" 
			{{ isset($item_id) ?  $item_id == $item->item_id ? 'selected' : '' : '' }}>{{$item->item_name}}</option>
@endforeach
@if(sizeOf($_item)-1 == $key)
	<option class="hidden" value="" />
@endif