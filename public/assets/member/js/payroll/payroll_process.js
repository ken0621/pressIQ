var payroll_process = new payroll_process();

function payroll_process()
{
	init();

	function init()
	{
		toggle_custom_panel_header_event();
		btn_event();
	}

	function btn_event()
	{
		$(".custom-panel-header .btn").unbind("click");
		$(".custom-panel-header .btn").bind("click", function(e)
		{
			// e.stopPropagation();
		});
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

	this.reload_break_down = function(employee_id, period_id)
	{
		$(".break-down-div").load('/member/payroll/payroll_process/payroll_compute_brk_unsaved/' + employee_id + '/' + period_id + ' .break-down-div', function()
		{
			toastr.success("Computation has been updated.");
			
		});

		reload_tbl();
	}

	function reload_tbl()
	{
		$(".process-container").load("/member/payroll/payroll_process .process-container", function()
		{
			toggle_custom_panel_header_event();
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
	if(data.function_name == 'reload_break_down')
	{
		payroll_process.reload_break_down(data.payroll_employee_id, data.payroll_period_company_id);
	}
	data.element.modal("toggle");
}