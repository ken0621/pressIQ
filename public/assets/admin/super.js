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

        myApp.onPageInit('customer-list', function(page)
        {
        	var mySearchbar = $$('.searchbar')[0].f7Searchbar;
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