@extends('member.layout')

@section('content')

<div class="panel panel-default panel-block panel-title-block">
    <input type="hidden" name="_token" id="_token" value="{{csrf_token()}}"/>
    <div class="panel-heading">
        <div>
            <i class="fa fa-calendar"></i>
            <h1>
                <span class="page-title">Timesheet</span>
                <small>
                Time Record for Employee (Guillermo Tabligan)
                </small>
            </h1>
            
            <a href="javascript:" class="panel-buttons btn btn-custom-primary pull-right popup" link="/member/payroll/import_bio/modal_biometrics">Import Time Sheet</a>
        </div>
    </div>
</div>
<div class="panel panel-default panel-block panel-title-block">
    <div class="panel-body">
        <div class="search-filter-box">
            <div class="col-md-5" style="padding: 10px">
            	<span style="font-size: 18px;">February 26, 2017 to March 10, 2017</span>
            </div>
            <div class="col-md-4 col-md-offset-3" style="padding: 10px">
                <div class="input-group">
                    <span style="background-color: #fff; cursor: pointer;" class="input-group-addon" id="basic-addon1"><i class="fa fa-search"></i></span>
                    <select class="form-control choose-employee">
                        @foreach($_employee as $employee)
                        <option value="{{ $employee->payroll_employee_id }}" {{ $current_employee->payroll_employee_id == $employee->payroll_employee_id ? 'selected="selected"' : '' }}>{{ $employee->payroll_employee_display_name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <div class=" panel-customer load-data">
            <form class="payroll-form" action="return false;">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="load-timesheet"></div>
            </form>
            <div class="padding-10 text-center"></div>
        </div>
    </div>
</div>
@endsection

@section('css')
	<link rel="stylesheet" type="text/css" href="/assets/member/payroll/css/timesheet.css">
	<link rel="stylesheet" type="text/css" href="/assets/external/jquery.timeentry.package-2.0.1/jquery.timeentry.css">
@endsection

@section('script')
	<script type="text/javascript" src="/assets/member/payroll/js/timesheet.js"></script>
	<script type="text/javascript" src="/assets/external/jquery.timeentry.package-2.0.1/jquery.plugin.min.js"></script>
	<script type="text/javascript" src="/assets/external/jquery.timeentry.package-2.0.1/jquery.timeentry.min.js"></script>
@endsection