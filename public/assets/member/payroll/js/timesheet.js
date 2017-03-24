var timesheet = new timesheet();
var timesheet_request = null;
var adjust_form_request = null;
var new_sub_ctr = 1000;

function loading_done(url)
{
	/* ADD TIME ENTRY */
	$(".over-time-entry").each(function(key, val)
	{
		$min = $(this).attr("time_min");
		$max = $(this).attr("time_max");
		$(this).timeEntry({ampmPrefix: ' ',minTime: $min, maxTime: $max});
		timesheet.external_compute_overtime_form();
		
	});
}


function timesheet()
{
	init();

	this.external_compute_overtime_form = function()
	{
		action_compute_overtime_form();
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
		action_load_timesheet();
		event_change_employee();
		event_focus_edit();
		event_change_time_in_out();
		event_create_sub_time();
		event_delete_sub_time();
		event_load_overtime_form();
		event_for_overtime_form();

	}
	function event_load_overtime_form()
	{
		$("body").on("click", ".load-overtime-form", function(e)
		{
			tid = $(e.currentTarget).closest("tr").attr("tid");
			action_load_link_to_modal("/member/payroll/employee_timesheet/adjustment_form?payroll_time_sheet_id=" + tid, "md");
		});
	}
	function event_for_overtime_form()
	{
		$("body").on("change", ".over-time-entry", function(e)
		{
			action_compute_overtime_form();
		});

		$("body").on("click", ".submit-overtime-form", function()
		{
			action_approve_overtime_form();
		});
	}
	function action_approve_overtime_form()
	{
		$(".adjust-form-icon").addClass("hidden");
		$(".adjust-form-loader").removeClass("hidden");

		date = $(".over-time-form").find(".field-hidden-date").val();
		employee_id = $(".over-time-form").find(".field-hidden-employee-id").val();
		token = $(".ot-token").val();

		$.ajax(
		{
			url:"/member/payroll/employee_timesheet/adjustment_form_approve",
			dataType:"json",
			data:{"date":date, "employee_id":employee_id,"_token":token},
			type:"post",
			success: function(data)
			{
				$(".adjust-form-icon").removeClass("hidden");
				$(".adjust-form-loader").addClass("hidden");
				$("#global_modal").modal("hide");
				action_compute_work_hours();
			}
		});
	}
	function action_compute_overtime_form()
	{
		date = $(".over-time-form").find(".field-hidden-date").val();
		employee_id = $(".over-time-form").find(".field-hidden-employee-id").val();

		if(adjust_form_request !== null)
		{
			adjust_form_request.abort();
		}

		$(".time-summary-adjustment.new").text("__:__").css({"color":"#000", "font-weight":"normal"});

		adjust_form_request = $.ajax(
		{
			url:"/member/payroll/employee_timesheet/json_process_time_single/" + date + "/" + employee_id,
			dataType:"json",
			data:  $(".over-time-form").serialize(),
			type:"post",
			success: function(data)
			{
				
				$(".old_regular_hours").text(data.pending_timesheet.regular_hours);
				$(".old_night_differential").text(data.pending_timesheet.night_differential);
				$(".old_early_overtime").text(data.pending_timesheet.early_overtime);
				$(".old_late_overtime").text(data.pending_timesheet.late_overtime);
				$(".old_extra_day").text(data.pending_timesheet.extra_day_hours);
				$(".old_rest_day").text(data.pending_timesheet.rest_day_hours);

				$(".new_regular_hours").text(data.approved_timesheet.regular_hours);
				$(".new_night_differential").text(data.approved_timesheet.night_differential);
				$(".new_early_overtime").text(data.approved_timesheet.early_overtime);
				$(".new_late_overtime").text(data.approved_timesheet.late_overtime);
				$(".new_extra_day").text(data.approved_timesheet.extra_day_hours);
				$(".new_rest_day").text(data.approved_timesheet.rest_day_hours);


				$(".time-summary-adjustment").each(function()
				{
					if($(this).text() == "00:00")
					{
						$(this).css(
						{
							"color":"#000",
							"font-weight":"normal"
						});
					}
					else
					{
						$(this).css(
						{
							"color":"red",
							"font-weight":"bold"
						});
					}
				});	

				$(".time-summary-adjustment.new").each(function()
				{
					s = $(this).attr("s");
					old = $(".time-summary-adjustment.old[s=" + s + "]");

					if($(this).text() != old.text())
					{
						$(this).css({"color":"green", "font-weight":"bold"});
					};
				});

			}
		});
	}
	function action_load_timesheet()
	{
		$(".load-timesheet").html("<div class='timesheet-table-loading'><div class='spin'><i class='table-loader fa fa-spinner fa-spin fa-fw'></i></div> <div>LOADING</div> </div>");

		var selected_employee = $(".choose-employee").val();
		$(".load-timesheet").load('/member/payroll/employee_timesheet/timesheet/' + selected_employee, function()
		{
			action_compute_work_hours();
			event_time_entry();
		});
	}
	function event_change_employee()
	{
		$("body").on("change", ".choose-employee", function(e)
		{
			action_load_timesheet();
		});
	}
	function event_create_sub_time()
	{
		$("body").on("click", ".create-sub-time", function(e)
		{
			$date = $(e.currentTarget).closest("tr").attr("date");
			action_create_sub_time($date);
		});
	}
	function event_delete_sub_time()
	{
		$("body").on("click", ".delete-sub-time", function(e)
		{
			if(confirm("Are you sure you want to delete this time-entry?"))
			{
				$date = $(e.currentTarget).closest("tr").attr("date");
				$(e.currentTarget).closest("tr").remove();
				action_recompute_loading($date);
				action_compute_work_hours();
			}
		});
	}
	function event_change_time_in_out()
	{
		$("body").on("change", ".time-in", function(e)
		{
			$(e.currentTarget).closest("tr").find(".ot-approved").val("00:00");

			/* EMPTY BOTH IF ONE IS EMPTY */
			if($(e.currentTarget).val() == "")
			{
				$(e.currentTarget).closest("tr").find(".time-out").val("");
			}

			$date = $(e.currentTarget).closest("tr").attr("date");
			action_recompute_loading($date);
			action_compute_work_hours();
		});

		$("body").on("change", ".time-out", function(e)
		{
			$(e.currentTarget).closest("tr").find(".ot-approved").val("00:00");

			/* EMPTY BOTH IF ONE IS EMPTY */
			if($(e.currentTarget).val() == "")
			{
				$(e.currentTarget).closest("tr").find(".time-in").val("");
			}

			$date = $(e.currentTarget).closest("tr").attr("date");
			action_recompute_loading($date);
			action_compute_work_hours();
		});

		$("body").on("change", ".break-time", function(e)
		{
			$date = $(e.currentTarget).closest("tr").attr("date");
			action_recompute_loading($date);
			action_compute_work_hours();
		});

		$("body").on("change", ".ot-approved", function(e)
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
		$(".time-entry.time-in").timeEntry({ampmPrefix: ' ', defaultTime: new Date(0, 0, 0, 0, 0, 0)});
		$(".time-entry.time-out").timeEntry({ampmPrefix: ' ', defaultTime: new Date(0, 0, 0, 12, 0, 0)});
		$(".time-entry-24").timeEntry({show24Hours: true, defaultTime: new Date(0, 0, 0, 0, 0, 0)});
	}
	function action_recompute_loading(date)
	{	
		$(".time-record.main[date='" + date + "']").find(".table-loader").removeClass("hidden");
		$(".time-record.main[date='" + date + "']").find(".table-check").addClass("hidden");
		$(".time-record.main[date='" + date + "']").find(".normal-hours").text("__:__");
		$(".time-record.main[date='" + date + "']").find(".overtime-hours").text("__:__");
		$(".time-record.main[date='" + date + "']").find(".extra-day-hours").text("__:__");
		$(".time-record.main[date='" + date + "']").find(".rest-day-hours").text("__:__");
		$(".time-record.main[date='" + date + "']").find(".total-hours").text("__:__");
		$(".time-record.main[date='" + date + "']").find(".late-hours").text("__:__");
		$(".time-record.main[date='" + date + "']").find(".night-differential").text("__:__");
		$(".time-record.main[date='" + date + "']").find(".overtime-hours").removeClass("red");
	}
	function action_create_sub_time(date, $time_in = "", $time_out = "")
	{
		$append = $(".sub-time-container").html();
		$(".time-record[date='" + date + "']:last").after($append);
		
		$last_time_out = $(".time-record[date='" + date + "']:last").find(".time-out").val();

		/* UPDATE DATA FOR NEW SUB */
		$("tbody").find(".time-record.new-sub").attr("date", date);
		$("tbody").find(".time-record.new-sub").find(".date").val(date);
		$("tbody").find(".time-record.new-sub").find(".time-in").val($time_in);
		$("tbody").find(".time-record.new-sub").find(".time-out").val($time_out);
		$arr_count = new_sub_ctr++;
		$("tbody").find(".time-record.new-sub").find(".date").attr("name", "date[" + date + "][" + $arr_count + "]");
		$("tbody").find(".time-record.new-sub").find(".time-in").attr("name", "time_in[" + date + "][" + $arr_count + "]");
		$("tbody").find(".time-record.new-sub").find(".time-out").attr("name", "time_out[" + date + "][" + $arr_count + "]");
		/* ADD EVENT TO NEW SUB */
		event_time_entry();

		/* REMOVE NEW SUB REFERENCE */
		$("tbody").find(".time-record.new-sub").removeClass("new-sub");
	}

	function action_compute_work_hours()
	{
		if(timesheet_request !== null)
		{
			timesheet_request.abort();
		}

		timesheet_request = $.ajax(
		{
			url:"/member/payroll/employee_timesheet/json_process_time",
			dataType:"json",
			data: $(".payroll-form").serialize(),
			type:"post",
			success: function(data)
			{
				$.each(data, function(key, val)
				{
					update_time_record_on_table(val);
				});

				$(".table-loader").addClass("hidden");
				$(".table-check").removeClass("hidden");
			},
			error: function()
			{
				console.log("Error");
			}
		});
	}

	function update_time_record_on_table(val)
	{
		$(".time-record[date='" + val.date + "']").attr("tid", val.payroll_time_sheet_id);

		$(".time-record[date='" + val.date + "']").find(".normal-hours").text(val.regular_hours);
		$(".time-record[date='" + val.date + "']").find(".overtime-hours.late").text(val.late_overtime);
		$(".time-record[date='" + val.date + "']").find(".overtime-hours.early").text(val.early_overtime);
		$(".time-record[date='" + val.date + "']").find(".extra-day-hours").text(val.extra_day_hours);
		$(".time-record[date='" + val.date + "']").find(".rest-day-hours").text(val.rest_day_hours);
		$(".time-record[date='" + val.date + "']").find(".total-hours").text(val.total_hours);
		$(".time-record[date='" + val.date + "']").find(".late-hours").text(val.late_hours);
		$(".time-record[date='" + val.date + "']").find(".night-differential").text(val.night_differential);

		$(".time-record[date='" + val.date + "']").each(function(key)
		{
			$(this).find(".time-entry.time-in").val(val.time_record[key].time_in);
			$(this).find(".time-entry.time-out").val(val.time_record[key].time_out);
		});

		if(val.payroll_time_sheet_approved == 1)
		{
			warncolor = "green"; 
		}
		else
		{
			warncolor = "red";
		}
		

		/* ND GRAY IF ZERO */
		if(val.night_differential != "00:00")
		{
			$(".time-record[date='" + val.date + "']").find(".night-differential").css("color", "black");
		}
		else
		{
			$(".time-record[date='" + val.date + "']").find(".night-differential").css("color", "#bbb");
		}

		/* LATE HOURS GRAY IF ZERO */
		if(val.late_hours != "00:00")
		{
			$(".time-record[date='" + val.date + "']").find(".late-hours").css("color", "black");
		}
		else
		{
			$(".time-record[date='" + val.date + "']").find(".late-hours").css("color", "#bbb");
		}

		/* NORM HOURS GRAY IF ZERO */
		if(val.regular_hours != "00:00")
		{
			$(".time-record[date='" + val.date + "']").find(".normal-hours").css("color", "black");
		}
		else
		{
			$(".time-record[date='" + val.date + "']").find(".normal-hours").css("color", "#bbb");
		}

		/* EXTRA DAY GRAY IF ZERO */
		if(val.extra_day_hours != "00:00")
		{
			$(".time-record[date='" + val.date + "']").find(".extra-day-hours").css("color", "black");
		}
		else
		{
			$(".time-record[date='" + val.date + "']").find(".extra-day-hours").css("color", "#bbb");
		}

		/* REST DAY GRAY IF ZERO */
		if(val.rest_day_hours != "00:00")
		{
			$(".time-record[date='" + val.date + "']").find(".rest-day-hours").css("color", "black");
		}
		else
		{
			$(".time-record[date='" + val.date + "']").find(".rest-day-hours").css("color", "#bbb");
		}

		/* TOTAL GRAY IF ZERO */
		if(val.total_hours != "00:00")
		{
			$(".time-record[date='" + val.date + "']").find(".total-hours").css("color", "black");
		}
		else
		{
			$(".time-record[date='" + val.date + "']").find(".total-hours").css("color", "#bbb");
		}

		if(val.late_overtime != "00:00")
		{
			$(".time-record[date='" + val.date + "']").find(".overtime-hours.late").css("color", warncolor);
			if(val.payroll_time_sheet_approved == 1)
			{
				$(".time-record[date='" + val.date + "']").find(".overtime-hours.late").addClass("cancel-approve").css("cursor","pointer");
				$(".time-record[date='" + val.date + "']").find(".overtime-hours.late").removeClass("load-overtime-form").css("cursor","pointer");
			}
			else
			{
				$(".time-record[date='" + val.date + "']").find(".overtime-hours.late").addClass("load-overtime-form").css("cursor","pointer");
				$(".time-record[date='" + val.date + "']").find(".overtime-hours.late").removeClass("cancel-approve").css("cursor","pointer");
			}
		}
		else
		{
			$(".time-record[date='" + val.date + "']").find(".overtime-hours.late").css("color", "#bbb").css("cursor","");
		}

		if(val.early_overtime != "00:00")
		{
			$(".time-record[date='" + val.date + "']").find(".overtime-hours.early").css("color", warncolor);

			if(val.payroll_time_sheet_approved == 1)
			{
				$(".time-record[date='" + val.date + "']").find(".overtime-hours.early").addClass("cancel-approve");
				$(".time-record[date='" + val.date + "']").find(".overtime-hours.early").removeClass("load-overtime-form");
			}
			else
			{
				$(".time-record[date='" + val.date + "']").find(".overtime-hours.early").addClass("load-overtime-form");
				$(".time-record[date='" + val.date + "']").find(".overtime-hours.early").removeClass("cancel-approve");
			}
			
		}
		else
		{
			$(".time-record[date='" + val.date + "']").find(".overtime-hours.early").css("color", "#bbb");
			$(".time-record[date='" + val.date + "']").find(".overtime-hours.early").removeClass("load-overtime-form");
			$(".time-record[date='" + val.date + "']").find(".overtime-hours.early").removeClass("cancel-approve");
		}

		/* DISABLE IF APPROVED */
		if(val.payroll_time_sheet_approved == 1)
		{
			//$(".time-record[date='" + val.date + "']").find(".text-table").attr("disabled", "disabled").prop("disabled", "disabled");
			$(".time-record[date='" + val.date + "']").find(".table-check").removeClass("fa-check").addClass("fa-check").css("color","#000");
			$(".time-record[date='" + val.date + "']").addClass("disable-hover");
		}
		else
		{
			//$(".time-record[date='" + val.date + "']").find(".text-table").removeAttr("disabled", "disabled").removeProp("disabled", "disabled");
			$(".time-record[date='" + val.date + "']").find(".table-check").removeClass("fa-star").addClass("fa-check").css("color","#aaa");
			$(".time-record[date='" + val.date + "']").removeClass("disable-hover");
		}



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


	  if (MM % 60 === 0)
	  {
			res = MM / 60;
			HH += res;
			MM = MM - (60 * res);
	  }
		var formatted = ((HH < 10)?("0" + HH):HH) + ":" + ((MM < 10)?("0" + MM):MM);
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