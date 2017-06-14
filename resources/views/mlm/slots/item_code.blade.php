<form id="bank-form" class="global-submit" method="POST" action="/mlm/slots/item_code_post">
    {!! csrf_field() !!}
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title layout-modallarge-title">Code</h4>
    </div>
    <div class="modal-body max-450 modallarge-body-layout background-white">
        <div class="form-group">
                <label>Product Code</label>
                <input type="text" class="form-control" value="{{$item->item_activation_code}}" readonly>
                <input type="hidden" class="form-control" name="item_activation_code" value="{{$item->item_activation_code}}">
        </div>
        <div class="form-group">
                <label>Use to slot</label>
                <select name="slot_id" class="form-control">
                    @foreach($_slot as $slot)
                        <option value="{{$slot->slot_id}}">{{$slot->slot_no}} ({{$slot->membership_name}})</option>
                    @endforeach
                </select>
        </div>
        <div class="form-group">
            @if($item->UNILEVEL != 0)
                Unilevel: {{$item->UNILEVEL}}
            @endif
        </div>
        <div class="form-group">
            @if($item->STAIRSTEP != 0)
                Stairstep: {{$item->STAIRSTEP}}
            @endif
        </div>
        <div class="form-group">
            @if($item->REPURCHASE_POINTS != 0)
                 Repurchase Points: {{$item->REPURCHASE_POINTS}}
            @endif
        </div>
    </div>
    <div class="modal-footer">
        <div class="error-modal text-center"></div>
        <button type="button" class="btn btn-custom-white " data-dismiss="modal">Cancel</button>
        <button class="btn btn-custom-primary btn-save-modallarge" type="submit">Use Code</button>
    </div>
</form>