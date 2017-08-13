<table class="table table-bordered table-condensed custom-column-table">
    <thead>
        <tr>
            <th colkey="slot_no" class="text-center">SLOT NO</th>
            <th colkey="slot_owner" class="text-center">SLOT OWNER</th>
            <th colkey="sponsor" class="text-center">SPONSOR</th>
            <th colkey="placement" default="hide" class="text-center">PLACEMENT</th>
            <th colkey="membership" default="hide" class="text-center">MEMBERSHIP</th>
            <th colkey="binary_left" default="hide" class="text-center">BINARY<BR>LEFT</th>
            <th colkey="binary_right" default="hide" class="text-center">BINARY<BR>RIGHT</th>
            <th colkey="date_created" class="text-center">DATE<br>CREATED</th>
            <th colkey="time_created" class="text-center">TIME<br>CREATED</th>
            <th colkey="earnings" class="text-right">EARNINGS</th>
            <th colkey="payout" class="text-right">PAYOUT</th>
            <th colkey="current_gc" default="hide" class="text-right">CURRENT GC</th>
            <th colkey="current_wallet" class="text-right">CURRENT<br>WALLET</th>
        </tr>
    </thead>
    <tbody>
        @if(!isset($_slot))
            <tr>
                <td class="text-center" colspan="9">NO SLOT YET</td>
            </tr>
        @else
            @foreach($_slot as $key => $slot)
            <tr>
                <td colkey="slot_no" class="text-center">{{ $slot->slot_no }}</td>
                <td colkey="slot_owner" class="text-center">{{ strtoupper($slot->last_name) }}, {{ strtoupper($slot->first_name) }} {{ strtoupper($slot->middle_name) }}</td>
                <td colkey="sponsor" class="text-center">{!! $slot->sponsor_button !!}</a></td>
                <td colkey="placement" class="text-center">{!! $slot->placement_button !!}</a></td>
                <td colkey="membership" class="text-center">{!! $slot->membership_name !!}</a></td>
                <td colkey="binary_left" class="text-center">{!! number_format($slot->slot_binary_left, 2) !!}</a></td>
                <td colkey="binary_right" class="text-center">{!! number_format($slot->slot_binary_right, 2) !!}</a></td>
                <td colkey="date_created" class="text-center">{{ date("F d, Y", strtotime($slot->slot_created_date)) }}</td>
                <td colkey="time_created" class="text-center">{{ date("h:i A", strtotime($slot->slot_created_date)) }}</td>
                <td colkey="earnings" class="text-right">{!! $slot->total_earnings_format !!}</td>
                <td colkey="payout" class="text-right">{!! $slot->total_payout_format !!}</td>
                <td colkey="current_gc" class="text-right">{!! $slot->total_gc_format !!}</td>
                <td colkey="current_wallet" class="text-right">{!! $slot->current_wallet_format !!}</td>
            </tr>
            @endforeach
        @endif
    </tbody>
    <tfoot>
        <tr>
            <td colkey="slot_no" class="text-center"></td>
            <td colkey="slot_owner" class="text-center"></td>
            <td colkey="sponsor" class="text-center"></a></td>
            <td colkey="placement" class="text-center"></a></td>
            <td colkey="membership" class="text-center"></a></td>
            <td colkey="binary_left" class="text-center"></a></td>
            <td colkey="binary_right" class="text-center"></a></td>
            <td colkey="date_created" class="text-center"></td>
            <td colkey="time_created" class="text-center"></td>
            <td colkey="earnings" class="text-right text-bold"><a href="javascript:">{{ $total_slot_earnings }}</a></td>
            <td colkey="payout" class="text-right text-bold"><a href="javascript:">{{ $total_payout }}</a></td>
            <td colkey="current_gc" class="text-right text-bold"><a href="javascript:">PHP 0.00</a></td>
            <td colkey="current_wallet" class="text-right text-bold"><a href="javascript:">{{ $total_slot_wallet }}</a></td>
        </tr>
    </tfoot>
</table>

<div class="pull-right paginat">{!! $_slot_page->render() !!}</div>