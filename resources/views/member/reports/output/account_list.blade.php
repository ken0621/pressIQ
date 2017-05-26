<div class="report-container">
  <div class="panel panel-default panel-block panel-title-block panel-report load-data">
      <div class="panel-heading load-content">
         @include('member.reports.report_header');
         <div class="table-reponsive">
         		<table class="table table-condensed collaptable">
         		<tr>
              <th class="text-center">Account</th>
         			<th class="text-center">Date</th>
         			<th class="text-center">Module</th>
         			<th class="text-center">Num</th>
              <th class="text-center">Type</th>
         			<th class="text-center">Amount</th>
         			<th class="text-center">Balance</th>
         		</tr>
         		<tbody>
         			
     				@foreach($_account as $key=>$account)
     				  <tr data-id="account-{{$key}}" data-parent="">
         				<td ><b>{{$account->account_name}}</b></td>
                <td colspan="3"></td>
                <td >{{$account->chart_type_name}}</td>
                <td ></td>
                <td class="text-right"><text class="total-report">{{is_numeric($account->balance) ? '' .currency('PHP', $account->balance) : ''}}</text></td>
         			</tr>
         				<?php $balance = 0;?>
     					@foreach($account->account_journal as $key2=>$journal)
  						<tr data-id="account2-{{$key}}" data-parent="account-{{$key}}">
                <td nowrap></td>
  							<td nowrap>{{$journal->je_entry_date}}</td>
  							<td nowrap>{{$journal->je_reference_module}}</td>
  							<td nowrap>{{$journal->je_reference_id}}</td>
  							<td nowrap>{{$journal->chart_type_name}}</td>
  							<td class="text-right" nowrap>{{currency('PHP', $journal->amount)}}</td>
  							<?php $balance += $journal->amount; ?>
  							<td class="text-right" nowrap>{{is_numeric($account->balance) ? currency('PHP', $balance) : ''}}</td>
  						</tr>
    					@endforeach
      				<tr data-id="account2-{{$key}}" data-parent="account-{{$key}}">
      					<td colspan="6"><b>Total {{$account->account_name}}</b></td>
      					<td class="text-right">{{is_numeric($account->balance) ? currency('PHP', $balance) : ''}}</td>
      				</tr>	
     				@endforeach
         		</tbody>
         		</table>
         	</div>
          <h5 class="text-center">---- {{$now or ''}} ----</h5>
      </div>
  </div>
</div>