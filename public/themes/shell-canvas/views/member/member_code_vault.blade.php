@extends("member.member_layout")
@section("member_content")
<div class="wallet-encashment">
	<div class="main-member-header clearfix">
		<div class="left">
			<div class="icon">
				<img src="/themes/{{ $shop_theme }}/img/trust-icon.png">
			</div>
			<div class="text">
				<div class="name">
					<div>Membership Code Vault</div>
				</div>
				<div class="sub">In this tab you can view the product codes you have. </div>
			</div>
		</div>
		
	</div>
	<div class="wallet-encashment-content">
		
		<div class="table-holder table-responsive">
			<table class="table table-striped">
				<thead>
					<tr>
						<th class="text-center" >PIN NO.</th>
						<th class="text-center" >ACTIVATION </th>
						<th class="text-center" >STATUS</th>
						<th class="text-center" >FROM</th>
					</tr>
				</thead>
				
				<tfoot style="background-color: #f3f3f3; font-size: 15px;">
					@foreach($_codes as $codes)
					<tr>
						
							<td class="text-center">{{ $codes->mlm_pin }}</td>
							<td class="text-center">{{ $codes->mlm_activation }}</td>
							<td class="text-center">{{ $codes->item_in_use }}</td>
							@if($codes->payment_method == 'pos')
								<td class="text-center">POS</td>
							@else
								<td class="text-center">Manual</td>
							@endif
						
					</tr>
					@endforeach
				</tfoot>
			</table>
		  	<div class="clearfix">
			  	<div class="pull-right">
			  		{!! session('payout_paginate') !!}
			  	</div>
		  	</div>
		</div>

	</div>
</div>

<!-- MANUAL PLACING OF SLOT -->
<div class="popup-wallet-encashment">
    <div id="wallet-encashmnet-modal" class="modal fade">
        <div class="modal-md modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title"><i class="fa fa-credit-card"></i> ENCASHMENT</h4>
                </div>
				<div class="modal-body clearfix">
					<div class="row">
				        <div class="clearfix modal-body"> 
				            <div class="form-horizontal">
				                <div class="form-group">
				                    <div class="col-md-8">
				                        <label for="basic-input">Choose a Payout Method</label>
				                        <select class="form-control">
				                        	<option>BANK DEPOSIT</option>
				                        	<option>EON CARD</option>
				                        </select>
				                    </div>
				                    <div class="col-md-4">
				                        <label for="basic-input">Amount</label>
				                        <input id="basic-input" value="5000" class="form-control text-right" name="item_sku" placeholder="">
				                    </div>
				                </div>
				                <div class="form-group">
				                    <div class="col-md-4">
				                        <label for="basic-input">Bank Name</label>
				                        <select class="form-control">
				                        	<option>BDO (Banco de Oro)</option>
				                        	<option>BPI (Bank of the Philippiens Island)</option>
				                        	<option>China Bank</option>
				                        	<option>Metro Bank</option>
				                        </select>
				                    </div>
				                    <div class="col-md-4">
				                        <label for="basic-input">Account Name</label>
				                        <input type="text" class="form-control" name="">
				                    </div>
				                    <div class="col-md-4">
				                        <label for="basic-input">Account Number</label>
				                        <input id="basic-input" value="" class="form-control text-right" name="item_sku" placeholder="">
				                    </div>
				                </div>
				                <div class="form-group">
				                	
				                </div>
				            </div>
				        </div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default btn-custom-white" data-dismiss="modal"><i class="fa fa-close"></i> Close</button>
					<button class="btn btn-primary btn-custom-primary" type="button"><i class="fa fa-check"></i> Request Payout</button>
				</div>
              </div>
          </div>
      </div>
  </div>
@endsection