<div class="form-horizontal">
	<div class="form-group">
		<div class="col-md-12">
			<h4>Allowances<a href="#" class="popup btn btn-custom-primary pull-right" link="/member/payroll/allowance/modal_create_allowance">Create Allowance</a></h4>
		</div>
	</div>
	<ul class="nav nav-tabs">
	  <li class="active"><a data-toggle="tab" href="#active-allowance"><i class="fa fa-star"></i>&nbsp;Active</a></li>
	  <li><a data-toggle="tab" href="#archived-allowance"><i class="fa fa-trash-o"></i>&nbsp;Archived</a></li>
	</ul>
	<div class="tab-content padding-top-10">
	  <div id="active-allowance" class="tab-pane fade in active">
	  	<table class="table table-condensed table-bordered">
	  		<thead>
	  			<tr>
	  				<th>Allowance Name</th>
	  				<th>Category</th>
	  				<th>Amount</th>
	  				<th class="text-center">Action</th>
	  			</tr>
	  		</thead>
	  		<tbody>
	  			@foreach($_active as $active)
	  			<tr>
	  				<td>
	  					{{$active->payroll_allowance_name}}
	  				</td>
	  				<td>
	  					{{$active->payroll_allowance_category}}
	  				</td>
	  				<td class="text-right">
	  					{{number_format($active->payroll_allowance_amount, 2)}}
	  				</td>
	  				<td class="text-center"> 
	  					<div class="dropdown">
							<button class="btn btn-custom-white dropdown-toggle btn-xs" type="button" data-toggle="dropdown">Action
							<span class="caret"></span></button>
							<ul class="dropdown-menu dropdown-menu-custom">
								<li>
									<a href="#" class="popup" link="/member/payroll/allowance/modal_edit_allowance/{{$active->payroll_allowance_id}}"><i class="fa fa-pencil"></i>&nbsp;Edit</a>
								</li>
								<li>
									<a href="#" class="popup" link="/member/payroll/allowance/modal_archived_allwance/1/{{$active->payroll_allowance_id}}" size="sm"><i class="fa fa-trash-o"></i>&nbsp;Archived</a>
								</li>
							</ul>
						</div>
	  				</td>
	  			</tr>
	  			@endforeach
	  		</tbody>
	  	</table>
	  </div> 
	  <div id="archived-allowance" class="tab-pane fade">
	  	<table class="table table-condensed table-bordered">
	  		<thead>
	  			<tr>
	  				<th>Allowance Name</th>
	  				<th>Category</th>
	  				<th>Amount</th>
	  				<th class="text-center">Action</th>
	  			</tr>
	  		</thead>
	  		<tbody>
	  			@foreach($_archived as $archived)
	  			<tr>
	  				<td>
	  					{{$archived->payroll_allowance_name}}
	  				</td>
	  				<td>
	  					{{$archived->payroll_allowance_category}}
	  				</td>
	  				<td class="text-right">
	  					{{number_format($archived->payroll_allowance_amount, 2)}}
	  				</td>
	  				<td class="text-center">
	  					<div class="dropdown">
							<button class="btn btn-custom-white dropdown-toggle btn-xs" type="button" data-toggle="dropdown">Action
							<span class="caret"></span></button>
							<ul class="dropdown-menu dropdown-menu-custom">
								<li>
									<a href="#" class="popup" link="/member/payroll/allowance/modal_edit_allowance/{{$archived->payroll_allowance_id}}"><i class="fa fa-pencil"></i>&nbsp;Edit</a>
								</li>
								<li>
									<a href="#" class="popup" link="/member/payroll/allowance/modal_archived_allwance/0/{{$archived->payroll_allowance_id}}" size="sm"><i class="fa fa-refresh"></i>&nbsp;Restore</a>
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