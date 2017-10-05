<html>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <table>
        <thead>
            <tr>
                <th style="text-align: left; width: 20;">PAYOUT DATE</th>
                <th style="text-align: left; width: 20;">SLOT NO</th>
                <th style="text-align: left; width: 20;">METHOD</th>
                <th style="text-align: left; width: 20;">CUSTOMER</th>
                <th style="text-align: right; width: 20;">PAYOUT AMOUNT</th>
                <th style="text-align: right; width: 20;">SERVICE CHARGE</th>
                <th style="text-align: right; width: 20;">OTHER CHARGE</th>
                <th style="text-align: right; width: 20;">TAX</th>
                <th style="text-align: right; width: 20;">TOTAL</th>
            </tr>
        </thead>
        <tbody>
            @foreach($_slot as $slot)
            <tr>
                <td>{{ date("m/d/Y") }}</td>
                <td>{{ $slot->slot_no }}</td>
                <td>BANK DEPOSIT</td>
                <td>{{ $slot->first_name }} {{ $slot->last_name }}</td>
                <td>{{ $slot->real_net }}</td>
                <td>{{ $slot->real_service }}</td>
                <td>{{ $slot->real_other }}</td>
                <td>{{ $slot->real_tax }}</td>
                <td>{{ $slot->real_encash }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</html>