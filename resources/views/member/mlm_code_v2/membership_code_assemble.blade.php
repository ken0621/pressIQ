<form action="/member/mlm/code2/assemble" method="post" class="global-submit">
    {{ csrf_field() }}
    <div class="modal-header">
    	<button type="button" class="close" data-dismiss="modal">×</button>
    	<h4 class="modal-title"><i class="fa fa-qrcode"></i> ASSEMBLE MEMBERSHIP CODE</h4>
    </div>
    <div class="modal-body clearfix">
    	<div class="row">
            <div class="clearfix modal-body"> 
                <div class="form-horizontal">
                    <div class="form-group">
                        <div class="col-md-8">
                            <label for="basic-input">Item Kit</label>
    			            <select name="item_id" class="form-control membership-item-kit-select">
    			                @foreach($_item_kit as $kit)
    			                    <option value="{{ $kit->item_id }}">{{ $kit->item_name }}</option>
    			                @endforeach
    			            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="basic-input">Kit Quantity</label>
                            <input name="quantity" id="basic-input" value="1" class="form-control text-right membership-item-kit-quantity" name="item_sku" placeholder="">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-12 assembly-table-container-projection">
                        </div>
                    </div>
<!--                     @if($check_shop_id == 5)
                    <div style="border-bottom:1px solid #e5e5e5;"></div>
                        <div class="form-group">
                        	<div class="col-md-12" style="margin-top:25px;">
                                <div class="col-md-12" style="margin-bottom: 10px;">
                                    <label for="ez_program">Use for Ez Program</label>
                                    <input type="checkbox" id="ez_program" value="yes" name="ez_program">
                                </div>
                                <div class="col-md-12 ez_program_input">
                                    <div class="col-md-6">
                                         <label for="paid_price">Paid Price</label>
                                         <input type="text" id="paid_price" class="form-control" name="paid_price" readonly>
                                         <input type="hidden" id="paid_price_no_change" class="form-control" readonly>
                                    </div>
                                    <div class="col-md-6">
                                         <label for="cd_price">Remaining Balance</label>
                                         <input type="text" id="cd_price" name="cd_price" class="form-control" value="0">
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif -->
                </div>
            </div>
    	</div>
    </div>
    <div class="modal-footer">
    	<button type="button" class="btn btn-def-white btn-custom-white" data-dismiss="modal">Close</button>
    	<button class="btn btn-primary btn-custom-primary assemble-code-submit" type="submit"><i class="fa fa-qrcode"></i> Assemble Code</button>
    </div>
    <script type="text/javascript" src="/assets/member/js/membership_code/membership_code_assemble.js"></script>

    @if($check_shop_id == 5)
    <script type="text/javascript" src="/assets/member/js/membership_code/brown_ez.js"></script>
    @endif
</form>