var commission_report = new commission_report();

function commission_report()
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
		event_change_warehouse();
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
            }
        });
    }
}
