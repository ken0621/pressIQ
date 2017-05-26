<div class="report-container">
	<div class="panel panel-default panel-block panel-title-block panel-report load-data">
		<div class="panel-heading load-content">
			@include('member.reports.report_header');
			<div class="table-reponsive">
				@if(count($agent) > 0)
				<table class="table table-condensed collaptable">
					<thead style="text-transform: uppercase">
						<tr>
							<th>#</th>
							<th>Agent Name</th>
							<th>Sales</th>
							<th>Discrepancy</th>
							<th>ILR Losses</th>
							<th>ILR Over</th>
							<th>Total Discrepancy</th>
						</tr>
					</thead>
					<tbody>
						@foreach($agent as $key => $agnt)
							<tr>
								<td>{{$key+1}}</td>
								<td>{{$agnt['agent_name']}}</td>
								<td>{{currency('PHP',$agnt['total_sales'])}}</td>
								<td>{{currency('PHP',$agnt['discrepancy'])}}</td>
								<td>{{currency('PHP',$agnt['total_loss'])}}</td>
								<td>{{currency('PHP',$agnt['total_over'])}}</td>
								<td>{{currency('PHP',$agnt['total_discrepancy'])}}</td>
							</tr>
						@endforeach						
					</tbody>
				</table>
				@else	
				<h3 class="text-center">No Transaction</h3>
				@endif
			</div>
			<h5 class="text-center">---- {{$now or ''}} ----</h5>
		</div>
	</div>
</div>