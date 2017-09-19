@extends("member.member_layout")
@section("member_content")
<div class="wallet-encashment">
	<div class="main-member-header clearfix">
		<div class="left">
			<div class="icon">
				<img src="/themes/{{ $shop_theme }}/img/wallet-encashment.png">
			</div>
			<div class="text">
				<div class="name">Wallet Encashment</div>
				<div class="sub">In this tab you can request/view encashment history. </div>
			</div>
		</div>
		<div class="right">
			
		</div>
	</div>
	<div class="wallet-encashment-content">
		<div class="title">Encashment History</div>
		<div class="table-holder">
			<table class="table table-striped">
				<thead>
					<tr>
						<th class="text-left" width="100px">From</th>
						<th class="text-center" width="100px">To</th>
						<th class="text-center">Tax</th>
						<th class="text-center">Processing Fee</th>
						<th class="text-center">Amount</th>
						<th class="text-center">Total</th>
						<th class="text-left" width="100px">Status</th>
						<th class="text-left" width="100px">Breakdown</th>
						<th class="text-left" width="70px">PDF</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td class="text-left">Mr. Brown Lorem</td>
						<td class="text-left">Mrs. Brown Lorem</td>
						<td class="text-center">0</td>
						<td class="text-center">0</td>
						<td class="text-center">0</td>
						<td class="text-center">0</td>
						<td class="text-left">Lorem Ipsum</td>
						<td class="text-left">Lorem Ipsum</td>
						<td class="text-left">Lorem Ipsum</td>
					</tr>
				</tbody>
			</table>
		</div>
		<div class="title">Breakdown</div>
	</div>
</div>
@endsection
@section("member_script")
@endsection
@section("member_css")
<link rel="stylesheet" type="text/css" href="/themes/{{ $shop_theme }}/css/wallet_encashment.css">
@endsection