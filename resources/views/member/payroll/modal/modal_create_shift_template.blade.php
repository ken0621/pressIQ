<link rel="stylesheet" type="text/css" href="/assets/member/payroll/css/timesheet.css">
<link rel="stylesheet" type="text/css" href="/assets/external/jquery.timeentry.package-2.0.1/jquery.timeentry.css">
<form class="global-submit " role="form" action="/member/payroll/shift_template/modal_save_shift_template" method="post">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal">×</button>
		<h4 class="modal-title">Create Shift Template</h4>
		<input type="hidden" name="_token" value="{{csrf_token()}}">
	</div>
	<div class="modal-body form-horizontal">
		<div class="form-group">
			<div class="col-md-12">
				<small>Shift Code</small>
				<input type="text" name="shift_code_name" class="form-control" placeholder="Shift Code" required>
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
	<div class="modal-footer">
		<button type="button" class="btn btn-def-white btn-custom-white" data-dismiss="modal">Close</button>
		<button class="btn btn-primary btn-custom-primary" type="submit"">Submit</button>
	</div>
</form>

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

	$(".time-entry").timeEntry('destroy');
	$(".time-entry").timeEntry({ampmPrefix: ' ', defaultTime: new Date(0, 0, 0, 0, 0, 0)});
</script>