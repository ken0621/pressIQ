	var employee_tag_schedule_leave = new employee_tag_schedule_leave();

function employee_tag_schedule_leave()
{
	init();

	function init()
	{
		check_tags_event();
		filter_change_event();
		filter_change_action();
	}

	function check_tags_event()
	{
		$(".check-all-tag").unbind("change");
		$(".check-all-tag").bind("change", function()
		{
			if($(this).is(':checked'))
			{
				$(this).parents(".list-group").find(".check-tag").prop('checked', true);
			}
			else
			{
				$(this).parents(".list-group").find(".check-tag").prop('checked', false);
			}
		});
	}

	function filter_change_event()
	{
		$(".change-filter").unbind("change");
		$(".change-filter").bind("change", function()
		{
			filter_change_action();
		});

		$(".change-filter-department").unbind("change");
		$(".change-filter-department").bind("change", function()
		{
			filter_change_action();
			var formdata = {
				_token:misc('_token'),
				payroll_department_id:$(this).val()
			};
			var action 	= "/member/payroll/jobtitlelist/get_job_title_by_department";
			var method 	= "POST";
			var pre_load = "<option value='0'>...loading</option>";
			$(".change-filter-job-title").html(pre_load);
			$.ajax({
				url 	: 	action,
				type 	: 	method,
				data 	: 	formdata,
				success : 	function(result)
				{
					var html = "<option value='0'>Select Job Title</option>";
					result = JSON.parse(result);
					$(result).each(function(index, data)
					{
						html += "<option value='"+data.payroll_jobtitle_id+"'>"+data.payroll_jobtitle_name+"</option>";
					});
					$(".change-filter-job-title").html(html);
					filter_change_event();
				},
				error 	: 	function(err)
				{
					error_function();
				}
			});
		})
	}

	function filter_change_action()
	{
		var company 	= $(".change-filter-company").val();
		var department 	= $(".change-filter-department").val();
		var jobtitle 	= $(".change-filter-job-title").val();
		var leave_id 	= $(".leave_id").val();
		var payroll_leave_pay_value = $(".payroll_leave_temp_with_pay").val();


		var formdata 	= {
			company:company,
			department:department,
			jobtitle:jobtitle,
			leave_id:leave_id,
			payroll_leave_pay_value:payroll_leave_pay_value,
			_token:misc('_token')
		};

		var action = "/member/payroll/leave_schedule/v2/ajax_schedule_leave_tag_employeev2";
		var	method = "POST";
		var target = ".employee-tag-list";	
		var function_name = "employee_tag.check_tags_event";
		$(target).html(misc('loader'));	
		$.ajax({

			url 	: 	action,
			type 	: 	method,
			data 	: 	formdata,
			success : 	function(result)
			{
				result = JSON.parse(result);

				var html = '<li class="list-group-item padding-3-10"><div class="checkbox"><label><input type="checkbox" name="" class="check-all-tag">Check All</label></div></li>';

				$(result).each(function (index, data)
				{
					html += str_list(data);
				});
				$(target).html(html);
				check_tags_event();
			},
			error 	: 	function(err)
			{
				error_function();
			}
		});
	}

	function str_list(data)
	{
		if(typeof(data.payroll_leave_employee_id_3) === 'undefined')
		{
				var html = '<li class="list-group-item padding-3-10">';
			  	html 	+= '<div class="checkbox">'
			  	html 	+= '<label><input type="checkbox" name="employee_tag[]" class="check-tag" value="'+data.payroll_leave_employee_id_2+'">'+ data.payroll_employee_title_name + ' ' +data.payroll_employee_first_name + ' ' + data.payroll_employee_middle_name + ' ' + data.payroll_employee_last_name  + ' ' + data.payroll_employee_suffix_name +'</label>';
			  	html 	+= '</div></li>';
		}
		else
		{
					var html = '<li class="list-group-item padding-3-10">';
				  	html 	+= '<div class="checkbox">'
				  	html 	+= '<label><input type="checkbox" name="employee_tags[]" class="check-tag" value="'+data.payroll_employee_id+'">'+ data.payroll_employee_title_name + ' ' +data.payroll_employee_first_name + ' ' + data.payroll_employee_middle_name + ' ' + data.payroll_employee_last_name  + ' ' + data.payroll_employee_suffix_name +'</label>';
				  	html 	+= '</div></li>';
		}
	  	return html;
	  
	}	

	this.check_tags_event = function()
	{
		check_tags_event();
	}


	this.load_tagged_employee = function()
	{	
		
		var leavetempid = $('#leavetempid').val();
	    if($('#pay').is(':checked'))
	    {
	    	var leave_pay_value = $('#pay').val();
	    }
	    else
	    {
	    	var leave_pay_value = $('#pays').val();
	    }
		var action = "/member/payroll/leave_schedule/v2/get_session_leave_tagv2";
		var method = "POST";
		var target = ".table-employee-tag";
		var formdata = {
			_token:misc('_token'),
			leavetempid:leavetempid,
			leave_pay_value:leave_pay_value
		};
		var function_name = "modal_create_deduction.remove_tag";
		$(target).html('<tr><td colspan="5">'+misc('loader') + '</td></tr>');
		$.ajax({
			url 	: 	action,
			type 	: 	method,
			data 	: 	formdata,
			success : 	function(result)
			{
				var html = '';
				result = JSON.parse(result);
				console.log(result.new_record);
				$(result.new_record).each(function(index, data){

					$(data).each(function(index,data2){

						html += tbl_tag(data2);
					});
					
				});
				$(target).html(html);
				event_time_entry();
				//whole_time_check();
				remove_tag();
			},
			error 	: 	function(err)
			{
				error_function();
			}
		});
		// reload_tag_employee();
	}

	function remove_tag()
	{
		$(".btn-remove-tag").unbind("click");
		$(".btn-remove-tag").bind("click", function()
		{
			var content = $(this).data("content");
			var parent = $(this).parents("tr");
			var element = $(this);
			var html = element.html();
			
			var con = confirm("Do you realy want to remove this employee?");
			if(con)
			{
				element.html(misc('spinner'));
				$.ajax({
					url 	: 	"/member/payroll/leave_schedule/v2/unset_session_leave_tagv2",
					type 	: 	"POST",
					data 	: 	{
						_token:misc('_token'),
						content:content
					},
					success : 	function(result)
					{
						parent.remove();
					},
					error 	: 	function(err)
					{
						error_function();
					}
				});
			}
		});
	}

	function tbl_tag(data)
	{
		var html = '<tr class="text-center time-record main">';
		html += '<td>' + data.payroll_employee_display_name  + ' <input type="hidden" name="employee_tag[]" value="'+data.payroll_leave_employee_id+'"></td>';
		if(data.total_leave_consume == null)
		{
			html += '<td>00:00</td>';
		}
		else
		{
			html += '<td>'+ data.total_leave_consume +'</td>';
		}
		if(data.remaining_leave == null)
		{
			html += '<td>'+ data.payroll_leave_temp_hours + '</td>';
		}
		else
		{
			html += '<td>'+ data.remaining_leave +'</td>';
		}
	//	html += '<td class="text-center"><input type="checkbox" checked="checked" class="whole_day" name="whole_day_'+data.payroll_leave_employee_id+'" value="1"></td>';
		html += '<td class="text-center edit-data zerotogray" width="25%"><input type="text" name="leave_hours_'+data.payroll_leave_employee_id+'" placeholder="00:00" class="text-center form-control break time-entry time-target time-entry-24 is-timeEntry"></td>';
		html += '<td class="text-center"><a href="#" class="btn-remove-tag" data-content="'+data.payroll_employee_id+'"><i class="fa fa-times"></i></a></td>';
		html += '</tr>';
		return html;
	}

	function error_function()
	{
		toastr.error("Error, something went wrong.");
	}


	function event_time_entry()
	{
		$(".time-entry").timeEntry('destroy');
		$(".time-entry-24").timeEntry('destroy');
		$(".time-entry.time-in").timeEntry({ampmPrefix: ' ', defaultTime: new Date(0, 0, 0, 0, 0, 0)});
		$(".time-entry.time-out").timeEntry({ampmPrefix: ' ', defaultTime: new Date(0, 0, 0, 12, 0, 0)});
		$(".time-entry-24").timeEntry({show24Hours: true, defaultTime: new Date(0, 0, 0, 0, 0, 0)});
	}
	
	function whole_time_check()
	{
		$(".whole_day").unbind("change");
		$(".whole_day").bind("change", function()
		{
			var target = $(this).parents('tr').find('.time-target');
			if($(this).is(":checked"))
			{
				target.attr('disabled',true);
				target.removeAttr('required');
			}
			else
			{
				target.attr('disabled',false);
				target.attr('required',true);
			}
		});
	}

	function misc(str){
		var spinner = '<i class="fa fa-spinner fa-pulse fa-fw"></i><span class="sr-only">Loading...</span>';
		var plus = '<i class="fa fa-plus" aria-hidden="true"></i>';
		var times = '<i class="fa fa-times" aria-hidden="true"></i>';
		var pencil = '<i class="fa fa-pencil" aria-hidden="true"></i>';
		var loader = '<div class="loader-16-gray"></div>'
		var _token = $("#_token").val();

		switch(str){
			case "spinner":
				return spinner
				break;

			case "plus":
				return plus
				break;

			case "loader":
				return loader
				break;

			case "_token":
				return _token
				break;
			case "times":
				return times
				break;
			case "pencil":
				return pencil
				break;
		}
	}


}


