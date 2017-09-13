var	member_register = new member_register();

function member_register()
{
	init();

	function init()
	{
		document_ready();
	}

	function document_ready()
	{
		$(document).ready(function()
		{
			event_click_agreement();
		});
	}

	function event_click_agreement()
	{
		$(".agreement-checkbox input:checkbox").unbind("change");
		$(".agreement-checkbox input:checkbox").bind("change", function(e)
		{
			action_click_agreement(e);
		});
	}

	function action_click_agreement(self)
	{
		$(self.currentTarget).removeProp("checked").removeAttr("checked");
		$("#modal_agreement").modal();
	}
}