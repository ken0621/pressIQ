
@foreach($_account as $key=>$account)
	<tr>
		
	    <td style="font-weight: bold;">
	    	<span indent="{{$account['account_sublevel']}}" style="margin-left: {{$account['account_sublevel']*20}}px" class="coa-{{$account['account_parent_id']}} collapse in accordion-body">
	    	@if($account['is_sub_count'] == 1)
	    		<i class="fa cursor-pointer fa-caret-down toggle-caret accordion-toggle" data-target=".coa-{{$account['account_id']}}" data-toggle="collapse"></i> 
	    	@else
	    		&nbsp;&nbsp;&nbsp;
	    	@endif
	    		{{$account['account_number']}} • {{$account['account_name']}}
	    	</span>
	    </td>
	    <td><span class="coa-{{$account['account_parent_id']}} collapse in accordion-body">{{$account['account_type']}}</span></td>
	    <td><span class="coa-{{$account['account_parent_id']}} collapse in accordion-body">{{currency('PHP', $account['account_balance'])}}</span></td>
	    <td class="text-center">
	    	<span class="coa-{{$account['account_parent_id']}} collapse in accordion-body">
		    	<!-- ACTION BUTTON -->
		    	<div class="btn-group">
	                <a class="btn btn-primary btn-grp-primary popup btn-edit-account" href="javascript:" link="/member/accounting/chart_of_account/popup/update/{{$account['account_id']}}">Edit</a>
	                <a class="btn btn-primary btn-grp-primary" href="/member/accounting/journal/all-entry-by-account/{{$account['account_id']}}">Quick Report</a>
	            </div>
            </span>
	    </td>
	</tr>
	@if($account['sub_account'] != null)
		@include('member.accounting.load_chart_account', ['_account' => $account['sub_account']])
	@endif
	@if(sizeOf($_account)-1 == $key)
		<option class="hidden" value="" />
	@endif
@endforeach