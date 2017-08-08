var mlm_developer = new mlm_developer();

function mlm_developer()
{
	this.action_load_data = function()
	{
		action_load_data();
	}

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
		action_load_data();
		event_pagination_clicked();
	}
	function event_pagination_clicked()
	{
		$("body").on("click", ".pagination a", function(e)
		{
			action_load_data($(e.currentTarget).attr("href"));
			e.preventDefault();
		});
	}
	function action_load_data(link = "/member/mlm/developer/table")
	{
		$html_test_slots = '<div class="text-center" style="padding: 50px 100px; font-size: 20px;"><i class="fa fa-spinner fa-pulse fa-fw"></i></div>';
		$(".load-test-slots").html($html_test_slots);
		$(".load-test-slots").load(link);
	}
}
