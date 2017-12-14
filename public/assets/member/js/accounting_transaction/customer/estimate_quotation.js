var estimate_quotation = new estimate_quotation();

function estimate_quotation()
{
	init();

	function init()
	{
		action_load_initialize_select();
	}
	function action_load_initialize_select()
	{
		$('.droplist-customer').globalDropList(
		{
			width : "100%",
    		placeholder : "Select Customer...",
			link : "/member/customer/modalcreatecustomer",
			onChangeValue: function()
			{				
				$(".customer-email").val($(this).find("option:selected").attr("email"));
				$(".customer-billing-address").val($(this).find("option:selected").attr("billing-address"));
			}
		});
	}
}
function success_update_customer(data)
{
	$(".droplist-customer").load("/member/customer/load_customer", function()
    {                
        $(".droplist-customer").globalDropList("reload");
        $(".droplist-customer").val(data.id).change();

    	data.element.modal("hide");
    });
}