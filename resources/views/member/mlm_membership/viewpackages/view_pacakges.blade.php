@if($membership_packages->first())
	@foreach($membership_packages as $key => $mem_pack)
    	<tr >
            <td style="color: green;">{{$mem_pack->membership_package_name}}</td>
            <td class="text-left">
            @if($mem_pack->membership_package_is_gc == 0)
                @foreach($item_bundle[$key] as $key2 => $value2)
                <div class="col-md-12">
                    <div class="col-md-6">
                        <label>Bundle</label>
                        <input type="text" class="form-control" value="{{$value2->item_list['item_name']}}" readonly>
                    </div>
                    <div class="col-md-6">
                        <label>Quantity</label>
                        <input type="text" class="form-control" value="{{$value2->membership_package_has_quantity}}" readonly>
                    </div>
                    
                    @foreach($value2->item_list['bundle'] as $key3 => $value3)
                        <div class="col-md-12">
                            <div class="col-md-6">
                                <label>Item</label>
                                <input type="text" class="form-control" value="{{$value3['item_name']}}" readonly>
                            </div>
                            <div class="col-md-3">
                                <label>Quantity</label>
                                <input type="text" class="form-control" value="{{$value3['bundle_qty']}}" readonly>
                            </div>
                            <div class="col-md-3">
                                <label>Bundle Quantity</label>
                                <input type="text" class="form-control" value="{{$value3['bundle_qty'] * $value2->membership_package_has_quantity}}" readonly>
                            </div>
                        </div>
                    @endforeach
                    
                </div>
                @endforeach
            @else
            <div class="col-md-12">
                <label>GC AMOUNT</label>
                <input type="number" class="form-control" value="{{$mem_pack->membership_package_gc_amount}}" readonly>
            </div>
            @endif    
            </td>
           
            <td class="text-right">
                <a href="javascript:" class="popup" link="/member/mlm/membership/edit/package/{{$mem_pack->membership_package_id}}">EDIT</a> |
                <a href="/member/mlm/membership/edit/package/archive/{{$mem_pack->membership_package_id}}" class="" link="/member/mlm/membership/edit/package/archive/{{$mem_pack->membership_package_id}}">DELETE</a>
            </td>
        </tr>
	@endforeach
@else
<tr>
	<td colspan="3"> <center>No Available Package</center></td>
</tr>
@endif