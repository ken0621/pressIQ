<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">×</button>
    <h4 class="modal-title"><b>DAILY COMPUTATION ({{ $period_info->month_contribution }} - {{ $period_info->period_count }})</b> </h4>
</div>
<div class="modal-body clearfix">
    <div class="col-md-12" style="text-align: left; font-weight: normal; margin-bottom: 10px; font-size: 16px;"></div>
    <div class="clearfix">
        <div class="col-md-12">
            <div class="table-responsive">
                <table class="table table-condensed timesheet table-timesheet">
                    <thead style="text-transform: uppercase">
                        <tr>
                            <th width="120px" class="text-center">DATE</th>
                            <th class="text-center" width="100px">DAY RATE</th>
                            <th class="text-center" width="100px"></th>
                            <th width="150px" class="text-right" width="100px">ADDITIONS</th>
                            <th width="150px" class="text-right" width="100px">DEDUCTIONS</th>
                            <th class="text-right" width="100px">COLA</th>
                            
                            <th class="text-right"></th>
                            <th width="150px" class="text-right">BASIC</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($cutoff_input as $date => $compute)
                        <tr style="border-top: 2px solid #ddd">
                                <td class="text-center">{{ date("F d, Y", strtotime($date)) }} </td>
                                <td class="text-center">{{ payroll_currency($compute->compute->daily_rate, 2) }}</td>
                                <td></td>
                                <td class="text-right" style="opacity: 0.9">{{ payroll_currency($compute->compute->breakdown_addition, 2) }}</td>
                                <td class="text-right" style="opacity: 0.9">{{ payroll_currency($compute->compute->breakdown_deduction, 2) }}</td>
                                <td class="text-right">{{ payroll_currency($compute->compute->cola, 2) }}</td>
                                
                                <td></td>
                                <td class="text-right" style="opacity: 0.9">{{ payroll_currency($compute->compute->total_day_basic, 2) }}</td>
                            </tr>
                            @if(isset($compute->compute->_breakdown_addition))
                                @foreach($compute->compute->_breakdown_addition as $breakdown_label => $breakdown)
                                <tr >
                                    <td></td>
                                    <td style="border-left: 1px solid #ddd;" colspan="2" class="text-right" style="opacity: 0.5">{{ strtoupper($breakdown_label) }}</td>
                                    <td class="text-right" style="opacity: 0.5">{{ payroll_currency($breakdown["rate"]) }}</td>
                                    <td class="text-right" style="opacity: 0.5"></td>
                                    <td></td>
                                    <td></td>
                                    <td class="text-right" style="opacity: 0.5"></td>
                                </tr>
                                @endforeach
                            @endif
                            @if(isset($compute->compute->_breakdown_deduction))
                                @foreach($compute->compute->_breakdown_deduction as $breakdown_label => $breakdown)
                                <tr>
                                    <td></td>
                                    <td colspan="2" class="text-right" style="opacity: 0.5;">{{ strtoupper($breakdown_label) }}</td>
                                    <td class="text-right" style="opacity: 0.5"></td>
                                    <td class="text-right" style="opacity: 0.5">{{ payroll_currency($breakdown["rate"]) }}</td>
                                    <td></td>
                                    <td></td>
                                    <td class="text-right" style="opacity: 0.5"></td>
                                </tr>
                                @endforeach
                            @endif
                        @endforeach
                        

                        <!-- NET BASIC PAY -->
                        <tr class="text-right" style="border-top: 2px solid #000" style="opacity: 0.7">
                            <td colspan="7" style="font-weight: bold;">NET BASIC PAY</td>
                            <td style="font-weight: bold;">{{ payroll_currency($break_down['employee']['get_net_basic_pay']['total_net_basic']) }}</td>
                        </tr>

                        <!-- ADD ADDITIONS -->
                        @foreach($break_down['employee']['get_gross_pay']['obj'] as $obj)
                        <tr>
                            <td colspan="7" class="text-right" style="opacity: 0.5">
                                ADD: {{ strtoupper($obj['name']) }}
                            </td>
                            <td class="text-right">
                                {{payroll_currency($obj['amount'])}}
                                
                            </td>
                        </tr>
                        @endforeach

                        <!-- GROSS PAY -->
                        <tr style="font-weight: bold;">
                            <td colspan="7" class="text-right" style="border-top: 2px solid #000">
                                GROSS PAY
                            </td>
                            <td class="text-right" style="border-top: 2px solid #000">
                                {{ payroll_currency($break_down['employee']['get_gross_pay']['total_gross_pay']) }}
                            </td>
                        </tr>
                        
                        <!-- DEDUCTIONS -->
                       
                        @foreach($break_down['employee']['get_taxable_salary']['obj'] as $obj)
                       
                        <tr>
                            <td colspan="7" class="text-right" style="opacity: 0.5">
                                LESS: {{ strtoupper($obj['name']) }}
                                {!!isset($obj['ref']) ? '<br>'.$obj['ref'] : ''!!}
                              
                            </td>
                            <td class="text-right color-red" style="opacity: 0.7">
                                {{payroll_currency($obj['amount'])}}
                            </td>
                        </tr>
                        @endforeach
                       
                        <!-- TAXABLE SALARY -->
                        <tr style="font-weight: bold;">
                            <td colspan="7" class="text-right" style="border-top: 2px solid #000">
                                TAXABLE SALARY<br>{{$break_down['employee']['get_taxable_salary']['taxable_status']}}
                            </td>
                            <td class="text-right" style="border-top: 2px solid #000">
                                {{ payroll_currency($break_down['employee']['get_taxable_salary']['total_taxable']) }}
                            </td>
                        </tr>
                        
                        <!-- TAX -->
                         @foreach($break_down['employee']['get_net_pay']['obj'] as $obj)
                            @if($obj["name"] == "TAX")
                            <tr>
                                <td colspan="7" class="text-right" style="opacity: 0.5">
                                    LESS: {{ strtoupper($obj['name']) }}
                                </td>
                                <td class="text-right color-red" style="opacity: 0.7">
                                    {{payroll_currency($obj['amount'])}}
                                </td>
                            </tr>
                            @endif
                        @endforeach
                        @foreach($break_down['employee']['get_net_pay']['obj'] as $obj)
                            @if($obj["name"] != "TAX" && $obj['type'] != 'add')
                            <tr>
                                <td colspan="7" class="text-right" style="opacity: 0.5">
                                    LESS: {{ strtoupper($obj['name']) }}
                                    
                                </td>
                                <td class="text-right color-red" style="opacity: 0.7">
                                    {{payroll_currency($obj['amount'])}}
                                </td>
                            </tr>
                            @endif
                        @endforeach
                        @foreach($break_down['employee']['get_net_pay']['obj'] as $obj)
                            @if($obj["name"] != "TAX" && $obj['type'] == 'add')
                            <tr>
                                <td colspan="7" class="text-right" style="opacity: 0.5">
                                    ADD: {{ strtoupper($obj['name']) }}
                                </td>
                                <td class="text-right" style="opacity: 0.5">
                                    {{payroll_currency($obj['amount'])}}
                                </td>
                            </tr>
                            @endif
                        @endforeach
                        <!-- ALLOWANCES -->
                        
                        <!-- NET SALARY -->
                        <tr style="font-weight: bold;">
                            <td colspan="7" class="text-right" style="border-top: 2px solid #000">
                                NET PAY / TAKE HOME PAY
                            </td>
                            <td class="text-right" style="border-top: 2px solid #000; color: #1682ba">
                                {{ payroll_currency($break_down['employee']['get_net_pay']['total_net_pay']) }}
                            </td>
                        </tr> 
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>