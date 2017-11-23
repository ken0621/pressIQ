<div class="report-container">
	<div class="panel panel-default panel-block panel-title-block panel-report load-data">
		<div class="panel-heading load-content">
			@include('member.reports.report_header')
			<div class="table-reponsive">
				
				<table class="table table-condensed collaptable">
					<thead style="text-transform: uppercase">
						<tr>
							<th class="text-center">#</th>
							<th class="text-center">Invoice No.</th>
							<th class="text-center">Product</th>
							<th class="text-center">Quantity</th>
						</tr>
					</thead>
					<tbody>
						@if(count($_report) > 0)
							@foreach($_report as $key => $report)
							<tr>
								<td class="text-center">{{$key+1}}</td>
								<td class="text-center">{{$report->transaction_number}}</td>
								<td class="text-center">{{$report->item_name}}</td>
								<td class="text-center">{{$report->quantity}}</td>
							</tr>
							@endforeach
						@else
						<tr><td colspan="3"><h3 class="text-center">No Transaction</h3></td></tr>
						@endif							
					</tbody>
				</table>
			</div>
			<h5 class="text-center">---- {{$now or ''}} ----</h5>
		</div>
	</div>
</div>