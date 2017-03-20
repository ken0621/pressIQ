<div class="form-horizontal">
	<div class="form-group">
		<div class="col-md-12">
			<h4>Leave<a href="#" class="popup btn btn-custom-primary pull-right" link="/member/payroll/leave/modal_create_leave_temp">Create Leave</a></h4>

		</div>
	</div>
	<ul class="nav nav-tabs">
	  <li class="active"><a data-toggle="tab" href="#active-leave_temp"><i class="fa fa-star"></i>&nbsp;Active</a></li>
	  <li><a data-toggle="tab" href="#archived-leave_temp"><i class="fa fa-trash-o"></i>&nbsp;Archived</a></li>
	</ul>
	<div class="tab-content padding-top-10">
		  <div id="active-leave_temp" class="tab-pane fade in active">
		  	<table class="table table-condensed table-bordered">
		  		<thead>
		  			<tr>
		  				<th>Leave Name</th>
		  				<th>No of Days.</th>
		  				<th class="text-center">Action</th>
		  			</tr>
		  		</thead>
		  		<tbody>
		  			@foreach($_active as $active)
		  			<tr>
		  				<td>
		  					{{$active->payroll_leave_temp_name}}
		  				</td>
		  				<td>
		  					{{$active->payroll_leave_temp_days_cap}}
		  				</td>
		  				<td class="text-center"> 
		  					<div class="dropdown">
								<button class="btn btn-custom-white dropdown-toggle btn-xs" type="button" data-toggle="dropdown">Action
								<span class="caret"></span></button>
								<ul class="dropdown-menu dropdown-menu-custom">
									<li>
										<a href="#" class="popup" link="/member/payroll/leave/modal_edit_leave_temp/{{$active->payroll_leave_temp_id}}"><i class="fa fa-pencil"></i>&nbsp;Edit</a>
									</li>
									<li>
										<a href="#" class="popup" link="/member/payroll/leave/modal_archived_leave_temp/1/{{$active->payroll_leave_temp_id}}" size="sm"><i class="fa fa-trash-o"></i>&nbsp;Archived</a>
									</li>
								</ul>
							</div>
		  				</td>
		  			</tr>
		  			@endforeach
		  		</tbody>
		  	</table>
		  </div> 
	  <div id="archived-leave_temp" class="tab-pane fade">
		  	<table class="table table-condensed table-bordered">
		  		<thead>
		  			<tr>
		  				<th>Leave Name</th>
		  				<th>No of Days.</th>
		  				<th class="text-center">Action</th>
		  			</tr>
		  		</thead>
		  		<tbody>
		  			@foreach($_archived as $archive)
		  			<tr>
		  				<td>
		  					{{$archive->payroll_leave_temp_name}}
		  				</td>
		  				<td>
		  					{{$archive->payroll_leave_temp_days_cap}}
		  				</td>
		  				<td class="text-center"> 
		  					<div class="dropdown">
								<button class="btn btn-custom-white dropdown-toggle btn-xs" type="button" data-toggle="dropdown">Action
								<span class="caret"></span></button>
								<ul class="dropdown-menu dropdown-menu-custom">
									<li>
										<a href="#" class="popup" link="/member/payroll/leave/modal_edit_leave_temp/{{$archive->payroll_leave_temp_id}}"><i class="fa fa-pencil"></i>&nbsp;Edit</a>
									</li>
									<li>
										<a href="#" class="popup" link="/member/payroll/leave/modal_archived_leave_temp/1/{{$archive->payroll_leave_temp_id}}" size="sm"><i class="fa fa-trash-o"></i>&nbsp;Archived</a>
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
</div>
