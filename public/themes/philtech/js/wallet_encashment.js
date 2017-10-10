var encashment = new encashment();

function encashment()
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
		event_request_payout_clicked();
	}
	function event_request_payout_clicked()
	{
		$(".request-payout").click(function()
		{
			action_request_payout_clicked();
		});
	}
	function action_request_payout_clicked()
	{
		action_load_link_to_modal("/members/wallet-encashment-modal", "md");
	}
}