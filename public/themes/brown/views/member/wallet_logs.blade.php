@extends("member.member_layout")
@section("member_content")
<div class="wallet-logs-container">
	<div class="main-member-header clearfix">
		<div class="left">
			<div class="icon">
				<img src="/themes/{{ $shop_theme }}/img/wallet-encashment.png">
			</div>
			<div class="text">
				<div class="name">Wallet Logs</div>
			</div>
		</div>
	</div>
	<div class="wallet-logs-content">
		<div class="wallet-profile">
			<div class="img">
				<img src="/themes/{{ $shop_theme }}/img/wallet-pic.png">
<<<<<<< HEAD
			</div>
			{{-- </br>
			</br>
			</br> --}}
			<div>
				<div class="name"><b>Mr. Brown Lorem Ipsum</b></div>
				<div class="label-name">Name</div>
				<div class="p1"><b>brown&proudsolidgroup@gmail.com</b></div>
				<div class="label-name1">Email Address</div>
				<div class="p2"><b>1958-11-30</b></div>
				<div class="label-name2">Birthdate</div>
			</div>
		</div>
	</div>
	</br>
	</br>
	<div class="container">
		<p class="p3"><b>Income Summary</b></p>
		<br>
=======
			</div>	
			<div class="name">Mr. Brown Lorem Ipsum</div>
			<div class="label-name">Name</div>
			<div class="email">brown&proudsolidgroup@gmail.com</div>
			<div class="lbl-email">Email Address</div>
			<div class="birthdate">1958-11-30</div>
			<div class="lbl-birthdate">Birthdate</div>
		</div>
	</div>
	<div class="container">
	<p class="income-salary">Income Summary</p>            
>>>>>>> origin/master
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
<<<<<<< HEAD
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
=======
					<td>
						<p>PHP 0.00</p>
						<p>PHP 20,500.00</p>
						<p>Date: 2017-06-28</p>
					</td>
					<td><p>Direct Referral Bonus</p>
						<p>Pairing Reward</p>
					</td>
					<td>
						<p>PHP 20,500.00</p>
						<p>PHP 36,000.00</p>
					</td>
					<td>
						<p>PHP 20,500.00</p>
						<p>PHP 56,500.00</p>
						<p>End Balance: PHP 56,500.00</p>
					</td>
				</tr>
				<tr>
					<td>
						<p>PHP 0.00</p>
						<p>PHP 20,500.00</p>
						<p>Date: 2017-06-28</p>
					</td>
					<td><p>Direct Referral Bonus</p>
						<p>Pairing Reward</p>
					</td>
					<td>
						<p>PHP 20,500.00</p>
						<p>PHP 36,000.00</p>
					</td>
					<td>
						<p>PHP 20,500.00</p>
						<p>PHP 56,500.00</p>
						<p>End Balance: PHP 56,500.00</p>
					</td>
				</tr>
				<tr>
					<td>
						<p>PHP 0.00</p>
						<p>PHP 20,500.00</p>
						<p>Date: 2017-06-28</p>
					</td>
					<td><p>Direct Referral Bonus</p>
						<p>Pairing Reward</p>
					</td>
					<td>
						<p>PHP 20,500.00</p>
						<p>PHP 36,000.00</p>
					</td>
					<td>
						<p>PHP 20,500.00</p>
						<p>PHP 56,500.00</p>
						<p>End Balance: PHP 56,500.00</p>
					</td>
				</tr>				
			</tbody>
		</table>
	</div>
>>>>>>> origin/master
</div>
@endsection
@section("member_script")
@endsection
@section("member_css")
<link rel="stylesheet" type="text/css" href="/themes/{{ $shop_theme }}/css/wallet_logs.css">
@endsection