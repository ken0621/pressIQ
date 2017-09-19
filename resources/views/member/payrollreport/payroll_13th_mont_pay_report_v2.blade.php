@extends('member.layout')
@section('content')
<div class="panel panel-default panel-block panel-title-block" id="top">
    <div class="panel-heading">
        <div>
            <i class="fa fa-tags"></i>
            <h1>
                <span class="page-title">Payroll 13th Month Pay &raquo; {{ $employee->payroll_employee_first_name }} {{ $employee->payroll_employee_middle_name }} {{ $employee->payroll_employee_last_name }}</span>
                <small>
                Payroll 13th Month Pay Report
                </small>
            </h1>
            {{-- <a href="#"><button type="button" class="btn btn-success pull-right"><i class="fa fa-file-excel-o" style="font-size:25px;color:white"></i> &nbsp;EXPORT TO EXCEL</button></a> --}}
        </div>
    </div>
</div>


<div class="panel panel-default panel-block panel-title-block" >
    <div class="panel-body form-horizontal">
        <div class="form-group tab-content panel-body employee-container">
            <div id="all" class="tab-pane fade in active">
                <div class="form-group order-tags"></div>
                <div class="table-responsive tbl-13th-pay-table">
                    
                    
                </div>
            </div>
        </div> 
    </div>
</div>
@endsection