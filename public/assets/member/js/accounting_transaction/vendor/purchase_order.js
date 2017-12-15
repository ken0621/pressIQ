var purchase_order = new purchase_order();
var global_tr_html = $(".div-script tbody").html();

function purchase_order()
{
	init();

	function init()
	{
		action_load_initialize_select();
		event_click_last_row();

	}
	function action_load_initialize_select()
	{
		$('.droplist-vendor').globalDropList(
		{ 	
			width : "100%",
			link : "/member/vendor/add",
			placeholder : "Select Vendor...",
			onChangeValue: function()
			{
				$(".customer-email").val($(this).find("option:selected").attr("email"));
				$('textarea[name="po_billing_address"]').val($(this).find("option:selected").attr("billing-address"));
			}
		});

		$('.droplist-terms').globalDropList(
		{ 	
			width : "100%",
			link : "/member/maintenance/terms/terms",
			placeholder : "Select Term...",
			onChangeValue: function()
			{
				var start_date 		= $(".datepicker[name='po_date']").val();
            	var days 			= $(this).find("option:selected").attr("days");
            	var new_due_date 	= AddDaysToDate(start_date, days, "/");
            	$(".datepicker[name='po_due_date']").val(new_due_date);
			}
		});

	}

	function action_date_picker()
	{/*class name of tbody and text field for date*/
		$(".draggable .for-datepicker").datepicker({ dateFormat: 'mm-dd-yy', });
	}

	/*ITEM NUMBER*/
	function action_reassign_number()
	{
		var num = 1;
		$(".invoice-number-td").each(function(){
			$(this).html(num);
			num++;
		});
	}

	function event_click_last_row()
	{
		$(document).on("click", "tbody.draggable tr:last td:not(.remove-tr)", function(){
			event_click_last_row_op();
		});
	}

	function event_click_last_row_op()
	{
		$("tbody.draggable").append(global_tr_html);
		action_reassign_number();
		action_load_initialize_select();
		action_date_picker();
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

}
function success_vendor(data)
{
	$('.droplist-vendor').load("/member/vendor/load_vendor", function()
		{
			$('.droplist-vendor').globalDropList('reload');
			$('.droplist-vendor').val(data.vendor_id).change();

			data.element.modal("hide");

		});
}

