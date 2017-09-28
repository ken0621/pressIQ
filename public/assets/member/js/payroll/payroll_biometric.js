var payroll_biometric = new payroll_biometric();


function payroll_biometric()
{
	init();

	function init()
	{
		ready_document();
	}

	function ready_document()
	{
		$(document).ready(function()
		{
			// biometric_load_table();
			action_load_table();
		});
	}

	function action_load_table()
	{
		$('.btn-show').click(function()
		{
			biometric_load_table();
		});
	}

	function biometric_load_table()
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
	}

	function biometric_import_record()
	{
		var date_from = $('.date_from').val()
		var date_to = $('.date_to').val();
		$.ajax({
			url		:  '/member/payroll/payroll_biometric/biometric_import_record',
			data	: {date_from : date_from, date_to : date_to},
			type	: 'GET',
			success : function(result)
			{
				alert("Data Imported");
			}
		});
	}
}