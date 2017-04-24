<input type="hidden" name="employee_id" value="{{ $employee_id }}">
<table style="table-layout: fixed;" class="timesheet table table-condensed table-bordered table-sale-month">
    <thead style="text-transform: uppercase;">
        <tr>
            <th width="40px" class="text-center"></th>
            <th width="40px" class="text-center"></th>
            <th width="40px" class="text-center"></th>
            <th width="160px" class="text-center" colspan="2">Actual</th>
            <th width="160px" class="text-center" colspan="2">Approved</th>
            
            <th width="55px" class="text-center"></th>
            <th width="55px" class="text-center"></th>
            <th width="55px" class="text-center"></th>
            <th width="55px" class="text-center"></th>
            <th width="110px" colspan="2" class="text-center">Overtime</th>
            <th width="275px" colspan="5" class="text-center">Non-Reg Day</th>
            <th width="55px" class="text-center"></th>
        </tr>
        <tr>
            <th width="40px" class="text-center"></th>
            <th class="text-center" colspan="2">Day</th>
            <th class="text-center">In</th>
            <th class="text-center">Out</th>
            <th class="text-center">In</th>
            <th class="text-center">Out</th>
            <th class="text-center">BRK</th>
            <th class="text-center">REG</th>
            <th class="text-center">Late</th>
            <th class="text-center">U.T</th>
            @if($time_rule == "flexitime")
            <th colspan="2" width="80px" class="text-center">O.T Hours</th>
            @else
            <th class="text-center">Early</th>
            <th class="text-center">Reg</th>
            @endif
            <th class="text-center">R.D</th>
            <th class="text-center">E.D</th>
            <th class="text-center">N.D</th>
            <th class="text-center">S.H</th>
            <th class="text-center">R.H</th>
            <th class="text-center"></th>
        </tr>
    </thead>
    <tbody>
        @foreach($_timesheet as $timesheet)
        @foreach($timesheet->time_record as $key => $time_record)
        <tr class="time-record {{ $key == 0 ? 'main' : '' }}" tid="0" date="{{ $timesheet->date }}" total_hours="00:00" total_normal_hours="00:00" total_early_overtime="00:00" total_late_overtime="00:00">
            @if($key == 0) <!--MAIN -->
            <input class="date" type="hidden" name="date[{{ $timesheet->date}}][{{ $key }}]" value="{{ $timesheet->date }}">
            <td class="text-center table-loading">
                <i class="table-check fa fa-unlock-alt hidden"></i>
                <i class="table-loader fa fa-spinner fa-pulse fa-fw"></i>
            </td>
            <td class="text-center edit-data day-number">{{ $timesheet->day_number }}</td>
            <td class="text-center edit-data day-word">{{ $timesheet->day_word }}</td>
            <td class="text-center editable"><input placeholder="NO TIME" class="text-table time-entry time-in" type="text" name="time_in[{{ $timesheet->date}}][{{ $key }}]" value="{{ $time_record->time_in }}"></td>
            <td class="text-center editable"><input placeholder="NO TIME" class="text-table time-entry time-out"  type="text" name="time_out[{{ $timesheet->date}}][{{ $key }}]" value="{{ $time_record->time_out }}"></td>
            <td class="text-center editable approved-in">__:__ __</td>
            <td class="text-center editable approved-out">__:__ __</td>
            <td class="text-center edit-data zerotogray break">__:__</td>
            <td class="text-center edit-data zerotogray normal-hours">__:__</td>
            <td class="text-center edit-data zerotogray late-hours">__:__</td>
            <td class="text-center edit-data zerotogray under-time">__:__</td>
            @if($time_rule == "flexitime")
            <td class="text-center edit-data overtime-hours late" colspan="2">__:__</td>
            @else
            <td class="text-center edit-data zerotogray overtime-hours early">__:__</td>
            <td class="text-center edit-data zerotogray overtime-hours late">__:__</td>
            @endif
            <td class="text-center edit-data zerotogray rest-day-hours">__:__</td>
            <td class="text-center edit-data zerotogray extra-day-hours">__:__</td>
            <td class="text-center edit-data zerotogray night-differential">__:__</td>
            <td class="text-center edit-data zerotogray special-holiday-hours">__:__</td>
            <td class="text-center edit-data zerotogray regular-holiday-hours">__:__</td>
            <td class="text-center"><span class="button create-sub-time"><i class="fa fa-plus"></i></span></td>
            @else
            <input class="date" type="hidden" name="date[{{ $timesheet->date}}][{{ $key }}]" value="{{ $timesheet->date }}">
            <td class="text-center edit-data day-number"></td>
            <td class="text-center edit-data day-number"></td>
            <td class="text-center edit-data day-word"></td>
            <td class="text-center editable"><input placeholder="NO TIME" class="text-table time-entry time-in" type="text" name="time_in[{{ $timesheet->date}}][{{ $key }}]" value="{{ $time_record->time_in }}"></td>
            <td class="text-center editable"><input placeholder="NO TIME" class="text-table time-entry time-out"  type="text" name="time_out[{{ $timesheet->date}}][{{ $key }}]" value="{{ $time_record->time_out }}"></td>
            <td class="text-center edit-data approved-in">__:__ __</td>
            <td class="text-center edit-data approved-out">__:__ __</td>
            <td class="text-center edit-data"></td>
            <td class="text-center edit-data"></td>
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
            <td class="text-center edit-data approved-in">__:__ __</td>
            <td class="text-center edit-data approved-out">__:__ __</td>
            <td class="text-center edit-data"></td>
            <td class="text-center edit-data"></td>
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
<hr>
<div class="col-md-4 div-table-summary">
    <table class="table table-bordered table-condensed">
        <tr>
            <td>Total Regular Hours</td>
            <td class="text-right">
                {{$summary['regular_hours']}}
            </td>
        </tr>
        <tr>
            <td>Total Late</td>
            <td class="text-right">
                {{$summary['late_hours']}}
            </td>
        </tr>
        <tr>
            <td>Total Under Time</td>
            <td class="text-right">
                {{$summary['under_time']}}
            </td>
        </tr>
        <tr>
            <td>Total Reg OverTime</td>
            <td class="text-right">
                {{$summary['late_overtime']}}
            </td>
        </tr>
        <tr>
            <td>Total Early OverTime</td>
            <td class="text-right">
                {{$summary['early_overtime']}}
            </td>
        </tr>
        <tr>
            <td>Total Night Differentials</td>
            <td class="text-right">
                {{$summary['night_differential']}}
            </td>
        </tr>
        
        <tr>
            <td>Total Extra Day Hours</td>
            <td class="text-right">
                {{$summary['extra_day_hours']}}
            </td>
        </tr>
        
        <tr>
            <td>Total Rest Day Hour</td>
            <td class="text-right">
                {{$summary['rest_day_hours']}}
            </td>
        </tr>
        
        <tr>
            <td>Total Special Holiday Hour</td>
            <td class="text-right">
                {{$summary['special_holiday_hours']}}
            </td>
        </tr>
        
        <tr>
            <td>Total Regular Holiday Hour</td>
            <td class="text-right">
                {{$summary['regular_holiday_hours']}}
            </td>
        </tr>
        <tr>
            <td><b>Total Working Hours</b></td>
            <td class="text-right">
                <b>{{$summary['time_spent']}}</b>
            </td>
        </tr>
        <tr>
            <td width="50%">Total Regular Days</td>
            <td class="text-right">
                {{$summary['regular_day_count']}}
            </td>
        </tr>
        <tr>
            <td>Total Extra Days</td>
            <td class="text-right">
                {{$summary['extra_day_count']}}
            </td>
        </tr>
        <tr>
            <td>Total Rest Day</td>
            <td class="text-right">
                {{$summary['rest_day_count']}}
            </td>
        </tr>
        <tr>
            <td>Total Special Holiday</td>
            <td class="text-right">
                {{$summary['special_holiday_count']}}
            </td>
        </tr>
        <tr>
            <td>Total Regular Holiday</td>
            <td class="text-right">
                {{$summary['regular_holiday_count']}}
            </td>
        </tr>
        <tr>
            <td><b>Total Working Days</b></td>
            <td class="text-right">
                <b>{{$summary['total_working_days']}}</b>
            </td>
        </tr>
    </table>
</div>
<div class="col-md-4 pull-right form-horizontal">
    <div class="form-group">
        <div class="col-md-12">
            <small>Reminder Box</small>
            <div class="message-box"></div>
        </div>
    </div>
    <div class="form-group">
        <div class="col-md-12">
            <textarea class="form-control textarea-expand" placeholder="type here.."></textarea>
        </div>
    </div>
    <div class="form-group">
        <div class="col-md-8">
            <div class="checkbox">
                <label><input type="checkbox" name="">Can be view by employee</label>
            </div>
        </div>
        <div class="col-md-4">
            <button class="btn btn-custom-primary pull-right" title="send message" type="button"><i class="fa fa-paper-plane-o"></i></button>
            <label class="btn btn-custom-white pull-right margin-lr-5" title="upload file"><i class="fa fa-paperclip"></i><input type="file" name="" class="hide"></label>
        </div>
    </div>
</div>
<script type="text/javascript" src="/assets/member/js/textExpand.js"></script>
<script type="text/javascript">
    default_time_in = '{{ $default_time_in }}';
    default_time_out = '{{ $default_time_out }}';
</script>