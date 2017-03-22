<form class="global-submit form-horizontal over-time-form" role="form" action="{link_submit_here}" method="post">
    
    <input type="hidden" class="field-hidden-date" value="{{ $timesheet_info->payroll_time_date }}">
    <input type="hidden" class="field-hidden-employee-id" value="{{ $timesheet_info->payroll_employee_id }}">

    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">×</button>
        <h4 class="modal-title">TIME RECORD APPROVAL</h4>
    </div>
    <div class="modal-body clearfix">

        <!-- TABLE TIME IN AND OUT -->
        <h4>TIME RECORD</h4>
        <table class="table table-condensed table-bordered">
            <thead>
                <tr>
                    <th>TIME IN</th>
                    <th>TIME OUT</th>
                </tr>
            </thead>
            <tbody>
                @foreach($_time_record as $time_record)
                <tr>
                    <td><input class="over-time-entry form-control" time_max="{{ $time_record->time_in_max }}" time_min="{{ $time_record->time_in_min }}" {{ $time_record->time_in_enabled==true ? ''  : 'disabled' }}  type="" name="" value="{{ $time_record->time_in }}"></td>
                    <td><input class="over-time-entry form-control" time_max="{{ $time_record->time_out_max }}" time_min="{{ $time_record->time_out_min }}" {{ $time_record->time_out_enabled==true ? ''  : 'disabled' }}  type="" name="" value="{{ $time_record->time_out }}"></td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <!-- TABLE TIME IN AND OUT -->
        <h4>SUMMARY HOURS</h4>
        <table class="table table-condensed table-bordered">
            <thead>
                <tr>
                    <th></th>
                    <th class="text-center">ACTUAL</th>
                    <th class="text-center">APPROVED</th>
                    <th></th>
                    <th class="text-center">ACTUAL</th>
                    <th class="text-center">APRROVED</th>
                </tr>
            </thead>
            <tbody>

                <tr>
                    <td class="text-right">REGULAR TIME</td>
                    <td width="60px" class="text-center old_regular_hours">00:00</td>
                    <td width="60px" class="text-center new_regular_hours">00:00</td>
                    <td class="text-right">NIGHT DIFFERENTIAL</td>
                    <td width="60px" class="text-center old_night_differential time-summary-adjustment">00:00</td>
                    <td width="60px" class="text-center new_night_differential time-summary-adjustment">00:00</td>
                </tr>
                <tr>
                    <td class="text-right">EARLY OVERTIME</td>
                    <td width="60px" class="text-center old_early_overtime time-summary-adjustment">00:00</td>
                    <td width="60px" class="text-center new_early_overtime time-summary-adjustment">00:00</td>
                    <td class="text-right">REGULAR OVERTIME</td>
                    <td width="60px" class="text-center old_late_overtime time-summary-adjustment">00:00</td>
                    <td width="60px" class="text-center new_late_overtime time-summary-adjustment">00:00</td>
                </tr>
                <tr>
                    <td class="text-right">EXTRA DAY</td>
                    <td width="60px" class="text-center old_extra_day time-summary-adjustment">00:00</td>
                    <td width="60px" class="text-center new_extra_day time-summary-adjustment">00:00</td>
                    <td class="text-right">REST DAY</td>
                    <td width="60px" class="text-center old_rest_day time-summary-adjustment">00:00</td>
                    <td width="60px" class="text-center new_rest_day time-summary-adjustment">00:00</td>
                </tr>
                <tr>
            </tbody>
        </table>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-def-white btn-custom-white" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-def-white btn-custom-white">Set to Default</button>
        <button class="btn btn-primary btn-custom-primary" type="button"">Approve New Time</button>
    </div>
</form>