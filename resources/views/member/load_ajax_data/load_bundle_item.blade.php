<div class="col-sm-12">
    <table class="digima-table">
        <thead >
            <tr>
                <th class="text-center" style="width: 40px">ITEM SKU</th>
                <th class="text-center" style="width: 40px">ITEM BARCODE</th>
                <th class="text-center" style="width: 100px;">ACTUAL STOCKS</th>
                @if($pis != 0)
                <th class="text-center" style="width: 100px;">SIR Stocks</th>
                <th class="text-center" style="width: 100px;">ON HAND STOCKS</th>
                @endif
            </tr>
        </thead>
        <tbody class="draggable">
            @if($warehouse_item_bundle != null)
            @foreach($warehouse_item_bundle as $keys => $w_bundle_item)
            <tr class="tr-draggable tr-draggable-html count_row">
                <td class="text-center">
                    <label class="count-select">{{$w_bundle_item["bundle_item_name"]}}</label>
                </td>
                <td class="text-center">
                    <label class="count-select">{{$w_bundle_item["bundle_item_bardcode"]}}</label>
                </td>
                <td class="text-center">
                    <label >{{$w_bundle_item["bundle_actual_stocks_um"]}}</label>
                </td>
                @if($pis != 0)
                <td class="text-center"><a class="popup" link="/warehouse/sir/{{$warehouse->warehouse_id}}/{{$w_bundle_item['bundle_id']}}" size="md">{{$w_bundle_item["total_stock_sir"]}}</a></td>
                @endif
                <td class="text-center">
                    <label >{{$w_bundle_item["bundle_current_stocks_um"]}}</label>
                </td>
            </tr>
            @endforeach
            @endif
        </tbody>
    </table>
</div>