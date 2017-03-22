var cart = new cart();

function cart()
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
		event_qty_control();
		event_remove_cart();
	}
	function event_qty_control()
	{
		$('.qty-control-add').unbind("click");
		$('.qty-control-add').bind("click", function(event) 
		{
			event.preventDefault();
			
			action_qty_control("+", $(event.currentTarget).attr("variation-id"))
		})

		$('.qty-control-minus').unbind("click");
		$('.qty-control-minus').bind("click", function(event) 
		{
			event.preventDefault();
			
			action_qty_control("-", $(event.currentTarget).attr("variation-id"));
		})
	}
	function action_qty_control(sign, id)
	{
		var current = parseInt($('.qty-control[variation-id="'+id+'"]').val());

		if (sign == "+") 
		{
			$('.qty-control[variation-id="'+id+'"]').val(current + 1);
		}
		else
		{
			if (current > 1) 
			{
				$('.qty-control[variation-id="'+id+'"]').val(current - 1);
			}
		}	

		var quantity = parseInt($('.qty-control[variation-id="'+id+'"]').val());

		$.ajax({
			url: '/cart/update',
			type: 'get',
			dataType: 'json',
			data: {
				variation_id: id,
				quantity: quantity
			},
		})
		.done(function() {
			ready_load_mini_ecom_cart();
		})
		.fail(function() {
			console.log("error");
		})
		.always(function() {
			console.log("complete");
		});
	}
	function event_remove_cart()
	{
		$('.remove-cart').unbind('click');
		$('.remove-cart').bind('click', function(event) 
		{
			event.preventDefault();
			$(event.currentTarget).closest("tr").remove();
			
			var variation_id = $(event.currentTarget).attr("variation-id");

			$.ajax({
				url: '/cart/remove',
				type: 'GET',
				dataType: 'json',
				data: {variation_id: variation_id},
			})
			.done(function() {
				ready_load_mini_ecom_cart();
			})
			.fail(function() {
				console.log("error");
			})
			.always(function() {
				console.log("complete");
			});
		});
	}
}