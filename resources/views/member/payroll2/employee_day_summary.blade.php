<form class="global-submit form-horizontal" role="form" action="{link_submit_here}" method="post">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">×</button>
        <h4 class="modal-title"><b>{{ date("F d, Y",strtotime($timesheet_db->payroll_time_date)) }}</b> &raquo; {{ $employee_info->payroll_employee_first_name }} {{ $employee_info->payroll_employee_last_name }} (Employee No. {{ $employee_info->payroll_employee_number == "" ? "00" : $employee_info->payroll_employee_number }}) </h4>
    </div>
    <div class="modal-body clearfix">
        <div>
        <div class="clearfix">
            <div class="col-md-12">
                <div class="table-responsive">
                    @if($timesheet_info->clean_shift)
                    <table class="table table-bordered table-condensed timesheet">
                        <thead style="text-transform: uppercase">
                            <tr>
                                <th class="text-center" width="100px">Time In</th>
                                <th class="text-center" width="100px">Time Out</th>
                                <th class="text-center">Remark</th>
                                <th class="text-center" width="100px">Approve</th>
                                <th class="text-center" width="100px">Overtime</th>
                            </tr>
                        </thead>
                        <tbody>
                                @foreach($timesheet_info->clean_shift as $record)
                                <tr>
                                    <input type="hidden" name="payroll_time_sheet_record_id">
                                    <td><input value="{{ $record->time_in }}" type="text" placeholder="NO TIME" class="text-table text-center time-entry time-in is-timeEntry" name=""></td>
                                    <td><input value="{{ $record->time_out }}" type="text" placeholder="NO TIME" class="text-table text-center time-entry time-in is-timeEntry" name=""></td>
                                    <td><input value="" type="text" class="text-table time-entry is-timeEntry" name=""></td>
                                    <td class="text-center approve-checkbox"><input {{ $record->auto_approved == 1 ? 'checked disabled hidden' : '' }} type="checkbox" class="text-table time-entry is-timeEntry" name=""></td>
                                    <td class="text-center overtime-checkbox"><input {{ $record->auto_approved == 1 ? 'hidden' : 'checked' }} type="checkbox" class="text-table time-entry is-timeEntry" name=""></td>
                                </tr>
                                @endforeach
                            
                        </tbody>
                    </table>
                    @endif
                </div>
            </div>
        </div>
        <div class="clearfix">
            <div class="col-md-6">
                <div style="padding: 10px; color: #bbb">
                    <div class="text-bold">SHIFT FOR THE DAY</div>
                    @if($timesheet_info->_shift)
                        @foreach($timesheet_info->_shift as $record)
                        <div>{{ date("h:i A", strtotime($record->shift_in)) }} to {{ date("h:i A", strtotime($record->shift_out)) }}</div>
                        @endforeach
                    @else
                        NO SHIFT FOR THE DAY
                    @endif
                </div>
                @if($timesheet_info->default_remarks != "")
                <div style="padding: 10px; color: #bbb; padding-top: 0px;">
                    <div class="text-bold">TODAY IS</div>
                    {{ $timesheet_info->default_remarks }}
                </div>
                @endif
            </div>
            <div class="col-md-6 text-right">
                <table width="100%" style="background-color: transparent;" class="pull-right">
                    <tbody>
                    <tr>
                        <td>Daily Rate</td>
                        <td width="100px"></td>
                        <td>PHP {{ number_format($timesheet_info->compute->daily_rate, 2) }}</td>
                    </tr>
                    @if(isset($timesheet_info->compute->_breakdown_addition))
                        @foreach($timesheet_info->compute->_breakdown_addition as $key => $breakdown)
                        <tr>
                            <td>{{ ucfirst($key) }}</td>
                            <td width="100px" class="text-center" style="color: #bbb" width="100px">{{ $breakdown["time"] }}</td>
                            <td width="100px">PHP {{ number_format($breakdown["rate"], 2) }}</td>
                        </tr>
                        @endforeach
                        <tr>
                            <td class="text-bold" >Subtotal</td>
                            <td class="text-center" style="color: #bbb" width="100px"></td>
                            <td class="text-bold" width="100px">PHP {{ number_format($timesheet_info->compute->subtotal_after_addition, 2) }}</td>
                        </tr>
                    @endif
                    @if(isset($timesheet_info->compute->_breakdown_deduction))
                        @foreach($timesheet_info->compute->_breakdown_deduction as $key => $breakdown)
                        <tr>
                            <td>Less: {{ ucfirst($key) }}</td>
                            <td width="100px" class="text-center" style="color: #bbb" width="100px">{{ $breakdown["time"] }}</td>
                            <td width="100px">PHP {{ number_format($breakdown["rate"], 2) }}</td>
                        </tr>
                        @endforeach
                    @endif
                    <tr style="color: #1682ba; font-size: 18px;">
                        <td class="text-bold">Total</td>
                        <td class="text-center" style="color: #bbb" width="100px"></td>
                        <td class="text-bold" width="100px">PHP {{ number_format($timesheet_info->compute->total_day_income, 2) }}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-def-white btn-custom-white" data-dismiss="modal">Close</button>
        <button class="btn btn-primary btn-custom-primary" type="button"">Submit</button>
    </div>
</form>
<script type="text/javascript" src="/assets/member/payroll/js/timesheet2_day_summary.js"></script>

{{ dd($timesheet_info) }}