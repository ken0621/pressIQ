<link rel="stylesheet" type="text/css" href="/assets/member/payroll/css/timesheet.css">

<form class="global-submit" role="form" action="/leave/save_leave" method="POST">
<ol class="breadcrumb">
    <li class="breadcrumb-item">
      <a href="/employee">Dashboard </a>
    </li>
    <input type="hidden" name="_token" value="{{csrf_token()}}">
   <li class="breadcrumb-item active">&nbsp/&nbsp{{ $page }}</li>
</ol>
	<div class="modal-body form-horizontal">

        <div class="row">
 			    <div class="col-md-6">
 			    	<small>Type of Leave</small>
					<select class="form-control user-error" name="leave_type" aria-invalid="true" required>
						<option value="">Select Leave Type</option>
						<option value="SL">Sick Leave</option>
						<option value="VL">Vacation Leave</option>
						<option value="ML">Maternity Leave</option>
						<option value="PL">Paternity Leave</option>
					</select>
					<label>Status of Leave</label>
		  		</div>

		  		<div class="col-md-6">
			  		<small>Date Filed</small>
			      	<input class="form-control" type="date" class="form-control" name="date_filed" required>
				</div>
        </div>

        <div class="row">
 			    <div class="col-md-3">
					<small>Available Leave</small>
				   	<input class="form-control" type="text" class="form-control" style="width: 80px;" disabled>
		  		</div>

		  		 <div class="col-md-3">
					<small>Unused Leave</small>
				   	<input class="form-control" type="text" class="form-control" style="width: 80px;" disabled>
		  		</div>

		  		 <div class="col-md-6">
					<small>Reliever</small>
					<select class="form-control" name="payroll_employee_id_reliever" required>
						<option value="">Select Employee</option>
						@foreach($employees_info as $employee)
							<option value="{{$employee->payroll_employee_id}}">{{$employee->payroll_employee_first_name}} {{$employee->payroll_employee_middle_name}} {{$employee->payroll_employee_last_name}}</option> 
						@endforeach

					</select>
		  		</div>
        </div>

         <div class="row">
 			    <div class="col-md-3">
					<small>Used Leave</small>
				   	<input class="form-control" type="text" class="form-control" style="width: 80px;" disabled>
		  		</div>

		  		 <div class="col-md-3">
					<small>Hours</small>
				   	<input class="text-center form-control break time-entry time-target time-entry-24 is-timeEntry" type="text" name="leave_hours" placeholder="00:00" style="width: 80px;">
		  		</div>

		  		 <div class="col-md-6">
					<small>Approver</small>
					<select class="form-control" name="payroll_employee_id_approver" required>
						<option value="">Select Employee</option>
							@foreach($employees_info as $employee)
								<option value="{{$employee->payroll_employee_id}}">{{$employee->payroll_employee_first_name}} {{$employee->payroll_employee_middle_name}} {{$employee->payroll_employee_last_name}}</option> 
							@endforeach
					</select>
		  		</div>
        </div>

        <div class="row">
        	<div class="col-md-6">
        		<br>	
				<div class="checkbox">
					<label><input type="checkbox" class="single_date_only" name="single_date_only" value="1" checked>Single date only</label>
				</div>
			</div>
        </div>
        <div class="row">
		  		<div class="col-md-6">
			  		<small>Schedule Date Start</small>
			      	<input class="form-control" type="date" class="form-control" name="payroll_schedule_leave" required>
				</div>

		  		<div class="col-md-6">
			  		<small>Schedule Date End</small>
			      	<input class="form-control payroll_schedule_leave_end" type="date" class="form-control" name="payroll_schedule_leave_end" disabled="">
				</div>
        </div>

	</div>
	<div class="modal-footer">
		<button type="button" class="btn btn-primary btn-md" data-dismiss="modal">Cancel</button>
		<button type="submit" class="btn btn-primary btn-md">Submit</button>
	</div>
</form>
<script>
		function reload(data)
		{
			data.element.modal("hide");
			location.reload();
		}
	
		$(".time-entry").timeEntry('destroy');
		$(".time-entry-24").timeEntry('destroy');
		$(".time-entry.time-in").timeEntry({ampmPrefix: ' ', defaultTime: new Date(0, 0, 0, 0, 0, 0)});
		$(".time-entry.time-out").timeEntry({ampmPrefix: ' ', defaultTime: new Date(0, 0, 0, 12, 0, 0)});
		$(".time-entry-24").timeEntry({unlimitedHours: true, defaultTime: new Date(0, 0, 0, 0, 0, 0)});

		$(".single_date_only").unbind("change");
		$(".single_date_only").bind("change",function()
		{
			if($(this).is(':checked'))
			{
				$(".payroll_schedule_leave_end").attr("disabled","true");
				$(".payroll_schedule_leave_end").removeAttr("required");
			}
			else
			{
				$(".payroll_schedule_leave_end").removeAttr("disabled");
				$(".payroll_schedule_leave_end").attr("required",true);
			}
		});
</script>
