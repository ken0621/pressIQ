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
		<h2>Inventory Adjustment</h2>		
	</div>
	<div class="form-group">
		<div class="col-md-6 text-left" style="float: left; width: 50%">
			<strong>Warehouse :</strong><br>
			<span>{{$adj->warehouse_name}}</span>
		</div>
		<div class="col-md-6 text-right" style="float: right; width: 50%">
			<div class="col-md-6 text-right" style="float: left; width: 50%">
				<strong>REF NO.</strong><br>
				<strong>DATE.</strong><br>
			</div>
			<div class="col-md-6 text-left" style="float: left; width: 50%">
				<span>{{$adj->transaction_refnum != '' ? $adj->transaction_refnum : sprintf("%'.04d\n", $adj->inventory_adjustment_id)}}</span><br>
				<span>{{date('m/d/Y',strtotime($adj->date_created))}}</span><br>
			</div>
		</div>
	</div>
	<table width="100%" style="padding: 0; margin-top: 20px ">
		<tr>
			<th>PRODUCT NAME</th>
			<th width="20%">DESCRIPTION</th>
			<th width="15%">ACTUAL QTY</th>
			<th width="15%">NEW QTY</th>
			<th width="15%">DIFFERENCE QTY</th>
		</tr>
			<input type="hidden" name="{{$total = 0}}" class="{{$taxable_item = 0}}" >
		<tbody>
		@if($_adj_line)		
			@foreach($_adj_line as $item)
				<tr >
					<td>{{$item->item_name}}</td>
					<td style="text-align: center;">{{$item->itemline_item_description}}</td>
					<td style="text-align: right;">{{$item->actual_qty}}</td>
					<td style="text-align: right;">{{$item->new_qty}}</td>
					<td style="text-align: right;">{{$item->diff_qty}}</td>
				</tr>
			@endforeach
		@endif	
		</tbody>
	</table>
	<br>
	<table width="100%" style="padding: 10px; margin-top: 20px ">
		<tbody>
			<br>
			<tr class="{{$adj->adjustment_memo}}">
				@if($adj->adjustment_memo != "")
				<td>Note: <strong>{{$adj->adjustment_memo}}</strong></td>
				@endif
			</tr>
			<tr class="{{$adj->adjustment_remarks}}">
				@if($adj->adjustment_remarks != "")
				<td>Remarks: <strong>{{$adj->adjustment_remarks}}</strong></td>
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