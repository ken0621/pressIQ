var online_payment 	= new online_payment();

function online_payment()
{
	init();

	function init()
	{
		$(document).ready( function()
		{
			document_ready();
		})
	}

	function document_ready()
	{
		initialize_select_plugin();

		event_add_other_click();
		event_other_container_hide();
		event_view_other_click();
	}

	this.initialize_select_plugin = function()
	{
		initialize_select_plugin();
	}

	function initialize_select_plugin()
	{
		console.log("hello");
		$(".select-gateway").globalDropList(
		{
			hasPopup	: "false",
			width		: "100%",
			onChangeValue: function()
			{
				console.log($(this).find("option:selected").attr("reference-name"));
				$(this).closest(".select-container").find(".link-reference-name").val($(this).find("option:selected").attr("reference-name"));
			}
		})
	}
	
	function event_add_other_click()
	{
		$(document).on("click", ".add-other", function()
		{
			$(".other-container").load('/member/maintenance/online_payment/other-info').slideDown();
		})
		
	}

	function event_view_other_click()
	{
		$(document).on("click",".view-other", function()
		{
			var other_id = $(this).attr("data-id");
			$(".other-container").load('/member/maintenance/online_payment/other-info/?id='+other_id).slideDown();
		})
	}

	this.action_other_container_hide = function()
	{
		action_other_container_hide();
	}

	function event_other_container_hide()
	{
		$(document).on("click",".other-hide", function()
		{
			action_other_container_hide();
		})
	}

	function action_other_container_hide()
	{
		$(".other-container").slideUp();
	}
	
}

function submit_done(data)
{
	if(data.status == "success")
	{
		if(data.type == "api")
		{
			console.log("api")
		}
		else if(data.type == "other")
		{
			console.log("other");
			online_payment.action_other_container_hide();
			$(".other-load-data").load("/member/maintenance/online_payment .other-load");
			
		}
		else if(data.type == "payment_method")
		{
			data.element.modal("hide");
			$(".method-list-load-data").load("/member/maintenance/online_payment .method-list-data");
		}

		$(".method-load-data").load("/member/maintenance/online_payment .method-data", function()
		{
			online_payment.initialize_select_plugin();
			toastr.success('Success');
		});
		
	}
}

function submit_selected_image_done(data) 
{ 
    var image_path = data.image_data[0].image_path;
    var key = data.akey;

    $('.img-src[key="'+key+'"]').attr('src', image_path);
    $('.image-value[key="'+key+'"]').val(data.image_data[0].image_id);
}