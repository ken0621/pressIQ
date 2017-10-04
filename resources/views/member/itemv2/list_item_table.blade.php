@if(count($_item) > 0)

<table class="table table-bordered table-striped table-condensed">
    <thead style="text-transform: uppercase">
        <tr>
            @foreach($_item[0] as $column)
            <th class="text-center">{{ $column["label"] }}</th>
            @endforeach
            <th class="text-left" width="170px"></th>
        </tr>
    </thead>
    <tbody>
        @foreach($_item as $item)
        <tr>
            @foreach($item as $column)
            <td class="text-center">{{ $column["data"] }}</td>
            @endforeach
            <td class="text-center">
                <div class="btn-group">
                    <button type="button" class="btn btn-sm btn-custom-white dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Action <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-custom">
                        <li>
                            <a onclick="action_load_link_to_modal('/member/item/v2/edit?item_id={{ $column["default"]->item_id }}', 'lg')">
                                <div style="display: inline-block; width: 17px; text-align: center;"><i class="fa fa-edit"></i> &nbsp;</div>
                                Modify
                            </a>
                        </li>
                        <li>
                            <a href="javascript:" class="item-{{ $archive }}" item-id="{{ $column["default"]->item_id }}">
                                <div style="display: inline-block; width: 17px; text-align: center;"><i class="fa fa-trash"></i> &nbsp;</div>
                                <span style="text-transform: capitalize;">{{ $archive }}</span>
                            </a>
                        </li>
                        <li>
                            <a href="javascript:">
                                <div style="display: inline-block; width: 17px; text-align: center;"><i class="fa fa-info"></i> &nbsp;</div>
                                Item Information
                            </a>
                        </li>
                        @if($column["default"]->item_type_id == 1)
                        <li>
                            <a onclick="action_load_link_to_modal('/member/item/v2/refill_item?item_id={{ $column["default"]->item_id}}','md')">
                                <div style="display: inline-block; width: 17px; text-align: center;"><i class="fa fa-cubes"></i> &nbsp;</div>
                                Refill Item
                            </a>
                        </li>
                        @endif
                    </ul>
                </div>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
<div class="pull-right">{!! $pagination !!}</div>
@else
<div style="padding: 100px; text-align: center;">NO DATA YET</div>
@endif