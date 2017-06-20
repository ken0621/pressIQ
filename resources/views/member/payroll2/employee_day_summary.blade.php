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
                                <td><input value="{{ $record->time_in }}" type="text" placeholder="NO TIME" class="text-table text-center time-entry time-in is-timeEntry" name=""></td>
                                <td><input value="{{ $record->time_out }}" type="text" placeholder="NO TIME" class="text-table text-center time-entry time-in is-timeEntry" name=""></td>
                                <td><input value="" type="text" class="text-table time-entry is-timeEntry" name=""></td>
                                <td class="text-center"><input {{ $record->auto_approved == 1 ? 'checked disabled hidden' : '' }} type="checkbox" class="text-table time-entry is-timeEntry" name=""></td>
                                <td class="text-center"><input {{ $record->auto_approved == 1 ? 'hidden' : 'checked' }} type="checkbox" class="text-table time-entry is-timeEntry" name=""></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="clearfix">
            <div class="col-md-6">
                <div style="padding: 10px; color: #bbb">
                    <div class="text-bold">SHIFT FOR THE DAY</div>
                    @foreach($timesheet_info->_shift as $record)
                    <div>{{ date("h:i A", strtotime($record->shift_in)) }} to {{ date("h:i A", strtotime($record->shift_out)) }}</div>
                    @endforeach
                </div>
            </div>
            <div class="col-md-6 text-right">
                <table width="100%" style="background-color: transparent;" class="pull-right">
                    <tbody>
                    <tr>
                        <td>Daily Rate</td>
                        <td width="100px"></td>
                        <td>PHP 755.00</td>
                    </tr>
                    <tr>
                        <td>Overtime</td>
                        <td width="100px" class="text-center" style="color: #bbb" width="100px">01:32</td>
                        <td width="100px">PHP 123.00</td>
                    </tr>
                    <tr>
                        <td class="text-bold" >Subtotal</td>
                        <td class="text-center" style="color: #bbb" width="100px"></td>
                        <td class="text-bold" width="100px">PHP 878.00</td>
                    </tr>
                    <tr>
                        <td>Less: Late Deduction</td>
                        <td class="text-center" style="color: #bbb" width="100px">00:30</td>
                        <td width="100px">PHP 52.00</td>
                    </tr>
                    <tr>
                        <td>Less: Undertime</td>
                        <td class="text-center" style="color: #bbb" width="100px">00:15</td>
                        <td width="100px">PHP 21.50</td>
                    </tr>
                    <tr style="color: #1682ba; font-size: 18px;">
                        <td class="text-bold">Total</td>
                        <td class="text-center" style="color: #bbb" width="100px"></td>
                        <td class="text-bold" width="100px">PHP 804.50</td>
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