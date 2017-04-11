<form class="global-submit" role="form" action="/member/ecommerce/coupon/generate-code" method="POST" >
    <input type="hidden" name="_token" value="{{csrf_token()}}" >
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title layout-modallarge-title item_title">Generate Coupon Code</h4>
    </div>

    <div class="modal-body modallarge-body-layout background-white form-horizontal menu_container">
        <div class="panel-body form-horizontal">
            <div class="row clearfix">
                <div class="col-md-12">
                    <!-- START CONTENT -->
                    <div class="form-group">
                        <div class="col-md-6">
                           <label>Coupon Amount</label>
                           <input type="text" class="form-control input-sm" name="coupon_amount" value="">                    
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <div class="col-md-6">
                            <label>Coupon Type</label>
                            <select class="form-control input-sm" name="coupon_amount_type" value="">
                                <option value="fixed">Fixed</option>
                                <option value="percentage">Percentage</option>
                            </select>
                        </div>
                    </div>
                    <!-- END CONTENT -->
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer" >
        <button type="button" class="btn btn-custom-white" data-dismiss="modal">Cancel</button>
        <button class="btn btn-custom-primary btn-save-modallarge" type="submit" data-url="">Save</button>
    </div>
</form>