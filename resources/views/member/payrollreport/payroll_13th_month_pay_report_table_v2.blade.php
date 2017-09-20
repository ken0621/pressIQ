<table class="table table-bordered table-striped table-condensed" >
    <thead style="text-transform: uppercase">
        <tr>
            <th class="text-center">PERIOD</th>
            <th class="text-center">VIEW SUMMARY</th>
            <th class="text-center">13TH MONTH PAY BASIS</th>
            <th class="text-center">13TH MONTH PAY COMPUTATION</th>
        </tr>
    </thead>
    <tbody>
        @foreach($_period as $period)
        <tr>
            <td class="text-center">{{$period->payroll_period_start}} - {{$period->payroll_period_end}}</td>
            <td class="text-center"><a href="#">SUMMARY</a></td>
            <td class="text-center">{{ number_format($period->payroll_13th_month_basis,2) }}</td>
            <td class="text-center">{{ number_format($period->payroll_13th_month_contribution,2) }}</td>
        </tr>
        @endforeach
    </tbody>
</table>