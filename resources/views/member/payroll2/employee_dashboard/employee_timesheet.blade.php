
<div class="modal-header">
    <h4 class="modal-title timesheet-title">{{ $period_record->payroll_employee_first_name }} {{ $period_record->payroll_employee_last_name }}</h4>
    <button type="button" class="close" data-dismiss="modal">×</button></div>

<div class="modal-body clearfix timesheet-body">
    <div class="col-md-12 " style="text-align: left; font-weight: bold; font-size: 16px;">TIME RECORD {{ "(".$period_record_start." - ".$period_record_end.")"}}</div>
   
        <div class="col-md-12">
            <div class="table-responsive">
                <table class="table table-bordered table-condensed">
                    <thead class="timesheet-thead">
                        <tr>
                            <th class="text-center" colspan="2">Day</th>
                            <th class="text-center">Time In</th>
                            <th class="text-center">Time Out</th>
                            <th class="text-center">Remark / Activity</th>
                            <th class="text-center">Shift</i></th>
                            <th class="text-center">Source</th>
                            <th class="text-center">Branch</th>
                            <th class="text-center">{{ $access_salary_rates == 1 ? 'Rates':'Time Spent'}}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($_timesheet as $timesheet)
                        <tr>
                            <td class="text-center">{{ $timesheet->day_number}}</td>
                            <td class="text-center">{{ $timesheet->day_word}}</td>
                            <td>
                            @if($timesheet->record)
                                @foreach($timesheet->record as $key => $record)
                                <label>{{ $record->time_sheet_in }}</label>
                                @endforeach
                            @else
                                <label>NO TIME</label>
                            @endif
                            </td>

                            <td>
                            @if($timesheet->record)
                                @foreach($timesheet->record as $key => $record)
                                <label>{{ $record->time_sheet_out }}</label>
                                @endforeach
                            @else
                                <label>NO TIME</label>
                            @endif
                            </td>

                            <td>
                            @if($timesheet->record)
                                @foreach($timesheet->record as $key => $record)
                                    <label>{{ ($record->time_sheet_activity == '' ? $timesheet->default_remarks : $record->time_sheet_activity) }}</label>
                                @endforeach
                            @else 
                                <label>{{ $timesheet->default_remarks }}</label>
                            @endif
                            </td>
                           
                            @if($timesheet->custom_shift == 1)
                                <td class="shift-custom text-center">CUSTOM</td>
                            @else
                                <td class="shift-custom text-center">DEFAULT</td>
                            @endif
                            
                            <td>
                            @if($timesheet->record)
                                @foreach($timesheet->record as $key => $record)
                                    <label>{{ $record->source }}</label>
                                @endforeach
                            @else 
                                <label>Manually Encoded</label>
                            @endif
                            </td>

                            <td>
                            @if($timesheet->record)
                                @foreach($timesheet->record as $key => $record)
                                    <label>{{ $record->branch }}</label>
                                @endforeach
                            @else 
                                <label>New</label>
                            @endif
                            </td>

                            <td>{!! $timesheet->daily_info->value_html !!}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col-md-6 pull-right" >
            <table style="width: 100%;" class="table table-bordered">
                <tbody>
                @foreach($period_record->cutoff_breakdown->_time_breakdown as $key => $time_breakdown)
                  <tr>
                      <td style="text-transform:uppercase">{{ str_replace("_"," ",$key) }}</td>
                      <td class="text-right">{{ $time_breakdown["time"] }}</td>
                  </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="modal-footer text-right">
    <button type="button" class="btn btn-primary">VIEW PDF</button>
    <button type="button" class="btn btn-def-white btn-custom-white" data-dismiss="modal">CLOSE</button>
</div>
<style type="text/css">
    .timesheet-title
    {
        text-transform:uppercase;
        font-size: 18px;
        font-weight: bold;
    }

    .timesheet-thead
    {
        text-transform: uppercase;
        font-size: 14px;
    }
    td
    {
        font-size: 14px;
        text-align: center;

    }
</style>
