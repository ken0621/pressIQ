@if(isset($item_list))
    @foreach($item_list as $key => $value)
        <tr>
            <td>
            	{!! $item_list[$key] !!}
            </td>
            <td class="text-left">
            	<input style="width: 100px" type="text" class="form-control quantity_container" name="quantity[]" value="{{$item_array[$key]['quantity']}}">
            </td>
            <td class="text-right price_container">
            	{{currency('PHP', $item_array[$key]['price'])}}
            </td>
            <td class="text-right price_container">
                {{currency('PHP', $item_array[$key]['membership_discount'])}}
            </td>
            <td class="text-right subtotal_container" style="font-weight: bold;">
                {{currency('PHP', $item_array[$key]['membership_discounted_price_total'])}}
            </td>
            <td style="font-size: 20px;">
            	<a href="javascript:">
            		<i class="fa fa-trash" onClick="remove_line({{$key}})"></i>
            	</a>
            </td>
        </tr>
    @endforeach
@else
    <tr>
        <td colspan="6"> <center>No Item. Click add lines to add item.</center></td>
    </tr>
@endif
    