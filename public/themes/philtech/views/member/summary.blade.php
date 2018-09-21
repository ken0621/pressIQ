@extends("member.member_layout")
@section("member_content")
<!-- MLM MEMBER -->
<div class="dashboard">
	<div class="row clearfix">
		<div class="col-md-12">
			<div class="square-container">
				<div class="title"><i class="align-icon brown-icon-bar-chart"></i> <span>Wallet Summary</span></div>
				<div class="sub-container">
					<div class="table-holder">
						<table class="table table-striped table-bordered table-hover table-condensed" style="margin-bottom : 0;">
							<thead>
								<tr>
									<th>Slot No</th>
									<th>Current Wallet</th>
									<th>Total Pay-out</th>
									<th>Total Earnings</th>
									<!-- <th>Total Points</th> -->
								</tr>
							</thead>
							<tbody>
								@foreach($_wallet as $key => $wallet)
									<tr>
										<td>{{ $key }}</td>
										<td>PHP {{ number_format($wallet->current_wallet, 2) }}</td>
										<td>PHP {{ number_format($wallet->total_payout, 2) }}</td>
										<td>PHP {{ number_format($wallet->total_earnings, 2) }}</td>
										<!-- <td>{{ number_format($wallet->total_points, 2) }}</td> -->
									</tr>
								@endforeach
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-12">
			<div class="square-container">
				<div class="title"><i class="align-icon brown-icon-gift"></i> <span>Reward Points</span></div>
				<div class="sub-container">
					<div class="table-holder">
						@if(count($_point_plan) > 0)
							<table class="table table-striped table-bordered table-hover table-condensed" style="margin-bottom : 0;">
								<thead>
									<tr>
										<th>Slot No</th>
										@foreach($_point_plan as $plan)
											<th>
												@if($plan->label == "Repurchase Cashback")
													VIP Cashback
												@elseif($plan->label == "Leadership Bonus")
													Leadership Points
												@else
													{{ $plan->label }}
												@endif
											</th>
										@endforeach
									</tr>
								</thead>
								<tbody>
									@foreach($_points as $key => $points)
										<tr>
											<td>{{ $key }}</td>
											@foreach($_point_plan as $plan)
											<td>{{ number_format($points->{ $plan->string_plan }, 2) }}</td>
											@endforeach
										</tr>
									@endforeach
								</tbody>
							</table>
						@endif
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-12">
			<div class="square-container">
				<div class="title"><i class="fa fa-table"></i> <span>Commission Summary</span></div>
				<div class="sub-container">
					<div class="table-holder">
						<table class="table table-striped table-bordered table-hover table-condensed" style="margin-bottom : 0;">
							<thead>
								<tr>
									<th>Slot No</th>
									@foreach($_wallet_plan as $plan)
									@if($plan->label == "Admin Refill" || $plan->label == "Vmoney" || $plan->label == "Wallet Refill" || $plan->label == "Wallet Transfer" || $plan->label == "Repurchase")
									@else
									@if($plan->label == "Membership Matching")
									<th>Matching</th>
									@elseif($plan->label == "Vmoney")
									<th>E-Money</th>
									@elseif($plan->label == "Direct")
									<th>Direct Commission</th>
									@elseif($plan->label == "Indirect")
									<th>Override Commission</th>
									@elseif($plan->label == "Unilevel")
									<th>Unilevel Cashback</th>
									@else
									<th>{{ $plan->label }}</th>
									@endif
									@endif
									@endforeach
								</tr>
							</thead>
							<tbody>
								@foreach($_wallet as $key => $wallet)
								<tr>
									<td>{{ $key }}</td>
									@foreach($_wallet_plan as $plan)
									@if($plan->label == "Admin Refill" || $plan->label == "Vmoney" || $plan->label == "Wallet Refill" || $plan->label == "Wallet Transfer" || $plan->label == "Repurchase")
									@else
									<td>{{ number_format($wallet->{ $plan->string_plan }, 2) }}</td>
									@endif
									@endforeach
								</tr>
								@endforeach
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-12">
			<div class="square-container">
				<div class="title"><i class="fa fa-table"></i> <span>Wallet Movement</span></div>
				<div class="sub-container">
					<div class="table-holder">
						<table class="table table-striped table-bordered table-hover table-condensed" style="margin-bottom : 0;">
							<thead>
								<tr>
									<th>Slot No</th>
									@foreach($_wallet_plan as $plan)
									@if($plan->label == "Admin Refill" || $plan->label == "Wallet Refill" || $plan->label == "Wallet Transfer" || $plan->label == "Repurchase")
									<th>{{ $plan->label }}</th>
									@elseif($plan->label == "Vmoney")
									<th>E-Money</th>
									@else		
									@endif
									@endforeach
								</tr>
							</thead>
							<tbody>
								@foreach($_wallet as $key => $wallet)
								<tr>
									<td>{{ $key }}</td>
									@foreach($_wallet_plan as $plan)
									@if($plan->label == "Admin Refill" || $plan->label == "Vmoney" || $plan->label == "Wallet Refill" || $plan->label == "Wallet Transfer" || $plan->label == "Repurchase")
									<td>{{ number_format($wallet->{ $plan->string_plan }, 2) }}</td>
									@endif
									@endforeach
								</tr>
								@endforeach
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-12">
			<div class="square-container">
				<div class="title">VIP Cashback Wallet</div>
				<div class="sub-container">
					<div class="table-holder">
						<table class="table table-striped table-bordered table-hover table-condensed" style="margin-bottom : 0;">
							<thead>
								<tr>
									<th>Slot No</th>
									<th>Points</th>
								</tr>
							</thead>
							<tbody>
								@foreach($_points as $key => $value)
								<tr>
									<td>{{ $key }}</td>
									<td>{{ number_format($value->repurchase_cashback, 2) }}</td>
								</tr>
								@endforeach
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection

@section("member_script")

@endsection

@section("member_css")
<style type="text/css">
.dashboard .square-container {
    border: 1px solid #ddd;
    margin: 10px 5px;
}

.dashboard .square-container .title {
    color: #000;
    font-size: 21px;
    letter-spacing: 0.5px;
    font-weight: 400;
    padding: 5px 15px;
    margin-top: 5px;
    border-bottom: 1px solid #ddd;
}

.dashboard .square-container .sub-container {
    padding: 10px;
    background-color: #fff;
}

.dashboard {
    font-family: "Open Sans",sans-serif;
}
</style>
@endsection