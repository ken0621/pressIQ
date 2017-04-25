var repurchase = new repurchase();

function repurchase()
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
		event_add_to_cart();
		bootstrap_tooltip();
	}
	function bootstrap_tooltip
	{
		$('[data-toggle="tooltip"]').tooltip();
	}
	function event_add_to_cart()
	{
		$('.add-to-cart-button').unbind("click");
		$('.add-to-cart-button').bind("click", function(e)
		{
			action_add_to_cart(e.currentTarget);
		});
	}
	function action_add_to_cart(x)
	{
		var item_id = $(x).attr("item-id");
		var quantity = $('.add-to-cart-quantity[item-id="'+item_id+'"]').val();

		$.ajax({
			url: '/mlm/repurchase/add_cart',
			type: 'GET',
			dataType: 'json',
			data: {
				item_id: item_id,
				quantity: quantity
			},
		})
		.done(function() 
		{
			$(".repurchase-cart .loader").removeClass("hide");
			$(".repurchase-cart").load('/mlm/repurchase/cart', function()
			{
				$(".repurchase-cart .loader").addClass("hide");
			});
		});
		
	}
}
