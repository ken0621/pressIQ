<div style="overflow-x: scroll;" class="col-md-12">
      <table class="table table-bordered table-striped table-condensed" style="table-layout: fixed;">
            <thead style="text-transform: uppercase">
                  <tr>  
                        <th valign="center" rowspan="2" class="text-center head" id="name" style="width: 200px">NAME</th>
                        <th valign="center" rowspan="2" class="text-center head" id="gross_basic_pay" style="width: 120px">GROSS BASIC PAY</th>
                        <th valign="center" rowspan="2" class="text-center head" id="absent" style="width: 120px">ABSENT</th>
                        <th valign="center" rowspan="2" class="text-center head" id="late" style="width: 120px">LATE</th>
                        <th valign="center" rowspan="2" class="text-center head" id="undertime" style="width: 120px">UNDERTIME</th>

                        <th valign="center" rowspan="2" class="text-center head" id="basic_pay" style="width: 120px">BASIC PAY</th>

                        <th valign="center" rowspan="2" class="text-center head" id="cola" style="width: 120px">COLA</th>
                        <th valign="center" rowspan="2" class="text-center head" id="overtime_pay" style="width: 120px">OVER TIME PAY</th>
                        <th valign="center" rowspan="2" class="text-center head" id="night_differential_pay" style="width: 120px">NIGHT DIFFERENTIAL PAY</th>
                        <th valign="center" rowspan="2" class="text-center head" id="regular_holiday_pay" style="width: 120px">REGULAR HOLIDAY PAY</th>
                        <th valign="center" rowspan="2" class="text-center head" id="special_holiday_pay" style="width: 120px">SPECIAL HOLIDAY PAY</th>
                        <th valign="center" rowspan="2" class="text-center head" id="restday_pay" style="width: 120px">RESTDAY PAY</th>
                        <th valign="center" rowspan="2" class="text-center head" id="leave_pay" style="width: 120px">LEAVE PAY</th>
                        <!-- <th valign="center" rowspan="2" class="text-center" style="width: 120px">ALLOWANCES</th> -->
                        
                        <th colspan="8" class="text-center" style="width: 850px">ALLOWANCES</th>

                        <th valign="center" rowspan="2" class="text-center head" id="gross_pay" style="width: 100px">GROSS PAY</th>

                        <th colspan="4" class="text-center" style="width: 500px">DEDUCTIONS</th>
                        
                        <th colspan="2" class="text-center" style="width: 300px">SSS</th>
                        <th colspan="2" class="text-center" style="width: 200px">HDMF</th>
                        <th colspan="1" class="text-center" style="width: 100px">PHILHEALTH</th>

                        <th valign="center" rowspan="2" class="text-center head" id="with_holding_tax" style="width: 100px">Witholding Tax</th>
                        <th valign="center" rowspan="2" class="text-center head" id="total_deduction" style="width: 100px">TOTAL DEDUCTION</th>
                        <th valign="center" rowspan="2" class="text-center head" id="take_home_pay" style="width: 100px">TAKE HOME PAY</th>

                        <th colspan="4" class="text-center" style="width: 500px">GOVERNMENT EMPLOYER SHARE</th>
                  </tr>
                  
                  <tr>
                        <th class="text-center head" id="allowance" style="width: 100px">ALLOWANCE</th>
                        <th class="text-center head" id="bonus" style="width: 100px">BONUS</th>
                        <th class="text-center head" id="commision" style="width: 100px">COMMISSION</th>
                        <th class="text-center head" id="incentives" style="width: 100px">INCENTIVES</th>
                        <th class="text-center head" id="additions" style="width: 100px">ADDITIONS</th>
                        <th class="text-center head" id="month_13_and_other" style="width: 150px">13TH MONTH AND OTHER</th>
                        <th class="text-center head" id="de_minimis_benefit" style="width: 100px">DE MINIMIS BENEFIT</th>
                        <th class="text-center head" id="others" style="width: 100px">OTHERS</th>
                       <!--  <th class="text-center" style="width: 100px">Allowances</th> -->
                      <!--   <th class="text-center" style="width: 100px">Adjustment Allowances</th> -->
                        
                        <th class="text-center head" id="deductions" style="width: 100px">DEDUCTIONS</th>
                        <th class="text-center head" id="cash_bond" style="width: 100px">CASH BOND</th>
                        <th class="text-center head" id="cash_advance" style="width: 100px">CASH ADVANCE</th>
                        <th class="text-center head" id="other_loan" style="width: 100px">OTHER LOAN</th>
                        
                        <th class="text-center head" id="sss_loan" style="width: 100px">SSS LOAN</th>
                        <th class="text-center head" id="sss_ee" style="width: 100px">SSS EE</th>

                        <th class="text-center head" id="hdmf_loan" style="width: 100px">HDMF LOAN</th>
                        <th class="text-center head" id="hdmf_ee" style="width: 100px">HDMF EE</th>
                        

                        <th class="text-center head" id="phic_ee" style="width: 100px">PHIC EE</th>

                        <th class="text-center head" id="sss_er" style="width: 100px">SSS ER</th>
                        <th class="text-center head" id="sss_ec" style="width: 100px">SSS EC</th>
                        <th class="text-center head" id="hdmf_er" style="width: 100px">HDMF ER</th>
                        <th class="text-center head" id="phic_er" style="width: 100px">PHIC ER</th>
                  </tr>
            </thead>
            <tbody>
                  @foreach($_employee as $lbl => $employee)
                  <tr>
                        <td class="text-center" >{{ $employee->payroll_employee_first_name }} {{ $employee->payroll_employee_last_name }}</td>
                        <td class="text-center" >{{ number_format($employee->gross_basic_pay,2) }}</td>
                        <td class="text-center" >({{ number_format($employee->absent,2) }}) <br> ({{$employee->time_absent}} times)</td>
                        <td class="text-center" >({{ number_format($employee->late,2) }}) <br> ({{$employee->time_late}} hours)</td>
                        <td class="text-center" >({{ number_format($employee->undertime,2) }}) <br> ({{$employee->time_undertime}} hours)</td>
                        
                        <td class="text-center" >{{ number_format($employee->net_basic_pay,2) }} <br> ({{$employee->time_spent}} hours)</td>
                       
                        <td class="text-center" >{{ number_format($employee->cola,2) }}</td>
                        <td class="text-center" >{{ number_format($employee->overtime,2) }} <br> ({{$employee->time_overtime}} hours)</td>
                        <td class="text-center" >{{ number_format($employee->nightdiff,2) }} <br> ({{$employee->time_night_differential}} hours)</td>
                        <td class="text-center" >{{ number_format($employee->special_holiday,2) }} <br> ({{$employee->time_special_holiday}} times)</td>
                        <td class="text-center" >{{ number_format($employee->regular_holiday,2) }} <br> ({{$employee->time_regular_holiday}} times)</td>
                        <td class="text-center" >{{ number_format($employee->restday,2 )}}</td>
                        <td class="text-center" >{{ number_format($employee->leave_pay,2) }} <br> ({{$employee->time_leave_hours}} hours)</td>
                              
                        <td class="text-center" >{{ number_format((number_format($employee->allowance,2) + number_format($employee->adjustment_allowance, 2)), 2) }}</td>
                        <td class="text-center" >{{ number_format($employee->adjustment_bonus,2) }}</td>
                        <td class="text-center" >{{ number_format($employee->adjustment_commission,2) }}</td>
                        <td class="text-center" >{{ number_format($employee->adjustment_incentives,2) }}</td>
                        <td class="text-center" >{{ number_format($employee->adjustment_additions,2) }}</td>
                        <td class="text-center" >{{ number_format($employee->adjustment_13th_month_and_other,2) }}</td>
                        <td class="text-center" >{{ number_format($employee->adjustment_de_minimis_benefit,2) }}</td>
                        <td class="text-center" >{{ number_format($employee->adjustment_others,2) }}</td>

                        <td class="text-center" >{{ number_format($employee->gross_pay,2) }}</td>

                        <!--<td class="text-center" >{{ number_format($employee->adjustment_allowance,2) }}</td>-->
                        
                        <td class="text-center" >({{ number_format($employee->adjustment_deductions,2) }})</td>
                        <td class="text-center" >({{ number_format((number_format($employee->cash_bond,2) + number_format($employee->adjustment_cash_bond,2)), 2) }})</td>
                        <td class="text-center" >({{ number_format((number_format($employee->cash_advance,2) + number_format($employee->adjustment_cash_advance,2)),2) }})</td>
                        <td class="text-center" >({{ number_format($employee->other_loans,2) }})</td>
                        <!-- <td class="text-center" >{{ number_format($employee->adjustment_deduction,2) }}</td> -->

                        <td class="text-center" >({{ number_format($employee->sss_loan,2) }})</td>
                        <td class="text-center" >({{ number_format($employee->sss_ee,2) }})</td>

                        <td class="text-center" >({{ number_format($employee->hdmf_loan,2) }})</td>
                        <td class="text-center" >({{ number_format($employee->pagibig_ee,2) }})</td>

                        <td class="text-center" >({{ number_format($employee->philhealth_ee,2) }})</td>

                        <td class="text-center" >({{ number_format($employee->tax_ee,2) }})</td>
                        <td class="text-center" >({{ number_format($employee->total_deduction_employee,2) }})</td>
                        
                        <td class="text-center" >{{ number_format($employee->net_pay,2) }}</td>

                        <td class="text-center" >{{ number_format($employee->sss_er,2) }}</td>
                        <td class="text-center" >{{ number_format($employee->sss_ec,2) }}</td>
                        <td class="text-center" >{{ number_format($employee->pagibig_er,2) }}</td>
                        <td class="text-center" >{{ number_format($employee->philhealth_er,2) }}</td>
                  </tr>
                  @endforeach
                  <tr>
                        <td class="text-center" ><b>Total</b></td>
                        <td class="text-center" ><b>{{ number_format($total_gross_basic, 2) }}</b></td>
                        <td class="text-center" ><b>({{ number_format($absent_total, 2) }})</b></td>
                        <td class="text-center" ><b>({{ number_format($late_total, 2) }})</b></td>
                        <td class="text-center" ><b>({{ number_format($undertime_total, 2) }})</b></td>
                        <td class="text-center" ><b>{{ number_format($total_basic, 2) }}</b></td>
                        <td class="text-center" ><b>{{ number_format($cola_total, 2) }}</b></td>
                        <td class="text-center" ><b>{{ number_format($overtime_total, 2) }}</b></td>
                        <td class="text-center" ><b>{{ number_format($nightdiff_total, 2) }}</b></td>
                        <td class="text-center" ><b>{{ number_format($regular_holiday_total, 2) }}</b></td>
                        <td class="text-center" ><b>{{ number_format($special_holiday_total, 2) }}</b></td>
                        <td class="text-center" ><b>{{ number_format($restday_total, 2) }}</b></td>
                        <td class="text-center" ><b>{{ number_format($leave_pay_total, 2) }}</b></td>

                        <td class="text-center" ><b>{{ number_format(number_format($total_adjustment_allowance, 2) + number_format($allowance_total, 2), 2)}}</b></td>
                        <td class="text-center" ><b>{{ number_format($total_adjustment_bonus, 2) }}</b></td>
                        <td class="text-center" ><b>{{ number_format($total_adjustment_commission, 2) }}</b></td>
                        <td class="text-center" ><b>{{ number_format($total_adjustment_incentives, 2) }}</b></td>
                        <td class="text-center" ><b>{{ number_format($total_adjustment_additions, 2) }}</b></td>
                        <td class="text-center" ><b>{{ number_format($total_adjustment_13th_month_and_other, 2) }}</b></td>
                        <td class="text-center" ><b>{{ number_format($total_adjustment_de_minimis_benefit, 2) }}</b></td>
                        <td class="text-center" ><b>{{ number_format($total_adjustment_others, 2) }}</b></td>

                        <td class="text-center" ><b>{{ number_format($total_gross, 2) }}</b></td>
                        
                        <td class="text-center" ><b>({{ number_format($total_adjustment_deductions, 2) }})</b></td>
                        <td class="text-center" ><b>({{ number_format((number_format($cash_bond_total, 2)    + number_format($total_adjustment_cash_bond, 2)), 2)}})</b></td>
                        <td class="text-center" ><b>({{ number_format((number_format($cash_advance_total, 2) + number_format($total_adjustment_additions, 2)), 2)}})</b></td>
                        <td class="text-center" ><b>({{ number_format($other_loans_total, 2) }})</b></td>

                        <td class="text-center" ><b>({{ number_format($sss_loan_total, 2) }})</b></td>
                        <td class="text-center" ><b>({{ number_format($sss_ee_total, 2) }})</b></td>

                        <td class="text-center" ><b>({{ number_format($hdmf_loan_total, 2) }})</b></td>
                        <td class="text-center" ><b>({{ number_format($hdmf_ee_total, 2) }})</b></td>
                        
                        <td class="text-center" ><b>({{ number_format($philhealth_ee_total, 2) }})</b></td>
                        
                        <td class="text-center" ><b>({{ number_format($witholding_tax_total, 2) }})</b></td>
                        <td class="text-center" ><b>({{ number_format($deduction_total, 2) }})</b></td>

                        <td class="text-center" ><b>{{ number_format($total_net, 2) }}</b></td>

                        <td class="text-center" ><b>{{ number_format($sss_er_total, 2) }}</b></td>
                        <td class="text-center" ><b>{{ number_format($sss_ec_total, 2) }}</b></td>
                        <td class="text-center" ><b>{{ number_format($hdmf_er_total, 2) }}</b></td>
                        <td class="text-center" ><b>{{ number_format($philhealth_er_total, 2) }}</b></td>

                        @foreach($columns as $column)
                                    <input type="hidden" class="name" name="name" value="{{ $column->name }}">
                                     <input type="hidden" class="gross_basic_pay" name="gross_basic_pay" value="{{ $column->gross_basic_pay }}">
                                     <input type="hidden" class="absent" name="absent" value="{{ $column->absent }}"> 
                                    <input type="hidden" class="late" name="late" value="{{ $column->late }}">    
                                    <input type="hidden" class="undertime" name="undertime" value="{{ $column->undertime }}">
                                    <input type="hidden" class="basic_pay" name="basic_pay" value="{{ $column->basic_pay }}">   
                                    <input type="hidden" class="cola" name="cola" value="{{ $column->cola }}">    
                                    <input type="hidden" class="overtime_pay" name="overtime_pay" value="{{ $column->overtime_pay }}">      
                                    <input type="hidden" class="night_differential_pay" name="night_differential_pay" value="{{ $column->night_differential_pay }}">
                                     <input type="hidden" class="regular_holiday_pay" name="regular_holiday_pay" value="{{ $column->regular_holiday_pay }}">   
                                    <input type="hidden" class="special_holiday_pay" name="special_holiday_pay" value="{{ $column->special_holiday_pay }}">  
                                    <input type="hidden" class="restday_pay" name="restday_pay" value="{{ $column->restday_pay }}"> 
                                    <input type="hidden" class="leave_pay" name="leave_pay" value="{{ $column->leave_pay }}">  
                                    <input type="hidden" class="allowance" name="allowance" value="{{ $column->allowance }}">  
                                    <input type="hidden" class="bonus" name="bonus" value="{{ $column->bonus }}">
                                    <input type="hidden" class="commision" name="commision" value="{{ $column->commision }}">   
                                    <input type="hidden" class="incentives" name="incentives" value="{{ $column->incentives }}"> 
                                    <input type="hidden" class="additions" name="additions" value="{{ $column->additions }}">       
                                    <input type="hidden" class="month_13_and_other" name="month_13_and_other" value="{{ $column->month_13_and_other }}">
                                    <input type="hidden" class="de_minimis_benefit" name="de_minimis_benefit" value="{{ $column->de_minimis_benefit }}">    
                                    <input type="hidden" class="others" name="others" value="{{ $column->others }}">         
                                    <input type="hidden" class="gross_pay" name="gross_pay" value="{{ $column->gross_pay }}">   
                                    <input type="hidden" class="deductions" name="deductions" value="{{ $column->deductions }}">       
                                    <input type="hidden" class="cash_bond" name="cash_bond" value="{{ $column->cash_bond}}">   
                                    <input type="hidden" class="cash_advance" name="cash_advance" value="{{ $column->cash_advance}}">   
                                    <input type="hidden" class="other_loan" name="other_loan" value="{{ $column->other_loan}}">  
                                    <input type="hidden" class="sss_loan" name="sss_loan" value="{{ $column->sss_loan}}">  
                                    <input type="hidden" class="sss_ee" name="sss_ee" value="{{ $column->sss_ee}}"> 
                                    <input type="hidden" class="hdmf_loan" name="hdmf_loan" value="{{ $column->hdmf_loan}}"> 
                                    <input type="hidden" class="hdmf_ee" name="hdmf_ee" value="{{ $column->hdmf_ee}}"> 
                                    <input type="hidden" class="phic_ee" name="phic_ee" value="{{ $column->phic_ee}}"> 
                                    <input type="hidden" class="with_holding_tax" name="with_holding_tax" value="{{ $column->with_holding_tax}}"> 
                                    <input type="hidden" class="total_deduction" name="total_deduction" value="{{ $column->total_deduction}}"> 
                                    <input type="hidden" class="take_home_pay" name="take_home_pay" value="{{ $column->take_home_pay}}">
                                    <input type="hidden" class="sss_er" name="sss_er" value="{{ $column->sss_er}}">
                                    <input type="hidden" class="sss_ec" name="sss_ec" value="{{ $column->sss_ec}}">
                                    <input type="hidden" class="hdmf_er" name="hdmf_er" value="{{ $column->hdmf_er}}">
                                    <input type="hidden" class="phic_er" name="phic_er" value="{{ $column->phic_er}}">
                        @endforeach
                  </tr>
            </tbody>
      </table>
</div>
<script>
$( document ).ready(function() {
        $(".head").each(function() {
            var column = $(this).attr('id');
            var columnvalue = $('.' + column).val();

            if(columnvalue == 0)
            {
                  $("#" + column).css("display", "none");
            }

        });

});
</script>