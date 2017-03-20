<form class="global-submit form-horizontal" role="form" action="/member/payroll/payroll_group/modal_update_payroll_group" method="post">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal">×</button>
		<h4 class="modal-title">Create Payroll</h4>
		<input type="hidden" name="_token" value="{{csrf_token()}}">
		<input type="hidden" name="payroll_group_id" value="{{$group->payroll_group_id}}">
	</div>
	<div class="modal-body clearfix">
		
		
		<div class="form-group">
			<div class="col-md-12">
				<ul class="nav nav-tabs nav-tabs-custom">
					<li class="active"><a data-toggle="tab" href="#basic">Basic</a></li>
					<li><a data-toggle="tab" href="#deduction-basis">Deduction Basis</a></li>
					<li><a data-toggle="tab" href="#over-time-rates">Over Time Rates</a></li>
					<li><a data-toggle="tab" href="#shifting">Shifting</a></li>
				</ul>
				<div class="tab-content tab-content-custom tab-pane-div margin-bottom-0">
					<div id="basic" class="tab-pane fade in active form-horizontal">
						<div class="form-group">
							<div class="col-md-4">
								<small>Payroll Code</small>
								<input type="text" name="payroll_group_code" class="form-control" value="{{$group->payroll_group_code}}">
							</div>
						</div>
						<div class="form-group">
							<div class="col-md-4">
								<small>Salary Computation</small>
								<div class="panel panel-default">
									<div class="panel-body">
										<div class="radio">
											<label><input type="radio" name="payroll_group_salary_computation" value="Flat Rate" {{$group->payroll_group_salary_computation == 'Flat Rate' ? 'checked':''}}>Flat Rate</label>
										</div>
										<div class="radio">
											<label><input type="radio" name="payroll_group_salary_computation" value="Daily"  {{$group->payroll_group_salary_computation == 'Daily' ? 'checked':''}}>Daily</label>
										</div>
									</div>
								</div>
							</div>
							<div class="col-md-4">
								<small>Payroll Period</small>
								<div class="panel panel-default">
									<div class="panel-body">
										<div class="radio">
											<label><input type="radio" name="payroll_group_period" value="Weekly" {{$group->payroll_group_period == 'Weekly' ? 'checked':''}}>Weekly</label>
										</div>
										<div class="radio">
											<label><input type="radio" name="payroll_group_period" value="Semi-Monthly" {{$group->payroll_group_period == 'Semi-Monthly' ? 'checked':''}}>Semi-Monthly</label>
										</div>
										<div class="radio">
											<label><input type="radio" name="payroll_group_period" value="Monthly" {{$group->payroll_group_period == 'Monthly' ? 'checked':''}}>Monthly</label>
										</div>
									</div>
								</div>
							</div>
							<div class="col-md-4">
								<small>13 Month Basis</small>
								<div class="panel-default panel">
									<div class="panel-body">
										<label>Compute 13 Month</label>
										<div class="radio">
											<label><input type="radio" name="payroll_group_13month_basis" value="Periodically" {{$group->payroll_group_13month_basis == 'Periodically' ? 'checked':''}}>Periodically</label>
										</div>
										<div class="radio">
											<label><input type="radio" name="payroll_group_13month_basis" value="Custom Period" {{$group->payroll_group_13month_basis == 'Custom Period' ? 'checked':''}}>Custom Period</label>
										</div>
										<div class="radio">
											<label><input type="radio" name="payroll_group_13month_basis" value="Do not compute" {{$group->payroll_group_13month_basis == 'Do not compute' ? 'checked':''}}>Do not compute</label>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div id="deduction-basis" class="tab-pane fade form-horizontal">
						<div class="form-group">
							<div class="col-md-8">
								<div class="panel panel-default">
									<div class="panel-body">
										<label>Periods of Basic Deduction</label>
										<div class="checkbox">
											<label><input type="checkbox" name="payroll_group_deduct_before_absences" value="1" {{$group->payroll_group_deduct_before_absences == '1' ? 'checked':''}}>Deduct before absences and lates is deducted.</label>
										</div>
									</div>
								</div>
								<div class="panel panel-default">
									<div class="panel-body form-horizontal">
										<div class="form-group">
											<label class="col-md-12">Withholding Tax</label>
										</div>
										<div class="form-group">
											<div class="col-md-4">
												<div class="radio">
													<label><input type="radio" name="payroll_group_tax" value="Every Period" {{$group->payroll_group_tax == 'Every Period' ? 'checked':''}}>Every Period</label>
												</div>
											</div>
											<div class="col-md-4">
												<div class="radio">
													<label><input type="radio" name="payroll_group_tax" value="Last Period" {{$group->payroll_group_tax == 'Last Period' ? 'checked':''}}>Last Period</label>
												</div>
											</div>
											<div class="col-md-4">
												<div class="radio">
													<label><input type="radio" name="payroll_group_tax" value="Not Deducted" {{$group->payroll_group_tax == 'Not Deducted' ? 'checked':''}}>Not Deducted</label>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="form-group">
									<div class="col-md-4">
										<div class="panel panel-default">
											<div class="panel-body">
												<label>SSS</label>
												<div class="radio">
													<label><input type="radio" name="payroll_group_sss" value="1st Period" {{$group->payroll_group_sss == '1st Period' ? 'checked' : ''}}>1st Period</label>
												</div>
												<div class="radio">
													<label><input type="radio" name="payroll_group_sss" value="2nd Period" {{$group->payroll_group_sss == '2nd Period' ? 'checked' : ''}}>2nd Period</label>
												</div>
												
												<div class="radio">
													<label><input type="radio" name="payroll_group_sss" value="Last Period" {{$group->payroll_group_sss == 'Last Period' ? 'checked' : ''}}>Last Period</label>
												</div>
												<div class="radio">
													<label><input type="radio" name="payroll_group_sss" value="Every Period" {{$group->payroll_group_sss == 'Every Period' ? 'checked' : ''}}>Every Period</label>
												</div>
												<div class="radio">
													<label><input type="radio" name="payroll_group_sss" value="Not Deducted" {{$group->payroll_group_sss == 'Not Deducted' ? 'checked' : ''}}>Not Deducted</label>
												</div>
											</div>
										</div>
									</div>
									<div class="col-md-4">
										<div class="panel panel-default">
											<div class="panel-body">
												<label>PhilHealth</label>
												<div class="radio">
													<label><input type="radio" name="payroll_group_philhealth" value="1st Period" {{$group->payroll_group_philhealth == '1st Period' ? 'checked' : ''}}>1st Period</label>
												</div>
												<div class="radio">
													<label><input type="radio" name="payroll_group_philhealth" value="2nd Period" {{$group->payroll_group_philhealth == '2nd Period' ? 'checked' : ''}}>2nd Period</label>
												</div>
												
												<div class="radio">
													<label><input type="radio" name="payroll_group_philhealth" value="Last Period" {{$group->payroll_group_philhealth == 'Last Period' ? 'checked' : ''}}>Last Period</label>
												</div>
												<div class="radio">
													<label><input type="radio" name="payroll_group_philhealth" value="Every Period" {{$group->payroll_group_philhealth == 'Every Period' ? 'checked' : ''}}>Every Period</label>
												</div>
												<div class="radio">
													<label><input type="radio" name="payroll_group_philhealth" value="Not Deducted" {{$group->payroll_group_philhealth == 'Not Deducted' ? 'checked' : ''}}>Not Deducted</label>
												</div>
											</div>
										</div>
									</div>
									<div class="col-md-4">
										<div class="panel panel-default">
											<div class="panel-body">
												<label>PAGIBIG</label>
												<div class="radio">
													<label><input type="radio" name="payroll_group_pagibig" value="1st Period" {{$group->payroll_group_pagibig == '1st Period' ? 'checked' : ''}}>1st Period</label>
												</div>
												<div class="radio">
													<label><input type="radio" name="payroll_group_pagibig" value="2nd Period" {{$group->payroll_group_pagibig == '2nd Period' ? 'checked' : ''}}>2nd Period</label>
												</div>
												
												<div class="radio">
													<label><input type="radio" name="payroll_group_pagibig" value="Last Period" {{$group->payroll_group_pagibig == 'Last Period' ? 'checked' : ''}}>Last Period</label>
												</div>
												<div class="radio">
													<label><input type="radio" name="payroll_group_pagibig" value="Every Period" {{$group->payroll_group_pagibig == 'Every Period' ? 'checked' : ''}}>Every Period</label>
												</div>
												<div class="radio">
													<label><input type="radio" name="payroll_group_pagibig" value="Not Deducted" {{$group->payroll_group_pagibig == 'Not Deducted' ? 'checked' : ''}}>Not Deducted</label>
												</div>
											</div>
										</div>
									</div>
								</div>
								
							</div>
							<div class="col-md-4">
								<div class="panel panel-default">
									<div class="panel-body form-horizontal">
										<label>Agency Fee Deduction</label>
										<div class="radio">
											<label><input type="radio" name="payroll_group_agency" value="1st Period" {{$group->payroll_group_agency == '1st Period' ? 'checked':''}}>1st Period</label>
										</div>
										<div class="radio">
											<label><input type="radio" name="payroll_group_agency" value="2nd Period" {{$group->payroll_group_agency == '2nd Period' ? 'checked':''}}>2nd Period</label>
										</div>
										<div class="radio">
											<label><input type="radio" name="payroll_group_agency" value="Every Period" {{$group->payroll_group_agency == 'Every Period' ? 'checked':''}}>Every Period</label>
										</div>
										<div class="radio">
											<label><input type="radio" name="payroll_group_agency" value="Not Deducted" {{$group->payroll_group_agency == 'Not Deducted' ? 'checked':''}}>Not Deducted</label>
										</div>
										
									</div>
								</div>
								<div class="panel panel-default">
									<div class="panel-body form-horizontal">
										<div class="form-group">
											<div class="col-md-12">
												<small>Agency Fee</small>
												<input type="number" name="payroll_group_agency_fee" class="form-control text-right" {{$group->payroll_group_agency_fee}}>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						
					</div>
					<div id="over-time-rates" class="tab-pane fade">
						<table class="table table-condensed table-bordered">
							<tr>
								<td colspan="2">Overtime Rate Factors</td>
								<td colspan="2"></td>
								<td colspan="3" class="text-center">Rest Day</td>
							</tr>
							<tr>
								<td colspan="2"></td>
								<td class="text-center">Over Time</td>
								<td class="text-center">Night Diff</td>
								<td></td>
								<td class="text-center">Over Time</td>
								<td class="text-center">Night Diff</td>
							</tr>
							@foreach($_overtime_rate as $rate)
							<tr>
								<td width="14.28571428571429%">
									<input type="text" name="payroll_overtime_name[]" value="{{$rate->payroll_overtime_name}}" class="width-100 border-none" readonly>
								</td>
								<td width="14.28571428571429%">
									<input type="number" name="payroll_overtime_regular[]" value="{{$rate->payroll_overtime_regular}}" class="width-100 border-none text-right" {{$rate->payroll_overtime_name == 'Regular' ? 'readonly':''}}>
								</td>
								<td width="14.28571428571429%">
									<input type="number" step="any" name="payroll_overtime_overtime[]" class="width-100 border-none text-right" value="{{$rate->payroll_overtime_overtime}}">
								</td>
								<td width="14.28571428571429%">
									<input type="number" step="any" name="payroll_overtime_nigth_diff[]" class="width-100 border-none text-right" value="{{$rate->payroll_overtime_nigth_diff}}">
								</td>
								<td width="14.28571428571429%">
									<input type="number" step="any" name="payroll_overtime_rest_day[]" class="width-100 border-none text-right" value="{{$rate->payroll_overtime_rest_day}}">
								</td>
								<td width="14.28571428571429%">
									<input type="number" step="any" name="payroll_overtime_rest_overtime[]" class="width-100 border-none text-right" value="{{$rate->payroll_overtime_rest_overtime}}">
								</td>
								<td width="14.28571428571429%">
									<input type="number" step="any" name="payroll_overtime_rest_night[]" class="width-100 border-none text-right" value="{{$rate->payroll_overtime_rest_night}}">
								</td>
							</tr>
							@endforeach
						</table>
					</div>
					<div id="shifting" class="tab-pane fade">
						<div class="form-horizontal">
							<div class="form-group">
								<div class="col-md-8 form-horizontal">
									
									<div class="form-group">
										<div class="col-md-12">
											<div class="checkbox">
												<label><input type="checkbox" name="payroll_group_is_flexi_time" class="check-flexi" value="1" {{$group->payroll_group_is_flexi_time == 1 ? 'checked':''}}>Flexi Time</label>
											</div>
										</div>
									</div>
									<div class="form-group">
										<div class="col-md-6">
											<small>Working Days(per month)</small>
											<input type="number" name="payroll_group_working_day_month" class="form-control text-right" value="{{$group->payroll_group_working_day_month}}">
										</div>
										<div class="col-md-6">
											<small>Target Hours</small>
											<div class="input-group">
												<span class="input-group-btn width-120px">
													<select class="form-control select-target-hours" disabled name="payroll_group_target_hour_parameter">
														<option value="Daily" {{$group->payroll_group_target_hour_parameter == 'Daily' ? 'selected="selected"':''}}>Daily</option>
														<option value="Per Period" {{$group->payroll_group_target_hour_parameter == 'Per Period' ? 'selected="selected"':''}}>Per Period</option>
													</select>
												</span>
												<input type="number" name="payroll_group_target_hour" class="form-control text-right" value="{{$group->payroll_group_target_hour}}">
											</div>
										</div>
									</div>
									<div class="form-group">
										<div class="col-md-6">
											<small>Grace Time Period (minutes)</small>
											<input type="number" name="payroll_group_grace_time" class="form-control text-right" {{$group->payroll_group_grace_time}}>
										</div>
										<div class="col-md-6">
											<small>Break (minutes)</small>
											<input type="number" name="payroll_group_break" class="form-control text-right" {{$group->payroll_group_break}}>
										</div>
									</div>
									<div class="form-group">
										<div class="col-md-12">
											<table class="table table-bordered table-condensed">
												<tr>
													<td colspan="2" class="text-center">Schedule</td>
												</tr>
												<tr>
													<td class="text-center" width="50%">Work Start</td>
													<td class="text-center" width="50%">Work End</td>
												</tr>
												<tr>
													<td class="text-center editable">
														<input type="time" name="payroll_group_start" class="form-control" value="{{$group->payroll_group_start}}">
													</td>
													<td class="text-center editable">
														<input type="time" name="payroll_group_end" class="form-control" value="{{$group->payroll_group_end}}">
													</td>
												</tr>
											</table>
										</div>
									</div>
									
									
								</div>
								<div class="col-md-4">
									<table class="table table-bordered table-condensed padding-tb-2">
										<tr>
											<td>Rest Day</td>
											<td>Extra Day</td>
										</tr>
										@foreach($_day as $day)
										<tr>
											<td>
												<div class="checkbox">
													<label><input type="checkbox" class="restday-check" name="restday[]" value="{{$day['rest_day']}}" {{$day['rest_day_checked']}}>{{$day['rest_day']}}</label>
												</div>
											</td>
											<td>
												<div class="checkbox">
													<label><input type="checkbox" class="extraday-check" name="extraday[]"" value="{{$day['extra_day']}}" {{$day['extra_day_checked']}}>{{$day['extra_day']}}</label>
												</div>
											</td>
										</tr>
										@endforeach
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="modal-footer">
		<button type="button" class="btn btn-def-white btn-custom-white" data-dismiss="modal">Close</button>
		<button class="btn btn-primary btn-custom-primary" type="Submit">Submit</button>
	</div>
</form>
<script type="text/javascript">
	$(".restday-check").unbind("change");
	$(".restday-check").bind("change", function () {
		var parent = $(this).parents('tr').find('.extraday-check');
		if($(this).is(":checked"))
		{
			parent.prop("checked", false);
		}
		// else
		// {
			// 	parent.prop("checked", true);
		// }
	});
	$(".extraday-check").unbind("change");
	$(".extraday-check").bind("change", function () {
		var parent = $(this).parents('tr').find('.restday-check');
		if($(this).is(":checked"))
		{
			parent.prop("checked", false);
		}
		// else
		// {
			// 	parent.prop("checked", true);
		// }
	});
	$(".check-flexi").unbind("change");
	$(".check-flexi").bind("change", function(){
		if($(this).is(":checked"))
		{
			$(".select-target-hours").removeAttr("disabled");
		}
		else
		{
			$(".select-target-hours").attr("disabled", true);
			$(".select-target-hours").val("Daily");
		}
	});
</script>