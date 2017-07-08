<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">×</button>
    <h4 class="modal-title"><b>MONTHLY COMPUTATION</b> </h4>
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
                            <th class="text-center" width="100px"></th>
                            <th width="150px" class="text-right" width="100px">ADDITION</th>
                            <th width="150px" class="text-right" width="100px">DEDUCTION</th>
                            <th class="text-center"></th>
                            <th width="150px" class="text-right">TOTAL</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($cutoff_input as $date => $compute)
                            <tr style="border-top: 2px solid #ddd">
                                <td class="text-center">{{ date("F d, Y", strtotime($date)) }} </td>
                                <td></td>
                                <td class="text-right" style="opacity: 0.9">{{ payroll_currency($compute->compute->breakdown_addition, 2) }}</td>
                                <td class="text-right" style="opacity: 0.9">{{ payroll_currency($compute->compute->breakdown_deduction, 2) }}</td>
                                <td></td>
                                <td class="text-right" style="opacity: 0.9">{{ payroll_currency($compute->compute->breakdown_addition - $compute->compute->breakdown_deduction, 2) }}</td>
                            </tr>
                            @if(isset($compute->compute->_breakdown_addition))
                                @foreach($compute->compute->_breakdown_addition as $breakdown_label => $breakdown)
                                <tr>
                                    <td colspan="2" class="text-right" style="opacity: 0.5">{{ strtoupper($breakdown_label) }}</td>
                                    <td class="text-right" style="opacity: 0.5">{{ payroll_currency($breakdown["rate"]) }}</td>
                                    <td class="text-right" style="opacity: 0.5"></td>
                                    <td></td>
                                    <td class="text-right" style="opacity: 0.5"></td>
                                </tr>
                                @endforeach
                            @endif
                            @if(isset($compute->compute->_breakdown_deduction))
                                @foreach($compute->compute->_breakdown_deduction as $breakdown_label => $breakdown)
                                <tr>
                                    
                                    <td colspan="2" class="text-right" style="opacity: 0.5">{{ strtoupper($breakdown_label) }}</td>
                                    <td class="text-right" style="opacity: 0.5"></td>
                                    <td class="text-right" style="opacity: 0.5">{{ payroll_currency($breakdown["rate"]) }}</td>
                                    <td></td>
                                    <td class="text-right" style="opacity: 0.5"></td>
                                </tr>
                                @endforeach
                            @endif
                        @endforeach
                        <tr class="text-right" style="border-top: 2px solid #000" style="opacity: 0.7">
                            <td></td>
                            <td></td>
                            <td>LESS: DEDUCTION</td>
                            <td>{{ payroll_currency($cutoff_compute->total_deduction) }}</td>
                            <td style="font-weight: bold;">SUB TOTAL</td>
                            <td style="font-weight: bold;">{{ payroll_currency($cutoff_compute->total_subtotal) }}</td>
                        </tr>
                        <tr class="text-right" style="opacity: 0.7">
                            <td></td>
                            <td></td>
                            <td>CUT-OFF RATE</td>
                            <td>{{ payroll_currency($cutoff_compute->cutoff_rate) }}</td>
                            <td></td>
                            <td>{{ payroll_currency($cutoff_compute->cutoff_rate) }}</td>
                        </tr>
                        <tr class="text-right" style="opacity: 0.7">
                            <td></td>
                            <td></td>
                            <td>LESS: COLA</td>
                            <td>{{ payroll_currency($cutoff_compute->deduction_cola) }}</td>
                            <td>CUT-OFF COLA</td>
                            <td>{{ payroll_currency($cutoff_compute->cutoff_cola) }}</td>
                        </tr>
                        <tr class="text-right" style="border-top: 2px solid #000; font-weight: bold;">
                            <td></td>
                            <td></td>
                            <td>BASIC PAY</td>
                            <td>{{ payroll_currency($cutoff_compute->cutoff_basic) }}</td>
                            <td>GROSS PAY</td>
                            <td>{{ payroll_currency($cutoff_compute->cutoff_income_plus_cola) }}</td>
                        </tr>
                        
                   @foreach($adjustment['add'] as $add)
                    <tr>
                        <td colspan="5" class="text-right">
                            {{ strtoupper($add['name']) }}
                        </td>
                        <td class="text-right">
                            {{payroll_currency($add['amount'])}}
                        </td>
                    </tr>
                    @endforeach
                    @foreach($adjustment['minus'] as $minus)
                    <tr>
                        <td colspan="5" class="text-right color-red" style="opacity: 0.5">
                            {{ strtoupper($minus['name']) }}
                        </td>
                        <td class="text-right color-red" style="opacity: 0.7">
                            {{payroll_currency($minus['amount'])}}
                        </td>
                    </tr>
                    @endforeach
                    <tr style="border-top: 2px solid #000">
                        <td colspan="5" class="text-right"><b>NET SALARY</b></td>
                        <td class="text-right" style="font-weight: bold; font-size: 16px; color: #1682ba">
                            {{payroll_currency($netpay_compute['net_pay'])}}
                        </td>
                    </tr
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>