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
                    <table class="table table-bordered table-condensed timesheet table-timesheet">
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
                            <?php $random_integer = rand (10000000, 999999999); ?>
                            <tr class="tr-parent">
                                <td class="text-center" width="50px">{{ $timesheet->day_number }}</td>
                                <td class="text-center" width="50px">{{ $timesheet->day_word }}</td>
                                <td class="time-in-td">
                                    @foreach($timesheet->record as $record)
                                    <input unq="{{ $random_integer }}" mintime="12:00 AM" maxtime="11:59 PM" value="{{ $record->time_sheet_in }}" type="text" placeholder="NO TIME" class="new-time-event text-table text-center time-entry time-in is-timeEntry" name="">
                                    @endforeach
                                </td>
                                <td class="time-out-td">
                                    @foreach($timesheet->record as $record)
                                    <input unq="{{ $random_integer }}" mintime="12:00 AM" maxtime="11:59 PM" value="{{ $record->time_sheet_out }}" type="text" placeholder="NO TIME" class="new-time-event text-table text-center time-entry time-out is-timeEntry" name="">
                                    @endforeach
                                </td>
                                <td class="time-comment-td">
                                    @foreach($timesheet->record as $record)
                                    <input unq="{{ $random_integer }}" value="{{ $record->time_sheet_activity }}" type="text" class="comment new-time-event text-table time-entry is-timeEntry" name="">
                                    @endforeach
                                </td>
                                @if($timesheet->daily_info->shift_approved == true)
                                    <td class="text-center"><a href="javascript:" class="daily-salary" amount="{{ $timesheet->daily_info->daily_salary }}">PHP {{ number_format($timesheet->daily_info->daily_salary, 2) }}</a></td>
                                @else
                                    <td class="text-center"><a onclick="action_load_link_to_modal('/member/payroll/company_timesheet_day_summary/{{ $timesheet->payroll_time_sheet_id }}', 'lg')" style="color: red;" href="javascript:" class="daily-salary" amount="{{ $timesheet->daily_info->daily_salary }}">PHP {{ number_format($timesheet->daily_info->daily_salary, 2) }}</a></td>
                                @endif
                                
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