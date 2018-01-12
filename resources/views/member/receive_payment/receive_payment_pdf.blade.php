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
		<h2>RECEIVE PAYMENT</h2>		
	</div>
<div class="form-group">
	<div class="col-md-6 text-left" style="float: left; width: 50%">
		<strong>Payment From</strong><br>
		<span>{{$receive_payment->company}}</span><br>
		<span>{{$receive_payment->title_name.' '.$receive_payment->first_name.' '.$receive_payment->middle_name.' '.$receive_payment->last_name.' '.$receive_payment->suffix_name}}</span>
	</div>
	<div class="col-md-6 text-right" style="float: right; width: 50%">
		<div class="col-md-6 text-right" style="float: left; width: 50%">
			<strong>PAYMENT NO.</strong><br>
			<strong>DATE.</strong><br>
			<strong>DUE DATE</strong><br>
		</div>
		<div class="col-md-6 text-left" style="float: left; width: 50%">
			<span>{{sprintf("%'.04d\n", $receive_payment->rp_id)}}</span><br>
			<span>{{date('m/d/Y',strtotime($receive_payment->rp_date))}}</span><br>
			
		</div>
	</div>
</div>

<table width="100%" style="padding: 0; margin-top: 20px ">
	<tr>
		<th>PRODUCT NAME</th>
		<th>DESCRIPTION</th>
		<th width="10%">QTY</th>
		<th width="15%">PRICE</th>
		<th width="15%">AMOUNT</th>
		<th width="10%">REF</th>
	</tr>
	<tbody>			
		@foreach($_invoice_item as $item)		
			<tr >
				<td>{{$item->item_name}}</td>
				<td>{{$item->invline_description}}</td>
				<td style="text-align: center;">{{$item->invline_qty}}</td>
				<td style="text-align: right;">{{number_format($item->invline_rate,2)}}</td>
				<td style="text-align: right;">{{number_format($item->invline_amount,2)}}</td>
				<td style="text-align: right;">{{($item->itemline_ref_name == 'invoice' ? 'INV#' : '' ) . $item->invline_inv_id}}</td>
			</tr>	
		@endforeach					
	</tbody>
</table>
	<div class="row" style="text-align:right;margin-right: 10px">
		<h3><strong>TOTAL</strong> {{currency('PHP',($receive_payment->bill_total_amount))}}</h3>
	</div>
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
	html
	{
		font-size: 13px;
	}
</style>
</html>