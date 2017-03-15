$(document).ready(function()
{
	event_select_variation();
	event_slick();
	event_change_image();
});

function event_change_image()
{
	$(document).on('click', '.single-product-holder .thumb .holder', function(event) 
	{
		event.preventDefault();
		
		var variant_id = $(event.currentTarget).attr("variant-id");
		var key = $(event.currentTarget).attr("key");

		$('.single-product-content[variant-id="'+variant_id+'"] .single-product-img').addClass("hide");
		$('.single-product-content[variant-id="'+variant_id+'"] .single-product-img[key="'+key+'"]').removeClass("hide");

		image_crop(".4-3-ratio", 4, 3);

		$(".single-product-img").elevateZoom();
	});
}

function event_slick()
{
	$('.thumb').slick({
		infinite: true,
		slidesToShow: 4,
		slidesToScroll: 1,
		arrows: false
	});
}

function event_select_variation()
{
	var select_variation = '.select-variation';

	$("body").on('change', select_variation, function(event) 
	{
		event.preventDefault();
		action_select_variation(event);
	});
}

function action_select_variation(e)
{
	var content_holder = '.item-content';

	var selected = $(e.currentTarget).closest(content_holder).attr("variant-id");
	var product_id = $(e.currentTarget).attr("product-id");
	var variant_label = $(e.currentTarget).attr("variant-label");
	var variation = [];
	toload = true;

	var select_variation = '.select-variation[variant-id="'+selected+'"]';
	var select_variation_label = '.select-variation[variant-label="'+variant_label+'"]';

	$(select_variation).each(function(index, el) 
	{
		variation.push($(el).val());

		if ($(el).val() == 0) 
		{
			toload = false;
		}
	});

	if (toload == true) 
	{
		$('.loader').fadeIn();
	}

	$.ajax({
		url: '/product/variant/',
		type: 'GET',
		dataType: 'json',
		data: 
		{
			variation: variation,
			product_id: product_id,
		},
	})
	.done(function(data) 
	{
		if(data.result == "success")
		{
			var variant_id = data.variation.evariant_id;
			var content_holder_specific = '.item-content[variant-id="'+variant_id+'"]';
		
			$(content_holder).addClass("hide");
			$(content_holder_specific).removeClass("hide");
			$('.4-3-ratio').keepRatio({ ratio: 4/3, calculate: 'height' });
		}

		$(select_variation_label).val($(e.currentTarget).val());
		$(".loader").fadeOut();
	})
	.fail(function() 
	{
		console.log("error");
	});
}