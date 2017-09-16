var non_member = new non_member();

function non_member()
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
		add_event_enter_code_click();
		add_event_submit_verify_sponsor();
	}
	function add_event_submit_verify_sponsor()
	{
		$(".submit-verify-sponsor").submit(function(e)
		{
			if($(e.currentTarget).find(".btn-verify-sponsor").hasClass("use"))
			{
				$("#enter-a-code-modal").modal('hide');

				setTimeout(function()
				{
					$("#proceed-modal-2").modal('show');
				}, 350);
				
			}
			else
			{
				action_verify_sponsor();
			}
			
			return false;
		});
	}
	function action_verify_sponsor()
	{
		$(".submit-verify-sponsor").find(".btn-verify-sponsor").html('<i class="fa fa-spinner fa-pulse fa-fw"></i> VERIFYING SPONSOR').attr("disabled", "disabled");
		$(".submit-verify-sponsor").find("input").attr("disabled", "disabled");

		var form_data = {};
		form_data._token = $("._token").val();
		form_data.verify_sponsor = $(".input-verify-sponsor").val();

		$.ajax(
		{
			url:"/members/verify-sponsor",
			data:form_data,
			type:"post",
			success: function(data)
			{
				$(".submit-verify-sponsor").find(".output-container").html(data);
				$(".card").hide().slideDown('fast');

				if($(".card").length > 0)
				{
					$(".submit-verify-sponsor").find(".btn-verify-sponsor").html('<i class="fa fa-check"></i> USE THIS SPONSOR').removeAttr("disabled").addClass("use");
				}	
				else
				{
					$(".submit-verify-sponsor").find("input").removeAttr("disabled");
					$(".submit-verify-sponsor").find(".btn-verify-sponsor").html('<i class="fa fa-check"></i> VERIFY SPONSOR').removeAttr("disabled").removeClass("use");
				}
			}
		});
	}
	function add_event_enter_code_click()
	{
	    $("#btn-enter-a-code").click(function()
	    {
			$("#enter-a-code-modal").modal('show');
			$(".output-container").html("");

			$(".submit-verify-sponsor").find(".btn-verify-sponsor").html('<i class="fa fa-check"></i> VERIFY SPONSOR').removeClass("use").removeAttr("disabled");
			$(".submit-verify-sponsor").find("input").removeAttr("disabled").val("");
	    });
	}
}