@extends("member.member_layout")
@section("member_content")
<div class="notification-container">
	<div class="notification-header clearfix">
		<div class="left">
			<div class="icon">
				<img src="/themes/{{ $shop_theme }}/img/bell-big.png">
			</div>
			<div class="text">
				<div class="name">Notifications</div>
				<div class="sub">All income notification are shown here. </div>
			</div>
		</div>
		<div class="right">
			<div class="search">
				<input type="text" name="" class="form-control" placeholder="Search By Name or Slot #">
				<img src="/themes/{{ $shop_theme }}/img/search-icon.png">
			</div>
		</div>
	</div>
	<div class="notification-content">
		<div class="holder">
			<div class="member-info clearfix">
				<div class="left">
					<div class="pic">
						<img src="/themes/{{ $shop_theme }}/img/profile-nav.png">
					</div>
					<div class="text">
						<div class="name">Mr. Brown Lorem Ipsum</div>
						<div class="date">2017-09-01 03:20:47</div>
					</div>
				</div>
				<div class="right">
					<div class="read"><img src="/themes/{{ $shop_theme }}/img/read.png"></div>
				</div>
			</div>
			<div class="desc">Sorry, Your Slot has already reached the max level for matrix. Slot 111133's pairing reward will not be added. </div>
		</div>
		<div class="holder">
			<div class="member-info clearfix">
				<div class="left">
					<div class="pic">
						<img src="/themes/{{ $shop_theme }}/img/profile-nav.png">
					</div>
					<div class="text">
						<div class="name">Mr. Brown Lorem Ipsum</div>
						<div class="date">2017-09-01 03:20:47</div>
					</div>
				</div>
				<div class="right">
					<div class="read">
						<button class="btn btn-orange">Mark As Read</button>
					</div>
				</div>
			</div>
			<div class="desc">Sorry, Your Slot has already reached the max level for matrix. Slot 111133's pairing reward will not be added. </div>
		</div>
	</div>
</div>
@endsection
@section("member_script")
@endsection
@section("member_css")
<link rel="stylesheet" type="text/css" href="/themes/{{ $shop_theme }}/css/notification.css">
@endsection