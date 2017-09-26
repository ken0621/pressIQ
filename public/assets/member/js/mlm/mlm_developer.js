var mlm_developer = new mlm_developer();
var table_key = "slot_list_test_menu";
var slot_table_data = {};

function mlm_developer()
{
	this.action_load_data = function()
	{
		action_load_table();
	}

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
		add_event_search();
	}
	function add_event_search()
	{
		$(".search-employee-name").keypress(function(e)
		{
			if(e.which == 13)
			{
				slot_table_data.page = 1;
				action_load_table();
			}
		});
	}
	function add_event_pagination()
	{
		$("body").on("click", ".pagination a", function(e)
		{
			$url = $(e.currentTarget).attr("href");
			var url = new URL($url);
			$page = url.searchParams.get("page");
			slot_table_data.page = $page;
			action_load_table();
			return false;
		});
	}
	function action_load_table()
	{
		$html_test_slots = '<div class="text-center" style="padding: 180px 30px; font-size: 26px;"><i class="fa fa-spinner fa-pulse fa-fw"></i></div>';
	
		slot_table_data.search = $(".search-employee-name").val();

		$(".load-test-slots").html($html_test_slots);

		$.ajax(
		{
			url:"/member/mlm/developer/table",
			data:slot_table_data,
			success: function(data)
			{
				$(".load-test-slots").html(data);
			}
		});
	}
}
