<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" href="/themes/brown_new_dashboard/assets/img/brown-ico.png" type="image/png"/>
	<title>Brown Dashboard</title>

	<!-- Google Fonts -->
	<link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Rubik:300,400,500,700" rel="stylesheet">

	<!-- Bootstrap 4 -->
	<!-- <link rel="stylesheet" href="/themes/brown_new_dashboard/assets/bootstrap4/dist/css/bootstrap.min.css"> -->

	<!-- New Font Awesome -->
	<script defer src="https://use.fontawesome.com/releases/v5.0.6/js/all.js"></script>
	<script defer src="/themes/brown_new_dashboard/assets/fontawesome5/svg-with-js/css/fa-svg-with-js.css"></script>
	<script defer src="/themes/brown_new_dashboard/assets/fontawesome5/svg-with-js/js/fontawesome-all.js"></script>

	<!--External css-->
	<link rel="stylesheet" href="/themes/brown_new_dashboard/assets/css/member_layout.css">
	<link rel="stylesheet" href="/themes/brown_new_dashboard/assets/css/style.css">

	<!--wow animation-->
	<link rel="stylesheet" href="/themes/brown_new_dashboard/assets/wow/css/animate.css">

	<!-- Slick -->
	<link rel="stylesheet" type="text/css" href="/themes/brown_new_dashboard/assets/slick-1.8.0/slick/slick.css"/>
	<link rel="stylesheet" type="text/css" href="/themes/brown_new_dashboard/assets/slick-1.8.0/slick/slick-theme.css"/>

	<!-- MDB -->
	<link rel="stylesheet" type="text/css" href="/themes/brown_new_dashboard/assets/mdb/css/bootstrap.css"/>
	<link rel="stylesheet" type="text/css" href="/themes/brown_new_dashboard/assets/mdb/css/bootstrap.min.css"/>
	<link rel="stylesheet" type="text/css" href="/themes/brown_new_dashboard/assets/mdb/css/mdb.css"/>
	<link rel="stylesheet" type="text/css" href="/themes/brown_new_dashboard/assets/mdb/css/mdb.min.css"/>
