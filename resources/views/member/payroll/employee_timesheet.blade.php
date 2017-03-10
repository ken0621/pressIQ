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
            <table style="table-layout: fixed;" class="timesheet table table-condensed table-bordered table-sale-month">
                <thead>
                    <tr>
                        <th width="80px" class="text-center" colspan="2">Day</th>
                        <th width="200px" class="text-center" colspan="2">Time</th>
                        <th class="text-center">Activities</th>

                        <th width="100px" class="text-center">Regular</th>
                        <th width="100px" class="text-center">Break</th>
                        <th width="100px" class="text-center">Overtime</th>
                        <th width="100px" class="text-center">Rest Day</th>
                        <th width="50px" class="text-center"></th>
                    </tr>
                    <tr>
                        <th class="text-center"></th>
                        <th class="text-center"></th>
                        <th class="text-center">Time In</th>
                        <th class="text-center">Time Out</th>
                        <th class="text-center"></th>
                        <th class="text-center"></th>
                        <th class="text-center"></th>
                        <th class="text-center"></th>
                        <th class="text-center"></th>
                        <th class="text-center"></th>
                    </tr>
                </thead>
                <tbody>
                	@foreach($_timesheet as $timesheet)
	            		<tr class="total">
	                		<td class="text-center edit-data">{{ $timesheet->day_number }}</td>
	                		<td class="text-center edit-data">{{ $timesheet->day_word }}</td>
	                		<td class="text-center editable total-mod" colspan="2"></td>
	                		<td class="text-center editable normal-mod"><input class="text-table time-entry time-in" type="text" name="" value="10:30AM"></td>
	                		<td class="text-center editable normal-mod"><input class="text-table time-entry time-out"  type="text" name="" value="06:00PM"></td>
	                		<td class="text-center editable normal-mod"><textarea placeholder="" class="text-table" ></textarea></td>
	                		<td class="text-center editable total-mod"></td>
	                		<td class="text-center edit-data">05:10:30</td>
							<td class="text-center edit-data"><input class="text-table"  type="text" name="" value="01:00:00"></td>
	                		<td class="text-center edit-data">00:00:00</td>
	                		<td class="text-center edit-data">00:00:00</td>
	                		<td class="text-center"><button><i class="fa fa-plus"></i></button></td>
	            		</tr>
                		@foreach($timesheet->time_record as $time_record)
                		<tr class="breakdown">
	                		<td class="text-center edit-data"></td>
	                		<td class="text-center edit-data"></td>
	                		<td class="text-center editable"><input class="text-table time-entry time-in" type="text" name="" value="{{ $time_record->time_in }}"></td>
	                		<td class="text-center editable"><input class="text-table time-entry time-out"  type="text" name="" value="{{ $time_record->time_out }}"></td>
	                		<td class="text-center editable"><textarea placeholder="" class="text-table" ></textarea></td>
	                		<td class="text-center edit-data">05:10:30</td>
	                		<td class="text-center edit-data"></td>
	                		<td class="text-center edit-data"></td>
	                		<td class="text-center edit-data"></td>
	                		<td class="text-center"></td>
                		</tr>
                		@endforeach
                	@endforeach
                </tbody>
            </table>
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

	<script type="text/javascript" src="/assets/member/payroll/js/timesheet.js"></script>
	<script type="text/javascript" src="/assets/external/jquery.timeentry.package-2.0.1/jquery.plugin.min.js"></script>
	<script type="text/javascript" src="/assets/external/jquery.timeentry.package-2.0.1/jquery.timeentry.min.js"></script>
@endsection