{!! $customer_view !!}

<table class="table table-condensed" style="overflow-y: auto;">
	<thead>
	<th>START BALANCE</th>
	<th>COMPLAN</th>
	<th>AMOUNT</th>
	<th>NEW BALANCE</th>
	</thead>
	<tbody>
	<?php $last_amount = 0; ?>
	<?php $last_date = Carbon\Carbon::now(); ?>
	@foreach($sort_by_date as $key => $value)

		<tr>
			<td class="btn-primary" colspan="40">{{$key}}</td>
		</tr>
		@foreach($value as $key2 => $value2)
		
		<tr>
			<td>{{$last_amount}}</td>
			<td>{{$value2->wallet_log_plan}}</td>
			<td>{{$value2->wallet_log_amount}}</td>
			<?php $last_amount += $value2->wallet_log_amount; ?>
			<td>{{$last_amount}}</td>
		</tr>
		@endforeach
		<?php $last_date = $key; ?>
		<tr>
			<td colspan="40">
				<span class="pull-right">{{$last_date}}  End Balance: {{$last_amount}}</span>
			</td>
		</tr>
	@endforeach	
	
	</tbody>
</table>