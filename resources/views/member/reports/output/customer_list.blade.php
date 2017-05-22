<div class="report-container">
  <div class="panel panel-default panel-block panel-title-block panel-report load-data">
      <div class="panel-heading load-content">
         @include('member.reports.report_header');
         <div class="table-reponsive">
         		<table class="table table-condensed collaptable">
         		<tr>
         			<th>Date</th>
         			<th>Type</th>
         			<th>Num</th>
         			<th>Account</th>
         			<th>Amount</th>
         			<th>Balance</th>
         		</tr>
         		<tbody>
         			
     				@foreach($_customer as $key=>$customer)
     				<tr data-id="" data-parent="" style="background-color: #e4e5e6;">
         				<td colspan="6"><b>{{$customer->first_name." ".$customer->last_name}}</b></td>
         			</tr>
         				<?php $balance = 0;?>
     					@foreach($customer->customer_journal as $key2=>$journal)
  						<tr data-id="" data-parent="">
  							<td nowrap>{{$journal->je_entry_date}}</td>
  							<td nowrap>{{$journal->je_reference_module}}</td>
  							<td nowrap>{{$journal->je_reference_id}}</td>
  							<td nowrap>{{$journal->account_name}}</td>
  							<td nowrap>{{currency('PHP', $journal->amount)}}</td>
  							<?php $balance += $journal->amount; ?>
  							<td nowrap>{{currency('PHP', $balance)}}</td>
  						</tr>
  					@endforeach
  				<tr style="background-color: aliceblue;">
  					<td colspan="5"><b>Total {{$customer->first_name." ".$customer->last_name}}</b></td>
  					<td>{{currency('PHP', $balance)}}</td>
  				</tr>	
     				@endforeach
         		</tbody>
         		</table>
         	</div>
      </div>
  </div>
</div>