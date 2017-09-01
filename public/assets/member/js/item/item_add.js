var item_add = new item_add();

function item_add()
{
	init();

	function init()
	{
		$(document).ready(function()
		{
			add_event_select_item_type();
			add_event_change_type();
			add_action_initialize_select();
		});
	}
	function add_action_initialize_select()
	{
		$('.select-category').globalDropList({
			width       : '100%',
            link        : '/member/item/category/modal_create_category/inventory',
            link_size   : 'md',
            placeholder : 'Select Category'
		});
		$('.select-manufacturer').globalDropList({
			width       : '100%',
            link        : '/member/item/manufacturer/add',
            link_size   : 'md',
            placeholder : 'Select Manufacturer'
		});
		$('.select-income-account').globalDropList({
			width       : '100%',
            link        : '/member/accounting/chart_of_account/popup/add',
            link_size   : 'md',
            onCreateNew : function()
            {
                account_income = $(this);
            }
		});
		$('.select-expense-account').globalDropList({
			width       : '100%',
            link        : '/member/accounting/chart_of_account/popup/add',
            link_size   : 'md',
            onCreateNew : function()
            {
                account_expense = $(this);
            }
		});
		$('.select-asset-account').globalDropList({
			width       : '100%',
            link        : '/member/accounting/chart_of_account/popup/add',
            link_size   : 'md',
            onCreateNew : function()
            {
                account_asset = $(this);
            }
		});
		$('.select-has-serial').globalDropList({
			width       : '100%',
			hasPopup	: 'false'
		}).val(0).change();
	}
	function add_event_select_item_type()
	{
		$(".tp-picker").click(function(e)
		{
			$type_id = $(e.currentTarget).attr("type_id");
			$(".item-type-picker").hide();
			$(".item-add-main").fadeIn();
			$(".modal-footer").find("button").removeAttr("disabled");
		});
	}
	function add_event_change_type()
	{
		$(".change-type").click(function(e)
		{
			$(".item-type-picker").fadeIn();
			$(".item-add-main").hide();
			$(".modal-footer").find("button").attr("disabled", "disabled");
		});
	}
}
function success_item(data)
{
	if(data.status == 'success')
	{
        toastr.success(data.message);
        data.element.modal("hide");
        item_list.action_load_table();
	}
}
function submit_done(data)
{
	if(data.type == "category")
    {
        toastr.success("Success");
        $(".select-category.inventory").load("/member/item/load_category/inventory", function()
        {                
             $(".select-category").globalDropList("reload");
             $(".select-category").val(data.id).change();              
        });
        data.element.modal("hide");
    }
    else if(data.type == "manufacturer")
    {
        toastr.success("Success");
        $(".select-manufacturer").load("/member/item/manufacturer/load_manufacturer", function()
        {                
             $(".select-manufacturer").globalDropList("reload"); 
             $(".select-manufacturer").val(data.id).change();              
        });
        data.element.modal("hide");
    }
}