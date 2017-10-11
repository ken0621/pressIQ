<form class="global-submit" rold="form" action="/member/mlm/payout/config" method="post">
	{{ csrf_field() }}
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal">×</button>
		<h4 class="modal-title">PAYOUT CONFIGURATION</h4>
	</div>
	<div class="modal-body clearfix">
		<div class="row">
	        <div class="clearfix modal-body"> 
	            <div class="form-horizontal">
	                <div class="form-group">
	                	<div class="text-center"><div style="font-weight: bold; padding-bottom: 10px; font-size: 16px;">PAYOUT CHARGES</div></div>
						<div class="col-md-4">
	                        <label for="basic-input">Tax (%)</label>
	                        <input id="basic-input" value="0" class="form-control text-right" name="tax" placeholder="">
	                    </div>
						<div class="col-md-4">
	                        <label for="basic-input">Service Charge (PHP)</label>
	                        <input id="basic-input" value="0" class="form-control text-right" name="service_charge" placeholder="">
	                    </div>

	                    <div class="col-md-4">
	                        <label for="basic-input">Other Charge (PHP)</label>
	                        <input id="basic-input" value="0" class="form-control text-right" name="other_charge" placeholder="">
	                    </div>
	                </div>
	            </div>
	            <div class="form-horizontal" style="margin-top: 30px">
	                <div class="form-group">
	                    <div class="col-md-4">
	                    	<div style="font-weight: bold; padding-bottom: 10px; font-size: 16px;">METHOD LIST</div>
	                    	<div><label><input {{ hasWord('bank', $user_info->shop_payout_method) ? 'checked' : '' }} class="payout_method" value="bank" type="checkbox" name="payout_method[]"> BANK DEPOSIT</label></div>
	                    	<div><label><input {{ hasWord('cheque', $user_info->shop_payout_method) ? 'checked' : '' }} class="payout_method" value="cheque" type="checkbox" name="payout_method[]"> CHEQUE</label></div>
	                    	<div><label><input {{ hasWord('eon', $user_info->shop_payout_method) ? 'checked' : '' }} class="payout_method" value="eon" type="checkbox" name="payout_method[]"> EON</label></div>
	                    </div>
	                    <div class="col-md-4">
	                    	<div style="font-weight: bold; padding-bottom: 10px; font-size: 16px;">BANK LIST</div>
	                    	@foreach($_bank as $bank)
	                    	<div><label><input {{ $bank->enabled ? 'checked' : '' }} class="payout_method" name="bank[]" value="{{ $bank->payout_bank_id }}" type="checkbox"> {{ strtoupper($bank->payout_bank_name) }}</label></div>
	                    	@endforeach
	                    </div>
	                </div>
	            </div>
	        </div>
		</div>
	</div>
	<div class="modal-footer">
		<button type="button" class="btn btn-def-white btn-custom-white" data-dismiss="modal">Close</button>
		<button type="submit" class="btn btn-primary btn-custom-primary" type="button">Update Payout Settings</button>
	</div>
</form>

<script type="text/javascript">
	function payout_config_success(data)
	{
		data.element.modal("hide");
	}
</script>