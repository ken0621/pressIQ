
var tablet_customer_invoice = new tablet_customer_invoice();
var global_tr_html = $(".tablet-div-script").html();
var item_selected = ''; 

function tablet_customer_invoice()
{
	init();

	function init()
	{
		iniatilize_select();
		draggable_row.dragtable();

		event_accept_number_only();
		event_taxable_check_change();
		event_button_action_click();
		
		action_lastclick_row();
		action_convert_number();
		action_date_picker();
	}
	this.action_initialized = function()
	{
		action_initialize();
	}

	function action_initialize()
	{
		iniatilize_select();
		action_convert_number();
		action_date_picker();
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
	this.action_add_item_submit = function()
	{
		action_add_item_submit();
	}
	function action_add_item_submit()
	{
		$(".tablet-add-item").unbind("click");
		$(".tablet-add-item").bind("click",function()
		{
			$("#global_modal").modal("toggle");
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
	function action_compute_tablet()
	{
      	var tablet_unit_qty = $(".tablet-droplist-um").find("option:selected").attr("qty");
      	var tablet_item_qty = $(".tablet-item-qty").val();
      	var tablet_item_rate = $(".tablet-item-rate").val();
      	var tablet_item_disc = $(".tablet-item-disc").val();

 		var total = 0.00;

        var qty = tablet_item_qty * tablet_unit_qty;
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
				load_all_estimate($(this).val());
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

        $('.tablet-droplist-um').globalDropList(
	    {
	        hasPopup: "false",
	        width : "100%",
	        placeholder : "U/M..",
	        onChangeValue: function()
	        {
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