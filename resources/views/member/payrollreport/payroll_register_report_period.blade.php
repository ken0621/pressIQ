@extends('member.layout')
@section('content')
<div class="panel panel-default panel-block panel-title-block" id="top">
	<div class="panel-heading">
		<div>
			<i class="fa fa-tags"></i>
			<h1>
			<span class="page-title">Payroll Reports &raquo; Register Report</span>
			<small>
			{{ $company->payroll_company_name }}
			</small>
			</h1>
			
		</div>
	</div>
</div>
<div class=" panel panel-default panel-block panel-title-block" >
	<div class="panel-body form-horizontal">
		<div class="col-md-2 padding-lr-1">
			<small>Filter by Company</small>
			<select class="form-control" id="filter_report" data-id="{{$filtering_company}}">
				<option value="0">All Company</option>
				@foreach($_filter_company as $filter_company)
				<option value="{{$filter_company->payroll_company_id}}" >{{$filter_company->payroll_company_name}}</option>
				@endforeach
			</select>
		</div>
		<div class="form-group tab-content panel-body employee-container">
			<div id="all" class="tab-pane fade in active">
				<div class="form-group order-tags"></div>
				<div class="labas_mo_dito table-responsive " id="show_me_something">
					<div class="filterResult">
						<div >
							<a href="/member/payroll/reports/payroll_register_report_period/export_excel/{{$period_info->payroll_period_company_id}}"><button style="margin-bottom: 20px;" type="button" class="btn btn-success pull-right"><i class="fa fa-file-excel-o" style="font-size:25px;color:white"></i> &nbsp;EXPORT TO EXCEL</button></a>
						</div>
						<div style="overflow-x: scroll;" class="col-md-12">
							<table class="table table-bordered table-striped table-condensed" style="table-layout: fixed;">
								<thead style="text-transform: uppercase">
									<tr>
										<th valign="center" rowspan="2" class="text-center" style="width: 200px">NAME</th>
										<th valign="center" rowspan="2" class="text-center" style="width: 120px">GROSS BASIC PAY</th>
										<th valign="center" rowspan="2" class="text-center" style="width: 120px">ABSENT</th>
										<th valign="center" rowspan="2" class="text-center" style="width: 120px">LATE</th>
										<th valign="center" rowspan="2" class="text-center" style="width: 120px">UNDERTIME</th>
										<th valign="center" rowspan="2" class="text-center" style="width: 120px">BASIC PAY</th>

										<th valign="center" rowspan="2" class="text-center" style="width: 120px">COLA</th>
										<th valign="center" rowspan="2" class="text-center" style="width: 120px">Over Time Pay</th>
										<th valign="center" rowspan="2" class="text-center" style="width: 120px">Night Differential Pay</th>
										<th valign="center" rowspan="2" class="text-center" style="width: 120px">Regular Holiday Pay</th>
										<th valign="center" rowspan="2" class="text-center" style="width: 120px">Special Holiday Pay</th>
										<th valign="center" rowspan="2" class="text-center" style="width: 120px">Restday Pay</th>
										<th valign="center" rowspan="2" class="text-center" style="width: 120px">Leave Pay</th>
										<!-- <th valign="center" rowspan="2" class="text-center" style="width: 120px">ALLOWANCES</th> -->
										
										<th colspan="9" class="text-center" style="width: 900px">ALLOWANCES</th>

										<th valign="center" rowspan="2" class="text-center" style="width: 100px">GROSS PAY</th>

										<th colspan="5" class="text-center" style="width: 600px">DEDUCTIONS</th>
										
										<th colspan="3" class="text-center" style="width: 300px">SSS Contribution</th>
										<th colspan="2" class="text-center" style="width: 200px">PAG-IBIG Contribution</th>
										<th colspan="2" class="text-center" style="width: 200px">PHILHEALTH Contribution</th>
										<th valign="center" rowspan="2" class="text-center" style="width: 100px">Witholding Tax</th>
										<th valign="center" rowspan="2" class="text-center" style="width: 100px">TOTAL DEDUCTION</th>
										
										<th valign="center" rowspan="2" class="text-center" style="width: 100px">NET HOME PAY</th>
									</tr>
									
									<tr>
										<th class="text-center" style="width: 100px">ALLOWANCE</th>
										<th class="text-center" style="width: 100px">BONUS</th>
										<th class="text-center" style="width: 100px">COMMISSION</th>
										<th class="text-center" style="width: 100px">INCENTIVES</th>
										<th class="text-center" style="width: 100px">CASH ADVANCE</th>
										<th class="text-center" style="width: 100px">CASH BOND</th>
										<th class="text-center" style="width: 100px">ADDITIONS</th>
										<th class="text-center" style="width: 100px">DEDUCTIONS</th>
										<th class="text-center" style="width: 100px">OTHERS</th>
										<!-- <th class="text-center" style="width: 100px">Allowances</th>
										<th class="text-center" style="width: 100px">Adjustment Allowances</th> -->
										<th class="text-center" style="width: 100px">SSS LOAN</th>
										<th class="text-center" style="width: 100px">HDMF LOAN</th>
										<th class="text-center" style="width: 100px">CASH BOND</th>
										<th class="text-center" style="width: 100px">CASH ADVANCE</th>
										<th class="text-center" style="width: 100px">OTHER DEDUCTIONS</th>
										<!--  <th class="text-center" style="width: 100px">ADJUSTMENT DEDUCTION</th> -->
										
										
										<th class="text-center" style="width: 100px">SSS EE</th>
										<th class="text-center" style="width: 100px">SSS ER</th>
										<th class="text-center" style="width: 100px">SSS EC</th>
										<th class="text-center" style="width: 100px">HDMF EE</th>
										<th class="text-center" style="width: 100px">HDMF ER</th>
										<th class="text-center" style="width: 100px">PHIC EE</th>
										<th class="text-center" style="width: 100px">PHIC ER</th>
									</tr>
								</thead>

								<tbody>
									@foreach($_employee as $lbl => $employee)
									<tr>
										<td class="text-center" >{{ $employee->payroll_employee_first_name }} {{ $employee->payroll_employee_last_name }}</td>
										<td class="text-center" >{{ number_format($employee->gross_basic_pay,2) }}</td>
										<td class="text-center" >{{ number_format($employee->absent,2) }} <br> ({{$employee->time_absent}} times)</td>
										<td class="text-center" >{{ number_format($employee->late,2) }} <br> ({{$employee->time_late}} hours)</td>
										<td class="text-center" >{{ number_format($employee->undertime,2) }} <br> ({{$employee->time_undertime}} hours)</td>
										<td class="text-center" >{{ number_format($employee->net_basic_pay,2) }} <br> ({{$employee->time_spent}} hours)</td>
										<td class="text-center" >{{ number_format($employee->cola,2) }}</td>
										<td class="text-center" >{{ number_format($employee->overtime,2) }} <br> ({{$employee->time_overtime}} hours)</td>
										<td class="text-center" >{{ number_format($employee->nightdiff,2) }} <br> ({{$employee->time_night_differential}} hours)</td>
										<td class="text-center" >{{ number_format($employee->special_holiday,2) }} <br> ({{$employee->time_special_holiday}} times)</td>
										<td class="text-center" >{{ number_format($employee->regular_holiday,2) }} <br> ({{$employee->time_regular_holiday}} times)</td>
										<td class="text-center" >{{ number_format($employee->restday,2 )}}</td>
										<td class="text-center" >{{ number_format($employee->leave_pay,2) }} <br> ({{$employee->time_leave_hours}} hours)</td>
									<!-- 	<td class="text-center" >{{ number_format($employee->allowance,2) }}</td> -->
										
										<td class="text-center" >{{ number_format($employee->adjsutment_allowance,2) + number_format($employee->allowance,2) }}</td>
										<td class="text-center" >{{ number_format($employee->adjsutment_bonus,2) }}</td>
										<td class="text-center" >{{ number_format($employee->adjsutment_commission,2) }}</td>
										<td class="text-center" >{{ number_format($employee->adjsutment_incentives,2) }}</td>
										<td class="text-center" >{{ number_format($employee->adjsutment_cash_advance,2) }}</td>
										<td class="text-center" >{{ number_format($employee->adjsutment_cash_bond,2) }}</td>
										<td class="text-center" >{{ number_format($employee->adjsutment_additions,2) }}</td>
										<td class="text-center" >{{ number_format($employee->adjsutment_deductions,2) }}</td>
										<td class="text-center" >{{ number_format($employee->adjsutment_others,2) }}</td>

										<td class="text-center" >{{ number_format($employee->gross_pay,2) }}</td>

										<!--<td class="text-center" >{{ number_format($employee->adjustment_allowance,2) }}</td>-->
										<td class="text-center" >{{ number_format($employee->sss_loan,2) }}</td>
										<td class="text-center" >{{ number_format($employee->hdmf_loan,2) }}</td>
										<td class="text-center" >{{ number_format($employee->cash_bond,2) }}</td>
										<td class="text-center" >{{ number_format($employee->cash_advance,2) }}</td>
										<td class="text-center" >{{ number_format($employee->other_loans,2) }}</td>
										<!-- <td class="text-center" >{{ number_format($employee->adjustment_deduction,2) }}</td> -->

										<td class="text-center" >{{ number_format($employee->sss_ee,2) }}</td>
										<td class="text-center" >{{ number_format($employee->sss_er,2) }}</td>
										<td class="text-center" >{{ number_format($employee->sss_ec,2) }}</td>
										<td class="text-center" >{{ number_format($employee->pagibig_ee,2) }}</td>
										<td class="text-center" >{{ number_format($employee->pagibig_er,2) }}</td>
										<td class="text-center" >{{ number_format($employee->philhealth_ee,2) }}</td>
										<td class="text-center" >{{ number_format($employee->philhealth_er,2) }}</td>
										<td class="text-center" >{{ number_format($employee->tax_ee,2) }}</td>
										<td class="text-center" >{{ number_format($employee->total_deduction_employee,2) }}</td>
										
										<td class="text-center" >{{ number_format($employee->net_pay,2) }}</td>
										
									</tr>
									@endforeach
									<tr>
										<td class="text-center" ><b>Total</b></td>
										<td class="text-center" ><b>{{ number_format($total_gross_basic, 2) }}</b></td>
										<td class="text-center" ><b>{{ number_format($absent_total, 2) }}</b></td>
										<td class="text-center" ><b>{{ number_format($late_total, 2) }}</b></td>
										<td class="text-center" ><b>{{ number_format($undertime_total, 2) }}</b></td>
										<td class="text-center" ><b>{{ number_format($total_basic, 2) }}</b></td>
										<td class="text-center" ><b>{{ number_format($cola_total, 2) }}</b></td>
										<td class="text-center" ><b>{{ number_format($overtime_total, 2) }}</b></td>
										<td class="text-center" ><b>{{ number_format($nightdiff_total, 2) }}</b></td>
										<td class="text-center" ><b>{{ number_format($regular_holiday_total, 2) }}</b></td>
										<td class="text-center" ><b>{{ number_format($special_holiday_total, 2) }}</b></td>
										<td class="text-center" ><b>{{ number_format($restday_total, 2) }}</b></td>
										<td class="text-center" ><b>{{ number_format($leave_pay_total, 2) }}</b></td>
										<!-- <td class="text-center" ><b>{{ number_format($allowance_total, 2) }}</b></td> -->

										<td class="text-center" ><b>{{ number_format($total_adjsutment_allowance, 2) + number_format($allowance_total, 2)}}</b></td>
										<td class="text-center" ><b>{{ number_format($total_adjsutment_bonus, 2) }}</b></td>
										<td class="text-center" ><b>{{ number_format($total_adjsutment_commission, 2) }}</b></td>
										<td class="text-center" ><b>{{ number_format($total_adjsutment_incentives, 2) }}</b></td>
										<td class="text-center" ><b>{{ number_format($total_adjsutment_cash_advance, 2) }}</b></td>
										<td class="text-center" ><b>{{ number_format($total_adjsutment_cash_bond, 2) }}</b></td>
										<td class="text-center" ><b>{{ number_format($total_adjsutment_additions, 2) }}</b></td>
										<td class="text-center" ><b>{{ number_format($total_adjsutment_deductions, 2) }}</b></td>
										<td class="text-center" ><b>{{ number_format($total_adjsutment_others, 2) }}</b></td>

										<td class="text-center" ><b>{{ number_format($total_gross, 2) }}</b></td>

										<!-- <td class="text-center" ><b>{{ number_format($adjustment_allowance_total,2) }}</b></td> -->
										<td class="text-center" ><b>{{ number_format($sss_loan_total, 2) }}</b></td>
										<td class="text-center" ><b>{{ number_format($hdmf_loan_total, 2) }}</b></td>
										<td class="text-center" ><b>{{ number_format($cash_bond_total, 2) }}</b></td>
										<td class="text-center" ><b>{{ number_format($cash_advance_total, 2) }}</b></td>
										<td class="text-center" ><b>{{ number_format($other_loans_total, 2) }}</b></td>
										<!-- <td class="text-center" ><b>{{ number_format($adjustment_deduction_total,2) }}</b></td> -->
										
										<td class="text-center" ><b>{{ number_format($sss_ee_total, 2) }}</b></td>
										<td class="text-center" ><b>{{ number_format($sss_er_total, 2) }}</b></td>
										<td class="text-center" ><b>{{ number_format($sss_ec_total, 2) }}</b></td>
										<td class="text-center" ><b>{{ number_format($hdmf_ee_total, 2) }}</b></td>
										<td class="text-center" ><b>{{ number_format($hdmf_er_total, 2) }}</b></td>
										<td class="text-center" ><b>{{ number_format($philhealth_ee_total, 2) }}</b></td>
										<td class="text-center" ><b>{{ number_format($philhealth_er_total, 2) }}</b></td>
										<td class="text-center" ><b>{{ number_format($witholding_tax_total, 2) }}</b></td>
										<td class="text-center" ><b>{{ number_format($deduction_total, 2) }}</b></td>
										
										<td class="text-center" ><b>{{ number_format($total_net, 2) }}</b></td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
{{-- <script type="text/javascript" src="/assets/js/ajax_offline.js"></script> --}}
<script type="text/javascript" src="/assets/js/payroll_register_report_filter.js"></script>
@endsection