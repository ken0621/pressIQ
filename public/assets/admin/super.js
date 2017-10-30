var myApp = new Framework7( { animateNavBackIcon:true });
var $$ = Dom7;
var mainView = null;
var admin = new admin();

function admin()
{
	init();

	function init()
	{
		framework7init();

		$(document).ready(function()
		{
			page_ready();
		});

	}
	function page_ready()
	{
	}
	function framework7init()
	{
		mainView = myApp.addView('.view-main',
		{
		    dynamicNavbar: true,
		    domCache: true
		});
	}
}