<table class="table table-bordered table-striped table-condensed">
    <thead style="text-transform: uppercase">
        <tr>
            <th class="text-center">Date Covered</th>
            <th class="text-center">Company</th>
            <th class="text-center">Total Net Salary</th>
            <th class="text-center"></th>
        </tr>
    </thead>
    <tbody>
        @if(count($_period) > 0)
        	@foreach($_period as $period)
    		<tr>
    			<td class="text-center">
                    {{ date('M d, Y',strtotime($period->payroll_period_start)).' - '.date('M d, Y',strtotime($period->payroll_period_end)) }}
                    <div>{{ $period->payroll_period_category }} ({{ code_to_word($period->period_count) }} of {{ $period->month_contribution }}  {{ $period->year_contribution }})</div>
                </td>
    			<td class="text-center">{{ $period->payroll_company_name }}</td>
                <td class="text-center"><a href="javascript:">{{ payroll_currency($period->payroll_period_total_net) }}</a></td>
    			<td class="text-center"><a href="javascript:">VIEW PAYSLIP</a></td>
    		</tr>
    		@endforeach
        @else
            <tr>
                <td colspan="4" style="padding: 80px; text-align: center;">No Data</td>
            </tr>
        @endif
    </tbody>
</table>