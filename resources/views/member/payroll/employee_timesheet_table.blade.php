<input type="hidden" name="time_rule" value="{{ $time_rule }}">
<input type="hidden" name="default_time_in" value="{{ $default_time_in }}">
<input type="hidden" name="default_time_out" value="{{ $default_time_out }}">
<input type="hidden" name="default_working_hours" value="{{ $default_working_hours }}">
<input type="hidden" name="employee_id" value="{{ $employee_id }}">
<table style="table-layout: fixed;" class="timesheet table table-condensed table-bordered table-sale-month">
    <thead style="text-transform: uppercase;">
        <tr>
            <th width="40px" class="text-center"></th>
            <th width="40px" class="text-center"></th>
            <th width="40px" class="text-center"></th>
            <th width="180px" class="text-center" colspan="2">Time</th>
            <th class="text-center"></th>
            
            <th width="60px" class="text-center"></th>
            <th width="55px" class="text-center"></th>
            <th width="55px" class="text-center"></th>
            <th width="110px" colspan="2" class="text-center">Non-Reg Day</th>
            <th width="110px" colspan="2" class="text-center">Overtime</th>
            <th width="55px" class="text-center"></th>

            <th width="45px" class="text-center"></th>
            <th width="50px" class="text-center"></th>
        </tr>
        <tr>
            <th width="40px" class="text-center"></th>
            <th class="text-center" colspan="2">Day</th>
            <th class="text-center">Time In</th>
            <th class="text-center">Time Out</th>
            <th class="text-center">Activities</th>
            <th class="text-center">Break</th>
            <th class="text-center">NRM</th>
            <th class="text-center">Late</th>
            <th class="text-center">Rest</th>
            <th class="text-center">XTRA</th>

            @if($time_rule == "flexitime")
            <th colspan="2" width="80px" class="text-center">O.T Hours</th>
            @else
            <th class="text-center">Early</th>
            <th class="text-center">Reg</th>
            @endif
            <th class="text-center">Total</th>
            <th class="text-center">TYP</i></th>
            <th class="text-center"></th>
        </tr>
    </thead>
    <tbody>
        @foreach($_timesheet as $timesheet)
            @foreach($timesheet->time_record as $key => $time_record)
            <tr class="time-record {{ $key == 0 ? 'main' : '' }}" date="{{ $timesheet->date }}" total_hours="00:00" total_normal_hours="00:00" total_early_overtime="00:00" total_late_overtime="00:00">
                @if($key == 0) <!--MAIN -->
                    <input class="date" type="hidden" name="date[{{ $timesheet->date}}][{{ $key }}]" value="{{ $timesheet->date }}">
                    <td class="text-center table-loading"><i class="table-check fa fa-check hidden"></i> <i class="table-loader fa fa-spinner fa-spin fa-fw"></i></td>
                    <td class="text-center edit-data day-number">{{ $timesheet->day_number }}</td>
                    <td class="text-center edit-data day-word">{{ $timesheet->day_word }}</td>
                    <td class="text-center editable"><input placeholder="NO TIME" class="text-table time-entry time-in" type="text" name="time_in[{{ $timesheet->date}}][{{ $key }}]" value="{{ $time_record->time_in }}"></td>
                    <td class="text-center editable"><input placeholder="NO TIME" class="text-table time-entry time-out"  type="text" name="time_out[{{ $timesheet->date}}][{{ $key }}]" value="{{ $time_record->time_out }}"></td>
                    <td class="text-center editable"><textarea placeholder="" class="text-table" ></textarea></td>
                    <td class="text-center edit-data"><input class="text-table break-time time-entry-24"  type="text" name="break[{{ $timesheet->date}}]" value="{{ $timesheet->break }}"></td>
                    <td class="text-center edit-data normal-hours">__:__</td>
                    <td class="text-center edit-data late-hours">__:__</td>
                    <td class="text-center edit-data rest-day-hours">__:__</td>
                    <td class="text-center edit-data extra-day-hours">__:__</td>

                    @if($time_rule == "flexitime")
                    <td class="text-center edit-data overtime-hours late" colspan="2">__:__</td>
                    @else
                    <td class="text-center edit-data overtime-hours early">__:__</td>
                    <td class="text-center edit-data overtime-hours late">__:__</td>
                    @endif
                    <td class="text-center edit-data total-hours">__:__</td>
                    <td class="text-center edit-data">REG</td>
                    <td class="text-center"><span class="button create-sub-time"><i class="fa fa-plus"></i></span></td>
                @else 
                    <input class="date" type="hidden" name="date[{{ $timesheet->date}}][{{ $key }}]" value="{{ $timesheet->date }}">
                    <td class="text-center edit-data day-number"></td>
                    <td class="text-center edit-data day-number"></td>
                    <td class="text-center edit-data day-word"></td>
                    <td class="text-center editable"><input placeholder="NO TIME" class="text-table time-entry time-in" type="text" name="time_in[{{ $timesheet->date}}][{{ $key }}]" value="{{ $time_record->time_in }}"></td>
                    <td class="text-center editable"><input placeholder="NO TIME" class="text-table time-entry time-out"  type="text" name="time_out[{{ $timesheet->date}}][{{ $key }}]" value="{{ $time_record->time_out }}"></td>
                    <td class="text-center editable"><textarea placeholder="" class="text-table" ></textarea></td>
                    <td class="text-center edit-data"></td>
                    <td class="text-center edit-data"></td>
                    <td class="text-center edit-data"></td>
                    <td class="text-center edit-data"></td>
                    <td class="text-center edit-data"></td>
                    <td class="text-center edit-data"></td>
                    <td class="text-center edit-data"></td>
                    <td class="text-center edit-data"></td>
                    <td class="text-center edit-data"></td>
                    <td class="text-center"><span class="button delete-sub-time"><i class="fa fa-close"></i></span></td>
                @endif


            </tr>
            @endforeach
        @endforeach

        <!-- READY HTML FOR APPEND -->
        <tfoot class="hidden sub-time-container">
            <tr class="time-record new-sub" date="0000-00-00" total_hours="00:00" total_ot_early="00:00" total_ot_late="00:00">
                 <input class="date" type="hidden" name="" value="">
                <td class="text-center edit-data"></td>
                <td class="text-center edit-data"></td>
                <td class="text-center edit-data"></td>
                <td class="text-center editable"><input placeholder="NO TIME" class="text-table time-entry time-in is-timeEntry" name="" value="9:00AM" type="text"><span class="timeEntry-control" style="display: inline-block; background: url('spinnerDefault.png') 0 0 no-repeat; width: 20px; height: 20px;"></span></td>
                <td class="text-center editable"><input placeholder="NO TIME" class="text-table time-entry time-out is-timeEntry" name="" value="6:00PM" type="text"><span class="timeEntry-control" style="display: inline-block; background: url('spinnerDefault.png') 0 0 no-repeat; width: 20px; height: 20px;"></span></td>
                <td class="text-center editable"><textarea placeholder="" class="text-table"></textarea></td>   
                <td class="text-center edit-data"></td>
                <td class="text-center edit-data"></td>
                <td class="text-center edit-data"></td>
                <td class="text-center edit-data"></td>
                <td class="text-center edit-data"></td>
                <td class="text-center edit-data"></td>
                <td class="text-center edit-data"></td>
                <td class="text-center edit-data"></td>
                <td class="text-center edit-data"></td>
                <td class="text-center"><span class="button delete-sub-time"><i class="fa fa-close"></i></span></td>
            </tr>
        </tfoot>
    </tbody>
</table>