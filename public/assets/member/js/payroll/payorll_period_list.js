var payorll_period_list = new payorll_period_list();

function payorll_period_list()
{
	init();

	function payorll_period_list()
	{

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
	executeFunctionByName(data.function_name, window);
}