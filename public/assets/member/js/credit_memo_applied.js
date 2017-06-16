var credit_memo_applied = new credit_memo_applied();

function credit_memo_applied()
{
	init();

	function init()
	{
		document_ready();
	}

	function document_ready()
	{
		action_click_button();
	}


	function action_click_button()
	{

		$(".line-checked").click( function()
		{
			$(".amount-payment").val('');
			$parent = $(this).closest(".tr-inv-cm");
			// $balance = $parent.find(".balance-due").attr("data-content");
			// $parse_total = action_compute_total();
			// $rem = $parse_total - $balance;
			// if($rem >= 0)
			// {
			// 	$(".remaining-credit").html("PHP "+ $rem);
			// }
			$parent.find(".amount-payment").val($(".amount-to-credit").val());
			action_compute_total();
		})
		
	}
	function action_compute_total()
	{
		var $total = 0;
		$(".tr-inv-cm").each(function()
		{
			$amount = parseFloat($(this).find(".compute-amt-p").val());
			$total += $amount;
		});
		console.log($total);
		$(".amount-applied-total").html($total);
	}
}

function submit_done(data)
{
	if(data.status == "success")
	{
    	toastr.success("Success");
    	location.href = data.redirect_to;
	}
}