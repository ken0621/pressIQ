var cashier_settings = new cashier_settings();
var code_generate_delay;
var original_item_code;


var append = '<tr class="append"><td class="remove-payment"><i class="fa fa-times remove-payment"></i><input type="hidden" value="0" name="payment_type_id[]"></td><td><input type="text" class="form-control text-right" placeholder="Payment Type Name" value="" name="payment_type_name[]"></td></tr>';
			
function cashier_settings()
{
	init();

	function init()
	{
		$(document).ready(function()
		{
			remove_new_payment_type();
			add_new_payment_type();
			add_event_click_save();
		});
	}

	function add_new_payment_type()
	{
		$('body').on('click','#add_payment',function()
		{
			$('tr.append:last-child').after(append);
		});
	}

	function remove_new_payment_type()
	{
		$('body').on('click','.remove-payment',function()
		{
			$(this).closest('tr').remove();
		});
	}

	function add_event_click_save()
	{
		$('.add-submit-button').unbind("click");
		$('.add-submit-button').bind("click", function()
		{
			$('.remove-this-type').remove();
			$('#form_submit').submit();
		});
	}	
}

