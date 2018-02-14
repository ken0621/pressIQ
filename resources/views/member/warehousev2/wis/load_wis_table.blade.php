
<div class="form-group tab-content panel-body wis-container">
    <div id="all" class="tab-pane fade in active wis-table">
        <div class="table-responsive">
            <table class="table table-bordered table-condensed">
                <thead>
                    <tr>
                        <th class="text-center">TRANSACTION NUMBER</th>
                        <th class="text-center">TOTAL ISSUED INVENTORY</th>
                        @if($status== 'confirm')
                        <th class="text-center">RECEIVER CODE</th>
                        @endif
                        @if($status == 'received')
                        <th class="text-center">TOTAL RECEIVED INVENTORY</th>
                        <th class="text-center">TOTAL REMAINING INVENTORY</th>
                        @endif
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @if(count($_wis) > 0)
                        @foreach($_wis as $wis)
                        <tr>
                            <td class="text-center">{{$wis->wis_number}}</td>
                            <td class="text-center">{{$wis->issued_qty}} pc(s)</td>
                            @if($wis->wis_status == 'confirm')
                            <td class="text-center">{{$wis->receiver_code}}</td>
                            @endif
                            @if($wis->wis_status == 'received')
                            <td class="text-center">{{$wis->total_received_qty}} pc(s)</td>
                            <td class="text-center">{{$wis->issued_qty - $wis->total_received_qty}} pc(s)</td>
                            @endif

                            <td class="text-center">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-sm btn-custom-white dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Action <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-custom">
                                        <li ><a href="/member/item/warehouse/wis/print/{{$wis->wis_id}}"> Print </a></li>

                                        @if($wis->wis_status == 'pending')
                                        <li><a class="popup" link="/member/item/warehouse/wis/confirm/{{$wis->wis_id}}" size="md">Confirm</a></li>
                                        @endif
                                        @if($wis->wis_status == 'confirm')
                                        <li><a href="/member/item/warehouse/rr/receive-items/{{$wis->wis_id}}">Receive</a></li>
                                        @endif
                                    </ul>
                                </div>
                            </td>
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