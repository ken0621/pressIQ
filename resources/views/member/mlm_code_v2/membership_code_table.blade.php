<table class="table table-bordered table-striped table-condensed">
    <thead style="text-transform: uppercase">
        <tr>
            <th class="text-center" width="100px">Pin No.</th>
            <th class="text-center" width="200px">Activation</th>
            <th class="text-center" width="200px">Membership</th>
            <th class="text-center" width="250px">Membership Kit</th>
            <th class="text-center"></th>
            <th class="text-center"></th>
            <th class="text-center"></th>
            <th class="text-center"></th>
        </tr>
    </thead>
    <tbody>
        @if(count($_assembled_item_kit) > 0)
        @foreach($_assembled_item_kit as $item)
        <tr>
            <td class="text-center">{{$item->mlm_pin}}</td>
            <td class="text-center">{{$item->mlm_activation}}</td>
            <td class="text-center">{{$item->membership_name}}</td>
            <td class="text-center">{{$item->item_name}}</td>
            <td class="text-center"><a size="md" class="popup" link="/member/mlm/code2/change_status?action=reserved&item_id={{$item->item_id}}&record_id={{$item->record_log_id}}">Reserve</a></td>
            <td class="text-center"><a href="">Use Code</a></td>
            <td class="text-center"><a size="md" class="popup" link="/member/mlm/code2/disassemble?record_id={{$item->record_log_id}}">Disassemble</a></td>
            <td class="text-center"><a size="md" class="popup" link="/member/mlm/code2/change_status?action=block&item_id={{$item->item_id}}&record_id={{$item->record_log_id}}">Block Code</a></td>
        </tr>
        @endforeach
        @else
        <tr>
            <td class="text-center" colspan="8"> NO MEMBERSHIP CODE YET</td>
        </tr>
        @endif
        <!--  <tr>
            <td class="text-center">1</td>
            <td class="text-center">AT4YM1BU</td>
            <td class="text-center">GOLD</td>
            <td class="text-center">GOLD KIT A</td>
            <td class="text-center"><a href="">Reserve</a></td>
            <td class="text-center"><a href="">Use Code</a></td>
            <td class="text-center"><a href="">Disassemble</a></td>
            <td class="text-center"><a href="">Block Code</a></td>
        </tr>  -->
    </tbody>
</table>
<div class="pull-right">{!! $_assembled_item_kit->render() !!}</div>