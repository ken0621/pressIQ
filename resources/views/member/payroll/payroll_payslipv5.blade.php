<table width="100%">
@foreach($_employee as $employee)
  <tr>  
    <td>
      <table cellpadding="5" cellspacing="0" border="1" width="100%">      
        <tr>
          <tr>
            <td colspan="3" class="text-center">{{ strtoupper($company->payroll_company_name) }}</td>
          </tr>
          <tr>
            <td colspan="3">
              Name: 
                {{ $employee->payroll_employee_last_name }}, {{ $employee->payroll_employee_first_name }} {{ $employee->payroll_employee_middle_name }}
            </td>                  
          </tr>
          <tr>
            <td colspan="3">
              {{ $show_period_start }} - {{ $show_period_end }}
            </td>
          </tr>
        </tr> 
        <tbody>
          <tr style="font-weight: bold;" width="100%">
              <td>BASIC PAY</td>
              <td class="text-right">{{ payroll_currency($employee->net_basic_pay) }}</td>
              <td></td>
          </tr>
          <tr>
            <td colspan="3"></td>
          </tr>
          @foreach($employee->cutoff_breakdown->_gross_pay_breakdown as $breakdown)
            <tr>
                <td>{{ strtoupper($breakdown["label"]) }}</td>
                <td class="text-right">{{ payroll_currency($breakdown["amount"]) }}</td>
                <td></td>
            </tr>
          @endforeach

          <tr style="font-weight: bold;">
            <td>GROSS SALARY</td>
            <td></td>
            <td class="text-right">{{ payroll_currency($employee->gross_pay) }}</td>
          </tr>

          @foreach($employee->cutoff_breakdown->_taxable_salary_breakdown as $breakdown)
            <tr>
                <td>{{ strtoupper($breakdown["label"]) }}</td>
                <td class="text-right">{{ payroll_currency($breakdown["amount"]) }}</td>
                <td></td>
            </tr>
          @endforeach

          @foreach($employee->cutoff_breakdown->_net_pay_breakdown as $breakdown)
            <tr>
              <td>{{ strtoupper($breakdown["label"]) }}</td>
              <td class="text-right">{{ payroll_currency($breakdown["amount"]) }}</td>
              <td></td>
            </tr>
          @endforeach

          <tr>
              <td>TOTAL DEDUCTION</td>
              <td></td>
              <td class="text-right">{{ payroll_currency($employee->total_deduction) }}</td>
          </tr>

          <tr style="font-weight: bold;">
              <td>TAKE HOME PAY</td>
              <td></td>
              <td class="text-right">{{ payroll_currency($employee->net_pay) }}</td>
          </tr>
        </tbody>
      </table>
    </td>

    <td>
      <table cellpadding="5" cellspacing="0" border="1" width="100%">      
        <tr>
          <tr>
            <td colspan="3" class="text-center">{{ strtoupper($company->payroll_company_name) }}</td>
          </tr>
          <tr>
            <td colspan="3">
              Name: 
                {{ $employee->payroll_employee_last_name }}, {{ $employee->payroll_employee_first_name }} {{ $employee->payroll_employee_middle_name }}
            </td>                  
          </tr>
          <tr>
            <td colspan="3">
              {{ $show_period_start }} - {{ $show_period_end }}
            </td>
          </tr>
        </tr> 
        <tbody>
          <tr style="font-weight: bold;" width="100%">
              <td>BASIC PAY</td>
              <td class="text-right">{{ payroll_currency($employee->net_basic_pay) }}</td>
              <td></td>
          </tr>
          <tr>
            <td colspan="3"></td>
          </tr>
          @foreach($employee->cutoff_breakdown->_gross_pay_breakdown as $breakdown)
            <tr>
                <td>{{ strtoupper($breakdown["label"]) }}</td>
                <td class="text-right">{{ payroll_currency($breakdown["amount"]) }}</td>
                <td></td>
            </tr>
          @endforeach

          <tr style="font-weight: bold;">
            <td>GROSS SALARY</td>
            <td></td>
            <td class="text-right">{{ payroll_currency($employee->gross_pay) }}</td>
          </tr>

          @foreach($employee->cutoff_breakdown->_taxable_salary_breakdown as $breakdown)
            <tr>
                <td>{{ strtoupper($breakdown["label"]) }}</td>
                <td class="text-right">{{ payroll_currency($breakdown["amount"]) }}</td>
                <td></td>
            </tr>
          @endforeach

          @foreach($employee->cutoff_breakdown->_net_pay_breakdown as $breakdown)
            <tr>
              <td>{{ strtoupper($breakdown["label"]) }}</td>
              <td class="text-right">{{ payroll_currency($breakdown["amount"]) }}</td>
              <td></td>
            </tr>
          @endforeach

          <tr>
              <td>TOTAL DEDUCTION</td>
              <td></td>
              <td class="text-right">{{ payroll_currency($employee->total_deduction) }}</td>
          </tr>

          <tr style="font-weight: bold;">
              <td>TAKE HOME PAY</td>
              <td></td>
              <td class="text-right">{{ payroll_currency($employee->net_pay) }}</td>
          </tr>
        </tbody>
      </table>
    </td>
  </tr>

  @if($counter==2)

    </table>
    <table width="100%">
      <tr>
        <td><div style="page-break-after: always;">&nbsp;</div></td>
      </tr>
      <tr>
    <?php $counter=1 ?>
  @else
    <?php $counter++ ?>
  @endif

@endforeach
</table>
