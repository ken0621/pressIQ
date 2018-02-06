
<div class="form-group tab-content panel-body customer-wis-container">
    <div id="all" class="tab-pane fade in active customer-wis-table">
        <div class="table-responsive">
            <table class="table table-bordered table-condensed">
                <thead>
                    <tr>
                        <th class="text-center">SLIP NO.</th>
                        <th class="text-center">CUSTOMER</th>
                        <th class="text-center">DELIVERY DATE</th>
                        <th class="text-center">TOTAL ISSUED INVENTORY</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @if(count($_cust_wis) > 0)
                        @foreach($_cust_wis as $wis)
                        <tr>
                            <td class="text-center">{{$wis->transaction_refnum}}</td>
                            <td class="text-center">{{$wis->company != '' ? $wis->company : ($wis->title_name.' '.$wis->first_name.' '.$wis->middle_name.' '.$wis->last_name)}}</td>
                            <td class="text-center">{{date('F d, Y',strtotime($wis->cust_delivery_date))}}</td>
                            <td class="text-center">{{$wis->issued_qty}} pc(s)</td>
                            <td class="text-center">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-sm btn-custom-white dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Action <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-custom">
                                        <li ><a href="/member/customer/wis/print/{{$wis->cust_wis_id}}"> Print </a></li>
                                        @if($wis->cust_wis_status == 'pending')
                                        <li><a class="popup" link="/member/customer/wis/confirm/{{$wis->cust_wis_id}}" size="md">Confirm</a></li>
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