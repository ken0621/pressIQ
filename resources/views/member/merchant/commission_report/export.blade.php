<!DOCTYPE html>
<html>
<head>	
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<style type="text/css">
	*
	{
		font-family: Arial;
	}
	table
	{
		font-family: Arial;
	}
	.head td
	{
		border: 1px solid #000;
		font-size: 8px;
		font-weight: bold;
	}
	.title
	{
		font-size: 27px;
		font-family: Inherit;
	}
	.sub
	{
		font-size: 16px;
		font-family: Arial;
	}
	</style>
</head>
<body>
	<table>
		<tr>
			<td class="title" colspan="18">Commission Report</td>
		</tr>
		<tr>
			<td class="sub" colspan="18">{{ $warehouse_name }}</td>
		</tr>
		<tr class="head">
			<th>Pin</th>
            <th>Activation</th>
            <th>Date Used</th>
            <th>Amount</th>
            <th>Commission Percentage</th>
            <th>Receivable Amount</th>
		</tr>
		@foreach($table as $t)
		<tr>
			<td>{{$t->mlm_pin}}</td>
            <td>{{$t->mlm_activation}}</td>
            <td>{{$t->record_log_date_updated}}</td>
            <td>{{currency('Php',$t->item_price)}}</td>
            <td>{{$t->merchant_commission_percentage}}%</td>
            <td>{{currency('Php',$t->item_price*($t->merchant_commission_percentage/100))}}</td>
		</tr>
		@endforeach
		<br>
		<tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <th>Total Commission </th>
            <td>{{currency('Php',$totalcommission)}}</td>
        </tr>
	</table>
</body>
</html>