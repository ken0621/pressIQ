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
		<h2>{{$transaction_type}}</h2>		
	</div>
	<div class="form-group">
		<div class="col-md-6 text-left" style="float: left; width: 50%">
			<strong>BILL TO</strong><br>
			<span>{{$sr->title_name." ".$sr->first_name." ".$sr->middle_name." ".$sr->last_name." ".$sr->suffix_name}}</span>
		</div>
		<div class="col-md-6 text-right" style="float: right; width: 50%">
			<div class="col-md-6 text-right" style="float: left; width: 50%">
				<strong>SALES RECEIPT NO.</strong><br>
				<strong>DATE.</strong><br>
			</div>
			<div class="col-md-6 text-left" style="float: left; width: 50%">
				<span>{{$sr->transaction_refnum != '' ? $sr->transaction_refnum : sprintf("%'.04d\n", $sr->new_inv_id)}}</span><br>
				<span>{{date('m/d/Y',strtotime($sr->inv_date))}}</span><br>
			</div>
		</div>
	</div>
	<table width="100%" style="padding: 0; margin-top: 20px ">
		<tr>
			<th>PRODUCT NAME</th>
			<th width="20%">QTY</th>
			<th width="15%">PRICE</th>
			<th width="15%">AMOUNT</th>
			<th width="15%">Taxable</th>
		</tr>
			<input type="hidden" name="{{$total = 0}}" class="{{$taxable_item = 0}}" >
		<tbody>
		@if($sr_item)		
			@foreach($sr_item as $item)
				<tr >
					<td>{{$item->item_name}}</td>
					<td style="text-align: center;">{{$item->qty}}</td>
					<td style="text-align: right;">{{currency("PHP",$item->invline_rate)}}</td>
					<td style="text-align: right;">{{currency("PHP",$item->invline_amount)}}</td>
					<td style="text-align: center;" {{$taxable_item += $item->taxable == 1 ? $item->invline_amount : 0}}>{{$item->taxable == 1 ? "&#10004;" : '' }}</td>
				</tr>
			@endforeach
			<div class="{{$sr->inv_is_paid == 1 ? 'watermark' : 'hidden'}}"> PAID </div>
		@endif	
			<tr>
				<td colspan="2"></td>
				<td colspan="2" style="text-align: left;font-weight: bold">SUBTOTAL</td>
				<td style="text-align: right; font-weight: bold">{{currency('PHP', $sr->inv_subtotal_price)}}</td>
			</tr>
			@if($sr->ewt != 0)
			<tr>
				<td colspan="2"></td>
				<td colspan="2" style="text-align: left;font-weight: bold">EWT ({{$sr->ewt * 100}} %)</td>
				<td style="text-align: right; font-weight: bold">{{currency('PHP',$sr->ewt *  $sr->inv_subtotal_price)}}</td>
			</tr>
			@endif
			@if($sr->inv_discount_value != 0)
			<tr>
				<td colspan="2"></td>
				<td colspan="2" style="text-align: left;font-weight: bold">Discount {{$sr->inv_discount_type == 'percent' ? $sr->inv_discount_type."%" : '' }}</td>
				<td style="text-align: right; font-weight: bold">{{$sr->inv_discount_type == 'value' ? currency("PHP",$sr->inv_discount_value) : currency("PHP",($sr->inv_discount_value/100) * $sr->inv_subtotal_price) }}</td>
			</tr>
			@endif
			@if($sr->taxable != 0)
			<tr>
				<td colspan="2" ></td>
				<td colspan="2" style="text-align: left;font-weight: bold">Vat (12%)</td>
				<td style="text-align: right; font-weight: bold">{{currency("PHP",$taxable_item * (12/100))  }}</td>
			</tr>
			@endif
			<tr class="{{$cm_total = 0}}">
				<td colspan="2"></td>
				<td colspan="2" style="text-align: left;font-weight: bold">TOTAL</td>
				<td style="text-align: right; font-weight: bold">{{currency("PHP",$sr->inv_overall_price)}}</td>
			</tr>
		</tbody>
	</table>
	<div class="row pull-right" style="margin-right: 10px">
		<h3><strong>TOTAL</strong> {{currency('PHP',$sr->inv_overall_price)}}</h3>
	</div>
	<br>
	<table width="100%" style="padding: 10px; margin-top: 20px ">
		<tbody>
			<br>
			<tr class="{{$sr->inv_message}}">
				@if($sr->inv_message != "")
				<td>Note: <strong>{{$sr->inv_message}}</strong></td>
				@endif
			</tr>
			<tr class="{{$sr->inv_memo}}">
				@if($sr->inv_memo != "")
				<td>Remarks: <strong>{{$sr->inv_memo}}</strong></td>
				@endif
			</tr>
		</tbody>
	</table>
</body>

<style type="text/css">
	table
	{
		border-collapse: collapse;
		padding: 5px;
	}
	tr th
	{
		padding: 5px;
		border: 1px solid #000;
	}
	.watermark
	{
		font-size: 100px;
		text-align: center;
		 position:fixed;
		 left: 300px;
		 top: 250px;
		 opacity:0.5;
		 z-index:99;
		 color:#000;

		 -ms-transform: rotate(-40deg); /* IE 9 */
	    -webkit-transform: rotate(-40deg); /* Chrome, Safari, Opera */
	    transform: rotate(-40deg);
	}
	.page 
	{
		page-break-after:always;
		position: relative;
	}
</style>
</html>