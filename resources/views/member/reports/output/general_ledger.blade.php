<div class="report-container">
  <div class="panel panel-default panel-block panel-title-block panel-report">
      <div class="panel-heading">
         @include('member.reports.report_header');
         <div class="table-reponsive">
         		<table class="table table-condensed collaptable">
         		<tr>
              <th class="text-center">Account</th>
         			<th class="text-center">Date</th>
         			<th>Transaction Type</th>
         			<th>Num</th>
         			<th>Name</th>
         			<th class="text-center">Memo/Discription</th>
         			<!-- <th>SPLIT</th> -->
         			<th class="text-center">Amount</th>
         			<th class="text-center">Balance</th>
         		</tr>
         		<tbody>
         			
     				@foreach($chart_of_account_data as $key2 => $value2)
     				  <tr data-id="{{$key2}}" data-parent="" >
         				<td colspan="20"><b>{{$chart_of_account[$key2]}}</b></td>
         			</tr>
         				<?php $balance = 0;?>
     					@foreach($value2 as $key3 => $value3)
  						<tr data-id="{{$key3 }}" data-parent="{{$key2}}">
                <td></td>
  							<td class="text-center">{{$value3->date_a}}</td>
  							<td>{{$value3->je_reference_module}}</td>
  							<td>{{$value3->je_reference_id}}</td>

  							@if($value3->jline_name_reference == 'customer')
  							<td>{{$value3->c_full_name}}</td>
  							@else
  							<td>{{$value3->v_full_name}}</td>
  							@endif
  							<td>{{$value3->jline_description}}</td>
  							<td class="text-right">{{currency('PHP', $value3->amount)}}</td>
  							<?php $balance += $value3->amount; ?>
  							<td class="text-right">{{currency('PHP', $balance)}}</td>
  						</tr>
    					@endforeach
      				<tr>
      					<td colspan="7"><b>Total for {{$chart_of_account[$key2]}}</b></td>
      					<td class="text-right">{{currency('PHP', $balance)}}</td>
      				</tr>	
       			@endforeach
         		</tbody>
         		</table>
         	</div>
      </div>
  </div>
</div>