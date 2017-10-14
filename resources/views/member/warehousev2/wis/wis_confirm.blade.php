<form class="global-submit" method="post" action="/member/item/warehouse/wis/confirm-submit">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title layout-modallarge-title item_title">Confirm WIS</h4>
    </div>
    <div class="modal-body modallarge-body-layout background-white form-horizontal menu_container">
        <div class="panel-body form-horizontal">
            <div class="form-group">
                <select class="form-control" name="wis_status">
                    <option value="pending">Pending</option>
                    <option value="confirm">Confirm</option>
                </select>
            </div>
            <div class="form-group" name="confirm_image">
            	<label>Attach Proof of Issuing</label>
            	<input type="file" name="" class="form-control">
            </div>
        </div>
    </div>
    <div class="modal-footer" >
        <button type="button" class="btn btn-custom-white" data-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-primary" >Confirm</button>
    </div>
</form>