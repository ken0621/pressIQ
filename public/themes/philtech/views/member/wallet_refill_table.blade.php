<table class="table table-bordered table-striped table-condensed">
    <thead style="text-transform: uppercase">
        @if(count($refills)>0)
        <tr>
            <th class="text-center">Date Requested</th>
            @if($status!=0)
                @if($status==1)
                <th class="text-center">Date Approved</th>
                @else if($status==2)
                <th class="text-center">Date Rejected</th>
                @endif
            @endif
            <th class="text-center">Refill Amount</th>
            <th class="text-center" width="120px">Amount Paid</th>
            <th class="text-center" width="120px">Remark</th>
        </tr>
        @else
        <tr>
            <th class="text-center" colspan="5">No Data</th>
        </tr>
        @endif
    </thead>
    <tbody>
        @foreach($refills as $refill)
        <tr>
            <td class="text-center">{{$refill->wallet_log_refill_date}}</td>
            @if($status!=0)
            <td class="text-center">{{$refill->wallet_log_refill_date_approved}}</td>
            @endif
            <td class="text-center">{{$refill->wallet_log_refill_amount}}</td>
            <td class="text-center">{{$refill->wallet_log_refill_amount_paid}}</td>
            <td class="text-center" width="300px">
                @if($refill->wallet_log_remarks!="")
                {{$refill->wallet_log_remarks}}
                @else
                {{"No Remarks"}}
                @endif
            </td>
        </tr>
        @endforeach
    </tbody>
</table>