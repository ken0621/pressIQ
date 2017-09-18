var profile = new profile();
function profile()
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
		add_event_reward_conf_save();
	}
	function add_event_reward_conf_save()
	{
		$(".reward-configuration-form").submit(function()
		{
			
			return false;
		});
	}
}
