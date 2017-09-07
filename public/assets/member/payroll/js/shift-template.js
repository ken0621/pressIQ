var shifting = new shifting();

function shifting()
{
	init();

	function init()
	{
		event_add_sub_time(); //GUILLERMO
		event_check(); //JIMAR
		event_time_entry(); //GUILLERMO
		event_remove_time_entry();
		action_set_time_entry(); //GUILLERMO
		event_check_flexitime(); //KIM BRIEL
		action_show_break_hour(); // KIM BRIEL
		
	}
	function event_add_sub_time()
	{
		$(".add-sub-time").click(function(e)
		{
			action_append_sub_time($(e.currentTarget));
		})
	}
	function event_check()
	{
		$(".restday-check").unbind("change");
		$(".restday-check").bind("change", function () {
			var parent = $(this).parents('tr').find('.extraday-check');
			if($(this).is(":checked"))
			{
				parent.prop("checked", false);
			}

		});

		$(".extraday-check").unbind("change");
		$(".extraday-check").bind("change", function () {
			var parent = $(this).parents('tr').find('.restday-check');
			if($(this).is(":checked"))
			{
				parent.prop("checked", false);
			}

		});
	}
	function event_time_entry()
	{
		$(".time-entry.in").unbind("change");
		$(".time-entry.in").bind("change", function(e)
		{
			$(e.currentTarget).closest(".main-con").find(".time-entry.out").timeEntry('destroy');
			$(e.currentTarget).closest(".main-con").find(".time-entry.out").timeEntry({'minTime':$(e.currentTarget).val(), ampmPrefix: ' ', defaultTime: new Date(0, 0, 0, 12, 0, 0)});
		});

		$(".time-entry.out").unbind("change");
		$(".time-entry.out").bind("change", function(e)
		{
			$(e.currentTarget).closest(".main-con").find(".time-entry.in").timeEntry('destroy');
			$(e.currentTarget).closest(".main-con").find(".time-entry.in").timeEntry({'maxTime':$(e.currentTarget).val(), ampmPrefix: ' ', defaultTime: new Date(0, 0, 0, 12, 0, 0)});
		});
	}

	function event_check_flexitime()
	{

		$(".flexitime-check").change(function(e) 
		{
			if(e.currentTarget.checked) 
			{
				console.log("a");
        		$(e.currentTarget).closest(".main-time").find(".break_hours").removeClass("hidden");
   			}
   			else
   			{
   				console.log("b");
   				$(e.currentTarget).closest(".main-time").find(".break_hours").addClass("hidden");
   				$(e.currentTarget).closest(".main-time").find(".break_hours").val("0");
   			}
		});
	}



	function event_remove_time_entry()
	{
		$(".remove-time-entry").unbind("click");
		$(".remove-time-entry").bind("click", function(e)
		{
			$(e.currentTarget).closest(".main-con").remove();
		});
	}

	function event_flexitime_check()
	{
		$(".flexitime-check").change(function(e){
			if (e.currentTarget.checked) 
			{
				$(e.currentTarget).closest(".main-time").find(".-check").removeClass("hidden");
			}
			else
			{
				$(e.currentTarget).closest(".main-time").find(".flexitime-check").addClass("hidden");
				$(e.currentTarget).closest(".main-time").find(".flexitime-check").val("0");
			}
		});
	}

	function action_set_time_entry()
	{
		$(".time-entry.in").timeEntry('destroy');
		$(".time-entry.out").timeEntry('destroy');
		$(".time-entry.in").timeEntry({ampmPrefix: ' ', defaultTime: new Date(0, 0, 0, 0, 0, 0)});
		$(".time-entry.out").timeEntry({ampmPrefix: ' ', defaultTime: new Date(0, 0, 0, 12, 0, 0)});
	}

	function action_show_break_hour()
	{
		$(".flexitime-check").each(function(e)
		{
			// console.log($(this).is(":checked"));
			if($(this).is(":checked")) 
			{
				$(this).closest(".main-time").find(".break_hours").removeClass("hidden");
			}
			else
			{
				$(this).closest(".main-time").find(".break_hours").addClass("hidden");
				$(this).closest(".main-time").find(".break_hours").val("0");
			}
		});
	}

	
	function action_append_sub_time($target)
	{
		$day = $target.closest(".main-time").attr("day");

		$append = '<tr class="editable sub-time main-con">' +
							'<td></td>' +
							'<td></td>' +
							'<td class="editable">' +
								'<input type="text" placeholder="NO TIME" name="work_start[' + $day + '][]" class="text-table time-entry in" >' +
							'</td>' +
							'<td class="editable">' +
								'<input type="text" placeholder="NO TIME" name="work_end[' + $day + '][]" class="text-table time-entry out" >' +
							'</td>' +
							'<td>' +
								'<button type="button" class="btn btn-default remove-time-entry"><i class="fa fa-close"></i></button>' +
							'</td>' +
							'<td class="text-center"></td>' +
							'<td class="text-center"></td> ' +
							'<td class="text-center"></td>' +
						'</tr>';

		$target.closest(".main-time").after($append);

		action_set_time_entry();
		event_time_entry();
		event_remove_time_entry();
	}
}