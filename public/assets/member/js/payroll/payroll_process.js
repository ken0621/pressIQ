var payroll_process = new payroll_process();

function payroll_process()
{
	init();

	function init()
	{

	}
}

function submit_done(data)
{
	try
	{
		data = JSON.parse(data);
	}
	catch(err)
	{

	}
	data.element.modal("toggle");
}