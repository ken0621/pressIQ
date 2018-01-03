 <tr class="{{$tr_class}}">
    <td> 
      <span {!!$margin_left!!}><i class="fa fa-caret-down toggle-warehouse margin-right-10 cursor-pointer" data-content="{{$warehouse->warehouse_id}}"></i> {{$warehouse->warehouse_name}} </span></td>
    <td class="text-center">
        <div class="btn-group">
          <button type="button" class="btn btn-sm btn-custom-white dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Action <span class="caret"></span>
          </button>
          <ul class="dropdown-menu dropdown-menu-custom">
            <li><a size="lg" link="/member/item/warehouse/view/{{$warehouse->warehouse_id}}" href="javascript:" class="popup">View Warehouse</a></li>
            <li><a href="/member/item/v2/warehouse/refill?warehouse_id={{$warehouse->warehouse_id}}" >Refill  Warehouse</a></li>
            <li><a href="javascript:" class="popup" link="/member/item/v2/warehouse/edit/{{$warehouse->warehouse_id}}" size="lg" data-toggle="modal" data-target="#global_modal">Edit</a></li>
          </ul>
        </div>
    </td>
</tr>