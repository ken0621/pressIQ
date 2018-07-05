var product_code = new product_code();
var load_table_data = {};
var idList = [];

function product_code()
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
		event_load_search();
		add_event_pagination();
		select_all();
		select();
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
			url:"/member/mlm/product_code2/table",
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
	function event_load_search()
	{
		$('.search-keyword').unbind("change");
		$('.search-keyword').bind("change", function(e)
		{
			action_filter_membership_kit(e.currentTarget);
		});
	}
	function action_filter_membership_kit(self)
	{
		var search = $(self).val();

		load_table_data.search_keyword = search;
	    load_table_data.page = 1;
	    action_load_table();
	}
	
}
function click_status(status)
{
	load_table_data.status = status;
    load_table_data.page = 1;
    $('.change-tab').removeClass('active');
    $('.'+status+'-tab').addClass('active');
    product_code.action_load_table();
}
function success_change_status(data)
{
	if(data.status)
	{
        toastr.success('Success');
        data.element.modal("hide");
        product_code.action_load_table();		
	}	
}

function select_all()
{
    $(".codes_container").on("click", "#select-all", function(e)
    {   
        $('.select-id').each(function(index, el) 
        {
        	if($(e.currentTarget).is(':checked'))
        	{
        		if (!$(el).is(':checked')) 
        		{
        			$(el).trigger('click');
        		}
        	}
        	else
        	{
        		if ($(el).is(':checked')) 
        		{
        			$(el).trigger('click');
        		}
        	}
        });
        
    }); 
}

function select()
{
	$(".codes_container").on("click", "#select-id", function(e)
    {
    	if(this.checked)
    	{
    		idList.push($(this).val());
    	}
    	else
    	{

    		var index = idList.indexOf($(this).val());

			if (index !== -1) 
			{
				idList.splice(index, 1);
			}
    	}
    });
    
}

function tag_as_printed()
{
	console.log(idList);
	
		$.ajax({
			url: '/member/mlm/product_code2/table/set',
			type: 'get',
			data: {printed: idList},
			success:function(data)
			{

			}
		})
		// $.ajax({
		// 	url: '/path/to/file',
		// 	type: 'default GET (Other values: POST)',
		// 	dataType: 'default: Intelligent Guess (Other values: xml, json, script, or html)',
		// 	data: {param1: 'value1'},
		// })
		// .done(function() {
		// 	console.log("success");
		// })
		// .fail(function() {
		// 	console.log("error");
		// })
		// .always(function() {
		// 	console.log("complete");
		// });
		
	
}


