<!DOCTYPE html>
<html>
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1">
<style type="text/css">
table, th, td {
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

</style>
</head>
<body>
<div class="padding">
<table >
  
  <tr>

  <td>{{$company->payroll_company_name}}</td>
  </tr>
  <tr>
  <td>Payroll Register</td>
  </tr>
  <tr>
  <td>{{$show_period_start}}</td>
  </tr>
  <tr>
    <td rowspan="2">NAME</td>
    <td rowspan="2">BASIC PAY</td>
    <td rowspan="2">OT PAY</td>
    <td rowspan="2">NIGHT DIFF PAY</td>
    <td rowspan="2">REGULAR HOLIDAY PAY</td>
    <td rowspan="2">SPECIAL HOLIDAY PAY</td>
    <td rowspan="2">RESTDAY PAY</td>
    <td rowspan="2">LEAVE PAY</td>
    <td rowspan="2">COLA</td>
    <td rowspan="2">LATE</td>
    <td rowspan="2">UNDER TIME</td>
    <td rowspan="2">ABSENT</td>
    <td colspan="2">ALLOWANCES</td>
    <td colspan="6">DEDUCTION</td>
    <td colspan="3">SSS CONTRIBUTION</td>
    <td colspan="2">PAG-IBIG CONTRIBUTION</td>
    <td colspan="2">PHIL-HEALTH CONTRIBUTION</td>
    <td rowspan="2">WITH HOLDING TAX</td>
    <td rowspan="2">TOTAL DEDUCTIONS</td>
    <td rowspan="2">GROSS PAY</td>
    <td rowspan="2">NETHOME PAY</td>
   </tr>
  <tr>
    <td ></td>
    <td ></td>
    <td ></td>
    <td ></td>
    <td ></td>
    <td ></td>
    <td ></td>
    <td ></td>
    <td ></td>
    <td ></td>
    <td ></td>
    <td ></td>
    <td ></td>
    <td >ALLOWANCES</td>
    <td >ADJUSTMENTS ALLOWANCES</td>
    <td >SSS LOAN</td>
    <td >HDMF LOAN</td>
    <td >CASH BOND</td>
    <td >CASH ADVANCE</td>
    <td >OTHER DEDUCTIONS</td>
    <td >ADJUSTMENT DEDUCTION</td>
    <td >SSS EE</td>
    <td >SSS ER</td>
    <td >SSS EC</td>
    <td >HDMF EE</td>
    <td >HDMF ER</td>
    <td >PHIC EE</td>
    <td >PHIC ER</td>
  </tr>

  @foreach($_employee as $lbl => $employee)
  <tr>  
    <td  >{{ $employee->payroll_employee_first_name }} {{ $employee->payroll_employee_last_name }}</td>
    <td >{{ number_format($employee->net_basic_pay,2) }}</td>
    <td >{{ number_format($employee->overtime,2) }}</td>
    <td >{{ number_format($employee->nightdiff,2) }}</td>
    <td  >{{ number_format($employee->regular_holiday,2) }}</td>
    <td  >{{ number_format($employee->special_holiday,2) }}</td>
    <td  >{{ number_format($employee->restday,2 )}}</td>
    <td  >{{ number_format($employee->leave_pay,2) }}</td>
    <td  >{{ number_format($employee->cola,2) }}</td>
    <td  >{{ number_format($employee->late,2) }}</td>
    <td  >{{ number_format($employee->undertime,2) }}</td>
    <td  >{{ number_format($employee->absent,2) }}</td>
    <td  >{{ number_format($employee->allowance,2) }}</td>
    <td  >{{ number_format($employee->adjustment_allowance,2) }}</td>
    <td >{{ number_format($employee->sss_loan,2) }}</td>
    <td  >{{ number_format($employee->hdmf_loan,2) }}</td>
    <td  >{{ number_format($employee->cash_bond,2) }}</td>
    <td  >{{ number_format($employee->cash_advance,2) }}</td>
    <td  >{{ number_format($employee->other_loans,2) }}</td>
    <td  >{{ number_format($employee->adjustment_deduction,2) }}</td>
    <td  >{{ number_format($employee->sss_ee,2) }}</td>
    <td  >{{ number_format($employee->sss_er,2) }}</td>
    <td  >{{ number_format($employee->sss_ec,2) }}</td>
    <td  >{{ number_format($employee->pagibig_ee,2) }}</td>
    <td  >{{ number_format($employee->pagibig_er,2) }}</td>
    <td  >{{ number_format($employee->philhealth_ee,2) }}</td>
    <td  >{{ number_format($employee->philhealth_er,2) }}</td>
    <td  >{{ number_format($employee->tax_ee,2) }}</td>
    <td  >{{ number_format($employee->total_deduction_employee,2) }}</td>
    <td  >{{ number_format($employee->gross_pay,2) }}</td>
    <td  >{{ number_format($employee->net_pay,2) }}</td>
  </tr>
 @endforeach      
</table>
</div>
</body>
</html>
