
@foreach($_account as $key=>$account)
	<tr>
		
	    <td class="indent" indent="{{$account['account_sublevel']}}" style="font-weight: bold;">{{$account['account_number']}} • {{$account['account_name']}}</td>
	    <td>{{$account['account_type']}}</td>
	    <td>{{$account['account_balance']}}</td>
	    <td>
	    	<!-- ACTION BUTTON -->
	    	<div class="btn-group">
                <a class="btn btn-primary btn-grp-primary popup btn-edit-account" href="javascript:" link="/member/accounting/chart_of_account/popup/update/{{$account['account_id']}}">Edit</a>
                <!-- <a class="btn btn-primary btn-grp-primary popup" href="javascript:" link="" size="md"><span class="fa fa-trash"></span></a> -->
            </div>
	    </td>
	</tr>
	@if($account['sub_account'] != null)
		@include('member.accounting.load_chart_account', ['_account' => $account['sub_account']])
	@endif
	@if(sizeOf($_account)-1 == $key)
		<option class="hidden" value="" />
	@endif
@endforeach