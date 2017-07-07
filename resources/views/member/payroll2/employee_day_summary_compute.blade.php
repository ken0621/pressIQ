<table width="100%" style="background-color: transparent;" class="pull-right detail-table">
    <tbody>
    <tr>
        <td>Daily Rate</td>
        <td width="100px"></td>
        <td>PHP {{ number_format($timesheet_info->compute->daily_rate, 2) }}</td>
    </tr>
    @if(isset($timesheet_info->compute->_breakdown_addition))
        @foreach($timesheet_info->compute->_breakdown_addition as $key => $breakdown)
        <tr>
            <td>{{ ucfirst($key) }}</td>
            <td width="100px" class="text-center" style="color: #bbb" width="100px">{{ $breakdown["time"] }}</td>
            <td width="100px">PHP {{ number_format($breakdown["rate"], 2) }}</td>
        </tr>
        @endforeach
        <tr>
            <td class="text-bold" >Subtotal</td>
            <td class="text-center" style="color: #bbb" width="100px"></td>
            <td class="text-bold" width="100px">PHP {{ number_format($timesheet_info->compute->subtotal_after_addition, 2) }}</td>
        </tr>
    @endif
    @if(isset($timesheet_info->compute->_breakdown_deduction))
        @foreach($timesheet_info->compute->_breakdown_deduction as $key => $breakdown)
        <tr>
            <td><span style="color: red; opacity: 0.5">Less: {{ ucfirst($key) }}</span></td>
            <td width="100px" class="text-center" style="color: red; opacity: 0.4" width="100px">{{ $breakdown["time"] }}</td>
            <td width="100px"><span style="color: red; opacity: 0.5">PHP {{ number_format($breakdown["rate"], 2) }}</span></td>
        </tr>
        @endforeach
    @endif
    <tr style="color: #1682ba; font-size: 18px;">
        <td class="text-bold">Total</td>
        <td class="text-center" style="color: #bbb" width="100px"></td>
        <td class="text-bold" width="100px">PHP {{ number_format($timesheet_info->compute->total_day_income, 2) }}</td>
    </tr>
    </tbody>
</table>