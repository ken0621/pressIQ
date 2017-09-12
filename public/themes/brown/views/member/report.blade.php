@extends("member.member_layout")
@section("member_content")
<div class="report-container">
	<div class="report-header clearfix">
		<div class="left">
			<div class="icon">
				<img src="/themes/{{ $shop_theme }}/img/report-icon.png">
			</div>
			<div class="text">
				<div class="name">Reports</div>
				<div class="sub">Matching</div>
			</div>
		</div>
		<div class="right">
			<div class="search">
				<input type="text" name="" class="form-control" placeholder="Search By Name or Slot #">
				<img src="/themes/{{ $shop_theme }}/img/search-icon.png">
			</div>
		</div>
	</div>
	<div class="report-content">
		<div class="holder">
			<div class="member-info clearfix">
				<div class="left">
					<div class="pic">
						<img src="/themes/{{ $shop_theme }}/img/profile-nav.png">
					</div>
					<div class="text">
						<div class="sponsor">Sponsor: Mr. Brown Lorem Ipsum</div>
						<div class="slot"><span>Slot:</span> 573887</div>
						<div class="report-notif"><span>Notification:</span> Congratulations you earned 500 from the pairing of 272842</div>
						<div class="level">Level 1</div>
					</div>
				</div>
				<div class="right">
					<div class="read">
						<span class="btn-orange badge">PHP 500</span>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
@section("member_script")
@endsection
@section("member_css")
<link rel="stylesheet" type="text/css" href="/themes/{{ $shop_theme }}/css/report.css">
@endsection