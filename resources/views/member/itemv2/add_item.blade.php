<form class="global-submit form-horizontal" role="form" action="{link_submit_here}" method="post">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">×</button>
        <h4 class="modal-title"><i class="fa fa-cart-plus"></i> CREATE NEW ITEM</h4>
        <div>Enter the information of your items below</div>
    </div>
    
    <!-- ITEM TYPE PICKER -->
    <div class="item-type-picker">
        <div class="item-type-picker-container-clearfix">
            <div class="tp-picker" type_id="1">
                <div class="row unselectable">
                    <div class="col-md-5 text-right">
                        <div class="tp-icon text-center"><i class="fa fa-cube"></i></div>
                    </div>
                    <div class="col-md-7">
                        <div class="tp-detail">
                            <div class="tp-title">Inventory</div>
                            <div class="tp-description">Products you buy and/or sell that you track quantities of.</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tp-picker" type_id="2">
                <div class="row unselectable">
                    <div class="col-md-5 text-right">
                        <div class="tp-icon text-center"><i class="fa fa-dropbox"></i></div>
                    </div>
                    <div class="col-md-7">
                        <div class="tp-detail">
                            <div class="tp-title">Non-inventory</div>
                            <div class="tp-description">Products you buy and/or sell but don’t need to (or can’t) track quantities of, for example, nuts and bolts used in an installation.</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tp-picker" type_id="3">
                <div class="row unselectable">
                    <div class="col-md-5 text-right">
                        <div class="tp-icon text-center"><i class="fa fa-train"></i></div>
                    </div>
                    <div class="col-md-7">
                        <div class="tp-detail">
                            <div class="tp-title">Service</div>
                            <div class="tp-description">Services that you provide to customers, for example, landscaping or tax preparation services.</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tp-picker" type_id="4">
                <div class="row unselectable">
                    <div class="col-md-5 text-right">
                        <div class="tp-icon text-center"><i class="fa fa-cubes"></i></div>
                    </div>
                    <div class="col-md-7">
                        <div class="tp-detail">
                            <div class="tp-title">Bundle</div>
                            <div class="tp-description">A collection of products and/or services that you sell together, for example, a gift basket of fruit, cheese, and wine.</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tp-picker" type_id="5">
                <div class="row unselectable">
                    <div class="col-md-5 text-right">
                        <div class="tp-icon text-center"><i class="fa fa-user-circle-o"></i></div>
                    </div>
                    <div class="col-md-7">
                        <div class="tp-detail">
                            <div class="tp-title">Membership</div>
                            <div class="tp-description">Membership are items that are sometimes sold as Bundle or GC with reward features once sold to customers.</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ITEM ADD MAIN -->
    <div class="item-add-main" style="display: none">
        <div class="clearfix modal-body modallarge-body-layout"> 
            <div class="form-horizontal">
                <!-- BASIC INFORMATION -->
                <h4 class="section-title first">Basic Information</h4>
                <div class="form-group">
                    <div class="col-md-6">
                            <label for="basic-input">Item Description</label>
                            <input id="basic-input" class="form-control" placeholder="">
                    </div>
                    <div class="col-md-3">
                        <label for="basic-input">Item Code / SKU</label>
                        <input id="basic-input" class="form-control" placeholder="">
                    </div>
                    <div class="col-md-3">
                        <label for="basic-input">Barcode</label>
                        <input id="basic-input" class="form-control" placeholder="">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-6">
                        <label for="basic-input">Category</label>
                        <select class="form-control">
                            <option>No Category</option>
                            <option>T-Shirt</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="basic-input">Manufacturer</label>
                        <select class="form-control">
                            <option>No Manufacturer</option>
                            <option>Apple</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="basic-input">Item Type</label>
                        <div class="input-group change-type">
                          <input  type="text" class="form-control" disabled value="Inventory" aria-describedby="basic-addon1">
                          <span style="background-color: #eee; cursor: pointer;" class="input-group-addon" id="basic-addon1"><i class="fa fa-edit"></i></span>
                        </div>
                    </div>
                </div>


                <div class="row">
                    <div class="col-md-6">
                        <div class="sale-module">
                            <h4 class="section-title" >Sale</h4>
                            <div class="form-group">
                                <div class="col-md-6">
                                    <label for="basic-input">Sale Price / Rate *</label>
                                    <input type="text" class="form-control text-right" placeholder="0.00" value="0"  name="">
                                </div>
                                <div class="col-md-6">
                                    <label for="basic-input">Income Account</label>
                                    <select class="form-control">
                                        <option>411900 - Sales</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-12">
                                    <label for="basic-input">Sales Information</label>
                                    <textarea class="form-control" placeholder="Description on sales forms"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <!-- PURCHASE -->
                        <div class="purchase-module">
                            <h4 class="section-title">Purchase</h4>
                            <div class="form-group">
                                <div class="col-md-6">
                                    <label for="basic-input"> Cost *</label>
                                    <div class="input-group">
                                      <input  type="text" class="form-control text-right" placeholder="0.00" value="0" aria-describedby="basic-addon1">
                                      <span onclick="action_load_link_to_modal('/member/item/v2/cost', 'lg')" style="background-color: #eee; cursor: pointer;" class="input-group-addon" id="basic-addon1"><i class="fa fa-calculator"></i></span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="basic-input">Expense Account</label>
                                    <select class="form-control">
                                        <option>22000 - Undeposited Funds</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-12">
                                    <label for="basic-input">Purchasing Information</label>
                                    <textarea class="form-control" placeholder="Description on purchase forms"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- SALE -->



                <!-- INVENTORY -->
                <h4 class="section-title">Inventory</h4>
                <div class="form-group">
                    <div class="col-md-4">
                        <label for="basic-input">Initial quantity on hand *</label>
                        <div class="input-group">
                          <input type="text" class="form-control" placeholder="0" aria-describedby="basic-addon1" value="0">
                          <span style="background-color: #eee; cursor: pointer;" class="input-group-addon" id="basic-addon1">Unit Conversion</span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label for="basic-input">As of date</label>
                       <input id="basic-input" class="form-control" value="{{ date('m/d/Y') }}">
                    </div>
                    <div class="col-md-4">
                        <label for="basic-input">Reorder Point</label>
                       <input id="basic-input" class="form-control" value="0">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-8">
                        <label for="basic-input">Asset Account</label>
                        <select class="form-control">
                            <option>12100 - Inventory Assets</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="basic-input">Has Serial</label>
                        <select class="form-control">
                            <option>No</option>
                            <option>Yes</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal-footer">
        <button type="button" disabled class="btn btn-def-white btn-custom-white" data-dismiss="modal"><i class="fa fa-close"></i> Close</button>
        <button class="btn btn-primary btn-custom-primary" disabled  type="button"><i class="fa fa-save"></i> Save Item</button>
    </div>
</form>
<script type="text/javascript" src="/assets/member/js/item/item_add.js"></script>