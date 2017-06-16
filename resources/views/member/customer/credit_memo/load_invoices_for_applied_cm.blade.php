<input type="hidden" {{$total_orig = 0}} {{$total_bal = 0}} name="">
@if(isset($_invoice) && $_invoice != null)
	@foreach($_invoice as $invoice)
		<tr class="tr-inv-cm">
			<input type="hidden" value="invoice" name="rpline_txn_type[]">
			<input type="hidden" value="{{$invoice['inv_id']}}" name="rpline_txn_id[]">
		    <td class="text-center">
		    	<input type="hidden" class="line-is-checked" name="line_is_checked[]" value="" >
		    	<input type="radio" name="invoice_number" data-content="{{$invoice['inv_id']}}" value="{{$invoice['inv_id']}}" class="line-checked">
		    </td>
		    <td>Invoice # {{$invoice["new_inv_id"]}} ( {{dateFormat($invoice["inv_date"])}} )</td>
		    <td class="text-right">{{dateFormat($invoice["inv_due_date"])}}</td>
		    <td><input type="text" class="text-right original-amount" {{$total_orig += $invoice['inv_overall_price'] }} value="{{currency('',$invoice['inv_overall_price']) }}" disabled /></td>
		    <td><input type="text" class="text-right balance-due" {{ $total_bal += ($invoice['inv_overall_price']) - $invoice['amount_applied'] + (isset($invoice['rpline_amount']) ? $invoice['rpline_amount'] : 0) }} data-content="{{($invoice['inv_overall_price']) - $invoice['amount_applied'] + (isset($invoice['rpline_amount']) ? $invoice['rpline_amount'] : 0) }}" value="{{currency('', ($invoice['inv_overall_price']) - $invoice['amount_applied'] + (isset($invoice['rpline_amount']) ? $invoice['rpline_amount'] : 0 ))}}" disabled /></td>
		    <td><input type="text" class="text-right amount-payment compute-amt-p" name="cm_amount_applied[{{$invoice['inv_id']}}]" data-content="{{$invoice['inv_id']}}" /></td>
		</tr>

		<script type="text/javascript">
			console.log("{{(isset($invoice['rpline_amount']) ? $invoice['rpline_amount'] : 0 )}}");
		</script>
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
<tr class="tr-inv-cm">
	<td></td>
    <td></td>
    <td class="text-right"><strong>Totals</strong></td>
    <td class="text-right">{{currency('',$total_orig)}}</td>
    <td class="text-right">{{currency('',$total_bal)}}</td>
    <td class="text-right"><span class="amount-applied-total"></span></td>
</tr>