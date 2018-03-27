@if(isset($v2))	
    <div class="modal-body clearfix">
                <div class="table-responsive">
                     <table>
	
					        <tr>
					        	<td valign="center" rowspan="2" class="text-center" style="width: 200px">Name</td>
					            <td valign="center" rowspan="2" class="text-center" style="width: 120px">BASIC PAY</td>
					            <td valign="center" rowspan="2" class="text-center" style="width: 120px">Over Time PAY</td>
					            <td valign="center" rowspan="2" class="text-center" style="width: 120px">Night Differential Pay</td>
					            <td valign="center" rowspan="2" class="text-center" style="width: 120px">Regular Holiday Pay</td>
					            <td valign="center" rowspan="2" class="text-center" style="width: 120px">Special Holiday Pay</td>
					            <td valign="center" rowspan="2" class="text-center" style="width: 120px">Restday Pay</td>
					            <td valign="center" rowspan="2" class="text-center" style="width: 120px">Leave Pay</td>
					            <td valign="center" rowspan="2" class="text-center" style="width: 120px">COLA</td>
					            <td valign="center" rowspan="2" class="text-center" style="width: 120px">LATE</td>
					            <td valign="center" rowspan="2" class="text-center" style="width: 120px">UNDERTIME</td>
					            <td valign="center" rowspan="2" class="text-center" style="width: 120px">ABSENT</td>
					            <td colspan="7" class="text-center" style="width: 200px">ALLOWANCES</td>
					            <td colspan="6" class="text-center" style="width: 600px">DEDUCTIONS</td>
					            <td colspan="3" class="text-center" style="width: 300px">SSS Contribution</td>
					            <td colspan="2" class="text-center" style="width: 200px">PAG-IBIG Contribution</td>
					            <td colspan="2" class="text-center" style="width: 200px">PHILHEALTH Contribution</td>
					            <td valign="center" rowspan="2" class="text-center" style="width: 100px">Witholding Tax</td>
					            <td valign="center" rowspan="2" class="text-center" style="width: 100px">TOTAL DEDUCTION</td>
					            <td valign="center" rowspan="2" class="text-center" style="width: 100px">GROSS PAY</td>
								<td valign="center" rowspan="2" class="text-center" style="width: 100px">NET HOME PAY</td>					           
					        </tr>
					        
					        <tr>
					        	<td class="text-center" style="width: 100px"></td>
					        	<td class="text-center" style="width: 100px"></td>
					        	<td class="text-center" style="width: 100px"></td>
					        	<td class="text-center" style="width: 100px"></td>
					        	<td class="text-center" style="width: 100px"></td>
					        	<td class="text-center" style="width: 100px"></td>
					        	<td class="text-center" style="width: 100px"></td>
					        	<td class="text-center" style="width: 100px"></td>
					        	<td class="text-center" style="width: 100px"></td>
					        	<td class="text-center" style="width: 100px"></td>
					        	<td class="text-center" style="width: 100px"></td>
					        	<td class="text-center" style="width: 100px"></td>

	                            <td class="text-center" style="width: 100px">Allowances</td>
	                            <th class="text-center" style="width: 100px">Bonus</th>
	                            <th class="text-center" style="width: 100px">Incentives</th>
	                            <th class="text-center" style="width: 100px">Additions</th>
	                            <th class="text-center" style="width: 100px">13 Month and Other</th>
	                            <th class="text-center" style="width: 100px">De Minimis Benefit</th>
	                            <th class="text-center" style="width: 100px">Others</th>

	                            <td class="text-center" style="width: 100px">SSS LOAN</td>
	                            <td class="text-center" style="width: 100px">HDMF LOAN</td>
	                            <td class="text-center" style="width: 100px">CASH BOND</td>
	                            <td class="text-center" style="width: 100px">CASH ADVANCE</td>
	                            <td class="text-center" style="width: 100px">OTHER DEDUCTIONS</td>
	                            <td class="text-center" style="width: 100px">ADJUSTMENT DEDUCTION</td>

	                            <td class="text-center" style="width: 100px">SSS EE</td>
	                            <td class="text-center" style="width: 100px">SSS ER</td>
	                            <td class="text-center" style="width: 100px">SSS EC</td>

	                            <td class="text-center" style="width: 100px">HDMF EE</td>
	                            <td class="text-center" style="width: 100px">HDMF ER</td>

	                            <td class="text-center" style="width: 100px">PHIC EE</td>
	                            <td class="text-center" style="width: 100px">PHIC ER</td>
                        	</tr>

					    	 @foreach($month_total as $period)
						    	<tr>
						        	<td class="text-center">{{$period->payroll_employee_display_name}}</td>
						    	 	<td class="text-center">{{number_format($period->basic_pay_total,2)}}</td>
						    	 	<td class="text-center" >{{ number_format($period->overtime_total,2) }}</td>
						    	 	<td class="text-center" >{{ number_format($period->night_dif_total,2) }}</td>
							    	<td class="text-center" >{{ number_format($period->regular_total_pay,2) }}</td>
							    	<td class="text-center" >{{ number_format($period->special_total_pay,2) }}</td>
							    	<td class="text-center" >{{ number_format($period->rest_day_total,2 )}}</td>
							    	<td class="text-center" >{{ number_format($period->leave_pay_total,2) }}</td>
							    	<td class="text-center" >{{ number_format($period->cola_total,2) }}</td>
							    	<td class="text-center" >{{ number_format($period->late_total,2) }}</td>
							    	<td class="text-center" >{{ number_format($period->undertime_total,2) }}</td>
							    	<td class="text-center" >{{ number_format($period->absent_total,2) }}</td>
							    	<td class="text-center" >{{ number_format($period->allowance_total,2) }}</td>
							    	<td class="text-center" >{{ number_format($period->bonus_total,2) }}</td>
							    	<td class="text-center" >{{ number_format($period->commission_total,2) }}</td>
							    	<td class="text-center" >{{ number_format($period->incentives_total,2) }}</td>
							    	<td class="text-center" >{{ number_format($period->additions_total,2) }}</td>
							    	<td class="text-center" >{{ number_format($period->deminimis_total,2) }}</td>
							    	<td class="text-center" >{{ number_format($period->month_total_13,2) }}</td>

							    	<td class="text-center" >{{ number_format($period->sss_loan_total,2) }}</td>
							    	<td class="text-center" >{{ number_format($period->hdmf_loan_total,2) }}</td>
							    	<td class="text-center" >{{ number_format($period->cash_bond_total,2) }}</td>
							    	<td class="text-center" >{{ number_format($period->cash_adv_total,2) }}</td>
							    	<td class="text-center" >{{ number_format($period->other_loan_total,2) }}</td>
							    	<td class="text-center" >{{ number_format($period->adj_deduct_total,2) }}</td>
							    	<td class="text-center" >{{ number_format($period->sss_ee_total,2) }}</td>
							    	<td class="text-center" >{{ number_format($period->sss_er_total,2) }}</td>
							    	<td class="text-center" >{{ number_format($period->sss_ec_total,2) }}</td>
							    	<td class="text-center" >{{ number_format($period->hdmf_ee_total,2) }}</td>
							    	<td class="text-center" >{{ number_format($period->hdmf_er_total,2) }}</td>
							    	<td class="text-center" >{{ number_format($period->phic_ee_total,2) }}</td>
							    	<td class="text-center" >{{ number_format($period->phic_er_total,2) }}</td>
							    	<td class="text-center" >{{ number_format($period->tax_total,2) }}</td>
							    	<td class="text-center" >{{ number_format($period->total_deduction_total,2) }}</td>
							    	<td class="text-center" >{{ number_format($period->gross_total,2) }}</td>
							    	<td class="text-center" >{{ number_format($period->net_total,2) }}</td>
						    	</tr>
					    	 @endforeach
					    	  	<tr >
							   		<td class="text-center" ><b>Total</b></td>
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
							    	<td class="text-center" ><b>{{ number_format($total_adjustment_allowance + $allowance_total, 2)}}</b></td>
							    	<td class="text-center" ><b>{{ number_format($total_adjustment_bonus,2) }}</b></td>
							    	<td class="text-center" ><b>{{ number_format($total_adjustment_commission,2) }}</b></td>
							    	<td class="text-center" ><b>{{ number_format($total_adjustment_incentives,2) }}</b></td>
							    	<td class="text-center" ><b>{{ number_format($total_adjustment_additions,2) }}</b></td>
							    	<td class="text-center" ><b>{{ number_format($total_adjustment_de_minimis_benefit + $allowance_de_minimis_total, 2)}}</b></td>
							    	<td class="text-center" ><b>{{ number_format($total_adjustment_13th_month_and_other,2) }}</b></td>

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

					</table>
                </div>
    </div>
