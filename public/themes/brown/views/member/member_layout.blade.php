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
				<!-- <img class="shadow" src="/themes/{{ $shop_theme }}/img/shadow.png"> -->
				<div class="profile-holder">
					<div class="profile">
						<div class="img">
							<img src="{{ $profile_image }}">
						</div>
						<div class="text">
							<div class="name">{{ $customer->first_name }} {{ $customer->last_name }}</div>
							<div class="sub"><i>{{ $customer->email }}</i></div>
							<div class="sub"><b>PHP 0.00</b></div>
						</div>
					</div>
				</div>
				<div class="side-nav">
					<ul>
						<li class="{{ Request::segment(2) == "" ? "active" : "" }}">
							<a href="/members"><div class="nav-holder"><div class="icon brown-icon-dashboard"></div> <span>Dashboard</span></div></a>
						</li>
						<li class="{{ Request::segment(2) == "profile" ? "active" : "" }}">
							<a href="/members/profile"><div class="nav-holder"><div class="icon brown-icon-profile"></div> <span>Profile</span></div></a>
						</li>
						<li class="{{ Request::segment(2) == "notification" ? "active" : "" }}">
							<a href="javascript:"><div class="nav-holder"><div class="icon brown-icon-gift"></div> <span>Rewards</span></div></a>
							<ul>
								<li>
									<a href="/members/wallet-logs"><div class="icon brown-icon-list-alt nav-holder"> &nbsp;&nbsp; Matrix Reward</div></a>
								</li>
								<li>
									<a href="/members/wallet-encashment"><div class="icon brown-icon-money nav-holder"> &nbsp;&nbsp;Wallet Encashment</div></a>
								</li>
							</ul>
						</li>
						<li class="{{ Request::segment(2) == "genealogy" ? "active" : "" }}">
							<a href="/members/genealogy"><div class="nav-holder"><div class="icon brown-icon-flow-tree"></div> <span>Genealogy</span></div></a>
						</li>
						<li class="{{ Request::segment(2) == "report" ? "active" : "" }}">
							<a href="/members/report"><div class="nav-holder"><div class="icon brown-icon-bar-chart"></div> <span>Reward Reports</span></div></a>
						</li>
						<li class="{{ Request::segment(2) == "network" ? "active" : "" }}">
							<a href="/members/network"><div class="nav-holder"><div class="icon brown-icon-flow-tree"></div> <span>Network List</span></div></a>
						</li>
						<li class="{{ Request::segment(2) == "wallet-logs" || Request::segment(2) == "wallet-encashment" ? "active" : "" }}">
							<a href="javascript:"><div class="nav-holder"><div class="icon brown-icon-wallet"></div> <span>Wallet</span></div></a>
							<ul>
								<li>
									<a href="/members/wallet-logs"><div class="icon brown-icon-list-alt nav-holder"> &nbsp;&nbsp;Wallet Logs</div></a>
								</li>
								<li>
									<a href="/members/wallet-encashment"><div class="icon brown-icon-money nav-holder"> &nbsp;&nbsp;Wallet Encashment</div></a>
								</li>
							</ul>
						</li>
						<li class="{{ Request::segment(2) == "slot" ? "active" : "" }}">
							<a href="/members/slot"><div class="nav-holder"><div class="icon brown-icon-cubes"></div> <span>My Slots</span></div></a>
						</li>
<!-- 						<li class="{{ Request::segment(2) == "eon-card" ? "active" : "" }}">
							<a href="/members/eon-card"><div class="nav-holder"><dic class="icon brown-icon-credit-card"></dic> <span>Eon Card</span></div></a>
						</li>
						<li class="{{ Request::segment(2) == "order" ? "active" : "" }}">
							<a href="/members/order"><div class="nav-holder"><div class="icon brown-icon-bag"></div> <span>Orders</span></div></a>
						</li>
						<li class="{{ Request::segment(2) == "wishlist" ? "active" : "" }}">
							<a href="/members/wishlist"><div class="nav-holder"><div class="icon brown-icon-heart-empty"></div> <span>Wishlist</span></div></a>
						</li> -->
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