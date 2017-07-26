<input type="hidden" class="period-id" value="{{ $period_id }}" />
<input type="hidden" class="x-employee-id" value="{{ $employee_id }}" />

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
                            <th class="text-center" width="150px;">Source</th>
                            <th class="text-center" width="150px;">Branch</th>
                            <th width="150px" class="text-center">Rate</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($_timesheet as $timesheet)
                        <?php $random_integer = rand (10000000, 999999999); ?>
                        <tr class="tr-parent" date="{{ $timesheet->date }}">
                            {{ csrf_field() }}
                            <input type="hidden" name="date" value="{{ $timesheet->date }}"/>
                            <td class="text-center" width="50px">{{ $timesheet->day_number }}</td>
                            <td class="text-center" width="50px">{{ $timesheet->day_word }}</td>

                            <td class="time-in-td">
                                @if($timesheet->record)
                                    @foreach($timesheet->record as $record)
                                    <input name="time-in[]" unq="{{ $random_integer }}" mintime="12:00 AM" maxtime="11:59 PM" value="{{ $record->time_sheet_in }}" type="text" placeholder="NO TIME" class="new-time-event text-table text-center time-entry time-in is-timeEntry">
                                    @endforeach
                                @else
                                    <input name="time-in[]" unq="{{ $random_integer }}" mintime="12:00 AM" maxtime="11:59 PM" value="" type="text" placeholder="NO TIME" class="new-time-event text-table text-center time-entry time-in is-timeEntry">
                                @endif
                            </td>
                            <td class="time-out-td">
                                @if($timesheet->record)
                                    @foreach($timesheet->record as $record)
                                    <input name="time-out[]" unq="{{ $random_integer }}" mintime="12:00 AM" maxtime="11:59 PM" value="{{ $record->time_sheet_out }}" type="text" placeholder="NO TIME" class="new-time-event text-table text-center time-entry time-out is-timeEntry">
                                    @endforeach
                                @else
                                    <input name="time-out[]" unq="{{ $random_integer }}" mintime="12:00 AM" maxtime="11:59 PM" value="" type="text" placeholder="NO TIME" class="new-time-event text-table text-center time-entry time-out is-timeEntry">
                                @endif
                            </td>
                            <td class="time-comment-td">
                                @if($timesheet->record)
                                    @foreach($timesheet->record as $record)
                                    <input name="remarks[]" unq="{{ $random_integer }}" value="{{ ($record->time_sheet_activity == '' ? $timesheet->default_remarks : $record->time_sheet_activity) }}" type="text" class="comment new-time-event text-table">
                                    @endforeach
                                @else
                                    <input name="remarks[]" unq="{{ $random_integer }}" value="{{ $timesheet->default_remarks }}" type="text" class="comment new-time-event text-table">
                                @endif
                            </td>

                            <td class="text-center">
                                @if($timesheet->record)
                                    @foreach($timesheet->record as $record)
                                        <div>{{ $record->source }}</div>
                                    @endforeach
                                @else
                                    N/A
                                @endif
                            </td>
                            <td class="text-center">
                                @if($timesheet->record)
                                    @foreach($timesheet->record as $record)
                                        <div>{{ $record->branch }}</div>
                                    @endforeach
                                @else
                                    N/A
                                @endif
                            </td>
                            <td class="text-center rate-output">
                                {!! $timesheet->daily_info->value_html !!}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-def-white btn-custom-white" data-dismiss="modal">Cancel</button>
    <button class="btn btn-primary btn-custom-primary approve-timesheet-btn" type="button">{{ $time_keeping_approved == true ? "RETURN TO PENDING" : "MARK AS READY" }}</button>
</div>
<script type="text/javascript" src="/assets/member/payroll/js/timesheet2.js"></script>
<style type="text/css">
    .modal-dialog
    {
        width: 1100px !important;
    }
</style>

<div class="view-debug-mode modal-footer">
    <div onclick='$(".debug-view").removeClass("hidden")' style="text-align: center; cursor: pointer; color: #005fbf">DEBUG MODE (DEVELOPER ONLY) &nbsp; <i class="fa fa-caret-down"></i></div>
    <div class="debug-view hidden text-left" style="padding-top: 10px;">
        {{ dd($_timesheet) }}
    </div>
</div>