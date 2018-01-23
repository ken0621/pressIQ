
    @foreach($_po as $items)
    <tr>
        <input type="hidden" class="itemline_po_id">
        <td class="invoice-number-td text-right">{{$items->po_id}}</td>
    </tr>
    @endforeach

