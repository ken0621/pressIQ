<h4>Job Title <button class="btn btn-custom-primary pull-right popup" link="/member/payroll/jobtitlelist/modal_create_jobtitle">Create Job Title</button></h4>
<ul class="nav nav-tabs">
	<li class="active"><a data-toggle="tab" href="#active-department"><i class="fa fa-star"></i>&nbsp;Active Job Title</a></li>
	<li><a data-toggle="tab" href="#archived-department"><i class="fa fa-trash-o"></i>&nbsp;Archived Job Title</a></li>
</ul>
<div class="tab-content padding-10">
	<div id="active-department" class="tab-pane fade in active">
		<table class="table tabel-hover table-condensed table-bordered">
			<thead>
				<tr>
					<th>Job Title Name</th>
					<th>Department</th>
					<th class="text-center">Action</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>
					</td>
					<td></td>
					<td class="text-center">
						<div class="dropdown">
							<button class="btn btn-custom-white dropdown-toggle btn-xs" type="button" data-toggle="dropdown">Action
							<span class="caret"></span></button>
							<ul class="dropdown-menu dropdown-menu-custom">
								<li>
									<a href="#" class="popup" link="" ><i class="fa fa-search"></i>&nbsp;View</a>
								</li>
								<li>
									<a href="#" class="popup" link="" ><i class="fa fa-pencil"></i>&nbsp;Edit</a>
								</li>
								<li>
									<a href="#" data-content="" data-archived="1" class="btn-archived" data-action="" data-trigger="job title"><i class="fa fa-trash-o"></i>&nbsp;Archived</a>
								</li>
							</ul>
						</div>
					</td>
				</tr>
			</tbody>
		</table>
	</div>
	<div id="archived-department" class="tab-pane fade">
		<table class="table tabel-hover table-condensed table-bordered">
			<thead>
				<tr>
					<th>Department Name</th>
					<th>Department</th>
					<th class="text-center">Action</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>
					</td>
					<td></td>
					<td class="text-center">
						<div class="dropdown">
							<button class="btn btn-custom-white dropdown-toggle btn-xs" type="button" data-toggle="dropdown">Action
							<span class="caret"></span></button>
							<ul class="dropdown-menu dropdown-menu-custom">
								<li>
									<a href="#" class="popup" link="" ><i class="fa fa-search"></i>&nbsp;View</a>
								</li>
								<li>
									<a href="#" class="popup" link="" ><i class="fa fa-pencil"></i>&nbsp;Edit</a>
								</li>
								<li>
									<a href="#" data-content="" data-archived="0" class="btn-archived" data-action="" data-trigger="job title"><i class="fa fa-recycle"></i>&nbsp;Restore</a>
								</li>
							</ul>
						</div>
					</td>
				</tr>
			</tbody>
		</table>
	</div>
</div>