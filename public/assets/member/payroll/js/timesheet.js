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
	function action_deduct_two_time($from, $to)
	{
		var difference = Math.abs(toSeconds($from) - toSeconds($to));
		var result = [
		    // an hour has 3600 seconds so we have to compute how often 3600 fits
		    // into the total number of seconds
		    Math.floor(difference / 3600), // HOURS
		    // similar for minutes, but we have to "remove" the hours first;
		    // this is easy with the modulus operator
		    Math.floor((difference % 3600) / 60), // MINUTES
		    // the remainder is the number of seconds
		    difference % 60 // SECONDS
		];

		result = result.map(function(v) {
		    return v < 10 ? '0' + v : v;
		}).join(':');
	}
	function action_convert_time_str_to_seconds(time_str)
	{
	    // Extract hours, minutes and seconds
	    var parts = time_str.split(':');
	    // compute  and return total seconds
	    return parts[0] * 3600 + // an hour has 3600 seconds
	           parts[1] * 60 +   // a minute has 60 seconds
	           +parts[2];        // seconds
	}
}	