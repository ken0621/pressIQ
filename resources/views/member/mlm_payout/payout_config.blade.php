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
						<div class="col-md-3">
	                        <label for="basic-input">Tax (%)</label>
	                        <input id="basic-input" value="{{ $settings->enchasment_settings_tax }}" class="form-control text-right" name="enchasment_settings_tax" placeholder="">
	                    </div>
						<div class="col-md-3">
	                        <label for="basic-input">Service Charge (PHP)</label>
	                        <input id="basic-input" value="{{ $settings->enchasment_settings_p_fee }}" class="form-control text-right" name="enchasment_settings_p_fee" placeholder="">
	                    </div>

	                    <div class="col-md-3">
	                        <label for="basic-input">Other Charge (PHP)</label>
	                        <input id="basic-input" value="{{ $settings->encashment_settings_o_fee }}" class="form-control text-right" name="encashment_settings_o_fee" placeholder="">
	                    </div>
	                    <div class="col-md-3">
	                        <label for="basic-input">Minimum Encashment</label>
	                        <input id="basic-input" value="{{ $settings->enchasment_settings_minimum }}" class="form-control text-right" name="enchasment_settings_minimum" placeholder="">
	                    </div>
	                </div>
	            </div>
	            <div class="form-horizontal" style="margin-top: 30px">
	                <div class="form-group">
	                    <div class="col-md-6">
	                    	<div style="font-weight: bold; padding-bottom: 10px; font-size: 16px;">METHOD LIST</div>
	                    	<div><label><input {{ hasWord('bank', $user_info->shop_payout_method) ? 'checked' : '' }} class="payout_method" value="bank" type="checkbox" name="payout_method[]"> BANK DEPOSIT</label></div>
	                    	<div><label><input {{ hasWord('cheque', $user_info->shop_payout_method) ? 'checked' : '' }} class="payout_method" value="cheque" type="checkbox" name="payout_method[]"> CHEQUE</label></div>
	                    	<div><label><input {{ hasWord('eon', $user_info->shop_payout_method) ? 'checked' : '' }} class="payout_method" value="eon" type="checkbox" name="payout_method[]"> EON</label></div>
	                    </div>
	                    <div class="col-md-6">
	                    	<div style="font-weight: bold; padding-bottom: 10px; font-size: 16px;">BANK LIST</div>
	                    	@foreach($_bank as $bank)
	                    	<div><label><input {{ $bank->enabled ? 'checked' : '' }} class="payout_method" name="bank[]" value="{{ $bank->payout_bank_id }}" type="checkbox"> {{ strtoupper($bank->payout_bank_name) }}</label></div>
	                    	@endforeach
	                    </div>
	                </div>
	            </div>
	            <div class="form-horizontal">
	                <div class="form-group">
	                	<div class="text-center"><div style="font-weight: bold; padding-bottom: 10px; font-size: 16px; margin-top: 25px;">SCHEDULED REQUEST PAYOUT</div></div>
						<div class="col-md-12">
	                        <label for="basic-input">Schedule</label>
	                        <select class="form-control" name="encashment_settings_schedule">
	                        	@for($i = 1; $i <= 30; $i++)
	                        		<option value="{{ $i }}" {{ $i == $settings->encashment_settings_schedule ? "selected" : "" }}>Every {{ ordinal($i) }} of the Month</option>
	                        	@endfor
	                        </select>
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