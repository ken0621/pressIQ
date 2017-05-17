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

	<div class="text-center">
		<table style="width: 100%">
			<tr>
				<td style="width: 20%">
					<img style="width: 250px;height: 250px;object-fit: contain;" src="http://{{$_SERVER['SERVER_NAME']}}/assets/member/img/pdf_template/sample-business.jpg">
				</td>
				<td style="width: 80%">
					<div>
						<h3>{{$shop->shop_key}}</h3>
						<small>{{$shop->shop_street_address." ".$shop->shop_city}}</small><br>
						<small>Tel : {{$shop->shop_contact}} </small>
					</div>
				</td>
			</tr>
		</table>
	</div>
</head>
<body>
	<div class="form-group">
		<h2>{{$transaction_type}}</h2>		
	</div>
<div class="form-group">
	<div class="col-md-6 text-left" style="float: left; width: 50%">
		<strong>BILL TO</strong><br>
		<span>{{$invoice->title_name." ".$invoice->first_name." ".$invoice->middle_name." ".$invoice->last_name." ".$invoice->suffix_name}}</span>
	</div>
	<div class="col-md-6 text-right" style="float: right; width: 50%">
		<div class="col-md-6 text-right" style="float: left; width: 50%">
			<strong>INVOICE NO.</strong><br>
			<strong>DATE.</strong><br>
			<strong>DUE DATE</strong><br>
			<strong>TERMS</strong><br>
		</div>
		<div class="col-md-6 text-left" style="float: left; width: 50%">
			<span>{{sprintf("%'.04d\n", $invoice->inv_id)}}</span><br>
			<span>{{date('m/d/Y',strtotime($invoice->inv_date))}}</span><br>
			<span>{{date('m/d/Y',strtotime($invoice->inv_due_date))}}</span><br>
			<span>{{$invoice->terms_name}}</span><br>
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
	@if($invoice_item)		
		@foreach($invoice_item as $item)
			<tr >
				<td>{{$item->item_name}}</td>
				<td style="text-align: center;">{{$item->qty}}</td>
				<td style="text-align: right;">{{currency("PHP",$item->invline_rate)}}</td>
				<td style="text-align: right;">{{currency("PHP",$item->invline_amount)}}</td>
				<td style="text-align: center;" {{$taxable_item += $item->taxable == 1 ? $item->invline_amount : 0}}><input type="checkbox" {{$item->taxable == 1 ? 'checked' : '' }}></td>
			</tr>
		@endforeach
		<div class="{{$invoice->inv_is_paid == 1 ? 'watermark' : 'hidden'}}"> PAID </div>
	@endif	
		<tr>
			<td colspan="2"></td>
			<td colspan="2" style="text-align: left;font-weight: bold">SUBTOTAL</td>
			<td style="text-align: right; font-weight: bold">{{currency('PHP', $invoice->inv_subtotal_price)}}</td>
		</tr>
		@if($invoice->ewt != 0)
		<tr>
			<td colspan="2"></td>
			<td colspan="2" style="text-align: left;font-weight: bold">EWT ({{$invoice->ewt * 100}} %)</td>
			<td style="text-align: right; font-weight: bold">{{currency('PHP',$invoice->ewt *  $invoice->inv_subtotal_price)}}</td>
		</tr>
		@endif
		@if($invoice->inv_discount_value != 0)
		<tr>
			<td colspan="2"></td>
			<td colspan="2" style="text-align: left;font-weight: bold">Discount {{$invoice->inv_discount_type == 'percent' ? $invoice->inv_discount_type." (%".$invoice->inv_discount_value.")" : '' }}</td>
			<td style="text-align: right; font-weight: bold">{{$invoice->inv_discount_type == 'value' ? currency("PHP",$invoice->inv_discount_value) : currency("PHP",($invoice->inv_discount_value/100) * $invoice->inv_subtotal_price) }}</td>
		</tr>
		@endif
		@if($invoice->taxable != 0)
		<tr>
			<td colspan="2" ></td>
			<td colspan="2" style="text-align: left;font-weight: bold">Vat (12%)</td>
			<td style="text-align: right; font-weight: bold">{{currency("PHP",$taxable_item * (12/100))  }}</td>
		</tr>
		@endif
		<tr class="{{$cm_total = 0}}">
			<td colspan="2"></td>
			<td colspan="2" style="text-align: left;font-weight: bold">INVOICE TOTAL</td>
			<td class="text-right" style="font-weight: bold">{{currency("PHP",$invoice->inv_overall_price)}}</td>
		</tr>

		@if($cm != null)
			<tr class="{{$cm_total = $cm->cm_amount}}">
				<td colspan="5">
					<strong>RETURNS</strong>
				</td>
			</tr>
			@if($_cmline != null)
				@foreach($_cmline as $cmline)
				<tr>
					<td>{{$cmline->item_name}}</td>
					<td style="text-align: center;">{{$cmline->cm_qty}}</td>
					<td style="text-align: right;">{{currency("PHP",$cmline->cmline_rate)}}</td>
					<td style="text-align: right;">{{currency("PHP",$cmline->cmline_amount)}}</td>
					<td></td>
				</tr>
				@endforeach
			@endif
			<tr>
				<td colspan="2"></td>
				<td  colspan="2" style="text-align: left;font-weight: bold">RETURNS SUBTOTAL</td>
				<td class="text-right" style=" font-weight: bold">{{currency('PHP', $cm->cm_amount)}}</td>
				<td></td>
			</tr>
		@endif

	</tbody>
</table>
	<div class="row text-right" style="margin-right: 5px">
		<h3><strong>TOTAL</strong> {{currency('PHP',($invoice->inv_overall_price - $cm_total))}}</h3>
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
</style>
</html>