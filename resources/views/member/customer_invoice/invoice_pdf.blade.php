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
<table width="100%">
	<tr>
		<td width="60%" style="text-align: left"><span style="font-size: 50px;font-weight: bold">Invoice</span></td>
		<td width="40%" ><span style="font-size: 25px;font-weight: bold">NO : {{sprintf("%'.05d\n", $invoice->inv_id)}}</span></td>
	</tr>
	<tr>
		<td width="60%"></td>
		<td width="40%" ><span style="font-size: 15px;">DATE : {{date('m/d/Y',strtotime($invoice->date_created))}}</span></td>
	</tr>
	<tr>
		<td><span style="font-size: 15px;">CUSTOMER : {{$invoice->title_name." ".$invoice->first_name." ".$invoice->middle_name." ".$invoice->last_name." ".$invoice->suffix_name}}</span></td>
	</tr>
</table>
<table width="100%" style="padding: 0; margin-top: 20px ">
	<tr>
		<th width="10%">CODE</th>
		<th>PRODUCT NAME</th>
		<th width="20%">QTY</th>
		<th width="15%">PRICE</th>
		<th width="15%">AMOUNT</th>
	</tr>
		<input type="hidden" name="{{$total = 0}}">
	<tbody>
	@if($invoice_item)
		@foreach($invoice_item as $item)
			<tr class="{{$total += $item->invline_amount}}">
				<td>{{$item->item_barcode}}</td>
				<td>{{$item->item_name}}</td>
				<td style="text-align: center;">{{$item->qty}}</td>
				<td style="text-align: right;">{{number_format($item->invline_rate,2)}}</td>
				<td style="text-align: right;">{{number_format($item->invline_amount,2)}}</td>
			</tr>
		@endforeach
	@endif
		<tr>
			<td colspan="3"></td>
			<td style="text-align: left;font-weight: bold">TOTAL</td>
			<td style="text-align: right; font-weight: bold">{{number_format($total,2)}}</td>
		</tr>
	</tbody>
</table>
</body>
<style type="text/css">
	table
	{
		border-collapse: collapse;
	}
	tr th
	{
		padding: 0;
		border: 1px solid #000;
	}
</style>
</html>