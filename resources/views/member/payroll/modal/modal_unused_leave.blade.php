<form class="global-submit " role="form" action="{link_submit_here}" method="post">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal">×</button>
		<h4 class="modal-title">Process unused leave</h4>
	</div>
	<div class="modal-body form-horizontal">
		<table class="table table-bordered table-condensed">
			<thead>
				<tr>
					<th></th>
					<th>Leave Name</th>
					<th>Capping</th>
					<th>Remaining</th>
					<th>Avail leave</th>
				</tr>
			</thead>
			<tbody>
				@foreach($payable_leave as $leave)
				<tr>
					<td class="text-center" valign="center">
						<input type="checkbox" name="" value="{{$leave['payroll_leave_employee_id']}}" class="check-avail-leave">
					</td>
					<td>
						{{$leave['payroll_leave_temp_name']}}
					</td>
					<td class="text-right">
						{{$leave['payroll_leave_temp_days_cap']}}
					</td>
					<td class="text-right">
						{{$leave['remaining']}}
					</td>
					<td>
						<input type="number" name="" class="form-control text-right number-avail" max="{{$leave['remaining']}}" min="0" placeholder="0" step="1">
					</td>
				</tr>
				@endforeach
			</tbody>
		</table>
	</div>
	<div class="modal-footer">
		<button type="button" class="btn btn-def-white btn-custom-white" data-dismiss="modal">Close</button>
		<button class="btn btn-primary btn-custom-primary" type="button"">Submit</button>
	</div>
</form>
<script type="text/javascript">

	checkifcheck();
	function checkifcheck()
	{
		$(".check-avail-leave").each(function()
		{
			var avail_input = $(this).parents("tr").find(".number-avail");
			if($(this).is(":checked"))
			{
				avail_input.removeAttr("readonly");
			}
			else
			{
				avail_input.attr("readonly", true);
			}
		});
	}

	$(".check-avail-leave").unbind("change");
	$(".check-avail-leave").bind("change", function()
	{
		checkifcheck();
	});
</script>