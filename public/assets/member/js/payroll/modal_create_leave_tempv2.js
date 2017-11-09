var modal_create_leave_temp = new modal_create_leave_temp();

function modal_create_leave_temp()
{
	init();

	function init()
	{
		default_with_pay_val();
	}

	function remove_tag()
	{
		$(".btn-remove-tag").unbind("click");
		$(".btn-remove-tag").bind("click", function()
		{
			var content 	= $(this).data("content");
			var con 		= confirm("Do you really want to remove this employee from tagging?");
			var parent 		= $(this).parents("tr");
			var element 	= $(this);
			var html 		= element.html();

			if(con)
			{	
				element.html(misc('spinner'));
				$.ajax({
					url 	: 	"/member/payroll/leave/v2/remove_leave_tag_employeev2",
					type 	: 	"POST",
					data 	: 	{
						_token:misc('_token'),
						content:content
					},
					success : 	function(result)
					{
						parent.remove();
					},
					error 	: 	function(err)
					{
						error_function();
						element.html(html);
						remove_tag()
					}
				});
			}
		});
	}

	this.load_employee_tag = function()
	{
		reload_leave_employee();
		var payroll_leave_type_id = document.getElementById('payroll_leave_type_id').value;
		$(".tbl-tag").html('<tr><td colspan="3" class="text-center">'+misc('loader') + '</td></tr>');
		$.ajax({
			url 	: 	"/member/payroll/leave/v2/get_leave_tag_employeev2",
			type 	: 	"POST",
			data 	: 	{
				_token:misc('_token'),
			payroll_leave_type_id:payroll_leave_type_id
			},
			success : 	function(result)
			{
				result = JSON.parse(result);
				var html = "";

				$(result.new_record).each(function(index, emp)
				{			
							html += tbl_tag(emp,result.leave_type);
				});
				$(".tbl-tag").html(html);
				remove_tag();
			},
			error 	: 	function(err)
			{
				error_function();
			}
		});
	}

/*	this.reload_leave_employee = function()
	{
		reload_leave_employee();
	}*/

	function reload_leave_employee()
	{
		var action = "/member/payroll/leave/v2/reload_leave_employeev2";
		var method = "POST";
		var formdata = {
			_token:misc('_token'),
			payroll_leave_temp_id:$("#payroll_leave_temp_id").val()
		};
		var target = ".leave-employee";
		$(target).html(misc('loader'));
		$.ajax({
			url	 	: 	action,
			type	: 	method,
			data 	: 	formdata,
			success : 	function(result)
			{
				$(target).html(result);
			},
			error 	: 	function(err)
			{
				error_function();
			}
		});	
	}

	function error_function()
	{
		toastr.error("Error, something went wrong.");
	}

	function tbl_tag(data,leavetype)
	{

		var html = '<tr>';
		html += '<td>' + data.payroll_employee_title_name + ' ' + data.payroll_employee_first_name + ' ' + data.payroll_employee_middle_name  + ' ' + data.payroll_employee_last_name  + ' ' + data.payroll_employee_suffix_name  + ' <input type="hidden" name="employee_tag[]" value="'+data.payroll_employee_id+'"></td>';
	    html += '<td>'+ leavetype[0].payroll_leave_hours_cap + ' <input type="hidden" name="payroll_leave_temp_hours" value="'+leavetype[0].payroll_leave_hours_cap+'"></td>';
		html += '<td><a href="#" class="btn-remove-tag" data-content="'+data.payroll_employee_id+'"><i class="fa fa-times"></i></a></td>';
		html += '</tr>';

		return html;
	}

	function misc(str){
		var spinner = '<i class="fa fa-spinner fa-pulse fa-fw"></i><span class="sr-only">Loading...</span>';
		var plus = '<i class="fa fa-plus" aria-hidden="true"></i>';
		var times = '<i class="fa fa-times" aria-hidden="true"></i>';
		var pencil = '<i class="fa fa-pencil" aria-hidden="true"></i>';
		var loader = '<div class="loader-16-gray"></div>'
		var _token = $("#_token").val();

		switch(str){
			case "spinner":
				return spinner
				break;

			case "plus":
				return plus
				break;

			case "loader":
				return loader
				break;

			case "_token":
				return _token
				break;
			case "times":
				return times
				break;
			case "pencil":
				return pencil
				break;
		}
	}

	function default_with_pay_val()
	{
		$("body").on("click", ".payroll_leave_temp_with_pay", function(e){
			alert("Currently we support with pay value of 'Yes'!");
			return false;
		});
	}
}