@else
    <h4 class="modal-title" style="font-weight: bold;"><b>{{ $employee->payroll_employee_first_name }} {{ $employee->payroll_employee_middle_name }} {{ $employee->payroll_employee_last_name }}<br></h4>
    <div class="modal-body clearfix">
                <div class="table-responsive">
                     <table>
	
					        <tr>
					            <td valign="center" rowspan="2" class="text-center" style="width: 200px">PERIOD DATE</td>
					          <td valign="center" rowspan="2" class="text-center" style="width: 120px">BASIC PAY</td>
					            <td valign="center" rowspan="2" class="text-center" style="width: 120px">Over Time PAY</td>
					            <td valign="center" rowspan="2" class="text-center" style="width: 120px">Night Differential Pay</td>
					            <td valign="center" rowspan="2" class="text-center" style="width: 120px">Regular Holiday Pay</td>
					            <td valign="center" rowspan="2" class="text-center" style="width: 120px">Special Holiday Pay</td>
					            <td valign="center" rowspan="2" class="text-center" style="width: 120px">Restday Pay</td>
					            <td valign="center" rowspan="2" class="text-center" style="width: 120px">Leave Pay</td>
					            <td valign="center" rowspan="2" class="text-center" style="width: 120px">COLA</td>
					            <td valign="center" rowspan="2" class="text-center" style="width: 120px">LATE</td>
					            <td valign="center" rowspan="2" class="text-center" style="width: 120px">UNDERTIME</td>
					            <td valign="center" rowspan="2" class="text-center" style="width: 120px">ABSENT</td>
					            <td colspan="7" class="text-center" style="width: 200px">ALLOWANCES</td>
					            <td colspan="6" class="text-center" style="width: 600px">DEDUCTIONS</td>
					            <td colspan="3" class="text-center" style="width: 300px">SSS Contribution</td>
					            <td colspan="2" class="text-center" style="width: 200px">PAG-IBIG Contribution</td>
					            <td colspan="2" class="text-center" style="width: 200px">PHILHEALTH Contribution</td>
					            <td valign="center" rowspan="2" class="text-center" style="width: 100px">Witholding Tax</td>
					            <td valign="center" rowspan="2" class="text-center" style="width: 100px">TOTAL DEDUCTION</td>
					            <td valign="center" rowspan="2" class="text-center" style="width: 100px">GROSS PAY</td>
								<td valign="center" rowspan="2" class="text-center" style="width: 100px">NET HOME PAY</td>					           
					        </tr>
					        
					        <tr>
					        	<td class="text-center" style="width: 100px"></td>
					        	<td class="text-center" style="width: 100px"></td>
					        	<td class="text-center" style="width: 100px"></td>
					        	<td class="text-center" style="width: 100px"></td>
					        	<td class="text-center" style="width: 100px"></td>
					        	<td class="text-center" style="width: 100px"></td>
					        	<td class="text-center" style="width: 100px"></td>
					        	<td class="text-center" style="width: 100px"></td>
					        	<td class="text-center" style="width: 100px"></td>
					        	<td class="text-center" style="width: 100px"></td>
					        	<td class="text-center" style="width: 100px"></td>
					        	<td class="text-center" style="width: 100px"></td>

	                            <td class="text-center" style="width: 100px">Allowances</td>
	                            <th class="text-center" style="width: 100px">Bonus</th>
	                            <th class="text-center" style="width: 100px">Incentives</th>
	                            <th class="text-center" style="width: 100px">Additions</th>
	                            <th class="text-center" style="width: 100px">13 Month and Other</th>
	                            <th class="text-center" style="width: 100px">De Minimis Benefit</th>
	                            <th class="text-center" style="width: 100px">Others</th>

	                            <td class="text-center" style="width: 100px">SSS LOAN</td>
	                            <td class="text-center" style="width: 100px">HDMF LOAN</td>
	                            <td class="text-center" style="width: 100px">CASH BOND</td>
	                            <td class="text-center" style="width: 100px">CASH ADVANCE</td>
	                            <td class="text-center" style="width: 100px">OTHER DEDUCTIONS</td>
	                            <td class="text-center" style="width: 100px">ADJUSTMENT DEDUCTION</td>

	                            <td class="text-center" style="width: 100px">SSS EE</td>
	                            <td class="text-center" style="width: 100px">SSS ER</td>
	                            <td class="text-center" style="width: 100px">SSS EC</td>

	                            <td class="text-center" style="width: 100px">HDMF EE</td>
	                            <td class="text-center" style="width: 100px">HDMF ER</td>

	                            <td class="text-center" style="width: 100px">PHIC EE</td>
	                            <td class="text-center" style="width: 100px">PHIC ER</td>
                        	</tr>

					    	 @foreach($_employee as $lbl => $period)
						    	<tr>
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
							    	<td class="text-center" >{{ number_format($period->allowance + $period->adjustment_allowance, 2) }}</td>
							    	<td class="text-center" >{{ number_format($period->adjustment_bonus,2) }}</td>
							    	<td class="text-center" >{{ number_format($period->adjustment_commission,2) }}</td>
							    	<td class="text-center" >{{ number_format($period->adjustment_incentives,2) }}</td>
							    	<td class="text-center" >{{ number_format($period->adjustment_additions,2) }}</td>
							    	<td class="text-center" >{{ number_format($period->allowance_de_minimis + $period->adjustment_de_minimis_benefit, 2) }}</td>
							    	<td class="text-center" >{{ number_format($period->adjustment_13th_month_and_other,2) }}</td>
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
							    	<td class="text-center" ><b>{{ number_format($total_adjustment_allowance + $allowance_total, 2)}}</b></td>
							    	<td class="text-center" ><b>{{ number_format($total_adjustment_bonus,2) }}</b></td>
							    	<td class="text-center" ><b>{{ number_format($total_adjustment_commission,2) }}</b></td>
							    	<td class="text-center" ><b>{{ number_format($total_adjustment_incentives,2) }}</b></td>
							    	<td class="text-center" ><b>{{ number_format($total_adjustment_additions,2) }}</b></td>
							    	<td class="text-center" ><b>{{ number_format($total_adjustment_de_minimis_benefit + $allowance_de_minimis_total, 2)}}</b></td>
							    	<td class="text-center" ><b>{{ number_format($total_adjustment_13th_month_and_other,2) }}</b></td>

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

					</table>
                </div>
    </div>
@endif
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