var employee_leave_management = new employee_leave_management();

function employee_leave_management()
{
	init();

	function init()
	{
		ajax_load_pending_leave()
		ajax_load_approved_leave()
		ajax_load_rejected_leave()

		$(document).ready(function()
		{
			document_ready();

		})
	}

	function document_ready()
	{
		ajax_all_load_leave();
	}

	function ajax_all_load_leave()
	{
		$(".tbl-tag").html('<tr><td colspan="7" class="text-center">'+misc('spinner') + '</td></tr>');
		$.ajax({
			url 	: 	"/leave/ajax_load_leave",
			type 	: 	"POST",
			data 	: 	{
				_token:misc('_token')
			},
			success : 	function(result)
			{
				result = JSON.parse(result);
				var html = "";
				
				if(result.length > 0)
				{
					$(result).each(function(index, emp)
					{			
						 html += tbl_tag(emp);
					});
					$(".tbl-tag").html(html);
				}
				else
				{
				 	html += tbl_tag_2();
					$(".tbl-tag").html(html);
				}
			},
			error 	: 	function(err)
			{
				error_function();
			}
		});
	}

	function ajax_load_pending_leave()
	{
		$(".pending").on("click", function(e)
		{
			$(".tbl-tag").html('<tr><td colspan="7" class="text-center">'+misc('spinner') + '</td></tr>');
			$.ajax({
				url 	: 	"/leave/ajax_load_pending_leave",
				type 	: 	"POST",
				data 	: 	{
					_token:misc('_token')
				},
				success : 	function(result)
				{
					result = JSON.parse(result);
					var html = "";
					
					if(result.length > 0)
					{
						$(result).each(function(index, emp)
						{			
							 html += tbl_tag(emp);
						});
						$(".tbl-tag").html(html);
					}
					else
					{
					 	html += tbl_tag_2();
						$(".tbl-tag").html(html);
					}
				},
				error 	: 	function(err)
				{
					error_function();
				}
			});
		});
	}

	function ajax_load_approved_leave()
	{
		$(".approved").on("click", function(e)
		{
			$(".tbl-tag").html('<tr><td colspan="7" class="text-center">'+misc('spinner') + '</td></tr>');
			$.ajax({
				url 	: 	"/leave/ajax_load_approved_leave",
				type 	: 	"POST",
				data 	: 	{
					_token:misc('_token')
				},
				success : 	function(result)
				{
					result = JSON.parse(result);
					var html = "";
					
					if(result.length > 0)
					{
						$(result).each(function(index, emp)
						{			
							 html += tbl_tag(emp);
						});
						$(".tbl-tag").html(html);
					}
					else
					{
					 	html += tbl_tag_2();
						$(".tbl-tag").html(html);
					}

				},
				error 	: 	function(err)
				{
					error_function();
				}
			});
		});
	}

	function ajax_load_rejected_leave()
	{
		$(".rejected").on("click", function(e)
		{
			$(".tbl-tag").html('<tr><td colspan="7" class="text-center">'+misc('spinner') + '</td></tr>');
			$.ajax({
				url 	: 	"/leave/ajax_load_rejected_leave",
				type 	: 	"POST",
				data 	: 	{
					_token:misc('_token')
				},
				success : 	function(result)
				{
					result = JSON.parse(result);
					var html = "";

					if(result.length > 0)
					{
						$(result).each(function(index, emp)
						{			
							 html += tbl_tag(emp);
						});
						$(".tbl-tag").html(html);
					}
					else
					{
					 	html += tbl_tag_2();
						$(".tbl-tag").html(html);
					}
		
			
				},
				error 	: 	function(err)
				{
					error_function();
				}
			});
		});
	}

	$(".all").on("click", function(e)
	{
		ajax_all_load_leave();
	});

	function error_function()
	{
		toastr.error("Error, something went wrong.");
	}

	function tbl_tag(data)
	{

		var html = '<tr class="text-center">';
		html += '<td>'+data.payroll_request_leave_date_filed+'</td>';
		html += '<td>'+data.payroll_request_leave_type+'</td>';
		html += '<td>'+data.payroll_request_leave_date+'</td>';
		html += '<td>'+data.payroll_request_leave_total_hours+'</td>';
		html += '<td>'+data.payroll_employee_display_name+'</td>';
		html += '<td>'+data.payroll_request_leave_status+'</td>';
		html += '<td>'+payroll_request_leave_status_level+'</td>';
		html += '</tr>';

		return html;
	}

	function tbl_tag_2()
	{
			var html = '<tr class="text-center">';
			html += '<td colspan="7"><h2 style="margin: 50px; text-align: center;">No Data</h2></td>';
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

	function executeFunctionByName(functionName, context /*, args */) 
	{
	  var args = [].slice.call(arguments).splice(2);
	  var namespaces = functionName.split(".");
	  var func = namespaces.pop();
	  for(var i = 0; i < namespaces.length; i++) {
	    context = context[namespaces[i]];
	  }
	  return context[func].apply(context, args);
	}
}