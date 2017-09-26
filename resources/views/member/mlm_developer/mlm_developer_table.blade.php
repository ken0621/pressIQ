<table class="table table-bordered table-condensed custom-column-table">
    <thead>
        <tr>
            @foreach($_slot[0] as $column)
            <th class="text-center">{{ $column["label"] }}</th>
            @endforeach
        </tr>
    </thead>
    <tbody>
        @if(!isset($_slot))
            <tr>
                <td class="text-center" colspan="9">NO SLOT YET</td>
            </tr>
        @else
        @foreach($_slot as $slot)
            <tr>
                @foreach($slot as $column)
                <td class="text-center">{!! $column["data"] !!}</td>
                @endforeach
            @endforeach
        @endif
    </tbody>
    <tfoot>
<!--         <tr>
            <td colkey="slot_no" class="text-center"></td>
            <td colkey="slot_owner" class="text-center"></td>
            <td colkey="sponsor" class="text-center"></a></td>
            <td colkey="placement" class="text-center"></a></td>
            <td colkey="membership" class="text-center"></a></td>
            <td colkey="binary_left" class="text-center"></a></td>
            <td colkey="binary_right" class="text-center"></a></td>
            <td colkey="brown_current_rank" class="text-center"></a></td>
            <td colkey="brown_next_rank" class="text-center"></a></td>
            <td colkey="brown_next_rank_requirements" class="text-center"></a></td>
            <td colkey="brown_builder_points" class="text-center"></a></td>
            <td colkey="brown_leader_points" class="text-center"></a></td>
            <td colkey="date_created" class="text-center"></td>
            <td colkey="time_created" class="text-center"></td>
            <td colkey="earnings" class="text-right text-bold"><a href="javascript:">{{ $total_slot_earnings }}</a></td>
            <td colkey="payout" class="text-right text-bold"><a href="javascript:">{{ $total_payout }}</a></td>
            <td colkey="current_gc" class="text-right text-bold"><a href="javascript:">PHP 0.00</a></td>
            <td colkey="current_wallet" class="text-right text-bold"><a href="javascript:">{{ $total_slot_wallet }}</a></td>
        </tr> -->
    </tfoot>
</table>

<div class="pull-right paginat">{!! $_slot_page->render() !!}</div>