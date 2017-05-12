<div class="panel panel-default panel-block panel-title-block">
    <div class="panel-heading">
       <div class="table-reponsive">
       		<table class="table table-bordered table-condensed">
       		<?php 
       		$sum_income = 0;
			$sum_cogs = 0;
			$sum_expense = 0;
			$sum_other_ex = 0;
			$sum_other_in = 0;
			$sum_gross = 0;
			$sum_net_operating = 0;
                     $amount = 0;
			?>
                            <tr style="background-color: gray;">
                                   <td colspan="20"></td>
                            </tr>
       			@if(isset($account_income[11]))
       			<tr>
       				<td colspan="20">{{$account_income[11]->chart_type_name}}</td>
       			</tr>
       				<?php $sum_income = 0; ?>

       				@foreach($sum[11] as $key => $value)
                                   <?php $amount = debit_credit($value->jline_type, $value->sum); ?>
       				<tr>
						<td></td>
       					<td>{{$value->account_name}}</td>
       					<td>{{currency('PHP', $amount)}}</td>
       				</tr>
       				<?php $sum_income += $amount; ?>
       				@endforeach
       				
       				<tr>
       					<td><b>Total {{$account_income[11]->chart_type_name}}</b></td>
       					<td></td>
       					<td>{{currency('PHP', $sum_income)}}</td>
       				</tr>
       			@endif
                            <tr style="background-color: gray;">
                                   <td colspan="20"></td>
                            </tr>
       			@if(isset($account_income[12]))
       			<tr>
       				<td colspan="20">{{$account_income[12]->chart_type_name}}</td>

       			</tr>
       				<?php $sum_cogs = 0; ?>
       				@foreach($sum[12] as $key => $value)
                                   <?php $amount = debit_credit($value->jline_type, $value->sum); ?>
       				<tr>
						<td></td>
       					<td>{{$value->account_name}}</td>
       					<td>{{currency('PHP', $amount)}}</td>
       				</tr>
       				<?php $sum_cogs += $amount; ?>
       				@endforeach
       				
       				<tr>
       					<td><b>Total {{$account_income[12]->chart_type_name}}</b></td>
       					<td></td>
       					<td>{{currency('PHP', $sum_cogs)}}</td>
       				</tr>
       			@endif
                            <tr style="background-color: gray;">
                                   <td colspan="20"></td>
                            </tr>
       			<!-- Gross Profit -->
				<tr>
					<td>Gross Profit</td>
					<td></td>
					<td>{{ currency('PHP', $sum_gross = $sum_income + $sum_cogs) }}</td>
				</tr>
				<!-- End Gross Profit -->
                            <tr style="background-color: gray;">
                                   <td colspan="20"></td>
                            </tr>
       			@if(isset($account_income[13]))
       			<tr>
       				<td colspan="20">{{$account_income[13]->chart_type_name}}</td>

       			</tr>
       				<?php $sum_expense = 0; ?>
       				@foreach($sum[13] as $key => $value)
                                   <?php $amount = debit_credit($value->jline_type, $value->sum); ?>
       				<tr>
						<td></td>
       					<td>{{$value->account_name}}</td>
       					<td>{{currency('PHP', $amount)}}</td>
       				</tr>
       				<?php $sum_expense += $amount; ?>
       				@endforeach
       				
       				<tr>
       					<td><b>Total {{$account_income[13]->chart_type_name}}</b></td>
       					<td></td>
       					<td>{{currency('PHP', $sum_expense)}}</td>
       				</tr>
       			@endif
                            <tr style="background-color: gray;">
                                   <td colspan="20"></td>
                            </tr>
				<!-- Net Operating Income -->
				<tr>
					<td><b>Net Operating Income</b></td>
					<td></td>
					<td>{{ currency('PHP', $sum_net_operating = $sum_gross - $sum_expense)}}</td>
				</tr>
				<!-- End Net Operation Income -->
                            <tr style="background-color: gray;">
                                   <td colspan="20"></td>
                            </tr>
			
       			@if(isset($account_income[14]))
       			<tr>
       				<td colspan="20" >{{$account_income[14]->chart_type_name}}</td>

       			</tr>
       				<?php $sum_other_ex = 0; ?>
       				@foreach($sum[14] as $key => $value)
                                   <?php $amount = debit_credit($value->jline_type, $value->sum); ?>
       				<tr>
						<td></td>
       					<td>{{$value->account_name}}</td>
       					<td>{{currency('PHP', $amount)}}</td>
       				</tr>
       				<?php $sum_other_ex += $amount; ?>
       				@endforeach
       				
       				<tr>
       					<td><b>Total {{$account_income[14]->chart_type_name}}</b></td>
       					<td></td>
       					<td>{{currency('PHP', $sum_other_ex)}}</td>
       				</tr>
       			@endif
                            <tr style="background-color: gray;">
                                   <td colspan="20"></td>
                            </tr>
       			@if(isset($account_income[15]))
       			<tr>
       				<td colspan="20" >{{$account_income[15]->chart_type_name}}</td>

       			</tr>
       				<?php $sum_other_in = 0; ?>
       				@foreach($sum[15] as $key => $value)
                                   <?php $amount = debit_credit($value->jline_type, $value->sum); ?>
       				<tr>
						<td></td>
       					<td>{{$value->account_name}}</td>
       					<td>{{currency('PHP', $amount)}}</td>
       				</tr>
       				<?php $sum_other_in += $amount; ?>
       				@endforeach
       				
       				<tr>
       					<td><b>Total {{$account_income[15]->chart_type_name}}</b></td>
       					<td></td>
       					<td>{{currency('PHP', $sum_other_in)}}</td>
       				</tr>
       			@endif
                            <tr style="background-color: gray;">
                                   <td colspan="20"></td>
                            </tr>
				<!-- Net Operating Income -->
				<tr>
					<td><b>Net Income</b></td>
					<td></td>
					<td>{{ currency('PHP', $sum_net_operating = $sum_net_operating + $sum_other_ex + $sum_other_in) }}</td>
				</tr>
				<!-- End Net Operation Income -->
                            <tr style="background-color: gray;">
                                   <td colspan="20"></td>
                            </tr>



       		</table>
       </div>
    </div>
</div>