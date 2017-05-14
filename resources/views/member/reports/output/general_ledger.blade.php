<div class="panel panel-default panel-block panel-title-block">
    <div class="panel-heading">
       <div class="table-reponsive">
       		<table class="table table-bordered table-condensed collaptable">
       		<tr>
       			<th>Date</th>
       			<th>Transaction Type</th>
       			<th>Num</th>
       			<th>Name</th>
       			<th>Memo/Discription</th>
       			<!-- <th>SPLIT</th> -->
       			<th>Amount</th>
       			<th>Balance</th>
       		</tr>
       		<tbody>
       			
   				@foreach($chart_of_account_data as $key2 => $value2)
   				<tr data-id="{{$key2}}" data-parent="" >
       				<td colspan="20">{{$chart_of_account[$key2]}}</td>
       			</tr>
       				<?php $balance = 0;?>
   					@foreach($value2 as $key3 => $value3)
   						<?php $amount = debit_credit($value3->jline_type, $value3->jline_amount); ?>
						<tr data-id="{{$key3 }}" data-parent="{{$key2}}">
							<td>{{$value3->date_a}}</td>
							<td>{{$value3->je_reference_module}}</td>
							<td>{{$value3->je_reference_id}}</td>

							@if($value3->jline_name_reference == 'customer')
							<td>{{$value3->c_full_name}}</td>
							@else
							<td>{{$value3->v_full_name}}</td>
							@endif
							<td>{{$value3->jline_description}}</td>
							<td>{{currency('PHP', $amount)}}</td>
							<?php $balance += $amount; ?>
							<td>{{currency('PHP', $balance)}}</td>
						</tr>
					@endforeach
				<tr>
					<td colspan="6"><b>Total for {{$chart_of_account[$key2]}}</b></td>
					<td>{{currency('PHP', $balance)}}</td>
				</tr>	
   				@endforeach
       		</tbody>
       		</table>
       	</div>
    </div>
</div>     


	
<script type="text/javascript">
	$(document).ready(function(){
	  
	});
</script>