<table class="table table-bordered"> 
@foreach($order_by_customer as $key => $value)
	<tr>
		<td>{{name_format_from_customer_info($customer_id[$key])}}</td>
		<td>
			@foreach($value as $key2 => $value2)
				<div class="col-md-12">{{$key2}} : {{$value2}}</div>
			@endforeach
		</td>
		<td>@if(isset($count_per_customer[$key])) {{$count_per_customer[$key]}} @else 0 @endif</td>
	</tr>
@endforeach
</table> 