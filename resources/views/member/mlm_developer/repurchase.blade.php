
<form class="global-submit form-horizontal" role="form" action="/member/mlm/developer/repurchase" method="post">
    {{ csrf_field() }}
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">×</button>
        <h4 class="modal-title">CREATE MLM SLOT FOR TESTING</h4>
    </div>
    <div class="modal-body clearfix">
         <div class="form-group">
            <div class="col-md-12">            
                <label>PURCHASE BY (SLOT NO.)</label>
                <input name="sponsor" type="text" class="form-control" placeholder="RANDOM (IF EMPTY)">
            </div>
        </div>

        @if($unilevel == 1)
        <div class="form-group">
            <div class="col-md-6">            
                <label>PERSONAL PV</label>
                <input name="sponsor" type="text" class="form-control" placeholder="100 (IF EMPTY)">
            </div>
            <div class="col-md-6">            
                <label>GROUP PV</label>
                <input name="sponsor" type="text" class="form-control" placeholder="100 (IF EMPTY)">
            </div>
        </div>
        @endif

        @if($binary_repurchase == 1)
        <div class="form-group">
            <div class="col-md-12">            
                <label>BINARY PV</label>
                <input name="sponsor" type="text" class="form-control" placeholder="1.00 (IF EMPTY)">
            </div>
        </div>
        @endif
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-def-white btn-custom-white" data-dismiss="modal">Close</button>
        <button class="btn btn-primary btn-custom-primary" type="submit">Create Re-Purchase</button>
    </div>
</form>