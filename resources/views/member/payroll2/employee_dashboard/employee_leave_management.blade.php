@extends('member.payroll2.employee_dashboard.layout')
@section('content')
<ol class="breadcrumb">
    <li class="breadcrumb-item">
        <a href="/employee">Dashboard</a>
    </li>
    <li class="breadcrumb-item active">{{ $page }}</li>
</ol>
<div class="panel panel-default panel-block panel-title-block panel-gray ">
    <ul class="nav nav-tabs">
        
        <li class="active cursor-pointer change-tab approve-tab" mode="all"><a class="cursor-pointer"><i class="text-bold"> All </i></a></li>
        <li class="cursor-pointer change-tab approve-tab" mode="pending"><a class="cursor-pointer"><i class="text-bold"> Pending </i></a></li>
        <li class="cursor-pointer change-tab approve-tab" mode="approved"><a class="cursor-pointer"><i class="text-bold"> Approved </i></a></li>
        <li class="cursor-pointer change-tab approve-tab" mode="rejected"><a class="cursor-pointer"><i class="text-bold"> Rejected </i></a></li>
        
    </ul>
    
    <div class="search-filter-box">
        <div class="col-md-4" style="padding: 10px">
            <select class="form-control item_type company-change-event">
                <option value="0">Type of Leave</option>
                @foreach($_leave_name as $leave_name)
                <option value="{{ $leave_name->payroll_leave_temp_id }}">{{ $leave_name->payroll_leave_temp_name }}</option>
                @endforeach
            </select>
        </div>
    </div>
</div>
</div>
<script type="text/javascript" src="/assets/member/js/payroll/payroll_timekeeping.js?version=10"></script>
<!-- Example DataTables Card-->
<div class="card mb-3">
<div class="card-header">
    <i class="fa fa-table"></i> Leave Management
    <a href="javascript:" onClick="action_load_link_to_modal('/employee_leave_application', 'lg')"><button class="btn btn-default pull-right">Create Leave</button></a>
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
</div>
</div>
<!-- /.container-fluid-->
<!-- /.content-wrapper-->
@endsection;