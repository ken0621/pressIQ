<h4>Department <button class="btn btn-custom-primary pull-right popup" link="/member/payroll/departmentlist/department_modal_create">Create Department</button></h4>
<ul class="nav nav-tabs">
	<li class="active"><a data-toggle="tab" href="#active-department"><i class="fa fa-star"></i>&nbsp;Active Department</a></li>
	<li><a data-toggle="tab" href="#archived-department"><i class="fa fa-trash-o"></i>&nbsp;Archived Department</a></li>
</ul>
<div class="tab-content padding-10">
	<div id="active-department" class="tab-pane fade in active">
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
									<a href="#" data-content="{{$active->payroll_department_id}}" data-archived="1" class="btn-archived" data-action="/departmentlist/archived_department" data-trigger="department"><i class="fa fa-trash-o"></i>&nbsp;Archived</a>
								</li>
							</ul>
						</div>
					</td>
				</tr>
				@endforeach
			</tbody>
		</table>
	</div>
	<div id="archived-department" class="tab-pane fade">
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
									<a href="#" class="popup" link="/member/payroll/departmentlist/modal_edit_department/{{$archived->payroll_department_id}}" ><i class="fa fa-pencil"></i>&nbsp;Edit</a>
								</li>
								<li>
									<a href="#" data-content="{{$archived->payroll_department_id}}" data-archived="0" class="btn-archived" data-action="/departmentlist/archived_department" data-trigger="department"><i class="fa fa-recycle"></i>&nbsp;Restore</a>
								</li>
							</ul>
						</div>
					</td>
				</tr>
				@endforeach
			</tbody>
		</table>
	</div>
</div>