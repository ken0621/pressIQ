
var tablet_customer_invoice = new tablet_customer_invoice();
var global_tr_html = "";
var global_tablet_html = $(".tablet-div-script").html();
var item_selected = ''; 
var global_cm_tablet_html = $(".cm-tablet-div-script").html();
function tablet_customer_invoice()
{
	init();

	function init()
	{
		iniatilize_select();
		draggable_row.dragtable();

		event_accept_number_only();
		event_taxable_check_change();
		event_compute_class_change();
		event_button_action_click();
		
		action_lastclick_row();
		action_convert_number();
		action_general_compute();
		action_date_picker();
		action_click_remove();
	}
	this.action_initialized = function()
	{
		action_initialize();
	}
	function action_click_remove()
	{
		$(document).on("click", ".btn-remove", function(e){
			
				$(this).parent().parent().remove();

				action_general_compute();
		});
	}
	function action_initialize()
	{
		iniatilize_select();
		action_convert_number();
		action_date_picker();
		action_general_compute();
		draggable_row.dragtable();
	}

	this.action_lastclick_row = function()
	{
		action_lastclick_row();
	}
	this.iniatilize_select = function()
	{
		iniatilize_select();
	}
	this.action_compute_tablet = function()
	{
		action_compute_tablet();
	}
	this.event_tablet_compute_class_change = function()
	{
		event_tablet_compute_class_change();
	}
	this.event_tablet_cm_compute_class_change = function()
	{
		event_tablet_cm_compute_class_change();
	}
	this.action_add_item_submit = function()
	{
		action_add_item_submit();
	}
	this.action_cm_compute_tablet = function()
	{
		action_cm_compute_tablet();
	}
	this.action_general_compute = function()
	{
		action_general_compute();
	}

	this.action_cm_general_compute = function()
	{
		action_cm_general_compute();
	}
	this.action_add_cm_item_submit = function()
	{
		action_add_cm_item_submit();
	}
	function action_add_cm_item_submit()
	{
		$(".cm.tablet-add-item").unbind("click");
		$(".cm.tablet-add-item").bind("click",function()
		{
			$(".cm.item-list-"+$(".cm.tablet-item-id").val()).remove();
			$("#global_modal").modal("toggle");
			$(".cm-div-item-list").append(global_cm_tablet_html);
			$item_table = $(".cm-div-item-list .cm.item-table:last");
			
			$(".cm-div-item-list .cm.item-table:last").addClass("item-list-"+$(".cm.tablet-item-id").val());
			$(".cm-div-item-list .cm.item-table:last .popup").attr("link",'/tablet/credit_memo/add_item/'+$(".cm.tablet-item-id").val()+"/true");
			
			//PUT VALUE TO LABEL
			$item_table.find(".item-cm-name").html($(".cm.tablet-item-name").html());
			$item_table.find(".item-cm-rate").html($(".cm.tablet-item-rate").val());
			$item_table.find(".item-cm-um").html($(".cm.tablet-item-um").find("option:selected").attr("abbrev"));
			$item_table.find(".item-cm-amount").html($(".cm.tablet-item-amount").html());
			$item_table.find(".item-cm-qty").html($(".cm.tablet-item-qty").val());

			// if($(".cm.tablet-item-disc").val())
			// {
			// 	$item_table.find(".disc-content").removeClass("hidden");	
			// 	$item_table.find(".item-disc").html($(".cm.tablet-item-disc").val());
			// }
			// var tax = 0;
			// $item_table.find(".item-taxable").html("Non-Taxable");
			// if($(".tablet-item-taxable").is(":checked"))
			// {
			// 	tax = 1;
			// 	$item_table.find(".item-taxable").html("Taxable");
			// }
			$item_table.find(".item-cm-desc").html($(".cm.tablet-item-desc").val());

			//PUT VALUE TO INPUT
			$item_table.find(".cm.input-item-id").val($(".cm.tablet-item-id").val());
			$item_table.find(".cm.input-item-amount").val($(".cm.tablet-item-amount").html());
			$item_table.find(".cm.input-item-rate").val($(".cm.tablet-item-rate").val());
			$item_table.find(".cm.input-item-remarks").val($(".cm.tablet-item-remark").val());
			$item_table.find(".cm.input-item-qty").val($(".cm.tablet-item-qty").val());
			$item_table.find(".cm.input-item-um").val($(".cm.tablet-item-um").val());
			$item_table.find(".cm.input-item-desc").val($(".cm.tablet-item-desc").val());

			action_general_compute();

		});
	}
	function action_add_item_submit()
	{
		$(".tablet-add-item").unbind("click");
		$(".tablet-add-item").bind("click",function()
		{
			$(".item-list-"+$(".tablet-item-id").val()).remove();

			$("#global_modal").modal("toggle");
			$(".div-item-list").append(global_tablet_html);
			$item_table = $(".div-item-list .item-table:last");

			$(".div-item-list .item-table:last").addClass("item-list-"+$(".tablet-item-id").val());
			$(".div-item-list .item-table:last .popup").attr("link",'/tablet/invoice/add_item/'+$(".tablet-item-id").val());

			//PUT VALUE TO LABEL
			$item_table.find(".item-name").html($(".tablet-item-name").html());
			$item_table.find(".item-rate").html($(".tablet-item-rate").val());
			$item_table.find(".item-um").html($(".tablet-item-um").find("option:selected").attr("abbrev"));
			$item_table.find(".item-amount").html($(".tablet-item-amount").html());
			$item_table.find(".item-qty").html($(".tablet-item-qty").val());

			if($(".tablet-item-disc").val())
			{
				$item_table.find(".disc-content").removeClass("hidden");	
				$item_table.find(".item-disc").html($(".tablet-item-disc").val());
			}
			var tax = 0;
			$item_table.find(".item-taxable").html("Non-Taxable");
			if($(".tablet-item-taxable").is(":checked"))
			{
				tax = 1;
				$item_table.find(".item-taxable").html("Taxable");
			}
			$item_table.find(".item-desc").html($(".tablet-item-desc").val());

			//PUT VALUE TO INPUT
			$item_table.find(".input-item-id").val($(".tablet-item-id").val());
			$item_table.find(".input-item-amount").val($(".tablet-item-amount").html());
			$item_table.find(".input-item-rate").val($(".tablet-item-rate").val());
			$item_table.find(".input-item-disc").val($(".tablet-item-disc").val());
			$item_table.find(".input-item-remarks").val($(".tablet-item-remark").val());
			$item_table.find(".input-item-qty").val($(".tablet-item-qty").val());
			$item_table.find(".input-item-um").val($(".tablet-item-um").val());
			$item_table.find(".input-item-taxable").val(tax);
			$item_table.find(".input-item-desc").val($(".tablet-item-desc").val());

			action_general_compute();

		});
	}
	function action_lastclick_row()
	{
		$(document).on("click", "tbody.draggable tr:last td:not(.remove-tr)", function(){
			action_lastclick_row_op();
		});
		$(document).on("click", "tbody.cm-draggable tr:last td:not(.remove-tr)", function(){
			action_lastclick_row_op_cm();
		});
	}

	function event_compute_class_change()
	{
		$(document).on("change",".compute", function()
		{
			action_general_compute();
		});
	}
	function action_lastclick_row_op_cm()
	{
		$("tbody.cm-draggable").append(global_tr_html_cm);
		action_reassign_number();
		action_trigger_select_plugin();
		action_date_picker();
	}

	function action_lastclick_row_op()
	{
		$("tbody.draggable").append(global_tr_html);
		action_reassign_number();
		action_trigger_select_plugin();
		action_date_picker();
	}
	function action_date_picker()
	{
		$(".draggable .for-datepicker").datepicker({ dateFormat: 'mm-dd-yy', });
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
	function event_tablet_compute_class_change()
	{
		$(document).on("change",".tablet-compute", function()
		{
			action_compute_tablet();
		});
	}
	function event_tablet_cm_compute_class_change()
	{
		$(document).on("change",".cm.tablet-compute", function()
		{
			action_cm_compute_tablet();
		});
	}

	function action_compute_tablet()
	{
      	var tablet_unit_qty = $(".tablet-droplist-um").find("option:selected").attr("qty");
      	var tablet_item_qty = $(".tablet-item-qty").val();
      	var tablet_item_rate = $(".tablet-item-rate").val();
      	var tablet_item_disc = $(".tablet-item-disc").val();

 		var total = 0.00;

        var qty = tablet_item_qty;
        /* CHECK THE DISCOUNT */
        if(tablet_item_disc.indexOf('%') >= 0)
        {
            $(".tablet-item-disc").val(tablet_item_disc.substring(0, tablet_item_disc.indexOf("%") + 1));
            tablet_item_disc = (parseFloat(tablet_item_disc.substring(0, tablet_item_disc.indexOf('%'))) / 100) * (action_return_to_number(tablet_item_rate) * action_return_to_number(qty));
        }
        else if(tablet_item_disc == "" || tablet_item_disc == null)
        {
            tablet_item_disc = 0;
        }
        else
        {
            tablet_item_disc = parseFloat(tablet_item_disc);
        }

        /* RETURN TO NUMBER IF THERE IS COMMA */
        var rate        = action_return_to_number(tablet_item_rate);
        var discount    = action_return_to_number(tablet_item_disc);

        // console.log(qty+" * "+ rate + " - " + discount)
        total = ((qty * rate) - discount).toFixed(2);


        $(".tablet-item-amount").html(action_add_comma(total));

	}
	function action_cm_compute_tablet()
	{
		var tablet_unit_qty = $(".cm.tablet-droplist-um").find("option:selected").attr("qty");
      	var tablet_item_qty = $(".cm.tablet-item-qty").val();
      	var tablet_item_rate = $(".cm.tablet-item-rate").val();
 		var total = 0.00;

        var qty = tablet_item_qty;

        /* RETURN TO NUMBER IF THERE IS COMMA */
        var rate        = action_return_to_number(tablet_item_rate);

        // console.log(qty+" * "+ rate + " - " + discount)
        total = (qty * rate).toFixed(2);

        $(".cm.tablet-item-amount").html(action_add_comma(total));
	}
	function action_compute_tablet()
	{
      	var tablet_unit_qty = $(".tablet-droplist-um").find("option:selected").attr("qty");
      	var tablet_item_qty = $(".tablet-item-qty").val();
      	var tablet_item_rate = $(".tablet-item-rate").val();
      	var tablet_item_disc = $(".tablet-item-disc").val();

 		var total = 0.00;

        var qty = tablet_item_qty;
        /* CHECK THE DISCOUNT */
        if(tablet_item_disc.indexOf('%') >= 0)
        {
            $(".tablet-item-disc").val(tablet_item_disc.substring(0, tablet_item_disc.indexOf("%") + 1));
            tablet_item_disc = (parseFloat(tablet_item_disc.substring(0, tablet_item_disc.indexOf('%'))) / 100) * (action_return_to_number(tablet_item_rate) * action_return_to_number(qty));
        }
        else if(tablet_item_disc == "" || tablet_item_disc == null)
        {
            tablet_item_disc = 0;
        }
        else
        {
            tablet_item_disc = parseFloat(tablet_item_disc);
        }

        /* RETURN TO NUMBER IF THERE IS COMMA */
        var rate        = action_return_to_number(tablet_item_rate);
        var discount    = action_return_to_number(tablet_item_disc);

        // console.log(qty+" * "+ rate + " - " + discount)
        total = ((qty * rate) - discount).toFixed(2);


        $(".tablet-item-amount").html(action_add_comma(total));

	}

    function action_general_compute()
	{
		var subtotal = 0;
		var total_taxable = 0;

		var subtotal_returns = 0;
		var total_returns_with_returns = 0;

		if($(".div-item-list .item-table").length > 0)
		{
			$(".inv.item-table").each(function() 
			{			
				var qty 	= $(this).find(".input-item-qty").val();
				// console.lo
				var rate 	= $(this).find(".input-item-rate").val();
				var discount = "";
				if($(this).find(".input-item-disc").val())
				{
					discount.toString();
				}
				var amount 	= $(this).find(".input-item-amount");
				var taxable = $(this).find(".item-taxable");

				if(qty == "" || qty == null)
				{
					qty = 1;
				}

				/* CHECK THE DISCOUNT */
				if(discount.indexOf('%') >= 0)
				{
					$(this).find(".input-item-disc").val(discount.substring(0, discount.indexOf("%") + 1));
					discount = (parseFloat(discount.substring(0, discount.indexOf('%'))) / 100) * (action_return_to_number(rate) * action_return_to_number(qty));
				}
				else if(discount == "" || discount == null)
				{
					discount = 0;
				}
				else
				{
					discount = parseFloat(discount);
				}

				/* RETURN TO NUMBER IF THERE IS COMMA */
				qty 		= action_return_to_number(qty);
				rate 		= action_return_to_number(rate);
				discount 	= action_return_to_number(discount);

				var total_per_tr = ((qty * rate) - discount).toFixed(2);

				/* action_compute SUB TOTAL PER LINE */
				subtotal += parseFloat(total_per_tr);

				/* AVOID ZEROES */
				// if(total_per_tr <= 0)
				// {
				// 	total_per_tr = '';
				// }

				/* CONVERT TO INTEGER */
				var amount_val = amount.val();
				
				if(amount_val != '' && amount_val != null && total_per_tr == '') //IF QUANTITY, RATE IS [NOT EMPTY]
				{
					var sub = parseFloat(action_return_to_number(amount_val));
					if(isNaN(sub))
					{
						sub = 0;
					}
					subtotal += sub;
					total_per_tr = sub;
					amount.val(action_add_comma(sub));
				}
				else //IF QUANTITY, RATE IS [EMPTY]
				{
					amount.val(action_add_comma(total_per_tr));
				}

				/*CHECK IF TAXABLE*/	
				if(taxable.html() == "Taxable")
				{
					total_taxable += parseFloat(total_per_tr);
				}

			});

		}

		/* action_compute EWT */
		var ewt_value 			= $(".ewt-value").val();

		ewt_value = parseFloat(ewt_value) * subtotal;

		/* action_compute DISCOUNT */
		var discount_selection 	= $(".discount_selection").val();
		var discount_txt 		= $(".discount_txt").val();
		var tax_selection 		= $(".tax_selection").val();
		var taxable_discount 	= 0;

		if(discount_txt == "" || discount_txt == null)
		{
			discount_txt = 0;
		}

		discount_total = discount_txt;

		if(discount_selection == 'percent')
		{
			discount_total = subtotal * (discount_txt / 100);
			taxable_discount = total_taxable * (discount_txt / 100);
		}

		discount_total = parseFloat(discount_total);

		/* action_compute TOTAL */
		var total = 0;
		total     = subtotal - discount_total - ewt_value;

		/* action_compute TAX */
		var tax   = 0;
		if(tax_selection == 1){
			tax = total_taxable * (12 / 100);
		}
		total += tax;

		/* action payment applied */
		var payment_applied   	= parseFloat($(".payment-applied").html());
		var balance_due 		= total - payment_applied;

		$(".sub-total").html(action_add_comma(subtotal.toFixed(2)));
		$(".subtotal-amount-input").val(action_add_comma(subtotal.toFixed(2)));

		$(".ewt-total").html(action_add_comma(ewt_value.toFixed(2)));
		$(".discount-total").html(action_add_comma(discount_total.toFixed(2)));
		$(".tax-total").html(action_add_comma(tax.toFixed(2)));

		$(".total-amount").html(action_add_comma(total.toFixed(2)));
		$(".total-amount-input").val(total.toFixed(2));

		$(".balance-due").html(action_add_comma(balance_due.toFixed(2)));

		if($(".cm-div-item-list .cm.item-table").length > 0)
		{			
			$(".cm.item-table").each(function()
			{
				/* GET ALL DATA */
				var cm_qty 	= $(this).find(".cm.input-item-qty").val();
				var cm_rate = $(this).find(".cm.input-item-rate").val();
				var cm_amount = $(this).find(".cm.input-item-amount");
				
				/* CHECK IF QUANTITY IS EMPTY */
				if(cm_qty == "" || cm_qty == null)
				{
					cm_qty = 1;
				}


				/* RETURN TO NUMBER IF THERE IS COMMA */
				cm_qty 		= action_return_to_number(cm_qty);
				cm_rate 	= action_return_to_number(cm_rate);

				var cm_total_per_tr = (cm_qty * cm_rate).toFixed(2);

				/* action_compute SUB TOTAL PER LINE */
				subtotal_returns += parseFloat(cm_total_per_tr);

				/* CONVERT TO INTEGER */
				var amount_val = cm_amount.val();
				
				if(amount_val != '' && amount_val != null && cm_total_per_tr == '') //IF QUANTITY, RATE IS [NOT EMPTY]
				{
					var sub = parseFloat(action_return_to_number(amount_val));
					if(isNaN(sub))
					{
						sub = 0;
					}
					subtotal_returns += sub;
					cm_total_per_tr = sub;
					cm_amount.val(action_add_comma(sub));
				}
				else //IF QUANTITY, RATE IS [EMPTY]
				{
					cm_amount.val(action_add_comma(cm_total_per_tr));
				}
			});
		}

		console.log(subtotal_returns);
		$(".sub-total-returns").html(action_add_comma(subtotal_returns.toFixed(2)));
		$(".subtotal-amount-input-returns").val(action_add_comma(subtotal_returns.toFixed(2)));


		$(".total-amount-with-returns").html(action_add_comma((total - subtotal_returns).toFixed(2)));
		$(".total-amount-input-with-returns").val((total - subtotal_returns).toFixed(2));


	}     
	function action_convert_number()
	{
		$(".payment-applied").html(action_add_comma(parseFloat($(".payment-applied").html()).toFixed(2)));
	}


	/* CHECK BOX FOR TAXABLE */
	function event_taxable_check_change()
	{
		$(".taxable-check").unbind("change");
		$(".taxable-check").bind("change", function()
		{
			action_change_input_value($(this));
		});
	}

	function check_change_input_value()
	{
		$(".taxable-check").each( function()
		{
			action_change_input_value($(this));
		})
	}
	
	function action_change_input_value($this)
	{
		if($this.is(":checked"))
		{
			$this.prev().val(1);
		}
		else
		{
			$this.prev().val(0);
		}
	}
      

	function iniatilize_select()
	{
		$('.droplist-customer').globalDropList(
		{ 
            width : "100%",
    		placeholder : "Select Customer...",
			link : "/member/customer/modalcreatecustomer",
			onChangeValue: function()
			{
				$(".customer-email").val($(this).find("option:selected").attr("email"));
				// load_all_estimate($(this).val());
			}
		});
	    $('.droplist-item').globalDropList(
        {
            link : "/member/item/add",
            width : "100%",
            maxHeight: "309px",
            onCreateNew : function()
            {
            	item_selected = $(this);
            	console.log($(this));
            },
            onChangeValue : function()
            {
            	action_load_item_info($(this));
            }
        });

        $('.cm.tablet-droplist-um').globalDropList(
	    {
	        hasPopup: "false",
	        width : "100%",
	        placeholder : "U/M..",
	        onChangeValue: function()
	        {
	        	$(".cm.tablet-item-rate").val(($(this).find("option:selected").attr("qty") * $(".cm.tablet-price-per-item").val()).toFixed(2));
	            action_cm_compute_tablet();
	        }

	    });
        $('.tablet-droplist-um').globalDropList(
	    {
	        hasPopup: "false",
	        width : "100%",
	        placeholder : "U/M..",
	        onChangeValue: function()
	        {
	        	$(".tablet-item-rate").val(($(this).find("option:selected").attr("qty") * $(".tablet-price-per-item").val()).toFixed(2));
	            action_compute_tablet();
	        }

	    });
        $('.tablet-droplist-item-return').globalDropList({

            hasPopup : 'false',
            width : "100%",
            maxHeight: "309px",
    		placeholder : "Select Return Item...",
            onCreateNew : function()
            {
            	item_selected = $(this);
            	console.log($(this));
            },
            onChangeValue : function()
            {
            	console.log($(this).val());
            	if($(this).val() != '' || $(this).val() != null)
            	{
	           	    action_load_link_to_modal('/tablet/credit_memo/add_item/'+$(this).val()+"/true",'md');
            	}
            	// action_load_item_info();
            }
        });

        $('.tablet-droplist-um').globalDropList(
	    {
	        hasPopup: "false",
	        width : "100%",
	        placeholder : "U/M..",
	        onChangeValue: function()
	        {
	        	$(".tablet-item-rate").val(($(this).find("option:selected").attr("qty") * $(".tablet-price-per-item").val()).toFixed(2));
	            action_compute_tablet();
	        }

	    });
	    $('.droplist-item-cm').globalDropList(
        {
            link : "/member/item/add",
            width : "100%",
            onChangeValue : function()
            {
            	action_load_item_info_cm($(this));
            }
        });
        $('.droplist-terms').globalDropList(
        {
            link : "/member/maintenance/terms/terms",
            link_size : "sm",
            width : "100%",
    		placeholder : "Terms...",
            onChangeValue: function()
            {
            	var start_date 		= $(".datepicker[name='inv_date']").val();
            	var days 			= $(this).find("option:selected").attr("days");
            	var new_due_date 	= AddDaysToDate(start_date, days, "/");
            	$(".datepicker[name='inv_due_date']").val(new_due_date);
            }
        });
        $('.tablet-droplist-item').globalDropList({

            hasPopup : 'false',
            width : "100%",
            maxHeight: "309px",
    		placeholder : "Select Item...",
            onCreateNew : function()
            {
            	item_selected = $(this);
            	console.log($(this));
            },
            onChangeValue : function()
            {
            	if($(this).val() != '')
            	{
	           	    action_load_link_to_modal('/tablet/invoice/add_item/'+$(this).val(),'md');
            	}
            	// action_load_item_info();
            }
        });
        $('.droplist-um').globalDropList(
    	{
    		hasPopup: "false",
    		width : "100%",
    		placeholder : "um..",
    		onChangeValue: function()
    		{
    			action_load_unit_measurement($(this));
    		}

    	});
        $('.droplist-um:not(.has-value)').globalDropList("disabled");
        $('.droplist-um-cm').globalDropList(
    	{
    		hasPopup: "false",
    		width : "100%",
    		placeholder : "um..",
    		onChangeValue: function()
    		{
    			action_load_unit_measurement_cm($(this));
    		}
    	});
        $('.droplist-um-cm:not(.has-value)').globalDropList("disabled");
	}

	function AddDaysToDate(sDate, iAddDays, sSeperator) {
    //Purpose: Add the specified number of dates to a given date.
	    var date = new Date(sDate);
	    date.setDate(date.getDate() + parseInt(iAddDays));
	    var sEndDate = LPad(date.getMonth() + 1, 2) + sSeperator + LPad(date.getDate(), 2) + sSeperator + date.getFullYear();
	    return sEndDate;
	}
	function LPad(sValue, iPadBy) {
	    sValue = sValue.toString();
	    return sValue.length < iPadBy ? LPad("0" + sValue, iPadBy) : sValue;
	}
	
	function event_button_action_click()
	{
		$(document).on("click","button[type='submit']", function()
		{
			$(".button-action").val($(this).attr("data-action"));
		})
	}

}	

/* AFTER ADDING A CUSTOMER */
function submit_done_customer(result)
{
    $(".droplist-customer").load("/member/customer/load_customer", function()
    {                
         $(".droplist-customer").globalDropList("reload");
         $(".droplist-customer").val(result.id).change();    
         toastr.success("Success");      
    });
}

/* AFTER ADDING AN  ITEM */
function submit_done_item(data)
{
    item_selected.load("/member/item/load_item_category", function()
    {
        $(this).globalDropList("reload");
		$(this).val(data.item_id).change();
		toastr.success("Success");
    });
    data.element.modal("hide");
}

function submit_done(data)
{
	if(data.status == "success-invoice")
	{
		console.log("succes-invoice");
        if(data.redirect)
        {
        	toastr.success("Success inv");
        	location.href = data.redirect;
    	}
    	else
    	{
    		$(".load-data:last").load(data.link+" .load-data .data-container", function()
    		{
    			tablet_customer_invoice.action_initialized();
    			toastr.success("Success");
    		})
    	}
	}
	else if(data.status == 'error-inv-no')
	{
		action_load_link_to_modal('/member/customer/invoice/error/'+data.inv_id,'md');
	}
	else if(data.status == 'success-sir')
	{		
        toastr.success("Success sir");
       	location.href = "/member/pis/manual_invoice";
	}
	else if(data.status == 'success-tablet')
	{		
        toastr.success("Success");
       	location.href = "/tablet/invoice";
	}
	else if(data.status == 'success-tablet-sr')
	{		
        toastr.success("Success");
       	location.href = "/tablet/sales_receipt/list";
	}
    else if(data.status == "error")
    {
        toastr.warning(data.status_message);
        $(data.target).html(data.view);
    }

    if(data.status == "success")
    {
    	if(data.type == "terms")
    	{
    		$(".droplist-terms").load("/member/maintenance/terms/load-terms", function()
			{
				$(this).globalDropList("reload");
				$(this).val(data.terms_id).change();
			});
			data.element.modal("toggle");
    	}
    }
}

function submit_this_form()
{
	$("#keep_val").val("keep");
    $("#invoice_form").submit();
}

function toggle_returns(className, obj) {
var $input = $(obj);
if ($input.prop('checked')) $(className).slideDown();
else $(className).slideUp();
}