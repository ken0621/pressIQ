<link rel="stylesheet" type="text/css" href="/assets/member/payroll/css/timesheet.css">
<link rel="stylesheet" type="text/css" href="/assets/external/jquery.timeentry.package-2.0.1/jquery.timeentry.css">
<form class="global-submit " role="form" action="/member/payroll/shift_template/modal_update_shift_template" method="post">
	<div class="modal-header">
		<h4 class="modal-title">Shift Schedule</h4>
		<button type="button" class="close" data-dismiss="modal">×</button>
		<input type="hidden" name="_token" value="{{csrf_token()}}">
	</div>
	<div class="modal-body form-horizontal">
		<div class="form-group">
			<div class="col-md-12">
				<table class="table table-condensed table-bordered timesheet">
					<thead>
						<tr>
							<th rowspan="2" valign="center" class="text-center">Day</th>
							<th rowspan="2" valign="center" class="text-center">Working Hours</th>
							<th colspan="2" class="text-center">Work Schedule</th>
							<th class="text-center"></th>
							<th rowspan="2" class="text-center">Flexi Time</th>
							<th rowspan="2" valign="center" class="text-center">Break Hours</th>
							<th rowspan="2" class="text-center">Rest Day</th>
							<th rowspan="2" class="text-center">Extra Day</th>
					
						</tr>
						<tr>
							<th class="text-center">Start</th>
							<th class="text-center">End</th>
							<th></th>
						</tr>
					</thead>
					<tbody>
						
							<tr class="editable main-con main-time">
							</tr>
							
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<div class="modal-footer">
	</div>
</form>
