var modal_create_payslip = new modal_create_payslip();

function modal_create_payslip()
{
	init();

	function init()
	{
		payslip_action();
		include_header_action();
		time_summary();
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

		$(".company-position").unbind("click");
		$(".company-position").bind("click", function()
		{
			var target = $(this).data("target");
			$(".company-logo").addClass("display-none");
			$(target).removeClass("display-none");
			$(".company-position").removeClass("active");
			$(this).addClass("active");
		});

		$(".include-header").unbind('change');
		$(".include-header").bind('change', function()
		{
			include_header_action();
		});


		$(".time-summary").unbind('change');
		$(".time-summary").bind('change', function()
		{
			time_summary();
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

	function include_header_action()
	{
		$(".include-header").each(function()
		{
			var  target = $(this).data("target");
			if($(this).is(':checked'))
			{
				if($(target).hasClass('display-none'))
				{
					$(target).removeClass('display-none');
				}
			}
			else
			{
				$(target).addClass('display-none');
			}
		});
	}


	function time_summary()
	{
		var time = $(".time-summary");

		if(time.is(':checked'))
		{
			if($(".computaion-field").hasClass('col-md-12'))
			{
				$(".computaion-field").removeClass('col-md-12');
				
			}

			if($(".time-summary-field").hasClass('display-none'))
			{
				$(".time-summary-field").removeClass('display-none');
			}

			$(".computaion-field").addClass('col-md-6');
		}
		else
		{
			if($(".computaion-field").hasClass('col-md-6'))
			{
				$(".computaion-field").removeClass('col-md-6');
				
			}
			
			$(".time-summary-field").addClass('display-none');
			$(".computaion-field").addClass('col-md-12');
		}

	}

}