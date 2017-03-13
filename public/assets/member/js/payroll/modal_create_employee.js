var modal_create_employee = modal_create_employee();

function modal_create_employee()
{
	init()

	function init()
	{
		file_requirement_change_event();
		remove_requirements();
		select_change_action();
		select_change_event();
	}

	function file_requirement_change_event()
	{
		$(".file-requirements").unbind("change");
		$(".file-requirements").bind("change", function()
		{
			var file = $(this)[0].files[0];
			var parent = $(this).parents("tr");
			parent.find("label").addClass("display-none");
			var a_href = parent.find(".a-file-name");
			a_href.removeClass("display-none");
			a_href.html(file.name);

			var progress_container	= parent.find(".custom-progress-container-100");
			progress_container.removeClass("display-none");
			var progress_div 		= parent.find(".custom-progress");
			var removefile			= parent.find(".remove-requirements");
			var requirement_input 	= parent.find(".requirement-input");
			var checkbox			= parent.find("input[type=checkbox]");

			var formdata 	= new FormData();
			var ajax 		= new XMLHttpRequest();

			formdata.append("file",file);
			formdata.append("_token",misc('_token'));

			/* uploading with progress */
			ajax.upload.addEventListener("progress", function(event)
			{
				var progress = ( event.loaded / event.total ) * 100;
				progress_div.css("width",progress + "%");
			}, false);

			/* on complete upload */
			ajax.addEventListener("load", function(event)
			{
				var json = JSON.parse(event.target.responseText);
				progress_container.addClass("display-none");
				progress_div.css("width","0%");
				removefile.removeClass("display-none");
				removefile.attr("data-content",json.data.payroll_requirements_id);
				a_href.attr("href",json.data.path);
				requirement_input.val(json.data.payroll_requirements_id);
				checkbox.prop("checked", true);
			}, false);

			/* on error */
			ajax.addEventListener("error", function(event){

				error_function();
				parent.find("label").removeClass("display-none");
				a_href.addClass("display-none");
				progress_container.addClass("display-none");
				progress_div.css("width","0%");

			}, false);

			/* on abort */
			ajax.addEventListener("abort", function()
			{
				toastr.error("File upload aborted");
				parent.find("label").removeClass("display-none");
				a_href.addClass("display-none");
				progress_container.addClass("display-none");
				progress_div.css("width","0%");
			}, false);

			ajax.open("POST","/member/payroll/employee_list/employee_updload_requirements");
			ajax.send(formdata);

		});
	}


	function select_change_event()
	{
		// jobtitle-select
		$(".department-select").unbind("change");
		$(".department-select").bind("change", function()
		{
			select_change_action();
		});
	}

	function select_change_action()
	{
		var payroll_department_id = $(".department-select").val();
		var pre_data = '<option value="">...loading job title</option>';
		$(".jobtitle-select").html(pre_data);
		$.ajax(
			{
				url 	: 	"/member/payroll/jobtitlelist/get_job_title_by_department",
				type 	: 	"POST",
				data 	: 	{
					payroll_department_id:payroll_department_id,
					_token:misc('_token')
				},
				success : 	function(result)
				{
					var json = JSON.parse(result);

					var html = '<option value="">Select Job Title</option>';

					$(json).each(function(index, data)
					{
						html += '<option value="'+data.payroll_jobtitle_id+'">'+data.payroll_jobtitle_name+'</option>';
					});
					$(".jobtitle-select").html(html);
				},
				error 	: 	function(err)
				{
					error_function();
				}
			});
	}

	function remove_requirements()
	{
		$(".remove-requirements").unbind("click");
		$(".remove-requirements").bind("click", function()
		{
			var content 			= $(this).data("content");
			var parent 				= $(this).parents("tr");
			var checkbox 			= parent.find("input[type=checkbox]");
			var a_href 				= parent.find(".a-file-name");
			var requirement_input 	= parent.find(".requirement-input");
			var label 				= parent.find("label");
			var removefile 			= parent.find(".remove-requirements");
			var con 				= confirm("Do you really want to permanently remove " + a_href.html() + "?");
			var original_html		= $(this).html();

			if(con)
			{
				removefile.html(misc("spinner"));
				$.ajax({
					url 	: 	"/member/payroll/employee_list/remove_employee_requirement",
					type 	: 	"POST",
					data 	: 	{
						_token:misc('_token'),
						content:content
					},
					success : 	function(result)
					{
						a_href.attr("href","#");
						a_href.html("");
						a_href.addClass("display-none");
						requirement_input.val("");
						label.removeClass("display-none");
						removefile.addClass("display-none");
						removefile.html(original_html);
						checkbox.prop("checked", false);
						remove_requirements();

						file_requirement_change_event();
					},
					error 	: 	function(err)
					{
						error_function();
						removefile.html(original_html);
						remove_requirements();
					}
				});
			}
		});
	}

	function error_function()
	{
		toastr.error("Error, something went wrong.");
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
}