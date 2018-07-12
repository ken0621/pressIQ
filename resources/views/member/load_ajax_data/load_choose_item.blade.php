@if(isset($_choose_item))
	@if(count($_choose_item) > 0)
		@foreach($_choose_item as $item)
		<tr>
		    <td class="text-center">{{$item['item_sku']}}</td>
		    <td class="text-center">{{currency('PHP', $item['item_cost'])}}</td>
		    <td class="text-center">{{currency('PHP', $item['item_price'])}}</td>
		    <td class="text-center">{{number_format($item['quantity'])}}</td>
		    <td class="text-center" style="color:red;cursor: pointer;" onClick='remove_item({{$item["item_id"]}})' ><i class='fa fa-times loading-spinner-{{$item["item_id"]}}'></i></td>
		</tr>
		@endforeach
	@else
	<tr>
		<td colspan="5" class="text-center">NO ITEM YET</td>
	</tr>
	@endif
@else
	<tr>
		<td colspan="5" class="text-center">NO ITEM YET</td>
	</tr>
@endif