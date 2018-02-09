var receive_payment = new receive_payment();
var maximum_payment = 0;
var is_amount_receive_modified = false;

function receive_payment()
{
	init();

	function init()
	{
		document_ready();
	}

	function document_ready()
	{
		event_line_check_change();
		event_payment_amount_change();
		event_received_amount_change();
		event_button_action_click();

		action_initialize_load();
	}

	this.action_initialize_load = function()
	{
		action_initialize_load();
	}

	function action_initialize_load()
	{
		initialize_select_plugin();
		$(".datepicker").datepicker();
		$(".amount-payment").change();
	}

	function initialize_select_plugin()
	{
		$(".drop-down-customer").globalDropList(
		{
		    link 		: '/member/customer/modalcreatecustomer',
		    link_size 	: 'lg',
		    width 		: "100%",
		    placeholder : 'Customer',
		    onChangeValue: function()
		    {
		    	var customer_id = $(this).val();
		    	$('.salesrep_id').val($(this).find('option:selected').attr('salesrep_id'));
		    	$('.salesrep').val($(this).find('option:selected').attr('salesrep'));
		    	var check = $(".for-tablet-only").html();
		    	if(check == null || check == "")
		    	{
			    	$(".tbody-item").load("/member/customer/load_rp/"+ (customer_id != '' ? customer_id : 0), function()
			    	{
			    		action_compute_maximum_amount();
			    	})		    		
		    	}
		    	else
	    		{
			    	$(".tbody-item").load("/tablet/customer/load_rp/"+ (customer_id != '' ? customer_id : 0), function()
			    	{
			    		action_compute_maximum_amount();
			    	})		    		
	    		}
	    		action_load_open_transaction(customer_id);
		    }
		});

		$(".drop-down-payment").globalDropList(
		{
		    link 		: '/member/maintenance/payment_method/add',
		    link_size 	: 'sm',
		    width 		: "100%",
		    placeholder : 'Payment Method'
		});

		$(".drop-down-coa").globalDropList(
		{
		    link 		: '/member/accounting/chart_of_account/popup/add',
		    link_size 	: 'md',
		    width 		: "100%",
		    placeholder : 'Account'
		});
	}

	function action_load_open_transaction($customer_id)
	{
		if($customer_id)
		{
			$.ajax({
				url : '/member/transaction/receive_payment/count-transaction',
				type : 'get',
				data : {customer_id : $customer_id},
				success : function(data)
				{
					$(".open-transaction").slideDown();
					$(".popup-link-open-transaction").attr('link','/member/transaction/receive_payment/load-credit?c='+$customer_id);
					$(".count-open-transaction").html(data);
				}
			});
		}
		else
		{
			$(".open-transaction").slideUp();
		}
	}

	/* CHECK BOX FOR LINE ITEM */
	function event_line_check_change()
	{
		$(document).on("change", ".line-checked", function()
		{
			action_change_input_value($(this));
		});
	}
	function action_change_input_value($this)
	{
		if($this.is(":checked"))
		{
			$this.prev().val(1);
			var balance = $this.parents("tr").find(".balance-due").val();
			if(!formatFloat($this.parents("tr").find(".amount-payment").val()) > 0)
			{
				$this.parents("tr").find(".amount-payment").val(balance).change();
			}
		}
		else
		{
			$this.prev().val(0);
			if(formatFloat($this.parents("tr").find(".amount-payment").val()) > 0)
			$this.parents("tr").find(".amount-payment").val('').change();
		}
	}

	function action_compute_maximum_amount()
	{
		$(".balance-due").each(function()
		{
			maximum_payment += formatFloat($(this).val());
		})
	}

	function event_received_amount_change()
	{
		$(document).on("change", ".amount-received", function()
		{
			$(this).val(formatMoney_2($(this).val()));

			var amount_receive = formatFloat($(this).val());
			var amount_applied = formatFloat(action_total_amount_apply());

			if( amount_receive > amount_applied)
			{
				console.log("true");
				action_update_credit_amount(amount_receive - amount_applied);
			}
			else
			{
				action_update_credit_amount(0)
			}
		})

		$(document).on("keydown", ".amount-received", function()
		{
			is_amount_receive_modified = true;
		})
	}

	function action_update_apply_amount($amount)
	{
		$(".amount-to-apply").val($amount);
		$(".amount-apply").html("PHP "+formatMoney_2($amount))
	}

	function action_update_credit_amount($amount)
	{
		$(".amount-to-credit").val($amount);
		$(".amount-credit").html("PHP "+formatMoney_2($amount))
	}

	function event_payment_amount_change()
	{
		$(document).on("change",".amount-payment", function(e)
		{
			$(this).val(formatFloat($(this).val()) == 0 ? '' : formatMoney($(this).val()));

			!is_amount_receive_modified ? $(".amount-received").val(action_total_amount_apply()).change() : $(".amount-received").change();
			action_update_apply_amount(action_total_amount_apply());

			// check - uncheck checkbox
			if(formatFloat($(this).val()) > 0)
			{
				$(this).parents("tr").find(".line-checked").prop("checked", true).change();
			}
			else
			{
				$(this).parents("tr").find(".line-checked").prop("checked", false).change();
			}

			// validation for exceeding balace
			if(formatFloat($(this).val()) > formatFloat($(this).parents("tr").find(".balance-due").val()) )
			{
				this.setCustomValidity("You may not pay more than the balance due");
    			return false;
			}
			else
			{
				this.setCustomValidity("");
    			return true;
			}
		})
	}

	function action_total_amount_apply()
	{
		var line_payment_amount = 0;
		$(".amount-payment").each(function()
		{
			line_payment_amount += formatFloat($(this).val());
		})
		return formatMoney(line_payment_amount);
	}

	function formatFloat($this)
	{
		return Number($this.toString().replace(/[^0-9\.]+/g,""));
	}

	function formatMoney_2($this)
	{
		var n = formatFloat($this), 
	    c = isNaN(c = Math.abs(c)) ? 2 : c, 
	    d = d == undefined ? "." : d, 
	    t = t == undefined ? "," : t, 
	    s = n < 0 ? "-" : "", 
	    i = String(parseInt(n = Math.abs(Number(n) || 0).toFixed(c))), 
	    j = (j = i.length) > 3 ? j % 3 : 0;
	   return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
	}
	function formatMoney($this)
	{
		var n = formatFloat($this), 
	    c = isNaN(c = Math.abs(c)) ? 2 : c, 
	    d = d == undefined ? "." : d, 
	    t = t == undefined ? "," : t, 
	    s = n < 0 ? "-" : "", 
	    i = String(parseInt(n = Math.abs(Number(n) || 0).toFixed(c))), 
	    j = (j = i.length) > 3 ? j % 3 : 0;
	   return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
	}

	function event_button_action_click()
	{
		$(document).on("click","button[type='submit']", function()
		{
			$(".button-action").val($(this).attr("data-action"));
		})
	}

}

function success_receive_payment(data)
{
	if(data.status == 'success')
	{
		toastr.success(data.status_message);
		location.href = data.status_redirect;
	}
}


function submit_done(data)
{
	if(data.status == "success" || data.response_status == "success")
	{
		if(data.type == "payment_method")
		{
			$(".drop-down-payment").load("/member/maintenance/load_payment_method", function()
			{
				$(this).globalDropList("reload");
				$(this).val(data.payment_method_id).change();
			});
			data.element.modal("toggle");
		}
		else if(data.type == "account")
		{
			$(".drop-down-coa").load("/member/accounting/load_coa?filter[]=Bank", function()
			{
				$(this).globalDropList("reload");
				$(this).val(data.id).change();
			});
			data.element.modal("toggle");
		}
		else if(data.redirect)
        {
        	toastr.success(data.message);
        	location.href = data.redirect;
    	}
    	else
    	{
    		$(".rcvpymnt-container").load(data.url+" .rcvpymnt-container .rcvpymnt-load-data", function()
			{
				receive_payment.action_initialize_load();
				toastr.success(data.message);
			});
    	}
	}
}