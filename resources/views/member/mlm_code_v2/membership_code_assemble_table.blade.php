<table class="table table-bordered table-striped table-condensed">
    <thead style="text-transform: uppercase">
        <tr>
            <th class="text-center">Item Name</th>
            <th class="text-center">Stocks</th>
            <th class="text-center" width="120px">Required</th>
        </tr>
    </thead>
    <tbody>


    	@foreach($_item as $item)
        <tr>
            <td class="text-center">{{ $item->item_sku }}</td>
            <td class="text-center">{{ $item->item_quantity }}</td>
            <td class="text-center">{!! $item->required !!}</td>
        </tr>
        @endforeach
    </tbody>
</table>

<input type="hidden" class="allowed-assembly" value="{{ $allowed }}">