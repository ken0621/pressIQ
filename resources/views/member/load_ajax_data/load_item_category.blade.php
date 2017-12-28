<!-- @url '/member/item/load_item_category' -->
<!-- @selected_item $item_id -->

@foreach($_item as $key => $type)
	<option value="type_{{$type['type_id']}}" indent="{{$type['type_sub_level']}}" add-search="{{$add_search or ''}}" disabled>{{$type['type_name']}}</option>
	@if($type['item_list'])
		@foreach($type['item_list'] as $item)
			<option value="{{$item['item_id']}}" indent="{{$type['type_sub_level']+1}}" add-search="{{$add_search or ''."|".$type['type_name']}}" 
					item-sku="{{$item['item_sku']}}" item-type="{{$item['item_type_id']}}"
					inventory-count="{{$item['inventory_count'] or 0}}"
					sales-info="{{$item['item_sales_information']}}" purchase-info="{{$item['item_purchasing_information']}}" 
					price="{{$item['item_price'] or isset($item['sir_item_price'])}}" cost="{{$item['item_cost']}}" 
					has-um="{{$item['item_measurement_id']}}" 
					{{ isset($item_id) ?  $item_id == $item['item_id'] ? 'selected' : '' : '' }} > {{$item['item_name']}}</option>
		@endforeach
	@endif
	@if($type['subcategory'])
		@include('member.load_ajax_data.load_item_category', ['_item' => $type['subcategory'], 'add_search' => $type['type_name']."|".$add_search or ''])
	@endif
	@if(sizeOf($_item)-1 == $key)
		<option class="hidden" value="" />
	@endif
@endforeach
