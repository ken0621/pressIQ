@extends('member.layout')
@section('css')
@endsection
@section('content')
<div class="panel panel-default panel-block panel-title-block" id="top">
	<div class="panel-heading">
		<div>
			<i class="fa fa-calendar"></i>
			<h1>
			<span class="page-title">Select a Payroll Period</span>
			<small>You can view timesheet inside a specific payroll period.</small>
			</h1>
			<div class="dropdown pull-right">
				<button class="btn btn-custom-primary dropdown-toggle " type="button" data-toggle="dropdown"><i class="fa fa-gears"></i>&nbsp;Operation
				<span class="caret"></span></button>
				<ul class="dropdown-menu dropdown-menu-custom">
					<li><a href="#" class="popup" link="/member/payroll/payroll_period_list/modal_create_payroll_period"><i class="fa fa-plus"></i>&nbsp;Generate Period</a></li>
					<li><a href="#" class="popup" link="/member/payroll/import_bio/modal_biometrics"><i class="fa fa-upload"></i>&nbsp;Import Time Sheet</a></li>
				</ul>
			</div>
		</div>
	</div>
</div>


<div class="panel panel-default panel-block panel-title-block panel-gray ">
    <ul class="nav nav-tabs">
        <li class="active change-tab pending-tab cursor-pointer" mode="pending"><a class="cursor-pointer"><i class="text-bold">1st</i> &nbsp; Pending</a></li>
        <li class="cursor-pointer change-tab approve-tab" mode="approved"><a class="cursor-pointer"><i class="text-bold">2nd</i> &nbsp; Processed</a></li>
        <li class="cursor-pointer change-tab approve-tab" mode="approved"><a class="cursor-pointer"><i class="text-bold">3rd</i> &nbsp; Registered</a></li>
        <li class="cursor-pointer change-tab approve-tab" mode="approved"><a class="cursor-pointer"><i class="text-bold">4th</i> &nbsp; Posted</a></li>
        <li class="cursor-pointer change-tab approve-tab" mode="approved"><a class="cursor-pointer"><i class="text-bold">Last</i> &nbsp; Approved</a></li>
    </ul>
    
    <div class="search-filter-box">
        <div class="col-md-4" style="padding: 10px">
            <select class="form-control item_type company-change-event">
            	<option value="0">All Company</option>
            	@foreach($_company as $company)
            		<option value="{{ $company->payroll_company_id }}">{{ $company->payroll_company_name }}</option>
            	@endforeach
            </select>
        </div>
<!--         <div class="col-md-4 col-md-offset-4" style="padding: 10px">
            <div class="input-group">
                <span style="background-color: #fff; cursor: pointer;" class="input-group-addon" id="basic-addon1"><i class="fa fa-search"></i></span>
                <input type="text" class="form-control search-employee-name" placeholder="Search by employee name / number" aria-describedby="basic-addon1">
            </div>
        </div>   -->
    </div>
    
    <div class="tab-content codes_container">
        <div id="all" class="tab-pane fade in active">
            <div class="form-group order-tags"></div>
                <div class="clearfix">
                    <div class="col-md-12">
                        <div class="table-responsive load-table-employee-list">
						    <table class="table table-bordered table-striped table-condensed">
						        <thead style="text-transform: uppercase">
						            <tr>
						                <th class="text-center">Date Covered</th>
						                <th class="text-center">Company</th>
						                <th class="text-center">Period Type</th>
						                <th class="text-center">Covered Month</th>
						                <th class="text-center">Period Order</th>
						                <th class="text-center"></th>
						                <th class="text-center"></th>
						            </tr>
						        </thead>
						        <tbody>
						        
						        	@foreach($_period as $period)
									<tr>
										<td class="text-center"><a href="javascript: action_load_link_to_modal('/member/payroll/payroll_period_list/modal_edit_period/{{$period->payroll_period_id }}', 'md')">{{ date('M d, Y',strtotime($period->payroll_period_start)).' - '.date('M d, Y',strtotime($period->payroll_period_end)) }}</a></td>
										<td class="text-center">{{ $period->payroll_company_name }}</td>
										<td class="text-center">{{ $period->payroll_period_category }}</td>
										<td class="text-center">{{ $period->month_contribution }}</td>
										<td class="text-center">{{ code_to_word($period->period_count) }}</td>
										<td class="text-center"><a onclick="return confirm('Are you sure you want to delete this payroll period? You will not be able to recover the timesheet if you delete a payroll period.')" href="/member/payroll/time_keeping/company_period/delete/{{ $period->payroll_period_company_id }}">Delete</a></td>
										<td class="text-center"><a href="/member/payroll/company_timesheet2/{{$period->payroll_period_company_id}}">View Employee</a></td>
									</tr>
									@endforeach
						        </tbody>
						    </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
@section('script')
<script type="text/javascript" src="/assets/member/js/payroll/payroll_timekeeping.js"></script>
@endsection