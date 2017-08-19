var pos = new pos()
var load_item = null;
var item_search_delay_timer;
var keysearch = {};
function pos()
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
		action_load_item_table();
		event_search_item();
	}
	function event_search_item()
	{
		$(".event_search_item").keyup(function(e)
		{
			/* SCAN ITEM */
			if(e.which == 13)
			{
				action_scan_item($(".event_search_item").val());
				action_hide_search();
			}
			else /* SEARCH MODE */
			{
				if($(".event_search_item").val() == "")
				{
					action_hide_search();
				}
				else
				{
					keysearch.item_keyword = $(".event_search_item").val();
					keysearch._token = $(".token").val();
					if(load_item)
					{
						load_item.abort();
					}

					clearTimeout(item_search_delay_timer);

				    item_search_delay_timer = setTimeout(function()
				    {
				       $(".pos-search-container").html(get_loader_html(10)).show();
				       action_ajax_search_item();
				    }, 500);
				}
			}
		});

		$(".event_search_item").focusout(function()
		{
			action_hide_search();
		})
	}
	function action_scan_item($item_id)
	{
		$(".event_search_item").val("");
		$(".event_search_item").attr("disabled", "disabled");
		$(".button-scan").find(".scan-load").show();
		$(".button-scan").find(".scan-icon").hide();

 		$.ajax(
		{
			url:"/member/cashier/pos/scan_item",
			type:"post",
			data: scandata,
			success: function(data)
			{
				$(".event_search_item").removeAttr("disabled");
				$(".button-scan").find(".scan-load").hide();
				$(".button-scan").find(".scan-icon").show();
			}
		});
	}
	function action_ajax_search_item()
	{
		load_item = $.ajax(
		{
			url:"/member/cashier/pos/search_item",
			type:"post",
			data: keysearch,
			success: function(data)
			{
				$(".pos-search-container").html(data);
			}
		});
	}
	function action_hide_search()
	{
		$(".pos-search-container").hide();
		clearTimeout(item_search_delay_timer);
	}

	function action_load_item_table()
	{
		$(".load-item-table-pos").html(get_loader_html());
		$(".load-item-table-pos").load("/member/cashier/pos/table_item", function()
		{
			action_update_big_totals();
		});
	}
	function action_update_big_totals()
	{
		$(".big-total").find(".grand-total").text($(".table-grand-total").val());
		$(".big-total").find(".amount-due").text($(".table-amount-due").val());
	}
	function get_loader_html($padding = 50)
	{
		return '<div style="padding: ' + $padding + 'px; font-size: 20px;" class="text-center"><i class="fa fa-spinner fa-pulse fa-fw"></i></div>';
	}
}