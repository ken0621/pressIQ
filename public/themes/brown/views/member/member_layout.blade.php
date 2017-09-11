@extends("layout")
@section("content")
<div class="member">
	<div class="container">
		<div class="members">
			<div class="header">
				<div class="notification">
					<img src="/themes/{{ $shop_theme }}/img/bell.png">
					<span class="badge">500</span>
				</div>
				<div class="profile-dropdown">
					<div class="img"><img src="/themes/{{ $shop_theme }}/img/thumb.png"></div>
					<div class="name">Mr. Brown <span class="slot">#272842</span> <i class="fa fa-angle-down" aria-hidden="true"></i></div>
				</div>
			</div>
			<div class="sidebar">
				<img class="shadow" src="/themes/{{ $shop_theme }}/img/shadow.png">
				<div class="profile">
					<div class="img">
						<img src="/themes/{{ $shop_theme }}/img/big-thumb.jpg">
					</div>
					<div class="text">
						<div class="name">Mr. Brown</div>
						<div class="sub">Sub head</div>
						<div class="sub">Subtitle Lorem Ipsum</div>
					</div>
				</div>
				<div class="side-nav">
					<ul>
						<li>
							<a href="javascript:"><div class="icon"><img src="/themes/{{ $shop_theme }}/img/icon-nav/dashboard.png"></div> Dashboard</a>
						</li>
						<li>
							<a href="javascript:"><div class="icon"><img src="/themes/{{ $shop_theme }}/img/icon-nav/profile.png"></div> Profile</a>
						</li>
						<li>
							<a href="javascript:"><div class="icon"><img src="/themes/{{ $shop_theme }}/img/icon-nav/notif.png"></div> Notification</a>
						</li>
						<li>
							<a href="javascript:"><div class="icon"><img src="/themes/{{ $shop_theme }}/img/icon-nav/repurchase.png"></div> Repurchase</a>
						</li>
						<li>
							<a href="javascript:"><div class="icon"><img src="/themes/{{ $shop_theme }}/img/icon-nav/genealogy.png"></div> Genealogy</a>
						</li>
						<li>
							<a href="javascript:"><div class="icon"><img src="/themes/{{ $shop_theme }}/img/icon-nav/report.png"></div> Reports</a>
						</li>
						<li>
							<a href="javascript:"><div class="icon"><img src="/themes/{{ $shop_theme }}/img/icon-nav/wallet.png"></div> Wallet</a>
						</li>
						<li>
							<a href="javascript:"><div class="icon"><img src="/themes/{{ $shop_theme }}/img/icon-nav/slots.png"></div> My Slots</a>
						</li>
						<li>
							<a href="javascript:"><div class="icon"><img src="/themes/{{ $shop_theme }}/img/icon-nav/eon-card.png"></div> Eon Card</a>
						</li>
						<li>
							<a href="javascript:"><div class="icon"><img src="/themes/{{ $shop_theme }}/img/icon-nav/order.png"></div> Orders</a>
						</li>
					</ul>
				</div>
			</div>
			<div class="members-content">
				@yield("member_content")
			</div>	
		</div>
	</div>
</div>
@endsection
@section("css")
@yield("member_css")
<link rel="stylesheet" type="text/css" href="/themes/{{ $shop_theme }}/css/member.css">
@endsection
@section("script")
@yield("member_script")
@endsection