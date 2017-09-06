<form class="global-submit form-horizontal" role="form" action="{{$link_submit_here}}" method="post">
    <div class="modal-header">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <button type="button" class="close" data-dismiss="modal">×</button>
        <h4 class="modal-title"><i class="fa fa-cart-plus"></i> CREATE NEW ITEM</h4>
        <div>Enter the information of your items below</div>
    </div>
    
    <!-- ITEM TYPE PICKER -->
    <div class="item-type-picker {{ $item_picker }}">
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
                            <div class="tp-title">Membership Kit</div>
                            <div class="tp-description">Membership are items that are sometimes sold as Bundle or GC with reward features once sold to customers.</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ITEM ADD MAIN -->
    <div class="item-add-main" style="{{ $item_main }}">
        <div class="clearfix modal-body modallarge-body-layout"> 
            <div class="form-horizontal">
                <!-- BASIC INFORMATION -->
                <h4 class="section-title first">Basic Information</h4>
                <div class="form-group">
                    <div class="col-md-6">
                        <label for="basic-input">Item Description</label>
                        <input id="basic-input" value="{{ get_request_old($item_info, 'item_description', 'item_name') }}" class="form-control" name="item_description" placeholder="">
                    </div>
                    <div class="col-md-3">
                        <label for="basic-input">Item Code / SKU</label>
                        <input id="basic-input" value="{{ get_request_old($item_info, 'item_sku') }}" class="form-control" name="item_sku" placeholder="">
                    </div>
                    <div class="col-md-3">
                        <label for="basic-input">Barcode</label>
                        <input id="basic-input" value="{{ get_request_old($item_info, 'item_barcode') }}" class="form-control" name="item_barcode" placeholder="">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-6">
                        <label for="basic-input">Category</label>
                        <select class="form-control select-category inventory" name="item_category">
                            @include("member.load_ajax_data.load_category", ['add_search' => "",'_category' => $_inventory,'type_id' => get_request_old($item_info, 'item_category', 'item_category_id')])
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="basic-input">Manufacturer</label>
                        <select class="form-control select-manufacturer" name="item_manufacturer_id">
                            @include("member.load_ajax_data.load_manufacturer", ['_manufacturer' => $_manufacturer,'manufacturer_id' => get_request_old($item_info, 'item_manufacturer_id')])
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="basic-input">Item Type</label>
                        <div class="input-group change-type">
                          <input  type="text" class="form-control" name="item_type_id" disabled value="{{ get_request_old($item_info, 'item_type_id') }}" aria-describedby="basic-addon1">
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
                                    <input type="text" class="form-control text-right" placeholder="0.00" value="{{ get_request_old($item_info, 'item_price') }}" name="item_price">
                                </div>
                                <div class="col-md-6">
                                    <label for="basic-input">Income Account</label>
                                    <select class="form-control select-income-account" name="item_income_account_id">
                                        @include("member.load_ajax_data.load_chart_account", ['add_search' => "", '_account' => $_income, 'account_id' => get_request_old($item_info, 'item_income_account_id') != '' ? get_request_old($item_info, 'item_income_account_id') : $default_income])
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-12">
                                    <label for="basic-input">Sales Information</label>
                                    <textarea class="form-control" placeholder="Description on sales forms" name="item_sales_information">{{ get_request_old($item_info, 'item_sales_information') }}</textarea>
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
                                      <input  type="text" class="form-control text-right" placeholder="0.00" value="{{ get_request_old($item_info, 'item_cost') }}" aria-describedby="basic-addon1" name="item_cost">
                                      <span onclick="action_load_link_to_modal('/member/item/v2/cost', 'lg')" style="background-color: #eee; cursor: pointer;" class="input-group-addon" id="basic-addon1"><i class="fa fa-calculator"></i></span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="basic-input">Expense Account</label>
                                    <select class="form-control select-expense-account" name="item_expense_account_id">
                                        @include("member.load_ajax_data.load_chart_account", ['add_search' => "", '_account' => $_expense, 'account_id' => get_request_old($item_info, 'item_expense_account_id') != '' ? get_request_old($item_info, 'item_expense_account_id') : $default_expense])
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-12">
                                    <label for="basic-input">Purchasing Information</label>
                                    <textarea class="form-control" placeholder="Description on purchase forms" name="item_purchasing_information">{{ get_request_old($item_info, 'item_purchasing_information') }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
   
                <!-- INVENTORY -->
                <h4 class="section-title {{ $item_picker }}">Inventory</h4>
                <div class="form-group {{ $item_picker }}">
                    <div class="col-md-4">
                        <label for="basic-input">Initial Quantity On Hand *</label>
                        <div class="input-group">
                          <input type="text" class="form-control" placeholder="0" name="item_initial_qty" aria-describedby="basic-addon1" value="0">
                          <span style="background-color: #eee; cursor: pointer;" class="input-group-addon" id="basic-addon1">Unit Conversion</span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label for="basic-input">As Of Date</label>
                       <input id="basic-input" class="form-control" name="item_date_track" value="{{ date('m/d/Y') }}">
                    </div>
                    <div class="col-md-4">
                        <label for="basic-input">Reorder Point</label>
                       <input id="basic-input" class="form-control" value="0" name="item_reorder_point">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-8">
                        <label for="basic-input">Asset Account</label>
                        <select class="form-control select-asset-account" name="item_asset_account_id">
                            @include("member.load_ajax_data.load_chart_account", ['add_search' => "", '_account' => $_asset, 'account_id' => $default_asset])
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="basic-input">Has Serial</label>
                        <select class="form-control select-has-serial" name="item_has_serial">
                            <option value="0">No</option>
                            <option value="1">Yes</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ITEM ADD BUNDLE -->
    <div class="item-bundle" style="display: none;">
        <div class="clearfix modal-body modallarge-body-layout"> 
            <div class="form-horizontal">
                <div class="form-group">
                    <div class="col-md-6">
                        <label for="basic-input">Item Description</label>
                        <input id="basic-input" value="{{ get_request_old($item_info, 'item_description', 'item_name') }}" class="form-control" name="item_description" placeholder="">
                    </div>
                    <div class="col-md-3">
                        <label for="basic-input">Item Code / SKU</label>
                        <input id="basic-input" value="{{ get_request_old($item_info, 'item_sku') }}" class="form-control" name="item_sku" placeholder="">
                    </div>
                    <div class="col-md-3">
                        <label for="basic-input">Barcode</label>
                        <input id="basic-input" value="{{ get_request_old($item_info, 'item_barcode') }}" class="form-control" name="item_barcode" placeholder="">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-3">
                        <label for="basic-input">Sale Price / Rate *</label>
                        <input type="text" class="form-control text-right" placeholder="0.00" value="{{ get_request_old($item_info, 'item_price') }}" name="item_price">
                    </div>
                    <div class="col-md-3">
                        <label for="basic-input">Income Account</label>
                        <select class="form-control select-income-account" name="item_income_account_id">
                            @include("member.load_ajax_data.load_chart_account", ['add_search' => "", '_account' => $_income, 'account_id' => get_request_old($item_info, 'item_income_account_id') != '' ? get_request_old($item_info, 'item_income_account_id') : $default_income])
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="basic-input">Category</label>
                        <select class="form-control select-category inventory" name="item_category">
                            @include("member.load_ajax_data.load_category", ['add_search' => "",'_category' => $_inventory,'type_id' => get_request_old($item_info, 'item_category', 'item_category_id')])
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="basic-input">Item Type</label>
                        <div class="input-group change-type">
                          <input  type="text" class="form-control" name="item_type_id" disabled value="{{ get_request_old($item_info, 'item_type_id') }}" aria-describedby="basic-addon1">
                          <span style="background-color: #eee; cursor: pointer;" class="input-group-addon" id="basic-addon1"><i class="fa fa-edit"></i></span>
                        </div>
                    </div>
                </div>

                <hr>

                <div class="form-group">
                    <div class="col-md-12">
                        <div class="clearfix" style="margin-bottom: 10px;">
                            <div class="pull-left text-bold" style="font-size: 16px; padding-top: 10px;"><i class="fa fa-shopping-cart"></i> INCLUSIVE ITEMS</div>
                            <button type="button" onclick="action_load_link_to_modal('/member/item/choose')" class="pull-right btn btn-custom-white"><i class="fa fa-plus"></i> Add Item</button>
                        </div>
                        <table class="table table-bordered table-striped table-condensed">
                            <thead style="text-transform: uppercase">
                                <tr>
                                    <th class="text-center">Item SKU</th>
                                    <th class="text-center">Item Cost</th>
                                    <th class="text-center">Item Price</th>
                                    <th class="text-center">Quantity</th>
                                    <th class="text-center" width="50px"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td colspan="5" class="text-center">NO ITEM YET</td>
                                </tr>
                                <!--
                                <tr>
                                    <td class="text-center">IPHONE6PLUSGOLD</td>
                                    <td class="text-center">PHP 1,500.00</td>
                                    <td class="text-center">PHP 1,000.00</td>
                                    <td class="text-center">5</td>
                                </tr>
                                -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-def-white btn-custom-white" data-dismiss="modal"><i class="fa fa-close"></i> Close</button>
        <button {{ $item_button }} class="btn btn-primary btn-custom-primary" type="submit"><i class="fa fa-save"></i> Save Item</button>
    </div>
</form>
<script type="text/javascript" src="/assets/member/js/item/item_add.js"></script>