var create_approver = new create_approver();
var change_filter_company 		= 0;
var change_filter_job_title 	= 0;
var change_filter_department 	= 0;

function create_approver()
{
	init();

	function init()
	{
		document_ready();
		
	}

	function document_ready()
	{
		$(document).ready(function() 
		{
			change_filter_company 		= 0;
			change_filter_job_title 	= 0;
			change_filter_department 	= 0;
			event_change_company();
			event_change_job_title();
			event_change_filter_department();
			employee_list();
			select_all_employee();
			form_submit();
		});
	}

	

	function select_all_employee()
	{

	}

	function form_submit()
	{
		$('.approver-form').submit(function(event) 
		{
			var input = $('.approver-form').serialize();
			console.log(input);
			event.preventDefault();
			$.ajax({
				url: '/member/payroll/payroll_admin_dashboard/save_approver',
				type: 'POST',
				data: {inputs : input},
				success: function(data)
				{
					console.log('done');
				}
			});
			
		});
	}

	function event_change_company()
	{
		$('.change-filter-company').unbind('change');
		$('.change-filter-company').bind('change', function() 
		{
			change_filter_company = $(this).val();
			console.log(change_filter_company);
			employee_list();
		});
	}

	function event_change_job_title()
	{
		$('.change-filter-job-title').unbind('change');
		$('.change-filter-job-title').bind('change', function() 
		{
			change_filter_job_title = $(this).val();
			employee_list();
		});
	}

	function event_change_filter_department()
	{
		$('.change-filter-department').unbind('change');
		$('.change-filter-department').bind('change', function() 
		{
			change_filter_department = $(this).val();
			employee_list();
		});
	}

	function employee_list()
	{
		var target = ".table-employee-tag";
		var html =''; // '<li class="list-group-item padding-3-10"><div class="checkbox"><label><input type="checkbox" name="" class="check-all-tag">Check All</label></div></li>'
		$(target).html(misc("loader"));
		$.ajax({
			url: '/member/payroll/payroll_admin_dashboard/create_approver_table',
			type: 'GET',
			data: { _token : misc('_token'), company : change_filter_company, jobtitle : change_filter_job_title, department : change_filter_department},
			success : function(data)
			{
				// data = JSON.parse(data);
				// $(data).each(function(index, data) 
				// {
				// 	console.log(data.payroll_employee_first_name);
				// 	html += str_list(data);
				// });
				// $(target).html(html);
				$(target).html(data);
			}
		})
		.done(function() {
			console.log("success");
		})
		.fail(function() {
			console.log("error");
		})
		.always(function() {
			console.log("complete");
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

