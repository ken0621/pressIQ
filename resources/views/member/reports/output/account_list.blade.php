<div class="report-container">
  <div class="panel panel-default panel-block panel-title-block panel-report load-data">
      <div class="panel-heading load-content">
         @include('member.reports.report_header');
         <div class="table-reponsive">
         		<table class="table table-condensed collaptable">
         		<tr>
              <th>Account</th>
         			<th>Date</th>
         			<th>Module</th>
         			<th>Num</th>
              <th>Type</th>
         			<th>Amount</th>
         			<th>Balance</th>
         		</tr>
         		<tbody>
         			
     				@foreach($_account as $key=>$account)
     				  <tr data-id="{{'account-'.$key}}" data-parent="">
         				<td ><b>{{$account->account_name}}</b></td>
                <td colspan="3"></td>
                <td >{{$account->chart_type_name}}</td>
                <td ></td>
                <td class="text-right">{{currency('PHP', $account->balance)}}</td>
         			</tr>
         				<?php $balance = 0;?>
     					@foreach($account->account_journal as $key2=>$journal)
  						<tr data-id="{{'account2-'.$key2}}" data-parent="{{'account-'.$key}}">
                <td nowrap></td>
  							<td nowrap>{{$journal->je_entry_date}}</td>
  							<td nowrap>{{$journal->je_reference_module}}</td>
  							<td nowrap>{{$journal->je_reference_id}}</td>
  							<td nowrap>{{$journal->chart_type_name}}</td>
  							<td nowrap>{{currency('PHP', $journal->amount)}}</td>
  							<?php $balance += $journal->amount; ?>
  							<td nowrap>{{$account->balance > 0 ? currency('PHP', $balance) : currency('PHP', 0)}}</td>
  						</tr>
    					@endforeach
      				<tr data-id="{{'account2-'.$key}}" data-parent="{{'account-'.$key}}">
      					<td colspan="6"><b>Total {{$account->account_name}}</b></td>
      					<td>{{currency('PHP', $account->balance)}}</td>
      				</tr>	
     				@endforeach
         		</tbody>
         		</table>
         	</div>
      </div>
  </div>
</div>