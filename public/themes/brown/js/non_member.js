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
		add_event_submit_verify_code();
		add_event_process_slot_creation();
	}
	function add_event_process_slot_creation()
	{
		$("body").on("click", ".process-slot-creation", function()
		{
			var form_data = {};
			form_data._token = $("._token").val();

			$(".process-slot-creation").html('<i class="fa fa-spinner fa-pulse fa-fw"></i> Processing');

			$.ajax(
			{
				url:"/members/final-verify",
				dataType:"json",
				type:"post",
				data: form_data,
				success: function(data)
				{
					if(data == "success")
					{
						$("#proceed-modal-1").modal('hide');
						window.location.reload();
					}
					else
					{
						alert(data);
						window.location.reload();
					}
				}
			});
		});
	}
	function add_event_submit_verify_code()
	{
		$(".code-verification-form").submit(function()
		{
			action_verify_code();
			return false;
		});
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
	function action_verify_code()
	{
		var form_data = {};
		form_data._token = $("._token").val();
		form_data.pin = $(".input-pin").val();
		form_data.activation = $(".input-activation").val();

		/* START LOADING AND DISABLE FORM */
		$(".code-verification-form").find(".btn-proceed-2").html('<i class="fa fa-spinner fa-pulse fa-fw"></i> VERIFYING').attr("disabled", "disabled");
		$(".code-verification-form").find("select").attr("disabled", "disabled");

		$.ajax(
		{
			url:"/members/verify-code",
			data:form_data,
			type:"post",
			success: function(data)
			{
				$(".message-return-code-verify").html(data);
				$(".code-verification-form").find(".btn-proceed-2").html('<i class="fa fa-angle-double-right"></i> PROCEED').removeAttr("disabled");

				if(data == "")
				{
					$(".code-verification-form").find("input").val("");
					$("#proceed-modal-2").modal('hide');
					setTimeout(function()
					{
						$("#proceed-modal-1").modal('show');
						$("#proceed-modal-1").find(".load-final-verification").html('<div class="loading text-center" style="padding: 150px;"><i class="fa fa-spinner fa-pulse fa-fw fa-3x"></i></div>');
						$(".load-final-verification").load("/members/final-verify");
					}, 350);
				}
			},
			error: function(data)
			{
				alert("An ERROR occurred. Please contact administrator.");
				$(".code-verification-form").find(".btn-proceed-2").html('<i class="fa fa-angle-double-right"></i> PROCEED').removeAttr("disabled");
			}
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
			},
			error: function()
			{
				alert("An ERROR occurred. Please contact administrator.");
				$(".submit-verify-sponsor").find("input").removeAttr("disabled");
				$(".submit-verify-sponsor").find(".btn-verify-sponsor").html('<i class="fa fa-check"></i> VERIFY SPONSOR').removeAttr("disabled").removeClass("use");
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