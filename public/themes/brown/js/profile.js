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
			$(".reward-configuration-form").find("button[type=submit]").html("<i class='fa fa-spinner fa-pulse fa-fw'></i> Update");

			var form_data = $(".reward-configuration-form").serialize();

			$.ajax(
			{
				url:"/members/profile-update-reward",
				dataType:"json",
				data: form_data,
				type: "post",
				success: function(data)
				{
					if(data == "success")
					{
						$(".contact_info_success_message").removeClass("hidden");
					}
				},
				complete: function(data)
				{
					$(".reward-configuration-form").find("button[type=submit]").html("<i class='fa fa-save'></i> Update");
				}
			})

			return false;
		});
	}
}
