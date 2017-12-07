var payroll_register_report = new payroll_register_report();
var payroll_company_id = 0;
function payroll_register_report()
{

	init();

	function init()
	{
		$(document).ready(function()
		{
			document_ready();
		})
	}
	function document_ready()
	{
		$(document).ready(function(){
			event_register_report_filter();
			action_register_report_table(0);
			export_excel_register_report();
		});
	}
	

	function event_register_report_filter()
	{
		$('#filter_report').on('change', function(e){
			payroll_company_id = $(this).val();
			action_register_report_table(payroll_company_id);
		});
	}

	function action_register_report_table(payroll_company_id)
	{
		var period_company_id = $(".period_company_id").val();
		$(".payroll_register_report_table").html('<div style="padding: 150px 80px; padding-bottom: 500px; text-align: center; font-size: 30px; color: #1682ba"><i class="fa fa-spinner fa-pulse fa-fw"></i></div>');
		$.ajax({
			type: 'GET',
			url: '/member/payroll/reports/payroll_register_report_table',
			dataType: 'text',
			data: {payroll_company_id: payroll_company_id, period_company_id : period_company_id},
			success: function(data)
				{
					$(".payroll_register_report_table").html(data);
				
				}
			});
	}

	function export_excel_register_report()
	{
		$(".btn-export-excel").on('click',function()
		{
			var period_company_id = $(".period_company_id").val();
			window.location = "/member/payroll/reports/payroll_register_report_period/export_excel/"+period_company_id+"/"+payroll_company_id;
		});
	}

}

