var member = new member();

function member()
{
	init();

	function init()
	{
		document_ready();
		event_hover_sidebar();
	}

	function document_ready()
	{
		$(document).ready(function()
		{
			
		});
	}

	function event_hover_sidebar()
	{
		$(".sidebar").hover(function() 
		{
			$(".sidebar").removeClass("small");
		}, 
		function() 
		{
			$(".sidebar").addClass("small");
		});
	}
}