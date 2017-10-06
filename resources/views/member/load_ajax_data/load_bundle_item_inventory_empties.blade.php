<div class="col-sm-12">
    <table class="digima-table">
        <thead >
            <tr>
                <th class="text-center" style="width: 40px">ITEM SKU</th>
                <th class="text-center" style="width: 40px">ITEM BARCODE</th>
                <th class="text-center" style="width: 100px;">ACTUAL STOCKS</th>
            </tr>
        </thead>
        <tbody class="draggable">
            @if($_empties != null)
                @foreach($_empties as $keys => $empties)
                <tr class="tr-draggable tr-draggable-html count_row">
                    <td class="text-center">
                        <label class="count-select">{{$empties["item_sku"]}}</label>
                    </td>
                    <td class="text-center">
                        <label class="count-select">{{$empties["item_barcode"]}}</label>
                    </td>
                    <td class="text-center">
                        <label >{{$empties["item_actual_stock_um"]}}</label>
                    </td>
                </tr>
                @endforeach
            @endif
        </tbody>
    </table>
</div>