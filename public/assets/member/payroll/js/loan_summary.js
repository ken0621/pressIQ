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
			var company = $('.select-company-name').val();
			var branch = $('.filter-by-branch').val();

			load_summary_table(deduction_type,company,branch);

		});
	}

//-------------------------
	function select_company_name()
	{

		$('.select-company-name').change(function()
		{
			var company_id = this.value;
			var branch = $('.filter-by-branch').val();

			$.ajax({

				url : '/member/payroll/reports/table_company_loan_summary',
				data : {company_id:company_id,branch:branch},
				type : 'GET',
				success : function(result)
				 {
				 	$('.loan-summary-table-load').html(result);
				 }

			});
		});


		$('.filter-by-branch').change(function()
		{
			var branch = this.value;
			var company_id = $('.select-company-name').val();

			$.ajax({

				url : '/member/payroll/reports/table_company_loan_summary',
				data : {company_id:company_id,branch:branch},
				type : 'GET',
				success : function(result)
				 {
				 	$('.loan-summary-table-load').html(result);
				 }

			});
		});
	}
	
	function load_summary_table(deduction_type,company,branch)
	{
		$('.loan-summary-table-load').load('table_loan_summary/'+deduction_type+'/'+company+'/'+branch);
	}
}