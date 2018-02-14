<div class="panel panel-default panel-block panel-title-block">
	    <div class="panel-body form-horizontal">
	    	<div class="form-group draggable-container">
	    		<table class="digima-table">
	    			<thead>
	    				<tr>
	    				<th style="text-align: left; width: 20;">SLOT NO</th>
			            <th style="text-align: left; width: 20;">CUSTOMER</th>
		                <th style="text-align: left; width: 30;">EON ACCOUNT NAME</th>
		                <th style="text-align: left; width: 30;">EON ACCOUNT NUMBER</th>
		                <th style="text-align: left; width: 30;">EON CARD NUMBER</th>
		                <th style="text-align: left; width: 30;">BANK NAME</th>
		                <th style="text-align: left; width: 30;">ACCOUNT NAME</th>
		                <th style="text-align: left; width: 30;">ACCOUNT TYPE</th>
		                <th style="text-align: left; width: 30;">ACCOUNT NUMBER</th>
	    				<th class="text-center">EZ BONUS</th>
	    				<th class="text-center">TOTAL PAYOUT</th>
	    				<th class="text-center">PAYOUT</th>
		    			</tr>
	    			</thead>

	    			<tbody class="draggable tbody-item">
	    				@if(count($_payout) > 0)
	    					@foreach($_payout as $key => $payout)
		    				<tr class="tr-draggable">
			    				<td class="text-center">{{$payout->slot_no}}</td>
					            <td class="text-center">{{$payout->first_name}} {{$payout->last_name}}</td>
				                <td class="text-center">{{$payout->slot_eon}}</td>
				                <td class="text-center">{{$payout->slot_eon_account_no}}</td>
				                <td class="text-center">{{$payout->slot_eon_card_no}}</td>
				                <td class="text-center">{{$payout->payout_bank_name}}</td>
				                <td class="text-center">{{$payout->bank_account_name}}</td>
				                <td class="text-center">{{$payout->bank_account_type}}</td>
				                <td class="text-center">{{$payout->bank_account_number}}</td>
			    				<td class="text-center">{{currency('',$payout->ez_bonus)}}</td>
			    				<td class="text-center">{{currency('',$payout->total_payout)}}</td>
			    				<td class="text-center">{{currency('',$payout->payout)}}</td>
			    			</tr>
			    			@endforeach
		    			@endif
	    			</tbody>
	    		</table>
	    	</div>
	    </div>
	</div>