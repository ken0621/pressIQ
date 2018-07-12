<h4>Department <button class="btn btn-custom-primary pull-right popup" link="/member/payroll/departmentlist/department_modal_create">Create Department</button></h4>
<ul class="nav nav-tabs">
	<li class="active"><a data-toggle="tab" href="#active-department"><i class="fa fa-star"></i>&nbsp;Active Department</a></li>
	<li><a data-toggle="tab" href="#archived-department"><i class="fa fa-trash-o"></i>&nbsp;Archived Department</a></li>
</ul>
<div class="tab-content padding-10">
	<div id="active-department" class="tab-pane fade in active">
		<div class="load-data" target="value-id-1">
			<div id="value-id-1">
				<table class="table tabel-hover table-condensed table-bordered">
					<thead>
						<tr>
							<th>Department Name</th>
							<th class="text-center">Action</th>
						</tr>
					</thead>
					<tbody>
						@foreach($_active as $active)
						<tr>
							<td>
								{{$active->payroll_department_name}}
							</td>
							<td class="text-center">
								<div class="dropdown">
									<button class="btn btn-custom-white dropdown-toggle btn-xs" type="button" data-toggle="dropdown">Action
									<span class="caret"></span></button>
									<ul class="dropdown-menu dropdown-menu-custom">
										<li>
											<a href="#" class="popup" link="/member/payroll/departmentlist/modal_view_department/{{$active->payroll_department_id}}" ><i class="fa fa-search"></i>&nbsp;View</a>
										</li>
										<li>
											<a href="#" class="popup" link="/member/payroll/departmentlist/modal_edit_department/{{$active->payroll_department_id}}" ><i class="fa fa-pencil"></i>&nbsp;Edit</a>
										</li>
										<li>
											<a href="#" class="popup" link="/member/payroll/departmentlist/modal_archived_department/1/{{$active->payroll_department_id}}" size="sm"><i class="fa fa-trash-o"></i>&nbsp;Archived</a>
										</li>
									</ul>
								</div>
							</td>
						</tr>
						@endforeach
					</tbody>				
				</table>
				<div class="pagination"> {!! $_active->render() !!} </div>
			</div>
		</div>
	</div>
	<div id="archived-department" class="tab-pane fade">
		<div class="load-data" target="value-id-2">
			<div id="value-id-2">
				<table class="table tabel-hover table-condensed table-bordered">
					<thead>
						<tr>
							<th>Department Name</th>
							<th class="text-center">Action</th>
						</tr>
					</thead>
					<tbody>
						@foreach($_archived as $archived)
						<tr>
							<td>
								{{$archived->payroll_department_name}}
							</td>
							<td class="text-center">
								<div class="dropdown">
									<button class="btn btn-custom-white dropdown-toggle btn-xs" type="button" data-toggle="dropdown">Action
									<span class="caret"></span></button>
									<ul class="dropdown-menu dropdown-menu-custom">
										<li>
											<a href="#" class="popup" link="/member/payroll/departmentlist/modal_view_department/{{$archived->payroll_department_id}}" ><i class="fa fa-search"></i>&nbsp;View</a>
										</li>										
										<li>
											<a href="#" class="popup" link="/member/payroll/departmentlist/modal_archived_department/0/{{$archived->payroll_department_id}}" size="sm"><i class="fa fa-trash-o"></i>&nbsp;Restore</a>
										</li>
									</ul>
								</div>
							</td>
						</tr>
						@endforeach
					</tbody>
				</table>
				<div class="pagination"> {!! $_archived->render() !!} </div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	function loading_done_paginate (data)
	{
		console.log(data);
	}
</script>

<script type="text/javascript" src="/assets/member/js/paginate_ajax_multiple.js"></script>