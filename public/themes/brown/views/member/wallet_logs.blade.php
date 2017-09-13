@extends("member.member_layout")
@section("member_content")
<div class="wallet-logs">
	<div class="main-member-header clearfix">
		<div class="left">
			<div class="icon">
				<img src="/themes/{{ $shop_theme }}/img/wallet-encashment.png">
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
			<div class="name">Mr. Brown Lorem Ipsum</div>
			<div class="label-name">Name</div>
		</div>
	</div>
</div>
@endsection
@section("member_script")
@endsection
@section("member_css")
<link rel="stylesheet" type="text/css" href="/themes/{{ $shop_theme }}/css/wallet_logs.css">
@endsection