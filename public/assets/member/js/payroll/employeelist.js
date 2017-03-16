var employeelist = new employeelist();

function employeelist()
{
	init()
	function init()
	{
		tbl_btn_event();
		// reload_employee_list();
		// reload_employee_list('separated');
		filter_change_event();
	}

	function tbl_btn_event()
	{

	}

	function filter_change_event()
	{
		$(".filter-change").unbind("change");
		$(".filter-change").bind("change", function()
		{
			var parent = $(this).parents(".filter-div");
			var company_id = parent.find(".filter-change-company").val();
			var employement_status =  parent.find(".filter-change-status").val();
			var formdata = {
				_token:misc('_token'),
				company_id:company_id,
				employement_status:employement_status
			};
			var action = "/member/payroll/employee_list/reload_employee_list";
			var method = "POST";
			var target = $(this).data("target");
			var function_name = "employeelist.tbl_btn_event";
			$(target).html(misc('loader'));
			load_configuration(action, method, formdata, target, function_name);
		});
	}

	function load_configuration(action = "", method = "POST", formdata = [] , target = "",  function_name = "")
	{
		$(target).html(misc('loader'));
		$.ajax({
			url 	: 	action,
			type 	:  	method,
			data 	: 	formdata,
			success : 	function(result)
			{
				$(target).html(result);
				// load_configuration_event();
				executeFunctionByName(function_name, window);
			},
			error  	: 	function()
			{
				error_function();
			}
		});
	}

	function error_function()
	{
		toastr.error("Error, something went wrong.");
	}

	/* USE THIS FOR FILTERING THE EMPLOYEE LIST */
	function reload_employee_list(employement_status = 0, company_id = 0)
	{
		var formdata = {
			_token:misc('_token'),
			company_id:company_id,
			employement_status:employement_status
		};
		var action = "/member/payroll/employee_list/reload_employee_list";
		var method = "POST";
		var target = "#active-employee";
		if(employement_status == 'separated')
		{
			target = "#separated-employee";
		}
		var function_name = "employeelist.tbl_btn_event";
		$(target).html(misc('loader'));
		load_configuration(action, method, formdata, target, function_name);
	}

	this.executeFunctionByName = function(function_name)
	{
		console.log(function_name);
		executeFunctionByName(function_name, window);
	}

	this.reload_employee_list = function()
	{	
		reload_employee_list();
		reload_employee_list('separated');
	}

	this.tbl_btn_event = function()
	{
		tbl_btn_event();
	}

	/* CALL A FUNCTION BY NAME */
	function executeFunctionByName(functionName, context /*, args */) {
	  var args = [].slice.call(arguments).splice(2);
	  var namespaces = functionName.split(".");
	  var func = namespaces.pop();
	  for(var i = 0; i < namespaces.length; i++) {
	    context = context[namespaces[i]];
	  }
	  return context[func].apply(context, args);
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


function submit_done($data)
{
	data = JSON.parse(data);
	console.log(data);
	alert("submit done");
	employeelist.executeFunctionByName(data.function_name);
	data.element.modal("toggle");
}