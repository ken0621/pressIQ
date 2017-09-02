@if(count($_item) > 0)

<table class="table table-bordered table-striped table-condensed">
    <thead style="text-transform: uppercase">
        <tr>
            <th class="text-center" width="70px;">ITEM ID</th>
            <th class="text-center">SKU</th>
            <th class="text-center" width="150px">Price</th>
            <th class="text-center" width="150px">Cost</th>
            <th class="text-center" width="150px">Markup</th>
            <th class="text-center" width="100px">Inventory</th>
            <th class="text-center" width="60px">U/M</th>
            <th class="text-left" width="170px"></th>
        </tr>
    </thead>
    <tbody>
        @foreach($_item as $item)
        <tr>
            <td class="text-center">{{ $item->item_id }}</td>
            <td class="text-center">{{ $item->item_sku }}</td>
            <td class="text-center">{{ $item->display_price }}</td>
            <td class="text-center">{{ $item->display_cost }}</td>
            <td class="text-center">{{ $item->display_markup }}</td>
            @if($item->item_type_id == 1)
                <td class="text-center">{{ $item->inventory_count }}</td>
                @if($item->multi_abbrev == "")
                    <td class="text-center">N/A</td>
                @else
                    <td class="text-center"><a href="javascript:">{{ $item->multi_abbrev }}</a></td>
                @endif 
            @else
                <td class="text-center">N/A</td>
                <td class="text-center">N/A</td>
            @endif
            <td class="text-center">
                <div class="btn-group">
                    <button type="button" class="btn btn-sm btn-custom-white dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Action <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-custom">
                        <li>
                            <a onclick="action_load_link_to_modal('/member/item/v2/add?item_id={{ $item->item_id }}', 'lg')">
                                <div style="display: inline-block; width: 17px; text-align: center;"><i class="fa fa-edit"></i> &nbsp;</div>
                                Modify
                            </a>
                        </li>
                        <li>
                            <a href="javascript:">
                                <div style="display: inline-block; width: 17px; text-align: center;"><i class="fa fa-trash"></i> &nbsp;</div>
                                Archive
                            </a>
                        </li>
                        <li>
                            <a href="javascript:">
                                <div style="display: inline-block; width: 17px; text-align: center;"><i class="fa fa-info"></i> &nbsp;</div>
                                Item Information
                            </a>
                        </li>
                    </ul>
                </div>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
<div class="pull-right">{!! $_item_raw->render() !!}</div>
@else
<div style="padding: 100px; text-align: center;">NO DATA YET</div>
@endif