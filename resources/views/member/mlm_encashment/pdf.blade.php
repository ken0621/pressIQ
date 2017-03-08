<div class="">
	@if(isset($encashment_process))
		@if($encashment_process != null)
			@if($log != null)
				@if(isset($customer_view))
					{!! $customer_view !!}
				@endif
				<table class="table table-condensed">
					<tr>
						<td>Date</td>
						<td>Complan</td>
						<td>Amount</td>
					</tr>
					
					@foreach($log as $key => $value)
					<tr>
						<td>{{$value->wallet_log_date_created}}</td>
						<td>{{$value->wallet_log_plan}}</td>
						<td>{{$value->wallet_log_amount}}</td>
					</tr>
					@endforeach

					@if(isset($log_final))
					<tr>
						<td colspan="40">
							<hr>
						</td>
					</tr>
					<tr>
						<td>{{$log_final->wallet_log_date_created}}</td>
						<td>{{$log_final->wallet_log_plan}}</td>
						<td>{{$log_final->wallet_log_amount}}</td>
					</tr>

					<tr>
						<td colspan="40">
							<hr>
						</td>
					</tr>
					<?php 
                        $value2 = $log_final->wallet_log_amount * (-1);
                        $p_fee_type = $encashment_process->enchasment_process_p_fee_type;
                        $p_fee = $encashment_process->enchasment_process_p_fee;
                        $tax_p =    $encashment_process->enchasment_process_tax_type;
                        $tax = $encashment_process->enchasment_process_tax;
                        if($p_fee_type == 0)
                        {
                            $value2 = $value2 - $p_fee;
                        }
                        else
                        {
                            $p_fee = ($value2 * $p_fee)/100;
                            $value2 = $value2 - $p_fee;
                        }

                        if($tax_p == 0)
                        {
                            $value2 = $value2 - $tax;
                        }
                        else
                        {
                            $tax = ($value2 * $tax)/100;
                            $value2 = $value2-$tax;
                        }
                    ?>
                    <tr>
						<td></td>
						<td>
							<span class="pull-right">
								Subtotal
							</span>
						</td>
						<td>{{$log_final->wallet_log_amount * (-1)}}</td>
					</tr>
                    <tr>
						<td></td>
						<td>
							<span class="pull-right">
								Processing Fee
							</span>
						</td>
						<td>{{$p_fee}}</td>
					</tr>
					<tr>
						<td></td>
						<td>
							<span class="pull-right">
								Tax
							</span>
						</td>
						<td>{{$tax}}</td>
					</tr>
					<tr>
						<td></td>
						<td>
							<span class="pull-right">
								Total
							</span>
						</td>
						<td>{{$value2}}</td>
					</tr>
					<tr>
						<td colspan="40">
							<hr>
						</td>
					</tr>
					@if($log_final->encashment_process_type == 0)
					<tr>
						<td colspan="40">
							<form class="global-submit" method="post" action="/member/mlm/encashment/view/breakdown/process">
							{!! csrf_field() !!}
							<label>Remarks</label>
							<textarea class="form-control" name="wallet_log_remarks"></textarea>
							<br>
							<input type="hidden" name="slot_id" value="{{$log_final->wallet_log_slot}}">
							<input type="hidden" name='wallet_log_id' value="{{$log_final->wallet_log_id}}">
							<input type="hidden" name="encashment_process" value="{{$encashment_process->encashment_process}}">
							</form>
						</td>
					</tr>
					@else
					<tr>
						<td colspan="40">
							<label>Status</label>
							<input type="text" class="form-control" value="Processed" readonly>
							<label>Remarks</label>
							<textarea class="form-control" name="wallet_log_remarks" readonly>{{$log_final->wallet_log_remarks}}</textarea>
							<br>
						</td>
					</tr>
					@endif

					@endif
				</table>


			@endif
		@endif
	@endif	
	<hr>

</div>