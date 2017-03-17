<div class="form-horizontal">
	<div class="form-group">
		<div class="col-md-12">
			<h4>Deduction<button class="btn btn-custom-primary pull-right popup" link="/member/payroll/deduction/modal_create_deduction">Create Deduction</button></h4>
		</div>
	</div>
	<ul class="nav nav-tabs">
	  <li class="active"><a data-toggle="tab" href="#active-deduction"><i class="fa fa-star"></i>&nbsp;Active</a></li>
	  <li><a data-toggle="tab" href="#archived-deduction"><i class="fa fa-trash-o"></i>&nbsp;Archived</a></li>
	</ul>

	<div class="tab-content padding-top-10">
	  <div id="active-deduction" class="tab-pane fade in active">
	   <table class="table table-bordered table-condensed">
	   	<thead>
	   		<tr>
	   			<th>Deduction Name</th>
	   			<th>Category</th>
	   			<th>Type</th>
	   			<th>Effective Date</th>
	   			<th>Amount</th>
	   			<th class="text-center">Action</th>
	   		</tr>
	   	</thead>
	   	<tbody>
	   		@foreach($_active as $active)
	   		<tr>
	   			<td>
	   				{{$active->payroll_deduction_name}}
	   			</td>
	   			<td>
	   				{{$active->payroll_deduction_category}}
	   			</td>
	   			<td>
	   				{{$active->payroll_deduction_type_name}}
	   			</td>
	   			<td>
	   				{{date('M d, Y', strtotime($active->payroll_deduction_date_start))}}
	   			</td>
	   			<td class="text-right">
	   				{{number_format($active->payroll_deduction_amount, 2)}}
	   			</td>
	   			<td class="text-center">
	   				<div class="dropdown">
						<button class="btn btn-custom-white dropdown-toggle btn-xs" type="button" data-toggle="dropdown">Action
						<span class="caret"></span></button>
						<ul class="dropdown-menu dropdown-menu-custom">
							<li>
								<a href="#" class="popup" link="/member/payroll/deduction/modal_edit_deduction/{{$active->payroll_deduction_id}}"><i class="fa fa-pencil"></i>&nbsp;Edit</a>
							</li>
							<li>
								<a href="#" class="popup" link="/member/payroll/deduction/archive_deduction/1/{{$active->payroll_deduction_id}}" size="sm"><i class="fa fa-trash-o"></i>&nbsp;Archived</a>
							</li>
						</ul>
					</div>
	   			</td>
	   		</tr>
	   		@endforeach
	   	</tbody>
	   </table>
	  </div>
	  <div id="archived-deduction" class="tab-pane fade">
	    <table class="table table-bordered table-condensed">
		   	<thead>
		   		<tr>
		   			<th>Deduction Name</th>
		   			<th>Category</th>
		   			<th>Typ</th>
		   			<th>Effective Date</th>
		   			<th>Amount</th>
		   			<th class="text-center">Action</th>
		   		</tr>
		   	</thead>
	   		<tbody>
	   		@foreach($_archived as $archived)
	   		<tr>
	   			<td>
	   				{{$archived->payroll_deduction_name}}
	   			</td>
	   			<td>
	   				{{$archived->payroll_deduction_category}}
	   			</td>
	   			<td>
	   				{{$archived->payroll_deduction_type_name}}
	   			</td>
	   			<td>
	   				{{date('M d, Y', strtotime($archived->payroll_deduction_date_start))}}
	   			</td>
	   			<td class="text-right">
	   				{{number_format($archived->payroll_deduction_amount, 2)}}
	   			</td>
	   			<td class="text-center">
	   				<div class="dropdown">
						<button class="btn btn-custom-white dropdown-toggle btn-xs" type="button" data-toggle="dropdown">Action
						<span class="caret"></span></button>
						<ul class="dropdown-menu dropdown-menu-custom">
							<li>
								<a href="#" class="popup" link="/member/payroll/deduction/modal_edit_deduction/{{$archived->payroll_deduction_id}}"><i class="fa fa-pencil"></i>&nbsp;Edit</a>
							</li>
							<li>
								<a href="#" class="popup" link="/member/payroll/deduction/archive_deduction/0/{{$archived->payroll_deduction_id}}" size="sm"><i class="fa fa-refresh"></i>&nbsp;Restore</a>
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