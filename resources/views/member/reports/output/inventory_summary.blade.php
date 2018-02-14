<div class="report-container">
	<div class="panel panel-default panel-block panel-title-block panel-report load-data">
		<div class="panel-heading load-content">
			@include('member.reports.report_header')
			<div class="table-reponsive">
				<table class="table table-condensed collaptable">
					<thead style="text-transform: uppercase">
						<tr>
							<th class="text-center">Item</th>
							<th class="text-center">Description</th>
							<th class="text-center">Stock-on-hand</th>
							<th class="text-center">U/M</th>
							<th class="text-center">Cost</th>
							<th class="text-center">Total Cost</th>
							<th class="text-center">% of Total Asset</th>
							<th class="text-center">Sales Price</th>
							<th class="text-center">Total Sales</th>
							<th class="text-center">% of Total Retail</th>
						</tr>
					</thead>
					<tbody>
						@if(count($_report) > 0)
							@foreach($_report as $key => $report)
							<tr>
								<td class="text-center">{{$report['item_id']}}</td>
								<td class="text-center">{{$report['item_name']}}</td>
								<td class="text-center">{{$report['invty_count']}}</td>
								<td class="text-center"></td>
								<td class="text-center">{{$report['item_cost']}}</td>
								<td class="text-center">{{$report['item_cost'] * $report['invty_count']}}</td>
								<td class="text-center"> %</td>
								<td class="text-center">{{$report['item_price']}}</td>
								<td class="text-center">{{$report['item_price'] * $report['invty_count']}}</td>
								<td class="text-center"> %</td>
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