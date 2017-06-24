<table border="1" width="100%" style="text-align: center;">
	<thead>
		<tr>
			<th>ID</th>
			<th>Checkout ID</th>
			<th>Log Date</th>
			<th>Order ID</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
		@foreach($_paymaya as $paymaya)
			<tr>
				<td>{{ $paymaya->id }}</td>
				<td>{{ $paymaya->checkout_id }}</td>
				<td>{{ $paymaya->log_date }}</td>
				<td>{{ $paymaya->order_id }}</td>
				<td><a href="/payment/paymaya/maintenance/edit/{{ $paymaya->id }}">Edit</a></td>
			</tr>
		@endforeach
	</tbody>
</table>