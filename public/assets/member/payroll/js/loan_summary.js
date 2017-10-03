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
				//select_company_name();
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
/*	function select_company_name()
	{

		$('.select-company-name').change(function()
		{
			var company_name = this.value;

			//alert(company_name);
			if (company_name!=0) 
			{
				load_summary_table(company_name);
				alert(company_name);
			}
			else
			{
				load_summary_table('0');
			}
		});
	}*/
/*var team_name = $('#team_name').val();

$.ajax({

		url		:  '/supervisor/view/user',
			data	: {team_name : team_name},
			type	: 'GET',
			success : function(data)
			{
				$('.panel-table').removeClass('hidden');
				$('.continue-btn').html(data);
			}
});*/



	function load_summary_table(deduction_type)
	{
		$('.loan-summary-table-load').load('table_loan_summary/'+deduction_type);
	}
}