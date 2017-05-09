<div class="panel panel-default panel-block panel-title-block">
    <div class="panel-heading">
        <div class="table-repsonsive">
			<table class="table table-condensed table-bordered">
				<thead>
					
					@foreach($report_field as $key => $value)
						<th>{{$value->report_field_label}}</th>
					@endforeach
					<th>Balance</th>
				</thead>
				<tbody>
		            @foreach($sales_by_customer as $key => $value)
		            	<?php $total = 0; ?>
		            	<tr>
		            		<td colspan="20" style="background-color: gray; color: white">{{$customer_info[$key]}}</td>
		            	</tr>
		            	@foreach($value as $key2 => $value2)
		            	<tr>
			            	@foreach($report_field as $key3 => $value3)
								<td>{{$value2->$key3}}</td>
							@endforeach
							<?php $total += $value2->jline_amount; ?>
							<td>{{$total}}</td>
						</tr>		
						@endforeach
						<tr>
							<td colspan="{{count($report_field) - 1}}">Total : {{$customer_info[$key]}} </td>
							<td>{{$total}}</td>
							<td>{{$total}}</td>
						</tr>
		            @endforeach
		            
            	</tbody>
			</table>
        </div>
    </div>
</div>