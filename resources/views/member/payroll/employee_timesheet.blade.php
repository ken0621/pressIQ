@extends('member.layout')

@section('content')

<div class="panel panel-default panel-block panel-title-block">
    <input type="hidden" name="_token" id="_token" value="{{csrf_token()}}"/>
    <div class="panel-heading">
        <div>
            <i class="fa fa-calendar"></i>
            <h1>
                <span class="page-title">Timesheet</span>
                <small>
                Time Record for Employee (Guillermo Tabligan)
                </small>
            </h1>
            
            <a href="javascript:" class="panel-buttons btn btn-custom-primary pull-right popup" link="/member/customer/modalcreatecustomer" size="lg" data-toggle="modal" data-target="#global_modal">View Employee Status</a>
        </div>
    </div>
</div>
<div class="panel panel-default panel-block panel-title-block">
    <div class="panel-body">
        <div class="search-filter-box">
            <div class="col-md-5" style="padding: 10px">
            	<span style="font-size: 18px;">February 26, 2017 to March 10, 2017</span>
            </div>
            <div class="col-md-4 col-md-offset-3" style="padding: 10px">
                <div class="input-group">
                    <span style="background-color: #fff; cursor: pointer;" class="input-group-addon" id="basic-addon1"><i class="fa fa-search"></i></span>
                    <select class="form-control">
                        <option>Guillermo Tabligan</option>
                        <option>Jimar Zape</option>
                    </select>
                </div>
            </div>
        </div>

        <div class=" panel-customer load-data">
            <form class="payroll-form" action="return false;">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="time_rule" value="{{ $time_rule }}">
                <input type="hidden" name="default_time_in" value="{{ $default_time_in }}">
                <input type="hidden" name="default_time_out" value="{{ $default_time_out }}">
                <input type="hidden" name="default_working_hours" value="{{ $default_working_hours }}">
                default_working_hours
                <table style="table-layout: fixed;" class="timesheet table table-condensed table-bordered table-sale-month">
                    <thead style="text-transform: uppercase;">
                        <tr>
                            <th width="40px" class="text-center"></th>
                            <th width="40px" class="text-center"></th>
                            <th width="40px" class="text-center"></th>
                            <th width="200px" class="text-center" colspan="2">Time</th>
                            <th class="text-center"></th>
                            <th width="90px" rowspan="2" class="text-center">Approved<br>Overtime</th>
                            <th width="80px" class="text-center"></th>
                            <th width="80px" class="text-center"></th>
                            <th width="160px" colspan="2" class="text-center">Overtime</th>
                            <th width="100px" class="text-center"></th>
                            <th width="50px" class="text-center"></th>
                        </tr>
                        <tr>
                            <th width="40px" class="text-center"></th>
                            <th class="text-center" colspan="2">Day</th>
                            <th class="text-center">Time In</th>
                            <th class="text-center">Time Out</th>
                            <th class="text-center">Activities</th>

                            <th width="80px" class="text-center">Break</th>
                            <th width="80px" class="text-center">Normal</th>

                            <th class="text-center">Early</th>
                            <th class="text-center">Regular</th>
                            <th class="text-center">Type</th>
                            <th class="text-center"></th>
                        </tr>
                    </thead>
                    <tbody>
                    	@foreach($_timesheet as $timesheet)
                    		@foreach($timesheet->time_record as $key => $time_record)
    	            		<tr class="time-record {{ $key == 0 ? 'main' : '' }}" date="{{ $timesheet->date }}" total_hours="00:00" total_normal_hours="00:00" total_early_overtime="00:00" total_late_overtime="00:00">
    	                		
                                @if($key == 0) <!--MAIN -->
                                    <input type="hidden" name="date[{{ $timesheet->date}}][{{ $key }}]" value="{{ $timesheet->date }}">
                                    <td class="text-center day-number"><i class="fa fa-check"></i></td>
                                    <td class="text-center edit-data day-number">{{ $timesheet->day_number }}</td>
    	                			<td class="text-center edit-data day-word">{{ $timesheet->day_word }}</td>
    	                			<td class="text-center editable"><input placeholder="NO TIME" class="text-table time-entry time-in" type="text" name="time_in[{{ $timesheet->date}}][{{ $key }}]" value="{{ $time_record->time_in }}"></td>
    	                			<td class="text-center editable"><input placeholder="NO TIME" class="text-table time-entry time-out"  type="text" name="time_out[{{ $timesheet->date}}][{{ $key }}]" value="{{ $time_record->time_out }}"></td>
    	                			<td class="text-center editable"><textarea placeholder="" class="text-table" ></textarea></td>
    								<td class="text-center edit-data"><input class="text-table ot-approved time-entry-24"  type="text" name="approved_ot[{{ $timesheet->date}}]" value="00:00"></td>
    		                		<td class="text-center edit-data"><input class="text-table break-time time-entry-24"  type="text" name="break[{{ $timesheet->date}}]" value="{{ $timesheet->break }}"></td>
                                    <td class="text-center edit-data normal-hours">00:00</td>
    		                		<td class="text-center edit-data overtime-hours early">00:00</td>
    		                		<td class="text-center edit-data overtime-hours late">00:00</td>
    		                		<td class="text-center edit-data">Regular</td>
    		                		<td class="text-center"><span class="button create-sub-time"><i class="fa fa-plus"></i></span></td>
                                @else 
                                    <input type="hidden" name="date[{{ $timesheet->date}}][{{ $key }}]" value="{{ $timesheet->date }}">
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
    		                		<td class="text-center"><span class="button delete-sub-time"><i class="fa fa-close"></i></span></td>
    	                		@endif


    	            		</tr>
                    		@endforeach
                    	@endforeach

                        <!-- READY HTML FOR APPEND -->
    	                <tfoot class="hidden sub-time-container">
    	                	<tr class="time-record new-sub" date="0000-00-00" total_hours="00:00" total_ot_early="00:00" total_ot_late="00:00">
    		                	<td class="text-center edit-data"></td>
                                <td class="text-center edit-data"></td>
    		                	<td class="text-center edit-data"></td>
    		                	<td class="text-center editable"><input class="text-table time-entry time-in is-timeEntry" name="" value="9:00AM" type="text"><span class="timeEntry-control" style="display: inline-block; background: url('spinnerDefault.png') 0 0 no-repeat; width: 20px; height: 20px;"></span></td>
    		                	<td class="text-center editable"><input class="text-table time-entry time-out is-timeEntry" name="" value="6:00PM" type="text"><span class="timeEntry-control" style="display: inline-block; background: url('spinnerDefault.png') 0 0 no-repeat; width: 20px; height: 20px;"></span></td>
    		                	<td class="text-center editable"><textarea placeholder="" class="text-table"></textarea></td>	
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
            </form>
            <div class="padding-10 text-center">
            </div>
        </div>
    </div>
</div>
@endsection

@section('css')
	<link rel="stylesheet" type="text/css" href="/assets/member/payroll/css/timesheet.css">
	<link rel="stylesheet" type="text/css" href="/assets/external/jquery.timeentry.package-2.0.1/jquery.timeentry.css">
@endsection

@section('script')
	<script type="text/javascript">
		var time_rule = "{{ $time_rule }}";
		var default_time_in = "{{ $default_time_in }}";
		var default_time_out = "{{ $default_time_out }}";
	</script>
	<script type="text/javascript" src="/assets/member/payroll/js/timesheet.js"></script>
	<script type="text/javascript" src="/assets/external/jquery.timeentry.package-2.0.1/jquery.plugin.min.js"></script>
	<script type="text/javascript" src="/assets/external/jquery.timeentry.package-2.0.1/jquery.timeentry.min.js"></script>
@endsection