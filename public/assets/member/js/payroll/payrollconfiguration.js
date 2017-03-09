var payrollconfiguration = new payrollconfiguration();

function payrollconfiguration()
{
	init();

	function init()
	{
		a_navigation_configuration_event();
		load_configuration('/member/payroll/departmentlist');
	}

	function a_navigation_configuration_event()
	{
		$(".a-navigation-configuration").unbind("click");
		$(".a-navigation-configuration").bind("click", function(e)
		{
			e.preventDefault();
			var link 	= $(this).attr("href");
			load_configuration(link);
		});
	}

	function load_configuration(action = "", method = "POST", target = ".configuration-div")
	{
		$(target).html(misc('loader'));
		$.ajax({
			url 	: 	action,
			type 	:  	method,
			data 	: 	{
				_token:misc('_token')
			},
			success : 	function(result)
			{
				$(target).html(result);
				load_configuration_event();
			},
			error  	: 	function()
			{
				error_function();
			}
		});
	}

	function load_configuration_event()
	{	
		$(".btn-archived").unbind("click");
		$(".btn-archived").bind("click", function()
		{
			var content = $(this).data("content");
		});
	}

	function error_function()
	{
		toastr.error("Error, something went wrong.");
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


	this.relaod_tbl_department = function()
	{

	}

	this.executeFunctionByName = function(functionName)
	{
		executeFunctionByName(functionName, window);
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
}
function submit_done(data)
{
	$("#global_modal").modal("hide");
	payrollconfiguration.executeFunctionByName(data.function_name);
	$("#global_modal").modal("hide");
}