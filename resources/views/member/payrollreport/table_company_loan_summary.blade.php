<table class="table table-bordered table-condensed">
	<thead>
	    <tr>
	        <th class="text-center">EMPLOYEE NAME</th>
	        <th class="text-center">DESCRIPTION</th>
	        <th class="text-center"># of Payments</th>
	        <th class="text-center">LOAN AMOUNT</th>
	        <th class="text-center">TOTAL PAYMENT</th>
	        <th class="text-center">BALANCE</th>
	        <th></th>
	    </tr>
	</thead>
	<tbody class="table-warehouse">
	    @foreach($_loan_data as $key => $loan_data)
	    <tr>
	        <td class="text-center">{{ $loan_data->payroll_employee_display_name }}</td>
	        <td class="text-center">{{ $loan_data->payroll_deduction_name }}</td>
	        <td class="text-center">{{ $loan_data->number_of_payment .' out of '. $loan_data->payroll_deduction_number_of_payments}}</td>
	        <td class="text-center">{{ $loan_data->payroll_deduction_amount }}</td>
	        <td class="text-center">{{ $loan_data->total_payment }}</td>
	        <td class="text-center">{{ $loan_data->payroll_deduction_amount - $loan_data->total_payment }}</td>
	        <td class="text-center"><a href="javascript: action_load_link_to_modal('/member/payroll/reports/modal_loan_summary_report/{{ $loan_data->payroll_employee_id }}/{{ $loan_data->payroll_deduction_id }}','lg')">SUMMARY</a></td>
	    </tr>
	    @endforeach
	</tbody>
</table>