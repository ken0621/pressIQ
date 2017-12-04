<body>
<div  class="text-center">
	<h2>{{strtoupper($owner->shop_key)}}</h2>
	<h3>{{strtoupper($owner->warehouse_name)}}</h3>
	<div>{{ucwords($owner->warehouse_address)}}</div>
    <div>Warehouse Issuance Slip</div>
</div>
<table  style="width: 100%">
    <tr>
        @foreach ($customer as $cust)
        <td>Deliver To: <h4>{{$cust->title_name}} {{$cust->first_name}} {{$cust->middle_name}} {{$cust->last_name}}</h4></td>
        @endforeach
    </tr>
    <tr>
        <td>{{date('F d, Y h:i:s A',strtotime($wis->created_at))}}</td>
        <td class="text-right"><h4>{{strtoupper($wis->cust_wis_number)}}</td></h4>
    </tr>
    <tr>
        <td colspan="5">
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
        </tr>
    </thead>
    <tbody>
        @if(count($wis_item) > 0)
            @foreach($wis_item as $item)
            <tr>
                <td>{{$item->item_name}}</td>
                <td>{{$item->item_sku}}</td>
                <td>{{$item->wis_item_quantity}} pc(s)</td>
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