</head>
<body>
	<header>
		<div class="topnav">
			<div class="container d-flex justify-content-end">
				<div class="right d-flex align-items-center">
					<!-- <a class="decor-none" href="#">THE BAD PUPPY <i class=" ml-2 fas fa-angle-down"></i></a> -->
					<div class="profile-dropdown">
						<div class="dropdown">
							<a class="dropbtn" href="javascript:">
								{{-- <img src="" alt="" width="24" height="24" style="border-radius: 100%"> --}}
								<span class="name">John Doe</span>
								<i class=" ml-2 fas fa-angle-down"></i>
							</a>
							<div class="dropdown-content">
								<!-- <a href="/profile_settings">MY PROFILE</a>
								<a href="/logout">SIGNOUT</a> -->
								<div class="top d-flex p-3">
									<div class="profile-pic">
										<img src="/themes/brown_new_dashboard/assets/img/c01.jpg" alt="">
									</div>
									<div class="name-email ml-3">
										<div class="uname">John Doe</div>
										<div class="email">johnd@gmail.com</div>
									</div>
								</div>
								<div class="bottom p-3">
									<div class="button-holder d-flex justify-content-between">
										<button class="btn-profile">MY PROFILE</button>
										<button class="btn-signout">SIGN OUT</button>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="subnav">
			<div class="container">
				<div class="subnav-holder d-flex flex-wrap align-items-center">
					<div class="left d-flex flex-wrap align-items-center">
						<a class="decor-none" href="#"><img src="/themes/brown_new_dashboard/assets/img/logo.svg" alt=""></a>
						<a class="decor-none" href="#">MY ACCOUNT</a>
						<a class="decor-none" href="#">HOME</a>
						<a class="decor-none" href="#">ABOUT</a>
						<a class="decor-none" href="#">INSPIRERS</a>
					</div>
					<div class="right ml-auto">
						<div class="cart-holder">
							<a class="decor-none d-flex align-items-center" href="#">
								<img src="/themes/brown_new_dashboard/assets/img/cart.png" alt="">
								<span class="ml-2">(0)items</span>
							</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</header>

	<div class="member">
		<div class="members">
			<div class="header d-flex flex-wrap justify-content-between">
				<div class="current-wallet d-flex align-items-start p-2">
					<div class="icon"><img src="/themes/brown_new_dashboard/assets/img/current-wallet2.png" alt=""></div>
					<div class="value-holder ml-3">
						<div class="value">PHP 0.00</div>
						<div class="label">Current Wallet</div>
					</div>
				</div>
				<div class="ez-plan-balance d-flex align-items-start p-2">
					<div class="icon"><img src="/themes/brown_new_dashboard/assets/img/ez-plan-balance2.png" alt=""></div>
					<div class="value-holder ml-3">
						<div class="value">PHP 0.00</div>
						<div class="label mt-1">EZ Plan Balance</div>
					</div>
				</div>
				<div class="reminder-holder d-flex align-items-center justify-content-center">
				 	<div class="reminder"><span class="bold-1">A friendly Reminder: </span> You won't be receiving your payout until you setup your <span class="bold-2">payout details. <a class="bold-2" href="#"><u>Click here to set it up right away.</u></a></span>
				 	</div>
				 </div>
			</div>
			<div class="stay-aside">
				<div class="sidebar small">
					<div class="side-nav">
						<ul>
							<li>
								<a href="javascript:">
									<div class="nav-holder">
										<div class="menu d-flex align-items-center justify-content-start">
											<div class="image d-flex align-items-center">
												<img src="/themes/brown_new_dashboard/assets/img/menu.png" alt="">
											</div>
											<div class="label ml-1">
												Menu
											</div>
										</div>
									</div>
								</a>
							</li>

							<li>
								<a href="javascript:">
									<div class="nav-holder">
										<div class="profile d-flex align-items-center justify-content-start">
											<div class="image-profile">
												<img src="/themes/brown_new_dashboard/assets/img/c01.jpg" alt="">
											</div>
											<div class="label ml-4">
												<div class="name">John Doe</div>
												<div class="email">johnd@email.com</div>
											</div>
										</div>
									</div>
								</a>
							</li>

							<li class="active">
								<a href="">
									<div class="nav-holder">
										<!-- <div class="hover-with-border-left"></div> -->
										<div class="icon">
											<img src="/themes/brown_new_dashboard/assets/img/dashboard.png" alt="">
										</div>
										<span>Dashboard</span>
									</div>
								</a>
							</li>

							<li class="">
								<a href="">
									<div class="nav-holder">
										<!-- <div class="hover-with-border-left"></div> -->
										<div class="icon">
											<img src="/themes/brown_new_dashboard/assets/img/membership.png" alt="">
										</div>
										<span>Membership <i class="fas fa-angle-right" style="margin-left: 114px;"></i></span>
									</div>
								</a>

								<ul>
									<li>
										<a href=""><div class="nav-holder"> &nbsp;&nbsp;&nbsp;&nbsp;Profile Settings</div></a>
									</li>
									<li>
										<a href=""><div class="nav-holder"> &nbsp;&nbsp;&nbsp;&nbsp;Payout Settings</div></a>
									</li>
									<li>
										<a href=""><div class="nav-holder"> &nbsp;&nbsp;&nbsp;&nbsp;My Genealogy <i class="fas fa-angle-right" style="margin-left: 150px;"></i></div></a>
										<ul>
											<li>
												<a href=""><div class="nav-holder"> &nbsp;&nbsp;&nbsp;&nbsp;Brown Tree</div></a>
											</li>
											<li>
												<a href=""><div class="nav-holder"> &nbsp;&nbsp;&nbsp;&nbsp;Solid Tree</div></a>
											</li>
										</ul>
									</li>
									<li>
										<a href=""><div class="nav-holder"> &nbsp;&nbsp;&nbsp;&nbsp;Network List</div></a>
									</li>
									<li>
										<a href=""><div class="nav-holder"> &nbsp;&nbsp;&nbsp;&nbsp;Leads</div></a>
									</li>
								</ul>
							</li>

							<li class="">
								<a href="">
									<div class="nav-holder">
										<!-- <div class="hover-with-border-left"></div> -->
										<div class="icon">
											<img src="/themes/brown_new_dashboard/assets/img/general-transactions.png" alt="">
										</div>
										<span>General Transactions <i class="fas fa-angle-right" style="margin-left: 60px;"></i></span>
									</div>
								</a>
								<ul>
									<li>
										<a href=""><div class="nav-holder"> &nbsp;&nbsp;&nbsp;&nbsp;Repurchase Kit</div></a>
									</li>
									<li>
										<a href=""><div class="nav-holder"> &nbsp;&nbsp;&nbsp;&nbsp;Create New Slot</div></a>
									</li>
								</ul>
							</li>

							<li class="">
								<a href="">
									<div class="nav-holder">
										<!-- <div class="hover-with-border-left"></div> -->
										<div class="icon">
											<img src="/themes/brown_new_dashboard/assets/img/reports.png" alt="">
										</div>
										<span>Reports <i class="fas fa-angle-right" style="margin-left: 142px;"></i></span>
									</div>
								</a>
								<ul>
									<li>
										<a href=""><div class="nav-holder"> &nbsp;&nbsp;&nbsp;&nbsp;Wallet Encashment</div></a>
									</li>
									<li>
										<a href=""><div class="nav-holder"> &nbsp;&nbsp;&nbsp;&nbsp;My Orders</div></a>
									</li>
									<li>
										<a href=""><div class="nav-holder"> &nbsp;&nbsp;&nbsp;&nbsp;My Notifications</div></a>
									</li>
								</ul>
							</li>

							<!-- <li class="">
								<a href="">
									<div class="nav-holder">
										<div class="hover-with-border-left"></div>
										<div class="icon">
											<img src="/themes/brown_new_dashboard/assets/img/repurchase-kit.png" alt="">
										</div>
										<span>Repurchase Kit</span>
									</div>
								</a>
							</li> -->
						</ul>
					</div>
				</div>
			</div>
			<div class="members-content">
				<div class="row clearfix">
					<div class="col-md-8">
						<div class="row clearfix">
							<div class="col-md-6">
								<div class="section-holder reward-summary">
									<div class="top-section-header d-flex align-items-center">
										<div class="icon d-flex align-items-center">
											<img src="/themes/brown_new_dashboard/assets/img/reward-summary.png" alt="">
										</div>
										<div class="section-title ml-2">Reward Summary</div>
									</div>
									<div class="bottom-section-content">
										<div class="rewards">
											<div class="bullet d-flex align-items-center">
												<div class="square dec"></div>
												<div class="left ml-3">Direct Enrollment Commission</div>
												<div class="right ml-auto">PHP 0.00</div>
											</div>
											<div class="bullet d-flex align-items-center">
												<div class="square epb"></div>
												<div class="left ml-3">EZ Plan Bonus</div>
												<div class="right ml-auto">PHP 0.00</div>
											</div>
											<div class="bullet d-flex align-items-center">
												<div class="square mb"></div>
												<div class="left ml-3">Matching Bonus</div>
												<div class="right ml-auto">PHP 0.00</div>
											</div>
											<div class="bullet d-flex align-items-center">
												<div class="square br"></div>
												<div class="left ml-3">Builder Reward</div>
												<div class="right ml-auto">PHP 0.00</div>
											</div>
											<div class="bullet d-flex align-items-center">
												<div class="square lr"></div>
												<div class="left ml-3">Leader Reward</div>
												<div class="right ml-auto">PHP 0.00</div>
											</div>
											<div class="bullet d-flex align-items-center">
												<div class="square tp"></div>
												<div class="left ml-3">Total Payout</div>
												<div class="right ml-auto">PHP 0.00</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="col-md-6">
								<div class="section-holder earning-deducted">
									<div class="top-section-header d-flex align-items-center">
										<div class="icon d-flex align-items-center">
											<img src="/themes/brown_new_dashboard/assets/img/ez-plan.png" alt="">
										</div>
										<div class="section-title ml-2">Earnings Deducted</div>
									</div>

									<div class="bottom-section-content">
										<div class="balance">
											<div class="bullet d-flex align-items-center">
												<div class="square ezebd"></div>
												<div class="left ml-3">EZ Enrollment Bonus Deducted</div>
												<div class="right ml-auto">PHP 0.00</div>
											</div>
											<div class="bullet d-flex align-items-center">
												<div class="square mbd"></div>
												<div class="left ml-3">Matching Bonus Deducted</div>
												<div class="right ml-auto">PHP 0.00</div>
											</div>
										</div>
									</div>
								</div>
								{{-- <div class="section-holder reward-points mt-3">
									<div class="top-section-header d-flex align-items-center">
										<div class="icon d-flex align-items-center">
											<img src="/themes/brown_new_dashboard/assets/img/reward-pts.png" alt="">
										</div>
										<div class="section-title ml-2">Reward Points</div>
									</div>
									<div class="bottom-section-content">
										<div class="points">
											<div class="bullet d-flex align-items-center">
												<div class="square bp"></div>
												<div class="left ml-3">Builder Points</div>
												<div class="right ml-auto">0.00 PTS</div>
											</div>
											<div class="bullet d-flex align-items-center">
												<div class="square lp"></div>
												<div class="left ml-3">Leader Points</div>
												<div class="right ml-auto">0.00 PTS</div>
											</div>
										</div>
									</div>
								</div> --}}
							</div>
						</div>
						<div class="row clearfix">
							<div class="col-md-12">
								<div class="section-holder my-slots mt-3">
									<div class="top-section-header d-flex align-items-center">
										<div class="icon d-flex align-items-center">
											<img src="/themes/brown_new_dashboard/assets/img/my-slots.png" alt="">
										</div>
										<div class="section-title ml-2">My Slots</div>
									</div>
									<div class="bottom-section-content">
										<div class="slot-holder d-flex flex-wrap align-items-center">
											<div class="left d-flex align-items-center p-3">
												<div class="replicated-link">
													<div class="label-bld">JDB0123</div>
													<div class="btn-holder">
														<button class="btn-cust-brown"><img src="/themes/brown_new_dashboard/assets/img/replicated.png" alt=""> Replicated Link</button>
													</div>
												</div>
												<div class="slot-wallet">
													<div class="label-reg">SLOT WALLET</div>
													<div class="value">PHP 2,500.00</div>
												</div>
											</div>
											<div class="right d-flex flex-column p-3">
												<div class="top d-flex align-items-center justify-content-center">
													<div class="label">ROAD TO BUILDER</div>
												</div>
												<div class="bottom d-flex align-items-center justify-content-between">
													<div class="direct text-center m-1">
														<span>DIRECT 0/2</span>
														{{-- <div class="gauge-1"></div> --}}
													</div>
													<div class="group text-center m-1">
														{{-- <div class="gauge-2"></div> --}}
														<span>GROUP 0/12</span>
													</div>
												</div>
											</div>
										</div>
										<div class="slot-holder d-flex flex-wrap align-items-center">
											<div class="left d-flex align-items-center p-3">
												<div class="replicated-link">
													<div class="label-bld">JDB4567</div>
													<div class="btn-holder">
														<button class="btn-cust-brown"><img src="/themes/brown_new_dashboard/assets/img/replicated.png" alt=""> Replicated Link</button>
													</div>
												</div>
												<div class="slot-wallet">
													<div class="label-reg">SLOT WALLET</div>
													<div class="value">PHP 2,500.00</div>
												</div>
											</div>
											<div class="right d-flex flex-column p-3">
												<div class="top d-flex align-items-center justify-content-center">
													<div class="label">ROAD TO BUILDER</div>
												</div>
												<div class="bottom d-flex align-items-center justify-content-between">
													<div class="direct text-center m-1">
														<!-- <div class="gauge"></div> -->
														<span>DIRECT 0/2</span>
													</div>
													<div class="group text-center m-1">
														{{-- <div class="gauge-3"></div> --}}
														<span>GROUP 0/12</span>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="row clearfix">
							<div class="col-md-6">
								<div class="section-holder newest-enrollees mt-3">
									<div class="top-section-header d-flex align-items-center">
										<div class="icon d-flex align-items-center">
											<img src="/themes/brown_new_dashboard/assets/img/enrollees.png" alt="">
										</div>
										<div class="section-title ml-2">Newest Enrollees</div>
									</div>
									<div class="bottom-section-content">

										<div class="ticket d-flex align-items-center text-center">
											<div class="ticket-title mr-auto">NAME/SLOT</div>
											<div class="ticket-title mx-auto pl-4">ENROLLER</div>
											<div class="ticket-title ml-auto">DETAILS</div>
										</div>
										
										<div class="enrollees-holder d-flex flex-column">
											<div class="left-right-holder d-flex align-items-center justify-content-between pt-3">
												<div class="left d-flex align-items-center">
													<div class="profile-pic d-flex align-items-start">
														<img src="/themes/brown_new_dashboard/assets/img/c02.jpg" alt="">
													</div>
													<div class="name-and-hour d-flex flex-column align-items-start ml-2">
														<div class="name">Drew Duncan</div>
														<div class="slot">DDB0123</div>
													</div>
												</div>
												<div class="right">
													<div class="uname-and-view d-flex align-items-center justify-content-between">
														<div class="uname">
															JDB0123
														</div>
														<div class="view">
															<button class="btn-cust-brown d-flex align-items-center"><img src="/themes/brown_new_dashboard/assets/img/view.png" alt=""> <span class="ml-2">View</span></button>
														</div>
													</div>
												</div>
											</div>
											<div class="date-time ml-auto">
												<span>3-15-18 4:30PM</span>
											</div>
										</div>
										<div class="enrollees-holder d-flex flex-column">
											<div class="left-right-holder d-flex align-items-center justify-content-between pt-3">
												<div class="left d-flex align-items-center">
													<div class="profile-pic d-flex align-items-start">
														<img src="/themes/brown_new_dashboard/assets/img/c03.jpg" alt="">
													</div>
													<div class="name-and-hour d-flex flex-column align-items-start ml-2">
														<div class="name">Austin Hicks</div>
														<div class="slot">AHB0124</div>
													</div>
												</div>
												<div class="right">
													<div class="uname-and-view d-flex align-items-center justify-content-between">
														<div class="uname">
															JDB0123
														</div>
														<div class="view">
															<button class="btn-cust-brown d-flex align-items-center"><img src="/themes/brown_new_dashboard/assets/img/view.png" alt=""> <span class="ml-2">View</span></button>
														</div>
													</div>
												</div>
											</div>
											<div class="date-time ml-auto">
												<span>3-14-18 5:35PM</span>
											</div>
										</div>
										<div class="enrollees-holder d-flex flex-column">
											<div class="left-right-holder d-flex align-items-center justify-content-between pt-3">
												<div class="left d-flex align-items-center">
													<div class="profile-pic d-flex align-items-start">
														<img src="/themes/brown_new_dashboard/assets/img/c04.jpg" alt="">
													</div>
													<div class="name-and-hour d-flex flex-column align-items-start ml-2">
														<div class="name">Bobby Halley</div>
														<div class="slot">BHB0125</div>
													</div>
												</div>
												<div class="right">
													<div class="uname-and-view d-flex align-items-center justify-content-between">
														<div class="uname">
															JDB4567
														</div>
														<div class="view">
															<button class="btn-cust-brown d-flex align-items-center"><img src="/themes/brown_new_dashboard/assets/img/view.png" alt=""> <span class="ml-2">View</span></button>
														</div>
													</div>
												</div>
											</div>
											<div class="date-time ml-auto">
												<span>3-12-18 1:30PM</span>
											</div>
										</div>
										<div class="enrollees-holder d-flex flex-column">
											<div class="left-right-holder d-flex align-items-center justify-content-between pt-3">
												<div class="left d-flex align-items-center">
													<div class="profile-pic d-flex align-items-start">
														<img src="/themes/brown_new_dashboard/assets/img/c05.jpg" alt="">
													</div>
													<div class="name-and-hour d-flex flex-column align-items-start ml-2">
														<div class="name">Abbey Clark</div>
														<div class="slot">ACB0126</div>
													</div>
												</div>
												<div class="right">
													<div class="uname-and-view d-flex align-items-center justify-content-between">
														<div class="uname">
															JDB0123
														</div>
														<div class="view">
															<button class="btn-cust-brown d-flex align-items-center"><img src="/themes/brown_new_dashboard/assets/img/view.png" alt=""> <span class="ml-2">View</span></button>
														</div>
													</div>
												</div>
											</div>
											<div class="date-time ml-auto">
												<span>3-11-18 5:23PM</span>
											</div>
										</div>
										<div class="enrollees-holder d-flex flex-column">
											<div class="left-right-holder d-flex align-items-center justify-content-between pt-3">
												<div class="left d-flex align-items-center">
													<div class="profile-pic d-flex align-items-start">
														<img src="/themes/brown_new_dashboard/assets/img/c06.jpg" alt="">
													</div>
													<div class="name-and-hour d-flex flex-column align-items-start ml-2">
														<div class="name">Cami Gosse</div>
														<div class="slot">CGB0127</div>
													</div>
												</div>
												<div class="right">
													<div class="uname-and-view d-flex align-items-center justify-content-between">
														<div class="uname">
															JDB4567
														</div>
														<div class="view">
															<button class="btn-cust-brown d-flex align-items-center"><img src="/themes/brown_new_dashboard/assets/img/view.png" alt=""> <span class="ml-2">View</span></button>
														</div>
													</div>
												</div>
											</div>
											<div class="date-time ml-auto">
												<span>3-10-18 3:45PM</span>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="col-md-6">
								<div class="section-holder recent-rewards mt-3">
									<div class="top-section-header d-flex align-items-center">
										<div class="left d-flex align-items-center">
											<div class="icon d-flex align-items-center">
												<img src="/themes/brown_new_dashboard/assets/img/rewards.png" alt="">
											</div>
											<div class="section-title ml-2">Recent Rewards</div>
										</div>
										<div class="right ml-auto">
											<button class="btn-cust-brown-success">SEE ALL</button>
										</div>
									</div>
									<div class="bottom-section-content">
										<div class="rewards-holder d-flex py-3">
											<div class="bullet">
												<div class="square gr"></div>
											</div>
											<div class="earned ml-3">
												<div class="top"><b>You earned PHP 500.00</b> from <b>direct referral bonus</b> because of <b>DDB0123(Drew Duncan)</b>.</div>
												<div class="bottom d-flex align-items-center">
													<div class="date-hours">3-15-18 3:15PM</div>
													<div class="earned-by ml-auto">EARNED BY JDB4567</div>
												</div>
											</div>
										</div>
										<div class="rewards-holder d-flex py-3">
											<div class="bullet">
												<div class="square gr"></div>
											</div>
											<div class="earned ml-3">
												<div class="top"><b>You earned PHP 500.00</b> from <b>direct referral bonus</b> because of <b>AHB0124(Austin Hicks)</b>.</div>
												<div class="bottom d-flex align-items-center">
													<div class="date-hours">3-14-18 4:16PM</div>
													<div class="earned-by ml-auto">EARNED BY JDB0123</div>
												</div>
											</div>
										</div>
										<div class="rewards-holder d-flex py-3">
											<div class="bullet">
												<div class="square gr"></div>
											</div>
											<div class="earned ml-3">
												<div class="top"><b>You earned PHP 500.00</b> from <b>direct referral bonus</b> because of <b>BHB0125(Bobby Halley)</b>.</div>
												<div class="bottom d-flex align-items-center">
													<div class="date-hours">3-13-18 2:45PM</div>
													<div class="earned-by ml-auto">EARNED BY JDB0123</div>
												</div>
											</div>
										</div>
										<div class="rewards-holder d-flex py-3">
											<div class="bullet">
												<div class="square gr"></div>
											</div>
											<div class="earned ml-3">
												<div class="top"><b>You earned PHP 500.00</b> from <b>direct referral bonus</b> because of <b>ACB0126(Abbey Clark)</b>.</div>
												<div class="bottom d-flex align-items-center">
													<div class="date-hours">3-12-18 1:54PM</div>
													<div class="earned-by ml-auto">EARNED BY JDB04567</div>
												</div>
											</div>
										</div>
										<div class="rewards-holder d-flex py-3">
											<div class="bullet">
												<div class="square gr"></div>
											</div>
											<div class="earned ml-3">
												<div class="top"><b>You earned PHP 500.00</b> from <b>direct referral bonus</b> because of <b>CGB0127(Cami Gosse)</b>.</div>
												<div class="bottom d-flex align-items-center">
													<div class="date-hours">3-11-18 2:38PM</div>
													<div class="earned-by ml-auto">EARNED BY JDB0123</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-4">
						<section class="ads-and-events">
							<div class="ads-carousel">
								<img src="https://brown.com.ph/uploads/myphone-5/oS7fRo32jZTcKftkAq7i07EnoVH5IDTcKVjMXMBp.jpeg" alt="">
						  		<img src="https://brown.com.ph/uploads/myphone-5/L7BlVBNf6NspnO6ih3wNah5FbNUrNIaIQ7CsQeRl.jpeg" alt="">
						  		<img src="https://brown.com.ph/uploads/myphone-5/PuSMVMg8PukSD3pVrRY7LwKmGtgqvuCftsfTdHAW.jpeg" alt="">	
							</div>
							<div class="section-holder upcoming-events">
								<div class="top-section-header d-flex align-items-center">
									<div class="icon d-flex align-items-center">
										<img src="/themes/brown_new_dashboard/assets/img/events.png" alt="">
									</div>
									<div class="section-title ml-2">Upcoming Events</div>
								</div>
								<div class="bottom-section-content" style="overflow-y: auto; overflow-x: hidden; max-height: 280px;">
								<!-- <div class="bottom-section-content scrollbar scrollbar-default force-overflow"> -->
									<div class="event-holder d-flex mt-2">
										<div class="left">
											<div class="view">
											    <img src="/themes/brown_new_dashboard/assets/img/event-1.png" class="img-fluid " alt="">
											    <div class="mask flex-center rgba-black-strong">
											        <!-- <p class="white-text">Strong overlay</p> -->
											        <div class="date-month text-center">
										        		<div class="date white-text">17</div>
										        		<div class="month white-text">March</div>
											        </div>
											    </div>
											</div>
										</div>
										<div class="right d-flex flex-column ml-3">
											<div class="top ml-2">
												<div class="title">MCE MARCH</div>
												<div class="description">Masterclass in creative Entrepreneurship</div>
											</div>
											<div class="bottom d-flex flex-wrap align-items-center">
												<div class="m-2">
													<button class="btn-cust-brown w-100">Details</button>
												</div>
												<div class="m-2">
													<button class="btn-cust-brown w-100">Reserve a Seat</button>
												</div>
											</div>
										</div>
									</div>
									<div class="event-holder d-flex mt-2">
										<div class="left">
											<div class="view">
											    <img src="/themes/brown_new_dashboard/assets/img/event-1.png" class="img-fluid " alt="">
											    <div class="mask flex-center rgba-black-strong">
											        <!-- <p class="white-text">Strong overlay</p> -->
											        <div class="date-month text-center">
										        		<div class="date white-text">26</div>
										        		<div class="month white-text">APRIL</div>
											        </div>
											    </div>
											</div>
										</div>
										<div class="right d-flex flex-column ml-3">
											<div class="top ml-2">
												<div class="title">MCE APRIL</div>
												<div class="description">Masterclass in creative Entrepreneurship</div>
											</div>
											<div class="bottom d-flex flex-wrap align-items-center">
												<div class="m-2">
													<button class="btn-cust-brown w-100">Details</button>
												</div>
												<div class="m-2">
													<button class="btn-cust-brown w-100">Reserve a Seat</button>
												</div>
											</div>
										</div>
									</div>
									<div class="event-holder d-flex mt-2">
										<div class="left">
											<div class="view">
											    <img src="/themes/brown_new_dashboard/assets/img/event-1.png" class="img-fluid " alt="">
											    <div class="mask flex-center rgba-black-strong">
											        <!-- <p class="white-text">Strong overlay</p> -->
											        <div class="date-month text-center">
										        		<div class="date white-text">16</div>
										        		<div class="month white-text">MAY</div>
											        </div>
											    </div>
											</div>
										</div>
										<div class="right d-flex flex-column ml-3">
											<div class="top ml-2">
												<div class="title">MCE MAY</div>
												<div class="description">Masterclass in creative Entrepreneurship</div>
											</div>
											<div class="bottom d-flex flex-wrap align-items-center">
												<div class="m-2">
													<button class="btn-cust-brown w-100">Details</button>
												</div>
												<div class="m-2">
													<button class="btn-cust-brown w-100">Reserve a Seat</button>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</section>
					</div>
				</div>
			</div>
		</div>
	</div>

	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
	<script src="/themes/brown_new_dashboard/assets/bootstrap4/dist/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="/themes/brown_new_dashboard/assets/slick-1.8.0/slick/slick.min.js"></script>

	<!-- Include all compiled plugins (below), or include individual files as needed -->
	<script type="text/javascript" src="/themes/brown_new_dashboard/assets/js/match-height.js"></script>
	<script type="text/javascript" src="/themes/brown_new_dashboard/assets/js/member_layout.js"></script>
	<script type="text/javascript" src="/themes/brown_new_dashboard/assets/scrolltofix/jquery-scrolltofixed.js"></script>
	<script type="text/javascript" src="/themes/brown_new_dashboard/assets/scrolltofix/jquery-scrolltofixed-min.js"></script>
	<script type="text/javascript" src="/themes/brown_new_dashboard/assets/mdb/js/mdb.js"></script>
	<script type="text/javascript" src="/themes/brown_new_dashboard/assets/mdb/js/mdb.min.js"></script>
	<!-- <script type="text/javascript" src="/themes/brown_new_dashboard/assets/js/globals_js.js"></script> -->
	<!-- <script src="//themes/brown_new_dashboard/assets/js/popup.js"></script> -->

	<!--START WOW JS-->
	<script src="/themes/brown_new_dashboard/assets/wow/js/wow.min.js"></script>

	<script>
	new WOW().init();
	</script>
	<!--END WOW JS-->

	<script type="text/javascript">

	  $(document).ready(function(){
	  	$('.stay-aside').scrollToFixed();
	  	$('.ads-and-events').scrollToFixed();

	    $('.ads-carousel').slick({
	      dots: true,
	      infinite: true,
	      speed: 300,
	      autoplay: true,
	      arrows: true,
	      prevArrow:"<img style='width: 30px; height: 30px;' class='a-left control-c prev slick-prev' src='/themes/brown_new_dashboard/assets/img/arrow-left.png'>",
	      nextArrow:"<img style='width: 30px; height: 30px;' class='a-right control-c next slick-next' src='/themes/brown_new_dashboard/assets/img/arrow-right.png'>",
	      slidesToScroll: 1,
	      responsive: [
	        {
	          breakpoint: 1024,
	          settings: {
	            slidesToShow: 1,
	            slidesToScroll: 1,
	            infinite: true,
	            dots: true
	          }
	        },
	        {
	          breakpoint: 600,
	          settings: {
	            slidesToShow: 1,
	            slidesToScroll: 1
	          }
	        },
	        {
	          breakpoint: 480,
	          settings: {
	            slidesToShow: 1,
	            slidesToScroll: 1
	          }
	        }
	        // You can unslick at a given breakpoint now by adding:
	        // settings: "unslick"
	        // instead of a settings object
	      ]
	    });

	  });
	</script>

</body>
</html>