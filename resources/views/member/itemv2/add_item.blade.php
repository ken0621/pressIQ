<form class="global-submit form-horizontal" role="form" action="{link_submit_here}" method="post">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">×</button>
        <h4 class="modal-title"><i class="fa fa-cart-plus"></i> CREATE NEW ITEM</h4>
        <div>Enter the information of your items below</div>
    </div>
    <div class="clearfix modal-body modallarge-body-layout"> 
        <div class="form-horizontal">
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
                        <option>Utilities</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="basic-input">Manufacturer</label>
                    <select class="form-control">
                        <option>Apple</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="basic-input">Has Serial</label>
                    <select class="form-control">
                        <option>No</option>
                        <option>Yes</option>
                    </select>
                </div>
            </div>
            <div class="form-group">

                <div class="col-md-4">
                    <label for="basic-input">Initial quantity on hand *</label>
                    <div class="input-group">
                      <input type="text" class="form-control" placeholder="0" aria-describedby="basic-addon1">
                      <span style="background-color: #eee; cursor: pointer;" class="input-group-addon" id="basic-addon1">Unit Conversion</span>
                    </div>
                </div>
                <div class="col-md-4">
                    <label for="basic-input">Asset Account</label>
                    <select class="form-control">
                        <option>12100 - Inventory Assets</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label for="basic-input">Reorder Point</label>
                   <input id="basic-input" class="form-control" value="0">
                </div>
                <div class="col-md-2">
                    <label for="basic-input">As of date</label>
                   <input id="basic-input" class="form-control">
                </div>

            </div>
            <div class="form-group">
                <div class="col-md-4">
                    <label for="basic-input">Sale Price / Rate *</label>
                    <div class="input-group">
                      <input type="text" class="form-control" placeholder="0.00" aria-describedby="basic-addon1">
                      <span onclick="action_load_link_to_modal('/member/item/v2/price_level','lg')" style="background-color: #eee; cursor: pointer;" class="input-group-addon" id="basic-addon1">Price Levels</span>
                    </div>
                </div>
                <div class="col-md-4">
                    <label for="basic-input">Income Account</label>
                    <select class="form-control">
                        <option>411900 - Sales</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="basic-input">Sales Description</label>
                   <input id="basic-input" class="form-control">
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-4">
                    <label for="basic-input"> Cost *</label>
                    <div class="input-group">
                      <input  type="text" class="form-control" placeholder="0.00" aria-describedby="basic-addon1">
                      <span onclick="action_load_link_to_modal('/member/item/v2/cost', 'lg')" style="background-color: #eee; cursor: pointer;" class="input-group-addon" id="basic-addon1">Compute Cost</span>
                    </div>
                </div>
                <div class="col-md-4">
                    <label for="basic-input">Expense Account</label>
                    <select class="form-control">
                        <option>22000 - Undeposited Funds</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="basic-input">Purchasing Description</label>
                   <input id="basic-input" class="form-control">
                </div>
            </div>
        </div>
    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-def-white btn-custom-white" data-dismiss="modal"><i class="fa fa-close"></i> Close</button>
        <button class="btn btn-primary btn-custom-primary" type="button"><i class="fa fa-save"></i> Save Item</button>
    </div>
</form>