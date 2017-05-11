<!-- @url  -->
@foreach($_payment_method as $key=>$payment)
	<option value="{{$payment->payment_method_id}}" {{ isset($payment_method_id) ?  ($payment_method_id == $payment->payment_method_id ? 'selected|'.$payment_method_id : '') : ($key == 0 ? 'selected' : '') }}>{{$payment->payment_name}} </option>
@endforeach
<option class="hidden" value="" />