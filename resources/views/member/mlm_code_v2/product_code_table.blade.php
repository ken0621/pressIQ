<div class="table-responsive">
    <table class="table table-bordered table-striped table-condensed">
        <thead style="text-transform: uppercase">
            <tr>
               
                    <th class="text-center">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="select-all">
                        </div>
                    </th>
               
                <th class="text-center" width="200px">Pin No.</th>
                <th class="text-center" width="250px">Activation</th>
                <th class="text-center" width="250px">Item Name</th>
                <th class="text-center"></th>
                @if(Request::input('status') != 'block')
                <th class="text-center"></th>
                <th class="text-center"></th>
                <th class="text-center"></th>
                @endif
            </tr>
        </thead>
        <tbody>
            @foreach($_item_product_code as $item)


            <tr>
                
                    <td class="text-center">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input select-id" id="select-id" name="selected[]" value="{{ $item->record_log_id }}">
                        </div>
                    </td>
                
                <td class="text-center">{{$item->mlm_pin}}</td>
                <td class="text-center">{{$item->mlm_activation}}</td>
                <td class="text-center">{{$item->item_name}}</td>
                
                @if($item->item_in_use == 'unused')
                    @if($item->record_consume_ref_name != 'block')
                        @if($item->record_consume_ref_name == 'reserved')
                        <td class="text-center">{{ucwords($item->first_name.' '.$item->middle_name.' '.$item->last_name)}} {{$item->record_consume_ref_id != 0 ? ' - ' : ''}} <a size="md" class="popup" link="/member/mlm/code2/change_status?action=cancel_reservation&item_id={{$item->item_id}}&record_id={{$item->record_log_id}}">Cancel Reservation</a></td>
                        @else
                        <td class="text-center"><a size="md" class="popup" link="/member/mlm/code2/change_status?action=reserved&item_id={{$item->item_id}}&record_id={{$item->record_log_id}}">Reserve</a></td>
                        @endif
                    @endif
    
                   <!--  @if($item->record_inventory_status == 0)
                    <td class="text-center"><a href="">Use Code</a></td>
                    @else -->
                   <!--  <td class="text-center"></td>
                    @endif -->
                    @if($item->record_consume_ref_name == 'block')
                    <td class="text-center"><a size="md" class="popup" link="/member/mlm/code2/change_status?action=unblock_code&item_id={{$item->item_id}}&record_id={{$item->record_log_id}}">Unblock Code</a></td>
                    @else
                    <td class="text-center"><a size="md" class="popup" link="/member/mlm/code2/change_status?action=block&item_id={{$item->item_id}}&record_id={{$item->record_log_id}}">Block Code</a></td>
                    @endif
                @else
                <td class="text-center" colspan="5"><a href="javascript:">{{$item->used_by}}</a></td>
                @endif
                {{-- @if(Request::input('status') == "unused" || Request::input('status') == '') --}}
                
                @if($item->record_consume_ref_name != 'block')
                    @if($item->item_in_use == 'unused')
                    <td class="text-center">
                        @if($item->released)
                            Released
                        @else
                            <a href="javascript:" class="popup" size="md" link="/member/mlm/product_code2/release?id={{ $item->record_log_id }}">Release</a>
                        @endif
                    </td>
                    <td class="text-center">
                        @if($item->distributed)
                            Activated
                        @else                        
                            <a href="javascript:" class="popup" size="md" link="/member/mlm/product_code2/distribute?id={{ $item->record_log_id }}">Activate</a>
                        @endif
                    </td>
                    @endif
                @endif

            </tr>
            @endforeach
            <!--  <tr>
                <td class="text-center">1</td>
                <td class="text-center">AT4YM1BU</td>
                <td class="text-center">GOLD</td>
                <td class="text-center">GOLD KIT A</td>
                <td class="text-center"><a href="">Use Code</a></td>
                <td class="text-center"><a href="">Block Code</a></td>
            </tr> -->
        </tbody>
    </table>
</div>
<div class="pull-right">{!! $_item_product_code->render() !!}</div>




