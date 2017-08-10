<table class="table table-bordered table-condensed">
    <thead>
        <tr>
            <th class="text-center">SLOT NO</th>
            <th class="text-center">SLOT OWNER</th>
            <th class="text-center">SPONSOR</th>
            @if($binary_enabled == 1 && $binary_auto == 0)
            <th class="text-center">PLACEMENT</th>
            @endif
            <th class="text-center">DATE<br>CREATED</th>
            <th class="text-center">TIME<br>CREATED</th>
            <th class="text-right">EARNINGS</th>
            <th class="text-right">PAYOUT</th>
            <th class="text-right">CURRENT<br>WALLET</th>
        </tr>
    </thead>
    <tbody class="table-warehouse">
        @if(!isset($_slot))
            <tr>
                <td class="text-center" colspan="7">NO SLOT YET</td>
            </tr>
        @else
            @foreach($_slot as $key => $slot)
            <tr>
                <td class="text-center">{{ $slot->slot_no }}</td>
                <td class="text-center">{{ strtoupper($slot->last_name) }}, {{ strtoupper($slot->first_name) }} {{ strtoupper($slot->middle_name) }}</td>
                <td class="text-center">{!! $slot->sponsor_button !!}</a></td>
                @if($binary_enabled == 1 && $binary_auto == 0)
                <td class="text-center">{!! $slot->placement_button !!}</a></td>
                @endif
                <td class="text-center">{{ date("F d, Y", strtotime($slot->slot_created_date)) }}</td>
                <td class="text-center">{{ date("h:i A", strtotime($slot->slot_created_date)) }}</td>
                <td class="text-right">{!! $slot->total_earnings_format !!}</td>
                <td class="text-right">{!! $slot->total_payout_format !!}</td>
                <td class="text-right">{!! $slot->current_wallet_format !!}</td>
            </tr>
            @endforeach
        @endif
    </tbody>
    <tfoot>
        <tr>
            <td colspan="{{ (($binary_enabled == 1 && $binary_auto == 0) ? '6' : '5') }}" class="text-left"><b>{{ $slot_count }}</b> SLOT(S) ON RECORD</td>
            <td class="text-right text-bold"><a href="javascript:">{{ $total_slot_earnings }}</a></td>
            <td class="text-right text-bold"><a href="javascript:">{{ $total_payout }}</a></td>
            <td class="text-right text-bold"><a href="javascript:">{{ $total_slot_wallet }}</a></td>
        </tr>
    </tfoot>
</table>

<div class="pull-right paginat">{!! $_slot_page->render() !!}</div>