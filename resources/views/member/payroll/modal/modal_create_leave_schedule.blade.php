<form class="global-submit " role="form" action="/member/payroll/leave_schedule/save_schedule_leave_tag" method="post">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal">×</button>
		<h4 class="modal-title">Leave Schedule</h4>
		<input type="hidden" name="_token" value="{{csrf_token()}}">
	</div>
	<div class="modal-body form-horizontal">
		<div class="form-group">
			<div class="col-md-6">
				<small>Schedule date</small>
				<input type="text" name="payroll_schedule_leave" class="date_picker form-control" required>
			</div>
			<div class="col-md-6">
				<small>Leave Name</small>
				<select class="form-control select-leave" required>
					<option value="">Select leave</option>
					@foreach($_leave as $leave)
					<option value="{{$leave->payroll_leave_temp_id}}">{{$leave->payroll_leave_temp_name}}</option>
					@endforeach
				</select>
			</div>
		</div>
		<div class="form-group">
			<div class="col-md-12">
				<button class="btn btn-custom-primary pull-right popup employee-tag" type="button" link="/member/payroll/leave_schedule/leave_schedule_tag_employee/0">Tag Employee</button>
			</div>
		</div>
		<div class="form-group">
			<div class="col-md-12">
				<table class="table table-condensed">
					<thead>
						<tr>
							<th>Employee name</th>
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
<script type="text/javascript">
	$(".date_picker").datepicker();
	$(".select-leave").unbind("change");
	$(".select-leave").bind("change", function()
	{
		console.log($(this).val());
		var link = "/member/payroll/leave_schedule/leave_schedule_tag_employee/" + $(this).val();
		 $(".employee-tag").attr('link',link);
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