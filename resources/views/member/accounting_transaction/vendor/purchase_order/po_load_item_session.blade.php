@if(count(Session::get('po_item')) > 0)
    @foreach(Session::get('po_item') as $items)
    <tr class="trcount tr-draggable tr-id-{{$items['poline_po_id']}}">
            <input type="hidden" class="poline_id" name="item_ref_name[]" value="purchase_order">
            <input type="hidden" class="itemline_po_id" name="item_ref_id[]" value="{{$items['poline_po_id']}}">
        <td class="invoice-number-td text-right">1</td>
        <td>
            <select class="1111 form-control select-item droplist-item input-sm pull-left" name="item_id[]" >
                @include("member.load_ajax_data.load_item_category", ['add_search' => "", 'item_id' => $items['poline_item_id']])
            </select>
        </td>
        <td>
            <textarea class="textarea-expand txt-desc" name="item_description[]">{{$items['poline_description']}}</textarea>
        </td>
        <td>
            <select class="2222 droplist-um select-um" name="item_um[]"><option class="hidden" value="" />
                @if($items['poline_um'])
                    @include("member.load_ajax_data.load_one_unit_measure", ['item_um_id' => $items['multi_um_id'], 'selected_um_id' => $items['poline_um']])
                @else
                    <option class="hidden" value="" />
                @endif
            </select>
        </td>
        <td><input class="text-center number-input txt-qty compute" type="text" name="item_qty[]" value="{{$items['poline_orig_qty']}}" /></td>
        <td><input class="text-right number-input txt-rate compute" type="text" name="item_rate[]" value="{{$items['poline_rate']}}" />
        </td>
        <td><input class="text-right number-input txt-amount" type="text" name="item_amount[]" value="{{$items['poline_amount']}}"/>
        </td>
        <!-- @include("member.load_ajax_data.load_td_serial_number"); -->
        <td tr_id="{{$items['poline_po_id']}}" linked_in="no" class="text-center remove-tr cursor-pointer"><i class="fa fa-trash-o" aria-hidden="true"></i></td>
    </tr>
    @endforeach
@endif
<tr class="tr-draggable">
    <input type="text" class="hidden poline_id" name="poline_id[]">
    <input type="text" class="hidden itemline_po_id" name="item_po_id[]">
    <td class="invoice-number-td text-right">1</td>
    <td>
        <input type="hidden" class="poline_id" name="item_ref_name[]">
        <input type="hidden" class="itemline_po_id" name="item_ref_id[]">
        <select class="1111 form-control select-item droplist-item input-sm pull-left" name="item_id[]" >
            @include("member.load_ajax_data.load_item_category", ['add_search' => ""])
        </select>
    </td>
    <td>
        <textarea class="textarea-expand txt-desc" readonly="true" name="item_description[]"></textarea>
    </td>
    <td><select class="2222 droplist-um select-um" name="item_um[]"><option class="hidden" value="" /></select></td>
    <td><input class="text-center number-input txt-qty compute" type="text" name="item_qty[]"/></td>
    <td><input class="text-right number-input txt-rate compute" type="text" name="item_rate[]"/></td>
    <td><input class="text-right number-input txt-amount" type="text" name="item_amount[]"/></td>
    <!-- @include("member.load_ajax_data.load_td_serial_number")
 -->    <td class="text-center remove-tr cursor-pointer"><i class="fa fa-trash-o" aria-hidden="true"></i></td>
</tr>