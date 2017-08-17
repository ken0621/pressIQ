<form class="global-submit form-horizontal" role="form" action="{link_submit_here}" method="post">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal">×</button>
		<h4 class="modal-title">EXPORT TO BANK</h4>
	</div>
	<div class="modal-body clearfix">
	<table class="table table-bordered table-striped table-condensed">
		<thead>
			<tr>
				<th>ACCOUNT #</th>
				<th>AMOUNT</th>
				<th>NAME</th>
				<th>REMARKS</th>
			</tr>
		</thead>
		<tbody>
			@foreach($_employee as $employee)
			<tr>
				<td>{{ $employee->payroll_employee_atm_number }}</td>
				<td>{{ number_format($employee->net_pay, 2) }}</td>
				<td>{{ $employee->payroll_employee_first_name }} {{ $employee->payroll_employee_middle_name }} {{ $employee->payroll_employee_last_name }}</td>
				<td>OK</td>
			</tr>
			@endforeach
	    </tbody>
	</table>
	</div>
	<div class="modal-footer">
		<button type="button" class="btn btn-def-white btn-custom-white" data-dismiss="modal">Close</button>
		<button class="btn btn-default btn-custom-default" onclick="location.href='/member/payroll/banking/{{ $payroll_period_company_id }}/download?xls=1'" type="button">Export Excel</button>
		<button class="btn btn-primary btn-custom-primary" onclick="location.href='/member/payroll/banking/{{ $payroll_period_company_id }}/download'" type="button">Export Bank Template</button>
	</div>
</form>