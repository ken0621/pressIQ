var transaction_list = new transaction_list();
var load_table_data = {};

function transaction_list()
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
		event_initialize_select();
		event_load_search();
		action_onload_view_receipt();
		event_filter_date();
	}
	function action_onload_view_receipt()
	{
		if($('.view-receipt').val() != '')
		{			
            action_load_link_to_modal('/member/cashier/transactions/view_item/'+$('.view-receipt').val(), 'md');
		}
	}
	function event_initialize_select()
	{
		$('.filter-type').globalDropList({
			hasPopup : 'false',
			width: "100%",
			placeholder: "Select Transaction Type",
			onChangeValue: function()
			{
				if(this.val() != '')
				{
					action_filter_type(this);
				}
			}
		});
	}
	function event_load_search()
	{
		$('.search-keyword').unbind("change");
		$('.search-keyword').bind("change", function(e)
		{
			action_filter_all_transaction(e.currentTarget);
		});
	}
	function action_filter_all_transaction(self)
	{
		var search = $(self).val();

		load_table_data.search_keyword = search;
	    load_table_data.page = 1;
	    action_load_table();
	}
	function action_filter_type(self)
	{
		var transaction_type = $(self).val();

		load_table_data.transaction_type = transaction_type;
	    load_table_data.page = 1;
	    action_load_table();
	}
	function action_filter_date(from, to)
	{
		load_table_data.from_date = from;
		load_table_data.to_date = to;
	    load_table_data.page = 1;
	    action_load_table();

	    $('#filter-date-modal').modal('hide');
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
			url:"/member/cashier/transactions_list/table",
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

	function event_filter_date()
	{
		$('.filter-date-form').submit(function(event) 
		{
			event.preventDefault();
			event.stopPropagation();

			action_filter_date($('.filter-date-form').find('input[name="from_date"]').val(), $('.filter-date-form').find('input[name="to_date"]').val())
		});
	}
}
function click_status(status)
{
	load_table_data.status = status;
    load_table_data.page = 1;

    $('.change-tab').removeClass('active');
    $('.'+status+'-tab').addClass('active');

    membership_code.action_load_table();
}