@extends('member.payroll2.employee_dashboard.layout')
@section('content')
  <ol class="breadcrumb">
    <li class="breadcrumb-item">
      <a href="/employee">Dashboard</a>
    </li>
    <li class="breadcrumb-item active">{{ $page }}</li>
  </ol>


<div class="card-body">
  <div class="table-responsive">
    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
      <thead>
        <tr>
          <th>Cut off Date</th>
          <th></th>
          <th>Year</th>
          <th></th>
          <th></th>
        </tr>
      </thead>
      <tfoot>
        <tr>
          <th>Cut off Date</th>
          <th></th>
          <th>Year</th>
          <th></th>
          <th></th>
        </tr>
      </tfoot>
      <tbody>
        @foreach($_timesheet as $timesheet)         
        <tr>
          <td>{{ $timesheet->payroll_time_date }}</td>
          <td>January 25</td>
          <td>2017</td>
          <td>Timesheet</td>
          <td>Payslip</td>
          @endforeach
        </tr>
      </tbody>
    </table>
  </div>
</div>

@endsection

