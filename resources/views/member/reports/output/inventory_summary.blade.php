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
					<tbody class="{{ $total_asset_value = 0 }}" class=" {{ $total_retail_value = 0 }}">
						@if(count($_report) > 0)
							@foreach($_report as $key => $report)							
							<tr class="{{$total_asset_value += ($report['total_cost']/ $total_cost_total) * 100}}" class="{{$total_retail_value += ($report['total_price']/ $total_price_total) * 100}}">
								<td class="text-center">{{$report['item_id']}}</td>
								<td class="text-center">{{$report['item_name']}}</td>
								<td class="text-center">{{$report['inventory_count']}}</td>
								<td class="text-center"></td>
								<td class="text-right">{{number_format($report['item_cost'], 2)}}</td>
								<td class="text-right">{{number_format($report['total_cost'], 2)}}</td>
								<td class="text-right">{{number_format(($report['total_cost']/ $total_cost_total) * 100, 2).'%'}}</td>
								<td class="text-right">{{number_format($report['item_price'], 2)}}</td>
								<td class="text-right">{{number_format($report['total_price'], 2)}}</td>
								<td class="text-right">{{number_format(($report['total_price']/ $total_price_total) * 100, 2).'%'}}</td>
							</tr>
							@endforeach
							<tr style="font-weight: bold;">
								<td class="text-center" colspan="2">TOTAL</td>
								<td class="text-center">{{$inventory_count_total }}</td>
								<td></td>
								<td class="text-right">{{number_format($cost_total, 2) }}</td>
								<td class="text-right">{{number_format($total_cost_total, 2) }}</td>
								<td class="text-right">{{number_format($total_asset_value, 2)}}%</td>
								<td class="text-right">{{number_format($price_total, 2) }}</td>
								<td class="text-right">{{number_format($total_price_total, 2) }}</td>
								<td class="text-right">{{number_format($total_retail_value, 2)}}%</td>
							</tr>
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