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
                        <tr>
                            <td class="text-center">{{ date("F d, Y", strtotime($date)) }} </td>
                            <td></td>
                            <td class="text-right">{{ payroll_currency($compute->compute->breakdown_addition, 2) }}</td>
                            <td class="text-right">{{ payroll_currency($compute->compute->breakdown_deduction, 2) }}</td>
                            <td></td>
                            <td class="text-right">{{ payroll_currency($compute->compute->breakdown_addition - $compute->compute->breakdown_deduction, 2) }}</td>
                        </tr>
                        @endforeach
                        <tr class="text-right" style="border-top: 2px solid #000">
                            <td></td>
                            <td></td>
                            <td>LESS DEDUCTION</td>
                            <td>{{ payroll_currency($cutoff_compute->total_deduction) }}</td>
                            <td>SUB TOTAL</td>
                            <td>{{ payroll_currency($cutoff_compute->total_subtotal) }}</td>
                        </tr>
                        <tr class="text-right">
                            <td></td>
                            <td></td>
                            <td>CUT-OFF RATE</td>
                            <td>{{ payroll_currency($cutoff_compute->cutoff_rate) }}</td>
                            <td></td>
                            <td>{{ payroll_currency($cutoff_compute->cutoff_rate) }}</td>
                        </tr>
                        <tr class="text-right">
                            <td></td>
                            <td></td>
                            <td>LESS: COLA</td>
                            <td>{{ payroll_currency($cutoff_compute->deduction_cola) }}</td>
                            <td>MONTHLY COLA</td>
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
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript" src="/assets/member/payroll/js/timesheet2.js"></script>