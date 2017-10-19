var payroll_employees_13th_month_pay = new payroll_employees_13th_month_pay();
var basis = "";
function payroll_employees_13th_month_pay()
{
	init();
	function init()
	{
		$(document).ready(function()
		{

			document_ready();
			action_load_modal_13th_month_basis();
			action_change_filter_company();
		});
	}

	function document_ready()
	{

	}

	function action_load_modal_13th_month_basis()
	{
		$('.modal-13th-pay-basis-button').on('click',function()
		{
			// var employee_id = $(this).data('id');
			// alert(employee_id);
			action_load_link_to_modal("/member/payroll/reports/modal_employee_13_month_pay_report", 'lg');
		});
	}
	function action_change_filter_company()
	{
		$('.filter-change-company').on('change',function()
		{
			console.log($('.filter-change-company').val()+"  "+basis);
		});
	}
}

function submit_done(data)
{
	if (data.function == 'load_13th_month_pay_table') 
	{
		load_13th_month_pay_table(data.employee_13_month_basis,data._token);
		data.element.modal("hide");
	}
}

function load_13th_month_pay_table(employee_13_month_basis,_token)
{
	basis = employee_13_month_basis;

	$.ajax({

		url		: '/member/payroll/reports/employees_13th_month_pay_table',
		data	: {employee_13_month_basis : employee_13_month_basis, _token : _token},
		type	: 'POST',
		success : function(result)
		{
			$('.employees-13th-month-pay').html(result);
		}
	});
}