<div class="report-container">
	<div class="panel panel-default panel-block panel-report panel-title-block">
	    <div class="panel-heading">
	    	@include('member.reports.report_header');
	        <div class="table-repsonsive">
				<table class="table table-condensed collaptable">
					<thead>
						<tr>
							@foreach($report_field as $key => $value)
								<th class="text-center">{{$value->report_field_label}}</th>
							@endforeach
							<th>Balance</th>
						</tr>
					</thead>
					<tbody>
			            @foreach($sales_by_customer as $key => $value)
			            	<?php $total = 0; ?>
			            	<?php $amount = 0; ?>
			            	<tr data-id="{{$key}}" data-parent="" >
			            		<td colspan="20" @if($report_type != 'excel') style="background-color: #dedede;" @endif >{{$customer_info[$key]}}</td>
			            	</tr>
			            	@foreach($value as $key2 => $value2)
			            	<tr data-id="{{$key2}}" data-parent="{{$key}}">
				            	@foreach($report_field as $key3 => $value3)
									@if($key3  == 'jline_amount')
									<td>{{currency('PHP', $value2->amount)}}</td>
									@else
									<td>{{$value2->$key3}}</td>
									@endif
		
								@endforeach
								<?php $total += $value2->amount; ?>
								<td>{{currency('PHP', $total)}}</td>
							</tr>		
							@endforeach
							<tr>
								<td colspan="{{count($report_field) - 1}}">Total : {{$customer_info[$key]}} </td>
								<td>{{currency('PHP', $total)}}</td>
								<td>{{currency('PHP', $total)}}</td>
							</tr>
			            @endforeach
			            
	            	</tbody>
				</table>
	        </div>
	        <h5 class="text-center">---- {{$now or ''}} ----</h5>
	    </div>
	</div>
</div>