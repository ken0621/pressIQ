@if(count($_employee) > 0)
    <table class="table table-bordered table-striped table-condensed">
        <thead style="text-transform: uppercase">
            <tr>
                <th class="text-center"><input type="checkbox" name=""></th>
                <th class="text-center">NO.</th>
                <th>Employee Name</th>
                <th class="text-center" width="150px">NET BASIC PAY</th>
                <th class="text-center" width="150px">GROSS PAY</th>
                <th class="text-center" width="150px">NET PAY / TAKE HOME PAY</th>
                <th class="text-center" width="100px"></th>
                <th class="text-center" width="100px"></th>
            </tr>
        </thead>
        <tbody>
            @foreach($_employee as $employee)
            <tr>
                <th class="text-center"><input type="checkbox" name=""></th>
                <td class="text-center">{!! $employee->payroll_employee_number == "" ? "<span style='color: red;'>00</span>" : $employee->payroll_employee_number !!}</td>
                <td>{{ $employee->payroll_employee_first_name }} {{ $employee->payroll_employee_last_name }}</td>
                
                @if($employee->net_pay != "")
                    <td class="text-center">{{ payroll_currency($employee->net_basic_pay) }}</td>
                    <td class="text-center">{{ payroll_currency($employee->gross_pay) }}</td>
                    <td class="text-center">{{ payroll_currency($employee->net_pay) }}</td>
                     <td class="text-center"><a href="javascript: timesheet_employee_list.action_set_to_unapprove('{{ $company->payroll_period_company_id }}','{{ $employee->payroll_employee_id }}')">UNAPPROVE</a></td>
                    <td class="text-center"><a href="javascript: action_load_link_to_modal('/member/payroll/company_timesheet2/income_summary/{{ $company->payroll_period_company_id }}/{{ $employee->payroll_employee_id }}', 'lg')">SUMMARY</a></td>
                @else
                    <td class="text-center">-</td>
                    <td class="text-center">-</td>
                    <td class="text-center">-</td>
                    <td class="text-center"><a href="javascript: action_load_link_to_modal('/member/payroll/company_timesheet2/{{ $company->payroll_period_company_id }}/{{ $employee->payroll_employee_id }}', 'lg')" >TIMESHEET</a></td>
                    <td class="text-center"><a href="javascript: action_load_link_to_modal('/member/payroll/company_timesheet2/income_summary/{{ $company->payroll_period_company_id }}/{{ $employee->payroll_employee_id }}', 'lg')">SUMMARY</a></td>
                 @endif
            </tr>
            @endforeach
        </tbody>
    </table>
@else
    <div class="text-center" style="padding: 150px 0">NO DATA</div>
@endif
