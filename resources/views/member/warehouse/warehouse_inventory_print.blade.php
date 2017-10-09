<div style="width: 100%" class="text-center">
	<h2>{{strtoupper($owner->shop_key)}}</h2>
	<label>{{strtoupper($owner->warehouse_name)}}</label> <br>
	<label>{{strtoupper($type)}}</label> <br>
	<label>{{date('M d, Y')}}</label>
</div>
@if($type == 'bundle')
<table class="" style="width: 100%">
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
                <td class="text-center">{{$w_bundle_item["total_stock_sir"]}}</td>
                @endif
                <td class="text-center">
                    <label >{{$w_bundle_item["bundle_current_stocks_um"]}}</label>
                </td>
            </tr>
            @endforeach
            @endif
        </tbody>
</table>
@endif
@if($type == 'inventory')
<table class="" style="width: 100%">
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
                    <td class="text-center">{{$inventory["sir_stock"]}}</td>
                    @endif
                    <td class="text-center">
                        <label class="count-select">{{$inventory["less_stock_um"]}}</label>
                    </td>
                </tr>
                @endforeach
            @endif
        </tbody>
</table>
@endif
@if($type == 'empties')
<table class="" style="width: 100%">
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
@endif

<style type="text/css">
	tr 
    {
        page-break-inside: avoid; 
    }
</style>