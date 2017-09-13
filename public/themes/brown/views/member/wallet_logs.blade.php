@extends("member.member_layout")
@section("member_content")
<div class="wallet-logs">
	<div class="main-member-header clearfix">
		<div class="left">
			<div class="icon">
				<img clases="wallet" src="/themes/{{ $shop_theme }}/img/wallet-encashment.png">
			</div>
			<div class="text">
				<div class="name">Wallet Logs</div>
			</div>
		</div>
		<div class="right">
			
		</div>
	</div>
	<div class="wallet-logs-content">
		<div class="wallet-profile">
			<div class="img">
				<img src="/themes/{{ $shop_theme }}/img/wallet-pic.png">
			</div>
		</br>
	</br>
</br>	
<div class="name"><b>Mr. Brown Lorem Ipsum</b></div>
<div class="label-name">Name</div>
<div class="p1"><b>brown&proudsolidgroup@gmail.com</b></div>
<div class="label-name1">Email Address</div>
<div class="p2"><b>1958-11-30</b></div>
<div class="label-name2">Birtdate</div>
</div>
</div>
</br>
</br>
<div class="container">
	<p class="p3"><b>Income Summary</b></p>
	<br>            
	<table class="table table-hover table_report">
		<thead>
			<tr>
				<th>Start Balance</th>
				<th>Complan</th>
				<th>Amount</th>
				<th>New Balance</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td><p>PHP 0.00</p>
					<p>PHP 20,500.00</p>
					<p>Date: 2017-06-28</p>
				</td>
				<td><p>Direct Referral Bonus</p>
					<p>Pairing Reward</p></td>
					<td><p>PHP 20,500.00</p>
						<p>PHP 36,000.00</p></td>
						<td><p>PHP 20,500.00</p>
							<p>PHP 56,500.00</p>
							<p>End Balance: PHP 56,500.00</p>
						</td>
					</tr>
				</tr>
				<tr>
					<td><p>PHP 0.00</p>
						<p>PHP 20,500.00</p>
						<p>Date: 2017-06-28</p>
					</td>
					<td><p>Direct Referral Bonus</p>
						<p>Pairing Reward</p></td>
						<td><p>PHP 20,500.00</p>
							<p>PHP 36,000.00</p></td>
							<td><p>PHP 20,500.00</p>
								<p>PHP 56,500.00</p>
								<p>End Balance: PHP 56,500.00</p>
							</td>
						</tr>
						<tr>
							<td><p>PHP 0.00</p>
								<p>PHP 20,500.00</p>
								<p>Date: 2017-06-28</p>
							</td>
							<td><p>Direct Referral Bonus</p>
								<p>Pairing Reward</p></td>
								<td><p>PHP 20,500.00</p>
									<p>PHP 36,000.00</p></td>
									<td><p>PHP 20,500.00</p>
										<p>PHP 56,500.00</p>
										<p>End Balance: PHP 56,500.00</p>
									</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
				@endsection
				@section("member_script")
				@endsection
				@section("member_css")
				<link rel="stylesheet" type="text/css" href="/themes/{{ $shop_theme }}/css/wallet_logs.css">
				@endsection