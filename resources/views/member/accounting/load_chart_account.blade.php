
@foreach($_account as $key=>$account)
	<tr>
		
	    <td class="indent" indent="{{$account['account_sublevel']}}" style="font-weight: bold;">{{$account['account_number']}} • {{$account['account_name']}}</td>
	    <td>{{$account['account_type']}}</td>
	    <td>0</td>
	    <td>
	    	<!-- ACTION BUTTON -->
            <div class="btn-group">
				<button type="button" class="btn btn-sm btn-custom-white dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				Action <span class="caret"></span>
				</button>
				<ul class="dropdown-menu dropdown-menu-custom">
					<li><a href="javascript:" class="popup btn-edit-account" link="/member/accounting/chart_of_account/popup/update/{{$account['account_id']}}" >Edit Chart of Accounts</a></li>
				</ul>
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