var loan_summary = new loan_summary();

function loan_summary()
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
				select_company_name();
				select_deduction_type();
				load_summary_table('0');
			});
	}

	function select_deduction_type()
	{

		$('.select-deduction-type').change(function()
		{
			var deduction_type = this.value;
			if (deduction_type!=0) 
			{
				load_summary_table(deduction_type);
			}
			else
			{
				load_summary_table('0');
			}
		});
	}

//-------------------------
	function select_company_name()
	{

		$('.select-company-name').change(function()
		{
			var company_id = this.value;

			$.ajax({

				url : '/member/payroll/reports/table_company_loan_summary',
				data : {company_id:company_id},
				type : 'GET',
				success : function(result)
				 {
				 	$('.loan-summary-table-load').html(result);
				 }

			});
		});
	}
/*function biometric_load_table()
	{
		var date_from = $('.date_from').val()
		var date_to = $('.date_to').val();
		$.ajax({
			url		:  '/member/payroll/payroll_biometric/biometric_record_table',
			data	: {date_from : date_from, date_to : date_to},
			type	: 'GET',
			success : function(result)
			{
				$('.panel-table').removeClass('hidden');
				$('.biometric-table-load').html(result);
			}
		});
	}*/






//---------------------------
	function load_summary_table(deduction_type)
	{
		$('.loan-summary-table-load').load('table_loan_summary/'+deduction_type);
	}
}