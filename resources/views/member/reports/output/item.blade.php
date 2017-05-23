<div class="report-container">
	<div class="panel panel-default panel-block panel-title-block panel-report">
	    <div class="panel-heading">
	    	@include('member.reports.report_header');
	        <div class="table-repsonsive">
				<table class="table table-condensed collaptable">
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
							@if(isset($category_data[$c_key]))
								<tr data-id="a_{{$c_key}}" data-parent="" @if($report_type != 'excel') style="background-color: #dedede;" @endif >
									<td colspan="{{count($report_field)}}">{{$category_data[$c_key]->type_name}}</td>
									<td></td>
								</tr>

								@foreach($c_value as $c_v_key => $c_v_value)
									@if(isset($item_info[$c_v_key]))
										<tr data-id="a_1_{{$c_v_key}}" data-parent="a_{{$c_key}}" @if($report_type != 'excel') style="background-color: #F5F5F5;" @endif >
											<td colspan="{{count($report_field)}}" ><span style="margin-left: 20px">{{$item_info[$c_v_key]}}</span></td>
											<td>{{currency('PHP', collect($sales_by_item[$c_v_key])->sum('amount'))}}</td>
						            	</tr>
						            	<?php $total = 0; ?>
						            	@if(isset($sales_by_item[$c_v_key]))
								            @foreach($sales_by_item[$c_v_key] as $key => $value2)
								            	<tr data-id="b_{{$key}}" data-parent="a_1_{{$c_v_key}}">
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
								            <tr data-id="b_{{$c_v_key}}" data-parent="a_1_{{$c_v_key}}">
												<td colspan="{{count($report_field) - 1}}">Total : {{$item_info[$c_v_key]}} </td>
												<td></td>
												<td>{{currency('PHP', $total)}}</td>
											</tr>
										@endif
									@endif
					            @endforeach
				            @endif
			            @endforeach
	            	</tbody>
				</table>
	        </div>
	    </div>
	</div>
</div>