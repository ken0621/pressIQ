@extends("member.member_layout")
@section("member_content")
<!-- MLM MEMBER -->
<div class="dashboard">
	<div class="row clearfix">
		<div class="col-md-12">
			<div class="square-container">
				<div class="title"><i class="align-icon brown-icon-bar-chart"></i> Wallet Summary</div>
				<div class="sub-container">
					<div class="table-holder">
						<table class="table table-striped table-bordered table-hover table-condensed" style="margin-bottom : 0;">
							<thead>
								<tr>
									<th>Slot No</th>
									<th>Current Wallet</th>
									<th>Total Pay-out</th>
									<th>Current Slot(s)</th>
									<th>Total Earnings</th>
									<th>Total Points</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td>23DS</td>
									<td>0.00</td>
									<td>0.00</td>
									<td>0.00</td>
									<td>0.00</td>
									<td>0.00</td>
								</tr>
								<tr>
									<td>23DS</td>
									<td>0.00</td>
									<td>0.00</td>
									<td>0.00</td>
									<td>0.00</td>
									<td>0.00</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-12">
			<div class="square-container">
				<div class="title"><i class="align-icon brown-icon-bar-chart"></i> Reward Points</div>
				<div class="sub-container">
					<div class="table-holder">
						<table class="table table-striped table-bordered table-hover table-condensed" style="margin-bottom : 0;">
							<thead>
								<tr>
									<th>Slot No</th>
									<th>Executive Bonus</th>
									<th>Total Pay-out</th>
									<th>Current Slot(s)</th>
									<th>Total Earnings</th>
									<th>Total Points</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td>23DS</td>
									<td>0.00</td>
									<td>0.00</td>
									<td>0.00</td>
									<td>0.00</td>
									<td>0.00</td>
								</tr>
								<tr>
									<td>23DS</td>
									<td>0.00</td>
									<td>0.00</td>
									<td>0.00</td>
									<td>0.00</td>
									<td>0.00</td>
								</tr>
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
</style>
@endsection