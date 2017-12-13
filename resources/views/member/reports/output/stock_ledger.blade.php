<div class="report-container">
	<div class="panel panel-default panel-block panel-title-block panel-report load-data">
		<div class="panel-heading load-content">
			@include('member.reports.report_header')
			<h4 class="text-center">{{$item or 'All Items'}}</h4>
			<div class="table-reponsive">
				<table class="table table-condensed collaptable">
					<thead style="text-transform: uppercase">
						
						<tr>
							
							<th class="text-center">Item SKU</th>
							<th class="text-center">Item Description</th>
							<th class="text-center">Date of Transaction</th>
							<th class="text-center">Vendor</th>
							<th class="text-center">Quantity in</th>
							<th class="text-center">Customer</th>
							<th class="text-center">Quantity out</th>
							<th class="text-center">Remaining Quantity</th>
							
						</tr>

					</thead>
					<tbody>
						@if(count($_report) > 0)
							@foreach($_report as $report)
							<tr>
								<td class="text-center">{{ $report->item_sku }}</td>
								<td class="text-center">{{ $report->item_name }}</td>
								<td class="text-center">{{ date('m/d/y',strtotime($report->history_date)) }}</td>
								@if($report->history_type == 'RR')
									<td class="text-center">{{ $report->vendor_company }}</td>
									<td class="text-center">{{ $report->quantity }}</td>
								@else
									<td class="text-center"></td>
									<td class="text-center"></td>
								@endif
								
								@if($report->history_type == 'WIS')
									<td class="text-center">{{ $report->vendor_company }}</td>
									<td class="text-center">-{{ $report->quantity }}</td>
								@else
									<td class="text-center"></td>
									<td class="text-center"></td>
								@endif	

								<td class="text-center">{{ $report->running_quantity }}</td>
							</tr>
							@endforeach
						@else
						<tr><td colspan="22"><h3 class="text-center">No Transaction</h3></td></tr>
						@endif						
					</tbody>
				</table>
			</div>
			<h5 class="text-center">---- {{$now or ''}} ----</h5>
		</div>
	</div>
</div>

<style type="text/css">
	tr { page-break-inside: avoid; }
</style>