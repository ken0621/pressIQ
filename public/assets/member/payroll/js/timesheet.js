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
		event_create_sub_time();
		event_delete_sub_time();
		action_compute_work_hours();
	}
	function event_create_sub_time()
	{
		$("body").on("click", ".create-sub-time", function(e)
		{
			$date = $(e.currentTarget).closest("tr").attr("date");
			action_create_sub_time($date);
			action_compute_work_hours();
		});
	}
	function event_delete_sub_time()
	{
		$("body").on("click", ".delete-sub-time", function(e)
		{
			if(confirm("Are you sure you want to delete this time-entry?"))
			{
				$date = $(e.currentTarget).closest("tr").remove();
			}
		});
	}
	function event_change_time_in_out()
	{
		$("body").on("keyup", ".time-in", function(e)
		{
			/* EMPTY BOTH IF ONE IS EMPTY */
			if($(e.currentTarget).val() == "")
			{
				$(e.currentTarget).closest("tr").find(".time-out").val("");
				$(e.currentTarget).closest("tr").find(".break-time").val("00:00");
			}

			action_compute_work_hours();
		});

		$("body").on("keyup", ".time-out", function(e)
		{
			/* EMPTY BOTH IF ONE IS EMPTY */
			if($(e.currentTarget).val() == "")
			{
				$(e.currentTarget).closest("tr").find(".time-in").val("");
				$(e.currentTarget).closest("tr").find(".break-time").val("00:00");
			}

			action_compute_work_hours();
		});

		$("body").on("keyup", ".break-time", function(e)
		{
			action_compute_work_hours();
		});
	}
	function event_focus_edit()
	{
		$("body").on("focusin", ".text-table", function(e)
		{
			$(e.currentTarget).closest("tr").addClass("focus");
		});
		$("body").on("focusout", ".text-table", function(e)
		{
			$(e.currentTarget).closest("tr").removeClass("focus");
		});
		$("body").on("focusout", ".edit-data", function(e)
		{
			$(e.currentTarget).closest("tr").find(".time-in").focus();
		});

	}
	function event_time_entry()
	{
		$(".time-entry").timeEntry('destroy');
		$(".time-entry-24").timeEntry('destroy');
		$(".time-entry").timeEntry();
		$(".time-entry-24").timeEntry({show24Hours: true});
	}
	function action_create_sub_time(date)
	{
		$append = $(".sub-time-container").html();
		$(".time-record[date='" + date + "']:last").after($append);
		
		$last_time_out = $(".time-record[date='" + date + "']:last").find(".time-out").val();
		$time_in = $last_time_out;
		$time_out = add_two_time(convert_to_24h($last_time_out), "01:00");

		/* UPDATE DATA FOR NEW SUB */
		$("tbody").find(".time-record.new-sub").attr("date", date);
		$("tbody").find(".time-record.new-sub").find(".time-in").val($time_in);
		$("tbody").find(".time-record.new-sub").find(".time-out").val($time_out);

		/* ADD EVENT TO NEW SUB */
		event_time_entry();

		/* REMOVE NEW SUB REFERENCE */
		$("tbody").find(".time-record.new-sub").removeClass("new-sub");
	}
	function action_compute_work_hours()
	{
		/* COMPUTE TOTAL HOURS PER LINE */
		$(".time-record").each(function(key, val)
		{		
			var time_in = convert_to_24h($(this).find(".time-in").val());
			var time_out = convert_to_24h($(this).find(".time-out").val());

			/* IF BLANK TIME-IN */
			if(time_in == "" || time_out == "")
			{
				var total_hours = "00:00";
			}
			else
			{
				var total_hours = deduct_two_time(time_in, time_out);
			}

			
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

		if(end_actual_time < start_actual_time)
		{
			end_actual_time = start_actual_time;
		}

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
		if(time_str == "")
		{
			time_str = "12:00AM";
		}
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