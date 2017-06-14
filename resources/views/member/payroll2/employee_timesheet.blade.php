<form class="global-submit form-horizontal" role="form" action="{link_submit_here}" method="post">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">×</button>
        <h4 class="modal-title"><b>TIME SHEET</b> &raquo; {{ $employee_info->payroll_employee_first_name }} {{ $employee_info->payroll_employee_last_name }} (Employee No. {{ $employee_info->payroll_employee_number == "" ? "00" : $employee_info->payroll_employee_number }})</h4>
    </div>
    <div class="modal-body clearfix">
        <div class="col-md-12" style="text-align: left; font-weight: normal; margin-bottom: 10px; font-size: 16px;">{{ $show_period_start }} - {{  $show_period_end }}</div>
        <div class="clearfix">
            <div class="col-md-12">
                <div class="table-responsive">
                    <table class="table table-bordered table-condensed timesheet">
                        <thead style="text-transform: uppercase">
                            <tr>
                                <th class="text-center" colspan="2">Day</th>
                                <th class="text-center" width="100px">Time In</th>
                                <th class="text-center" width="100px">Time Out</th>
                                <th class="text-center">Remark / Activity</th>
                                <th width="150px" class="text-center">Rate</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($_timesheet as $timesheet)
                            <tr>
                                <td class="text-center" width="50px">{{ $timesheet->day_number }}</td>
                                <td class="text-center" width="50px">{{ $timesheet->day_word }}</td>
                                <td>
                                    @foreach($timesheet->record as $record)
                                    <input value="{{ $record->time_sheet_in }}" type="text" placeholder="NO TIME" class="text-table text-center time-entry time-in is-timeEntry" name="">
                                    @endforeach
                                </td>
                                <td>
                                    @foreach($timesheet->record as $record)
                                    <input value="{{ $record->time_sheet_out }}" type="text" placeholder="NO TIME" class="text-table text-center time-entry time-out is-timeEntry" name="">
                                    @endforeach
                                </td>
                                <td>
                                    @foreach($timesheet->record as $record)
                                    <input value="{{ $record->time_sheet_activity }}" type="text" class="text-table time-entry is-timeEntry" name="">
                                    @endforeach
                                </td>
                                <td class="text-center"><a href="javascript:" class="daily-salary" amount="{{ $timesheet->daily_info->daily_salary }}">PHP {{ number_format($timesheet->daily_info->daily_salary, 2) }}</a></td>
                            </tr>
                            @endforeach
                            <tr style="font-weight: bold;">
                                <td class="text-right" colspan="5">GROSS SALARY</td>
                                <td class="text-center"><a href="javascript:">PHP <span class="total-gross-salary">0.00</span></a></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-def-white btn-custom-white" data-dismiss="modal">Cancel</button>
        <button class="btn btn-primary btn-custom-primary" type="button"">Approve Timesheet</button>
    </div>
</form>
<script type="text/javascript" src="/assets/member/payroll/js/timesheet2.js"></script>