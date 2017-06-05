<form class="global-submit form-horizontal" role="form" action="{{$action}}" id="confirm_answer" method="post">
    {!! csrf_field() !!}
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">{{$item_details->item_name}}</h4>
    </div>
    <div class="modal-body add_new_package_modal_body clearfix">
        <input type="hidden" name="item_id" value="{{$item_details->item_id}}">
        <input type="hidden" name="sir_id" value="{{$item_details->sir_id}}">
        <div class="form-group">
            <div class="col-xs-4">
                <h4> U/M </h4>
            </div>
            <div class="col-xs-8">
                <select class="1111 tablet-droplist-um form-control" name="invline_um[]">
                    @if($item_details)
                        @include("member.load_ajax_data.load_one_unit_measure", ['item_um_id' => $item_details->multi_um_id, 'selected_um_id' => $item_details->multi_id])
                    @else
                        <option class="hidden" value="" />
                    @endif
                </select>
            </div>
        </div>
        <div class="form-group">
            <div class="col-xs-4">
                <h4> Quantity </h4>
            </div>        
            <div class="col-xs-8">
                <input type="text" class="form-control input-sm text-right tablet-item-qty tablet-compute" value="1" name="invline_qty">
            </div>
        </div>
        <div class="form-group">
            <div class="col-xs-4">
                <h4> Rate </h4>
            </div>        
            <div class="col-xs-8">
                <input type="text" style="text-align: right; border: 0;border-bottom: 1px solid #000;outline: 0;" class="form-control input-sm tablet-item-rate tablet-compute" name="invline_rate" value="{{number_format($item_details->item_price,2)}}">
            </div>
        </div>
        <div class="form-group">
            <div class="col-xs-4">
                <h4> Discount </h4>
            </div>        
            <div class="col-xs-8">
                <input type="text" class="form-control text-right input-sm tablet-item-disc tablet-compute" name="">
            </div>
        </div>
        <div class="form-group">
            <div class="col-xs-4">
                <h4> Remark </h4>
            </div>        
            <div class="col-xs-8">
                <input type="text" class="form-control input-sm" name="">
            </div>
        </div>
        <div class="form-group">
            <div class="col-xs-4">
                <h4> Amount </h4>
            </div>        
            <div class="col-xs-8 text-right">
                <h3 class="tablet-item-amount"></h3>
            </div>
        </div>
        <div class="form-group">
            <div class="col-xs-12">
                <h4> Description </h4>
            </div>        
            <div class="col-xs-12">
                <textarea class="form-control input-sm"></textarea>
            </div>
        </div>
        <div class="form-group">
            <div class="col-xs-12">
                <input type="checkbox" name="taxable" value="1"> <span>Taxable</span>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <div class="col-md-4 col-xs-4"><button data-dismiss="modal" class="btn btn-custom-white form-control">Cancel</button></div>
        <div class="col-md-4 col-xs-4"><button class="btn btn-custom-white form-control">Remove</button></div>
        <div class="col-md-4 col-xs-4"><button type="submit" class="btn btn-custom-blue form-control">Done</button></div>
    </div>
</form>
<script type="text/javascript">
    customer_invoice.iniatilize_select();
    customer_invoice.event_tablet_compute_class_change();
    customer_invoice.action_compute_tablet();
</script>