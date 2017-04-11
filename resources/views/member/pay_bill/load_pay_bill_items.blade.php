@if(isset($_bill) && $_bill != null)
	@foreach($_bill as $bill)
		<tr>
			<input type="hidden" value="bill" name="rpline_txn_type[]">
			<input type="hidden" value="{{$bill['bill_id']}}" name="rpline_txn_id[]">
		    <td class="text-center">
		    	<input type="hidden" class="line-is-checked" name="line_is_checked[]" value="" >
		    	<input type="checkbox" class="line-checked">
		    </td>
		    <td>Invoice # {{$bill["bill_id"]}} ( {{dateFormat($bill["bill_date"])}} )</td>
		    <td class="text-right">{{dateFormat($bill["bill_due_date"])}}</td>
		    <td><input type="text" class="text-right original-amount" value="{{currency('',$bill['bill_total_amount'])}}" disabled /></td>
		    <td><input type="text" class="text-right balance-due" value="{{currency('', $bill['bill_total_amount'] - $bill['amount_applied'] + (isset($bill['pbline_amount']) ? $bill['pbline_amount'] : 0 ))}}" disabled /></td>
		    <td><input type="text" class="text-right amount-payment" name="pbline_amount[]" value="{{$bill['pbline_amount'] or ''}}" data="{{$bill['pbline_amount'] or 0}}"/></td>
		</tr>
	@endforeach
@else
	<tr>
	    <td class="text-center"></td>
	    <td></td>
	    <td class="text-right"></td>
	    <td><input type="text" class="text-right" disabled /></td>
	    <td><input type="text" class="text-right" disabled /></td>
	    <td><input class="text-right" type="text" disabled /></td>
	</tr> 
@endif