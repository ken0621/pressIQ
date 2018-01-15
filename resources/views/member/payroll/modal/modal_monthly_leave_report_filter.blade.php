    <div class="modal-body clearfix">
                <div class="table-responsive">
                    <table class="table table-bordered table-condensed">
                        <thead>
                            <tr>
                                <th class="text-center">Leave Name</th>
                                <th class="text-center">Employee Number</th>
                                <th class="text-center">Employee Name</th>
                                <th class="text-center">Date of Leave</th>
                                <th class="text-center">Leave Credits</th>
                                <th class="text-center">Number of Hours</th>
                                <th class="text-center">Remaining Leave</th>
                                <th class="text-center">Payment Indicator</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(isset($leave_report))
                            @foreach($leave_report as $leave_data)
                                @foreach($leave_data as $leave)
                            <tr>
                                <td class="text-center">{{ $leave->payroll_leave_temp_name }}</td>
                                <td class="text-center">{{ $leave->payroll_employee_id }}</td>
                                <td class="text-center">{{ $leave->payroll_employee_display_name }}</td>
                                <td class="text-center">{{ $leave->payroll_schedule_leave }}</td>
                                <td class="text-center">{{ $leave->payroll_leave_temp_hours }}</td>
                                <td class="text-center">{{ $leave->total_leave_consume}}</td>
                                <td class="text-center">{{ $leave->remaining_leave }}</td>
                                <td class="text-center">{{ $leave->payroll_leave_temp_with_pay == '1' ? 'P' : 'NP'}}</td>
                            </tr>
                                 @endforeach
                            @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-def-white btn-custom-white" data-dismiss="modal">Close</button>
        &nbsp;<a href="/member/payroll/leave/v2/monthly_leave_report_excel/{{$month_today}}"><button type="button" class="btn btn-success pull-right"><i class="fa fa-file-excel-o" ></i> &nbsp;EXPORT TO EXCEL</button></a>
    </div>