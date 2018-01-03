var item_list = new item_list();
var load_table_data = {};

function item_list()
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
		event_archive();
		event_item_archive();
		event_filter_item_type();
		event_filter_item_category();
		event_filter_item_search();
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
			url:"/member/item/v2/table",
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
	function event_archive()
	{
		$('.go-default').unbind("click");
	    $('.go-default').bind("click", function(e)
	    {
	        action_archive(0, e.currentTarget);
	    });

	    $('.go-archive').unbind("click");
	    $('.go-archive').bind("click", function(e)
	    {
	        action_archive(1, e.currentTarget);
	    });
	}
	function event_item_archive()
	{
		$("body").on('click', '.item-archive', function(event) 
	    {
	        event.preventDefault();
	        var item_id = $(event.currentTarget).attr("item-id");
	        action_item_archive(item_id, "archive");
	    });

	    $("body").on('click', '.item-restore', function(event) 
	    {
	        event.preventDefault();
	        var item_id = $(event.currentTarget).attr("item-id");
	        action_item_archive(item_id, "restore");
	    });
	}
	function action_archive(archive, x)
	{
	    load_table_data.archived = archive;
	    load_table_data.page = 1;
	    action_load_table(); 
	    $('.nav-tabs li').removeClass('active'); 
	    $(x).parent().addClass('active');
	}
	function action_item_archive(item_id, action)
	{
	    $.ajax({
	        url: '/member/item/v2/'+action,
	        type: 'GET',
	        dataType: 'json',
	        data: {
	            item_id: item_id
	        },
	    })
	    .done(function() {
	        action_load_table(); 
	    })
	    .fail(function() {
	        console.log("error");
	    })
	    .always(function() {
	        console.log("complete");
	    });
	}
	function event_filter_item_type()
	{
		$('.filter-item-type').globalDropList(
		{
			hasPopup: "false",
			width: "100%",
			placeholder: "All Item Type",
			onChangeValue: function()
			{
				action_filter_item_type(this);
			}
		});
	}
	function action_filter_item_type(self)
	{
		var item_type_id = $(self).val();

		load_table_data.item_type_id = item_type_id;
	    load_table_data.page = 1;
	    action_load_table();
	}
	function event_filter_item_category()
	{
		$('.category-select').globalDropList(
		{
			hasPopup: "false",
			width: "100%",
			placeholder: "All Category",
			onChangeValue: function()
			{
				action_filter_item_category(this);
			}
		});
	}
	function action_filter_item_category(self)
	{
		var item_category_id = $(self).val();

		load_table_data.item_category_id = item_category_id;
	    load_table_data.page = 1;
	    action_load_table();
	}
	function event_filter_item_search()
	{
		$('.search-item-list').unbind("change");
		$('.search-item-list').bind("change", function(e)
		{
			action_filter_item_search(e.currentTarget);
		});
	}
	function action_filter_item_search(self)
	{
		var search = $(self).val();

		load_table_data.search = search;
	    load_table_data.page = 1;
	    action_load_table();
	}
}
function success_refill(data)
{
	if(data.status == 'success')
	{
        toastr.success("Success refilling item");
        data.element.modal("hide");
        item_list.action_load_table();
	}
}

function success_item(data)
{
	if(data.status == 'success')
	{
        toastr.success(data.message);
        data.element.modal("hide");
        item_list.action_load_table();
	}
}