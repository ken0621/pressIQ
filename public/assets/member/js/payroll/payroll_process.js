var payroll_process = new payroll_process();

function payroll_process()
{
	init();

	function init()
	{
		toggle_custom_panel_header_event();
	}

	function toggle_custom_panel_header_event()
	{
		$(".custom-panel-header").unbind("click");
		$(".custom-panel-header").bind("click", function()
		{
			var child = $(this).parents(".custom-panel").find(".custom-panel-child");
			child.slideToggle();
		});
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