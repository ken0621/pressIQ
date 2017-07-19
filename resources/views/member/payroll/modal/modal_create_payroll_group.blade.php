<link rel="stylesheet" type="text/css" href="/assets/member/payroll/css/timesheet.css">
<link rel="stylesheet" type="text/css" href="/assets/external/jquery.timeentry.package-2.0.1/jquery.timeentry.css">
<form class="global-submit form-horizontal" role="form" action="/member/payroll/payroll_group/modal_save_payroll_group" method="post">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal">×</button>
		<h4 class="modal-title">Create Payroll</h4>
		<input type="hidden" name="_token" value="{{csrf_token()}}">
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
								<input type="text" name="payroll_group_code" class="form-control">
							</div>
						</div>
						<div class="form-group">
							<div class="col-md-4">
								<small>Salary Computation</small>
								<div class="panel panel-default">
									<div class="panel-body">
										<div class="radio">
											<label><input type="radio" name="payroll_group_salary_computation" value="Flat Rate">Flat Rate</label>
										</div>
										<div class="radio">
											<label><input type="radio" name="payroll_group_salary_computation" value="Daily Rate" checked>Daily Rate</label>
										</div>
										<div class="radio">
											<label><input type="radio" name="payroll_group_salary_computation" value="Monthly Rate" >Monthly Rate</label>
										</div>
									</div>
								</div>
							</div>
							<div class="col-md-4">
								<small>Payroll Period</small>
								<div class="panel panel-default">
									<div class="panel-body">
										@foreach($_period as $period)
										<div class="radio">
											<label><input type="radio" name="payroll_group_period" value="{{$period->payroll_tax_period}}">{{$period->payroll_tax_period}}</label>
										</div>
										@endforeach
										
									</div>
								</div>
							</div>
							<div class="col-md-4">
								<small>13 Month Basis</small>
								<div class="panel-default panel">
									<div class="panel-body">
										<label>Compute 13 Month</label>
										<div class="radio">
											<label><input type="radio" name="payroll_group_13month_basis" value="Periodically">Periodically</label>
										</div>
										<div class="radio">
											<label><input type="radio" name="payroll_group_13month_basis" value="Custom Period" checked>Custom Period</label>
										</div>
										<div class="radio">
											<label><input type="radio" name="payroll_group_13month_basis" value="Do not compute">Do not compute</label>
										</div>
									</div>
								</div>
							</div>

						</div>
						<div class="form-group">
							<div class="col-md-4">
								<small>Display Rate</small>
								<div class="panel panel-default">
									<div class="panel-body">
										<div class="checkbox">
											<label><input type="checkbox" name="display_monthly_rate" checked value="1">Display Monthly rate</label>
										</div>
										<div class="checkbox">
											<label><input type="checkbox" name="display_daily_rate" checked value="1">Display Daily rate</label>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div id="deduction-basis" class="tab-pane fade form-horizontal">
						<div class="form-group">
							<div class="col-md-8"><!-- 
								<div class="panel panel-default">
									<div class="panel-body">
										<label>Periods of Basic Deduction</label>
										<div class="checkbox">
											<label><input type="checkbox" name="payroll_group_deduct_before_absences" value="1">Deduct before absences and lates is deducted.</label>
										</div>
									</div>
								</div> -->
								<div class="panel panel-default">
									<div class="panel-body">
										<div class="form-horizontal">
											<div class="form-group">
												<div class="col-md-12">
													<div class="checkbox">
														<label><input type="checkbox" name="payroll_group_before_tax" value="1">Deduct Tax after SSS, PhilHealth, & Pagibig</label>
													</div>
												</div>
											</div>
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
													<label><input type="radio" name="payroll_group_tax" value="Every Period" checked>Every Period</label>
												</div>
											</div>
											<div class="col-md-4">
												<div class="radio">
													<label><input type="radio" name="payroll_group_tax" value="Last Period" >Last Period</label>
												</div>
											</div>
											<div class="col-md-4">
												<div class="radio">
													<label><input type="radio" name="payroll_group_tax" value="Not Deducted">Not Deducted</label>
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
													<label><input type="radio" name="payroll_group_sss" value="1st Period">1st Period</label>
												</div>
												<div class="radio">
													<label><input type="radio" name="payroll_group_sss" value="2nd Period">2nd Period</label>
												</div>
												
												<div class="radio">
													<label><input type="radio" name="payroll_group_sss" value="Last Period" checked>Last Period</label>
												</div>
												<div class="radio">
													<label><input type="radio" name="payroll_group_sss" value="Every Period" checked>Every Period</label>
												</div>
												<div class="radio">
													<label><input type="radio" name="payroll_group_sss" value="Not Deducted">Not Deducted</label>
												</div>
											</div>
										</div>
									</div>
									<div class="col-md-4">
										<div class="panel panel-default">
											<div class="panel-body">
												<label>PhilHealth</label>
												<div class="radio">
													<label><input type="radio" name="payroll_group_philhealth" value="1st Period">1st Period</label>
												</div>
												<div class="radio">
													<label><input type="radio" name="payroll_group_philhealth" value="2nd Period">2nd Period</label>
												</div>
												
												<div class="radio">
													<label><input type="radio" name="payroll_group_philhealth" value="Last Period" checked>Last Period</label>
												</div>
												<div class="radio">
													<label><input type="radio" name="payroll_group_philhealth" value="Every Period" checked>Every Period</label>
												</div>
												<div class="radio">
													<label><input type="radio" name="payroll_group_philhealth" value="Not Deducted">Not Deducted</label>
												</div>
											</div>
										</div>
									</div>
									<div class="col-md-4">
										<div class="panel panel-default">
											<div class="panel-body">
												<label>PAGIBIG</label>
												<div class="radio">
													<label><input type="radio" name="payroll_group_pagibig" value="1st Period">1st Period</label>
												</div>
												<div class="radio">
													<label><input type="radio" name="payroll_group_pagibig" value="2nd Period">2nd Period</label>
												</div>
												
												<div class="radio">
													<label><input type="radio" name="payroll_group_pagibig" value="Last Period" checked>Last Period</label>
												</div>
												<div class="radio">
													<label><input type="radio" name="payroll_group_pagibig" value="Every Period" checked>Every Period</label>
												</div>
												<div class="radio">
													<label><input type="radio" name="payroll_group_pagibig" value="Not Deducted">Not Deducted</label>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="panel panel-default">
									<div class="panel-body form-horizontal">
										<div class="form-group">
											<label class="col-md-12">Late Deduction</label>
										</div>
										<div class="form-group">
											<div class="col-md-4">
												<div class="radio">
													<label><input class="late-category-change" type="radio" value="Base on Salary" name="payroll_late_category">Base on Salary</label>
												</div>
											</div>
											<div class="col-md-4">
												<div class="radio">
													<label><input class="late-category-change" type="radio" value="Custom" name="payroll_late_category">Custom</label>
												</div>
											</div>
											<div class="col-md-4">
												<div class="radio">
													<label><input class="late-category-change" type="radio" name="payroll_late_category" value="Not Deducted" checked>Not Deducted</label>
												</div>
											</div>
										</div>
										<div class="form-group display-none late-custom-form">
											<div class="col-md-6">
												<small>Late parameter</small>
												<div class="input-group">
													<input type="number" name="payroll_late_interval" class="form-control late-param-change late-param-number text-right" step="any">
													<span class="input-group-btn" style="width: 100px">
														<select class="form-control late-param-change late-param-select" name="payroll_late_parameter">
															<option value="Second">Second</option>
															<option value="Minute">Minute</option>
															<option value="Hour">Hour</option>
														</select>
													</span>
												</div>

											</div>
											<div class="col-md-6">
												<small>Deduction for every (<span class="late-label-param">0</span>)</small>
												<input type="number" name="payroll_late_deduction" class="form-control text-right" step="any">
											</div>
										</div>
									</div>
								</div>
								<div class="panel panel-default">
									<div class="panel-body form-horizontal">
										<div class="form-group">
											<label class="col-md-12">Under Time Deduction</label>
										</div>
										<div class="form-group">
											<div class="col-md-4">
												<div class="radio">
													<label><input class="under-time-category-change" type="radio" value="Base on Salary" name="payroll_under_time_category">Base on Salary</label>
												</div>
											</div>
											<div class="col-md-4">
												<div class="radio">
													<label><input class="under-time-category-change" type="radio" value="Custom" name="payroll_under_time_category">Custom</label>
												</div>
											</div>
											<div class="col-md-4">
												<div class="radio">
													<label><input class="under-time-category-change" type="radio" name="payroll_under_time_category" value="Not Deducted" checked>Not Deducted</label>
												</div>
											</div>
										</div>
										<div class="form-group display-none under-time-custom-form">
											<div class="col-md-6">
												<small>Under Time parameter</small>
												<div class="input-group">
													<input type="number" name="payroll_under_time_interval" class="form-control late-param-change late-param-number text-right" step="any">
													<span class="input-group-btn" style="width: 100px">
														<select class="form-control late-param-change late-param-select" name="payroll_under_time_parameter">
															<option value="Second">Second</option>
															<option value="Minute">Minute</option>
															<option value="Hour">Hour</option>
														</select>
													</span>
												</div>

											</div>
											<div class="col-md-6">
												<small>Deduction for every (<span class="under-time-label-param">0</span>)</small>
												<input type="number" name="payroll_under_time_deduction" class="form-control text-right" step="any">
											</div>
										</div>
									</div>
								</div>
								<div class="panel panel-default">
									<div class="panel-body form-horizontal">
										<div class="form-group">
											<label class="col-md-12">Break Deduction</label>
										</div>
										<div class="form-group">
											<div class="col-md-4">
												<div class="radio">
													<label><input class="late-category-change" type="radio" value="Base on Salary" name="payroll_break_category">Base on Salary</label>
												</div>
											</div>
											
											<div class="col-md-4">
												<div class="radio">
													<label><input class="late-category-change" type="radio" name="payroll_break_category" value="Not Deducted" checked>Not Deducted</label>
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
											<label><input type="radio" name="payroll_group_agency" value="1st Period">1st Period</label>
										</div>
										<div class="radio">
											<label><input type="radio" name="payroll_group_agency" value="2nd Period">2nd Period</label>
										</div>
										<div class="radio">
											<label><input type="radio" name="payroll_group_agency" value="Last Period" checked>Last Period</label>
										</div>
										<div class="radio">
											<label><input type="radio" name="payroll_group_agency" value="Every Period" checked>Every Period</label>
										</div>
										<div class="radio">
											<label><input type="radio" name="payroll_group_agency" value="Not Deducted">Not Deducted</label>
										</div>
										
									</div>
								</div>
								<div class="panel panel-default">
									<div class="panel-body form-horizontal">
										<div class="form-group">
											<div class="col-md-12">
												<small>Agency Fee</small>
												<input type="number" name="payroll_group_agency_fee" class="form-control text-right" step="any">
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
									<input type="number" name="payroll_overtime_regular[]" value="{{$rate->payroll_overtime_regular}}" class="width-100 border-none text-right" step="any" {{$rate->payroll_overtime_name == 'Regular' ? 'readonly':''}}>
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
								<div class="col-md-6">
									<small>Working Days(per month)</small>
									<input type="number" name="payroll_group_working_day_month" class="form-control text-center" step="any" required>
								</div>
								<div class="col-md-6">
									<small>Grace Time Period</small>
									<input type="number" name="payroll_group_grace_time" class="form-control text-center" step="any" required>
								</div>
							</div>
							<div class="form-group">
								<div class="col-md-12">
									<table class="table table-condensed table-bordered timesheet">
										<thead>
											<tr>
												<th rowspan="2" valign="center" class="text-center">Day</th>
												<th rowspan="2" valign="center" class="text-center">Target Hours</th>
												<th colspan="2" class="text-center">Work Schedule</th>
												<th colspan="2" class="text-center">Break Schedule</th>
												<th rowspan="2" class="text-center">Flexi Time</th>
												<th rowspan="2" class="text-center">Rest Day</th>
												<th rowspan="2" class="text-center">Extra Day</th>
											</tr>
											<tr>
												<th class="text-center">Start</th>
												<th class="text-center">End</th>
												<th class="text-center">Start</th>
												<th class="text-center">End</th>
											</tr>
										</thead>
										<tbody>
											@foreach($_day as $key => $day)
											<tr class="editable">
												<td>
													{{$day['day']}}
													<input type="hidden" name="day[]" value="{{$day['day']}}">
												</td>
												<td>
													<input type="number" name="target_hours[]" class="form-control text-center" step="any" >
												</td>
												<td class="editable">
													<input type="text" name="work_start[]" class="text-table time-entry" >
												</td>
												<td class="editable">
													<input type="text" name="work_end[]" class="text-table time-entry" >
												</td>
												<td class="editable">
													<input type="text" name="break_start[]" class="text-table time-entry" >
												</td>
												<td class="editable">
													<input type="text" name="break_end[]" class="text-table time-entry" >
												</td>
												<td class="text-center">
													<input type="checkbox" name="flexi_{{$key}}" value="1">
												</td>
												<td class="text-center">
													<input type="checkbox" name="rest_day_{{$key}}" class="restday-check" value="1">
												</td>
												<td class="text-center">
													<input type="checkbox" name="extra_day_{{$key}}" class="extraday-check" value="1">
												</td>
											</tr>
											@endforeach
										</tbody>
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
		<button class="btn btn-primary btn-custom-primary" type="Submit">Save</button>
	</div>
