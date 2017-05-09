<div class="panel panel-default panel-block panel-title-block">
    <div class="panel-heading">
        <div class="table-repsonsive">
			<table class="table table-condensed table-bordered">
				<thead>
					
					@foreach($report_field as $key => $value)
						<th>{{$value->report_field_label}}</th>
					@endforeach
				</thead>
				<tbody>
					
		            @foreach($sales_by_customer as $key => $value)
		            
		            	@foreach($value as $key2 => $value2)
		            	<tr>
			            	@foreach($report_field as $key3 => $value3)
								
										<td>{{$value2->$key3}}</td>
								
							@endforeach
						</tr>		
						@endforeach
		            @endforeach
		            
            	</tbody>
			</table>
        </div>
    </div>
</div>