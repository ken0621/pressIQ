<body>
<div  class="text-center">
	<h2>{{strtoupper($owner->shop_key)}}</h2>
	<h3>{{strtoupper($owner->warehouse_name)}}</h3>
	<div>{{ucwords($owner->warehouse_address)}}</div>
    <div>Receiving Report</div>
</div>
<br>
<table  style="width: 100%">
    <tr style="margin-bottom: 20px">
        <td>{{date('F d, Y h:i:s A',strtotime($rr->created_at))}}</td>
        <td class="text-right">{{strtoupper($rr->rr_number)}}</td>
    </tr>
    <tr>
        <td colspan="5">
            <b>REMARKS : </b>{!! $rr->rr_remarks !!}
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
         @if(count($rr_item) > 0)
            @foreach($rr_item as $item)
            <tr>
                <td>{{$item->item_name}}</td>
                <td>{{$item->item_sku}}</td>
                <td>{{$item->qty}}</td>
                <td>{{currency('',$item->rr_rate)}}</td>
                <td>{{currency('',$item->rr_amount)}}</td>
            </tr>
            @endforeach
        @elseif(count($rr_item_v1) > 0)
            @foreach($rr_item_v1 as $itemv1)
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
        <td class="text-center"></div></td>
        <td class="text-center"></div></td>
        <td class="text-center"><div style="border-bottom: 1px solid #000;width: 90%"></div></td>
    </tr>
    <tr>
        <td style="width: 33%"></td>
        <td style="width: 33%"></td>
        <td style="width: 33%">Received By:</td>
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