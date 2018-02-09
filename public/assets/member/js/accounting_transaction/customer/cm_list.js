var cm_list = new cm_list();
var load_table_data = {};

function cm_list()
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
		action_load_table();
		add_event_pagination();
		event_load_search();
		action_click_tab();
	}
	function event_load_search()
	{
		$('.search-keyword').unbind("change");
		$('.search-keyword').bind("change", function(e)
		{
			action_filter_search(e.currentTarget);
		});
	}
	function action_filter_search(self)
	{
		var search = $(self).val();

		load_table_data.search_keyword = search;
	    load_table_data.page = 1;
	    action_load_table();
	}
	function add_event_pagination()
	{
		$("body").on("click", ".pagination a", function(e)
		{
			$url = $(e.currentTarget).attr("href");
			var url = new URL($url);
			$page = url.searchParams.get("page");
			load_table_data.page = $page;
			action_load_table();
			return false;
		});
	}	
	function action_click_tab()
	{
		$("body").on("click", ".change-tab", function(e)
		{
			$('.change-tab').removeClass("active");
			$('.'+$(e.currentTarget).attr("mode")+'-tab').addClass('active');
			load_table_data.tab_type = $(e.currentTarget).attr("mode");
		    load_table_data.page = 1;
		    action_load_table();
		});
	}
	function action_load_table()
	{
		if($(".load-item-table").text() == "")
		{
			$(".load-item-table").html(get_loader_html(100));
		}
		else
		{
			$(".load-item-table").css("opacity", 0.3);
		}
		$.ajax(
		{
			url:"/member/transaction/credit_memo/load-credit-memo",
			data: load_table_data,
			type: "get",
			success: function(data)
			{
				$(".load-item-table").html(data);
				$(".load-item-table").css("opacity", 1);
			}
		});
	}
	function get_loader_html($padding = 50)
	{
		return '<div style="padding: ' + $padding + 'px; font-size: 20px;" class="text-center"><i class="fa fa-spinner fa-pulse fa-fw"></i></div>';
	}

	this.action_load_table = function()
	{
		action_load_table();
	}
}