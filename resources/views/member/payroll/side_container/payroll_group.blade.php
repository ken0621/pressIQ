<div class="form-horizontal">
	<div class="form-group">
		<div class="col-md-12">
			<h4>Payroll Group<button class="btn btn-custom-primary pull-right popup" link="/member/payroll/payroll_group/modal_create_payroll_group" size="lg">Create Payroll Group</button></h4>
		</div>
	</div>
	<ul class="nav nav-tabs">
		<li class="active"><a data-toggle="tab" href="#active-payroll-group"><i class="fa fa-star"></i>&nbsp;Active Job Title</a></li>
		<li><a data-toggle="tab" href="#archived-payroll-group"><i class="fa fa-trash-o"></i>&nbsp;Archived</a></li>
	</ul>
	<div class="tab-content padding-10">
		<div id="active-payroll-group" class="tab-pane fade in active">
			<table class="table table-condensed table-bordered">
				<thead>
					<tr>
						<th>Paryoll Code</th>
						<th>Computation</th>
						<th>Period</th>
						<th>13 Month</th>
						<th class="text-center">Action</th>
					</tr>
				</thead>
				<tbody>
				@foreach($_active as $active)
				<tr>
					<td>
						{{$active->payroll_group_code}}
					</td>
					<td>
						{{$active->payroll_group_salary_computation}}
					</td>
					<td>
						{{$active->payroll_group_period}}
					</td>
					<td>
						{{$active->payroll_group_13month_basis}}
					</td>
					<td class="text-center">
						<div class="dropdown">
							<button class="btn btn-custom-white dropdown-toggle btn-xs" type="button" data-toggle="dropdown">Action
							<span class="caret"></span></button>
							<ul class="dropdown-menu dropdown-menu-custom">
								<li>
									<a href="#" class="popup" link="/member/payroll/payroll_group/modal_edit_payroll_group/{{$active->payroll_group_id}}" size="lg"><i class="fa fa-pencil"></i>&nbsp;Edit</a>
								</li>
								<li>
									<a href="#" dclass="popup" link=""><i class="fa fa-trash-o"></i>&nbsp;Archived</a>
								</li>
							</ul>
						</div>
					</td>
				</tr>
				@endforeach
				</tbody>
			</table>
			
		</div>
		<div id="archive-payroll-group" class="tab-pane fade"></div>
	</div>
</div>