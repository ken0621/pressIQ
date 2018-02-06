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
		<strong>ADDRESS</strong><br>
		<span>{{$so->company != '' ? $so->company : $so->title_name." ".$so->first_name." ".$so->middle_name." ".$so->last_name." ".$so->suffix_name}}</span>
	</div>
	<div class="col-md-6 text-right" style="float: right; width: 50%">
		<div class="col-md-6 text-right" style="float: left; width: 50%">
			<strong>{{ucwords($transaction_type)}} NO.</strong><br>
			<strong>DATE.</strong><br>
		</div>
		<div class="col-md-6 text-left" style="float: left; width: 50%">
			<span>{{$so->transaction_refnum != '' ? $so->transaction_refnum : sprintf("%'.04d\n", $so->est_id)}}</span><br>
			<span>{{date('m/d/Y',strtotime($so->est_date))}}</span><br>
		</div>
	</div>
</div>

<table width="100%" style="padding: 0; margin-top: 20px ">
	<tr>
		<th>PRODUCT NAME</th>
		<th width="20%">QTY</th>
		<th width="15%">PRICE</th>
		<th width="5%">DISCOUNT</th>
		<th width="15%">AMOUNT</th>
		<th width="5%">Taxable</th>
	</tr>
		<input type="hidden" name="{{$total = 0}}" class="{{$taxable_item = 0}}" >
	<tbody>
	@if($so_item)		
		@foreach($so_item as $item)
			<tr >
				<td>{{$item->item_name}}</td>
				<td style="text-align: center;">{{$item->qty}}</td>
				<td style="text-align: right;">{{currency("PHP",$item->estline_rate)}}</td>
				<td style="text-align: right;">{{$item->estline_discount}}{{$item->estline_discount_type == 'fixed' ? '' : '%'}}</td>
				<td style="text-align: right;">{{currency("PHP",$item->estline_amount)}}</td>
				<td style="text-align: center;" {{$taxable_item += $item->taxable == 1 ? $item->estline_amount : 0}}>{{$item->taxable == 1 ? "&#10004;" : '' }}</td>
			</tr>
		@endforeach
	@endif	
		<tr>
			<td colspan="2"></td>
			<td colspan="2" style="text-align: left;font-weight: bold">SUBTOTAL</td>
			<td style="text-align: right; font-weight: bold">{{currency('PHP', $so->est_subtotal_price)}}</td>
		</tr>
		@if($so->ewt != 0)
		<tr>
			<td colspan="2"></td>
			<td colspan="2" style="text-align: left;font-weight: bold">EWT ({{$so->ewt * 100}} %)</td>
			<td style="text-align: right; font-weight: bold">{{currency('PHP',$so->ewt *  $so->est_subtotal_price)}}</td>
		</tr>
		@endif
		@if($so->est_discount_value != 0)
		<tr>
			<td colspan="2"></td>
			<td colspan="2" style="text-align: left;font-weight: bold">Discount {{$so->est_discount_type == 'percent' ? $so->est_discount_type."%" : '' }}</td>
			<td style="text-align: right; font-weight: bold">{{$so->est_discount_type == 'value' ? currency("PHP",$so->est_discount_value) : currency("PHP",($so->est_discount_value/100) * $so->est_subtotal_price) }}</td>
		</tr>
		@endif
		@if($so->taxable != 0)
		<tr>
			<td colspan="2" ></td>
			<td colspan="2" style="text-align: left;font-weight: bold">Vat (12%)</td>
			<td style="text-align: right; font-weight: bold">{{currency("PHP",$taxable_item * (12/100))  }}</td>
		</tr>
		@endif
		<tr class="{{$cm_total = 0}}">
			<td colspan="2"></td>
			<td colspan="2" style="text-align: left;font-weight: bold">TOTAL</td>
			<td style="text-align: right; font-weight: bold">{{currency("PHP",$so->est_overall_price)}}</td>
		</tr>

	</tbody>
</table>
	<div class="row pull-right" style="margin-right: 10px">
		<h3><strong>TOTAL</strong> {{currency('PHP',$so->est_overall_price)}}</h3>
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