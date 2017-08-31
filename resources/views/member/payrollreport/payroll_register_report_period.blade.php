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



<div class="panel panel-default panel-block panel-title-block" style="overflow-x: scroll; ">
    <div class="panel-body form-horizontal">
        <div class="form-group tab-content panel-body employee-container">
            <div id="all" class="tab-pane fade in active">
                <div class="form-group order-tags"></div>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-condensed" style="table-layout: fixed;">
					    <thead style="text-transform: uppercase">
					        <tr>
					            <th valign="center" rowspan="2" class="text-center" style="width: 200px">NAME</th>
					            <th valign="center" rowspan="2" class="text-center" style="width: 100px">BASIC PAY</th>
					            <th valign="center" rowspan="2" class="text-center" style="width: 100px">Over Time PAY</th>
					            <th valign="center" rowspan="2" class="text-center" style="width: 100px">Night Differential Pay</th>
					            <th valign="center" rowspan="2" class="text-center" style="width: 100px">Regular Holiday Pay</th>
					            <th valign="center" rowspan="2" class="text-center" style="width: 100px">Special Holiday Pay</th>
					            <th valign="center" rowspan="2" class="text-center" style="width: 100px">Restday Pay</th>
					            <th valign="center" rowspan="2" class="text-center" style="width: 100px">Leave Pay</th>
					            <th valign="center" rowspan="2" class="text-center" style="width: 100px">COLA</th>
					            <th valign="center" rowspan="2" class="text-center" style="width: 100px">LATE</th>
					            <th valign="center" rowspan="2" class="text-center" style="width: 100px">UNDERTIME</th>
					            <th valign="center" rowspan="2" class="text-center" style="width: 100px">ABSENT</th>
					            <th colspan="2" class="text-center" style="width: 200px">ALLOWANCES</th>
					            <th colspan="6" class="text-center" style="width: 600px">DEDUCTIONS</th>
					            <th colspan="3" class="text-center" style="width: 300px">SSS Contribution</th>
					            <th colspan="2" class="text-center" style="width: 200px">PAG-IBIG Contribution</th>
					            <th colspan="2" class="text-center" style="width: 200px">PHILHEALTH Contribution</th>
					            <th valign="center" rowspan="2" class="text-center" style="width: 100px">Witholding Tax</th>
					            <th valign="center" rowspan="2" class="text-center" style="width: 100px">TOTAL DEDUCTION</th>
					            <th valign="center" rowspan="2" class="text-center" style="width: 100px">GROSS PAY</th>
								<th valign="center" rowspan="2" class="text-center" style="width: 100px">NET HOME PAY</th>
													           
					        </tr>
					        
					        <tr>
	                            <th class="text-center" style="width: 100px">Allowances</th>
	                            <th class="text-center" style="width: 100px">Adjustment Allowances</th>

	                            <th class="text-center" style="width: 100px">SSS LOAN</th>
	                            <th class="text-center" style="width: 100px">HDMF LOAN</th>
	                            <th class="text-center" style="width: 100px">CASH BOND</th>
	                            <th class="text-center" style="width: 100px">CASH ADVANCE</th>
	                            <th class="text-center" style="width: 100px">OTHER DEDUCTIONS</th>
	                            <th class="text-center" style="width: 100px">ADJUSTMENT DEDUCTION</th>

	                            <th class="text-center" style="width: 100px">SSS EE</th>
	                            <th class="text-center" style="width: 100px">SSS ER</th>
	                            <th class="text-center" style="width: 100px">SSS EC</th>

	                            <th class="text-center" style="width: 100px">HDMF ER</th>
	                            <th class="text-center" style="width: 100px">HDMF ER</th>

	                            <th class="text-center" style="width: 100px">PHIC ER</th>
	                            <th class="text-center" style="width: 100px">PHIC EC</th>
                        	</tr>
					    </thead>
					    <tbody>
					   @foreach($_employee as $lbl => $employee)
					    <tr>	
					    	<td class="text-center" >{{ $employee->payroll_employee_first_name }} {{ $employee->payroll_employee_last_name }}</td>
					    	<td class="text-center" >{{ number_format($employee->net_basic_pay,2) }}</td>
					    	<td class="text-center" >{{ number_format($employee->overtime,2) }}</td>
					    	<td class="text-center" >{{ number_format($employee->nightdiff,2) }}</td>
					    	<td class="text-center" >{{ number_format($employee->regular_holiday,2) }}</td>
					    	<td class="text-center" >{{ number_format($employee->special_holiday,2) }}</td>
					    	<td class="text-center" >{{ number_format($employee->restday,2 )}}</td>
					    	<td class="text-center" >{{ number_format($employee->leave_pay,2) }}</td>
					    	<td class="text-center" >{{ number_format($employee->cola,2) }}</td>
					    	<td class="text-center" >{{ number_format($employee->late,2) }}</td>
					    	<td class="text-center" >{{ number_format($employee->undertime,2) }}</td>
					    	<td class="text-center" >{{ number_format($employee->absent,2) }}</td>
					    	<td class="text-center" >{{ number_format($employee->allowance,2) }}</td>
					    	<td class="text-center" >{{ number_format($employee->adjustment_allowance,2) }}</td>
					    	<td class="text-center" >{{ number_format($employee->sss_loan,2) }}</td>
					    	<td class="text-center" >{{ number_format($employee->hdmf_loan,2) }}</td>
					    	<td class="text-center" >{{ number_format($employee->cash_bond,2) }}</td>
					    	<td class="text-center" >{{ number_format($employee->cash_advance,2) }}</td>
					    	<td class="text-center" >{{ number_format($employee->other_loans,2) }}</td>
					    	<td class="text-center" >{{ number_format($employee->adjustment_deduction,2) }}</td>
					    	<td class="text-center" >{{ number_format($employee->sss_ee,2) }}</td>
					    	<td class="text-center" >{{ number_format($employee->sss_er,2) }}</td>
					    	<td class="text-center" >{{ number_format($employee->sss_ec,2) }}</td>
					    	<td class="text-center" >{{ number_format($employee->pagibig_ee,2) }}</td>
					    	<td class="text-center" >{{ number_format($employee->pagibig_er,2) }}</td>
					    	<td class="text-center" >{{ number_format($employee->philhealth_ee,2) }}</td>
					    	<td class="text-center" >{{ number_format($employee->philhealth_er,2) }}</td>
					    	<td class="text-center" >{{ number_format($employee->tax_ee,2) }}</td>
					    	<td class="text-center" >{{ number_format($employee->total_deduction_employee,2) }}</td>
					    	<td class="text-center" >{{ number_format($employee->gross_pay,2) }}</td>
					    	<td class="text-center" >{{ number_format($employee->net_pay,2) }}</td>
					    </tr>
					   @endforeach					     
				      
					       
					    </tbody>
					</table>
                </div>
            </div>
        </div> 
    </div>
</div>
@endsection