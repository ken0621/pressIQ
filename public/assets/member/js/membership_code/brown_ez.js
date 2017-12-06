var ez_program = new ez_program();
function ez_program()
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
		check_ez_box();
		toggle_ez_box();
		on_change_balance();
	}

	function check_ez_box()
	{
		$("#ez_program").change(function()
		{
			toggle_ez_box();
		});
	}

	function toggle_ez_box()
	{
		if($('#ez_program').is(":checked"))
		{
			$(".ez_program_input").show();
		}
		else
		{
			$(".ez_program_input").hide();
		}
	}

	function on_change_balance()
	{
		$("#cd_price").keyup(function()
		{
			toggle_change_balance();
		});

		$("#cd_price").change(function()
		{
			toggle_change_balance();
		});
	}

	function toggle_change_balance()
	{
    	var paid_price = $("#paid_price_no_change").val();
    	var balance    = $("#cd_price").val();

    	var totality   = parseFloat(paid_price) - (isNaN(parseFloat(balance)) ? 0 : parseFloat(balance));
    	totality       = isNaN(parseFloat(totality)) ? 0 : totality;
        $("#paid_price").val(totality);
	}
}
