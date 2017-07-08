<div class="form-horizontal">
    <div class="form-group">
        <div class="col-md-12">
            <table class="table table-condensed table-bordered">
                <thead>
                    <tr>
                        <th colspan="5" class="text-center"></th>
                    </tr>
                    <tr>
                        <th class="text-center">DATE</th>
                        <th class="text-center">BASIC PAY</th>
                        <th class="text-center">GROSS PAY</th>
                        <th class="text-center">COLA PAY</th>
                        <th class="text-center">GROSS + COLA</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($cutoff_input as $key => $cutoff)
                <tr>
                    <td class="text-center">
                        {{date('F d, Y', strtotime($key))}}
                    </td>
                    <td class="text-right">
                        {{number_format($cutoff->compute->total_day_basic, 2)}}
                    </td>
                    <td class="text-right">
                        {{number_format($cutoff->compute->total_day_income, 2)}}
                    </td>
                    <td class="text-right">
                        {{number_format($cutoff->compute->total_day_cola, 2)}}
                    </td>
                    <td class="text-right">
                        {{number_format($cutoff->compute->total_day_income_plus_cola, 2)}}
                    </td>
                </tr>
                @endforeach
                <tr>
                    <td></td>
                    <td class="text-right"><b>{{number_format($total['basic_total'],2)}}</b></td>
                    <td class="text-right"><b>{{number_format($total['basic_gross'],2)}}</b></td>
                    <td class="text-right"><b>{{number_format($total['basic_cola'],2)}}</b></td>
                    <td class="text-right"><b>{{number_format($total['basic_gross_cola'],2)}}</b></td>
                </tr>
                </tbody>
                <tbody>
                    @foreach($adjustment['add'] as $add)
                    <tr>
                        <td colspan="4" class="text-right">
                            {{$add['name']}}
                        </td>
                        <td class="text-right">
                            {{number_format($add['amount'], 2)}}
                        </td>
                    </tr>
                    @endforeach
                    @foreach($adjustment['minus'] as $minus)
                    <tr>
                        <td colspan="4" class="text-right color-red">
                            {{$minus['name']}}
                        </td>
                        <td class="text-right color-red">
                            {{number_format($minus['amount'], 2)}}
                        </td>
                    </tr>
                    @endforeach
                    <tr>
                        <td colspan="4" class="text-right"><b>NET SALARY</b></td>
                        <td class="text-right">
                            {{number_format($netpay_compute['net_pay'], 2)}}
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>