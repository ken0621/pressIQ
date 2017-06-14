var timesheet = new timesheet();
var timesheet_request = null;
var adjust_form_request = null;
var new_sub_ctr = 1000;

function timesheet()
{
	init();

	this.external_event_time_entry = function()
	{
		event_time_entry();
	}

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
		action_sum_total_gross_salary();
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

	/* ACTIONS */
	function action_sum_total_gross_salary()
	{
		var total_gross_salary = 0;

		$(".daily-salary").each(function(key, val)
		{
			total_gross_salary += parseFloat($(this).attr("amount"));
		});

		$(".total-gross-salary").html(j_number_format(total_gross_salary));
	}

	function j_number_format(number)
	{
	    number = number.toFixed(2) + '';
	    x = number.split('.');
	    x1 = x[0];
	    x2 = x.length > 1 ? '.' + x[1] : '';
	    var rgx = /(\d+)(\d{3})/;
	    while (rgx.test(x1)) {
	        x1 = x1.replace(rgx, '$1' + ',' + '$2');
	    }
	    return x1 + x2;
	}
}	