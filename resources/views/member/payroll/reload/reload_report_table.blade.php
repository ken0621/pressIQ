<table class="table table-condensed table-bordered column-fit">
	<thead>
		<tr>
			<th></th>
			@if(isset($_columns))
				@foreach($_columns as $column)
				<th class="block">{{$column}}</th>
				@endforeach
			@endif
		</tr>
	</thead>
	<tbody>
		@if(isset($_columns))
			@foreach($_emp as $emp)
			<tr>
				<td>{!!$emp['name']!!}</td>
				@foreach($emp['_record'] as $record)
				<td class="text-right">
					{!!$record!!}
				</td>
				@endforeach
			</tr>
			
			@endforeach
		@endif
		<tr>
			<td><b>Total</b></td>
			@foreach($_total as $total)
			<td class="text-right">
				<b>{{number_format($total, 2)}}</b>
			</td>
			@endforeach
		</tr>
	</tbody>
</table>