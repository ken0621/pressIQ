<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal">×</button>
	<h4 class="modal-title">Shift Schedule</h4>
	<input type="hidden" value="{{$id}}" id="payroll_period_id" name="payroll_period_id">
	<input type="hidden" name="_token" value="{{csrf_token()}}">
</div>
<div class="modal-body form-horizontal">
	<div class="form-group">
		<div class="col-md-4">
			<div class="list-group">
			  <a href="#" class="list-group-item active">First item</a>
			  <a href="#" class="list-group-item">Second item</a>
			  <a href="#" class="list-group-item">Third item</a>
			</div>
		</div>
		<div class="col-md-8">
			<div class="form-group">
				<div class="col-md-12">
					<small>Select By Company</small>
					<select class="form-control form-select">
						<option value="">Select</option>
						@foreach($_company as $company)
						<option value="{{$company->payroll_company_id}}">{{$company->payroll_company_name}}</option>
						@endforeach
					</select>
				</div>				
			</div>
			<div class="form-group">
				<div class="col-md-6">
					<small>Select By Department</small>
					<select class="form-control department-select">
						<option value="">Select Department</option>
						@foreach($_department as $department)
						<option value="{{$department->payroll_department_id}}">{{$department->payroll_department_name}}</option>
						@endforeach
					</select>
				</div>
				<div class="col-md-6">
					<small>Select By Job Title</small>
					<select class="form-control form-select jobtitle-select">
						<option value="">Select By Job Title</option>
						@foreach($_jobtitle as $jobtitle)
						<option value="{{$jobtitle->payroll_jobtitle_id}}">{{$jobtitle->payroll_jobtitle_name}}</option>
						@endforeach
					</select>
				</div>
			</div>
			<div class="form-group">
				<div class="col-md-12">
					<small>Select By Employee</small>
					<select class="form-control select-employee form-select">
						<option value="">Select By Employee</option>
					</select>
				</div>
			</div>
			<hr>
			<div class="form-group">
				<div class="col-md-12 div-schedule-tbl"></div>
			</div>
		</div>
	</div>
</div>
<div class="modal-footer">
	<button type="button" class="btn btn-def-white btn-custom-white" data-dismiss="modal">Done</button>
	<!-- <button class="btn btn-primary btn-custom-primary" type="button"">Submit</button> -->
</div>

<script type="text/javascript">
	$(".form-select").globalDropList({
		hasPopup                : "false",
		link_size               : "lg",
		width                   : "100%",
		maxHeight				: "129px",
		placeholder             : "Select Employee",
		no_result_message       : "No result found!",
		onChangeValue           : function(){},
		onCreateNew             : function(){},
	});


	$(".department-select").globalDropList({
		hasPopup                : "false",
		link_size               : "lg",
		width                   : "100%",
		maxHeight				: "129px",
		placeholder             : "Select Employee",
		no_result_message       : "No result found!",
		onChangeValue           : function(){
			select_change_action($(this).val());
			$(".jobtitle-select").globalDropList("reload");
			$(".jobtitle-select").globalDropList({
				placeholder : '...loading'
			});
		},
	});

	function select_change_action(payroll_department_id = 0, selected = 0)
	{
		// var payroll_department_id = $(".department-select").val();
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
					$(".jobtitle-select").globalDropList("destroy");
					$(".jobtitle-select").globalDropList({
						link 		: '/member/payroll/jobtitlelist/modal_create_jobtitle?selected='+payroll_department_id,
						link_size 	: 'md',
						placeholder : 'Job Title',
						width 		: '100%'
					});
					$(".jobtitle-select").globalDropList("reload");
					$(".jobtitle-select").val(selected).change();
					
				},
				error 	: 	function(err)
				{
					error_function(selected).change();
				}
			});
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

</script>
