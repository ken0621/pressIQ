var global = new global()

function global()
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
			action_match_height();
			event_show_cart();
			action_fit_text();
			action_slick();
		});
	}
	function event_show_cart()
	{
		$('html').click(function() 
		{
			action_hide_cart();
		});

		$("body").on("click", ".shopping-cart-container", function(e)
		{
			event.stopPropagation();
			action_show_cart();
		});
	}
	function action_show_cart()
	{
		$(".shopping-cart-container .container-cart").addClass("show");
	}
	function action_hide_cart()
	{
		$(".shopping-cart-container .container-cart").removeClass("show");
	}
	function action_match_height()
	{
		$(".match-height").matchHeight();

		$(window).resize(function()
		{
			$(".match-height").matchHeight();
		});
	}
	function action_fit_text()
	{
		jQuery(".item-price").fitText(0.8, {
			maxFontSize: '16px',
			minFontSize: '8px',
		});
	}
	function action_slick()
	{
		$('.daily-container').slick({
			arrows: false,
			autoplay: true,
  			autoplaySpeed: 2000,
		})

		$(document).on('click', '.hot-deals-container .left-container-title .scroll-button a', function(event) 
		{
			event.preventDefault();
			var direction = $(event.currentTarget).attr("class");
			
			if (direction == "left") 
			{
				$(".daily-container").slick("slickPrev");
			}
			else
			{
				$(".daily-container").slick("slickNext");
			}
		});
	}
}