<table class="table table-bordered table-hover">
	@foreach($order as $key => $value)
		<tr>
			<td>
				<div class="col-md-12">
					Order # {{$value->ec_order_id}}
					<span class="pull-right"><button class="btn btn-primary">View</button></span>
				</div>
				<div class="col-md-12">
					{{name_format_from_customer_info($value)}}
				</div>
				<div class="col-md-12">
					{{$value->order_status}}
				</div>
			</td>
		</tr>
	@endforeach
</table>