var reports = new reports();

function reports()
{
	init();

	function init()
	{
		document_ready();
	}

	function document_ready()
	{
		on_event();
	}

	function on_event()
	{
		$('body').on('change', '.report_choose', function(event) {
			console.log('sample');
			action_get_unhide_class();	
		});
	}

	function action_get_unhide_class()
	{
		$('.cashiers_c').removeClass('hide');
	}
	
		
}