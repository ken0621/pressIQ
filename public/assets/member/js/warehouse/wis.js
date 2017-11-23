var wis = new wis()
var load_item = null;
var item_search_delay_timer;
var settings_delay_timer;
var keysearch = {};

function wis()
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
function change_status(status)
{
	$('.wis-container').load('/member/item/warehouse/wis/load-wis-table?status='+status+' .wis-table');
}
function success_confirm(data)
{
	if(data.status == 'success')
	{
		toastr.success('Success');
		setInterval(function()
		{
			location.reload();
		},2000);
	}
}
