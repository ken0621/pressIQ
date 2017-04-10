@if(isset($_invoice) && $_invoice != null)
	@foreach($_invoice as $invoice)
		<tr>
			<input type="hidden" value="invoice" name="rpline_txn_type[]">
			<input type="hidden" value="{{$invoice['inv_id']}}" name="rpline_txn_id[]">
		    <td class="text-center">
		    	<input type="hidden" class="line-is-checked" name="line_is_checked[]" value="" >
		    	<input type="checkbox" class="line-checked">
		    </td>
		    <td>Invoice # {{$invoice["new_inv_id"]}} ( {{dateFormat($invoice["inv_date"])}} )</td>
		    <td class="text-right">{{dateFormat($invoice["inv_due_date"])}}</td>
		    <td><input type="text" class="text-right original-amount" value="{{currency('',$invoice['inv_overall_price'])}}" disabled /></td>
		    <td><input type="text" class="text-right balance-due" value="{{currency('', $invoice['inv_overall_price'] - $invoice['amount_applied'] + (isset($invoice['rpline_amount']) ? $invoice['rpline_amount'] : 0 ))}}" disabled /></td>
		    <td><input type="text" class="text-right amount-payment" name="rpline_amount[]" value="{{$invoice['rpline_amount'] or ''}}" data="{{$invoice['rpline_amount'] or 0}}"/></td>
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