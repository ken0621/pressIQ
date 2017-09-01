var item_add = new item_add();

function item_add()
{
	init();

	function init()
	{
		$(document).ready(function()
		{
			add_event_select_item_type();
			add_event_change_type();
		});
	}

	function add_event_select_item_type()
	{
		$(".tp-picker").click(function(e)
		{
			$type_id = $(e.currentTarget).attr("type_id");
			$(".item-type-picker").hide();
			$(".item-add-main").fadeIn();
			$(".modal-footer").find("button").removeAttr("disabled");
		});
	}
	function add_event_change_type()
	{
		$(".change-type").click(function(e)
		{
			$(".item-type-picker").fadeIn();
			$(".item-add-main").hide();
			$(".modal-footer").find("button").attr("disabled", "disabled");
		});
	}
}