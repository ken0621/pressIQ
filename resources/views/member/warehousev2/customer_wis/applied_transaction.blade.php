@if(count($_transactions) > 0)
    @foreach($_transactions as $transaction)
    <tr class="tr-draggable">
        <td class="invoice-number-td text-center">1</td>
        <td>
            <select class="form-control droplist-item select-item input-sm" name="item_id[]" >
                @include("member.load_ajax_data.load_item_category", ['add_search' => "", 'item_id' => $transaction['item_id']])
                <option class="hidden" value="" />
            </select>
        </td>
        <td><textarea class="form-control txt-desc" name="item_description[]">{{$transaction['item_description']}}</textarea></td>
        <td><select class="2222 droplist-um select-um" name="item_um[]"><option class="hidden" value="{{$transaction['item_um']}}" /></select></td>
        <td><input class="form-control number-input txt-qty text-center compute" type="text" name="item_qty[]" value="{{$transaction['item_qty']}}" /></td>
        <td><input class="text-right number-input txt-rate" type="text" name="item_rate[]" value="{{$transaction['item_rate']}}" /></td>
        <td><input class="text-right number-input txt-amount" type="text" name="item_amount[]" value="{{$transaction['item_amount']}}" /></td>
        <td class="text-center remove-tr cursor-pointer"><i class="fa fa-trash-o" aria-hidden="true"></i></td>
    </tr>
    @endforeach
@endif
<input type="hidden" class="inv-remarks" name="" value="{!! $remarks or '' !!}">