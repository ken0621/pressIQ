@extends("member.member_layout")
@section("member_content")
<div class="wallet-encashment">
	<div class="main-member-header clearfix">
		<div class="left">
			<div class="icon">
				<img src="/themes/{{ $shop_theme }}/img/wallet-encashment.png">
			</div>
			<div class="text">
				<div class="name">
					<div>Wallet Encashment</div>
				</div>
				<div class="sub">In this tab you can request/view encashment history. </div>
			</div>
		</div>
		<div class="right">
			<div class="text-right">
				<button type="button" class="btn btn-default"><i class="fa fa-bank"></i> PAYOUT METHOD</button>
				<button type="button" class="btn btn-primary"><i class="fa fa-credit-card"></i> REQUEST PAYOUT</button>
			</div>
		</div>
	</div>
	<div class="wallet-encashment-content">
		<div class="title">
			Encashment History

		</div>
		<div class="table-holder table-responsive">
			<table class="table table-striped">
				<thead>
					<tr>
						<th class="text-left">Release Date</th>
						<th class="text-center" width="200px">Method</th>
						<th class="text-center" width="200px">Amount</th>
						<th class="text-left" width="200px">Tax</th>
						<th class="text-right" width="200px">Sub Total</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td class="text-left">October 12, 2017</td>
						<td class="text-center">REQUESTED (EON)</td>
						<td class="text-center"><b>PHP 15,000.00</b></td>
						<td class="text-left">10% (PHP 1,500.00)</td>
						<td class="text-right"><a href='javascript:'><b>PHP 13,500.00</b></a></td>
					</tr>
					<tr>
						<td class="text-left">October 17, 2017</td>
						<td class="text-center">WALLET PURCHASE</td>
						<td class="text-center"><b>PHP 1,000.00</b></td>
						<td class="text-left">12% (PHP 120.00)</td>
						<td class="text-right"><a href='javascript:'><b>PHP 880.00</b></a></td>
					</tr>
				</tbody>
				<tfoot style="background-color: #f3f3f3; font-size: 16px;">
					<tr>
						<td class="text-right"></td>
						<td class="text-center"></td>
						<td class="text-center"><b>PHP 16,000.00</b></td>
						<td class="text-right"></td>
						<td class="text-right"><b>PHP 14,380.00</b></td>
					</tr>
				</tfoot>
			</table>
		</div>
	</div>
</div>
@endsection
@section("member_script")
@endsection
@section("member_css")
<link rel="stylesheet" type="text/css" href="/themes/{{ $shop_theme }}/css/wallet_encashment.css">
@endsection