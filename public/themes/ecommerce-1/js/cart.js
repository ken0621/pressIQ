var cart = new cart();
var ajax_quantity = {abort: function () {}};

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
			var key = $(event.currentTarget).attr("key");
			
			action_qty_control("+", $(event.currentTarget).attr("variation-id"), key)
		})

		$('.qty-control-minus').unbind("click");
		$('.qty-control-minus').bind("click", function(event) 
		{
			event.preventDefault();
			var key = $(event.currentTarget).attr("key");
			
			action_qty_control("-", $(event.currentTarget).attr("variation-id"), key);
		})
	}
	function action_qty_control(sign, id, key)
	{
		var current = parseInt($('.qty-control[variation-id="'+id+'"]').val());
		var price = parseInt($('.upc span[key="'+key+'"]').attr('raw-price'));

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

		$('.ttl span[key="'+key+'"]').html((price * quantity).toFixed(2));

		total_price = 0;

		$('.upc span').each(function(index, el) 
		{
			total_price += parseInt($(el).attr("raw-price")) * parseInt($('.qty-control[variation-id="'+$(el).attr('key')+'"]').val());
		});

		$('.subtotal-value span').html(parseInt(total_price).toFixed(2));

		ajax_quantity.abort();

		ajax_quantity = $.ajax({
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