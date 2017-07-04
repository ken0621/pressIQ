@extends('member.layout')
@section('css')
@endsection
@section('content')
<div class="panel panel-default panel-block panel-title-block" id="top">
	<div class="panel-heading">
		<div class="col-md-6 padding-lr-1">
			<i class="fa fa-bar-chart" aria-hidden="true"></i>
			<h1>
			<span class="page-title">Alphalist Report</span>
			<small>
			Manage Payroll Reports
			</small>
			</h1>
			<input type="hidden" name="_token" value="{{csrf_token()}}" id="_token">
		</div>
		<div class="col-md-6">
			<div class="col-md-4 padding-lr-2" >
				<input type="text" class="datepicker form-control start-date" name="start_date" placeholder="Start Date" value=""/>
			</div>
			<div class="col-md-4 padding-lr-2">
				<input type="text" class="datepicker form-control end-date" name="end_date" placeholder="End Date" value="" />
			</div>
			<div class="col-md-4 padding-lr-2">
				<button class="btn btm-custom-green btn-block dropdown-toggle " type="button" data-toggle="dropdown"><i class="fa fa-file-excel-o"></i>&nbsp;Export From Excel
				</button>
			</div>
		</div>
	</div>
</div>
<div class="panel panel-default panel-block panel-title-block">
	<div class="panel panel-body">
		<div class="form-horizontal">
			<div class="form-group">
				<div class="col-md-12">
					<div class="col-md-2 padding-lr-1">
						<small>Filter by Company</small>
						<select class="form-control filter-change company_id">
							<option value="0">Select company</option>
							@foreach($_company as $company)
							<option value="{{$company['company']->payroll_company_id}}">{{$company['company']->payroll_company_name}}</option>
							@foreach($company['branch'] as $branch)
							<option value="{{$branch->payroll_company_id}}">&nbsp;&nbsp;• {{$branch->payroll_company_name}}</option>
							@endforeach
							@endforeach
						</select>
					</div>
					<div class="col-md-2 padding-lr-1">
						<small>Filter by Department</small>
						<select class="form-control filter-change department_id">
							<option value="0">Select Department</option>
							@foreach($_department as $department)
							<option value="{{ $department->payroll_department_id }}">{{ $department->payroll_department_name }}</option>
							@endforeach
						</select>
					</div>
				</div>
			</div>
			<div class="form-group table-responsive">
				<div class="col-md-12">
					<table class="table table-bordered table-condensed">
						<thead>
							<tr>
								<th></th>
							</tr>
						</thead>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
@section('script')
<script type="text/javascript" src="/assets/member/js/payroll/payroll_reports.js"></script>
@endsection