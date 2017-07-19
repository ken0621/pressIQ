var payroll_group = new payroll_group();

function payroll_group()
{
	
	init();

	function init()
	{
		$(document).ready(function()
		{
			document_ready();
		})
	}

	function document_ready()
	{
		custom_drop_down('.shift_code_id');	
	}

	function custom_drop_down(target)
	{
		$(target).globalDropList(
		{  
		  hasPopup                : "false",
		  link                    : "/member/payroll/shift_template/modal_create_shift_template",
		  link_size               : "lg",
		  width                   : "100%",
		  maxHeight				  : "129px",
		  placeholder             : "Search....",
		  no_result_message       : "No result found!",
		  onChangeValue           : function(){},
		  onCreateNew             : function(){
		  								
		  							},
		});
	}
}