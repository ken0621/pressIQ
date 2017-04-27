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
			action_product_carousel();
			event_show_product();
		});
	}
	function action_match_height()
	{
		$(".match-height").matchHeight();

		$(window).resize(function()
		{
			$(".match-height").matchHeight();
		});
	}
	function event_show_product()
	{
		$(".show-product").unbind("click");
		$(".show-product").bind("click", function()
		{
			action_show_product();
		});
	}
	function action_show_product()
	{
		$('.product-container').toggleClass('show');
	}
	function action_product_carousel()
	{
		$('.product-container .list-product').slick({
			infinite: true,
			slidesToShow: 7,
			slidesToScroll: 1,
			prevArrow:"<img class='a-left control-c prev slick-prev' src='/themes/sovereign/img/carousel-left.png'>",
      		nextArrow:"<img class='a-right control-c next slick-next' src='/themes/sovereign/img/carousel-right.png'>"
		})
	}
}