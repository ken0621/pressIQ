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
		add_event_info_conf_save();
		add_event_picture_conf_save();
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
	function add_event_info_conf_save()
	{
		$(".info-form").submit(function()
		{
			$(".profile_info_success_message").addClass("hidden");
			$(".profile_info_failed_message ul").empty();
			$(".profile_info_failed_message").addClass("hidden");
			$(".info-form").find("button[type=submit]").html("<i class='fa fa-spinner fa-pulse fa-fw'></i> Update");

			var form_data = $(".info-form").serialize();

			$.ajax(
			{
				url:"/members/profile-update-info",
				dataType:"json",
				data: form_data,
				type: "post",
				success: function(data)
				{
					if(data == "success")
					{
						$(".load-profile").load('/members/profile .load-profile-holder', function()
						{
							$(".info-form").find("button[type=submit]").html("<i class='fa fa-save'></i> Update");
							$(".profile_info_success_message").removeClass("hidden");
						});
					}
					else
					{
						var errors = '';

						$.each(data, function(index, val) 
						{
							errors += '<li>'+val+'</li>';
						});

						$(".profile_info_failed_message ul").append(errors);
						$(".profile_info_failed_message").removeClass("hidden");
						$(".info-form").find("button[type=submit]").html("<i class='fa fa-save'></i> Update");
					}
				}
			})

			return false;
		});
	}
	function add_event_picture_conf_save()
	{
		$(".upload-profile").change(function()
		{
			$(".tab-pane").css("opacity", "0.5");
		    readURL(this);
		}); 	
	}
	function add_action_picture_conf_save()
	{
		var upload_data = new FormData($(".upload-profile-pic")[0]);
		upload_data._token = $(".get-token").val();
		console.log(upload_data);
		$.ajax({
			url: '/members/profile-update-picture',
			data: upload_data,
			dataType: 'json',
			async: false,
			type: 'post',
			processData: false,
			contentType: false,
			success:function(response)
			{
				console.log(response);
			},
		});
	}
	function readURL(input) 
	{
	    if (input.files && input.files[0]) 
	    {
	        var reader = new FileReader();
	        
	        reader.onload = function (e) 
	        {
				var filename = $(input).val().split('\\').pop();
				console.log(filename,$('.file-name'));
				var lastIndex = filename.lastIndexOf("\\");   
				$('.file-name').text(filename);

	        	console.log(e.target);
	            $('.img-upload').attr('src', e.target.result);

	            $(".tab-pane").css("opacity", "1");

	            add_action_picture_conf_save();
	        }
	        
	        reader.readAsDataURL(input.files[0]);
	    }
	}
}
