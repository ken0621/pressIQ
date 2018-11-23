@extends("layout")
@section("content")
<div class="main-container">

</div>
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
							<img class="img-upload" src="{{ $profile_image }}">
						</div>
						<div class="text">
							<div class="name">{{ $customer->first_name }} {{ $customer->last_name }}</div>
							<div class="sub" id="customer_rank">{{$customer->rank}}</div>
							<div class="sub hidden"><b>PHP 0.00</b></div>
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
						<li class="{{ Request::segment(2) == "codevault" ? "active" : "" }}">
							<a href="javascript:"><div class="nav-holder"><div class="icon fa fa-briefcase"></div> <span>Code Vault</span></div></a>
							<ul>
								<li>
									<a href="/members/codevault"><div class="nav-holder"> &nbsp;&nbsp;<span>Membership Codes</span></div></a>
								</li>
								@if($mlm_member)
								<li>
									<a href="/members/codevaultproducts"><div class="nav-holder"> &nbsp;&nbsp;<span>Product Code Vault</span></div></a>
								</li>
								@endif
							</ul>
							
						</li>
						@if($mlm_member)
						<li class="{{ Request::segment(2) == "genealogy" ? "active" : "" }}">
							<a href="javascript:"><div class="nav-holder"><div class="icon brown-icon-flow-tree"></div> <span>Genealogy</span></div></a>

							<ul>
								{{-- <li>
									<a href="/members/genealogy?mode=binary"><div class="nav-holder"> &nbsp;&nbsp;<span>Binary Tree</span></div></a>
								</li> --}}
								<li>
									<a href="/members/genealogy?mode=sponsor"><div class="nav-holder"> &nbsp;&nbsp;<span>Unilevel Tree</span></div></a>
								</li>
							</ul>
						</li>
						<li class="{{ Request::segment(2) == "report" ? "active" : "" }}">
							<a href="javascript:"><div class="nav-holder"><div class="icon brown-icon-bar-chart"></div> <span>Reports</span></div></a>
							<ul>
								{{-- <li>
									<a href="/members/genealogy?mode=binary"><div class="nav-holder"> &nbsp;&nbsp;<span>Binary Tree</span></div></a>
								</li> --}}
								<li>
									<a href="/members/report"><div class="nav-holder"> &nbsp;&nbsp;<span>Income Reports</span></div></a>
								</li>
								<li>
									<a href="/members/report-gc"><div class="nav-holder"> &nbsp;&nbsp;<span>GC Reports</span></div></a>
								</li>
							</ul>
						</li>
						<li class="{{ Request::segment(2) == "lead-list" ? "active" : "" }}">
							<a href="/members/lead-list"><div class="nav-holder"><div class="icon brown-icon-heart"></div> <span>Lead List</span></div></a>
						</li>
						<li class="{{ Request::segment(2) == "network" ? "active" : "" }}">
							<a href="/members/network"><div class="nav-holder"><div class="icon brown-icon-flow-tree"></div> <span>Network List</span></div></a>
						</li>
						<li class="{{ Request::segment(2) == "wallet-logs" || Request::segment(2) == "wallet-encashment" ? "active" : "" }}">
							<a href="javascript:"><div class="nav-holder"><div class="icon brown-icon-wallet"></div> <span>Wallet</span></div></a>
							<ul>
								<li>
									<a href="/members/wallet-encashment"><div class="nav-holder"> &nbsp;&nbsp;<span>Wallet Encashment</span></div></a>
								</li>
							</ul>
						</li>
						
						<li class="{{ Request::segment(2) == "order" ? "active" : "" }}">
							<a href="/members/order"><div class="nav-holder"><div class="icon fa fa-shopping-cart"></div> <span>My Orders</span></div></a>
						</li>
						@else
						@endif
					</ul>
				</div>
			</div>
			<div class="members-content">
				<div class="clearfix">
					@yield("member_content")
				</div>
			</div>
		</div>
	</div>
	<!-- SCROLL TO TOP -->
	<div class="scroll-up"><img src="/themes/{{ $shop_theme }}/img/scroll-up.png"></div>
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


