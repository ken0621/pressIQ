
<div class="form-group tab-content panel-body wis-container">
    <div id="all" class="tab-pane fade in active wis-table">
        <div class="table-responsive">
            <table class="table table-bordered table-condensed">
                <thead>
                    <tr>
                        <th class="text-center">#</th>
                        <th class="text-center">SLIP NO.</th>
                        <th class="text-center">TOTAL ISSUED INVENTORY</th>
                        @if($status== 'confirm')
                        <th class="text-center">RECEIVER CODE</th>
                        @endif
                        @if($status == 'received')
                        <th class="tex
                        t-center">TOTAL RECEIVED INVENTORY</th>
                        <th class="text-center">TOTAL REMAINING INVENTORY</th>
                        @endif
                        @if($status == 'pending')
                        <th></th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @if(count($_wis) > 0)
                        @foreach($_wis as $wis)
                        <tr>
                            <td class="text-center">{{$wis->wis_id}}</td>
                            <td class="text-center">{{$wis->wis_number}}</td>
                            <td class="text-center">{{$wis->issued_qty}}</td>
                            @if($wis->wis_status == 'confirm')
                            <td class="text-center">{{$wis->receiver_code}}</td>
                            @endif
                            @if($wis->wis_status == 'received')
                            <td class="text-center">{{$wis->total_received_qty}}</td>
                            <td class="text-center">{{$wis->total_remaining_qty}}</td>
                            @endif

                            @if($wis->wis_status == 'pending')
                            <td>
                                
                            </td>
                            @endif
                        </tr>
                        @endforeach
                    @else
                    <tr>
                        <td class="text-center" colspan="7">NO PROCESS YET</td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>