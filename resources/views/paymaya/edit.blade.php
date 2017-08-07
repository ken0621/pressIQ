<form method="post">
	<input type="hidden" name="_token" value="{{ csrf_token() }}">
	<select name="order_id">
		@foreach($_order as $order)
			<option value="{{ $order->ec_order_id }}">{{ $order->ec_order_id }}</option>
		@endforeach
	</select>
	<button type="submit">Submit</button>
</form>