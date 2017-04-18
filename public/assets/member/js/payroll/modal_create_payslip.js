var modal_create_payslip = new modal_create_payslip();

function modal_create_payslip()
{
	init();

	function init()
	{
		payslip_action();
		// check_orientation($(".paper-orientation").val());
		$(".payslip-container").css("width",$(".payslip-width").val()+"%");
	}	

	function payslip_action()
	{
		$(".payslip-width").unbind("change");
		$(".payslip-width").bind("change", function()
		{
			var width = $(this).val();
			$(".payslip-container").css("width",width+"%");
		});

		$(".paper-orientation").unbind("change");
		$(".paper-orientation").bind("change", function(){
			var orientation = $(this).val();

			check_orientation(orientation);
		});
	}


	function check_orientation(orientation)
	{
		add_class = "paper-landscape";
		remove_class = "paper-portrait";

		if(orientation == "Portrait")
		{
			add_class = "paper-portrait";
			remove_class = "paper-landscape";
		}

		$(".payslip-div").removeClass(remove_class);
		$(".payslip-div").addClass(add_class);
	}
}