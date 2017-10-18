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
            @if(count($_empties) > 0)
                @if($_empties != null)
                    @foreach($_empties as $keys => $empties)
                    <tr class="tr-draggable tr-draggable-html count_row">
                        <td>
                            <label class="count-select">{{$empties["item_sku"]}}</label>
                        </td>
                        <td>
                            <label class="count-select">{{$empties["item_barcode"]}}</label>
                        </td>
                        <td>
                            <label >{{$empties["item_actual_stock_um"]}}</label>
                        </td>
                    </tr>
                    @endforeach
                @endif
            @else
            <tr>
                <td colspan="3" class="text-center">NO ITEM</td>
            </tr>
            @endif
        </tbody>
    </table>
</div>