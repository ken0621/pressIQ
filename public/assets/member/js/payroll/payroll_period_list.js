var payroll_period_list = new payroll_period_list();

function payroll_period_list()
{
	init();

	function init()
	{

	}

	this.reload_list = function()
	{
		toastr.success("Period list has been updated");
		$(".period-list").load("/member/payroll/payroll_period_list .tab-pane-div", function()
		{
			
		});
	}	
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

function submit_done(data)
{
	data.element.modal("toggle");
	console.log(data.function_name);
	executeFunctionByName(data.function_name, window);
}