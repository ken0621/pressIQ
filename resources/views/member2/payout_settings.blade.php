<form method="post" class="form-payout-submit">
	{{ csrf_field() }}
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal">×</button>
		<h4 class="modal-title">PAYOUT DETAILS</h4>
	</div>
	<div class="modal-body clearfix">
		<div class="row">
	        <div class="clearfix modal-body"> 
	            <div class="col-md-6">
	                <label for="basic-input">How would you like to receive your payout?</label>
	                <select name="customer_payout_method" class="form-control choose-method">
	                	@foreach($_method as $method)
	                		<option {{ $customer->customer_payout_method == $method ? "selected" : "" }} value="{{ $method }}">{{ strtoupper($method) }}</option>
	                	@endforeach
	                </select>
	            </div>

	            <div class="col-md-6">
	                <label for="basic-input">Enter Your Tin Number</label>
	                <input class="form-control" required="required" type="text" name="tin_number" value="{{ $tin_number }} ">
	            </div>
	        </div>
	    </div>

	    {{-- EON CARD --}}
		<div class="row payout-mode-container" content="eon">
	        <div class="clearfix modal-body"> 
	                <div class="col-md-12">
	                    <div class="table-responsive">
	                        <table class="table table-bordered">
	                            <thead style="text-transform: uppercase">
	                                <tr>
	                                    <th class="text-center" style="width: 100px;">SLOT CODE</th>
	                                    <th class="text-center" width="120px">EON ACCOUNT NUMBER</th>
	                                    <th class="text-center" width="120px">EON CARD NUMBER</th>
	                                </tr>
	                            </thead>
	                            <tbody>
	                            	@foreach($_slot as $slot)
	                                <tr>
	                                	<input type="hidden" name="eon_slot_code[]" value="{{ $slot->slot_no }}">
	                                    <td class="text-center" style="vertical-align: middle;">{{ $slot->slot_no }}</td>
	                                    <td class="text-center">
	                                    	<input type="text" class="form-control text-center" name="eon_account_no[]" value="{{ $slot->slot_eon_account_no }}">
	                                    </td>
	                                    <td class="text-center">
	                                    	<input type="text" class="form-control text-center" name="eon_card_no[]" value="{{ $slot->slot_eon_card_no }}">
	                                    </td>
	                                </tr>
	                                @endforeach
	                            </tbody>
	                        </table>
	                    </div>
	                </div>
	        </div>
		</div>

		{{-- BANK DEPOSIT --}}
		<div class="row bank-table payout-mode-container" content="bank">
	        <div class="clearfix modal-body"> 
	            <div class="col-md-12">
	                <div class="table-responsive">
	                    <table class="table table-bordered">
	                        <thead style="text-transform: uppercase">
	                            <tr>
	                                <th class="text-center" style="width: 100px;">SLOT CODE</th>
	                                <th class="text-center" width="120px">BANK</th>
	                                <th class="text-center" width="120px">BANK ACCOUNT NUMBER</th>
	                            </tr>
	                        </thead>
	                        <tbody>
	                        	@foreach($_slot as $slot)
	                            <tr>
	                            	<input type="hidden" name="bank_slot_no[]" value="{{ $slot->slot_no }}">
	                                <td class="text-center" style="vertical-align: middle;">{{ $slot->slot_no }}</td>
	                                <td class="text-center">
	                                	<select name="bank_id[]" class="form-control">
	                                		@foreach($_bank as $bank)
	                                			<option {{ $slot->payout_bank_id == $bank->payout_bank_id ? 'selected' : '' }} value="{{ $bank->payout_bank_id  }}">{{ $bank->payout_bank_name }}</option>
	                                		@endforeach
	                                	</select>
	                                </td>
	                              	<td class="text-center">
	                                	<input name="bank_account_no[]" type="text" value="{{ $slot->bank_account_number }}" class="form-control text-center" >
	                                </td>
	                            </tr>
	                            @endforeach
	                        </tbody>
	                    </table>
	                </div>
	            </div>
	        </div>
		</div>
	</div>
	<div class="modal-footer">
		<button type="button" class="btn btn-def-white btn-custom-white" data-dismiss="modal"><i class="fa fa-close"></i> Close</button>
		<button type="submit" class="btn btn-custom-primary" type="button"><i class="fa fa-pencil"></i> Update Payout Details</button>
	</div>
</form>

<script type="text/javascript">
	
var payout = new payout();

function payout()
{
	init();

	function init()
	{
		action_show_hide_based_on_method();
		event_change_method();
		event_payout_submit();
	}
}
	
function event_change_method()
{
	$(".choose-method").change(function()
	{
		action_show_hide_based_on_method();
	});
}
function action_show_hide_based_on_method()
{
	$method = $(".choose-method").val();
	$(".payout-mode-container").hide();
	$(".payout-mode-container[content=" + $method + "]").fadeIn();
}

function event_payout_submit()
{
	$(".form-payout-submit").submit(function(e)
	{
		action_submit_payout_details($(e.currentTarget).serialize());
		return false;
	});
}

function action_submit_payout_details(form_data)
{
	$.ajax(
	{
		url:"/members/payout-setting",
		dataType:"json",
		data: form_data,
		type:"post",
		success: function(data)
		{
			$("#global_modal").modal("hide");
			setTimeout(function()
			{
				action_load_link_to_modal("/members/payout-setting-success", "sm");
				$(".top-message-warning.for-payout").fadeOut();
			}, 350);
		}
	});
}
</script>