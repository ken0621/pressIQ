
<table class="table table-bordered table-hover table_css">
	<tbody class="tbody_css">
	@foreach($order as $key => $value)
		@if(count($order) == 1)
		<script type="text/javascript">load_append_order('{{$value->ec_order_id}}');</script>
		@endif
		<tr>
			<td>
				<div class="col-md-12">
					Order # {{$value->ec_order_id}}
					<span class="pull-right"><button class="btn btn-primary" onClick="load_append_order('{{$value->ec_order_id}}')">View</button></span>
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
	</tbody>
</table>