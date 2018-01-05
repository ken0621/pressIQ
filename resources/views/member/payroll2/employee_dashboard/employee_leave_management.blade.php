@extends('member.payroll2.employee_dashboard.layout')
@section('content')
<ol class="breadcrumb">
    <li class="breadcrumb-item">
        <a href="/employee">Dashboard</a>
    </li>
    <li class="breadcrumb-item active">{{ $page }}</li>
     <a href="javascript:" onClick="action_load_link_to_modal('/employee_leave_application', 'lg')"><button class="btn btn-primary pull-right">Create Leave</button></a>
</ol>
<div class="panel panel-default panel-block panel-title-block panel-gray ">
           <input type="hidden" name="_token" id="_token" value="{{csrf_token()}}">
    
</div>

<script type="text/javascript" src="/assets/member/js/payroll/payroll_timekeeping.js?version=10"></script>
<br>
 

<div class="card mb-3">
    <div class="card-header">
        <i class="fa fa-table"></i> Leave Application
    </div>
    <div class="card-body">
        <ul class="nav nav-tabs">
            <li class="tabs active all" data-type='all'><a data-toggle="tab" href="#all" >All</a></li>
            <li class="tabs pending" data-type='pending'><a data-toggle="tab" href="#pending" >Pending</a></li>
            <li class="tabs approved" data-type='approved'><a data-toggle="tab" href="#approved" >Approved</a></li>
            <li class="tabs rejected" data-type='rejected'><a data-toggle="tab" href="#rejected" >Rejected</a></li>
          </ul>
            <br>
                  <table class="table table-bordered" style="font-size:12px;">
            <thead>
              <tr>
                <th style="text-align: center;">Leave Type</th>
                <th style="text-align: center;">Leave Hours</th>
                <th style="text-align: center;">Date Filed</th>
                <th style="text-align: center;">Schedule Leave</th>
                <th style="text-align: center;">Approver</th>
                <th style="text-align: center;">Reliever</th>
                <th style="text-align: center;">Status</th>
              </tr>
            </thead>
            <tbody class="tbl-tag">
                                
            </tbody>
          </table>

    </div>
    <div class="card-footer small text-muted"></div>
</div>

<!-- Example DataTables Card-->
{{-- <div class="card mb-3">
<div class="card-header">
    <i class="fa fa-table"></i> Leave Management
</div>
<div class="card-body">
    <div class="table-responsive">
        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
            <thead>
                <tr>
                    <th>Type of Leave</th>
                    <th>Date of Application</th>
                    <th>Date from</th>
                    <th>Date To</th>
                    <th>Remarks</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tfoot>
            <tr>
                <th>Type of Leave</th>
                <th>Date of Application</th>
                <th>Date from</th>
                <th>Date To</th>
                <th>Remarks</th>
                <th>Action</th>
            </tr>
            </tfoot>
            <tbody>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>
                        <div class="dropdown">
                            <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown">Action
                            <span class="caret"></span></button>
                            <ul class="dropdown-menu">
                                <li><a href="#">View</a></li>
                                <li><a href="#">Edit</a></li>
                                <li><a href="#">Cancel</a></li>
                            </ul>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
<div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div>
</div> --}}
</div>
<!-- /.container-fluid-->
<!-- /.content-wrapper-->
<script type="text/javascript" src="/assets/member/js/payroll/employee_leave_management.js"></script>
@endsection;