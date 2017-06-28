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
		event_create_new_time();
		event_time_focus_out_recompute();
		action_sum_total_gross_salary();
	}

	/* EVENTS */
	function event_create_new_time()
	{
		$(".table-timesheet").on("keypress",".new-time-event", function(e)
		{
			if(e.which == 13)
			{
				action_create_new_line($(e.currentTarget).closest(".tr-parent"));
			}
		});
	}
	function event_time_entry()
	{
		$(".time-entry").timeEntry('destroy');
		$(".time-entry-24").timeEntry('destroy');
		$(".time-entry.time-in").timeEntry({ampmPrefix: ' ', defaultTime: new Date(0, 0, 0, 0, 0, 0)});
		$(".time-entry.time-out").timeEntry({ampmPrefix: ' ', defaultTime: new Date(0, 0, 0, 12, 0, 0)});
		$(".time-entry-24").timeEntry({show24Hours: true, defaultTime: new Date(0, 0, 0, 0, 0, 0)});
	}
	function event_time_focus_out_recompute()
	{
		/* STORE INITITAL VALUE */
		$(".time-entry").focusin(function(e)
		{
			$focus_value = $(e.currentTarget).val();
			$(e.currentTarget).attr("focus_value", $focus_value);
		});

		/* CHECK IF INITIAL VALUE CHANGED AFTER FOCUS OUT */
		$(".time-entry").focusout(function(e)
		{
			$focus_value = $(e.currentTarget).attr("focus_value");
			if($focus_value != $(e.currentTarget).val())
			{
				console.log("TIME CHANGED - NEED TO RECOMPUTE");
			}
		});
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

	function action_create_new_line($target_tr)
	{
		$time_in_blank = false;
		$time_out_blank = false;

		/* CHECK IF ONE OF TIME-IN IS BLANK */
		$target_tr.find(".time-in").each(function(key)
		{
			if($(this).val() == "")
			{
				$time_in_blank = true;
			}
		});

		/* CHECK IF ONE OF TIME-OUT IS BLANK */
		$target_tr.find(".time-out").each(function(key)
		{
			if($(this).val() == "")
			{
				$time_out_blank = true;
			}
		});

		if($time_in_blank == false && $time_out_blank == false)
		{
			$target_tr.find(".time-in-td").append('<input value="" type="text" placeholder="NO TIME" class="new-time-event new-time-focus text-table text-center time-entry time-in is-timeEntry" name="">');
			$target_tr.find(".time-out-td").append('<input value="" type="text" placeholder="NO TIME" class="new-time-event text-table text-center time-entry time-in is-timeEntry" name="">');
			$target_tr.find(".time-comment-td").append('<input value="" type="text" class="new-time-event text-table time-entry is-timeEntry" name="">');
			$target_tr.find(".new-time-focus").focus().removeClass("new-time-focus");
			event_time_entry();
		}
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