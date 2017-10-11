@extends('member.payroll2.employee_dashboard.employee_layout')
@section('content')
<div class="page-title">
    <h3>{{ $page }}</h3>
    <div class="page-breadcrumb">
        <ol class="breadcrumb">
            <li><a href="/">Home</a></li>
            <li class="active">{{ $page }}</li>
        </ol>
    </div>
</div>
	<div class="modal-body form-horizontal">
		<div class="form-group">
			<div class="col-md-12">
				<div class="checkbox">
					<label><input type="checkbox" class="single_date_only" name="single_date_only" value="1" checked>Single date only</label>
				</div>
			</div>
		</div>
		<div class="form-group">
			<div class="col-md-6">
				<small>Schedule date Start</small>
				<input type="text" name="payroll_schedule_leave" class="date_picker form-control" required>
			</div>
			<div class="col-md-6">
				<small>Schedule date End</small>
				<input type="text" name="payroll_schedule_leave_end" class="date_picker form-control payroll_schedule_leave_end" disabled>
			</div>
		</div>
		<div class="form-group">
			<div class="col-md-6">
				<small>Leave Name</small>
				<select class="form-control select-leave" name="leave_reason" required>
					<option value="">Select leave</option>


				</select>
			</div>
			<div class="col-md-6">
				<small>&nbsp;</small>
				<button class="btn btn-custom-primary btn-block popup employee-tag" type="button" link="/member/payroll/leave_schedule/leave_schedule_tag_employee/0">Tag Employee</button>
			</div>
		</div>
		<div class="form-group">
			<div class="col-md-12">
				<table class="table table-condensed table-bordered">
					<thead>
						<tr>
							<th class="text-center">Employee name</th>
							<!-- <th class="text-center">Whole day</th> -->
							<th class="text-center">Hours</th>
							<th></th>
						</tr>
					</thead>
					<tbody class="table-employee-tag"></tbody>
				</table>
			</div>
		</div>
	</div>
	<div class="modal-footer">
		<button type="button" class="btn btn-def-white btn-custom-white" data-dismiss="modal">Close</button>
		<button class="btn btn-primary btn-custom-primary" type="submit"">Submit</button>
	</div>
</form>
@endsection
<script type="text/javascript" src="/assets/external/jquery.timeentry.package-2.0.1/jquery.plugin.min.js"></script>
<script type="text/javascript" src="/assets/external/jquery.timeentry.package-2.0.1/jquery.timeentry.min.js"></script>

<script type="text/javascript">
	$(".date_picker").datepicker();
	$(".select-leave").unbind("change");
	$(".select-leave").bind("change", function()
	{
		var link = "/member/payroll/leave_schedule/leave_schedule_tag_employee/" + $(this).val();
		 $(".employee-tag").attr('link',link);
	});

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

	/* CALL A FUNCTION BY NAME */
	function executeFunctionByName(functionName, context /*, args */) {
	  var args = [].slice.call(arguments).splice(2);
	  var namespaces = functionName.split(".");
	  var func = namespaces.pop();
	  for(var i = 0; i < namespaces.length; i++) {
	    context = context[namespaces[i]];
	  }
	  return context[func].apply(context, args);
	}
</script>