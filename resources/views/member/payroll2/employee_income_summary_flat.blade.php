<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">×</button>
    <h4 class="modal-title"><b>MONTHLY COMPUTATION ({{ $period_info->month_contribution }} - {{ code_to_word($period_info->period_count) }})</b> </h4>
</div>
<div class="modal-body clearfix">
    <div class="col-md-12" style="text-align: left; font-weight: normal; margin-bottom: 10px; font-size: 16px;"></div>
    <div class="clearfix">
        <div class="col-md-12">
            <div class="table-responsive">

                <table width="100%" class="table table-condensed">
                    <tbody>
                        <tr>
                            <td colspan="7"></td>
                            <td width="150px"></td>
                        </tr>
                        <!-- NET BASIC PAY -->
                        <tr class="text-right" style="border-top: 2px solid #000" style="opacity: 0.7">
                            <td colspan="7" style="font-weight: bold;">NET BASIC PAY</td>
                            <td style="font-weight: bold;">{{ payroll_currency($cutoff_breakdown->basic_pay_total) }}</td>
                        </tr>

                        <!-- GROSS BREAKDOWN  -->
                        @if($cutoff_breakdown->_gross_pay_breakdown)
                            @foreach($cutoff_breakdown->_gross_pay_breakdown as $breakdown)
                                {!! $breakdown["tr"] !!}
                            @endforeach
                        @endif

                        <!-- GROSS PAY -->
                        <tr style="font-weight: bold;">
                            <td colspan="7" class="text-right" style="border-top: 2px solid #000">
                                GROSS PAY
                            </td>
                            <td class="text-right" style="border-top: 2px solid #000">
                                {{ payroll_currency($cutoff_breakdown->gross_pay_total) }}
                            </td>
                        </tr>
                        
                        <!-- TAXABLE BREAKDOWN -->
                        @foreach($cutoff_breakdown->_taxable_salary_breakdown as $breakdown)
                            {!! $breakdown["tr"] !!}
                        @endforeach
                       
                        <!-- TAXABLE SALARY -->
                        <tr style="font-weight: bold;">
                            <td colspan="7" class="text-right" style="border-top: 2px solid #000">
                                TAXABLE SALARY
                            </td>
                            <td class="text-right" style="border-top: 2px solid #000">
                                {{ payroll_currency($cutoff_breakdown->taxable_salary_total) }}
                            </td>
                        </tr>

                        <!-- NET PAY BREAKDOWN -->
                        @foreach($cutoff_breakdown->_net_pay_breakdown as $breakdown)
                            {!! $breakdown["tr"] !!}
                        @endforeach
                        
                        <!-- NET SALARY -->
                        <tr style="font-weight: bold;">
                            <td colspan="7" class="text-right" style="border-top: 2px solid #000">
                                NET PAY / TAKE HOME PAY
                            </td>
                            <td class="text-right" style="border-top: 2px solid #000; color: #1682ba">
                                {{ payroll_currency($cutoff_breakdown->net_pay_total) }}
                            </td>
                        </tr> 
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

