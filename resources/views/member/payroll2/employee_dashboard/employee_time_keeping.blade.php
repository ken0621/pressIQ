@extends('member.payroll2.employee_dashboard.layout')
@section('content')
<ol class="breadcrumb">
  <li class="breadcrumb-item">
    <a href="/employee">Dashboard</a>
  </li>
  <li class="breadcrumb-item active">{{ $page }}</li>
</ol>
  <!-- Example DataTables Card-->
      <div class="card mb-3">
        <div class="card-header">
          <i class="fa fa-table"></i> Time Keeping</div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
              <thead>
                <tr>
                  <th>Cut off From</th>
                  <th>To</th>
                  <th>Year</th>
                  <th></th>
                  <th></th>
                </tr>
              </thead>
              <tfoot>
                <tr>
                  <th>Cut off From</th>
                  <th>To</th>
                  <th>Year</th>
                  <th></th>
                  <th></th>
                </tr>
              </tfoot>
              <tbody>        
                <tr>
                  <td></td>
                  <td>January 25</td>
                  <td>2017</td>
                  <td>Timesheet</td>
                  <td>Payslip</td>
                
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