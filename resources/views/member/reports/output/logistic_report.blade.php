<div class="report-container">
	<div class="panel panel-default panel-block panel-title-block panel-report load-data">
		<div class="panel-heading load-content">
			@include('member.reports.report_header')
			<h4 class="text-center">{{$payment_method or 'All Payment Type'}}</h4>
			<div class="table-reponsive">
				
				<table class="table table-condensed collaptable">
					<thead style="text-transform: uppercase">
						<tr>
							<th class="text-center">#</th>
							<th class="text-center">Date</th>
							<th class="text-center">Customer Name</th>
							<th class="text-center">Contact Number</th>
							<th class="text-center">Slot ID</th>
							<th class="text-center">Slot No</th>
							<th class="text-center">TIN</th>
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
								<td class="text-center">{{date('F d, Y',strtotime($report->transaction_date))}}</td>
								<td class="text-center">{{ucwords($report->first_name.' '.$report->middle_name.' '.$report->last_name)}}</td>
								<td class="text-center">{{$report->customer_mobile or $report->contact}}</td>
								<td class="text-center">{{strtoupper($report->slot_id)}}</td>
								<td class="text-center">{{strtoupper($report->slot_no)}}</td>
								<td class="text-center">{{$report->tin_number or '- - -'}}</td>
								<td class="text-center">{{$report->transaction_number}}</td>
								<td class="text-center">{{$report->item_name}}</td>
								<td class="text-center">{{$report->quantity}}</td>
							</tr>
							@endforeach
						@else
						<tr><td colspan="10"><h3 class="text-center">No Transaction</h3></td></tr>
						@endif							
					</tbody>
				</table>
			</div>
			<h5 class="text-center">---- {{$now or ''}} ----</h5>
		</div>
	</div>
</div>