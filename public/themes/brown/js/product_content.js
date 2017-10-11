var product_content = new product_content();

function product_content()
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
    		action_product_zoom();
    	});
	}

	function action_product_zoom()
	{
		$('.img-holder .img').elevateZoom();
	}
}