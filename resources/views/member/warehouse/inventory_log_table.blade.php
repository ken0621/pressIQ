
<table class="table table-bordered table-condensed">
    <thead>
        <tr>
            <th>#</th>
            <th class="text-center">Item Name</th>
            <th class="text-center">Warehouse Name</th>
            <th>Inventory Count</th>
            <th>Date</th>
            <th></th>
        </tr>
    </thead>
    <tbody class="table-warehouse">
        @if($_inventory_log != null)
        @foreach($_inventory_log as $inventory_log)
        @if($inventory_log->serial_id == null)
        <tr>
            <td>{{$inventory_log->inventory_id}}</td>
            <td class="text-center">{{$inventory_log->item_name}}</td>
            <td>{{$inventory_log->warehouse_name}}</td>
            <td>{{$inventory_log->inventory_count}}</td>
            <td>{{date("M d, Y g:i a",strtotime($inventory_log->inventory_created))}}</td>
            <td class="text-center">
                <div class="btn-group">
                    <button type="button" class="btn btn-sm btn-custom-white dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Action <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-custom">
                        <li><a size="lg" link="/member/item/add_serial?inventory_id={{$inventory_log->inventory_id}}" href="javascript:" class="popup">Add Serial to this Item</a></li>
                    </ul>
                </div>
            </td>
        </tr>
        @endif
        @endforeach
        @endif
    </tbody>
</table>
<div class="text-center pull-right">
    {!!$_inventory_log->render()!!}
</div>