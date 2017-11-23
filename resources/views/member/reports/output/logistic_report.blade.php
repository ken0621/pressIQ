<div class="report-container">
	<div class="panel panel-default panel-block panel-title-block panel-report load-data">
		<div class="panel-heading load-content">
			@include('member.reports.report_header');
			<div class="table-reponsive">
				
				<table class="table table-condensed collaptable">
					<thead style="text-transform: uppercase">
						<tr>
							<th>Invoice No.</th>
							<th>Product</th>
							<th>Quantity</th>
						</tr>
					</thead>
					<tbody>
						
							<tr>
								<td></td>
								<td></td>
								<td></td>
							</tr>
											
					</tbody>
				</table>
					
				<h3 class="text-center">No Transaction</h3>
				
			</div>
			<h5 class="text-center">---- {{$now or ''}} ----</h5>
		</div>
	</div>
</div>