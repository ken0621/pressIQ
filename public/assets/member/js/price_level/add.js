var add_price_level = new add_price_level();

function add_price_level()
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
		event_price_level_checkbox_click();
		event_change_price_level_select();
		action_change_price_level_select();
		event_check_all_item_click();
	}
	function event_change_price_level_select()
	{
		$(".select-type-of-price-level").change(function(e)
		{
			action_change_price_level_select()
		});
	}
	function action_change_price_level_select()
	{
		$price_level_type = $(".select-type-of-price-level").val();

		$(".price-level-container").hide();
		$(".price-level-container[leveltype=" + $price_level_type + "]").show();
	}
	function event_price_level_checkbox_click()
	{
		$(".price-level-check-event").click(function(e)
		{
			action_price_level_checkbox_click(e);
		});
	}
	function action_price_level_checkbox_click(e)
	{
		if(!$(e.target).is('.checkboxs'))
		{
			$(e.currentTarget).closest("tr").find(".checkboxs").trigger("click");
		}
	}
	function event_check_all_item_click()
	{
		$(".check-all-item").click(function(e)
		{
			action_check_all_item_click(e);
		});
	}
	function action_check_all_item_click(e)
	{
		if(!$(e.target).is('.checkbox-all'))
		{
			$(".checkbox-all").trigger("click");
		}

		if($(".checkbox-all").is(":checked"))
		{
			$(".checkboxs").each(function() 
			{
			    if(!$(this).is(":checked"))
			    {
			    	$(this).trigger("click");
			    }
			});
		}
		else
		{
			$(".checkboxs").each(function() 
			{
			    if($(this).is(":checked"))
			    {
			    	$(this).trigger("click");
			    }
			});
		}
	}

}