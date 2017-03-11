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
		event_change_time_in_out();
		action_compute_work_hours();
	}
	function event_change_time_in_out()
	{
		$("body").on("keyup", ".time-in", function()
		{
			action_compute_work_hours();
		});

		$("body").on("keyup", ".time-out", function()
		{
			action_compute_work_hours();
		});

		$("body").on("keyup", ".break-time", function()
		{
			action_compute_work_hours();
		});
	}
	function event_time_entry()
	{
		$(".time-entry").timeEntry();
		$(".time-entry-24").timeEntry({show24Hours: true});
	}
	function action_compute_work_hours()
	{
		/* COMPUTE TOTAL HOURS PER LINE */
		$(".time-record").each(function(key, val)
		{
			
			var time_in = convert_to_24h($(this).find(".time-in").val());
			var time_out = convert_to_24h($(this).find(".time-out").val());
			var total_hours = deduct_two_time(time_in, time_out);
			$(this).attr("total_hours", total_hours);
			$(this).find(".normal-hours").text(total_hours);
		});

		/* COMPUTE TOTAL HOURS PER DATE */
		$(".time-record.main").each(function(key, val)
		{
			count_entry_per_date = $(".time-record[date='" + $(this).attr("date") + "']").length;
			
			if(count_entry_per_date > 1)
			{
				var total_time_multiple_line = "00:00";

				$(".time-record[date='" + $(this).attr("date") + "']").each(function(key, val)
				{
					total_time_multiple_line = add_two_time(total_time_multiple_line, $(this).attr("total_hours"));
					$(this).attr("total_hours", "00:00");
				});

				$(".time-record.main[date='" + $(this).attr("date") + "']").attr("total_hours", total_time_multiple_line);
			}
		});

		/* COMPUTE PER DATE*/
		$(".time-record.main").each(function(key, val)
		{
			total_hours = $(this).attr("total_hours");
			total_break = $(this).find(".break-time").val();
			total_hours_less_break = deduct_two_time(total_break, total_hours);

			if(check_greater(total_hours_less_break, '08:00'))
			{
				total_normal_hours = "08:00";
				total_overtime_hours = deduct_two_time('08:00', total_hours_less_break);
			}
			else
			{
				total_normal_hours = total_hours_less_break;
				total_overtime_hours = "00:00";
			}

 			$(this).find(".normal-hours").text(total_normal_hours);
 			$(this).find(".overtime-hours").text(total_overtime_hours);
 			if(check_greater(total_overtime_hours, '00:00'))
 			{
 				$(this).find(".overtime-hours").addClass("red");
 			}
 			else
 			{
 				$(this).find(".overtime-hours").removeClass("red");
 			}
 			
		});
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

	function action_convert_time_str_to_seconds(time_str)
	{
	    // Extract hours, minutes and seconds
	    var parts = time_str.split(':');
	    // compute  and return total seconds
	    return parts[0] * 3600 + // an hour has 3600 seconds
	           parts[1] * 60 +   // a minute has 60 seconds
	           +parts[2];        // seconds
	}


	/* HELPERS */
	function check_greater($value, $compare)
	{
		var start_actual_time  =  "01/01/2012 " + $value;
		var end_actual_time    =  "01/01/2012 " + $compare;

		start_actual_time = new Date(start_actual_time);
		end_actual_time = new Date(end_actual_time);

		var diff = end_actual_time - start_actual_time;

		if(start_actual_time > end_actual_time)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	function deduct_two_time($from, $to)
	{
		var start_actual_time  =  "01/01/2012 " + $from;
		var end_actual_time    =  "01/01/2012 " + $to;

		start_actual_time = new Date(start_actual_time);
		end_actual_time = new Date(end_actual_time);

		var diff = end_actual_time - start_actual_time;

		var diffSeconds = diff/1000;
		var HH = Math.floor(diffSeconds/3600);
		var MM = Math.floor(diffSeconds%3600)/60;

		var formatted = ((HH < 10)?("0" + HH):HH) + ":" + ((MM < 10)?("0" + MM):MM)
		return formatted;
	}
	function add_two_time(start, end)
	{
	  times = [];
	  times1 = start.split(':');
	  times2 = end.split(':');

	  for (var i = 0; i < 3; i++) {
	    times1[i] = (isNaN(parseInt(times1[i]))) ? 0 : parseInt(times1[i])
	    times2[i] = (isNaN(parseInt(times2[i]))) ? 0 : parseInt(times2[i])
	    times[i] = times1[i] + times2[i];
	  }

	  var MM = times[1];
	  var HH = times[0];


	  if (MM % 60 === 0) {
	    res = MM / 60;
	    HH += res;
	    MM = MM - (60 * res);
	  }
		var formatted = ((HH < 10)?("0" + HH):HH) + ":" + ((MM < 10)?("0" + MM):MM)
	  return formatted;
	}
	function convert_to_24h(time_str)
	{
	    // Convert a string like 10:05:23 PM to 24h format, returns like [22,5,23]
	    var time = time_str.match(/(\d+):(\d+)(\w)/);
	    var hours = Number(time[1]);
	    var minutes = Number(time[2]);
	    var meridian = time[3].toLowerCase();

	    if (meridian == 'p' && hours < 12) {
	      hours = hours + 12;
	    }
	    else if (meridian == 'a' && hours == 12) {
	      hours = hours - 12;
	    }

	    return hours + ":" + minutes + ":00";
	 }



}	