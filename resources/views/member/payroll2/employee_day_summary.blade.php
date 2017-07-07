<form class="global-submit form-horizontal" role="form" action="{link_submit_here}" method="post">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">×</button>
        <h4 class="modal-title"><b>{{ date("F d, Y",strtotime($timesheet_db->payroll_time_date)) }}</b> &raquo; {{ $employee_info->payroll_employee_first_name }} {{ $employee_info->payroll_employee_last_name }} (Employee No. {{ $employee_info->payroll_employee_number == "" ? "00" : $employee_info->payroll_employee_number }}) </h4>
    </div>
    <div class="modal-body clearfix">
        <div>
        <div class="clearfix">
            <div class="col-md-12">
                <div class="table-responsive day-summary-table">
                    {{ csrf_field() }}
                    <input type="hidden" class="payroll-time-sheet-id" name="payroll_time_sheet_id" value="{{ $payroll_time_sheet_id }}" />
                    <input type="hidden" name="employee_id" value="{{ $employee_id }}" />
                    @if($timesheet_info->clean_shift)
                    <table class="table table-bordered table-condensed timesheet ">
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
                                @foreach($timesheet_info->clean_shift as $key => $record)
                                    @if($record->auto_approved != 2)
                                    <tr>
                                        <input type="hidden" name="payroll_time_sheet_record_id[{{ $key }}]" value="{{ $record->payroll_time_sheet_record_id }}"/>
                                        <td><input value="{{ $record->time_in }}" type="text" placeholder="NO TIME" class="text-table text-center time-entry time-in is-timeEntry" name="time-in[{{ $key }}]"></td>
                                        <td><input value="{{ $record->time_out }}" type="text" placeholder="NO TIME" class="text-table text-center time-entry time-in is-timeEntry" name="time-out[{{ $key }}]"></td>
                                        <td><input value="" type="text" class="text-table time-entry is-timeEntry" name=""></td>
                                        @if( $record->status_time_sched == 'OVERTIME' || $timesheet_info->day_type == "rest_day" || $timesheet_info->day_type == "extra_day")
                                        <td class="text-center"><input {{ $record->auto_approved == 1 ? 'checked' : '' }} type="checkbox" class="approve-checkbox" name="approve-checkbox[{{ $key }}]"></td>
                                        <td class="text-center"><input checked type="checkbox" class="overtime-checkbox" name="overtime-checkbox[{{ $key }}]"></td>
                                        @else
                                        <td><input type="hidden" class="approve-checkbox" value="on" name="approve-checkbox[{{ $key }}]"></td>
                                        <td><input type="hidden" class="overtime-checkbox" value="on" name="overtime-checkbox[{{ $key }}]"></td>
                                        @endif
                                    @endif
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
            <div class="col-md-6 text-right load-detail-table">
                {!! $compute_html !!}
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