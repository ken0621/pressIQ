var payroll_group_approver = new payroll_group_approver();

function payroll_group_approver()
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
			action_change_level();
		});
	}

	function action_change_level()
	{
		$('#approver_level_count').unbind('change');
		$('#approver_level_count').bind('change',function(event) 
		{
			console.log($(this).val());
		});
	}
}