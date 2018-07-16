@if(count($_transactions) > 0)
    @foreach($_transactions as $transaction)
     <tr class="tr-draggable">
        <td class="invoice-number-td text-center">1</td>
        <td>
            <select class="form-control droplist-item input-sm select-item" name="rs_item_id[]" >
                @include("member.load_ajax_data.load_item_category", ['add_search' => "", 'item_id' => $transaction['item_id']])
                <option class="hidden" value="" />
            </select>
        </td>
        <td><textarea class="form-control txt-desc" name="rs_item_description[]">{{$transaction['item_description']}}</textarea></td>
        <td class="text-center">
            <input type="text" class="form-control text-center txt-qty compute" value="{{$transaction['item_qty']}}" name="rs_item_qty[]">
        </td>
        <td class="text-center">
            <select class="form-control droplist-item-um select-um  {{isset($transaction['multi_id']) ? 'has-value' : ''}}" name="rs_item_um[]">
            	@if($transaction['item_um'])
                    @include("member.load_ajax_data.load_one_unit_measure", ['item_um_id' => $transaction['multi_um_id'], 'selected_um_id' => $transaction['item_um']])
                @else
                    <option class="hidden" value="" />
                @endif
            </select>
        </td>
        <td class="text-center">
            <input type="text" class="form-control text-right txt-rate" value="{{$transaction['item_rate']}}" name="rs_item_rate[]">
        </td>
        <td class="text-center">
            <input type="text" class="form-control text-right txt-amount" name="rs_item_amount[]" value="{{$transaction['item_amount']}}">
        </td>
        <td class="text-center">
            <select class="form-control droplist-vendor select-vendor" name="rs_vendor_id[]">
                @include('member.load_ajax_data.load_vendor')
            </select>
        </td>
        <td class="text-center remove-tr cursor-pointer"><i class="fa fa-trash-o" aria-hidden="true"></i></td>
    </tr>
    @endforeach
@endif
<input type="hidden" class="pr-remarks" name="" value="{!! $remarks or '' !!}">