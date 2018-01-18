<link rel="stylesheet" type="text/css" href="/assets/member/payroll/css/timesheet.css">
<link rel="stylesheet" type="text/css" href="/assets/external/jquery.timeentry.package-2.0.1/jquery.timeentry.css">
<form class="global-submit form-horizontal" role="form" action="{link_submit_here}" method="post">
	<input type="hidden" class="_token" value="{{ csrf_token() }}" />
    <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal">×</button>
		<h4 class="modal-title">Without Pay - Leave Records</h4>
	</div>
        <input type="hidden" id="category" value="monthly_without">
    <div class="panel panel-default panel-block panel-title-block">
        <div class="panel-body form-horizontal">
            <div class="form-group">
                  <div class="col-md-3">
                        <small>Date Start</small>
                        <input type="text" name="payroll_schedule_leave_start" id="start" class="date_picker form-control payroll_schedule_leave_start" value="{{date("m/d/Y")}}" required>
                 </div>

                 <div class="col-md-3">
                       <small>Date End</small>
                       <input type="text" name="payroll_schedule_leave_end" id="end" class="date_picker form-control payroll_schedule_leave_end" value="{{date("m/d/Y")}}" required>
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
                                <th class="text-center">Employee Number</th>
                                <th class="text-center">Employee Name</th>
                                <th class="text-center">Leave Credits</th>
                                <th class="text-center">Used Leave without Pay</th>
                                <th class="text-center">Remaining Leave</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(isset($leave_report))
                 			@foreach($leave_report as $leave_data)
                                @foreach($leave_data as $leave)
                                	<tr>
                                        <td class="text-center">{{ $leave->payroll_leave_temp_name }}</td>
                                		<td class="text-center">{{ $leave->payroll_employee_id }}</td>
                                		<td class="text-center">{{ $leave->payroll_employee_display_name }}</td>
                                		<td class="text-center">{{ $leave->payroll_leave_temp_hours }}</td>
                                		<td class="text-center">{{ $leave->total_leave_consume }}</td>
                                        @foreach($remainings as $remain)
                                         @foreach($remain as $rem)
                                          @if($rem->payroll_employee_id == $leave->payroll_employee_id)
                                		  <td class="text-center">{{ $rem->remaining_leave }}</td>
                                          @endif
                                          @endforeach
                                        @endforeach
                                	</tr>
                                 @endforeach
                        	@endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
	</div>
    <div class="modal-footer">
        <button type="button" class="btn btn-def-white btn-custom-white" data-dismiss="modal">Close</button>
        &nbsp;<a href="/member/payroll/leave/v2/withoutpay_leave_report_excel/{{date("Y-m-d")}}/{{date("Y-m-d")}}"><button type="button" class="btn btn-success pull-right"><i class="fa fa-file-excel-o" ></i> &nbsp;EXPORT TO EXCEL</button></a>
    </div>
    </div>
</form>

<style type="text/css">
    #global_modal .modal-dialog
    {
        width: 85% !important;
    }
</style>
<script type="text/javascript" src="/assets/external/jquery.timeentry.package-2.0.1/jquery.plugin.min.js"></script>
<script type="text/javascript" src="/assets/external/jquery.timeentry.package-2.0.1/jquery.timeentry.min.js"></script>
<script type="text/javascript">
        $(".date_picker").datepicker();
</script>
<script type="text/javascript" src="/assets/member/js/payroll/modal_create_leave_tempv2.js"></script>