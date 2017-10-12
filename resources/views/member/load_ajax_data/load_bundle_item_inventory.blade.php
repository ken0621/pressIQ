<div class="col-sm-12">
    <table class="digima-table">
        <thead >
            <tr>
                <th class="text-center" style="width: 40px">ITEM SKU</th>
                <th class="text-center" style="width: 40px">ITEM BARCODE</th>
                <th class="text-center" style="width: 100px;">ACTUAL STOCKS</th>
                @if($pis != 0)
                <th class="text-center" style="width: 100px;">SIR STOCKS</th>
                <th class="text-center" style="width: 100px;">ON HAND STOCKS</th>
                @endif
            </tr>
        </thead>
        <tbody class="draggable">
            @if(count($_inventory) > 0)
                @if($_inventory != null)
                    @foreach($_inventory as $keys => $inventory)
                    <tr class="tr-draggable tr-draggable-html count_row">
                        <td class="text-center">
                            <label class="count-select">{{$inventory["item_sku"]}}</label>
                        </td>
                        <td class="text-center">
                            <label class="count-select">{{$inventory["item_barcode"]}}</label>
                        </td>
                        <td class="text-center">
                            <label >{{$inventory["item_actual_stock_um"]}}</label>
                        </td>
                        @if($pis != 0)
                        <td class="text-center"><a class="popup" link="/warehouse/sir/{{$warehouse->warehouse_id}}/{{$inventory['item_id']}}" size="md">{{$inventory["sir_stock"]}}</a></td>
                        @endif
                        <td class="text-center">
                            <label class="count-select">{{$inventory["less_stock_um"]}}</label>
                        </td>
                    </tr>
                    @endforeach
                @endif
            @else
            <tr>
                <td colspan="5" class="text-center"> NO ITEM</td>
            </tr>
            @endif
        </tbody>
    </table>
</div>