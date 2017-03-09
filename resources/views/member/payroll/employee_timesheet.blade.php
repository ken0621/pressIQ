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
            <div class="col-md-3" style="padding: 10px">
            	<span style="font-size: 18px;">February 26, 2017 to March 10, 2017</span>
            </div>
            <div class="col-md-4 col-md-offset-5" style="padding: 10px">
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
                        <th class="text-center">Day</th>
                        <th class="text-center" colspan="2">Time</th>
                        <th class="text-center">Activities</th>
                        <th class="text-center">Total</th>
                        <th class="text-center">OT Hours</th>
                    </tr>
                    <tr>
                        <th class="text-center"></th>
                        <th class="text-center" width="30px">Time In</th>
                        <th class="text-center" width="30px">Time Out</th>
                        <th class="text-center"></th>
                        <th class="text-center"></th>
                        <th class="text-center"></th>
                    </tr>
                </thead>
                <tbody>
                	<tr>
                		<td class="text-center">26 (SUN)</td>
                		<td class="text-center editable"><input class="text-table" type="text" name="" value="10:30 AM"></td>
                		<td class="text-center editable"><input class="text-table"  type="text" name="" value="06:00 PM"></td>
                		<td class="text-center editable"><textarea placeholder="" class="text-table" ></textarea></td>
                		<td class="text-center">5 Hours and 10 Minutes</td>
                		
                		<td class="text-center">No Overtime</td>
                	</tr>
                	<tr>
                		<td class="text-center">27 (MON)</td>
                		<td class="text-center editable"><input class="text-table" type="text" name="" value="10:30 AM"></td>
                		<td class="text-center editable"><input class="text-table" type="text" name="" value="06:00 PM"></td>
                		<td class="text-center editable"><textarea placeholder="" class="text-table" ></textarea></td>
                		<td class="text-center ">5 Hours and 10 Minutes</td>
                		<td class="text-center">No Overtime</td>
                	</tr>
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
@endsection

@section('script')
	<script type="text/javascript" src="/assets/member/payroll/js/timesheet.js"></script>
@endsection