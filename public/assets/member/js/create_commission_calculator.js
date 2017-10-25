var create_commission_calculator = new create_commission_calculator();
var load_table_data = {};

function create_commission_calculator()
{
	init();

	function init()
	{
		$(document).ready(function()
		{
			document_ready();
		});
	}

	function document_ready()
	{
		action_initialize_select();
	}
	function action_initialize_select()
	{
		$('.select-customer').globalDropList({
			hasPopup : 'false',
			width : '100%'
		});
		$('.select-property').globalDropList({
			hasPopup : 'false',
			width : '100%'
		});
		$('.select-agent').globalDropList({
			hasPopup : 'false',
			width : '100%'
		});
	}
}