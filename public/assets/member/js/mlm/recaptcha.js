var recaptcha = new recaptcha();

function recaptcha()
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
		action_load_table();
		event_form_submit();
	}
	function action_table_loader()
	{
		$(".load-table-here").html('<div style="padding: 100px; text-align: center; font-size: 20px;"><i class="fa fa-spinner fa-pulse fa-fw"></i></div>');
	}
	function action_load_table()
	{
		action_table_loader();
		$.ajax(
		{
			url: '/member/mlm/recaptcha/recaptcha_table',
			type: "get",
			success: function(data)
			{
				$('.load-table-here').html(data);
			}
		});
	}
}