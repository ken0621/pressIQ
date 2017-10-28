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
        <i class="fa fa-table"></i> Leave Management
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Date Covered</th>
                        <th>Year</th>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($_employee_period as $period)
                    <tr>
                        <td>{{ date('M d, Y',strtotime($period->payroll_period_start))." - ".date('M d, Y',strtotime($period->payroll_period_end)) }}</td>
                        <td>{{ date('Y', strtotime($period->payroll_period_end)) }}</td>
                        <td><a href=''>TIMESHEET</td>
                        <td><a href='/employee_payslip/{{ $period->payroll_period_id}}'>PAYSLIP</a></td>
                    </tr>
                    @endforeach
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