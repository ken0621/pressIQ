var timesheet_day_summary = new timesheet_day_summary();

function timesheet_day_summary()
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
		event_time_entry();
		event_change_approve_check();
		action_check_each_approve_check();
	}
	

	

	/* EVENTS */
	function event_time_entry()
	{
		$(".time-entry").timeEntry('destroy');
		$(".time-entry-24").timeEntry('destroy');
		$(".time-entry.time-in").timeEntry({ampmPrefix: ' ', defaultTime: new Date(0, 0, 0, 0, 0, 0)});
		$(".time-entry.time-out").timeEntry({ampmPrefix: ' ', defaultTime: new Date(0, 0, 0, 12, 0, 0)});
		$(".time-entry-24").timeEntry({show24Hours: true, defaultTime: new Date(0, 0, 0, 0, 0, 0)});
	}
	
	function event_change_approve_check()
	{
		$(".approve-checkbox").change(function(e)
		{
			$target = $(e.currentTarget);
			action_show_hide_overtime_depending_if_checked($target);
			action_re_compute_on_change();
		});
	}
	
	/* ACTIONS */
	
	function action_check_each_approve_check()
	{
		$(".approve-checkbox").each(function()
		{
			action_show_hide_overtime_depending_if_checked($(this));
		});
	}
	function action_show_hide_overtime_depending_if_checked($target)
	{
		if($target.is(":checked"))
		{
			$target.closest("tr").find(".overtime-checkbox").show();
		}
		else
		{
			$target.closest("tr").find(".overtime-checkbox").hide();
		}
	}
	function action_re_compute_on_change()
	{
		$input = $(".day-summary-table :input").serialize();
		$url = "/member/payroll/company_timesheet_day_summary/change"
		$payroll_time_sheet_id = $(".payroll-time-sheet-id").val();
		$(".load-detail-table").css("opacity", 0.3);

		$.ajax(
		{
			url: $url,
			dataType: "json",
			data: $input,
			type:"post",
			success: function(data)
			{
				$(".load-detail-table").load("/member/payroll/company_timesheet_day_summary/info/" + $payroll_time_sheet_id, function()
				{
					$(".load-detail-table").css("opacity", 1);
				});
			}
		});
	}
}	