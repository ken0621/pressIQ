var credit_memo = new credit_memo();
var global_tr_html = $(".div-script tbody").html();
var item_selected = ''; 


function credit_memo()
{
	init();

	function init()
	{
		action_load_initialize_select();
		event_click_last_row();
		event_remove_tr();
		action_compute();
		event_compute_class_change();
	}
	function action_compute()
	{
		var subtotal = 0;
		var total_taxable = 0;


		$(".tr-draggable").each(function()
		{
			/* GET ALL DATA */
			var qty               = $(this).find(".txt-qty").val();
			var rate              = $(this).find(".txt-rate").val();
			var amount            = $(this).find(".txt-amount");

			if(!qty)
			{
				qty = 1;
			}

			/* RETURN TO NUMBER IF THERE IS COMMA */
			qty 		= action_return_to_number(qty);
			rate 		= action_return_to_number(rate);

			var total_per_tr = ((qty * rate)).toFixed(2);

			/* action_compute SUB TOTAL PER LINE */
			subtotal += parseFloat(total_per_tr);


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

			$(this).find(".txt-rate").val(action_add_comma(rate));
		});

		$(".total-amount").html(action_add_comma(subtotal.toFixed(2)));
		$(".total-amount-input").val(action_add_comma(subtotal.toFixed(2)));
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

	function event_compute_class_change()
	{
		$(document).on("change",".compute", function()
		{
			action_compute();
		});
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

	    $('.droplist-item').globalDropList(
        {
            link : "/member/item/v2/add",
            width : "100%",
            maxHeight: "309px",
            onCreateNew : function()
            {
            	item_selected = $(this);
            },
            onChangeValue : function()
            {
            	action_load_item_info($(this));
            }
        });

	    $(".draggable .tr-draggable:last td select.select-item").globalDropList(
        {
            link : "/member/item/v2/add",
            width : "100%",
            maxHeight: "309px",
            onCreateNew : function()
            {
            	item_selected = $(this);
            },
            onChangeValue : function()
            {
            	action_load_item_info($(this));
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

        $(".draggable .tr-draggable:last td select.select-um").globalDropList(
        {
        	hasPopup: "false",
    		width : "100%",
    		placeholder : "um..",
    		onChangeValue: function()
    		{  
    			action_load_unit_measurement($(this));
    		}

        }).globalDropList('disabled');
	}
	function event_remove_tr()
	{
		$(document).on("click", ".remove-tr", function(e){
			var len = $(".tbody-item .remove-tr").length;
			if($(".tbody-item .remove-tr").length > 1)
			{
				$(this).parent().remove();
				action_reassign_number();
			}
			else
			{
				console.log("success");
			}
		});
	}


	function action_load_unit_measurement($this)
	{
		$parent = $this.closest(".tr-draggable");
		$item   = $this.closest(".tr-draggable").find(".select-item");

		$um_qty = parseFloat($this.find("option:selected").attr("qty") || 1);
		$sales  = parseFloat($item.find("option:selected").attr("price"));
		$qty    = parseFloat($parent.find(".txt-qty").val());

		$parent.find(".txt-rate").val( $um_qty * $sales * $qty ).change();

    	action_compute();
	}
	function event_click_last_row()
	{
		$(document).on("click", "tbody.draggable tr:last td:not(.remove-tr)", function(){
			event_click_last_row_op();
		});
	}

	function action_load_item_info($this)
	{
		$parent = $this.closest(".tr-draggable");
		$parent.find(".txt-desc").html($this.find("option:selected").attr("sales-info")).change();
		$parent.find(".txt-rate").val($this.find("option:selected").attr("price")).change();
		$parent.find(".txt-qty").val(1).change();
		if($this.find("option:selected").attr("has-um"))
		{
			$parent.find(".select-um").load('/member/item/load_one_um/' +$this.find("option:selected").attr("has-um"), function()
			{
				$(this).globalDropList("reload").globalDropList("enabled");
				$(this).val($(this).find("option:first").val()).change();
			})
		}
		else
		{
			$parent.find(".select-um").html('<option class="hidden" value=""></option>').globalDropList("reload").globalDropList("disabled").globalDropList("clear");
		}
    	action_compute();
	}

	function event_click_last_row_op()
	{
		$("tbody.draggable").append(global_tr_html);
		action_reassign_number();
		action_load_initialize_select();
		action_date_picker();
    	action_compute();
	}

	function action_date_picker()
	{
		$(".draggable .for-datepicker").datepicker({ dateFormat: 'mm-dd-yy', });
	}

	function action_reassign_number()
	{
		var num = 1;
		$(".invoice-number-td").each(function(){
			$(this).html(num);
			num++;
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

/* AFTER ADDING AN  ITEM */
function success_item(data)
{
    item_selected.load("/member/item/load_item_category", function()
    {
        $(this).globalDropList("reload");
		$(this).val(data.item_id).change();
    });
    data.element.modal("hide");
}
