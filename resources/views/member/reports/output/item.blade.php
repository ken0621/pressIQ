<div class="panel panel-default panel-block panel-title-block">
    <div class="panel-heading">
        <div class="table-repsonsive">
			<table class="table table-condensed table-bordered collaptable">
				<thead>
					
					<tr>
					@foreach($report_field as $key => $value)
						<th>{{$value->report_field_label}}</th>
					@endforeach
						<th>Balance</th>
					</tr>
				</thead>
				<tbody>
					@foreach($category as $c_key => $c_value)
						<tr data-id="a_{{$c_key}}" data-parent="" >
							<td @if($report_type != 'excel') style="background-color: gray; color: white" @endif colspan="20">{{$category_data[$c_key]->type_name}}</td>
						</tr>

						@foreach($c_value as $c_v_key => $c_v_value)
							@if(isset($item_info[$c_v_key]))
								<tr>
				            		<td @if($report_type != 'excel') style="background-color: #F5F5F5;" @endif ></td><td colspan="20" @if($report_type != 'excel') style="background-color: #F5F5F5;" @endif >{{$item_info[$c_v_key]}}</td>
				            	</tr>
				            	<?php $total = 0; ?>
					            @foreach($sales_by_item[$c_v_key] as $key => $value2)
					            	<tr data-id="b_{{$key}}" data-parent="a_{{$c_key}}">
					            	<?php $amount = debit_credit($value2->jline_type, $value2->jline_amount); ?>
						            	@foreach($report_field as $key3 => $value3)
											@if($key3  == 'jline_amount')
												<td>{{currency('PHP', $amount)}}</td>
											@else
												<td>{{$value2->$key3}}</td>
											@endif
										@endforeach
										<?php $total += $amount; ?>
										<td>{{currency('PHP', $amount)}}</td>
									</tr>		
									
					            @endforeach
					            <tr>
									<td colspan="{{count($report_field) - 1}}">Total : {{$item_info[$c_v_key]}} </td>
									<td>{{currency('PHP', $total)}}</td>
									<td>{{currency('PHP', $total)}}</td>
								</tr>
								<tr>
									<td colspan="20"></td>
								</tr>
							@endif
			            @endforeach
		            @endforeach
            	</tbody>
			</table>
        </div>
    </div>
</div>