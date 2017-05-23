<div class="report-container">
  <div class="panel panel-default panel-block panel-title-block panel-report load-data">
      <div class="panel-heading load-content">
         @include('member.reports.report_header');
         <div class="table-reponsive">
         		<table class="table table-condensed collaptable">
         		<tr>
              <th>Vendor</th>
         			<th>Date</th>
         			<th>Type</th>
         			<th>Num</th>
         			<th>Account</th>
         			<th>Amount</th>
         			<th>Balance</th>
         		</tr>
         		<tbody>
         			
     				@foreach($_vendor as $key=>$vendor)
     				<tr data-id="" data-parent="" style="background-color: #e4e5e6;">
         				<td><b>{{$vendor->vendor_first_name." ".$vendor->vendor_last_name}}</b></td>
                <td colspan="5"></td>
                <td></td>
         			</tr>
         				<?php $balance = 0;?>
     					@foreach($vendor->vendor_journal as $key2=>$journal)
  						<tr data-id="" data-parent="">
                <td nowrap></td>
  							<td nowrap>{{$journal->je_entry_date}}</td>
  							<td nowrap>{{$journal->je_reference_module}}</td>
  							<td nowrap>{{$journal->je_reference_id}}</td>
  							<td nowrap>{{$journal->account_name}}</td>
  							<td nowrap>{{currency('PHP', $journal->amount)}}</td>
  							<?php $balance += $journal->amount; ?>
  							<td nowrap>{{currency('PHP', $balance)}}</td>
  						</tr>
  					@endforeach
  				<tr>
  					<td colspan="6"><b>Total {{$vendor->first_name." ".$vendor->last_name}}</b></td>
  					<td>{{currency('PHP', $balance)}}</td>
  				</tr>	
     				@endforeach
         		</tbody>
         		</table>
         	</div>
      </div>
  </div>
</div>