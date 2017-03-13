@extends('member.layout')

@section('css')
@endsection

@section('content')
<div class="panel panel-default panel-block panel-title-block" id="top">
	<div class="panel-heading">
		<div>
			<i class="fa fa-group"></i>
			<h1>
			<span class="page-title">Employee List</span>
			<small>
			Employee 201 files
			</small>
			</h1>
			<button class="btn btn-custom-primary panel-buttons pull-right popup" link="/member/payroll/employee_list/modal_create_employee" size="lg">Create Employee</button>
			<input type="hidden" name="_token" value="{{csrf_token()}}" id="_token">
		</div>
	</div>
</div>
<ul class="nav nav-tabs">
  <li class="active"><a data-toggle="tab" href="#active-employee"><i class="fa fa-star"></i>&nbsp;Active Employee</a></li>
  <li><a data-toggle="tab" href="#separated-employee"><i class="fa fa-scissors"></i>&nbsp;Separated Employee</a></li>

</ul>

<div class="tab-content tab-pane-div">
  <div id="active-employee" class="tab-pane fade in active">
  	<table class="table table-condensed table-bordered">
  		<thead>
  			<tr>
  				<th>Employee No</th>
  				<th>Employee Name</th>
  				<th>Employee Company</th>
  				<th>Department</th>
  				<th>Position</th>
  				<th class="text-center">Action</th>
  			</tr>
  		</thead>
  		@foreach($_active as $active)
  		<tr>
  			<td>
  				{{$active->payroll_employee_number}}
  			</td>
  			<td>
  				{{$active->payroll_employee_display_name}}
  			</td>
  			<td>
  				{{$active->payroll_company_name}}
  			</td>
  			<td>
  				{{$active->payroll_department_name}}
  			</td>
  			<td>
  				{{$active->payroll_jobtitle_name}}
  			</td>
  			<td class="text-center">
  				<div class="dropdown">
					<button class="btn btn-custom-white dropdown-toggle btn-xs" type="button" data-toggle="dropdown">Action
					<span class="caret"></span></button>
					<ul class="dropdown-menu dropdown-menu-custom">
						<li>
							<a href="#" class="popup" link="/member/payroll/employee_list/modal_employee_view/{{$active->payroll_employee_id}}" size="lg"><i class="fa fa-search"></i>&nbsp;View</a>
						</li>
					</ul>
				</div>
  			</td>
  		</tr>
  		@endforeach
  	</table>
  </div>
  <div id="separated-employee" class="tab-pane fade">
 
  </div>
</div>
@endsection

@section('script')
<script type="text/javascript" src="/assets/member/js/payroll/employeelist.js"></script>
@endsection