<body>
<div  class="text-center">
	<h2>{{strtoupper($owner->shop_key)}}</h2>
	<h3>{{strtoupper($owner->warehouse_name)}}</h3>
	<div>{{ucwords($owner->warehouse_address)}}</div>
	<div>{{strtoupper($type)}}</div>
	<div>{{date('M d, Y')}}</div>
</div>
<br>
@if($type == 'bundle')
<table class="" style="width: 100%">
	<thead>
            <tr>
                <th class="text-center" style="width: 100px">ITEM SKU</th>
                <th class="text-center" style="width: 100px">ITEM BARCODE</th>
                <th class="text-center" style="width: 100px;">ACTUAL STOCKS</th>
                @if($pis != 0)
                <th class="text-center" style="width: 100px;">SIR STOCKS</th>
                <th class="text-center" style="width: 100px;">ON HAND STOCKS</th>
                @endif
            </tr>
        </thead>
        <tbody class="draggable">
            @if($warehouse_item_bundle != null)
            @foreach($warehouse_item_bundle as $keys => $w_bundle_item)
            <tr class="tr-draggable tr-draggable-html count_row">
                <td class="text-center">
                    {{$w_bundle_item["bundle_item_name"]}}
                </td>
                <td class="text-center">
                    {{$w_bundle_item["bundle_item_bardcode"]}}
                </td>
                <td class="text-center">
                    {{$w_bundle_item["bundle_actual_stocks_um"]}}
                </td>
                @if($pis != 0)
                <td class="text-center">{{$w_bundle_item["total_stock_sir"]}}</td>
                @endif
                <td class="text-center">
                    {{$w_bundle_item["bundle_current_stocks_um"]}}
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
                <th class="text-center" style="width: 100px">ITEM SKU</th>
                <th class="text-center" style="width: 100px">ITEM BARCODE</th>
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
                        {{$inventory["item_sku"]}}
                    </td>
                    <td class="text-center">
                        {{$inventory["item_barcode"]}}
                    </td>
                    <td class="text-center">
                        {{$inventory["item_actual_stock_um"]}}
                    </td>
                    @if($pis != 0)
                    <td class="text-center">{{$inventory["sir_stock"]}}</td>
                    @endif
                    <td class="text-center">
                       {{$inventory["less_stock_um"]}}
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
                <th class="text-center" style="width: 100px">ITEM SKU</th>
                <th class="text-center" style="width: 100px">ITEM BARCODE</th>
                <th class="text-center" style="width: 100px;">ACTUAL STOCKS</th>
            </tr>
        </thead>
        <tbody class="draggable">
            @if($_empties != null)
                @foreach($_empties as $keys => $empties)
                <tr class="tr-draggable tr-draggable-html count_row">
                    <td class="text-center">
                        {{$empties["item_sku"]}}
                    </td>
                    <td class="text-center">
                        {{$empties["item_barcode"]}}
                    </td>
                    <td class="text-center">
                        {{$empties["item_actual_stock_um"]}}
                    </td>
                </tr>
                @endforeach
            @endif
        </tbody>
</table>
@endif
</body>

<style type="text/css">
	tr 
    {
        page-break-inside: avoid; 
    }
    body 
    {
    	font-size: 12px;
    }

</style>