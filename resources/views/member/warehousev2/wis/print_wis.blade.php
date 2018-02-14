<body>
<div  class="text-center">
	<h2>{{strtoupper($owner->shop_key)}}</h2>
	<h3>{{strtoupper($owner->warehouse_name)}}</h3>
	<div>{{ucwords($owner->warehouse_address)}}</div>
    <div>Warehouse Issuance Slip</div>
    <div><strong> RECEIVER'S CODE : {{ucwords($wis->receiver_code)}}</strong></div>
</div>
<table  style="width: 100%">
    <tr>
        <td>{{date('F d, Y h:i:s A',strtotime($wis->created_at))}}</td>
        <td class="text-right">{{strtoupper($wis->wis_number)}}</td>
    </tr>
    <tr>
        <td colspan="2">
            <b>DELIVER TO : {{$deliver_to->warehouse_name or ''}}</b>
        </td>
    </tr>
    <tr>
        <td colspan="2">
            <b>ADDRESS :</b> 
            {{ $wis->destination_warehouse_address }}
        </td>
    </tr>
    <tr>
        <td colspan="2">
            <b>REMARKS : </b>{!! $wis->wis_remarks !!}
        </td>
    </tr>
</table>
<br>

<table style="width: 100%;">
    <thead style="font-weight: bold;">
        <tr>
            <td>ITEM NAME</td>
            <td>ITEM SKU</td>
            <td>ISSUED QTY</td>
            <td>RATE</td>
            <td>AMOUNT</td>
        </tr>
    </thead>
    <tbody>
        @if(count($wis_item) > 0)
            @foreach($wis_item as $item)
            <tr>
                <td>{{$item->item_name}}</td>
                <td>{{$item->item_sku}}</td>
                <td>{{$item->qty}}</td>
                <td>{{currency('',$item->wt_rate)}}</td>
                <td>{{currency('',$item->wt_amount)}}</td>
            </tr>
            @endforeach
        @elseif(count($wis_item_v1) > 0)
            @foreach($wis_item_v1 as $itemv1)
            <tr>
                <td>{{$itemv1->item_name}}</td>
                <td>{{$itemv1->item_sku}}</td>
                <td>{{$itemv1->qty}} pc(s)</td>
                <td>{{currency('',$itemv1->item_price)}}</td>
                <td>{{currency('',($itemv1->qty * $itemv1->item_price))}}</td>
            </tr>
            @endforeach
        @else
        <tr>
            <td colspan="3" class="text-center">NO ITEMS</td>
        </tr>
        @endif
    </tbody>
</table>
<br>
<br>
<br>
<br>
<table class="text-center" style="width: 100%;">
    <tr>
        <td style="width: 33%"></td>
        <td style="width: 33%"></td>
        <td style="width: 33%">{{strtoupper($user->user_first_name." ".$user->user_last_name)}}</td>
    </tr>
    <tr>
        <td class="text-center"><div style="border-bottom: 1px solid #000;width: 90%"></div></td>
        <td class="text-center"><div style="border-bottom: 1px solid #000;width: 90%"></div></td>
        <td class="text-center"><div style="border-bottom: 1px solid #000;width: 90%"></div></td>
    </tr>
    <tr>
        <td style="width: 33%">Approved By:</td>
        <td style="width: 33%">Checked By:</td>
        <td style="width: 33%">Printed By:</td>
    </tr>
</table>
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
    thead
    {
        border: 1px solid #000;
    }

</style>