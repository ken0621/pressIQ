var rr = new rr()
var load_item = null;
var item_search_delay_timer;
var settings_delay_timer;
var keysearch = {};

function rr()
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

	}
}
function success_code(data)
{
	if(data.status == 'success')
	{
		toastr.success('Success');
		location.href = '/member/item/warehouse/rr/receive-inventory';
		/*toastr.success('Success');
		setInterval(function()
		{
			location.href = '/member/item/warehouse/rr/receive-inventory';
		},2000);*/
	}
}