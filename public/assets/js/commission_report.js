var commission_report = new commission_report();

function commission_report()
{
	init();

	this.action_load_table = function()
	{
		action_load_table();
	}

	function init()
	{
		$(document).ready(function()
		{
			document_ready();
		});
	}
	function document_ready()
	{
		event_change_warehouse();
		action_load_table();
	}
	function event_change_warehouse()
    {
        $('.select_current_warehouse').change(function()
        {
            action_change_warehouse();
        });
    }
    function action_change_warehouse()
    {
        var currentWarehouse = $('.select_current_warehouse').val();
        $('.commission-percentage').attr('disabled',true);
        $.ajax(
        {
            url: '/member/merchant/commission-report/getpercentage',
            type: 'get',
            data: 'warehouse_id='+currentWarehouse,
            success: function(data)
            {
                $('.commission-percentage').val(data);
                $('.commission-percentage').removeAttr('disabled');
                action_load_table();
            }
        });
    }
    function action_table_loader()
	{
		$(".load-table-here").html('<div style="padding: 100px; text-align: center; font-size: 20px;"><i class="fa fa-spinner fa-pulse fa-fw"></i></div>');
	}
	function action_load_table()
	{
		var currentWarehouse = $('.select_current_warehouse').val(); 
		action_table_loader();
		$.ajax(
		{
			url: '/member/merchant/commission_report/table',
			data: 'warehouse_id='+currentWarehouse,
			type: "get",
			success: function(data)
			{
				$('.load-table-here').html(data);
			}
		});
	}
	$(window).on('hashchange', function() {
	    if (window.location.hash) {
	        var page = window.location.hash.replace('#', '');
	        if (page == Number.NaN || page <= 0) {
	            return false;
	        } else {
	            getPosts(page);
	        }
	    }
	});
	$(document).ready(function() {
		getPosts(1);
	    $(document).on('click', '.pagination a', function (e) {
	        getPosts($(this).attr('href').split('page=')[1]);
	        e.preventDefault();
	    });
	});
	function getPosts(page) {
	    $.ajax(
	    {
	        url : '/member/merchant/commission_report/table?page=' + page,
	        type: 'get',
	    }).done(function (data) 
	    {
	        $('.load-table-here').html(data);
	        location.hash = page;
	    }).fail(function () 
	    {
	        alert('Posts could not be loaded.');
	    });
	}
}
