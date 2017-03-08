@foreach($_invoice as $invoice)
	<tr>
		<input type="hidden" value="Invoice" name="txn_type[]">
		<input type="hidden" value="{{$invoice['inv_id']}}" name="txn_id[]">
	    <td class="text-center">
	    	<input type="hidden" class="line-is-checked" name="line_is_checked[]" value="" >
	    	<input type="checkbox" class="line-checked">
	    </td>
	    <td>Invoice # {{$invoice["inv_id"]}} ( {{$invoice["inv_date"]}} )</td>
	    <td class="text-right">{{$invoice["inv_due_date"]}}</td>
	    <td><input type="text" class="text-right original-amount" value="{{currency('',$invoice['inv_overall_price'])}}" disabled /></td>
	    <td><input type="text" class="text-right balance-due" value="{{currency('',$invoice['inv_overall_price'] - $invoice['inv_payment_applied'])}}" disabled /></td>
	    <td><input type="text" class="text-right amount-payment" name="amount_payment[]"/></td>
	</tr>
@endforeach