<input type="hidden" name="employee_id" value="{{ $employee_id }}" id="employee_id">
<table style="table-layout: fixed;" class="timesheet table table-condensed table-bordered table-sale-month">
    <thead style="text-transform: uppercase;">
        <tr>
            <th width="35px" class="text-center"></th>
            <th width="35px" class="text-center"></th>
            <th width="35px" class="text-center"></th>
            <th width="35px" class="text-center"></th>
            <th width="35px" class="text-center"></th>
            <th width="160px" class="text-center" colspan="2">Actual</th>
            <th width="160px" class="text-center" colspan="2">Approved</th>
            
            <th width="55px" class="text-center"></th>
            <th width="55px" class="text-center"></th>
            <th width="55px" class="text-center"></th>
            <th width="55px" class="text-center"></th>
            <th width="110px" colspan="2" class="text-center">Overtime</th>
            <th width="275px" colspan="5" class="text-center">Non-Reg Day</th>
            <th width="35px" class="text-center"></th>
        </tr>
        <tr>
            <th width="35px" class="text-center"></th>
            <th width="35px" class="text-center"></th>
            <th width="35px" class="text-center"></th>
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
        
        <tr class="time-record {{ $key == 0 ? 'main' : '' }}" tid="0" date="{{ $timesheet->date }}" total_hours="00:00" total_normal_hours="00:00" total_early_overtime="00:00" total_late_overtime="00:00" data-id="{{ $time_record->payroll_time_sheet_record_id }}" id="{{ $time_record->payroll_time_sheet_record_id }}">
            @if($key == 0) <!--MAIN -->
            <input class="date" type="hidden" name="date[{{ $timesheet->date}}][{{ $key }}]" value="{{ $time_record->payroll_time_sheet_record_id }}">
            <td class="text-center table-loading tr-icons">
                <!-- <i class="table-check fa fa-unlock-alt hidden"></i> -->
                {!!$timesheet->symbol!!}
                <i class="table-loader fa fa-spinner fa-pulse fa-fw"></i>
            </td>
            <td class="text-center">
               <i class="fa fa-comment-o popup" link="/member/payroll/timesheet/modal_timesheet_comment/{{ $time_record->payroll_time_sheet_record_id }}"></i>
            </td>
            <td class="text-center">
                <i class="fa fa-university popup" link="/member/payroll/timesheet/modal_choose_company/{{ $time_record->payroll_time_sheet_record_id }}" title="{{$time_record->company}}" size="sm"></i>
            </td>
            <td class="text-center edit-data day-number">{!! $timesheet->day_number !!}</td>
            <td class="text-center edit-data day-word">{!! $timesheet->day_word !!}</td>
            <td class="text-center editable ">
                <input placeholder="NO TIME" class="text-table time-entry time-entry-record time-in" type="text" name="time_in[{{ $timesheet->date}}][{{ $key }}]" value="{{ $time_record->time_in }}" {{$time_record->disable}}>
                <input class="hidden-time-in" type="hidden" name="time_in2[{{ $timesheet->date}}][{{ $key }}]" value="{{ $time_record->time_in }}">
            </td>
            <td class="text-center editable">
                <input placeholder="NO TIME" class="text-table time-entry time-entry-record time-out"  type="text" name="time_out[{{ $timesheet->date}}][{{ $key }}]" value="{{ $time_record->time_out }}" {{$time_record->disable}} origin="{{$time_record->origin}}">
                 <input type="hidden" class="hidden-time-out" name="time_out2[{{ $timesheet->date}}][{{ $key }}]" value="{{ $time_record->time_out }}">
            </td>
            <td class="text-center editable approved-in">__:__ __</td>
            <td class="text-center editable approved-out">__:__ __</td>
            <td class="text-center edit-data zerotogray ">
                <input type="text" placeholder="00:00" name="break[{{ $timesheet->date}}][{{ $key }}]" class="form-control break time-entry time-entry-record break-time time-entry-24">
            </td>
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
            <td class="text-center edit-data zerotogray regular-holiday-hours {{$timesheet->holiday_class}}">__:__</td>
            <td class="text-center"><span class="button create-sub-time"><i class="fa fa-plus"></i></span></td>
            @else
            <input class="date" type="hidden" name="date[{{ $timesheet->date}}][{{ $key }}]" value="{{ $time_record->payroll_time_sheet_record_id }}">
            <td class="text-center edit-data day-number"></td>
            <td class="text-center edit-data day-number">
                <i class="fa fa-comment-o popup" link="/member/payroll/timesheet/modal_timesheet_comment/{{ $time_record->payroll_time_sheet_record_id }}"></i>
            </td>
            <td class="text-center">
                <i class="fa fa-university popup" link="/member/payroll/timesheet/modal_choose_company/{{ $time_record->payroll_time_sheet_record_id }}" size="sm" title="{{$time_record->company}}"></i>
            </td>
            <td class="text-center edit-data day-number"></td>
            <td class="text-center edit-data day-word"></td>
            <td class="text-center editable">
                <input placeholder="NO TIME" class="text-table time-entry time-in time-entry-record" type="text" name="time_in[{{ $timesheet->date}}][{{ $key }}]" value="{{ $time_record->time_in }}" {{$time_record->disable}} origin="{{$time_record->origin}}">

                <input class="hidden-time-in" type="hidden" name="time_in2[{{ $timesheet->date}}][{{ $key }}]" value="{{ $time_record->time_in }}">
            </td>
            <td class="text-center editable">
              
                <input placeholder="NO TIME" class="text-table time-entry time-out time-entry-record"  type="text" name="time_out[{{ $timesheet->date}}][{{ $key }}]" value="{{ $time_record->time_out }}" {{$time_record->disable}}>

                <input type="hidden" class="hidden-time-out" name="time_out2[{{ $timesheet->date}}][{{ $key }}]" value="{{ $time_record->time_out }}">
            </td>
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
            <td class="text-center edit-data color-red"></td>
            <td class="text-center"><span class="button delete-sub-time"><i class="fa fa-close"></i></span></td>
            @endif
        </tr>
        @endforeach
        @endforeach
        <!-- READY HTML FOR APPEND -->
        <tfoot class="hidden sub-time-container">
        <tr class="time-record new-sub" date="0000-00-00" total_hours="00:00" total_ot_early="00:00" total_ot_late="00:00" data-id="">
            <input class="date" type="hidden" name="" value="">
            <td class="text-center edit-data"></td>
            <td class="text-center edit-data">
                <i class="fa fa-comment-o popup new-comment" link="/member/payroll/timesheet/modal_timesheet_comment/"></i>
            </td>
            <td class="text-center">
                <i class="fa fa-university popup new-company" size="sm" link="/member/payroll/timesheet/modal_choose_company/" title="" size="sm"></i>
            </td>
            <td class="text-center edit-data"></td>
            <td class="text-center edit-data"></td>
            <td class="text-center editable">
                <input placeholder="NO TIME" class="text-table time-entry time-in is-timeEntry time-entry-record" name="" value="9:00AM" type="text"><span class="timeEntry-control" style="display: inline-block; background: url('spinnerDefault.png') 0 0 no-repeat; width: 20px; height: 20px;"></span>
                <input class="hidden-time-in" type="hidden" name="" value="">
            </td>
            <td class="text-center editable">
                <input placeholder="NO TIME" class="text-table time-entry time-out time-entry-record is-timeEntry" name="" value="6:00PM" type="text"><span class="timeEntry-control" style="display: inline-block; background: url('spinnerDefault.png') 0 0 no-repeat; width: 20px; height: 20px;"></span>
                <input class="hidden-time-out" type="hidden" name="" value="">
            </td>
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
    <div class="div-summary-table">
        <table class="table table-bordered table-condensed">
            <tr>
                <td>Total Regular Hours</td>
                <td class="text-right">
                    {{$summary['regular_hours']}}
                </td>
            </tr>
             <tr>
                <td>Total Break</td>
                <td class="text-right">
                    {{$summary['break_hours']}}
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
                <td width="50%">Total Absents</td>
                <td class="text-right">
                    {{$summary['absent']}}
                </td>
            </tr>

            <tr>
                <td width="50%">Total Leave with Pay</td>
                <td class="text-right">
                    {{$summary['leave_with_pay']}}
                </td>
            </tr>
            <tr>
                <td width="50%">Total Leave without Pay</td>
                <td class="text-right">
                    {{$summary['leave_wo_pay']}}
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
</div>
<div class="col-md-4 pull-right form-horizontal">
    <div class="form-group">
        <div class="col-md-12">
            <small>Reminder Box</small>
            <div class="message-box">
                @foreach($_remarks as $remarks)
                <div class="message-container">
                    <p>{{$remarks['message']}}</p>
                    <span class="date-message f-9"><i>{{date('F d, Y h:i:s', strtotime($remarks['date']))}}</i></span>
                    <span class="pull-right user-message"><b>-{{$remarks['user']}}</b></span>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    <div class="form-message" action="/member/payroll/timesheet/send_reminder" method="POST" data-btn=".btn-send-message">
        <input type="hidden" id="_token" name="payroll_period_company_id" value="{{$payroll_period_company_id}}">
        <input type="hidden" name="_token" value="{{csrf_token()}}">
        <div class="form-group">
            <div class="col-md-12">
                <textarea class="form-control textarea-expand" name="payroll_remarks" placeholder="type here.."></textarea>
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-8">
                <!-- <div class="checkbox">
                    <label><input type="checkbox" name="">Can be view by employee</label>
                </div> -->
                <span class="file-name"></span>
            </div>
            <div class="col-md-4">
                <button class="btn btn-custom-primary pull-right btn-send-message" title="send message" type="button"><i class="fa fa-paper-plane-o"></i></button>
                <label class="btn btn-custom-white pull-right margin-lr-5" title="upload file"><i class="fa fa-paperclip"></i><input type="file" name="file_name" class="hide file-input-message"></label>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="/assets/member/js/textExpand.js"></script>
<script type="text/javascript" src="/assets/member/js/payroll/send_message_timesheet.js"></script>
<script type="text/javascript">
    default_time_in = '{{ $default_time_in }}';
    default_time_out = '{{ $default_time_out }}';
</script>
