@extends('member.payroll2.employee_dashboard.layout')
@section('content')
  <ol class="breadcrumb">
    <li class="breadcrumb-item">
      <a href="/employee">Dashboard</a>
    </li>
    <li class="breadcrumb-item active">{{ $page }}</li>
  </ol>
<div id="exTab1" class="container"> 
  <ul  class="nav nav-tabs">
    <li class="active"><a  href="#1a" data-toggle="tab">All</a></li>
    <li><a href="#2a" data-toggle="tab">Pending</a></li>
    <li><a href="#3a" data-toggle="tab">Approved</a></li>
    <li><a href="#4a" data-toggle="tab">Rejected</a></li>
  </ul>
<div class="tab-content">
<div class="tab-pane active" id="1a">
</div>


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