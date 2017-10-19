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
            {{-- <button class="btn btn-primary pull-right modal-13th-pay-basis-button" data-id = "{{$employee->payroll_employee_id}}">Compute 13th Month Pay</button> --}}
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
                    <table class="table table-bordered table-striped table-condensed" >
                        <thead style="text-transform: uppercase">
                            <tr>
                                <th class="text-center">PERIOD</th>
                                <th class="text-center">VIEW SUMMARY</th>
                                <th class="text-center">13TH MONTH PAY BASIS</th>
                                <th class="text-center">13TH MONTH PAY COMPUTATION</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($_period as $period)
                            <tr>
                                <td class="text-center">{{$period->month_contribution}} ( {{$period->period_count}} )</td>
                                <td class="text-center"><a href="javascript: action_load_link_to_modal('/member/payroll/company_timesheet2/income_summary/{{ $period->payroll_period_company_id }}/{{ $period->payroll_employee_id }}', 'lg')">SUMMARY</a></td>
                                <td class="text-center">{{ payroll_currency($period->payroll_13th_month_basis,2) }}</td>
                                <td class="text-center">{{ payroll_currency($period->payroll_13th_month_contribution,2) }}</td>
                            </tr>
                            @endforeach
                            <tr>
                                <td class="text-center"><b>TOTAL 13TH MONTH PAY</b></td>
                                <td class="text-center"></td>
                                <td class="text-center"></td>
                                <td class="text-center"><b>{{ payroll_currency($grand_total_13th_month_pay) }}</b></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div> 
    </div>
</div>


@endsection
@section('script')
<script type="text/javascript" src="/assets/member/payroll/js/payroll_13th_month_pay.js"></script>
@endsection