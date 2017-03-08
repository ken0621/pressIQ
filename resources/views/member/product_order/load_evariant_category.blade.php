<!-- @url '/member/item/load_item_category' -->
<!-- @selected_item $item_id -->

@foreach($_item as $item)
		<option value="{{$item->item_id}}" add-search="{{$add_search}}" 
				sales-info="{{$item->item_sales_information}}" purchase-info="{{$item->item_purchasing_information}}" 
				price="{{$item->evariant_price}}" cost="{{$item->item_cost}}" has-um="{{$item->item_measurement_id}}"
				{{ isset($item_id) ?  $item_id == $item->item_id ? 'selected' : '' : '' }} >{{$item->evariant_item_label}}
		</option>
@endforeach