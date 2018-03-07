	@if(!isset($v2))
    <h4 class="modal-title" style="font-weight: bold;"><b>{{ $employee->payroll_employee_first_name }} {{ $employee->payroll_employee_middle_name }} {{ $employee->payroll_employee_last_name }}<br></h4>
    @endif	
    <div class="modal-body clearfix">
                <div class="table-responsive">
                     <table class="table table-bordered table-striped table-condensed" style="table-layout: fixed;">
					    <thead style="text-transform: uppercase">
					        <tr>
					        	@if(isset($v2))
					        	<th valign="center" rowspan="2" class="text-center" style="width: 200px">Name</th>
					        	@endif
					            <th valign="center" rowspan="2" class="text-center" style="width: 200px">PERIOD DATE</th>
					            <th valign="center" rowspan="2" class="text-center" style="width: 120px">BASIC PAY</th>
					            <th valign="center" rowspan="2" class="text-center" style="width: 120px">Over Time PAY</th>
					            <th valign="center" rowspan="2" class="text-center" style="width: 120px">Night Differential Pay</th>
					            <th valign="center" rowspan="2" class="text-center" style="width: 120px">Regular Holiday Pay</th>
					            <th valign="center" rowspan="2" class="text-center" style="width: 120px">Special Holiday Pay</th>
					            <th valign="center" rowspan="2" class="text-center" style="width: 120px">Restday Pay</th>
					            <th valign="center" rowspan="2" class="text-center" style="width: 120px">Leave Pay</th>
					            <th valign="center" rowspan="2" class="text-center" style="width: 120px">COLA</th>
					            <th valign="center" rowspan="2" class="text-center" style="width: 120px">LATE</th>
					            <th valign="center" rowspan="2" class="text-center" style="width: 120px">UNDERTIME</th>
					            <th valign="center" rowspan="2" class="text-center" style="width: 120px">ABSENT</th>
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

	                            <th class="text-center" style="width: 100px">HDMF EE</th>
	                            <th class="text-center" style="width: 100px">HDMF ER</th>

	                            <th class="text-center" style="width: 100px">PHIC EE</th>
	                            <th class="text-center" style="width: 100px">PHIC ER</th>
                        	</tr>
					    </thead>
					    <tbody>
					    	 @foreach($_employee as $lbl => $period)
						    	<tr>
						    		@if(isset($v2))
						        	<td class="text-center">{{$period->payroll_employee_display_name}}</td>
						        	@endif
						    	 	<td class="text-center">{{$period->payroll_period_start}} - {{$period->payroll_period_end}}</td>
						    	 	<td class="text-center">{{number_format($period->net_basic_pay,2)}}</td>
						    	 	<td class="text-center" >{{ number_format($period->overtime,2) }}</td>
						    	 	<td class="text-center" >{{ number_format($period->nightdiff,2) }}</td>
							    	<td class="text-center" >{{ number_format($period->regular_holiday,2) }}</td>
							    	<td class="text-center" >{{ number_format($period->special_holiday,2) }}</td>
							    	<td class="text-center" >{{ number_format($period->restday,2 )}}</td>
							    	<td class="text-center" >{{ number_format($period->leave_pay,2) }}</td>
							    	<td class="text-center" >{{ number_format($period->cola,2) }}</td>
							    	<td class="text-center" >{{ number_format($period->late,2) }}</td>
							    	<td class="text-center" >{{ number_format($period->undertime,2) }}</td>
							    	<td class="text-center" >{{ number_format($period->absent,2) }}</td>
							    	<td class="text-center" >{{ number_format($period->allowance,2) }}</td>
							    	<td class="text-center" >{{ number_format($period->adjustment_allowance,2) }}</td>
							    	<td class="text-center" >{{ number_format($period->sss_loan,2) }}</td>
							    	<td class="text-center" >{{ number_format($period->hdmf_loan,2) }}</td>
							    	<td class="text-center" >{{ number_format($period->cash_bond,2) }}</td>
							    	<td class="text-center" >{{ number_format($period->cash_advance,2) }}</td>
							    	<td class="text-center" >{{ number_format($period->other_loans,2) }}</td>
							    	<td class="text-center" >{{ number_format($period->adjustment_deduction,2) }}</td>
							    	<td class="text-center" >{{ number_format($period->sss_ee,2) }}</td>
							    	<td class="text-center" >{{ number_format($period->sss_er,2) }}</td>
							    	<td class="text-center" >{{ number_format($period->sss_ec,2) }}</td>
							    	<td class="text-center" >{{ number_format($period->pagibig_ee,2) }}</td>
							    	<td class="text-center" >{{ number_format($period->pagibig_er,2) }}</td>
							    	<td class="text-center" >{{ number_format($period->philhealth_ee,2) }}</td>
							    	<td class="text-center" >{{ number_format($period->philhealth_er,2) }}</td>
							    	<td class="text-center" >{{ number_format($period->tax_ee,2) }}</td>
							    	<td class="text-center" >{{ number_format($period->total_deduction_employee,2) }}</td>
							    	<td class="text-center" >{{ number_format($period->gross_pay,2) }}</td>
							    	<td class="text-center" >{{ number_format($period->net_pay,2) }}</td>
						    	</tr>
					    	 @endforeach
					    	  	<tr >
							   		<td class="text-center" ><b>Total</b></td>
							   		@if(isset($v2))
						        	<td class="text-center" ></td>
						        	@endif
							    	<td class="text-center" ><b>{{ number_format($total_basic,2) }}</b></td>
							    	<td class="text-center" ><b>{{ number_format($overtime_total,2) }}</b></td>
							    	<td class="text-center" ><b>{{ number_format($nightdiff_total,2) }}</b></td>
							    	<td class="text-center" ><b>{{ number_format($regular_holiday_total,2) }}</b></td>
							    	<td class="text-center" ><b>{{ number_format($special_holiday_total,2) }}</b></td>
							    	<td class="text-center" ><b>{{ number_format($restday_total,2) }}</b></td>
							    	<td class="text-center" ><b>{{ number_format($leave_pay_total,2) }}</b></td>
							    	<td class="text-center" ><b>{{ number_format($cola_total,2) }}</b></td>
							    	<td class="text-center" ><b>{{ number_format($late_total,2) }}</b></td>
							    	<td class="text-center" ><b>{{ number_format($undertime_total,2) }}</b></td>
							    	<td class="text-center" ><b>{{ number_format($absent_total,2) }}</b></td>
							    	<td class="text-center" ><b>{{ number_format($allowance_total,2) }}</b></td>
							    	<td class="text-center" ><b>{{ number_format($adjustment_allowance_total,2) }}</b></td>
							    	<td class="text-center" ><b>{{ number_format($sss_loan_total,2) }}</b></td>
							    	<td class="text-center" ><b>{{ number_format($hdmf_loan_total,2) }}</b></td>
							    	<td class="text-center" ><b>{{ number_format($cash_bond_total,2) }}</b></td>
							    	<td class="text-center" ><b>{{ number_format($cash_advance_total,2) }}</b></td>
							    	<td class="text-center" ><b>{{ number_format($other_loans_total,2) }}</b></td>
							    	<td class="text-center" ><b>{{ number_format($adjustment_deduction_total,2) }}</b></td>
							    	<td class="text-center" ><b>{{ number_format($sss_ee_total,2) }}</b></td>
							    	<td class="text-center" ><b>{{ number_format($sss_er_total,2) }}</b></td>
							    	<td class="text-center" ><b>{{ number_format($sss_ec_total,2) }}</b></td>
							    	<td class="text-center" ><b>{{ number_format($hdmf_ee_total,2) }}</b></td>
							    	<td class="text-center" ><b>{{ number_format($hdmf_er_total,2) }}</b></td>
							    	<td class="text-center" ><b>{{ number_format($philhealth_ee_total,2) }}</b></td>
							    	<td class="text-center" ><b>{{ number_format($philhealth_er_total,2) }}</b></td>
							    	<td class="text-center" ><b>{{ number_format($witholding_tax_total,2) }}</b></td>
							    	<td class="text-center" ><b>{{ number_format($deduction_total,2) }}</b></td>
							    	<td class="text-center" ><b>{{ number_format($total_gross,2) }}</b></td>
							    	<td class="text-center" ><b>{{ number_format($total_net,2) }}</b></td>
							   </tr>
					    </tbody>
					</table>
                </div>
    </div>
<style type="text/css">

table, td {
    border: 6px solid #333333;
    width:30px;
    height:20px;
    text-align:center;
    background-color:#fff;
    vertical-align:middle;
}

table {
    border-collapse: collapse;
}
body{
  background-color:#ededed;
}
.padding
{
    padding:300px 50px 100px 50px;
}

#title
{
    border: 2px solid #E5E5E5;
}

</style>