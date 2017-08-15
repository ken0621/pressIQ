<html>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<style type="text/css">
	*
	{
		font-family: Arial Narrow;
	}
	.strong
	{
		font-weight: 700;
	}
	</style>
	<tr>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td style="font-weight: 700;">RDS GLOBAL ALLIANZ CORP</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>China Banking Corporation</td>
	</tr>
	<tr>
		<td>Balintawak Branch</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>Subject:</td>
		<td style="font-weight: 700; text-decoration: underline;">Payroll Deduction</td>
		<td style="text-decoration: underline; text-align: center;">July 31, 2017</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>
	<tr style="text-align: center; font-weight: 700; text-align: center;">
		<td style="border: 1px solid #000;">Name</td>
		<td style="border: 1px solid #000;">Account No.</td>
		<td style="border: 1px solid #000;">Amount</td>
	</tr>
	@foreach($_employee as $employee)
	<tr>	
		<td>{{ $employee->payroll_employee_first_name }} {{ $employee->payroll_employee_middle_name }} {{ $employee->payroll_employee_last_name }}</td>
		<td style="border: 1px solid #000;">{{ $employee->payroll_employee_atm_number }}</td>
		<td style="border: 1px solid #000;">{{ number_format($employee->net_pay, 2) }}</td>
	</tr>
	@endforeach
</html>