</form>

<!-- <script type="text/javascript" src="/assets/member/payroll/js/timesheet.js"></script> -->
<script type="text/javascript" src="/assets/external/jquery.timeentry.package-2.0.1/jquery.plugin.min.js"></script>
<script type="text/javascript" src="/assets/external/jquery.timeentry.package-2.0.1/jquery.timeentry.min.js"></script>

<script type="text/javascript">
	$(".restday-check").unbind("change");
	$(".restday-check").bind("change", function () {
		var parent = $(this).parents('tr').find('.extraday-check');
		if($(this).is(":checked"))
		{
			parent.prop("checked", false);
		}

	});
	$(".extraday-check").unbind("change");
	$(".extraday-check").bind("change", function () {
		var parent = $(this).parents('tr').find('.restday-check');
		if($(this).is(":checked"))
		{
			parent.prop("checked", false);
		}

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
	$(".time-entry").timeEntry('destroy');
	$(".time-entry").timeEntry({ampmPrefix: ' ', defaultTime: new Date(0, 0, 0, 0, 0, 0)});
	late_categoy_change_event();
	late_param_change();
	under_time_category_change_event();
	function late_categoy_change_event()
	{
		$(".late-category-change").unbind("change");
		$(".late-category-change").bind("change", function()
		{
			if($(this).val() == "Custom")
			{
				if($(".late-custom-form").hasClass('display-none'))
				{
					$(".late-custom-form").removeClass("display-none");
				}
			}
			else
			{
				if(!$(".late-custom-form").hasClass('display-none'))
				{
					$(".late-custom-form").addClass("display-none");
				}
			}
		});

		$(".payroll_group_is_flexi_break").unbind("change");
		$(".payroll_group_is_flexi_break").bind("change", function(){

			if($(this).is(":checked"))
			{
				$(".tbl-schedule-break").addClass("display-none");
				$(".flexi-break-container").removeClass("display-none");
			}
			else
			{
				$(".tbl-schedule-break").removeClass("display-none");
				$(".flexi-break-container").addClass("display-none");
			}
		});

		$(".late-param-change").unbind("change");
		$(".late-param-change").bind("change", function()
		{
			late_param_change();
		});

	}


	function under_time_category_change_event()
	{
		$(".under-time-category-change").unbind("change");
		$(".under-time-category-change").bind("change", function()
		{
			if($(this).val() == "Custom")
			{
				if($(".under-time-custom-form").hasClass('display-none'))
				{
					$(".under-time-custom-form").removeClass("display-none");
				}
			}
			else
			{
				if(!$(".under-time-custom-form").hasClass('display-none'))
				{
					$(".under-time-custom-form").addClass("display-none");
				}
			}
		});
	}

	function late_param_change()
	{
		var number = $('.late-param-number').val();
		var select = $('.late-param-select').val();
		if(number == null || number == '')
		{
			number = 0
		}
		$('.late-label-param').html(number + ' ' + select);
	}
</script>