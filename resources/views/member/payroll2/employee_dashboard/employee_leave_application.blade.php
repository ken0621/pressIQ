<link rel="stylesheet" type="text/css" href="/assets/member/payroll/css/timesheet.css">
<link rel="stylesheet" type="text/css" href="/assets/external/jquery.timeentry.package-2.0.1/jquery.timeentry.css">

<!-- Change action, name, some links and functions-->
<form class="global-submit" role="form" action="/leave/save_leave" method="POST">
<ol class="breadcrumb">
    <li class="breadcrumb-item">
      <a href="/employee">Dashboard</a>
    </li>
    <li class="breadcrumb-item active">{{ $page }}</li>
</ol>
	<div class="modal-body form-horizontal">
{{-- 		<div class="row">
		    <div class="col-md-6">
				<small>Type of Leave</small>
				<select class="form-control" required>
					<option value="">Select Employee</option>
				</select>
		  	</div>
		  	<div class="col-md-6">
		  		<small>Date</small>
		      	<select class="form-control" required>
					<option value="">Select Department</option>
				</select>
			</div>
		</div>
		<div class="row">
			<div class="col-md-6">
				<small>Date</small>
				<input class="form-control" type="date" class="form-control" required>
			</div>
			<div class="col-md-3">
				<small>Time in</small>
				<input class="form-control" type="time" class="form-control">
			</div>
			<div class="col-md-3">
				<small>Time out</small>
				<input class="form-control" type="time" class="form-control">
			</div>
		</div>
		<div class="row">
            <div class="col-sm-12">
            <small>Remarks</small>
            	<textarea class="form-control" name="other_info" rows="4" required></textarea>
            </div>
        </div> --}}
        <div class="row">
 			    <div class="col-md-6">
 			    	<small>Type of Leave</small>
					<select class="form-control user-error" id="payroll_leave_type_id" name="payroll_leave_name" aria-invalid="true">
						<option value="">Select Leave Type</option>
						<option value="Sick Leave">Sick Leave</option>
						<option value="Vacation Leave">Vacation Leave</option>
						<option value="Maternity Leave">Maternity Leave</option>
						<option value="Paternity Leave">Paternity Leave</option>
						<option value="Parental Leave">Parental Leave</option>
					</select>
					<label>Status of Leave</label>
		  		</div>

		  		<div class="col-md-6">
			  		<small>Date Filed</small>
			      	<input class="form-control" type="date" class="form-control" name="date_filed">
				</div>
        </div>

        <div class="row">
 			    <div class="col-md-3">
					<small>Available Leave</small>
				   	<input class="form-control" type="text" class="form-control" style="width: 50px;" disabled>
		  		</div>

		  		 <div class="col-md-3">
					<small>Unused Leave</small>
				   	<input class="form-control" type="text" class="form-control" style="width: 50px;" disabled>
		  		</div>

		  		 <div class="col-md-6">
					<small>Reliever</small>
					<select class="form-control">
						<option value="">Select Employee</option>
					</select>
		  		</div>
        </div>

         <div class="row">
 			    <div class="col-md-3">
					<small>Used Leave</small>
				   	<input class="form-control" type="text" class="form-control" style="width: 50px;" disabled>
		  		</div>

		  		 <div class="col-md-3">
					<small>Hours</small>
				   	<input class="form-control" type="text" name="leave_hours" class="form-control" style="width: 50px;">
		  		</div>

		  		 <div class="col-md-6">
					<small>Approver</small>
					<select class="form-control">
						<option value="">Select Employee</option>
					</select>
		  		</div>
        </div>

        <div class="row">
		  		<div class="col-md-6">
			  		<small>Schedule Date Start</small>
			      	<input class="form-control" type="date" class="form-control">
				</div>

		  		<div class="col-md-6">
			  		<small>Schedule Date End</small>
			      	<input class="form-control" type="date" class="form-control">
				</div>
        </div>

	</div>
	<div class="modal-footer">
		<button type="button"  class="btn btn-primary btn-md" data-dismiss="modal">Cancel</button>
		<button type="submit"  class="btn btn-primary btn-md">Submit</button>
	</div>
</form>
<script type="text/javascript" src="/assets/external/jquery.timeentry.package-2.0.1/jquery.plugin.min.js"></script>
<script type="text/javascript" src="/assets/external/jquery.timeentry.package-2.0.1/jquery.timeentry.min.js"></script>
