var timesheet = new timesheet();

function timesheet()
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
		event_focus_edit();
		event_time_entry();
	}
	function event_time_entry()
	{
		$(".time-entry").timeEntry();
	}
	function event_focus_edit()
	{
		$(".text-table").focusin(function(e)
		{
			$(e.currentTarget).closest("tr").addClass("focus");
		});
		$(".text-table").focusout(function(e)
		{
			$(e.currentTarget).closest("tr").removeClass("focus");
		});

		$(".edit-data").click(function(e)
		{
			$(e.currentTarget).closest("tr").find(".time-in").focus();
		});
	}
}