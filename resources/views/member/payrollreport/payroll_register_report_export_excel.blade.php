<!DOCTYPE html>
<html>
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1">

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
</head>
<body>
<div class="padding">




<table>
  
  <tr>
      <th id="title">{{$company->payroll_company_name}}</th>
  </tr>
  <tr>
      <th>Payroll Register</th>
  </tr>
  <tr>
      <th>{{$show_period_start}}</th>
      <th>{{$show_period_end}}</th>
  </tr>
  <tr>
      <th>-</th>
  </tr>

  <tr>
    @if($columns[0]->name == 1)
    <td class="head" rowspan="2" id="name">NAME</td>
    @endif
{{--     @if($columns[0]->position == 1)
    <td class="head" rowspan="2" id="position" >POSITION</td>
    @endif --}}
    @if($columns[0]->taxstatus == 1)
    <td class="head" rowspan="2" id="taxstatus">PERSONAL TAX STATUS</td>
    @endif
{{--     @if($columns[0]->dailyrate == 1)
    <td class="head" rowspan="2" id="dailyrate">DAILY RATE</td>
    @endif
    @if($columns[0]->monthlybasic == 1)
    <td class="head" rowspan="2" id="monthlybasic">MONTHLY BASIC</td>
    @endif
    @if($columns[0]->semimonthlybasic == 1)
    <td class="head" rowspan="2" id="semimonthlybasic">SEMI MONTHLY BASIC</td>
    @endif --}}
    @if($columns[0]->gross_basic_pay == 1)
    <td class="head" rowspan="2" id="gross_basic_pay">GROSS BASIC PAY</td>
    @endif
    @if($columns[0]->absent == 1)
    <td class="head" colspan="2" id="absent">ABSENT</td>
    @endif
    @if($columns[0]->late == 1)
    <td class="head" colspan="2" id="late">LATE</td>
    @endif
    @if($columns[0]->undertime == 1)
    <td class="head" colspan="2" id="undertime">UNDERTIME</td>
    @endif
    @if($columns[0]->basic_pay == 1)
    <td class="head" rowspan="2" id="basic_pay">BASIC PAY</td>
    @endif
    @if($columns[0]->rendered_days == 1)
    <td class="head" rowspan="2" id="rendered_days">RENDERED DAYS</td>
    @endif
    @if($columns[0]->cola == 1)
    <td class="head" rowspan="2" id="cola">COLA</td>
    @endif
    @if($columns[0]->overtime_pay == 1)
    <td class="head" colspan="2" id="overtime_pay">OVER TIME PAY</td>
    @endif
    @if($columns[0]->night_differential_pay == 1)
    <td class="head" colspan="2" id="night_differential_pay">NIGHT DIFFERENTIAL PAY</td>
    @endif
    @if($columns[0]->regular_holiday_pay == 1)
    <td class="head" rowspan="2" id="regular_holiday_pay">REGULAR HOLIDAY PAY</td>
    @endif
    @if($columns[0]->special_holiday_pay == 1)
    <td class="head" rowspan="2" id="special_holiday_pay">SPECIAL HOLIDAY PAY</td>
    @endif
    @if($columns[0]->restday_pay == 1)
    <td class="head" rowspan="2" id="restday_pay">RESTDAY PAY</td>
    @endif
    @if($columns[0]->leave_pay == 1)
    <td class="head" colspan="2" id="leave_pay">LEAVE PAY</td>
    @endif
    <td colspan="8" id="allowancescol">ALLOWANCES</td>
    @if($columns[0]->gross_pay == 1)
    <td class="head" id="gross_pay" rowspan="2">GROSS PAY</td>
    @endif
    <td colspan="4" id="deductionscol">DEDUCTION</td>

    <td colspan="2" id="ssscol">SSS</td>
    <td colspan="2" id="hdmfcol">PAG-IBIG</td>
    <td rowspan="1">PHIL-HEALTH</td>

    @if($columns[0]->with_holding_tax == 1)
    <td class="head" rowspan="2"  id="with_holding_tax">WITH HOLDING TAX</td>
    @endif
    @if($columns[0]->total_deduction == 1)
    <td class="head" rowspan="2" id="total_deduction">TOTAL DEDUCTIONS</td>     
    @endif
    @if($columns[0]->take_home_pay == 1)  
    <td class="head" rowspan="2" id="take_home_pay">NETHOME PAY</td>
    @endif
    <td colspan="4" id="government_es">GOVERNMENT EMPLOYER SHARE</td>
   </tr>
  <tr>
    @if($columns[0]->name == 1)
    <td class="head" id="name_one"></td>
    @endif
{{--     @if($columns[0]->position == 1)
    <td class="head" id="position_one"></td>
    @endif --}}
    @if($columns[0]->taxstatus == 1)
    <td class="head" id="taxstatus_one"></td>
    @endif
{{--     @if($columns[0]->dailyrate == 1)
    <td class="head" id="dailyrate_one"></td>
    @endif
    @if($columns[0]->monthlybasic == 1)
    <td class="head" id="monthlybasic_one"></td>
    @endif
    @if($columns[0]->semimonthlybasic == 1)
    <td class="head" id="semimonthlybasic_one"></td>
    @endif --}}
    @if($columns[0]->gross_basic_pay == 1)
    <td class="head" id="gross_basic_pay_one"></td>
    @endif
    @if($columns[0]->absent == 1)
    <td class="head" id="absent_no">No. of Days</td>
    <td class="head" id="absent_amount">Amount</td>
    @endif
    @if($columns[0]->late == 1)
    <td class="head" id="late_no">No. of Hrs.</td>  
    <td class="head" id="late_amount">Amount</td>
    @endif
    @if($columns[0]->undertime == 1)  
    <td class="head" id="undertime_no">No. of Hrs.</td>
    <td class="head" id="undertime_amount">Amount</td>
    @endif
    @if($columns[0]->basic_pay == 1)
    <td class="head" id="basic_pay_one"></td>
    @endif
    @if($columns[0]->rendered_days == 1)
    <td class="head" id="rendered_days_one"></td>
    @endif
    @if($columns[0]->cola == 1)
    <td class="head" id="cola_one"></td>
    @endif
    @if($columns[0]->overtime_pay == 1)
    <td class="head" id="overtime_pay_no">No. of Hrs.</td>
    <td class="head" id="overtime_pay_amount">Amount</td>
    @endif
    @if($columns[0]->night_differential_pay == 1)
    <td class="head" id="night_differential_pay_no">No. of Hrs.</td>
    <td class="head" id="night_differential_pay_amount">Amount</td>
    @endif
    @if($columns[0]->regular_holiday_pay == 1)
    <td class="head" id="regular_holiday_pay_one"></td>
    @endif
    @if($columns[0]->special_holiday_pay == 1)
    <td class="head" id="special_holiday_pay_one"></td>
    @endif
    @if($columns[0]->restday_pay == 1)
    <td class="head" id="restday_pay_one"></td>
    @endif
    @if($columns[0]->leave_pay == 1)
    <td class="head" id="leave_pay_no">No. of Hrs.</td>
    <td class="head" id="leave_pay_amount">Amount</td>
    @endif
    <td class="head" id="allowance">ALLOWANCE</td>
    <td class="head" id="bonus">BONUS</td>
    <td class="head" id="commision">COMMISSION</td>
    <td class="head" id="incentives">INCENTIVES</td>
    <td class="head" id="additions">ADDITIONS</td>
    <td class="head" id="month_13_and_other">13TH MONTH AND OTHER</td>
    <td class="head" id="de_minimis_benefit">DE MINIMIS BENEFIT</td>
    <td class="head" id="others">OTHER</td>
    @if($columns[0]->gross_pay == 1)
    <td class="head" id="gross_pay_one"></td>
    @endif
    <td class="head" id="deductions">DEDUCTION</td>
    <td class="head" id="cash_bond">CASH BOND</td>
    <td class="head" id="cash_advance">CASH ADVANCE</td>
    <td class="head" id="other_loan">OTHER LOAN</td>
    <td class="head" id="sss_loan">SSS LOAN</td>
    <td class="head" id="sss_ee">SSS EE</td>
    <td class="head" id="hdmf_loan">HDMF LOAN</td>
    <td class="head" id="hdmf_ee">HDMF EE</td>
    <td class="head" id="phic_ee">PHIC EE</td>
    @if($columns[0]->with_holding_tax == 1)
    <td class="head" id="with_holding_tax_one"></td>
    @endif
    @if($columns[0]->total_deduction == 1)
    <td class="head" id="total_deduction_one"></td>
    @endif
    @if($columns[0]->take_home_pay == 1)
    <td class="head" id="take_home_pay_one"></td>
    @endif
    <td class="head" id="sss_er">SSS ER</td>
    <td class="head" id="sss_ec">SSS EC</td>
    <td class="head" id="hdmf_er">HDMF ER</td>
    <td class="head" id="phic_er">PHIC ER</td>
  </tr>

  @foreach($_employee as $lbl => $employee)
  <tr>  
    @if($columns[0]->name == 1)
    <td class="text-center name_td_td" id="name_td">{{ $employee->payroll_employee_first_name }} {{ $employee->payroll_employee_last_name }}</td>
    @endif
{{--     @if($columns[0]->position == 1)
    <td class="text-center position_td_td" id="position_td"> {{ $employee->payroll_jobtitle_name }}</td>
    @endif --}}
    @if($columns[0]->taxstatus == 1)
    <td class="text-center taxstatus_td_td" id="taxstatus_td">{{ $employee->payroll_employee_tax_status }}</td>
    @endif
    {{-- @if($columns[0]->dailyrate == 1)
    <td class="text-center dailyrate_td_td" id="dailyrate_td" >{{ $employee->daily_rate }}</td>
    @endif
    @if($columns[0]->monthlybasic == 1)
    <td class="text-center monthlybasic_td_td" id="monthlybasic_td">{{ $employee->payroll_employee_salary_monthly }}</td>
    @endif
    @if($columns[0]->semimonthlybasic == 1)
    <td class="text-center semimonthlybasic_td_td" id="semimonthlybasic_td">{{ ($employee->payroll_employee_salary_monthly / 2) }}</td>
    @endif --}}
    @if($columns[0]->gross_basic_pay == 1)
    <td class="text-center gross_basic_pay_td_td" id="gross_basic_pay_td">{{ number_format($employee->gross_basic_pay,2) }}</td>
    @endif
    @if($columns[0]->absent == 1)
    <td class="text-center absent_td_no" id="absent_td">({{$employee->time_absent}} Days)</td>
    <td class="text-center absent_td_td" id="absent_td">({{ number_format($employee->absent,2) }})</td>
    @endif
    @if($columns[0]->late == 1)
    <td class="text-center late_td_no" id="late_td">({{$employee->time_late}} hours)</td>
    <td class="text-center late_td_td" id="late_td">({{ number_format($employee->late,2) }})</td>
    @endif
    @if($columns[0]->undertime == 1)
    <td class="text-center undertime_td_no" id="undertime_td">{{$employee->time_undertime}}</td>
    <td class="text-center undertime_td_td" id="undertime_td">{{ number_format($employee->undertime,2) }}</td>
    @endif
    @if($columns[0]->basic_pay == 1)
    <td class="text-center basic_pay_td_td" id="basic_pay_td">{{ number_format($employee->net_basic_pay,2) }} <br> ({{$employee->time_spent}} hours)</td>
    @endif
    @if($columns[0]->rendered_days == 1)
    <td class="text-center rendered_days_td_td" id="rendered_days_td">{{ number_format($employee->rendered_days,2) }} <br> ({{$employee->time_spent}} hours)</td>
    @endif
    @if($columns[0]->cola == 1)
    <td class="text-center cola_td_td" id="cola_td">{{ number_format($employee->cola,2) }}</td>
    @endif
    @if($columns[0]->overtime_pay == 1)
    <td class="text-center overtime_pay_td_no" id="overtime_pay_td">{{$employee->time_overtime}}</td>
    <td class="text-center overtime_pay_td_td" id="overtime_pay_td">{{ number_format($employee->overtime,2) }}</td>
    @endif
    @if($columns[0]->night_differential_pay == 1)
    <td class="text-center night_differential_pay_td_no" id="night_differential_pay_td">{{$employee->time_night_differential}}</td>
    <td class="text-center night_differential_pay_td_td" id="night_differential_pay_td">{{ number_format($employee->nightdiff,2) }}</td>
    @endif
    @if($columns[0]->regular_holiday_pay == 1)
    <td class="text-center regular_holiday_pay_td_td" id="regular_holiday_pay_td">{{ number_format($employee->regular_holiday,2) }} <br> ({{$employee->time_regular_holiday}} times)</td>
    @endif
    @if($columns[0]->special_holiday_pay == 1)
    <td class="text-center special_holiday_pay_td_td" id="special_holiday_pay_td">{{ number_format($employee->special_holiday,2) }} <br> ({{$employee->time_special_holiday}} times)</td>
    @endif
    @if($columns[0]->restday_pay == 1)
    <td class="text-center restday_pay_td_td" id="restday_pay_td">{{ number_format($employee->restday,2 )}}</td>
    @endif
    @if($columns[0]->leave_pay == 1)
    <td class="text-center leave_pay_td_no" id="leave_pay_td">{{$employee->time_leave_hours}}</td>
    <td class="text-center leave_pay_td_td" id="leave_pay_td">{{ number_format($employee->leave_pay,2) }}</td> 
    @endif

    <td class="text-center allowance_td_td" id="allowance_td">{{ number_format($employee->allowance + $employee->adjustment_allowance, 2) }}</td>
    <td class="text-center bonus_td_td" id="bonus_td">{{ number_format($employee->adjustment_bonus,2) }}</td>
    <td class="text-center commision_td_td" id="commision_td">{{ number_format($employee->adjustment_commission,2) }}</td>
    <td class="text-center incentives_td_td" id="incentives_td">{{ number_format($employee->adjustment_incentives,2) }}</td>
    <td class="text-center additions_td_td" id="additions_td">{{ number_format($employee->adjustment_additions,2) }}</td>
    <td class="text-center month_13_and_other_td_td" id="month_13_and_other_td">{{ number_format($employee->adjustment_13th_month_and_other,2) }}</td>
    <td class="text-center de_minimis_benefit_td_td" id="de_minimis_benefit_td">{{ number_format($employee->allowance_de_minimis + $employee->adjustment_de_minimis_benefit, 2) }}</td>
    <td class="text-center others_td_td" id="others_td">{{ number_format($employee->adjustment_others,2) }}</td>
    @if($columns[0]->gross_pay == 1)
    <td class="text-center gross_pay_td_td" id="gross_pay_td">{{ number_format($employee->gross_pay,2) }}</td>
    @endif
    <!--<td class="text-center" >{{ number_format($employee->adjustment_allowance,2) }}</td>-->
    <td class="text-center deductions_td_td" id="deductions_td">({{ number_format($employee->adjustment_deductions,2) }})</td>
    <td class="text-center cash_bond_td_td" id="cash_bond_td">({{ number_format($employee->cash_bond + $employee->adjustment_cash_bond, 2) }})</td>
    <td class="text-center cash_advance_td_td" id="cash_advance_td">({{ number_format($employee->cash_advance + $employee->adjustment_cash_advance,2) }})</td>
    <td class="text-center other_loan_td_td" id="other_loan_td">({{ number_format($employee->other_loans,2) }})</td>
    <!-- <td class="text-center" >{{ number_format($employee->adjustment_deduction,2) }}</td> -->
    <td class="text-center sss_loan_td_td" id="sss_loan_td">({{ number_format($employee->sss_loan,2) }})</td>
    <td class="text-center sss_ee_td_td" id="sss_ee_td">({{ number_format($employee->sss_ee,2) }})</td>
    <td class="text-center hdmf_loan_td_td" id="hdmf_loan_td">({{ number_format($employee->hdmf_loan,2) }})</td>
    <td class="text-center hdmf_ee_td_td" id="hdmf_ee_td">({{ number_format($employee->pagibig_ee,2) }})</td>
    <td class="text-center phic_ee_td_td" id="phic_ee_td">({{ number_format($employee->philhealth_ee,2) }})</td>
    @if($columns[0]->with_holding_tax == 1)
    <td class="text-center with_holding_tax_td_td" id="with_holding_tax_td">({{ number_format($employee->tax_ee,2) }})</td>
    @endif
    @if($columns[0]->total_deduction == 1)
    <td class="text-center total_deduction_td_td" id="total_deduction_td">({{ number_format($employee->total_deduction_employee,2) }})</td>
    @endif
    @if($columns[0]->take_home_pay == 1)
    <td class="text-center take_home_pay_td_td" id="take_home_pay_td">{{ number_format($employee->net_pay,2) }}</td>
    @endif
    <td class="text-center sss_er_td_td" id="sss_er_td">{{ number_format($employee->sss_er,2) }}</td>
    <td class="text-center sss_ec_td_td" id="sss_ec_td">{{ number_format($employee->sss_ec,2) }}</td>
    <td class="text-center hdmf_er_td_td" id="hdmf_er_td">{{ number_format($employee->pagibig_er,2) }}</td>
    <td class="text-center phic_er_td_td" id="phic_er_td">{{ number_format($employee->philhealth_er,2) }}</td>
  </tr>
 @endforeach
 <tr>
    @if($columns[0]->name == 1)
    <td class="text-center" id="name_total"><b>Total</b></td>
    @endif
{{--     @if($columns[0]->position == 1)
    <td class="text-center" id="position_total"><b></b></td>
    @endif --}}
    @if($columns[0]->taxstatus == 1)
    <td class="text-center" id="taxstatus_total"><b></b></td>
    @endif
   {{--  @if($columns[0]->dailyrate == 1)
    <td class="text-center" id="dailyrate_total"><b>{{ number_format($daily_rate_total, 2) }}</b></td>
    @endif
    @if($columns[0]->monthlybasic == 1)
    <td class="text-center" id="monthlybasic_total"><b>{{ number_format($monthly_basic_total,2)}}</b></td>
    @endif
    @if($columns[0]->semimonthlybasic == 1)
    <td class="text-center" id="semimonthlybasic_total"><b>{{ number_format($semimonthly_basic_total,2)}}</b></td>
    @endif --}}
    @if($columns[0]->gross_basic_pay == 1)
    <td class="text-center" id="gross_basic_pay_total"><b>{{ number_format($total_gross_basic, 2) }}</b></td>
    @endif
    @if($columns[0]->absent == 1)
    <td class="text-center" id="absent_total"><b>{{ number_format($time_total_absent,2)}}</b></td>
    <td class="text-center" id="absent_total_total"><b>({{ number_format($absent_total, 2) }})</b></td>
    @endif
    @if($columns[0]->late == 1)
    <td class="text-center" id="late_total"><b>({{ $time_total_late }})</b></td>
    <td class="text-center" id="late_total_total"><b>({{ number_format($late_total, 2) }})</b></td>
    @endif
    @if($columns[0]->undertime == 1)
    <td class="text-center" id="undertime_total"><b>({{ number_format($time_total_undertime, 2) }})</b></td>
    <td class="text-center" id="undertime_total_total"><b>({{ number_format($undertime_total, 2) }})</b></td>
    @endif
    @if($columns[0]->basic_pay == 1)
    <td class="text-center" id="basic_pay_total"><b>{{ number_format($total_basic, 2) }}</b></td>
    @endif
    @if($columns[0]->rendered_days == 1)
    <td class="text-center" id="rendered_days_total"><b>{{ number_format($rendered_days_total, 2) }}</b></td>
    @endif
    @if($columns[0]->cola == 1)
    <td class="text-center" id="cola_total"><b>{{ number_format($cola_total, 2) }}</b></td>
    @endif
   {{--  <td class="text-center" id="overtime_pay_total"><b>{{ number_format($overtime_total, 2) }}</b></td> --}}
    @if($columns[0]->overtime_pay == 1)
    <td class="text-center" id="overtime_pay_total"><b>({{ number_format($time_total_overtime, 2) }})</b></td>
    <td class="text-center" id="overtime_pay_total_total"><b>({{ number_format($overtime_total, 2) }})</b></td>
    @endif
    @if($columns[0]->night_differential_pay == 1)
    <td class="text-center" id="night_differential_pay_total"><b>
    {{ number_format($time_total_night_differential, 2) }}</b></td>
    <td class="text-center" id="night_differential_pay_total_total"><b>{{ number_format($nightdiff_total, 2) }}</b></td>
    @endif
    @if($columns[0]->regular_holiday_pay == 1)
    <td class="text-center" id="regular_holiday_pay_total"><b>{{ number_format($regular_holiday_total, 2) }}</b></td>
    @endif
    @if($columns[0]->special_holiday_pay == 1)
    <td class="text-center" id="special_holiday_pay_total"><b>{{ number_format($special_holiday_total, 2) }}</b></td>
    @endif
    @if($columns[0]->restday_pay == 1)
    <td class="text-center" id="restday_pay_total"><b>{{ number_format($restday_total, 2) }}</b></td>
    @endif
    @if($columns[0]->leave_pay == 1)
    <td class="text-center" id="leave_pay_total"><b>{{ number_format($time_total_leave_hours, 2) }}</b></td>
    <td class="text-center" id="leave_pay_total_total"><b>{{ number_format($leave_pay_total, 2) }}</b></td>
    @endif
    <td class="text-center" id="allowance_total"><b>{{ number_format($total_adjustment_allowance + $allowance_total, 2)}}</b></td>
    <td class="text-center" id="bonus_total"><b>{{ number_format($total_adjustment_bonus, 2) }}</b></td>
    <td class="text-center" id="commision_total"><b>{{ number_format($total_adjustment_commission, 2) }}</b></td>
    <td class="text-center" id="incentives_total"><b>{{ number_format($total_adjustment_incentives, 2) }}</b></td>
    <td class="text-center" id="additions_total"><b>{{ number_format($total_adjustment_additions, 2) }}</b></td>
    <td class="text-center" id="month_13_and_other_total"><b>{{ number_format($total_adjustment_13th_month_and_other, 2) }}</b></td>
    <td class="text-center" id="de_minimis_benefit_total"><b>{{ number_format($total_adjustment_de_minimis_benefit + $allowance_de_minimis_total, 2)}}</b></td>
    <td class="text-center" id="others_total"><b>{{ number_format($total_adjustment_others, 2) }}</b></td>
    @if($columns[0]->gross_pay == 1)
    <td class="text-center" id="gross_pay_total"><b>{{ number_format($total_gross, 2) }}</b></td>
    @endif
    <td class="text-center" id="deductions_total"><b>({{ number_format($total_adjustment_deductions, 2) }})</b></td>
    <td class="text-center" id="cash_bond_total"><b>({{ number_format((number_format($cash_bond_total, 2)    + number_format($total_adjustment_cash_bond, 2)), 2)}})</b></td>
    <td class="text-center" id="cash_advance_total"><b>({{ number_format((number_format($cash_advance_total, 2) + number_format($total_adjustment_additions, 2)), 2)}})</b></td>
    <td class="text-center" id="other_loan_total"><b>({{ number_format($other_loans_total, 2) }})</b></td>
    <td class="text-center" id="sss_loan_total"><b>({{ number_format($sss_loan_total, 2) }})</b></td>
    <td class="text-center" id="sss_ee_total"><b>({{ number_format($sss_ee_total, 2) }})</b></td>
    <td class="text-center" id="hdmf_loan_total"><b>({{ number_format($hdmf_loan_total, 2) }})</b></td>
    <td class="text-center" id="hdmf_ee_total"><b>({{ number_format($hdmf_ee_total, 2) }})</b></td>
    <td class="text-center" id="phic_ee_total"><b>({{ number_format($philhealth_ee_total, 2) }})</b></td>
    @if($columns[0]->with_holding_tax == 1)
    <td class="text-center" id="with_holding_tax_total"><b>({{ number_format($witholding_tax_total, 2) }})</b></td>
    @endif
    @if($columns[0]->total_deduction == 1)
    <td class="text-center" id="total_deduction_total"><b>({{ number_format($deduction_total, 2) }})</b></td>
    @endif
    @if($columns[0]->take_home_pay == 1)
    <td class="text-center" id="take_home_pay_total"><b>{{ number_format($total_net, 2) }}</b></td>
    @endif
    <td class="text-center" id="sss_er_total"><b>{{ number_format($sss_er_total, 2) }}</b></td>
    <td class="text-center" id="sss_ec_total"><b>{{ number_format($sss_ec_total, 2) }}</b></td>
    <td class="text-center" id="hdmf_er_total"><b>{{ number_format($hdmf_er_total, 2) }}</b></td>
    <td class="text-center" id="phic_er_total"><b>{{ number_format($philhealth_er_total, 2) }}</b></td>
    @foreach($columns as $column)
                <input type="hidden" class="name" name="name" value="{{ $column->name }}">
                <input type="hidden" class="position" name="position" value="{{ $column->position }}">
                <input type="hidden" class="taxstatus" name="taxstatus" value="{{ $column->taxstatus }}">
                <input type="hidden" class="dailyrate" name="dailyrate" value="{{ $column->dailyrate }}">
                <input type="hidden" class="monthlybasic" name="monthlybasic" value="{{ $column->monthlybasic }}">
                <input type="hidden" class="semimonthlybasic" name="semimonthlybasic" value="{{ $column->semimonthlybasic }}">
                 <input type="hidden" class="gross_basic_pay" name="gross_basic_pay" value="{{ $column->gross_basic_pay }}">
                 <input type="hidden" class="absent" name="absent" value="{{ $column->absent }}"> 
                <input type="hidden" class="late" name="late" value="{{ $column->late }}">    
                <input type="hidden" class="undertime" name="undertime" value="{{ $column->undertime }}">
                <input type="hidden" class="basic_pay" name="basic_pay" value="{{ $column->basic_pay }}"> 
                 <input type="hidden" class="rendered_days" name="rendered_days" value="{{ $column->rendered_days }}">   
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
</table>
</div>
</body>
</html>
