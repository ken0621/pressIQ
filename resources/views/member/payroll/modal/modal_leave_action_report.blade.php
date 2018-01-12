<form class="global-submit form-horizontal" role="form" action="{link_submit_here}" method="post">
	<input type="hidden" class="_token" value="{{ csrf_token() }}" />
    <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal">×</button>
		<h4 class="modal-title">Leave Action Report {{-- {{$month_today_string}} --}}</h4>
	</div>
    <div class="panel panel-default panel-block panel-title-block">
        <div class="panel-body form-horizontal">
            <div class="form-group">
                <div class="col-md-3">
       {{--              <select class="form-control filter-by-month-leave" name="month">
                        <option value="0">Month</option>
                        @foreach($months as $key=>$month)
                            @if($key == $month_today)
                            <option value="{{$key}}" selected>{{$month}}</option>
                            @else
                            <option value="{{$key}}">{{$month}}</option>
                            @endif
                        @endforeach
                    </select> --}}
                </div>
            </div>
        </div>
    </div>
    <div class="text-center" id="spinningLoader" style="display:none;">
                <img src="/assets/images/loader.gif">
    </div>
    <div class="load-filter-data">
	<div class="modal-body clearfix">
                <div class="table-responsive">
                    <table class="table table-bordered table-condensed">
                        <thead>
                            <tr>
                                <th class="text-center">Leave Name</th>
                                <th class="text-center" width="30">Employee Code</th>
                                <th class="text-center">Employee Name</th>
                                <th class="text-center" width="10">Leave Credits</th>
                                <th class="text-center" width="10">Leave Hours Remaining</th>
                                <th class="text-center" width="10">Leave Hours Accumulated</th>
                                <th class="text-center" width="10">Cash Converted</th>
                                <th class="text-center">Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(isset($leave_report))
                 			@foreach($leave_report as $leave)
                        	<tr>
                                <td class="text-center">{{ $leave->payroll_leave_temp_name }}</td>
                        		<td class="text-center">{{ $leave->payroll_employee_id }}</td>
                        		<td class="text-center">{{ $leave->payroll_employee_display_name }}</td>
                                <td class="text-center">{{ $leave->payroll_leave_temp_hours }}</td>
                        		<td class="text-center">{{ $leave->payroll_leave_hours_remaining }}</td>
                        		<td class="text-center">{{ $leave->payroll_leave_hours_accumulated }}</td>
                        		<td class="text-center">{{ $leave->payroll_leave_cash_converted }}</td>
                                <td class="text-center">{{ $leave->payroll_report_date_created }}</td>
                        	</tr>
                        	@endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
	</div>
    <div class="modal-footer">
        <button type="button" class="btn btn-def-white btn-custom-white" data-dismiss="modal">Close</button>
        &nbsp;<a href="/member/payroll/leave/v2/leave_action_report_excel"><button type="button" class="btn btn-success pull-right"><i class="fa fa-file-excel-o" ></i> &nbsp;EXPORT TO EXCEL</button></a>
    </div>
    </div>
</form>

<style type="text/css">
    #global_modal .modal-dialog
    {
        width: 85% !important;
    }
</style>
<script type="text/javascript" src="/assets/member/js/payroll/modal_create_leave_tempv2.js"></script>