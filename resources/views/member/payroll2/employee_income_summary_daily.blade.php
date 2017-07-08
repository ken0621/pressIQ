<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">×</button>
    <h4 class="modal-title"><b>DAILY COMPUTATION</b> </h4>
</div>
<div class="modal-body clearfix">
    <div class="col-md-12" style="text-align: left; font-weight: normal; margin-bottom: 10px; font-size: 16px;"></div>
    <div class="clearfix">
        <div class="col-md-12">
            <div class="table-responsive">
             <table class="table table-condensed timesheet table-timesheet">
                <thead>
                    <tr>
                        <th colspan="5" class="text-center"></th>
                    </tr>
                    <tr>
                        <th class="text-center">DATE</th>
                        <th class="text-right">BASIC PAY</th>
                        <th class="text-right">GROSS PAY</th>
                        <th class="text-right">COLA PAY</th>
                        <th class="text-right">GROSS + COLA</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($cutoff_input as $key => $cutoff)
                <tr>
                    <td class="text-center">
                        {{date('F d, Y', strtotime($key))}}
                    </td>
                    <td class="text-right" style="opacity: 0.7">
                        {{payroll_currency($cutoff->compute->total_day_basic, 2)}}
                    </td>
                    <td class="text-right" style="opacity: 0.7">
                        {{payroll_currency($cutoff->compute->total_day_income, 2)}}
                    </td>
                    <td class="text-right" style="opacity: 0.7">
                        {{payroll_currency($cutoff->compute->total_day_cola, 2)}}
                    </td>
                    <td class="text-right" style="opacity: 0.7">
                        {{payroll_currency($cutoff->compute->total_day_income_plus_cola, 2)}}
                    </td>
                </tr>
                @endforeach
                <tr style="border-top: 2px solid #000">
                    <td></td>
                    <td class="text-right"><b>{{payroll_currency($total['basic_total'],2)}}</b></td>
                    <td class="text-right"><b>{{payroll_currency($total['basic_gross'],2)}}</b></td>
                    <td class="text-right"><b>{{payroll_currency($total['basic_cola'],2)}}</b></td>
                    <td class="text-right"><b>{{payroll_currency($total['basic_gross_cola'],2)}}</b></td>
                </tr>
                </tbody>
                <tbody>
                    @foreach($adjustment['add'] as $add)
                    <tr>
                        <td colspan="4" class="text-right" style="opacity: 0.7">
                            {{strtoupper($add['name'])}}
                        </td>
                        <td class="text-right" style="opacity: 0.7">
                            {{payroll_currency($add['amount'], 2)}}
                        </td>
                    </tr>
                    @endforeach
                    @foreach($adjustment['minus'] as $minus)
                    <tr>
                        <td colspan="4" class="text-right color-red" style="opacity: 0.7">
                            {{ strtoupper($minus['name'])}}
                        </td>
                        <td class="text-right color-red" style="opacity: 0.7">
                            {{payroll_currency($minus['amount'], 2)}}
                        </td>
                    </tr>
                    @endforeach
                    <tr style="border-top: 2px solid #000">
                        <td colspan="4" class="text-right"><b>NET SALARY</b></td>
                        <td class="text-right" style="font-weight: bold; color: #1682ba">
                            {{payroll_currency($netpay_compute['net_pay'], 2)}}
                        </td>
                    </tr>
                </tbody>
            </table>
            </div>
        </div>
    </div>
</div>
