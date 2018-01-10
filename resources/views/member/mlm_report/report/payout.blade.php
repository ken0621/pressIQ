<table class="table table-bordered table-striped table-condensed">
    <thead style="text-transform: uppercase">
        <tr>
            @if(count($table)!=0)
            <th class="text-center">Item Id</th>
            <th class="text-center">Item Name</th>
            <th class="text-center">Item Description</th>
            <th class="text-center">Redeemable Points</th>
            <!-- <th class="text-center">Shop Id</th> -->
            <th class="text-center"></th>
            @else
            <tr>
                <th class="text-center" colspan="5">NO DATA</th>
            </tr>
            @endif
        </tr>
    </thead>
    <tbody>
        @foreach($table as $t)
        <tr id="{{ $redeemable->item_redeemable_id }}">
            <td class="text-center"></td>
            <td class="text-center"></td>
            <td class="text-center"></td>
            <td class="text-center"></td>
            <!-- <td class="text-center">{{ $redeemable->shop_id }}</td> -->
        </tr>
        @endforeach
    </tbody>
</table>