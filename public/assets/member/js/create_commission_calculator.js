var create_commission_calculator = new create_commission_calculator();
var load_table_data = {};

function create_commission_calculator()
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
		action_initialize_select();
		action_load_datepicker();
	}
	function action_load_datepicker()
	{
		$('.datepicker').datepicker();
	}
	function action_initialize_select()
	{
		$('.select-customer').globalDropList({
			hasPopup : 'false',
			width : '100%',
			onChangeValue : function()
			{
				$(".customer-email").val($(this).find("option:selected").attr("email"));
			}
		});
		$('.select-property').globalDropList({
			hasPopup : 'false',
			width : '100%',
			onChangeValue : function()
			{
				$(".sales-price").val('P ' + number_format($(this).find("option:selected").attr("price")));
			}
		});
		$('.select-agent').globalDropList({
			hasPopup : 'false',
			width : '100%'
		});
	}
	function number_format(number)
	{
	    var yourNumber = (parseFloat(number)).toFixed(2);
	    //Seperates the components of the number
	    var n= yourNumber.toString().split(".");
	    //Comma-fies the first part
	    n[0] = n[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
	    //Combines the two sections
	    return (n.join("."));
	}
	function event_compute_commission()
	{
		
	}

}