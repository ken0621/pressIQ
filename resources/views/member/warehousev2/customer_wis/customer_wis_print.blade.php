<!DOCTYPE html>
<html>
<head>
    <title></title>
    <style type="text/css">
        body
        {
            font-size: 13px;
            font-family: 'Titillium Web',sans-serif;
        }
    </style>
</head>
<body>
    <div class="form-group">
        <h2>
            @if($wis->cust_wis_status == 'pending')
            Warehouse Issuance Slip
            @else
            Delivery Report
            @endif
        </h2>      
    </div>
    <div class="form-group">
        <div class="col-md-6 text-left" style="float: left; width: 50%">
            <strong>SHIP TO</strong><br>
            <span>{{$wis->company != '' ? $wis->company : ($wis->title_name." ".$wis->first_name." ".$wis->middle_name." ".$wis->last_name." ".$wis->suffix_name)}}</span><br>
            <strong>ADDRESS</strong>
            <p>{!! $wis->destination_customer_address !!}</p>
        </div>
        <div class="col-md-6 text-right" style="float: right; width: 50%">
            <div class="col-md-6 text-right" style="float: left; width: 50%">
                <strong>NO :</strong><br>
                <strong>DATE :</strong><br>
                <strong>FROM :</strong><br>
            </div>
            <div class="col-md-6 text-left" style="float: left; width: 50%">
                <span>{{$wis->transaction_refnum != '' ? $wis->transaction_refnum : sprintf("%'.04d\n", $wis->new_inv_id)}}</span><br>
                <span>{{date('m/d/Y',strtotime($wis->cust_delivery_date))}}</span><br>
                <span>{{$wis->warehouse_name}}</span><br>
            </div>
        </div>
    </div>
</body>

<body>

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
                <td>{{$item->qty}}</td>
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
<div>
    <p>
       <b>REMARKS : <br>{!! $wis->cust_wis_remarks != '' ? $wis->cust_wis_remarks : 'none' !!}
    </p>
</div>
<br>
<br>
<br>
<br>

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