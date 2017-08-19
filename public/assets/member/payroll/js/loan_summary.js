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

	function load_summary_table(deduction_type)
	{
		$('.loan-summary-table-load').load('table_loan_summary/'+deduction_type);
	}
}