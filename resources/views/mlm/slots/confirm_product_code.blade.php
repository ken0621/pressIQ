<form class="global-submit" method="POST" action="/mlm/slot/use_product_code/confirmation/used">
    <input type="hidden" value="{{csrf_token()}}" name="_token">
    <input type="hidden" value="{{$mlm_pin}}" name="mlm_pin">
    <input type="hidden" value="{{$mlm_activation}}" name="mlm_activation">
    <input type="hidden" value="{{$slot_no}}" name="slot_no">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title layout-modallarge-title">Confirmation</h4>
    </div>
    <div class="modal-body modallarge-body-layout background-white">
        <div class="form-horizontal">
            <div class="form-group">
                <div class="col-md-12 text-center">
                   <h3>{!! $message !!}</h3>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-custom-white " data-dismiss="modal">Cancel</button>
        <button class="btn btn-primary " type="submit">Confirm</button>
    </div>
</form>
<script type="text/javascript">
    function success_confirm(data) 
    {
        if(data.status == 'success')
        {
            action_load_link_to_modal('/mlm/slot/use_product_code/to_slot?mlm_pin='+data.mlm_pin+'&mlm_activation='+data.mlm_activation, 'md');
        }
    }
</script>