var wis_create = new wis_create()
var load_item = null;
var item_search_delay_timer;
var settings_delay_timer;
var keysearch = {};
var global_tr_html = $(".div-script tbody").html();

var success_audio = new Audio('/assets/sounds/success.mp3');
var error_audio = new Audio('/assets/sounds/error.mp3');

function wis_create()
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
		// action_load_item_table();
		event_search_item();
		event_click_search_result();
		event_remote_item_from_cart();
		event_change_global_discount();
		event_change_quantity();
		event_submit_form();
		action_initialize_select();
		action_lastclick_row();
		event_remove_tr();
		action_reassign_number();
		event_compute_class_change();
	}
	function event_remove_tr()
	{		
		$(document).on("click", ".remove-tr", function(e)
		{
			var len = $(".tbody-item .remove-tr").length;
			if($(".tbody-item .remove-tr").length > 1)
			{
				$(this).parent().remove();
			}
		});
	}

	function action_reassign_number()
	{
		var num = 1;
		$(".invoice-number-td").each(function(){
			$(this).html(num);
			num++;
		});
	}

	function event_compute_class_change()
	{
		$(document).on("change",".compute", function()
		{
			action_compute();
		});
	}
	function  action_load_warehouse_info(data)
	{
		$(".txt-warehouse-address").html(data.find("option:selected").attr("warehouse-address"));
	}
	function action_initialize_select()
	{

        $('.droplist-warehouse').globalDropList(
        {
            width : "100%",
    		hasPopup: "false",
            onChangeValue : function()
            {
            	if($(this).val())
            	{
            		action_load_warehouse_info($(this));
            	}
            }
        });

		$('.droplist-item').globalDropList({
			link : "/member/item/add",
            width : "100%",
            placeholder : 'Search Item...',
            onCreateNew : function()
            {
            	// item_selected = $(this);
            	// console.log($(this));
            },
            onChangeValue : function()
            {
            	action_load_item_info($(this));
            }
		});
		
		$(".draggable .tr-draggable:last td select.select-item").globalDropList(
        {
            link : "/member/item/add",
            width : "100%",
            placeholder : 'Search Item...',
            onCreateNew : function()
            {
            	// item_selected = $(this);
            },
            onChangeValue : function()
            {
            	if($(this).val())
            	{
            		action_load_item_info($(this));
            	}
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
    	$(".draggable .tr-draggable:last td select.select-um").globalDropList(
        {
        	hasPopup: "false",
    		width : "100%",
    		placeholder : "um..",
    		onChangeValue: function()
    		{  
    			action_load_unit_measurement($(this));
    		}

        });
	}
	function action_load_item_info($this)
	{
		// $parent = $this.closest(".tr-draggable");
		// $parent.find(".txt-desc").val($this.find("option:selected").attr("sales-info")).change();
		// $parent.find(".txt-remaining-qty").html($this.find("option:selected").attr("inventory-count") + " pc(s)").change();
		$parent = $this.closest(".tr-draggable");
		$parent.find(".txt-desc").html($this.find("option:selected").attr("sales-info")).change();
		$parent.find(".txt-rate").val($this.find("option:selected").attr("price")).change();
		$parent.find(".txt-qty").val(1).change();
		$parent.find(".txt-qty").attr("disabled",true);
		if($this.find("option:selected").attr("has-um"))
		{
			$parent.find(".txt-qty").attr("disabled",false);
			$parent.find(".select-um").load('/member/item/load_one_um/' +$this.find("option:selected").attr("has-um"), function()
			{
				$parent.find(".txt-qty").removeAttr("disabled");
				$(this).globalDropList("reload").globalDropList("enabled");
				$(this).val($(this).find("option:first").val()).change();
			})
		}
		else
		{
			$parent.find(".txt-qty").attr("disabled",false);
			$parent.find(".select-um").html('<option class="hidden" value=""></option>').globalDropList("reload").globalDropList("disabled").globalDropList("clear");
		}
    	action_compute();
	}

	function action_load_unit_measurement($this)
	{
		$parent = $this.closest(".tr-draggable");
		$item   = $this.closest(".tr-draggable").find(".select-item");

		$um_qty = parseFloat($this.find("option:selected").attr("qty") || 1);
		$sales  = parseFloat($item.find("option:selected").attr("price"));
		$qty    = parseFloat($parent.find(".txt-qty").val());

		$parent.find(".txt-rate").val($um_qty * $sales * $qty).change();

    	action_compute();
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
			var total_per_tr = (qty * rate).toFixed(2);

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

			$(this).find(".txt-rate").val(action_add_comma(rate.toFixed(2)));
		});

		/* action_compute TOTAL */
		var total = 0;
		total     = subtotal;

		$(".total-amount").html(action_add_comma(total.toFixed(2)));
		$(".total-amount-input").val(total.toFixed(2));
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

	function action_load_item_info_old($this)
	{
		$parent = $this.closest(".tr-draggable");
		$parent.find(".txt-desc").val($this.find("option:selected").attr("sales-info")).change();
		$parent.find(".txt-remaining-qty").html($this.find("option:selected").attr("inventory-count") + " pc(s)").change();
	}
	function action_lastclick_row()
	{
		$(document).on("click", "tbody.draggable tr:last td:not(.remove-tr)", function(){
			action_lastclick_row_op();
		});
	}
	function action_lastclick_row_op()
	{
		$("tbody.draggable").append(global_tr_html);
		action_initialize_select();
		action_reassign_number();
	}
	function event_submit_form()
	{
		$('.save-button').unbind('click')
		$('.save-button').bind('click', function()
		{
			$('.form-to-submit-add').submit();
		});
	}
	function table_loading()
	{
		$(".load-item-table-pos").css("opacity", 0.3);
	}
	function event_change_quantity()
	{
		$("body").on("keyup", ".quantity-item", function(e)
		{
			var item_id = $(e.currentTarget).attr('item-id');
			var quantity = $(e.currentTarget).val();

			console.log('quantity-change-here');

			$.ajax(
			{
				url 		: "/member/item/warehouse/wis/change-quantity?item_id=" + item_id + "&qty=" + quantity,
				dataType 	: "json",
				type 		: "get",
				success 	: function(data)
				{
					action_load_item_table();
				}
			});
		});
	}
	function event_change_global_discount()
	{
		$(".cart-global-discount").keyup(function()
		{
			table_loading();
			clearTimeout(settings_delay_timer);

		    settings_delay_timer = setTimeout(function()
		    {
		       	action_set_cart_info("global_discount", $(".cart-global-discount").val());
		    }, 500);
		});
	}
	function action_set_cart_info($key, $value)
	{
		table_loading();

		if($value == "" || $value == null)
		{
			$value = 0;
		}

		$.ajax(
		{
			url 		: "/member/cashier/pos/set_cart_info/" + $key + "/" + $value,
			dataType 	: "json",
			type 		: "get",
			success 	: function(data)
			{
				action_load_item_table();
			}
		});
	}
	function event_remote_item_from_cart()
	{
		$("body").on("click", ".remove-item-from-cart", function(e)
		{
			$item_id = $(e.currentTarget).closest(".item-info").attr("item_id");

			$(e.currentTarget).html('<i class="fa fa-spinner fa-pulse fa-fw"></i>');
			table_loading();


			$.ajax(
			{
				url:"/member/item/warehouse/wis/create-remove-item",
				dataType:"json",
				data: {"item_id":$item_id},
				type:"get",
				success: function(data)
				{
					action_load_item_table();
				}
			});
		});
	}
	function event_search_item()
	{
		$("body").on('keyup', '.event_search_item' ,function(e)
		{
			if(e.which == 13) //ENTER KEY
			{
				action_scan_item($(".event_search_item").val());
				action_hide_search();
			}
			else if(e.which == 38) //UP KEY
			{
				event_search_item_cursor_next(true);
			}
			else if(e.which == 40) //DOWN KEY
			{
				event_search_item_cursor_next();
			}
			else /* SEARCH MODE */
			{
				if($(".event_search_item").val() == "")
				{
					action_hide_search();
				}
				else
				{
					keysearch.item_keyword = $(".event_search_item").val();
					keysearch._token = $(".token").val();
					if(load_item)
					{
						load_item.abort();
					}

					clearTimeout(item_search_delay_timer);

				    item_search_delay_timer = setTimeout(function()
				    {
				       $(".pos-search-container").html(get_loader_html(10)).show();
				       action_ajax_search_item();
				    }, 500);
				}
			}
		});

		$("body").click(function(event)
		{
			if(!$(event.target).is('.pos-item-search-result'))
			{
			    action_hide_search();
			}
		});

	}
	function event_search_item_cursor_next(reverse = false)
	{
		var current_cursor = $(".pos-item-search-result.cursor");

		if(current_cursor.length < 1)
		{
			$(".pos-item-search-result:first").addClass("cursor");
		}
		else
		{
			if(reverse == true)
			{
				$(".pos-item-search-result.cursor").prev(".pos-item-search-result").addClass("cursor");
			}
			else
			{
				$(".pos-item-search-result.cursor").next(".pos-item-search-result").addClass("cursor");
			}
			
			current_cursor.removeClass("cursor");
		}

		$active_item_id = $(".pos-item-search-result.cursor").attr("item_id");
		$(".event_search_item").val($active_item_id);
	}
	function event_click_search_result()
	{
		$("body").on("click", ".pos-item-search-result", function(e)
		{
			$item_id = $(e.currentTarget).attr("item_id");
			action_scan_item($item_id);
			action_hide_search();
		});
	}
	function action_scan_item($item_id)
	{
		$(".event_search_item").val("");
		$(".event_search_item").attr("disabled", "disabled");
		$(".button-scan").find(".scan-load").show();
		$(".button-scan").find(".scan-icon").hide();

		scandata = {};
		scandata.item_id = $item_id;
		scandata._token = $(".token").val();

 		$.ajax(
		{
			url			: "/member/item/warehouse/wis/scan-item",
			dataType	: "json",
			type 		: "post",
			data 		: scandata,
			success 	: function(data)
			{
				$(".event_search_item").removeAttr("disabled");
				$(".button-scan").find(".scan-load").hide();
				$(".button-scan").find(".scan-icon").show();

				if(data.status == "success")
				{
					toastr.success("<b>SUCCESS!</b><br>" + data.message);
					success_audio.play();
					action_load_item_table();
				}
				else if(data.status == "error")
				{
					toastr.error("<b>ERROR!</b><br>" + data.message);
					error_audio.play();
				}

				$(".event_search_item").focus();
			},
			error : function(data)
			{
				$(".event_search_item").removeAttr("disabled");
				$(".button-scan").find(".scan-load").hide();
				$(".button-scan").find(".scan-icon").show();
				toastr.error("An error occured during scan - please contact system administrator");
				$(".event_search_item").focus();
			}
		});
	}
	function action_ajax_search_item()
	{
		load_item = $.ajax(
		{
			url:"/member/cashier/pos/search_item",
			type:"post",
			data: keysearch,
			success: function(data)
			{
				$(".pos-search-container").html(data);
			}
		});
	}
	function action_hide_search()
	{
		$(".pos-search-container").hide();
		clearTimeout(item_search_delay_timer);
	}
	function action_load_item_table()
	{
		if($(".load-item-table-pos").text() != "")
		{
			table_loading();
		}
		else
		{
			$(".load-item-table-pos").html(get_loader_html());
		}

		
		$(".load-item-table-pos").load("/member/item/warehouse/wis/table-item", function()
		{
			action_update_big_totals();
			$(".load-item-table-pos").css("opacity", 1);
		});
	}
	function action_update_big_totals()
	{
		$(".big-total").find(".grand-total").text($(".table-grand-total").val());
		$(".big-total").find(".amount-due").text($(".table-amount-due").val());
	}
	function get_loader_html($padding = 50)
	{
		return '<div style="padding: ' + $padding + 'px; font-size: 20px;" class="text-center"><i class="fa fa-spinner fa-pulse fa-fw"></i></div>';
	}
}

function new_price_level_save_done(data)
{
	$("#global_modal").modal("hide");
	$(".price-level-select").append('<option value="' + data.price_level_id + '">' + data.price_level_name + '</option>');
	$(".price-level-select").globalDropList("reload");
	$(".price-level-select").val(data.price_level_id).change();
}
function success_create_wis(data)
{
	if(data.status == 'success')
	{
		toastr.success('Success');
		location.href = '/member/item/warehouse/wis';
	}
}