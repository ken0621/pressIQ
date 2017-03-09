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
		<div class="col-md-4">
			<div class="panel panel-default">
				<div class="panel-body background-white">
					<table class="table table-condensed table-bordered">
						<tr>
							<td>
								<a href="/member/payroll/departmentlist" class="a-navigation-configuration">Department</a>
							</td>
						</tr>
						<tr>
							<td>
								<a href="#" class="a-navigation-configuration">Job Title</a>
							</td>
						</tr>
						<tr>
							<td>
								<a href="#" class="a-navigation-configuration">Holiday</a>
							</td>
						</tr>
						<tr>
							<td>
								<a href="#" class="a-navigation-configuration">Allowances</a>
							</td>
						</tr>
						<tr>
							<td>
								<a href="#" class="a-navigation-configuration">Deductions</a>
							</td>
						</tr>
						<tr>
							<td>
								<a href="#" class="a-navigation-configuration">Leave</a>
							</td>
						</tr>
					</table>
				</div>
			</div>
		</div>
		<div class="col-md-8">
			<div class="panel panel-default">
				<div class="panel-body background-white configuration-div"></div>
			</div>
		</div>
	</div>
</div>
@endsection
@section('script')
<script type="text/javascript" src="/assets/member/js/payroll/departmentlist.js"></script>
@endsection