var requisition_slip = new requisition_slip()
var load_item = null;
var item_search_delay_timer;
var settings_delay_timer;
var keysearch = {};

function requisition_slip()
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
	$('.rs-container').load('/member/transaction/requisition_slip/load-rs-table?status='+status+' .rs-table');
}
function success_confirm(data)
{
	if(data.status == 'success')
	{
		toastr.success('Success');
		location.reload();
	}
}
