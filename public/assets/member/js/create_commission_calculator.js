var create_commission_calculator = new create_commission_calculator();
var load_table_data = {};

var agent_commission_percent = 0;
var dp_string = 0;
var downpayment = 0;
var tax = 1.12;
var tsp = 0;
var discount = 0;
var total_commission = 0;
var payment_term = 1;
var misc_string = 0;
var misc = 0;

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
		event_compute_all();
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
		$('.select-term').globalDropList({
			hasPopup : 'false',
			width : '100%',
			onChangeValue : function()
			{
				payment_term = $(this).val();
				event_compute_commission();
			}
		});
		$('.select-property').globalDropList({
			hasPopup : 'false',
			width : '100%',
			onChangeValue : function()
			{
				if($(this).val() != '')
				{
					$(".sales-price").val(number_format($(this).find("option:selected").attr("price")));
					tsp = parseFloat($(this).find("option:selected").attr("price"));
					event_compute_commission();
				}
				else
				{
					$(".sales-price").val('');	
					tsp = 0;
				}
			}
		});
		$('.select-agent').globalDropList({
			hasPopup : 'false',
			width : '100%',
			onChangeValue : function()
			{
				if($(this).val() != '')
				{
					agent_commission_percent = parseFloat($(this).find("option:selected").attr('commission-percent')) / 100;
					event_compute_commission();
				}
				else
				{
					agent_commission_percent = 0;
				}
			}
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
	function event_compute_all()
	{
		$('.compute-all').unbind('keyup');
		$('.compute-all').bind('keyup', function()
		{
			event_compute_commission();
		});
	}
	function event_compute_commission()
	{
		dp_string = $('.downpayment').val();
		downpayment = 0;
		discount = parseFloat(($('.discount').val()).replace(',',''));
		if(discount == '')
		{
			discount = 0;
		}
		if(dp_string.indexOf('%') > 0)
		{
			downpayment = (parseFloat(dp_string.substring(0, dp_string.indexOf('%'))) / 100);
		}

		var amount_downpayment = tsp * downpayment;
		$('.amount-downpayment').val(number_format(amount_downpayment));
		var amount_net_downpayment = amount_downpayment - discount;
		$('.amount-net-downpayment').html('P '+ number_format(amount_net_downpayment));
		$('.amount-monthly-amort-dp').html('P '+ number_format(amount_net_downpayment / payment_term));

		misc_string = $('.misc').val();
		misc = 0;
		if(misc_string.indexOf('%') > 0)
		{
			misc = (parseFloat(misc_string.substring(0, misc_string.indexOf('%'))) / 100);
		}
		var amount_misc = tsp * misc;
		$('.amount-misc').html('P '+ number_format(amount_misc));
		var amount_loanable = tsp - amount_downpayment;
		$('.amount-loanable').html('P '+number_format(amount_loanable));
		var amount_tcp = tsp + amount_misc;
		$('.amount-tcp').html('P '+number_format(amount_tcp));
		console.log(tsp +'-'+ discount+ '/'+ tax +'*'+ agent_commission_percent +'/'+ 100);
		// var amount_tc = () / (tax * (agent_commission_percent / 100));
		var sales1 =  tsp - discount;
		var sales2 = tax * agent_commission_percent
		console.log(agent_commission_percent);
		console.log(sales1);
		console.log(sales2);
		$('.amount-tc').html('P '+ number_format(sales1/sales2));


	}
	function event_accept_number_only()
	{
		$(document).on("keypress",".number-input", function(event){
			if(event.which < 46 || event.which > 59) {
		        event.preventDefault();
		    } // prevent if not number/dot

		    if(event.which == 46 && $(this).val().indexOf('.') != -1) {
		        event.preventDefault();
		    } // prevent if already dot

		});

		$(document).on("change",".number-input", function(){
			$(this).val(function(index, value) {		 
			    var ret = '';
			    value = action_return_to_number(value);
			    if(!$(this).hasClass("txt-qty")){
			    	value = parseFloat(value);
			    	value = value.toFixed(2);
			    }
			    if(value != '' && !isNaN(value)){
			    	value = parseFloat(value);
			    	ret = action_add_comma(value).toLocaleString();
			    }

				return ret;
			  });
		});
	}
	function action_add_comma(number)
	{
		number += '';
		if(number == ''){
			return '';
		}

		else{
			return number.replace(/\B(?=(\d{3})+(?!\d))/g, ",");
		}
	}
	function action_return_to_number(number = '')
	{
		number += '';
		number = number.replace(/,/g, "");
		if(number == "" || number == null || isNaN(number)){
			number = 0;
		}
		
		return parseFloat(number);
	}


}