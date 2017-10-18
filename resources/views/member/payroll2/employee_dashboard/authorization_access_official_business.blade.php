@extends('member.payroll2.employee_dashboard.employee_layout')
@section('content')
<div class="page-title">
    <h3>{{ $page }}</h3>
    <div class="page-breadcrumb">
        <ol class="breadcrumb">
            <li><a href="/employee">Home</a></li>
            <li class="active">{{ $page }}</li>
        </ol>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <button class="btn btn-default pull-right">Create Official Businesss</button>
    </div>
</div>
<br>
<div class="row">
    <div class="col-md-6">
    </div>
    <div class="col-md-3">
    </div>
    <div class="col-md-3">
        <div class="input-group">
            <span class="input-group-addon"><i class="fa fa-filter"></i></span>
            <input id="" type="text" class="form-control" name="" placeholder="Enter Keyword Here">
        </div>
    </div>
    <div class="panel-heading">
    <ul class="nav nav nav-tabs">
      <li class="active"><a href="#">All</a></li>
      <li><a href="#">Pending</a></li>
      <li><a href="#">Approved</a></li>
      <li><a href="#">Rejected</a></li>
    </ul> 
    <div class="panel-body">
        <div class="table-responsive col-md-12">
            <table class="display table" style="width: 100%;">
                <thead>
                    <tr>
                        <th style="font-size:12px">Name of Employee</th>
                        <th style="font-size:12px">Date of Application</th>
                        <th style="font-size:12px">Client Name</th>
                        <th style="font-size:12px">Date</th>
                        <th style="font-size:12px">No. of hours</th>
                        <th style="font-size:12px">Status</th>
                        <th style="font-size:12px"></th>
                    </tr>
                </thead>                       
                <tbody>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td style="font-size:12px">View</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div><!-- Row -->
<!-- Row --> 
@endsection;