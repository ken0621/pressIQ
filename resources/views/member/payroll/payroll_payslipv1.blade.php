<style type="text/css">

	@page { margin: 0px; }
	body { 
		margin: 0px; 
	}

	.border
	{
		border: 1px solid #000000;
	}
	.padding-5
	{
		padding:5px;
	}
	.padding-3
	{
		padding:3px;
	}
	.text-center
	{
		text-align: center;
	}
	.text-left
	{
		text-align: left;
	}
	.text-right
	{
		text-align: right;
	}
	td
	{
		font-size: 9px;
	}
</style>
<div class="main-container">
	<table cellpadding="5" cellspacing="0" class="" width="100%" >
		<tr>
		<?php 
			$counter=0; 
			$payslip_num = 100/$payslip->payslip_width;
			$col = 1;
		?>
	
		@foreach($_record as $brk)

				@if($counter==$payslip_num)
					</tr><tr>
					<?php $col++ ?>
				@endif		


				@if($col>2)
					
					</table>
					<table cellpadding="5" cellspacing="0" class="" width="100%">
						<tr>
							<td valign="top" width="25%"><div style="page-break-after: always;">&nbsp;</div></td>
						</tr>
						<tr>

					<?php $col=1 ?>
				@endif
				
				<?php ($counter>=$payslip_num) ? $counter=1 : $counter++ ?>

				<td valign="top" width="{{ $payslip->payslip_width }}%">
					<div class="div-payslip">
						<table cellpadding="5" cellspacing="0" class="border padding-5" width="100%">
							@if($payslip->include_company_logo == 1)
							<tr>
								<td colspan="2" class="{{$logo_position}} border padding-3">
									{{-- {{ $counter }} --}}
									@if($logo)
									<img src="{{ url($brk['company_logo']) }}" style="width:auto;height:50px;object-fit: contain;"><br>
									@endif
									<b>{{$brk['company_name']}}</b><br>
									<small>{{$brk['company_address']}}</small>
								</td>
							</tr>
							@endif
							<tr>
								<td colspan="2"></td>
							</tr>
							<tr>
								<td colspan="2" class="border">
									<table cellpadding="2" cellspacing="0">
										<tr>
											<td>Employee Name</td>
											<td>
												{{$brk['display_name']}}
											</td>
										</tr>
										@if($payslip->include_department == 1)
										<tr>
											<td>Department</td>
											<td>
												{{$brk['emp']->payroll_department_name}}
											</td>
										</tr>
										@endif
										@if($payslip->include_job_title == 1)
										<tr>
											<td>Job Title</td>
											<td>
												{{$brk['emp']->payroll_jobtitle_name}}
											</td>
										</tr>
										@endif
										<tr>
											<td>Payroll Period</td>
											<td>{{$brk['period']}}</td>
										</tr>
									</table>
								</td>
								
							</tr>
							<tr>
								<td valign="top" {{ $payslip->include_time_summary == 0 ? 'colspan=2' : '' }} >
									<table class="border" cellspacing="0" cellpadding="2" width="100%" >
										<tr>
											<td colspan="" class=""><b>EARNINGS</b></td>
										</tr>
										<tr>
											<td>Description</td>
											<td>Hrs.</td>
											<td>Amount</td>
										</tr>
										@foreach($brk['_ptkab']['additions'] as $additions)
											<tr>
												<td>{{ $additions['ptkab_label'] }}</td>
												<td></td>
												<td>{{ $additions['ptkab_amount'] }}</td>
											</tr>
										@endforeach
										
									</table>
								</td>
								@if($payslip->include_time_summary == 1)
								<td valign="top">
									<table class="border" cellspacing="0" cellpadding="2" width="100%" >
										<tr>
											<td colspan="2" class=""><b>DEDUCTIONS</b></td>
										</tr>
									
										@foreach($brk['_ptkab']['deductions'] as $deductions)
											<tr>
												<td>{{ $deductions['ptkab_label'] }}</td>
												<td>{{ $deductions['ptkab_amount'] }}</td>
											</tr>
										@endforeach

										@foreach($brk['_ptkab']['government_contributions'] as $government)
											<tr>
												<td>{{ $government['ptkab_label'] }}</td>
												<td>{{ $government['ptkab_amount'] }}</td>
											</tr>
										@endforeach
										
									</table>
								</td>
								@endif
							</tr>
							<tr>
								<td style="text-align:center" width="50%">
									<span>____________________</span>
									<p>Date Received</p>
								</td>
								<td style="text-align:center">
									<span>____________________</span>
									<p>Employee Signature</p>
								</td>
							</tr>
						</table>
					</div>
				</td>

		@endforeach
		
		</tr>
		</table>
	</table>

</div>
