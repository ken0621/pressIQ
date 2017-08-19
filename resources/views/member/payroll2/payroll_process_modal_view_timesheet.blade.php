<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">×</button>
    <h4 class="modal-title"><b>NAME OF EMPLOYEEH HERE</b></h4>
</div>

<div class="modal-body clearfix employee-timesheet-modal">
    @if($employee)
        <table class="table table-bordered table-striped table-condensed">
            <thead style="text-transform: uppercase">
                <tr>
                    <th class="text-center" colspan="2">Actual</th>
                    <th class="text-center" colspan="2">Approved</th>
                    <th class="text-center" rowspan="2" width="120px">Remarks</th>
                </tr>
                <tr>
                    <th class="text-center">Time In</th>
                    <th class="text-center">Time Out</th>
                    <th class="text-center">Time In</th>
                    <th class="text-center">Time Out</th>
                   
                </tr>
            </thead>
            <tbody>
                @foreach($_timesheet as $timesheet)
                <tr>
                    <td class="text-center">{{$timesheet["converted_time_in"]}}</td>
                    <td class="text-center">{{$timesheet["converted_time_out"]}}</td>
                    <td class="text-center">{{$timesheet["converted_time_in"]}}</td>
                    <td class="text-center">{{$timesheet["converted_time_out"]}}</td>
                    <td class="text-center">{{$timesheet["remarks"]}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="modal-body clearfix">
            <div class="row">
                <div class="col-md-12">
                    <div class="col-md-3"></div>
                    <div class="col-md-3"></div>
                    <div style="text-transform: uppercase;" class="col-md-3 text-bold text-right title_summary">Number of Days Worked</div>
                    <div class="col-md-3 text-center title_description">{{$days_worked}}</div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="col-md-3"></div>
                    <div class="col-md-3"></div>
                    <div style="text-transform: uppercase;" class="col-md-3 text-bold text-right title_summary">Total Absent(s)</div>
                    <div class="col-md-3 text-center title_description">{{$total_absent}}</div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="col-md-3"></div>
                    <div class="col-md-3"></div>
                    <div style="text-transform: uppercase;" class="col-md-3 text-bold text-right title_summary">Total Late(s)</div>
                    <div class="col-md-3 text-center title_description">{{$total_late}}</div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="col-md-3"></div>
                    <div class="col-md-3"></div>
                    <div style="text-transform: uppercase;" class="col-md-3 text-bold text-right title_summary">Overtime</div>
                    <div class="col-md-3 text-center title_description">{{$overtime}}</div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="col-md-3"></div>
                    <div class="col-md-3"></div>
                    <div style="text-transform: uppercase;" class="col-md-3 text-bold text-right title_summary">Undertime</div>
                    <div class="col-md-3 text-center title_description">{{$undertime}}</div>
                </div>
            </div>
        </div>
    @else
        <div class="text-center" style="padding: 150px 0">NO DATA</div>
    @endif
</div>