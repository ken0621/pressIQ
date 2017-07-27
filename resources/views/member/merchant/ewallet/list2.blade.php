@if($r_list)
	@if(count($r_list) >= 1)
		<h3>{!! $headers !!}</h3>
		<h4>{{$user->user_first_name}} {{$user->user_last_name}}</h4>
		<table class="table table-bordered">
			<tr>
				<th>Id</th>
				<th>Date Requested</th>
				<th>Amount</th>
				<th></th>
			</tr>
			@foreach($r_list as $key => $value)
				<tr>
					<td>{{$value->merchant_ewallet_id}}</td>
					<td>{{$value->merchant_ewallet_request_date}}</td>
					<td>{{$value->merchant_ewallet_amount}}</td>
					<td>
						<a onclick="view_link('/member/merchant/ewallet/list?user_id={{$user->user_id}}&find={{$headers}}&merchant_ewallet_id={{$value->merchant_ewallet_id}}')">Breakdown</a>
					</td>
				</tr>
			@endforeach
		</table>
	@else
	<center>-No Data Found-</center>
	@endif
@else

@endif