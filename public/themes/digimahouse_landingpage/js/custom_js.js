var custom = new custom();

function custom()
{
	init();

	function init()
	{
		$(document).ready(function($) 
		{
			document_ready();
		});
	}

	function document_ready()
	{
		event_toggle_nav();
		fix_header();
	}

	function fix_header()
	{
		$window = $(window);
		$window.scroll(function() {
		  $scroll_position = $window.scrollTop();
		    if ($scroll_position > 100) { 
		        $('.header-container').addClass('header-fixed');

		        header_height = $('.your-header').innerHeight();
		        $('body').css('padding-top' , header_height);
		    } else {
		        $('.header-container').removeClass('header-fixed');
		        $('body').css('padding-top' , '0');
		    }
		 });
	}

	function event_toggle_nav()
	{
	    $(".menu-nav").bind("click", function()
	    {
	        action_toggle_nav();
	    });
	}

	function action_toggle_nav()
	{
	    $(".menu-nav").unbind("click");
	    $(".navirino").slideToggle(400, function()
	    {
	        event_toggle_nav();
	    });
	}
}