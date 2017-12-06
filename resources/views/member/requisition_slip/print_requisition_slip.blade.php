<body>
<div  class="text-center">
	<h2>{{strtoupper($user->shop_key)}}</h2>
    <div>Requisition Slip</div>
</div>
<table  style="width: 100%">
    <tr>
        <td>{{date('F d, Y h:i:s A',strtotime($rs->requisition_slip_date_created))}}</td>
        <td class="text-right">{{strtoupper($rs->requisition_slip_number)}}</td>
    </tr>
    <tr>
        <td colspan="5">
            <b>REMARKS : </b>{!! $rs->requisition_slip_remarks !!}
        </td>
    </tr>
</table>
<br>
<table style="width: 100%;">
    <thead style="font-weight: bold;">
        <tr>
            <td>#</td>
            <td>ITEM NAME</td>
            <td>DESCRIPTION</td>
            <td>QTY</td>
            <td>RATE</td>
            <td>AMOUNT</td>
            <td>VENDOR NAME</td>
        </tr>
    </thead>
    <tbody>
        @if(count($_rs_item) > 0)
            @foreach($_rs_item as $key => $item)
            <tr>
                <td>{{$key+1}}</td>
                <td>{{$item->item_name}}</td>
                <td>{{$item->item_description}}</td>
                <td>{{$item->rs_item_qty}} pc(s)</td>
                <td>{{number_format($item->rs_item_rate,2)}}</td>
                <td>{{number_format($item->rs_item_amount,2)}}</td>
                <td>{{$item->vendor_company}}</td>
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