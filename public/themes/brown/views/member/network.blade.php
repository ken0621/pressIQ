@extends("member.member_layout")
@section("member_content")
<div class="report-container">
	<div class="report-header clearfix">
		<div class="left">
			<div class="icon">
				<img src="/themes/{{ $shop_theme }}/img/report-icon.png">
			</div>
			<div class="text">
				<div class="name">Network List</div>
				<div class="sub">List of network on your <b>SOLID TREE</b></div>
			</div>
		</div>
		<div class="right">
			<div class="search">
				<select class="form-control">
					<option>MYPHONE0001</option>
				</select>
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