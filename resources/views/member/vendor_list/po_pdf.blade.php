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
		<h2>Purchase Order</h2>		
	</div>
<div class="form-group" style="padding-bottom: 50px">
	<div class="col-md-6 text-left" style="float: left; width: 40%">
		<strong>Vendor </strong><br>
		<span>{{$po->vendor_company}}</span><br>
		<span>{{$po->title_name." ".$po->first_name." ".$po->middle_name." ".$po->last_name." ".$po->suffix_name}}</span>
	</div>
	<div class="col-md-6 text-right" style="float: right; width: 30%">
		<div class="col-md-6 text-right" style="float: left; width: 50%">
			<strong>P.O NO.</strong><br>
			<strong>DATE.</strong><br>
		</div>
		<div class="col-md-6 text-left" style="float: left; width: 50%">
			<span>{{sprintf("%'.04d\n", $po->po_id)}}</span><br>
			<span>{{date('m/d/Y',strtotime($po->po_date))}}</span><br>
		</div>
	</div>
	<div class="col-md-6 text-right" style="float: right; width: 30%">
		<strong>Ship To: </strong>
		<span>{{$po->ven_shipping_street." ".$po->ven_shipping_city." ".$po->ven_shipping_state." ".$po->country_name.", ".$po->ven_shipping_zipcode}}</span><br>
	</div>
</div>

<table width="100%" style="padding: 0; margin-top: 20px ">
	<tr>
		<th>PRODUCT NAME</th>
		<th width="20%">QTY</th>
		<th width="15%">PRICE</th>
		<th width="15%">AMOUNT</th>
	</tr>
		<input type="hidden" name="{{$total = 0}}" class="{{$taxable_item = 0}}" >
	<tbody>
	@if($_poline)		
		@foreach($_poline as $poline)
			<tr >
				<td>{{$poline->item_name}}</td>
				<td style="text-align: center;">{{$poline->qty}}</td>
				<td style="text-align: right;">{{currency("PHP",$poline->poline_rate)}}</td>
				<td style="text-align: right;">{{currency("PHP",$poline->poline_amount)}}</td>
			</tr>
		@endforeach
		<!-- <div class="$invoice->inv_is_paid == 1 ? 'watermark' : 'hidden'"> PAID </div> -->
	@endif	
		<tr>
			<td colspan="1"></td>
			<td colspan="2" style="text-align: left;font-weight: bold">SUBTOTAL</td>
			<td style="text-align: right; font-weight: bold">{{currency('PHP', $po->po_subtotal_price)}}</td>
		</tr>
		

	</tbody>
</table>
	<div class="row pull-right" >
		<h3><strong>TOTAL</strong> {{currency('PHP',($po->po_overall_price))}}</h3>
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