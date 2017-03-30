@extends('member.layout')
@section('css')
@endsection
@section('content')
<div class="panel panel-default panel-block panel-title-block" id="top">
	<div class="panel-heading">
		<div>
			<i class="fa fa-gears"></i>
			<h1>
			<span class="page-title">Payroll Configuration</span>
			<small>
			Payroll Settings
			</small>
			</h1>
			<input type="hidden" name="_token" value="{{csrf_token()}}" id="_token">
		</div>
	</div>
</div>
<div class="form-horizontal">
	<div class="form-gorup">
		<div class="col-md-3">
			<div class="panel panel-default">
				<div class="panel-body background-white">
					<div class="list-group">

					  <a href="/member/payroll/departmentlist" class="list-group-item  a-navigation-configuration">Department</a>

					  <a href="/member/payroll/jobtitlelist" class="list-group-item a-navigation-configuration">Job Title</a>

					  <a href="/member/payroll/holiday" class="list-group-item a-navigation-configuration">Holiday</a>

					  <a href="/member/payroll/allowance" class="list-group-item a-navigation-configuration">Allowances</a>

					  <a href="/member/payroll/deduction" class="list-group-item a-navigation-configuration">Deductions</a>

					  <a href="/member/payroll/leave" class="list-group-item a-navigation-configuration">Leave</a>

					  <a href="/member/payroll/payroll_group" class="list-group-item a-navigation-configuration">Payroll Group</a>

					  <a href="/member/payroll/tax_period" class="list-group-item a-navigation-configuration">Tax Period</a>

					  <a href="/member/payroll/tax_table_list" class="list-group-item a-navigation-configuration">Tax Table</a>

					  <a href="/member/payroll/sss_table_list" class="list-group-item a-navigation-configuration">SSS Table</a>

					  <a href="/member/payroll/philhealth_table_list" class="list-group-item a-navigation-configuration">Philhealth Table</a>

					  <a href="/member/payroll/pagibig_formula" class="list-group-item a-navigation-configuration">Pagibig/HDMF</a>

					</div>
					
				</div>
			</div>
		</div>
		<div class="col-md-9">
			<div class="panel panel-default">
				<div class="panel-body background-white configuration-div"></div>
			</div>
		</div>
	</div>
</div>
@endsection
@section('script')

<script type="text/javascript" src="/assets/member/js/payroll/payrollconfiguration.js"></script>
@endsection