<form class="global-submit" role="form" action="/member/ecommerce/coupon/generate-code" method="POST" >
    <input type="hidden" name="_token" value="{{csrf_token()}}" >
    <input type="text" name="coupon_id" value="{{$coupon->coupon_code_id or ''}}" >
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title layout-modallarge-title item_title">Generate Coupon Code</h4>
    </div>

    <div class="modal-body modallarge-body-layout background-white form-horizontal menu_container">
        <div class="panel-body form-horizontal">
            <div class="row clearfix">
                <div class="col-md-12">
                    <!-- START CONTENT -->
                    @if(isset($coupon))
                        <div class="form-group">
                            <div class="col-md-12">
                               <label>Coupon Code</label>
                               <input type="text" class="form-control input-sm" name="coupon_amount" value="{{$coupon->coupon_code}}" disabled>                    
                            </div>
                        </div>
                    @endif
                    <div class="form-group">
                        <div class="col-md-6">
                           <label>Product</label>
                           <select name="coupon_product_id" class="select-product">
                                @include("member.load_ajax_data.load_product_category", ['add_search' => "", 'variant_id' => isset($coupon) ? $coupon->coupon_product_id : ''])
                           </select>         
                        </div>
                        <div class="col-md-6">
                           <label>Minimum Quantity</label>
                           <input class="form-control int-format" type="text" name="coupon_minimum_quantity" value="{{$coupon->coupon_minimum_quantity or ''}}">         
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-6">
                           <label>Coupon Amount</label>
                           <input type="text" class="form-control input-sm" name="coupon_amount" value="{{$coupon->coupon_code_amount or ''}}">                    
                        </div>
                        <div class="col-md-6">
                            <label>Coupon Type</label>
                            <select class="form-control input-sm" name="coupon_amount_type" value="">
                                <option value="fixed" {{isset($coupon) ? $coupon->coupon_discounted == 'fixed' ? 'selected' : '' : ''}}>Fixed</option>
                                <option value="percentage" {{isset($coupon) ? $coupon->coupon_discounted == 'percentage' ? 'selected' : '' : ''}}>Percentage</option>   
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
        <div class="col-md-4 pull-right">
            <div class="input-group">
                <input type="hidden" class="form-control int-format text-center" name="generate_count" value="1">
                <span class="input-group-btn">
                    <button class="btn btn-custom-primary btn-save-modallarge" type="submit" data-url="">Generate</button>
                </span>
            </div>
        </div>
        <!-- <button class="btn btn-custom-primary btn-save-modallarge" type="submit" data-url="">Generate</button> -->
    </div>
</form>

<script type="text/javascript">
var generate_coupon = new generate_coupon();

    function generate_coupon()
    {
        init();

        function init()
        {
            action_initialize_select();
        }

        function action_initialize_select()
        {
            console.log("hello");
            $(".select-product").globalDropList(
            {
                hasPopup: "false",
                width : "100%",
                placeholder : "Select a product",
            });
        }
    }
</script>