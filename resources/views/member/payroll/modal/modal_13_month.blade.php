<form class="global-submit" role="form" action="{link_submit_here}" method="post">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal">×</button>
		<h4 class="modal-title">Process 13 month</h4>
	</div>
	<div class="modal-body form-horizontal">
		<table class="table table-condensed table-bordered">
			<thead>
				<tr>
					<th></th>
					<th>Payroll Period</th>
					<th>Basic Earnings</th>
					<th></th>
					<th>Sub Total</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td class="text-center" valign="center">
						<input type="checkbox" name="">
					</td>
					<td>Check All</td>
					<td></td>
					<td></td>
					<td></td>
				</tr>
				@foreach($_13_month as $13_month)
				<tr>
					<td class="text-center" valign="top">
						<input type="checkbox" name="">
					</td>
					<td>
						{{date('F d, Y', strtotime($13_month->payroll_period_start))}} to  {{date('F d, Y', strtotime($13_month->payroll_period_end))}}
					</td>
					<td class="text-right">
						{{number_format($13_month->regular_salary)}}
					</td>
					<td>
						divide by 12
					</td>
					<td class="text-right">
						
					</td>
				</tr>
				@endforeach
				<tr>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td class="text-right"></td>
				</tr>
			</tbody>
		</table>
	</div>
	<div class="modal-footer">
		<button type="button" class="btn btn-def-white btn-custom-white" data-dismiss="modal">Close</button>
		<button class="btn btn-primary btn-custom-primary" type="button"">Submit</button>
	</div>
</form>
