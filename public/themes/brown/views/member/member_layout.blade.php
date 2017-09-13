@extends("layout")
@section("content")
<div class="member">
	<div class="container">
		<div class="members">
			<div class="header hidden">
				
				<div class="notification">
					<img src="/themes/{{ $shop_theme }}/img/bell.png">
					<span class="badge">500</span>
				</div>
				<div class="profile-dropdown">
					<div class="name">Slot <span class="slot">#272842</span> <i class="fa fa-angle-down" aria-hidden="true"></i></div>
				</div>
			</div>
			<div class="sidebar small">
				<img class="shadow" src="/themes/{{ $shop_theme }}/img/shadow.png">
				<div class="profile-holder">
					<div class="profile">
						<div class="img">
							<img src="/themes/{{ $shop_theme }}/img/big-thumb.jpg">
						</div>
						<div class="text">
							<div class="name">{{ $customer->first_name }} {{ $customer->last_name }}</div>
							<div class="sub">{{ $customer->customer_id }}</div>
							<div class="sub">Subtitle Lorem Ipsum</div>
						</div>
					</div>
				</div>
				<div class="side-nav">
					<ul>
						<li class="{{ Request::segment(2) == "" ? "active" : "" }}">
							<a href="/members"><div class="nav-holder"><div class="icon"><img src="/themes/{{ $shop_theme }}/img/icon-nav/dashboard.png"></div> <span>Dashboard</span></div></a>
						</li>
						<li class="{{ Request::segment(2) == "profile" ? "active" : "" }}">
							<a href="/members/profile"><div class="nav-holder"><div class="icon"><img src="/themes/{{ $shop_theme }}/img/icon-nav/profile.png"></div> <span>Profile</span></div></a>
						</li>
						<li class="{{ Request::segment(2) == "notification" ? "active" : "" }}">
							<a href="/members/notification"><div class="nav-holder"><div class="icon"><img src="/themes/{{ $shop_theme }}/img/icon-nav/notif.png"></div> <span>Notification</span></div></a>
						</li>
						<li class="{{ Request::segment(2) == "genealogy" ? "active" : "" }}">
							<a href="/members/genealogy"><div class="nav-holder"><div class="icon"><img src="/themes/{{ $shop_theme }}/img/icon-nav/genealogy.png"></div> <span>Genealogy</span></div></a>
						</li>
						<li class="{{ Request::segment(2) == "report" ? "active" : "" }}">
							<a href="/members/report"><div class="nav-holder"><div class="icon"><img src="/themes/{{ $shop_theme }}/img/icon-nav/report.png"></div> <span>Reports</span></div></a>
						</li>
						<li class="{{ Request::segment(2) == "wallet" ? "active" : "" }}">
							<a href="javascript:"><div class="nav-holder"><div class="icon"><img src="/themes/{{ $shop_theme }}/img/icon-nav/wallet.png"></div> <span>Wallet</span></div></a>
							<ul>
								<li>
									<a href="/members/wallet-logs"><div class="nav-holder">Wallet Logs</div></a>
								</li>
								<li>
									<a href="/members/wallet-encashment"><div class="nav-holder">Wallet Encashment</div></a>
								</li>
							</ul>
						</li>
						<li class="{{ Request::segment(2) == "slots" ? "active" : "" }}">
							<a href="javascript:"><div class="nav-holder"><div class="icon"><img src="/themes/{{ $shop_theme }}/img/icon-nav/slots.png"></div> <span>My Slots</span></div></a>
						</li>
						<li class="{{ Request::segment(2) == "eoncard" ? "active" : "" }}">
							<a href="javascript:"><div class="nav-holder"><div class="icon"><img src="/themes/{{ $shop_theme }}/img/icon-nav/eon-card.png"></div> <span>Eon Card</span></div></a>
						</li>
						<li class="{{ Request::segment(2) == "order" ? "active" : "" }}">
							<a href="javascript:"><div class="nav-holder"><div class="icon"><img src="/themes/{{ $shop_theme }}/img/icon-nav/order.png"></div> <span>Orders</span></div></a>
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
<script type="text/javascript" src="/themes/{{ $shop_theme }}/js/member.js"></script>
@endsection