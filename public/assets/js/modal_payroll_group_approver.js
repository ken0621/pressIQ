var modal_payroll_group_approver = new modal_payroll_group_approver();
var approver_level_count;
var approver_type; 
function modal_payroll_group_approver()
{
	init();

	function init()
	{
		ready_document();
	}

	function ready_document()
	{
		$(document).ready(function() 
		{
			action_change_level_and_type();
			approver_level_count = 0;
			approver_type = 0;
		});
	}

	function action_change_level_and_type()
	{
		$('#approver_level_count').unbind('change');
		$('#approver_level_count').bind('change',function(event) 
		{
			
			approver_level_count = $(this).val();

			if (approver_type != 0 && approver_level_count != 0) 
			{
				append_selector(approver_level_count ,approver_type);
			}
		});

		$('#approver_type').unbind('change');
		$('#approver_type').bind('change',function(event) 
		{
			approver_type = $(this).val();

			if (approver_type != 0 && approver_level_count != 0) 
			{
				append_selector(approver_level_count ,approver_type);
			}
		});
	}


	function append_selector(level, type)
	{
		var target = $('.approver-container');
		target.html(misc('loader'))
		$.ajax({
			url: '/member/payroll/payroll_admin_dashboard/get_employee_approver_by_level',
			type: 'get',
			data: {level : level, type : type},
			success: function(data)
			{
				target.html('<hr>'+data);
				$('.multiple-select-2').select2(
				{placeholder: 'Select an option', closeOnSelect : false,  allowClear: true});
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