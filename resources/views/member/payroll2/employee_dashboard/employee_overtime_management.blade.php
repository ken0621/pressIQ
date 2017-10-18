@extends('member.payroll2.employee_dashboard.layout')
@section('content')
  <ol class="breadcrumb">
    <li class="breadcrumb-item">
      <a href="/employee">Dashboard</a>
    </li>
    <li class="breadcrumb-item active">{{ $page }}</li>
  </ol>
<div class="row">
    <div class="col-md-12">
        <a href="/employee_overtime_application"><button class="btn btn-default pull-right">Create Overtime</button></a>
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
                        <td style="font-size:12px">View</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div><!-- Row -->
<!-- Row --> 
@endsection;