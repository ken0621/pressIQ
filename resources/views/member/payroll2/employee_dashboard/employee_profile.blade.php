@extends('member.payroll2.employee_dashboard.layout')
@section('content')
  <ol class="breadcrumb">
    <li class="breadcrumb-item">
      <a href="/employee">Dashboard</a>
    </li>
    <li class="breadcrumb-item active">{{ $page }}</li>
  </ol>
	<div class="pull-right">
		<a href="javascript:" onClick="action_load_link_to_modal('/edit_employee_profile', 'lg')"><button type="button" class="btn btn-default btn-xs">Edit Information</button></a>
	</div>
	<br>
	<div class="row">
		<div class="center-block">
	    	<img src="{{ $company->payroll_company_logo }}" alt="{{ $company->payroll_company_name }}" height="120" class="center-block">            
		</div>    
		<div class="col-md-12">
	   		<h4 class="text-center">{{ $employee->payroll_employee_display_name }}</h4>
			<p class="text-center">{{ $employee->payroll_jobtitle_name }}</p>
		</div>
	</div>
	{{csrf_field()}}
	@if(session()->has('warning'))
	    <div class="alert alert-success">
	      <strong>Updated Successfully!</strong>
	    </div>
	@endif
	<div class="container"><h1></h1></div>
		<div id="exTab1" class="container">	
			<ul  class="nav nav-tabs">
				<li class="active"><a  href="#1a" data-toggle="tab">Personal Information</a></li>
				<li><a href="#2a" data-toggle="tab">Job Information</a></li>
				<li><a href="#3a" data-toggle="tab">Government Information</a></li>
			</ul>
			<div class="tab-content">
				<div class="tab-pane active" id="1a">
					<div class="row">
					    <div class="col-md-6">
							<small>Full Name</small>
							<input class="form-control" value="{{ $employee->payroll_employee_display_name }}" disabled>
					  	</div>
					  	<div class="col-md-3">
					      	<small>Gender</small>
							<input class="form-control" value="{{ $employee->payroll_employee_gender }}" disabled>
						</div>
					  	<div class="col-md-3">
					      	<small>Birthdate</small>
							<input class="form-control" value="{{ date('M d, Y',strtotime($employee->payroll_employee_birthdate)) }}" disabled>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<small>Address</small>
							<input class="form-control" value="{{ $employee->payroll_employee_street.' '.$employee->payroll_employee_city.' '.$employee->payroll_employee_state }}" disabled>
					  	</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<small>Contact Number</small>
							<input class="form-control" value="{{ $employee->payroll_employee_contact }}" disabled>
					  	</div>
						<div class="col-md-6">
							<small>Email Address</small>
							<input class="form-control" value="{{ $employee->payroll_employee_email }}" disabled>
					  	</div>
					</div>
				</div>
				<div class="tab-pane active" id="2a">
					<div class="row">
						<div class="col-md-6">
							<small>Company Name</small>
							<input class="form-control" value="{{ $employee->payroll_company_name }}" disabled>
					  	</div>
						<div class="col-md-6">
							<small>Location</small>
							<input class="form-control" value="{{ $company->payroll_company_address }}" disabled>
					  	</div>
					</div>
					<div class="row">
					    <div class="col-md-2">
							<small>Employee No.</small>
							<input class="form-control" value="{{ $employee->payroll_employee_number }}" disabled>
					  	</div>
					  	<div class="col-md-5">
					      	<small>Title</small>
							<input class="form-control" value="{{ $employee->payroll_jobtitle_name }}" disabled>
						</div>
					  	<div class="col-md-5">
					      	<small>Department</small>
							<input class="form-control" value="{{ $employee->payroll_department_name }}" disabled>
						</div>
					</div>
					<div class="row">
						<div class="col-md-4">
							<small>Employment Status</small>
							<input class="form-control" value="{{ $employee->payroll_employee_contract_status }}" disabled>
					  	</div>
					  	<div class="col-md-4">
							<small>Shift</small>
							<input class="form-control" value="{{ $employee->payroll_employee_title_name }}" disabled>
					  	</div>
						<div class="col-md-4">
							<small>Start Date</small>
							<input class="form-control" value="{{ date('M d, Y',strtotime($startdate->payroll_employee_contract_date_hired)) }}" disabled>
					  	</div>
					</div>
				</div>
				<div class="tab-pane active" id="3a">
					<div class="row">
						<div class="col-md-6">
							<small>TIN No.</small>
							<input class="form-control" value="{{ $employee->payroll_employee_tin }}" disabled>
					  	</div>
					<div class="col-md-6">
							<small>SSS No.</small>
							<input class="form-control" value="{{ $employee->payroll_employee_sss }}" disabled>
					  	</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<small>PAGIBIG No.</small>
							<input class="form-control" value="{{ $employee->payroll_employee_pagibig }}" disabled>
					  	</div>
						<div class="col-md-6">
							<small>PHILHEATH No.</small>
							<input class="form-control" value="{{ $employee->payroll_employee_philhealth }}" disabled>
					  	</div>
					</div>
					<div class="row">
						
					</div>
				</div>
			</div>
		</div>
	</div>
</form>
@endsection

