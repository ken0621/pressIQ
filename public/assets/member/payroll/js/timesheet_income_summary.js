var timesheet_income_summary = new timesheet_income_summary();

function timesheet_income_summary()
{
	init();
	function init()
	{
		$(document).ready(function()
		{
			document_ready();
		})
	}
	function document_ready()
	{
		action_click_approve_timesheet();
	}
	function action_click_approve_timesheet()
	{
		$(".approve-timesheet-btn").unbind("click");
		$(".approve-timesheet-btn").bind("click", function()
		{
			$(".approve-timesheet-btn").html('<i class="fa fa-spinner fa-pulse fa-fw"></i>');

			var period_id = $(".employee-income-summary .period-id").val();
			var employee_id = $(".employee-income-summary .x-employee-id").val();
			
			$.ajax({
				url : "/member/payroll/company_timesheet_approve/approve_timesheet",
				type : "get",
				dataType:"json",
				data : {period_id : period_id, employee_id : employee_id},
				success : function(data)
				{
					$("#global_modal").modal("hide");
					timesheet_employee_list.action_load_table();
				}
			})
		});
	}
}